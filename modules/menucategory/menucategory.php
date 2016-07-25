<?php

/*
 * Module BlfMenu
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class MenuCategory extends Module {

    public function __construct() {
        $this->name = 'menucategory';
        $this->tab = 'others';
		$this->version = '1.0';
		$this->author = 'Vupar';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); 
        $this->module_key = "";

        parent::__construct();

        $this->displayName = $this->l('Menu Category');
        $this->description = $this->l("Display all Category in a menu");
        
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall Menu Category Module?');
    }

    
    public function install() {

        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);
                                
        if (!parent::install() ||
            !$this->registerHook('top')) {
            return false;
        }
        
        return true;
    }
    
    
    public function uninstall() {       
        
        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }
    
    
    public function hookTop($params) {
        
        if (!$this->isCached('menucategory.tpl', $this->getCacheId())) {
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
        
        $display = $this->display(__FILE__, '/views/templates/hook/menucategory.tpl', $this->getCacheId());
		return $display;
	}
    
    
    public function getTree($resultParents, $resultIds, $maxDepth, $id_category = null, $currentDepth = 0)
	{
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