<?php

/*
 * Module ShoppingList
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class OverridePhpModule extends Module {

    public function __construct() {
        $this->name = 'overridephpmodule';
        $this->tab = 'others';
		$this->version = '1.0';
		$this->author = 'Vupar';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); 
        $this->module_key = "";

        parent::__construct();

        $this->displayName = $this->l('Override PHP in Module');
        $this->description = $this->l("Permit to override a php's module file");
        
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall Override PHP Module?');
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