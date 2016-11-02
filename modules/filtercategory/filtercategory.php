<?php

/*
 * Module BlfMenu
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class FilterCategory extends Module {

    public function __construct() {
        $this->name = 'filtercategory';
        $this->tab = 'others';
		$this->version = '1.0';
		$this->author = 'Vupar';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); 
        $this->module_key = "";

        parent::__construct();

        $this->displayName = $this->l('Filter Category');
        $this->description = $this->l("Display all Adjacente Category");
        
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall Filter Category Module?');
    }

    
    public function install() {

        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);
                                
        if (!parent::install() ||
            !$this->registerHook('displayLeftColumn')) {
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
    
    
    public function hookDisplayLeftColumn($params) {
        
        if((int)Tools::getValue('id_category') != "") {
            if (!$this->isCached('menucategory.tpl', $this->getCacheId())) {
                $groups = implode(', ', Customer::getGroupsStatic((int)$this->context->customer->id));
                $id_category = (int)Tools::getValue('id_category');
                $categoryObj = new Category($id_category, $this->context->language->id, $this->context->shop->id);

                $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
                    SELECT DISTINCT c.id_parent, c.id_category, cl.name, cl.description, cl.link_rewrite
                    FROM `'._DB_PREFIX_.'category` c
                    INNER JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_lang` = '.(int)$this->context->language->id.Shop::addSqlRestrictionOnLang('cl').')
                    INNER JOIN `'._DB_PREFIX_.'category_shop` cs ON (cs.`id_category` = c.`id_category` AND cs.`id_shop` = '.(int)$this->context->shop->id.')
                    WHERE c.`active` = 1
                    AND c.id_category IN (SELECT id_category FROM `'._DB_PREFIX_.'category_group` WHERE `id_group` IN ('.pSQL($groups).'))
                    AND c.id_parent = '.$categoryObj->id_parent.'
                    ORDER BY c.`position` ASC');

                foreach ($results as $i=>$result) {
                    $results[$i]['link'] = $this->context->link->getCategoryLink($results[$i]['id_category'], $results[$i]['link_rewrite']);
                }

                $this->smarty->assign('categories', $results);
                $this->smarty->assign('current_category', $categoryObj);
            }
        }

        $display = $this->display(__FILE__, '/views/templates/hook/filtercategory.tpl', $this->getCacheId());
		return $display;
	}
}