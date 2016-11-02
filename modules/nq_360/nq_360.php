<?php

if (!defined('_PS_VERSION_'))
  exit;
//test here
include(dirname(__FILE__) . "/config/config.php");
class NQ_360 extends Module
{
    private $gateway = NULL;
    public function __construct()
    {
        $this->name = 'nq_360';
        $this->tab = 'front_office_features';
        $this->version = '1.6';
        $this->author = 'NewQuest';
        parent::__construct();
        $this->displayName = $this->l('Scancube 360');
        $this->description = $this->l('Scancube 360 settings');
    }

    public function install()
    {
        if (!parent::install() 
                OR!$this->registerHook('productTabContent') 
                OR !$this->registerHook('header') 
                OR !$this->registerHook('footer') 
                OR !$this->registerHook('displayBackOfficeHeader') 
                OR !$this->registerHook('displayBackOfficeFooter') 
                OR !$this->registerHook('productTab') 
                OR !$this->registerHook('extraRight') 
                OR !$this->registerHook('extraLeft') 
                OR !$this->registerHook('productActions') 
                OR !$this->installDB())
            return false;
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() 
                OR !$this->registerHook('productTabContent') 
                OR !$this->registerHook('header') 
                OR !$this->registerHook('footer') 
                OR !$this->registerHook('productTab') 
                OR !$this->registerHook('displayBackOfficeFooter') 
                OR !$this->registerHook('displayBackOfficeHeader') 
                OR !$this->registerHook('extraRight') 
                OR !$this->registerHook('extraLeft') 
                OR !$this->registerHook('productActions') 
                OR !$this->uninstallDB())
            return false;
        return true;
    }

    public function installDB()
    {
        $res1 = Db::getInstance()->Execute('
		CREATE TABLE `' . _DB_PREFIX_ . '360_file` (
	        `id_file` int(10) unsigned NOT NULL auto_increment,
		  `file_url` varchar(255) default NULL,
		  `type` varchar(100) default NULL,
		  `id_product` int(10) unsigned default NULL,
		  `date_add` datetime default NULL,
		  PRIMARY KEY  (`id_file`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');


        $res2 = Db::getInstance()->Execute('
		CREATE TABLE `' . _DB_PREFIX_ . '360_generate` (
		  `id_360` int(11) unsigned NOT NULL auto_increment,
		  `name` varchar(255) default NULL,
		  `date_add` datetime default NULL,
		  `active` tinyint(1) unsigned default NULL,
		  `id_product` int(11) default NULL,
		  `display` varchar(255) default NULL,
		  `zoom` tinyint(1) unsigned default NULL,
                  `num_images` tinyint(8) unsigned default 24,
                  `rotation_dir` tinyint(1) unsigned default 0,
                  `rotation_speed` tinyint(6) unsigned default 10,
                  `anim_style` tinyint(5) unsigned default 1,
                  `auto_spin` tinyint(8) unsigned default 5,
		  PRIMARY KEY  (`id_360`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');



        $res3 = Db::getInstance()->Execute('
		CREATE TABLE `' . _DB_PREFIX_ . '360_link_file` (
		  `id_link` int(11) unsigned NOT NULL auto_increment,
		  `id_360` int(11) unsigned default NULL,
		  `id_file` int(11) unsigned default NULL,
		  `position` int(11) unsigned default NULL,
		  `date_add` datetime default NULL,
		  PRIMARY KEY  (`id_link`)
		) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');

        if ($res1 && $res2 && $res3)
        {
            return true;
        }

        return false;
    }

    public function uninstallDB()
    {
        $res1 = Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . '360_file`;');
        $res2 = Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . '360_generate`;');
        $res3 = Db::getInstance()->Execute('DROP TABLE `' . _DB_PREFIX_ . '360_link_file`;');
        if ($res1 && $res2 && $res3)
        {
            return true;
        }
        return false;
    }
    public function hookProductTabContent($params)
    {
        global $smarty;
        if (!GestionFo::isPageProduct())
        {
            return;
        }
        if (!$id_product = GestionFo::getIdProduct())
        {
            return;
        }
        $t_img = Scancube360::isGenereted360($id_product);
        if (count($t_img) == 0)
        {
            return;
        }
        $display = Scancube360::getDisplayScanCube($id_product);
        if ($display != "onglet")
        {
            return;
        }
        $smarty->assign("t_img_360", $t_img);
        return ($this->display(__FILE__, '/' . DIR_NAME_TEMPLATE . '/content-tab.tpl'));
    }

    public function hookProductTab($params)
    {
        if (!GestionFo::isPageProduct()){return;}
        if (!$id_product = GestionFo::getIdProduct()){return;}
        $t_img = Scancube360::isGenereted360($id_product);
        if (count($t_img) == 0){return;}
        $display = Scancube360::getDisplayScanCube($id_product);

        if ($display != "onglet")
        {
            return;
        }
        return ($this->display(__FILE__, '/' . DIR_NAME_TEMPLATE . '/tab.tpl'));
    }

    public function hookExtraRight($params, $type = "extraRight", $template = "content-extra-right.tpl")
    {
        global $smarty;
        if (!GestionFo::isPageProduct())
        {
            return;
        }
        if (!$id_product = GestionFo::getIdProduct())
        {
            return;
        }

        $t_img = Scancube360::isGenereted360($id_product);
        if (count($t_img) == 0)
        {
            return;
        }

        $display = Scancube360::getDisplayScanCube($id_product);

        if ($display != $type)
        {
            return;
        }
        $smarty->assign("t_img_360", $t_img);
        return ($this->display(__FILE__, '/' . DIR_NAME_TEMPLATE . '/' . $template));
    }

    public function hookExtraLeft($params)
    {
        return $this->hookExtraRight($params, "extraLeft", "content-extra-left.tpl");
    }

    public function hookProductActions($params)
    {
        global $smarty;
        if (!GestionFo::isPageProduct())
        {
            return;
        }
        if (!$id_product = GestionFo::getIdProduct())
        {
            return;
        }
        $t_img = Scancube360::isGenereted360($id_product);
        if (count($t_img) == 0)
        {
            return;
        }
        $display = Scancube360::getDisplayScanCube($id_product);
        if ($display != "bouton")
        {
            return;
        }
        $id_360 = Scancube360::getId360($id_product);
        list($width, $height) = getimagesize(dirname(__FILE__) . "/img_360/" . $t_img[0]);
        $presta_dir = __PS_BASE_URI__;
        if ($presta_dir[strlen($presta_dir) - 1] == '/')
        {
            $presta_dir = substr($presta_dir, 0, strlen($presta_dir) - 1);
        }
        $smarty->assign("width", $width + 40);
        $smarty->assign("height", $height + 40);
  
        return ($this->display(__FILE__, '/' . DIR_NAME_TEMPLATE . '/content-button-show-360.tpl'));
    }

    public function hookHeader($params)
    {
        /* if (!GestionFo::isPageProduct())
        {
           return;
        } */
        if (!$id_product = GestionFo::getIdProduct())
        {
          return;
        }

        $t_img = Scancube360::isGenereted360($id_product);
        if (count($t_img) == 0)
        {
          return;
        }

        if (version_compare(_PS_VERSION_, '1.4', '>=') && version_compare(_PS_VERSION_, '1.5', '<'))
        {
            Tools::addCSS(__PS_BASE_URI__ . 'modules/nq_360/css/scancube-jzspin1.4.css', 'screen');
            Tools::addJS(__PS_BASE_URI__ . 'modules/nq_360/js/jzspin1.4.js');
            Tools::addCSS(__PS_BASE_URI__ . 'modules/nq_360/css/jquery.fancybox-1.3.4.css', 'screen');
            Tools::addJS(__PS_BASE_URI__ . 'modules/nq_360/js/jquery.fancybox-1.3.4.js');
        }
        if (version_compare(_PS_VERSION_, '1.5', '>'))
        {
            $this->context->controller->addCSS(__PS_BASE_URI__ . 'modules/nq_360/css/scancube-jzspin1.4.css');
            $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/nq_360/js/jzspin1.4.js');
        }
         
    }

    public function hookFooter($param)
    {
        global $smarty;
        if (!GestionFo::isPageProduct())
        {
           return;
        }
        if (!$id_product = GestionFo::getIdProduct())
        {
           return;
        }
        $t_img = Scancube360::isGenereted360($id_product);
        if (count($t_img) == 0)
        {
           return;
        }
        $jzs = "";
        $display = Scancube360::getDisplayScanCube($id_product);
        $animOptions = Scancube360::getAnimationOptions($id_product);
       
        if (is_array($t_img) && count($t_img) > 1)
         {
                $img0 = substr($t_img[1], 0, -8);
                list($width, $height) = getimagesize(dirname(__FILE__) . "/img_360/" . $t_img[0]);
                list($Hdwidth, $Hdheight) = getimagesize(dirname(__FILE__) . "/img_360/" . "hd-" . $t_img[1]);
		
		$_PS_VERSION_ = _PS_VERSION_ ;
		 $jzs .= "<script>
		 window.ScanCubePresta360Settings =     
                  {
		     prestashopVersion : ".'"'. $_PS_VERSION_.'"'.",
                     ldImageWidth:   {$width},
                     ldImageHeight:  {$height},
                     isZoomable:     {$animOptions['zoom']},
                     hdImageWidth:   {$Hdwidth},
                     hdImageHeight:  {$Hdheight},
                     numberOfImages: {$animOptions['num_images']},
                     rotationSpeed : {$animOptions['rotation_speed']},
                     autoSpinAfter : {$animOptions['auto_spin']},
                     style :{$animOptions['anim_style']},
                     magnifierSize :300,
                     direction:{$animOptions['rotation_dir']}, //ckw = 0 , antickw = 1 
                     ldImageBaseName : " . '"' . __PS_BASE_URI__ . "modules/nq_360/img_360/{$img0}" . '"' . ",".
                     "hdImageBaseName :" . '"' . __PS_BASE_URI__ . "modules/nq_360/img_360/hd-{$img0}" . '"' .
                  "}
                </script>" ;
		if ($display == "onglet" || $display == "extraRight" || $display == "extraLeft")
		{
                   $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/nq_360/js/front-non-popup-360.js');
		  //$jzs .='<script src="'.__PS_BASE_URI__ .'modules/nq_360/js/front-non-popup-360.js" type="text/javascript" ></script>';
		}
		else  //pupup button display
		{
	          $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/nq_360/js/front-popup-360.js');
		  //$jzs .='<script src="'.__PS_BASE_URI__ .'modules/nq_360/js/front-popup-360.js" type="text/javascript" ></script>';

		}
           $smarty->assign("jzscan", $jzs);
           return ($this->display(__FILE__, '/' . DIR_NAME_TEMPLATE . '/front-footer.tpl')); 
            }
      }

    public function hookDisplayBackOfficeHeader($params)
    {
        $html = '';
        $html .= '<link href="'.__PS_BASE_URI__ .'modules/nq_360/css/main-admin.css" rel="stylesheet" type="text/css" media="all" />'."\r\n";
        $html .= '<link href="'.__PS_BASE_URI__ .'modules/nq_360/css/uploadify.css" rel="stylesheet" type="text/css" media="all" />'."\r\n";
        $html .= '<script src="'.__PS_BASE_URI__ .'modules/nq_360/js/main-admin15.js" type="text/javascript" ></script>';
	$html .= '<script src="'.__PS_BASE_URI__ .'modules/nq_360/js/uploadify/jquery.uploadify.min.js" type="text/javascript" ></script>';
	
	return $html ;
	
	//not working 
	//$this->context->controller->addCSS(__PS_BASE_URI__ . 'modules/nq_360/css/main-admin.css');
	//$this->context->controller->addCSS(__PS_BASE_URI__ . 'modules/nq_360/css/uploadify.css');
	
    }

    public function hookDisplayBackOfficeFooter($params)
    {
	global $smarty;
        if (!GestionBO::isPageProductBO())
        {
          return;
        }
        if (!$id_product = GestionBO::getIdProduct())
        {
          return;
        }
      
         $js =  "
          <script>
             window.scancubeBoSettings =
               {
		id_product_for_360 : " . $id_product . ",
		link_module_360 : '" .__PS_BASE_URI__  . 'modules/nq_360'. "/',
		dir_presta : '" . __PS_BASE_URI__  . "',
	       }
		</script>
		";
       
	 
	// not needed anymore
	// $js .=  "<script src=\"".__PS_BASE_URI__ . 'modules/nq_360/js/main-admin15.js'.    "\" >  </script> " ;
	// $js .=  "<script src=\"".__PS_BASE_URI__ . 'modules/nq_360/js/uploadify/jquery.uploadify.min.js'.    "\" >  </script> " ;
        
	// not working
        // $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/nq_360/js/main-admin15.js')  ;
        // $this->context->controller->addJS(__PS_BASE_URI__ . 'modules/nq_360/js/uploadify/jquery.uploadify.min.js');

        $smarty->assign("jzscanBofooter", $js);
	return ($this->display(__FILE__, '/' . DIR_NAME_TEMPLATE . '/bo-footer.tpl')); 
    }

}