<?php

/*
 * Module ShoppingList
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class OverrideImageManager extends Module {

    public function __construct() {
        $this->name = 'overrideimagemanager';
        $this->tab = 'others';
		$this->version = '1.0';
		$this->author = 'Vupar';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); 
        $this->module_key = "";

        parent::__construct();

        $this->displayName = $this->l('Override Image Manager');
        $this->description = $this->l("Permit to override image manager to zoom and crop image");
        
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall Override Image Manager?');
    }

    public function install() {

        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);
                                
        if (!parent::install()) {
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
}