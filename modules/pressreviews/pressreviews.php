<?php

if (!defined('_PS_VERSION_'))
  exit;

require_once _PS_MODULE_DIR_ . 'pressreviews/models/PrReviews.php';

class PressReviews extends Module {

    public function __construct() {

        $this->name 		= 'pressreviews';
        $this->tab 		= 'content_management';
        $this->version 		= 1.3;
        $this->author 		= 'Mehdi BOUZIDI';
        $this->need_instance = 0;
        $this->module_key = 'c7e7e5f35eff451c1af2d4f29716228b';
        
        parent::__construct();
        
        $this->displayName 	= $this->l('Press Reviews');
        $this->description 	= $this->l('Create a gallery of images for your press review. Module for PrestaShop 1.5.x');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');        

    }

    public function install()
    {	     
		return $this->createModule()
			&& parent::install()
			&& $this->registerHook('header')
			&& Configuration::updateValue('PR_THUMB_WIDTH', '210')
			&& Configuration::updateValue('PR_THUMB_HEIGHT', '210')
			&& Configuration::updateValue('PR_INTRO_TEXT', array())
			&& Configuration::updateValue('PR_ITEMS_PER_PAGE', '12')
			&& Configuration::updateValue('PR_ELEMENTS_DISPLAY', serialize(array('PR_ELEMENTS_DISPLAY_title' => 'on', 'PR_ELEMENTS_DISPLAY_date' => 'on')))
			&& Configuration::updateValue('PR_ORDER', 'd_desc');
    }
    
    public function uninstall()
    {
		return $this->delModule()
			&& parent::uninstall()
			&& Configuration::deleteByName('PR_THUMB_WIDTH')
			&& Configuration::deleteByName('PR_THUMB_HEIGHT')
			&& Configuration::deleteByName('PR_INTRO_TEXT')
			&& Configuration::deleteByName('PR_ITEMS_PER_PAGE')
			&& Configuration::deleteByName('PR_ELEMENTS_DISPLAY')
			&& Configuration::deleteByName('PR_ORDER');
    }
    
    private function createModule() 
    {
		$statements = array();

		$statements[] 	= "DROP TABLE IF EXISTS `"._DB_PREFIX_."pressreviews`";
		$statements[] 	= "DROP TABLE IF EXISTS `"._DB_PREFIX_."pressreviews_lang`";
		
		$statements[] 	= "CREATE TABLE `"._DB_PREFIX_."pressreviews` ("
						. "`id_pressreviews` int(11) NOT NULL AUTO_INCREMENT,"
						. "`position` int(11) NOT NULL,"
						. "`active` tinyint(1) NOT NULL,"
						. "`type` enum('lightbox','link') NOT NULL,"
						. "`creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
						. "PRIMARY KEY (`id_pressreviews`)"
						. ") ENGINE="._MYSQL_ENGINE_.";";
						
		$statements[] 	= "CREATE TABLE `"._DB_PREFIX_."pressreviews_lang` ("
						. "`id_pressreviews_lang` int(11) NOT NULL AUTO_INCREMENT,"
						. "`id_pressreviews` int(11) NOT NULL,"
						. "`id_lang` int(11) NOT NULL,"
						. "`title` varchar(255) NOT NULL,"
						. "`thumb_txt` varchar(255) NOT NULL,"
						. "`big_txt` varchar(255) NOT NULL,"
						. "`link` text NOT NULL,"
						. "PRIMARY KEY (`id_pressreviews_lang`)"
						. ") ENGINE="._MYSQL_ENGINE_.";";

		foreach ($statements as $statement) {
			if (!Db::getInstance()->Execute($statement)) {
				return false;
			}
		}

		Db::getInstance()->insert("tab", array(
			'id_parent'		=> (int)0,
			'class_name'	=> 'AdminPressReviews',
			'module'		=> 'pressreviews',
			'position'		=> (int)12,
			'active'		=> (int)1
		));
		
		$newTab = Db::getInstance()->getRow("SELECT * FROM `"._DB_PREFIX_."tab` WHERE `class_name` = 'AdminPressReviews' AND `id_parent` = 0");
		
		Db::getInstance()->insert("tab", array(
			'id_parent'		=> (int)$newTab['id_tab'],
			'class_name'	=> 'AdminPressReviews',
			'module'		=> 'pressreviews',
			'position'		=> (int)1,
			'active'		=> (int)1
		));
		
		$this->context->controller->getLanguages();
		foreach ($this->context->controller->_languages as $language)
		{
			if($language['iso_code'] == 'en') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Press review'
				));
			}
			elseif($language['iso_code'] == 'gb') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Press review'
				));
			}
			elseif ($language['iso_code'] == 'de') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Presserundschau'
				));
			}
			elseif ($language['iso_code'] == 'es') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Revista de prensa'
				));
			}
			elseif ($language['iso_code'] == 'fr') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Revue de presse'
				));
			}
			elseif ($language['iso_code'] == 'it') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Rassegna stampa'
				));
			}
			else {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Press review'
				));
			}
		}
		
		$newUnderTab = Db::getInstance()->getRow("SELECT * FROM `"._DB_PREFIX_."tab` WHERE `class_name` = 'AdminPressReviews' AND `id_parent` != 0");

		foreach ($this->context->controller->_languages as $language)
		{
			if($language['iso_code'] == 'en') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newUnderTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Press review'
				));
			}
			elseif($language['iso_code'] == 'gb') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newUnderTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Press review'
				));
			}
			elseif ($language['iso_code'] == 'de') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newUnderTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Presserundschau'
				));
			}
			elseif ($language['iso_code'] == 'es') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newUnderTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Revista de prensa'
				));
			}
			elseif ($language['iso_code'] == 'fr') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newUnderTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Revue de presse'
				));
			}
			elseif ($language['iso_code'] == 'it') {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newUnderTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Rassegna stampa'
				));
			}
			else {
				Db::getInstance()->insert("tab_lang", array(
					'id_tab'	=> (int)$newUnderTab['id_tab'],
					'id_lang'	=> (int)$language['id_lang'],
					'name'		=> 'Press review'
				));
			}
		}
		
		$dirs =  array(_PS_IMG_DIR_.'pr/thumb/', _PS_IMG_DIR_.'pr/big/');
		
		foreach ($dirs as $dir) {
			if(!is_dir($dir))
				mkdir($dir, 0777, true);
		}
		
		
		Db::getInstance()->insert("meta", array(
			'page'	=> 'module-pressreviews-default'
		));
        $id_page = Db::getInstance()->Insert_ID();
		
		foreach ($this->context->controller->_languages as $language)
		{
			/*if($language['iso_code'] == 'en') {
				Db::getInstance()->insert("meta_lang", array(
					'id_meta'		=> 	(int)$id_page,
					'id_shop'		=> 	(int)$this->context->shop->id,
					'id_lang'		=>	(int)$language['id_lang'],
					'title'			=>	'Press review',
					'description'	=>	'Our press review',
					'keywords'		=>	'press, review',
					'url_rewrite'	=>	'press-review'
				));
			}*/
			if($language['iso_code'] == 'gb') {
				Db::getInstance()->insert("meta_lang", array(
					'id_meta'		=> 	(int)$id_page,
					'id_shop'		=> 	(int)$this->context->shop->id,
					'id_lang'		=>	(int)$language['id_lang'],
					'title'			=>	'Press review',
					'description'	=>	'Our press review',
					'keywords'		=>	'press, review',
					'url_rewrite'	=>	'press-review'
				));
			}
			elseif ($language['iso_code'] == 'de') {
				Db::getInstance()->insert("meta_lang", array(
					'id_meta'		=> 	(int)$id_page,
					'id_shop'		=> 	(int)$this->context->shop->id,
					'id_lang'		=>	(int)$language['id_lang'],
					'title'			=>	'Presserundschau',
					'description'	=>	'Unsere Presserundschau',
					'keywords'		=>	'Presserundschau',
					'url_rewrite'	=>	'presserundschau'
				));
			}
			elseif ($language['iso_code'] == 'es') {
				Db::getInstance()->insert("meta_lang", array(
					'id_meta'		=> 	(int)$id_page,
					'id_shop'		=> 	(int)$this->context->shop->id,
					'id_lang'		=>	(int)$language['id_lang'],
					'title'			=>	'Revista de prensa',
					'description'	=>	'Nuestra revista de prensa',
					'keywords'		=>	'Revista, prensa',
					'url_rewrite'	=>	'revista-de-prensa'
				));
			}
			elseif ($language['iso_code'] == 'fr') {
				Db::getInstance()->insert("meta_lang", array(
					'id_meta'		=> 	(int)$id_page,
					'id_shop'		=> 	(int)$this->context->shop->id,
					'id_lang'		=>	(int)$language['id_lang'],
					'title'			=>	'Revue de presse',
					'description'	=>	'Notre revue de presse',
					'keywords'		=>	'revue, presse',
					'url_rewrite'	=>	'revue-de-presse'
				));
			}
			elseif ($language['iso_code'] == 'it') {
				Db::getInstance()->insert("meta_lang", array(
					'id_meta'		=> 	(int)$id_page,
					'id_shop'		=> 	(int)$this->context->shop->id,
					'id_lang'		=>	(int)$language['id_lang'],
					'title'			=>	'Rassegna stampa',
					'description'	=>	'Rassegna, stampa',
					'keywords'		=>	'la nostra rassegna stampa',
					'url_rewrite'	=>	'rassegna-stampa'
				));
			}
			else {
				Db::getInstance()->insert("meta_lang", array(
					'id_meta'		=> 	(int)$id_page,
					'id_shop'		=> 	(int)$this->context->shop->id,
					'id_lang'		=>	(int)$language['id_lang'],
					'title'			=>	'Press review',
					'description'	=>	'Our press review',
					'keywords'		=>	'press, review',
					'url_rewrite'	=>	'press-review'
				));
			}
		}

		return true;
	}
	
	private function delModule() 
	{
		$statements[] 	= "DROP TABLE IF EXISTS `"._DB_PREFIX_."pressreviews`";
		$statements[] 	= "DROP TABLE IF EXISTS `"._DB_PREFIX_."pressreviews_lang`";
		
		foreach ($statements as $statement) {
			if (!Db::getInstance()->Execute($statement)) {
				return false;
			}
		}
		
		$tabs = Db::getInstance()->ExecuteS("SELECT * FROM `"._DB_PREFIX_."tab` WHERE `class_name` = 'AdminPressReviews'");
		
		foreach ($tabs as $tab) {
			Db::getInstance()->delete("tab_lang", "id_tab = ".$tab['id_tab']);
		}
		
		Db::getInstance()->delete("tab", "class_name = 'AdminPressReviews'");
		
		$metas = Db::getInstance()->getRow("SELECT * FROM `"._DB_PREFIX_."meta` WHERE `page` = 'module-pressreviews-default'"); 
		if($metas['id_meta']) {
			Db::getInstance()->delete("meta_lang", "id_meta = ".$metas['id_meta']);
			Db::getInstance()->delete("meta", "id_meta = ".$metas['id_meta']);
		}
		
		$dirs =  array(_PS_IMG_DIR_.'pr/thumb/', _PS_IMG_DIR_.'pr/big/', _PS_IMG_DIR_.'pr/');
		
		foreach ($dirs as $dir) {
			if(is_dir($dir))
				$this->delDir($dir);
		}
		
		
		
		return true;
	}
	
	private function delDir($dir) {
		if (is_dir($dir)) { 
			$objects = scandir($dir); 
			foreach ($objects as $object) { 
				if ($object != "." && $object != "..") { 
					if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
				} 
			} 
			reset($objects); 
			rmdir($dir); 
		} 
	}
    
    
    public function getContent()
    {
    	$base = ((Configuration::get('PS_SSL_ENABLED') == 1) ? _PS_BASE_URL_SSL_ : _PS_BASE_URL_);
    	$metas = new Meta();
    	$seo_url = $metas->getMetaByPage('module-pressreviews-default', $this->context->language->id);
        $output = '<div class="hint clear" style="display: block;">
        <b>'.$this->l('Informations').'</b>
        	<br />
        	<ul>
        		<li>&nbsp;</li>
        		<li>'.$this->l('The gallery is available here:').' '.$base.__PS_BASE_URI__.$this->context->language->iso_code.'/'.$seo_url['url_rewrite'].'</li>
        		<li>&nbsp;</li>
        		<li>
        			<a href="'.(($this->context->language->iso_code == 'fr') ? $this->_path.'docs/readme_fr.pdf' : $this->_path.'docs/readme_en.pdf').'" target="_blank">'.$this->l('Click here to see the documentation').'</a>
        		</li>
        	</ul>
        </div>
        <br />';
     
        if (Tools::isSubmit('submit'.$this->name))
        {
            $pr_thumb_width = strval(Tools::getValue('PR_THUMB_WIDTH'));
            $pr_thumb_height = strval(Tools::getValue('PR_THUMB_HEIGHT'));
            $pr_items_per_page = strval(Tools::getValue('PR_ITEMS_PER_PAGE'));
            $pr_order = strval(Tools::getValue('PR_ORDER'));
            
            $this->context->controller->getLanguages();
            foreach ($this->context->controller->_languages as $language)
            {
            	$pr_intro_text[$language['id_lang']] = Tools::getValue('PR_INTRO_TEXT_'.$language['id_lang']);
            }
            
            $pr_element_display = array(
            	'PR_ELEMENTS_DISPLAY_title'	=>	strval(Tools::getValue('PR_ELEMENTS_DISPLAY_title')),
            	'PR_ELEMENTS_DISPLAY_date'	=>	strval(Tools::getValue('PR_ELEMENTS_DISPLAY_date')),
            );
            
            if ((!$pr_thumb_width || empty($pr_thumb_width) || !Validate::isInt($pr_thumb_width)) 
            && (!$pr_thumb_height || empty($pr_thumb_height) || !Validate::isInt($pr_thumb_height)))
                $output .= $this->displayError( $this->l('Invalid Configuration value') );
            else
            {
                Configuration::updateValue('PR_THUMB_WIDTH', $pr_thumb_width); 
                Configuration::updateValue('PR_THUMB_HEIGHT', $pr_thumb_height);
                Configuration::updateValue('PR_INTRO_TEXT', $pr_intro_text, true);
                Configuration::updateValue('PR_ITEMS_PER_PAGE', $pr_items_per_page);
                Configuration::updateValue('PR_ELEMENTS_DISPLAY', serialize($pr_element_display));
                Configuration::updateValue('PR_ORDER', $pr_order);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }
        return $output.$this->displayForm();
    }
    
    public function displayForm()
    {
        // Get default Language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $this->fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Module configuration'),
                'image' => '../modules/pressreviews/img/add.png',
            ),
            'input' => array(
            	array(
            	  'type'		=> 'select',
            	  'label'    	=> $this->l('Items per page'),
            	  'name'      	=> 'PR_ITEMS_PER_PAGE',
            	  'options' => array(
	    	          'query' => array(
	    	          				array(
	    	          					'id' => '12', 
	    	          					'name' => '12'
	    	          				),
	    	          				array(
	    	          					'id' => '24', 
	    	          					'name' => '24'
	    	          				),
	    	          				array(
	    	          					'id' => '36', 
	    	          					'name' => '36'
	    	          				),
	    	          				array(
	    	          					'id' => '0', 
	    	          					'name' => $this->l('No pagination')
	    	          				)
	    	          			),
						'id' => 'id',
						'name' => 'name'
	    	        ),
            	  'desc'       	=> $this->l('How many items to display on the page ?'),
            	  'lang'		=> false,
            	),
            	array(
	        		'type'		=> 'checkbox',
	        		'label'    	=> $this->l('Elements to display'),
	        		'name'      	=> 'PR_ELEMENTS_DISPLAY',
	        		'values' => array(
		    				'query'	=>	array(
		    					array(
		    						'id' => 'title', 
		    						'name' => $this->l('Title')
		    					),
		    					array(
		    						'id' => 'date', 
		    						'name' => $this->l('Date')
		    					)
		    				),
		    				'id' => 'id',
		    				'name'	=> 'name'
	        		  ),
	        		'desc'       	=> $this->l('Elements to display on every items'),
            	),
            	array(
            	  'type'		=> 'select',
            	  'label'    	=> $this->l('Order'),
            	  'name'      	=> 'PR_ORDER',
            	  'options' => array(
            	      'query' => array(
            	      				array(
            	      					'id' => 'd_asc', 
            	      					'name' => $this->l('Date Ascending (Older to Newer)')
            	      				),
            	      				array(
            	      					'id' => 'd_desc', 
            	      					'name' => $this->l('Date Descending (Newer to Older)')
            	      				),
            	      				array(
            	      					'id' => 'p_asc', 
            	      					'name' => $this->l('Position Ascending (Upper to Lower)')
            	      				),
            	      				array(
            	      					'id' => 'p_desc', 
            	      					'name' => $this->l('Position Descending (Lower to Upper)')
            	      				),
            	      			),
            			'id' => 'id',
            			'name' => 'name'
            	    ),
            	  'lang'		=> false,
            	),
            ),
            
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button'
            )
        );	

        $this->fields_form[1]['form'] = array(
            'legend' => array(
                'title' => $this->l('Thumbnail configuration'),
                'image' => '../modules/pressreviews/img/add.png',
            ),
            'input' => array(
            	array(
            	  'type'		=> 'text',
            	  'label'    	=> $this->l('Thumbnail width'),
            	  'name'      	=> 'PR_THUMB_WIDTH',
            	  'size'       	=> 10,
            	  'required' 	=> true,
            	  'suffix'		=> 'px',
            	  'hint'       	=> $this->l('Enter the thumbnail width in pixels'),
            	  'desc'       	=> $this->l('Thumbnail width'),
            	  'lang'		=> false,
            	),
            	array(
            	  'type'       	=> 'text',
            	  'label'    	=> $this->l('Thumbnail height'),
            	  'name'       	=> 'PR_THUMB_HEIGHT',
            	  'size'       	=> 10,
            	  'required' 	=> true,
            	  'suffix'		=> 'px',
            	  'hint'       	=> $this->l('Enter the thumbnail height in pixels'),
            	  'desc'       	=> $this->l('Thumbnail height'),
            	  'lang'		=> false,
            	),    
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button'
            )
        );
        
        $this->fields_form[2]['form'] = array(
        	'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Introductory text'),
                'image' => '../modules/pressreviews/img/add.png',
            ),
            'input' => array(
            	array(
            	  'type'		 => 'textarea',
            	  'label'    	 => $this->l('Introductory text'),
            	  'name'      	 => 'PR_INTRO_TEXT',
            	  'required' 	 => false,
            	  'lang'		 => true,
            	  'autoload_rte' => true,
            	  'cols'		 => 40,
            	  'rows'		 => 5,
            	  'hint' 		 => $this->l('Invalid characters:').' <>;=#{}',
            	  'desc'       	 => $this->l('Introductory text'),
            	),  
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'button'
            )
        );
         
        $helper = new HelperForm();
         
        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->identifier = $this->identifier;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
         
        // Language        
        $languages = Language::getLanguages(false);
        		foreach ($languages as $k => $language)
        			$languages[$k]['is_default'] = (int)($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'));
        
		$helper->languages = $languages;
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = true;
		
        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = array(
            'save' =>
            array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules'),
                'class'	=> 'save',
                'imgclass' => 'save'
            ),
            'back' => array(
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list'),
                'class' => 'back',
                'imgclass' => 'back',
            )
        );
        
        /* Load checkboxes */
		$uns = Tools::unSerialize(Configuration::get('PR_ELEMENTS_DISPLAY'));

        // Load current value
        $helper->fields_value = array(
        		'PR_THUMB_WIDTH'  => Configuration::get('PR_THUMB_WIDTH'),
        		'PR_THUMB_HEIGHT'  => Configuration::get('PR_THUMB_HEIGHT'),
        		'PR_INTRO_TEXT'  => array(),
        		'PR_ITEMS_PER_PAGE'	=>	Configuration::get('PR_ITEMS_PER_PAGE'),
        		'PR_ELEMENTS_DISPLAY_title'	=>	$uns['PR_ELEMENTS_DISPLAY_title'],
        		'PR_ELEMENTS_DISPLAY_date'	=>	$uns['PR_ELEMENTS_DISPLAY_date'],
        		'PR_ORDER'	=> Configuration::get('PR_ORDER'),
        );      
        
        $this->context->controller->getLanguages();
        foreach ($this->context->controller->_languages as $language)
        {
        	$helper->fields_value['PR_INTRO_TEXT'][$language['id_lang']] = Configuration::get('PR_INTRO_TEXT', $language['id_lang']);
        }
        
        
        
        return $helper->generateForm($this->fields_form);
    }

	public static function setOnTop() {
		$sql = 'UPDATE `'._DB_PREFIX_.'pressreviews`
				SET `position` = position + 1';
		$addOne = DB::getInstance()->execute($sql);
		
		return $addOne;
	}
		
	public static function getHigherPosition()
	{
		$sql = 'SELECT MAX(`position`)
				FROM `'._DB_PREFIX_.'pressreviews`';
		$position = DB::getInstance()->getValue($sql);
		print_r($position);
		return (is_numeric($position)) ? $position : -1;
	}
}

?>