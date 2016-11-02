<?php
/**
* Module Csv Movment Stock
*/

if (!defined('_PS_VERSION_')) {
    exit;
}


class CsvMovementStock extends Module {

    public function __construct() {
        $this->name = 'csvmovementstock';
        $this->tab = 'others';
		$this->version = '1.0';
		$this->author = 'Vupar';
        $this->need_instance = 0;
        $this->module_key = "";

        parent::__construct();

        $this->displayName = $this->l('Csv Movement Stock');
        $this->description = $this->l('Csv Movement Stock Permit to upload stock movement');
    }

    public function install() {
                                
        if (!parent::install()) {
            return FALSE;
        }
        
        return TRUE;
    }
    
    public function uninstall() {

        if (!parent::uninstall()) {
            return FALSE;
        }

        return TRUE;
    }
}