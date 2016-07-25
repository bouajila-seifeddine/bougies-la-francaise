<?php
/*************************************
/* contentBox for prestashop
/* Made By Miguel Costa for emotionLoop
/* http://emotionloop.com
/* http://contentbox.org/
/*
/***********************************/
if ( !defined( '_PS_VERSION_' ) ) {
	exit;		
}


class contentbox extends Module {
	function __construct() {
		$this->name = 'contentbox';
		$this->description = 'Place your content everywhere!';
		$this->tab = 'front_office_features';
		$this->version = '1.0.2';
		$this->author = 'emotionLoop';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');
		$this->monolanguageContent = 'CONTENTBOX_MONOLANGUAGE';
		$this->textEditorContent = 'CONTENTBOX_TEXTEDITOR';
		$this->bootstrap = true;
		$this->_html = '';
		$this->completeContentFilesLocation = dirname(__FILE__).'/content/'; 
		$this->simpleContentFilesLocation = $this->_path.'content/'; 

		parent::__construct();

		$this->displayName = $this->l('contentBox');
		$this->description = $this->l('Place your content everywhere!');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

		//store selection
		$this->selectedStoreId = ( isset( $_POST[ 'contentbox_shop_select' ] ) 
								&& !empty( $_POST[ 'contentbox_shop_select' ] ) ) 
								? (int)$_POST[ 'contentbox_shop_select' ]
								: $this->context->shop->id;
		//language selection
		$postedMonoLanguage = (isset( $_POST['monolanguage'] ))? (int)$_POST['monolanguage'] : null;
		if ( Configuration::get( $this->monolanguageContent ) || !empty( $postedMonoLanguage ) ) {
			$this->selectedLanguageId = (int)Configuration::get('PS_LANG_DEFAULT');
		} else {
			$this->selectedLanguageId = ( isset( $_POST[ 'contentbox_language_select' ] )
									&& !empty( $_POST[ 'contentbox_language_select' ] ) ) 
									? (int)$_POST[ 'contentbox_language_select' ]
									: $this->context->language->id;
		}
	}

	public function install() {
		if (Shop::isFeatureActive()) {
			Shop::setContext(Shop::CONTEXT_ALL);
		}

		if (!parent::install()
			|| !$this->registerHook('header')
			|| !$this->registerHook('footer')
			|| !contentboxModel::createTables()
		) {
			return false;		
		}

		Configuration::updateValue($this->monolanguageContent, 0);
		Configuration::updateValue($this->textEditorContent, 1);

		$this->_clearCache('contentbox.tpl');

		
		return true;
	}

	public function uninstall() {
		$this->_clearCache('contentbox.tpl');
		if (!parent::uninstall() 
			|| !contentboxModel::DropTables() ) {

			Configuration::deleteByName($this->monolanguageContent);
			Configuration::deleteByName($this->textEditorContent);

			return false;		
		}
		return true;
	}

	public function __call($method, $args) {
		//if method exists
		if(function_exists($method)) { 
			return call_user_func_array($method, $args);
		}

		//if head hook: add the css and js files
		if ( $method == 'hookdisplayHeader' ) {
			return $this->hookHeader( $args[0] );
		}

		//check for a call to an hook
		if ( strpos($method, 'hook') !== false ) {
			return $this->genericHookMethod( $args[0] );
		}

	}

	public function addFilesToTemplate( $path = null ) {
		$result = true;
		//list the active files to add
		$filesData = contentboxModel::getFilesInUse( $this->selectedStoreId, $this->selectedLanguageId );
		if ( empty( $filesData ) || !isset( $filesData['files'] ) ) {
			return $result;
		}

		$files = json_decode( $filesData['files'] );

		if ( empty( $files ) ) {
			return $result;
		}
		if ( empty( $path ) ) {
			$path = $this->simpleContentFilesLocation;
		}

		foreach ($files as $file) {
			switch( $file->extension ) {
				case 'js':
					$this->context->controller->addJs($path.'/'.$file->name, 'all');
				break;
				case 'css':
					$this->context->controller->addCss($path.'/'.$file->name, 'all');
				break;
			}
		}

	}
	public function genericHookMethod($params) {
		$content = '';
		$contentQuery = contentboxModel::getContent( $this->selectedStoreId, $this->selectedLanguageId );
		$this->context->smarty->assign(
				array( 'content' => $contentQuery['content_text'] )
			);
		return $this->display(__FILE__, $this->name.'.tpl');
		
	}

	public function hookHeader($params) {
		$this->addFilesToTemplate( $this->_path.'content/' );
	}

	public function getContent() {

		if ( !is_writable( $this->completeContentFilesLocation ) ){
			$this->_html .= $this->displayError( 'FOLDER PERMISSIONS ERROR: <br/>writing access denied on '.$this->simpleContentFilesLocation.' <br/> ' );
		}

		$this->processSubmit();
		return $this->displayForm();
	}

	public function processSubmit() {

		if (Tools::isSubmit('submit'.$this->name)) {
			//remove file 
			if ( isset( $_POST['delete_file'] ) && !empty( $_POST['delete_file'] ) ){
				$tmp_file = strip_tags($_POST['delete_file']);
				unlink($this->completeContentFilesLocation.$tmp_file);
				$this->_html .= $this->displayConfirmation( 'File Deleted' );
			}

			//if change shop or change language submit
			if ( isset( $_POST['ignore_changes'] ) && !empty( $_POST['ignore_changes'] ) ) {
				return true;
			}

			//upload file
			if ( isset( $_FILES['upload_file'] ) 
				&& isset( $_FILES['upload_file']['tmp_name'] ) 
				&& !empty( $_FILES['upload_file']['tmp_name']) 
				&& $_FILES['upload_file']['error'] == UPLOAD_ERR_OK ) {
				$this->processFileUpload();
			}

			//if the posted language different from the current language -> ignore content changes 
			if ( 
				(isset( $_POST[ 'contentbox_language_select' ] ) && (int)$_POST[ 'contentbox_language_select' ] == $this->selectedLanguageId )
				||
				(!isset( $_POST[ 'contentbox_language_select' ] ) && (int)Configuration::get('PS_LANG_DEFAULT') == $this->selectedLanguageId)
				) {
				//store the content
				if ( isset( $_POST['content_text'] ) ) {
					contentboxModel::setContent( $_POST['content_text'] , $this->selectedStoreId, $this->selectedLanguageId );
				}
				//store the files to be used
				if ( isset( $_POST['headerFiles'] ) ) {			
					contentboxModel::setFiles( $this->processFilesList( $_POST['headerFiles'], true ) , $this->selectedStoreId, $this->selectedLanguageId );
				}
			}

			//store the developer configurations
			if ( isset( $_POST['monolanguage'] ) ) {
				Configuration::updateValue($this->monolanguageContent, (int)$_POST['monolanguage']);
			}
			
			if ( isset( $_POST['use_editor'] ) ) {
				Configuration::updateValue($this->textEditorContent, (int)$_POST['use_editor']);
			}

		}
	}
	private function processFileUpload(){
		//test files folder permissions
		if ( !is_writable( $this->completeContentFilesLocation ) ) {
			return false;
		}

		if(file_exists($this->completeContentFilesLocation . $_FILES["upload_file"]["name"])){
			$tmp_name = explode('.',$_FILES["upload_file"]["name"]);
			$tmp_ext = end($tmp_name);
			array_pop($tmp_name);
			$tmp_name = implode('.',$tmp_name);
			$tmp_new_img_name = $this->completeContentFilesLocation.$tmp_name;
			
			$control_loop = false;
			$tmp_i = 1;
			while ($control_loop == false){
				if(file_exists($tmp_new_img_name.'('.$tmp_i.').'.$tmp_ext )){
					++ $tmp_i;
				}else{ 
					$_FILES["upload_file"]["name"] = $tmp_name.'('.$tmp_i.').'.$tmp_ext; 
					$control_loop = true;
				}
			}
		}

		$moveResult = move_uploaded_file($_FILES['upload_file']['tmp_name'], $this->completeContentFilesLocation.$_FILES['upload_file']['name']);
		if( empty( $moveResult ) ) {
			$this->_html .= $this->displayError( 'UPLOAD ERROR: <br/> There was an unknown error. Please try again.<br/> ' );
		} else {
			$this->_html .= $this->displayConfirmation( 'File Uploaded' );
		};	
	}

	public function displayForm() {
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

		//use text editor
		$useTextEditor = (int)Configuration::get($this->textEditorContent);
		$shopsList = $this->getShopsList();
		$languagesList = $this->getLanguagesList();
		$filesList = $this->getFiles();

		$fields_form[]['form'] = array(
				'input' => array(
					array(
						'type' => 'topform',
						'shops' => $shopsList,
						'current_shop_id' => $this->selectedStoreId,
						'languages' => $languagesList,
						'current_language_id' => $this->selectedLanguageId,
						'monolanguage' => Configuration::get($this->monolanguageContent),
						'label' => ';)',
						'logoImg' => $this->_path.'img/contentbox_logo.png',
						'moduleName' => $this->displayName,
						'moduleDescription' => $this->description,
						'moduleVersion' => $this->version,
					),
				),
			);
		$fields_form[]['form'] = array(
				'tinymce' => true,
				'legend' => array(
					'title' => $this->l('Content Configuration'),
				),
				'input' => array(
					array(
						'type' => 'textarea',
						'name' => 'content_text',
						'label' => $this->l("Module's Content"),
						'cols' => 50,
						'rows' => 20,
						'class' => ( !empty( $useTextEditor ) )? 'rte' : '',
						'autoload_rte' => ( !empty( $useTextEditor ) )? true :false,
					),
					array(
						'type' => 'files_area',
						'label' => $this->l("Module's Files"),
						'files' =>  $filesList,
						'path' => $this->_path,
						'imagesExtensions' => array( 'jpg','gif','png' ),
					),
					array(
						'type' => 'file',
						'name' => 'upload_file',
						'path' => $this->_path,
						'imagesExtensions' => array( 'jpg','gif','png' ),
					),

				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
			);

		$fields_form[]['form'] = array(
				'legend' => array(
					'title' => $this->l('Developer Configurations'),
				),
				'input' => array(
					array(
						'type' => 'select',
						'name' => 'monolanguage',
						'label' => $this->l('Use only the main language settings'),
						'options' => array(
							'query' => array(
								array(
									'value' => 0,
									'text' => $this->l('No'),
								),
								array(
									'value' => '1',
									'text' => $this->l('Yes'),
								),
							),
							'id' => 'value',
							'name' => 'text'
						)
					),
					array(
						'type' => 'select',
						'name' => 'use_editor',
						'label' => $this->l('Use Text Editor'),
						'options' => array(
							'query' => array(
								array(
									'value' => 0,
									'text' => $this->l('No'),
								),
								array(
									'value' => '1',
									'text' => $this->l('Yes'),
								),
							),
							'id' => 'value',
							'name' => 'text'
						)
					),
					array(
						'type' => 'select',
						'name' => 'headerFiles[]',
						'label' => $this->l('Load Files on HTML Header'),
						'desc' => $this->l('Please select above the files to be used.'),
						'multiple' => true,
						'options' => array(
							'query' => $this->filterFiles( $filesList, true ),
							'id' => 'name',
							'name' => 'name'
						)
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
			);
		$helper = new HelperForm();

		// Module, t    oken and currentIndex
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
		
		// Language
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;
		
		// Title and toolbar
		$helper->title = $this->displayName;
		$helper->show_toolbar = true;	 // false -> remove toolbar
		$helper->toolbar_scroll = true;	 // yes - > Toolbar is always visible on the top of the screen.
		$helper->submit_action = 'submit'.$this->name;
		$helper->toolbar_btn = array(
			'save' =>
				array(
					'desc' => $this->l('Save'),
					'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
					'&token='.Tools::getAdminTokenLite('AdminModules'),
				),
			'back' => array(
				'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
				'desc' => $this->l('Back to list')
			)
		);
		// Load current value
		$contentQuery = contentboxModel::getContent( $this->selectedStoreId, $this->selectedLanguageId );

		$contentField = ( !empty( $contentQuery ) )? $contentQuery[ 'content_text' ] : '';

		$helper->fields_value['content_text'] = $contentField;

		$helper->fields_value['monolanguage'] = Configuration::get($this->monolanguageContent);
		$helper->fields_value['use_editor'] = $useTextEditor;

		$helper->fields_value['headerFiles[]'] = $this->processSelectFilesForMultiselect( 
																contentboxModel::getFilesInUse( $this->selectedStoreId, $this->selectedLanguageId ) 
																);
		Tools::addJs($this->_path.'/js/contentbox.js');
		Tools::addCss($this->_path.'/css/contentbox.css');
		return $this->_html.$helper->generateForm($fields_form);
	}

	private function filterFiles( $files = array(), $addEmpty = false, $acceptedFiles = array( 'css', 'js' ) ){
		$result = array();

		$result[] = array( 'name' => 'none' );

		foreach ($files as $file) {
			if ( in_array( $file['extension'], $acceptedFiles ) ) {
				$result[] = $file;
			}
		}
		return $result;
	}

	private function processSelectFilesForMultiselect( $filesData = array(), $emptyValue = 'none' ){
		if ( isset( $filesData['files'] ) ) {
			$filesData = $filesData['files'];
		}

		$filesType = gettype( $filesData );

		$files = ( $filesType == 'string' )? json_decode($filesData) : $filesData;
		
		$result = array();
		foreach ($files as $file) {
				$result[] = ( is_object( $file ) )? $file->name : $file['name'];
		}

		if ( empty( $result ) ) {
			$result[] = 'none';
		}

		return $result;
	}
	private function getLanguagesList() {
		$languagesList = array();
		$langs = Language::getLanguages(false);
		foreach ( $langs as $lang ) {
			$languagesList[] = array( 'id_lang' => $lang['id_lang'], 'name' => $lang['name'] );
		}
		return $languagesList;
	}

	private function getShopsList() {
		$shopsList = array();
		$shops = Shop::getShops();
		foreach ( $shops as $shop ) {
			$shopsList[] = array( 'id_shop' => $shop[ 'id_shop' ], 'name' => $shop[ 'name' ] );
		}
		return $shopsList;
	}

	private function getFiles(){
		$tmp_files_info = array();

		$handle = opendir($this->completeContentFilesLocation);
		
		while (false !== ($file = readdir($handle))) {
			if ( $file == '.' || $file == '..' ) {
				continue;
			}
			$tmp_files_info[] = $this->extractFileInfo( $file );
		}
		closedir($handle);
		sort($tmp_files_info);

		return $tmp_files_info; 
	}

	private function processFilesList( $filesList, $joinByExtension = false ) {

		if ( !is_array( $filesList ) ) {
			return array();
		}

		$dataOut = array();
		foreach ($filesList as $file) {
			$dataOut[] = $this->extractFileInfo( $file );
		}

		if ( !empty( $joinByExtension ) ) {
			$tempContainer = array();
			//group by extension
			foreach ($dataOut as $file) {
				if ( !isset( $tempContainer[ $file['extension'] ] ) ) {
					$tempContainer[ $file['extension'] ] = array();
				}
				$tempContainer[ $file['extension'] ][ $file['name'] ] = $file;
			}
			//create new dataOut
			$dataOut = array();
			foreach( $tempContainer as $extension => $filesArray ) {
				$dataOut = array_merge( $dataOut, $filesArray );
			}
		}

		return $dataOut;
	}

	private function extractFileInfo( $fileName = null ) {
		if ( empty( $fileName ) ) {
			return $fileName;
		}

		$extension = pathinfo( $fileName, PATHINFO_EXTENSION );
		return array( 'name'=> $fileName, 'extension'=> $extension);
	}

}


/**
* The model in the same file because of the module generator
*/

class contentboxModel extends ObjectModel {

	public static $definition = array(
		'table' => 'contentbox',
		'primary' => 'file_id',
		'multishop' => true,
		'multilang' => true,
		'fields' => array(
			'file_id' =>       array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'file_name' =>    		array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true,'size' => 255),
			'file_type' =>		    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'id_store' =>      array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true)
		),
	);

	public static function createTables() {
		//main table for the files
		return ( contentboxModel::createFilesTable()
				&& contentboxModel::createContentTable());
	}

	public static function dropTables() {
		$sql = 'DROP TABLE
			`'._DB_PREFIX_. self::$definition['table'].'_files`,
			`'._DB_PREFIX_. self::$definition['table'].'`
		';
		$result = Db::getInstance()->execute($sql);
		return $result;
	}

	public static function createContentTable() {
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_. self::$definition['table'] .'`(
			`content_id` int(10) unsigned NOT NULL auto_increment,
			`content_text` text NOT NULL,
			`id_lang` int(10) unsigned NOT NULL,
			`id_store` int(10) unsigned NOT NULL default \'1\',
			PRIMARY KEY (`content_id`),
			UNIQUE KEY `id_lang_id_store` (`id_lang`,`id_store`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

		return Db::getInstance()->execute($sql);
	}

	public static function setContent( $content_text = null, $id_store = 1, $id_lang = null ){
		//special thanks to MarkOG (http://www.prestashop.com/forums/user/817367-markog/)
		$content_text = pSQL( $content_text, true );
		$id_lang = (int)$id_lang;
		$id_store = (int)$id_store;
		$sql = 'INSERT INTO `'._DB_PREFIX_. self::$definition['table'].'` (`content_text`,`id_lang`,`id_store`) 
					VALUES ("'. $content_text .'","'. $id_lang .'","'. $id_store .'")
					ON DUPLICATE KEY UPDATE `content_text` = "'. $content_text .'"
				';

		return Db::getInstance()->execute( $sql );
	}
	
	public static function getContent( $shop, $language ){
		$sql = 'SELECT * FROM '._DB_PREFIX_. self::$definition['table'].' WHERE `id_lang` = "'. (int)$language .'" and `id_store`="'. (int)$shop .'"';
		return Db::getInstance()->getRow($sql);
	}

	public static function createFilesTable() {
		//file_type 0 =>css, 1=> js, 2=>html
		$sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_. self::$definition['table'] .'_files`(
			`id` int(10) unsigned NOT NULL auto_increment,
			`id_store` int(10) unsigned NOT NULL ,
			`id_lang` int(10) unsigned NOT NULL,
			`files` text NOT NULL,
			PRIMARY KEY (`id`),
			UNIQUE KEY `id_lang_id_store` (`id_lang`,`id_store`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

		return Db::getInstance()->execute($sql);
	}

	public static function getFilesInUse( $id_store = 1, $id_lang = 1 )
	{
		$sql = 'SELECT * FROM `'. _DB_PREFIX_. self::$definition['table'] .'_files` where `id_store`='. (int)$id_store .' and `id_lang`='. (int)$id_lang ;
		return Db::getInstance()->getRow($sql);
	}

	public static function setFiles( $filesList = null, $id_store = 1, $id_lang = null ){
		$filesList = json_encode( $filesList );
		$files = pSQL( $filesList );
		$id_lang = (int)$id_lang;
		$id_store = (int)$id_store;

		$sql = 'INSERT INTO `'._DB_PREFIX_. self::$definition['table'].'_files` (`files`,`id_lang`,`id_store`) 
					VALUES ("'. $files .'","'. $id_lang .'","'. $id_store .'")
					ON DUPLICATE KEY UPDATE `files` = "'. $files .'"
				';

		return Db::getInstance()->execute( $sql );
	}
}