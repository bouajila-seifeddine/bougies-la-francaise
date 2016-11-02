<?php
/**
* MODULE HomeImageBlock
* 
* @author Olivier Michaud
* @copyright  Olivier Michaud
* @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

define('_PS_HOMEIMAGE_IMG_DIR_', _PS_IMG_DIR_.'home_image_block/');
if (!file_exists(_PS_HOMEIMAGE_IMG_DIR_)) {
    mkdir(_PS_HOMEIMAGE_IMG_DIR_);
}

include_once(_PS_MODULE_DIR_.'homeimageblock/classes/HomeImageBlockObject.php');

class HomeImageBlock extends Module {
    
    private $_html = '';
    
    public function __construct() {
        $this->name = 'homeimageblock';
        $this->tab = 'others';
		$this->version = '1.6';
		$this->author = 'Olivier Michaud';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5.2', 'max' => '1.6'); 
        $this->module_key = "fd707cfa470b1732f6a0e34d990f884a";

        parent::__construct();

        $this->displayName = $this->l('Home Image Block');
        $this->description = $this->l("Permit to display some image block on home with link");
        
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall Home Image Block Module?');
    }

    
    public function install()
	{
        $sql = array();
	
        /* Image */
        $sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'home_image_block` (
                 `id_home_image_block` int(10) unsigned NOT NULL AUTO_INCREMENT,
                 `position` INT(10) UNSIGNED NOT NULL,
                 `date_add` DATETIME NOT NULL,
                 `date_upd` DATETIME NOT NULL,
                 `active` TINYINT(1) NOT NULL DEFAULT 1,
				PRIMARY KEY (`id_home_image_block`)
                ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;';
        
        /* Image Lang */
        $sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'home_image_block_lang` (
			  `id_home_image_block` int(10) unsigned NOT NULL,
              `id_lang` INT(10) UNSIGNED NOT NULL,
			  `title` VARCHAR(255) NOT NULL,
              `description` VARCHAR(500) NULL,
              `url` VARCHAR(255) NULL,
              `image` VARCHAR(255) NOT NULL,
              `legend` VARCHAR(500) NOT NULL,
			  PRIMARY KEY (`id_home_image_block`, `id_lang`)
              ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;';
        
        /* Image Shop */
        $sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'home_image_block_shop` (
			  `id_home_image_block` int(10) unsigned NOT NULL,
			  `id_shop` int(10) unsigned NOT NULL,
			  PRIMARY KEY (`id_home_image_block`,`id_shop`)
              ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;';
        
        //Add a menu in "preference menu"
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminHomeImageBlock';
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang)
            $tab->name[$lang['id_lang']] = $this->l('Image Home');
        $tab->id_parent = 9;
        $tab->module = $this->name;
        $tab->add();
        
		/* Adds Module */
		if (!parent::install() or 
            !$this->registerHook('displayHome') OR
            !$this->registerHook('displayHeader') OR
            !Configuration::updateValue('IMAGE_BLOCK_LEFT_MARGIN', '10') OR
            !Configuration::updateValue('IMAGE_BLOCK_BOTTOM_MARGIN', '10') OR
            !Configuration::updateValue('IMAGE_BLOCK_ANIMATE', '1') OR
            !Configuration::updateValue('IMAGE_BLOCK_ANIMATE_PX', '5') OR
            !Configuration::updateValue('IMAGE_BLOCK_BACKGROUND', '#FFFFFF') OR
            !$this->runSql($sql)
		) {
			return false;
		}
		
        return true;
	}

    
    public function uninstall() {       
        $sql = array();
        $sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'home_image_block`';
        $sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'home_image_block_lang`';
        $sql[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'home_image_block_shop`';
        
        //Remove the menu
        $idTab = Tab::getIdFromClassName('AdminHomeImageBlock');
        $tab = new Tab($idTab);
        $tab->delete();
        
        if (!parent::uninstall() ||
            !Configuration::deleteByName('IMAGE_BLOCK_LEFT_MARGIN') OR
            !Configuration::deleteByName('IMAGE_BLOCK_BOTTOM_MARGIN') OR
            !Configuration::deleteByName('IMAGE_BLOCK_ANIMATE') OR
            !Configuration::deleteByName('IMAGE_BLOCK_ANIMATE_PX') OR
            !Configuration::deleteByName('IMAGE_BLOCK_BACKGROUND') OR
            !$this->runSql($sql) 
        ) {
            return false;
        }

        return true;
    }
    
    
    public function runSql($sql) {
        foreach ($sql as $s) {
			if (!Db::getInstance()->Execute($s)){
				return FALSE;
			}
        }
        return TRUE;
    }
    
    
    public function hookDisplayHeader($params) {
        $this->context->controller->addCSS($this->_path.'css/homeimageblock.css');
        $this->context->controller->addJS($this->_path.'js/vendor/masonry.pkgd.min.js');
        $this->context->controller->addJS($this->_path.'js/homeimageblock.js');
    }
    
    
    public function hookDisplayHome($params) {
        $images = HomeImageBlockObject::getAllImages($this->context->language->id, $this->context->shop->id);
        
        foreach ($images as $i=>$image) {

            if(file_exists(_PS_HOMEIMAGE_IMG_DIR_.$image['id_home_image_block'].'.jpg') || file_exists(_PS_HOMEIMAGE_IMG_DIR_.$image['id_home_image_block'].'.png')) {
                (file_exists(_PS_HOMEIMAGE_IMG_DIR_.$image['id_home_image_block'].'.jpg')) ? $extention = '.jpg': $extention = '.png';
                
                $images[$i]['image'] = _PS_IMG_.'home_image_block/'.$image['id_home_image_block'].$extention;
                list($width, $height, $type, $attr) = getimagesize(_PS_HOMEIMAGE_IMG_DIR_.$image['id_home_image_block'].$extention);
                $images[$i]['image_height'] = $height;
                $images[$i]['image_width'] = $width;
            }
            else {
                unset($images[$i]);
            }
        }

        $this->context->smarty->assign(array(
            'images'=> $images,
            'left_margin' => Configuration::get('IMAGE_BLOCK_LEFT_MARGIN'),
            'bottom_margin' => Configuration::get('IMAGE_BLOCK_BOTTOM_MARGIN'),
            'animate' => Configuration::get('IMAGE_BLOCK_ANIMATE'),
            'animate_px' => Configuration::get('IMAGE_BLOCK_ANIMATE_PX'),
            'image_block_backgroud' => Configuration::get('IMAGE_BLOCK_BACKGROUND'),
        ));

        return $this->display(__FILE__, 'views/templates/hook/home.tpl');
    }
}