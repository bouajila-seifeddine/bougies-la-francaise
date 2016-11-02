<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class Blocktopmenu extends BlocktopmenuModule
{

	public function hookDisplayTop($param) {
		$this->user_groups =  ($this->context->customer->isLogged() ? $this->context->customer->getGroups() : array(Configuration::get('PS_UNIDENTIFIED_GROUP')));
		$this->page_name = Dispatcher::getInstance()->getController();

		if (!$this->isCached('blocktopmenu.tpl', $this->getCacheId()))
		{
			$this->makeMenu();
			$this->smarty->assign('MENU_SEARCH', Configuration::get('MOD_BLOCKTOPMENU_SEARCH'));
			$this->smarty->assign('MENU', $this->_menu);
			$this->smarty->assign('this_path', $this->_path);

			$groups = implode(', ', Customer::getGroupsStatic((int)$this->context->customer->id));
			$maxdepth = 4;

			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                SELECT DISTINCT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite
                FROM `'._DB_PREFIX_.'category` c
                INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_lang` = '.(int)$this->context->language->id.Shop::addSqlRestrictionOnLang('cl').')
                INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (cs.`id_category` = c.`id_category` AND cs.`id_shop` = '.(int)$this->context->shop->id.')
                WHERE (c.`active` = 1 OR c.`id_category` = '.(int)Configuration::get('PS_HOME_CATEGORY').')
                AND c.`id_category` != '.(int)Configuration::get('PS_ROOT_CATEGORY').'
                '.((int)$maxdepth != 0 ? ' AND `level_depth` <= '.(int)$maxdepth : '').'
                AND c.id_category IN (SELECT id_category FROM `'._DB_PREFIX_.'category_group` WHERE `id_group` IN ('.pSQL($groups).'))
                ORDER BY `level_depth` ASC, '.(Configuration::get('BLOCK_CATEG_SORT') ? 'cl.`name`' : 'cs.`position`').' '.(Configuration::get('BLOCK_CATEG_SORT_WAY') ? 'DESC' : 'ASC'));

			$resultParents = array();
			$resultIds = array();
			$isDhtml = (Configuration::get('BLOCK_CATEG_DHTML') == 1 ? true : false);

			foreach ($result as &$row)
			{
				$resultParents[$row['id_parent']][] = &$row;
				$resultIds[$row['id_category']] = &$row;
				if($row['id_parent'] == 2) {
					$resultIds[$row['id_category']]['image'] = '/img/c/'.$row['id_category'].'-category_menu_zoom.jpg';
				}
				else {
					$resultIds[$row['id_category']]['image'] = null;
				}
			}

			$blockCategTree = $this->getTree($resultParents, $resultIds, $maxdepth);
			unset($resultParents, $resultIds);

			$this->smarty->assign('blockCategTree', $blockCategTree);
			$this->smarty->assign('branche_tpl_path', _PS_MODULE_DIR_.'menucategory/views/templates/hook/category-tree-branch.tpl');

		}

		$id_category = (int)Tools::getValue('id_category');
		$id_product = (int)Tools::getValue('id_product');

		if (Tools::isSubmit('id_category')) {
			$this->context->cookie->last_visited_category = (int)$id_category;
			$this->smarty->assign('currentCategoryId', $this->context->cookie->last_visited_category);
		}

		if (Tools::isSubmit('id_product')) {
			if (!isset($this->context->cookie->last_visited_category)
				|| !Product::idIsOnCategoryId($id_product, array('0' => array('id_category' => $this->context->cookie->last_visited_category)))
				|| !Category::inShopStatic($this->context->cookie->last_visited_category, $this->context->shop))
			{
				$product = new Product((int)$id_product);
				if (isset($product) && Validate::isLoadedObject($product))
					$this->context->cookie->last_visited_category = (int)$product->id_category_default;
			}
			$this->smarty->assign('currentCategoryId', (int)$this->context->cookie->last_visited_category);
		}

		$html = $this->display(__FILE__, 'blocktopmenu.tpl', $this->getCacheId());
		return $html;
	}


	public function getTree($resultParents, $resultIds, $maxDepth, $id_category = null, $currentDepth = 0) {
		if (is_null($id_category))
			$id_category = $this->context->shop->getCategory();

		$children = array();
		if (isset($resultParents[$id_category]) && count($resultParents[$id_category]) && ($maxDepth == 0 || $currentDepth < $maxDepth))
			foreach ($resultParents[$id_category] as $subcat)
				$children[] = $this->getTree($resultParents, $resultIds, $maxDepth, $subcat['id_category'], $currentDepth + 1);
		if (!isset($resultIds[$id_category]))
			return false;
		$return = array('id' => $id_category, 'link' => $this->context->link->getCategoryLink($id_category, $resultIds[$id_category]['link_rewrite']),
			'name' => $resultIds[$id_category]['name'], 'desc'=> $resultIds[$id_category]['description'],
			'children' => $children, 'image' => $resultIds[$id_category]['image']);
		return $return;
	}
}
