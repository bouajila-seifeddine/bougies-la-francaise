<?php
/**
 * Copyright 2015 Lengow SAS.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 *  @author    Team Connector <team-connector@lengow.com>
 *  @copyright 2015 Lengow SAS
 *  @license   http://www.apache.org/licenses/LICENSE-2.0
 */

$sep = DIRECTORY_SEPARATOR;
require_once dirname(__FILE__).$sep.'..'.$sep.'..'.$sep.'loader.php';
try
{
	loadFile('core');
} catch(Exception $e)
{
	echo date('Y-m-d : H:i:s ').$e->getMessage().'<br />';
}
/**
 * The Lengow's Admin Controller.
 *
 * @author Team Connector <team-connector@lengow.com>
 * @copyright 2015 Lengow SAS
 */
class AdminLengowController extends ModuleAdminController
{
	protected $id_current_category;

	/**
	* Construct the admin selection of products
	*/
	public function __construct()
	{
		$this->table 		  = 'product';
		$this->className 	  = 'LengowProduct';
		$this->lang		   = true;
		$this->explicitSelect = true;
		$this->list_no_link   = true;
		$this->actions = array('lengowpublish', 'lengowunpublish');
		if (_PS_VERSION_ >= '1.6')
			$this->bootstrap = true;

		require_once LengowCore::getLengowFolder().DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'lengow.product.class.php';

		parent::__construct();

		$this->imageType = 'jpg';

		if (Tools::getValue('reset_filter_category'))
			$this->context->cookie->id_category_products_filter = false;
		if (Shop::isFeatureActive() && $this->context->cookie->id_category_products_filter)
		{
			$category = new Category((int)$this->context->cookie->id_category_products_filter);
			if (!$category->inShop())
			{
				$this->context->cookie->id_category_products_filter = false;
				Tools::redirectAdmin($this->context->link->getAdminLink('AdminProducts'));
			}
		}
		/* Join categories table */
		if ($id_category = (int)Tools::getValue('productFilter_cl!name'))
		{
			$this->_category = new Category((int)$id_category);
			$_POST['productFilter_cl!name'] = $this->_category->name[$this->context->language->id];
		}
		else
		{
			if ($id_category = (int)Tools::getValue('id_category'))
			{
				$this->id_current_category = $id_category;
				$this->context->cookie->id_category_products_filter = $id_category;
			}
			elseif ($id_category = $this->context->cookie->id_category_products_filter)
				$this->id_current_category = $id_category;
			if ($this->id_current_category)
				$this->_category = new Category((int)$this->id_current_category);
			else
				$this->_category = new Category();
		}

		$join_category = false;
		if (Validate::isLoadedObject($this->_category) && empty($this->_filter))
			$join_category = true;

		$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = a.`id_product` '.(!Shop::isFeatureActive() ? ' AND i.cover=1' : '').')
		LEFT JOIN `'._DB_PREFIX_.'lengow_product` lp ON lp.`id_product` = a.`id_product` ';

		if (Shop::isFeatureActive())
		{
			$alias = 'sa';
			$alias_image = 'image_shop';
			if (Shop::getContext() == Shop::CONTEXT_SHOP)
			{
				$this->_join .= ' JOIN `'._DB_PREFIX_.'product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = '.(int)$this->context->shop->id.')
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON ('.pSQL($alias).'.`id_category_default` = cl.`id_category` AND b.`id_lang` = cl.`id_lang` AND cl.id_shop = '.(int)$this->context->shop->id.')
				LEFT JOIN `'._DB_PREFIX_.'shop` shop ON (shop.id_shop = '.(int)$this->context->shop->id.')
				LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop ON (image_shop.`id_image` = i.`id_image` AND image_shop.`cover` = 1 AND image_shop.id_shop='.(int)$this->context->shop->id.')';
			}
			else
			{
				$this->_join .= ' LEFT JOIN `'._DB_PREFIX_.'product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = a.id_shop_default)
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON ('.pSQL($alias).'.`id_category_default` = cl.`id_category` AND b.`id_lang` = cl.`id_lang` AND cl.id_shop = a.id_shop_default)
				LEFT JOIN `'._DB_PREFIX_.'shop` shop ON (shop.id_shop = a.id_shop_default)
				LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop ON (image_shop.`id_image` = i.`id_image` AND image_shop.`cover` = 1 AND image_shop.id_shop=a.id_shop_default)';
			}
			$this->_select .= 'shop.name as shopname, lp.`id_product` as `id_lengow_product`, ';
		}
		else
		{
			$alias = 'a';
			$alias_image = 'i';
			$this->_join .= 'LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON ('.pSQL($alias).'.`id_category_default` = cl.`id_category` AND b.`id_lang` = cl.`id_lang` AND cl.id_shop = 1)';
		}

		$this->_select .= 'MAX('.pSQL($alias_image).'.id_image) id_image,';

		$this->_join .= ($join_category ? 'INNER JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_product` = a.`id_product` AND cp.`id_category` = '.(int)$this->_category->id.')' : '').'
		LEFT JOIN `'._DB_PREFIX_.'stock_available` sav ON (sav.`id_product` = a.`id_product` AND sav.`id_product_attribute` = 0
		'.StockAvailable::addSqlShopRestriction(null, null, 'sav').') ';
		$this->_select .= 'cl.name `name_category` '.($join_category ? ', cp.`position`' : '').', '.pSQL($alias).'.`price`, 0 AS price_final, sav.`quantity` as sav_quantity, '.pSQL($alias).'.`active`, IFNULL(lp.`id_product`, 0) as `id_lengow_product`	';

		$this->_group = 'GROUP BY '.pSQL($alias).'.id_product';

		$this->fields_list = array();

		$this->fields_list['id_product'] = array(
			'title' => $this->l('ID'),
			'align' => 'center',
			'width' => 20
		);
		$this->fields_list['image'] = array(
			'title' => $this->l('Image'),
			'align' => 'center',
			'image' => 'p',
			'width' => 70,
			'orderby' => false,
			'filter' => false,
			'search' => false
		);
		$this->fields_list['name'] = array(
			'title' => $this->l('Name'),
			'filter_key' => 'b!name'
		);
		$this->fields_list['reference'] = array(
			'title' => $this->l('Reference'),
			'align' => 'left',
			'width' => 80
		);

		if (Shop::isFeatureActive() && Shop::getContext() != Shop::CONTEXT_SHOP)
			$this->fields_list['shopname'] = array(
				'title' => $this->l('Default shop:'),
				'width' => 230,
				'filter_key' => 'shop!name',
			);
		else
			$this->fields_list['name_category'] = array(
				'title' => $this->l('Category'),
				'width' => 'auto',
				'filter_key' => 'cl!name',
			);

		$this->fields_list['price'] = array(
			'title' => $this->l('Original price'),
			'width' => 90,
			'type' => 'price',
			'align' => 'right',
			'filter_key' => 'a!price'
		);
		$this->fields_list['price_final'] = array(
			'title' => $this->l('Final price'),
			'width' => 90,
			'type' => 'price',
			'align' => 'right',
			'havingFilter' => true,
			'orderby' => false
		);
		$this->fields_list['sav_quantity'] = array(
			'title' => $this->l('Quantity'),
			'width' => 90,
			'align' => 'right',
			'filter_key' => 'sav!quantity',
			'orderby' => true,
			'hint' => $this->l('This is the quantity available in the current shop/group.'),
		);
		$this->fields_list['id_lengow_product'] = array(
			'title' => $this->l('Lengow status'),
			'width' => 'auto',
			//'active' => 'status',
			'filter' => false,
			'search' => false,
			'align' => 'center',
			//'type' => 'bool',
			'callback' => 'getLengowStatus',
			'orderby' => false
		);

		if ((int)$this->id_current_category)
			$this->fields_list['position'] = array(
				'title' => $this->l('Position'),
				'width' => 70,
				'filter_key' => 'cp!position',
				'align' => 'center',
				'position' => 'position'
			);

		$this->bulk_actions = array('publish' => array('text' => $this->l('Publish to Lengow')),
									'unpublish' => array('text' => $this->l('Unpublish to Lengow')));
		$this->show_toolbar = true;

	}

	/**
	* Set media
	*
	* @return media
	*/
	public function setMedia()
	{
		$this->addCSS('/modules/lengow/views/css/lengow-admin.css');
		return parent::setMedia();
	}

	/**
	* Set the productlist
	*
	* @param integer $id_lang ID of lang
	* @param varchar $orderBy Order of list
	* @param varchar $orderWay Sens of list
	* @param integer $start Start
	* @param integer $limit Count limit of list
	* @param integer $id_lang_shop ID of lang'shop
	*/
	public function getList($id_lang, $orderBy = null, $orderWay = null, $start = 0, $limit = null, $id_lang_shop = null)
	{
		$id_lang_shop = $id_lang_shop;
		$orderByPriceFinal = (empty($orderBy) ? ($this->context->cookie->__get($this->table.'Orderby') ? $this->context->cookie->__get($this->table.'Orderby') : 'id_'.$this->table) : $orderBy);
		$orderWayPriceFinal = (empty($orderWay) ? ($this->context->cookie->__get($this->table.'Orderway') ? $this->context->cookie->__get($this->table.'Orderby') : 'ASC') : $orderWay);
		if ($orderByPriceFinal == 'price_final')
		{
			$orderBy = 'id_'.$this->table;
			$orderWay = 'ASC';
		}
		parent::getList($id_lang, $orderBy, $orderWay, $start, $limit, $this->context->shop->id);

		/* update product quantity with attributes ...*/
		$nb = count($this->_list);
		if ($this->_list)
		{
			/* update product final price */
			for ($i = 0; $i < $nb; $i++)
			{
				// convert price with the currency from context
				$this->_list[$i]['price'] = Tools::convertPrice($this->_list[$i]['price'], $this->context->currency, true, $this->context);
				$this->_list[$i]['price_tmp'] = Product::getPriceStatic($this->_list[$i]['id_product'], true, null, 2, null, false, true, 1, true);
			}
		}

		if ($orderByPriceFinal == 'price_final')
		{
			if (Tools::strtolower($orderWayPriceFinal) == 'desc')
				uasort($this->_list, 'cmpPriceDesc');
			else
				uasort($this->_list, 'cmpPriceAsc');
		}
		for ($i = 0; $this->_list && $i < $nb; $i++)
		{
			$this->_list[$i]['price_final'] = $this->_list[$i]['price_tmp'];
			unset($this->_list[$i]['price_tmp']);
		}
	}

	/**
	* Init content html
	*
	* @param $token Token
	*/
	public function initContent($token = null)
	{
		$token = $token;
		if ($id_category = (int)$this->id_current_category)
			self::$currentIndex .= '&id_category='.(int)$this->id_current_category;

		// If products from all categories are displayed, we don't want to use sorting by position
		if (!$id_category)
		{
			$this->_defaultOrderBy = $this->identifier;
			if ($this->context->cookie->{$this->table.'Orderby'} == 'position')
			{
				unset($this->context->cookie->{$this->table.'Orderby'});
				unset($this->context->cookie->{$this->table.'Orderway'});
			}
		}
		if (!$id_category)
			$id_category = 1;
		$this->tpl_list_vars['is_category_filter'] = (bool)$this->id_current_category;

		// Generate category selection tree
		$helper = new Helper();
		$this->tpl_list_vars['category_tree'] = $helper->renderCategoryTree(null, array((int)$id_category), 'categoryBox', true, false, array(), false, true);
		if (isset($helper->actions))
			$helper->actions['unpublish'];

		// used to build the new url when changing category
		$this->tpl_list_vars['base_url'] = preg_replace('#&id_category=[0-9]*#', '', self::$currentIndex).'&token='.$this->token;

		parent::initContent();
	}

	/**
	* Get status Lengow of current line
	*
	* @param text $echo Block html
	* @param object $row Order of list
	*
	* @return boolean Is selected
	*/
	public function getLengowStatus($echo, $row)
	{
		$echo = $echo; // Prestashop validator
		$token = Tools::getAdminTokenLite('AdminLengow', Context::getContext());
		if ($row['id_lengow_product'] == 0)
			return '<a href="index.php?controller=AdminLengow&publish='.$row['id_product'].'&token='.$token.'"><img src="'._PS_ADMIN_IMG_.'disabled.gif" /></a>';
		else
			return '<a href="index.php?controller=AdminLengow&unpublish='.$row['id_product'].'&token='.$token.'"><img src="'._PS_ADMIN_IMG_.'enabled.gif" /></a>';
		return $row->id_lengow_product > 0 ? true : false;
	}

	/**
	* Get status Lengow of current line
	*
	* @param text $echo Block html
	* @param object $row Order of list
	*
	* @return boolean Is selected
	*/
	public function renderList()
	{
		$this->addRowAction('lengowunpublish');
		return parent::renderList();
	}

	/**
	* Publish selected products to Lengow
	*/
	protected function processBulkPublish()
	{
		$products = Tools::getValue($this->table.'Box');
		if (is_array($products) && (count($products)))
			foreach ($products as $id_product)
				LengowProduct::publish($id_product);
	}

	/**
	* Unpublish selected products to Lengow
	*/
	protected function processBulkUnpublish()
	{
		$products = Tools::getValue($this->table.'Box');
		if (is_array($products) && (count($products)))
			foreach ($products as $id_product)
				LengowProduct::publish($id_product, 0);
	}

	/**
	* postProcess handle every checks before saving products information
	*
	* @param mixed $token
	* @return void
	*/
	public function postProcess($token = null)
	{
		if (Tools::getValue('unpublish'))
			LengowProduct::publish(Tools::getValue('unpublish'), 0);
		elseif (Tools::getValue('publish'))
			LengowProduct::publish(Tools::getValue('publish'));
		if (Tools::getValue('importorder'))
		{
			@set_time_limit(0);
			$sep = DIRECTORY_SEPARATOR;
			require_once _PS_MODULE_DIR_.'lengow'.$sep.'models'.$sep.'lengow.import.class.php';
			$import = new LengowImport();
			$import->force_log_output = false;
			$date_to = date('Y-m-d');
			$days = (integer)LengowCore::getCountDaysToImport();
			$date_from = date('Y-m-d', strtotime(date('Y-m-d').' -'.$days.'days'));
			$result = $import->exec('commands', array(
						'dateFrom' => $date_from,
						'dateTo' => $date_to
						));
			if ($result && ($result['new'] > 0 || $result['update'] > 0))
			{
				if ($result['new'] > 0)
					$this->confirmations[] = sprintf($this->l('Import %d order%s'), $result['new'], $result['new'] > 1 ? 's' : '');
				if ($result['update'] > 0)
					$this->confirmations[] = sprintf($this->l('Updated %d order%s'), $result['update'], $result['update'] > 1 ? 's' : '');
			}
			else
				$this->errors[] = Tools::displayError('No available order to import or update.');
		}

		// avoids Prestashop from crashing by precising the table alias for the "quantity" field
		if (Tools::getValue('productOrderby') == 'quantity')
		{
			if ($_POST['productOrderby'])
				$_POST['productOrderby'] = 'sav.quantity';
			else
				$_GET['productOrderby'] = 'sav.quantity';
		}

		parent::postProcess($token);
	}

	/**
	* Init Toolbar
	*/
	public function initToolbar()
	{
		parent::initToolbar();
		unset($this->toolbar_btn['new']);
		/*$this->toolbar_btn['importlengow'] = array(
				'href' => $this->context->link->getAdminLink('AdminLengow', true).'&importorder=1',
				'desc' => $this->l('Import orders from lengow')
			);*/
		$this->context->smarty->assign('toolbar_scroll', 1);
		$this->context->smarty->assign('show_toolbar', 1);
		$this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
	}

	/**
	* Re-import order
	*/
	public function displayAjaxReimportOrder()
	{
		@set_time_limit(0);
		$sep = DIRECTORY_SEPARATOR;
		require_once LengowCore::getLengowFolder().$sep.'models'.$sep.'lengow.import.class.php';
		require_once LengowCore::getLengowFolder().$sep.'models'.$sep.'lengow.importv2.class.php';

		$order_id = Tools::getValue('id_order');
		// make sure order is from Lengow
		if (LengowOrder::isFromLengow($order_id))
		{	
			$order = new LengowOrder($order_id);
			if (!(!Configuration::get('LENGOW_SWITCH_V3') && $order->id_flux == null))
			{
				// disable order
				LengowOrder::disable($order->id);
				// suppress log to allow order to be reimported
				if ($order->lengow_delivery_address_id != null)
					LengowLog::deleteLogByOrderId($order->id_lengow, $order->lengow_delivery_address_id);
				else
					LengowLog::deleteLogByOrderIdV2($order->id_lengow);
				// start import for re-import order
				if (Configuration::get('LENGOW_SWITCH_V3'))
				{
					// compatibility V2
					if ($order->id_flux != null)
						$order->checkAndChangeMarketplaceName();
					$import = new LengowImport($order->id_lengow, $order->lengow_marketplace);
					$import->exec();
				}
				else
				{
					if ($order->id_flux != null)
					{
						$importV2 = new LengowImportV2($order->id_lengow, $order->id_flux);
						$importV2->exec();
					}
				}	
			}
		}
		// redirection
		$order_url = 'index.php?controller=AdminOrders&id_order='.$order_id.'&vieworder&token='.Tools::getAdminTokenLite('AdminOrders');
		Tools::redirectAdmin($order_url);
	}
}