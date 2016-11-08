<?php

if (!function_exists('json_encode')) {
	function json_encode($a=false) {
		if (is_null($a)) return 'null';
		if ($a === false) return 'false';
		if ($a === true) return 'true';
		if (is_scalar($a)) {
			if (is_float($a)) return floatval(str_replace(",", ".", strval($a)));
			if (is_string($a))	{
				static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
				return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
			} else return $a;
		}
		$isList = true;
		for ($i = 0, reset($a); $i < count($a); $i++, next($a)) {
			if (key($a) !== $i) {
				$isList = false;
				break;
			}
		}
		$result = array();
		if ($isList) {
			foreach ($a as $v) $result[] = json_encode($v);
			return '[' . join(',', $result) . ']';
		} else {
			foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
			return '{' . join(',', $result) . '}';
		}
	}
}

class AdvancedSearchClass extends ObjectModel {
	public 		$id;
	public 		$id_hook;
	public 		$active = 1;
	public 		$internal_name;
	public		$description;
	public		$title;
	public		$height;
	public		$width;
	public 		$display_nb_result_on_blc;
	public 		$display_nb_result_criterion;
	public 		$save_selection;
	public 		$remind_selection;
	public 		$show_hide_crit_method;
	public 		$filter_by_emplacement;
	public 		$search_on_stock;
	public 		$hide_empty_crit_group;
	public 		$search_method;
	public 		$step_search;
	public		$dynamic_criterion;
	public 		$priority_on_combination_image;
	public 		$use_cache;
	public 		$products_per_page;
	public 		$products_order_by;
	public 		$products_order_way;
	public 		$background_color;
	public 		$border_color;
	public 		$border_size;
	public 		$color_group_title;
	public		$font_size_group_title;
	public		$border_radius;
	public		$color_title;
	public		$font_size_title;
	public		$keep_category_information;
	public		$display_empty_criteria = 0;
	public		$recursing_indexing;
	public		$share;
	public		$search_results_selector;
	public		$smarty_var_name;
	public		$insert_in_center_column;
	public		$collapsable_criterias;
	public		$unique_search;
	public		$reset_group;
	public		$scrolltop_active = 1;
	public static		$start_indexation = 0;
	public static		$limit_indexation = 1000;
	public static		$current_indexation = 0;

	protected 	$tables = array ('pm_advancedsearch','pm_advancedsearch_lang');

	protected 	$fieldsRequired = array('active','id_hook','internal_name');
 	protected 	$fieldsSize = array('active' => 1);
 	protected 	$fieldsValidate = array('active' => 'isBool');

 	protected 	$fieldsRequiredLang = array();
 	protected 	$fieldsSizeLang = array();
 	protected 	$fieldsValidateLang = array('title'=>'isGenericName','description'=>'isCleanHTML');

	protected 	$table = 'pm_advancedsearch';
	public 	$identifier = 'id_search';

	public static $_valid_hooks = array('home','leftColumn','rightColumn','top');
	public static $_valid_hooks_1_5 = array('displayTop','displayRightColumn','displayLeftColumn','displayHome');
	public static $_valid_hooks_cms = array('leftColumn','rightColumn','top','displayTop','displayRightColumn','displayLeftColumn');
	public static $_valid_hooks_supplier = array('leftColumn','rightColumn','top','displayTop','displayRightColumn','displayLeftColumn');
	public static $_valid_hooks_manufacturer = array('leftColumn','rightColumn','top','displayTop','displayRightColumn','displayLeftColumn');
	public static $_valid_hooks_product = array('leftColumn','rightColumn','top','displayTop','displayRightColumn','displayLeftColumn');
	public static $_valid_hooks_special_page = array('leftColumn','rightColumn','top','displayTop','displayRightColumn','displayLeftColumn');
	public static $_valid_hooks_category = array('leftColumn','rightColumn','top','displayTop','displayRightColumn','displayLeftColumn');

	protected static $_cacheSearchsId = array();
	protected static $_cacheSearchs = NULL;
	protected static $_cacheLeftJoinWhereCriterion = array();

	protected static $producPropertiesCache = array();

	// Compatibility 1.5
	public static $definition = array(
		'table' => 'pm_advancedsearch',
		'primary' => 'id_search',
		'multishop' => true,
		'multilang_shop' => false,
		'fields' => array(
			'title' 		=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'description' 	=> 				array('type' => 3, 'lang' => true, 'required' => false)
		)
	);

	public function __construct($id_search = NULL,$id_lang=NULL, $id_shop = null) {
		// Compatibility 1.5
		if (_PS_VERSION_ >= 1.5) {
			if (version_compare(_PS_VERSION_, '1.5', '>=') && version_compare(_PS_VERSION_, '1.5.2.0', '<=') && class_exists ("ShopPrestaModule")) {
				ShopPrestaModule::PrestaModule_setAssoTable(self::$definition['table']);
			} else {
				Shop::addTableAssociation(self::$definition['table'], array('type' => 'shop'));
			}
			parent::__construct($id_search,$id_lang,$id_shop);
		} else {
			parent::__construct($id_search,$id_lang);
		}
	}

	public function getFields() {
		parent::validateFields();
		if (isset($this->id))
			$fields['id_search'] = intval($this->id);
		$fields['id_hook'] 	= intval($this->id_hook);
		$fields['active'] = intval($this->active);
		$fields['internal_name'] = pSQL($this->internal_name);
		$fields['height'] = intval($this->height);
		$fields['width'] = intval($this->width);
		$fields['display_nb_result_on_blc'] = intval($this->display_nb_result_on_blc);
		$fields['display_nb_result_criterion'] = intval($this->display_nb_result_criterion);
		$fields['save_selection'] = intval($this->save_selection);
		$fields['remind_selection'] = intval($this->remind_selection);
		$fields['show_hide_crit_method'] = intval($this->show_hide_crit_method);
		$fields['filter_by_emplacement'] = intval($this->filter_by_emplacement);
		$fields['search_on_stock'] = intval($this->search_on_stock);
		$fields['hide_empty_crit_group'] = intval($this->hide_empty_crit_group);
		$fields['search_method'] = intval($this->search_method);
		$fields['priority_on_combination_image'] = intval($this->priority_on_combination_image);
		$fields['use_cache'] = intval($this->use_cache);
		$fields['products_per_page'] = intval($this->products_per_page);
		$fields['products_order_by'] = intval($this->products_order_by);
		$fields['products_order_way'] = intval($this->products_order_way);
		$fields['step_search'] = intval($this->step_search);
		$fields['dynamic_criterion'] = intval($this->dynamic_criterion);
		$fields['background_color'] = pSQL($this->background_color);
		$fields['border_color'] = pSQL($this->border_color);
		$fields['border_size'] = pSQL($this->border_size);
		$fields['color_group_title'] = pSQL($this->color_group_title);
		$fields['font_size_group_title'] = intval($this->font_size_group_title);
		$fields['border_radius'] = intval($this->border_radius);
		$fields['color_title'] = pSQL($this->color_title);
		$fields['font_size_title'] = intval($this->font_size_title);
		$fields['keep_category_information'] = intval($this->keep_category_information);
		$fields['display_empty_criteria'] = intval($this->display_empty_criteria);
		$fields['recursing_indexing'] = intval($this->recursing_indexing);
		$fields['share'] = intval($this->share);
		$fields['search_results_selector'] = pSQL($this->search_results_selector);
		$fields['smarty_var_name'] = pSQL($this->smarty_var_name);
		$fields['insert_in_center_column'] = (int)($this->insert_in_center_column);
		$fields['collapsable_criterias']	=	(int)($this->collapsable_criterias);
		$fields['reset_group']	=	(int)($this->reset_group);
		$fields['unique_search']	=	(int)($this->unique_search);
		$fields['scrolltop_active'] = (int)$this->scrolltop_active;
		return $fields;
	}
	
	/**
	  * Check then return multilingual fields for database interaction
	  *
	  * @return array Multilingual fields
	  */
	public function getTranslationsFieldsChild() {
		parent::validateFieldsLang();

		$fieldsArray = array('title');
		$fields = array();
		$languages = Language::getLanguages(false);
		$defaultLanguage = Configuration::get('PS_LANG_DEFAULT');
		foreach ($languages as $language) {
			$fields[$language['id_lang']]['id_lang'] = $language['id_lang'];
			$fields[$language['id_lang']][$this->identifier] = intval($this->id);
			$fields[$language['id_lang']]['description'] = (isset($this->description[$language['id_lang']]) AND !empty($this->description[$language['id_lang']])) ? pSQL($this->description[$language['id_lang']], true) : pSQL($this->description[$defaultLanguage], true);
			foreach ($fieldsArray as $field) {
				if (!Validate::isTableOrIdentifier($field))
					die(Tools::displayError());

				/* Check fields validity */
				if (isset($this->{$field}[$language['id_lang']]) AND !empty($this->{$field}[$language['id_lang']]))
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$language['id_lang']]);
				else
					$fields[$language['id_lang']][$field] = pSQL($this->{$field}[$defaultLanguage]);
			}
		}
		return $fields;
	}
	
	public	function save($nullValues = true, $autodate = false) {
		if ($this->step_search) {
			$this->collapsable_criterias = 0;
			$this->reset_group = 0;
		}
		if ($this->id_hook != 8 && $this->id_hook != -1)
			$this->insert_in_center_column = 0;
		$ret = parent::save($nullValues,$autodate);

		/*
		 * Save search associations
		 * */
		if (isset($_POST['categories_association'])) {
			$this->addAssociations(Tools::getValue('categories_association'),'pm_advancedsearch_category','id_category');
		} else if (Tools::isSubmit('submitSearch')) {
			$this->cleanAssociation('pm_advancedsearch_category');
		}
		if (isset($_POST['cms_association'])) {
			$this->addAssociations(Tools::getValue('cms_association'),'pm_advancedsearch_cms','id_cms');
		} elseif (Tools::isSubmit('submitSearch')) {
			$this->cleanAssociation('pm_advancedsearch_cms');
		}
		if (isset($_POST['products_association'])) {
			$this->addAssociations(Tools::getValue('products_association'),'pm_advancedsearch_products','id_product');
		} elseif (Tools::isSubmit('submitSearch')) {
			$this->cleanAssociation('pm_advancedsearch_products');
		}
		if (isset($_POST['manufacturers_association'])) {
			$this->addAssociations(Tools::getValue('manufacturers_association'),'pm_advancedsearch_manufacturers','id_manufacturer');
		} elseif (Tools::isSubmit('submitSearch')) {
			$this->cleanAssociation('pm_advancedsearch_manufacturers');
		}
		if (isset($_POST['suppliers_association'])) {
			$this->addAssociations(Tools::getValue('suppliers_association'),'pm_advancedsearch_suppliers','id_supplier');
		} elseif (Tools::isSubmit('submitSearch')) {
			$this->cleanAssociation('pm_advancedsearch_suppliers');
		}
		if (isset($_POST['special_pages_association'])) {
			$this->addAssociations(Tools::getValue('special_pages_association'),'pm_advancedsearch_special_pages','page');
		} elseif (Tools::isSubmit('submitSearch')) {
			$this->cleanAssociation('pm_advancedsearch_special_pages');
		}

		return $ret;
	}
	
	public function delete() {
		$ret = parent::delete();
		
		$this->cleanAssociation('pm_advancedsearch_cms');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.intval($this->id).'`');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.intval($this->id).'_shop`');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.intval($this->id).'_lang`');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.intval($this->id).'`');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.intval($this->id).'_lang`');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.intval($this->id).'`');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.intval($this->id).'`');
		Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.intval($this->id).'`');

		// Delete seo_search
		AdvancedSearchSeoClass::deleteByIdSearch($this->id);

		return $ret;
	}
	
	public function addAssociations($associations,$asso_table,$asso_identifier,$cleanBefore = true) {
		if ($cleanBefore)$this->cleanAssociation($asso_table);
		foreach ($associations as $value) {
			$value = trim($value);
			if (!$value) continue;
			$row = array($this->identifier => intval($this->id), $asso_identifier => $value);
			Db::getInstance()->AutoExecute(_DB_PREFIX_.$asso_table, $row, 'INSERT');
		}
	}
	
	public function cleanAssociation($asso_table) {
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.$asso_table.'` WHERE `'.$this->identifier.'` = '.intval($this->id));
	}
	
	public static function getCMSAssociation($id_search,$id_lang) {
		return( Db::getInstance()->ExecuteS('
			SELECT cl.`meta_title`, cl.`id_cms`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_cms` a
			LEFT JOIN `'._DB_PREFIX_.'cms_lang` cl ON (a.`id_cms` = cl.`id_cms` AND cl.`id_lang` = '.(int)$id_lang.')
			'.(_PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('cms', 'cl', 'id_cms'):'').'
			WHERE a.`id_search` = '.(int)$id_search.'
			'.(_PS_VERSION_ >= 1.5 ? ' GROUP BY cl.`id_cms`':'').'
			ORDER BY cl.`meta_title` ASC'));
	}
	
	public static function getManufacturersAssociation($id_search) {
		return( Db::getInstance()->ExecuteS('
			SELECT m.`name`, m.`id_manufacturer`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_manufacturers` a
			LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = a.`id_manufacturer`)
			WHERE a.`id_search` = '.(int)$id_search.'
			ORDER BY m.`name` ASC'));
	}
	
	public static function getSuppliersAssociation($id_search) {
		return( Db::getInstance()->ExecuteS('
			SELECT s.`name`, s.`id_supplier`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_suppliers` a
			LEFT JOIN `'._DB_PREFIX_.'supplier` s ON (s.`id_supplier` = a.`id_supplier`)
			WHERE a.`id_search` = '.(int)$id_search.'
			ORDER BY s.`name` ASC'));
	}
	
	public static function getProductsAssociation($id_search,$id_lang) {
		return( Db::getInstance()->ExecuteS('
			SELECT pl.`name`, pl.`id_product`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_products` a
			LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (a.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)$id_lang.')
			'.(_PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'pl', 'id_product'):'').'
			WHERE a.`id_search` = '.(int)$id_search.'
			'.(_PS_VERSION_ >= 1.5 ? ' GROUP BY pl.`id_product`':'').'
			ORDER BY pl.`name` ASC'));
	}
	
	public static function getCategoriesAssociation($id_search,$id_lang) {
		return( Db::getInstance()->ExecuteS('
			SELECT cl.`name`, cl.`id_category`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_category` a
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (a.`id_category` = cl.`id_category` AND cl.`id_lang` = '.(int)$id_lang.')
			'.(_PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('category', 'cl', 'id_category'):'').'
			WHERE a.`id_search` = '.(int)$id_search.'
			'.(_PS_VERSION_ >= 1.5 ? ' GROUP BY cl.`id_category`':'').'
			ORDER BY cl.`name` ASC'));
	}
	
	public static function getSpecialPagesAssociation($id_search, $with_title = false, $id_lang = false) {
		return Db::getInstance()->ExecuteS('
			SELECT a.`page`'.($with_title && $id_lang ? ', ml.`title`' : '').' 
			FROM `'._DB_PREFIX_.'pm_advancedsearch_special_pages` a
			'.($with_title && $id_lang ? 
			'JOIN `'._DB_PREFIX_.'meta` m ON m.`page`=a.`page`
			JOIN `'._DB_PREFIX_.'meta_lang` ml ON m.`id_meta` = ml.`id_meta`
			'.(_PS_VERSION_ >= 1.5 ? Shop::addSqlRestrictionOnLang('ml') : '') : '').'
			WHERE a.`id_search` = '.(int)$id_search . ($with_title && $id_lang ? ' AND ml.`id_lang` = '.(int)$id_lang.' ' : '') .
			' ORDER BY a.`page` ASC');
	}
	
	public function addCacheProduct() {
		$sql_insert_multiple = array();
		$sql_insert_multiple_header = 'INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.$this->id.'` (`id_product`) VALUES ';
		$sql_insert_properties_multiple = array();
		foreach (self::getAllProductsId() as $row) {
			// Cache id
			$sql_insert_multiple[] = '('.(int) $row['id_product'].')';
			// Cache properties
			self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,200);
		}
		self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,1);
		return true;
	}
	
	public function updateCacheProduct() {
		$sql_insert_multiple = array();
		$sql_insert_multiple_header = 'INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.$this->id.'` (`id_product`) VALUES ';
		$getAllProductsIdNotCached_result = self::getAllProductsIdNotCached($this->id);
		
		if (AdvancedSearchCoreClass::_isFilledArray($getAllProductsIdNotCached_result)) {
			foreach ($getAllProductsIdNotCached_result as $row) {
				$sql_insert_multiple[] = '('.(int) $row['id_product'].')';
				self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,200);
			}
			self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,1);
		}
		return true;
	}
	
	public static function clearAllTables() {
		$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false);
		foreach($advanced_searchs_id as $key=>$row) {
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.intval($row['id_search']).'`');
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.intval($row['id_search']).'_lang`');
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.intval($row['id_search']).'`');
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.intval($row['id_search']).'_lang`');
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.intval($row['id_search']).'`');
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.intval($row['id_search']).'`');
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.intval($row['id_search']).'`');
		}
		Db::getInstance()->Execute('TRUNCATE `'._DB_PREFIX_.'pm_advancedsearch`');
		Db::getInstance()->Execute('TRUNCATE `'._DB_PREFIX_.'pm_advancedsearch_category`');
		Db::getInstance()->Execute('TRUNCATE `'._DB_PREFIX_.'pm_advancedsearch_cms`');
		Db::getInstance()->Execute('TRUNCATE `'._DB_PREFIX_.'pm_advancedsearch_lang`');
	}
	
	public static function getAllProductsId() {
		return Db::getInstance()->ExecuteS('SELECT p.`id_product`
		FROM `'._DB_PREFIX_.'product` p
		'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'p', 'id_product'):'').'
		WHERE '.(_PS_VERSION_ >= 1.5 && Shop::isFeatureActive() ? 'p_shop' : 'p').'.`active` = 1'.( _PS_VERSION_ >= 1.5 ? ' GROUP BY p.`id_product`':''));
	}
	
	public static function getAllProductsIdNotCached($id_search) {
		return Db::getInstance()->ExecuteS('SELECT p.`id_product`
		FROM `'._DB_PREFIX_.'product` p
		'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'p', 'id_product'):'').'
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int)$id_search.'` acp ON ( acp.id_product = p.id_product )
		WHERE acp.id_product IS NULL AND '.(_PS_VERSION_ >= 1.5 && Shop::isFeatureActive() ? 'p_shop' : 'p').'.`active` = 1'.( _PS_VERSION_ >= 1.5 ? ' GROUP BY p.`id_product`':''));
	}
	
	public static function deleteAllCacheProductsIdOutOfCache($id_search) {
		// Delete unused product cache entry
		Db::getInstance()->Execute('DELETE acp.*, app.*
		FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int)$id_search.'` acp
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int)$id_search.'` app ON ( acp.id_cache_product = app.id_cache_product )
		LEFT JOIN `'._DB_PREFIX_.'product` p ON ( acp.id_product = p.id_product )
		'.( _PS_VERSION_ >= 1.5 ? ' LEFT JOIN `'._DB_PREFIX_.'product_shop` p_shop ON ( p.id_product = p_shop.id_product ) ' : '' ).' 
		WHERE p.id_product IS NULL OR p.`active` = 0
		'.( _PS_VERSION_ >= 1.5 ? ' OR p_shop.`active` = 0 ' : '')
		);

		// Delete unused criteria cache entry
		 Db::getInstance()->Execute('DELETE ac.* , acl.*
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$id_search.'` ac
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int)$id_search.'_lang` acl ON ( acl.id_criterion = ac.id_criterion )
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int)$id_search.'` acpc ON ( acpc.id_criterion = ac.id_criterion )
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int)$id_search.'` acp ON ( acp.id_cache_product = acpc.id_cache_product )
		WHERE acpc.id_cache_product IS NULL');

		return true;
	}
	
	public static function getSearchsFromHook($hookName, $id_lang, $active = true,$ignore_include = false) {
		global $cookie;
		$include_categories = false;
		$include_cms = false;
		$include_supplier = false;
		$include_manufacturer = false;
		$include_product = false;
		$include_seo = false;
		$include_special_page = false;
		$curIdCategory = false;
		$curIdSearch = Tools::getValue('id_search',false);
		if (!Tools::getValue('id_seo') && in_array($hookName,self::$_valid_hooks_cms)) { $include_cms = true;$curIdCms = Tools::getValue('id_cms',false); }
		if (!Tools::getValue('id_seo') && in_array($hookName,self::$_valid_hooks_supplier)) { $include_supplier = true;$curIdSupplier = Tools::getValue('id_supplier',false); }
		if (!Tools::getValue('id_seo') && in_array($hookName,self::$_valid_hooks_manufacturer)) { $include_manufacturer = true;$curIdManufacturer = Tools::getValue('id_manufacturer',false); }
		if (!Tools::getValue('id_seo') && in_array($hookName,self::$_valid_hooks_product)) { $include_product = true;$curIdProduct = Tools::getValue('id_product',false); }
		if (!Tools::getValue('id_seo') && in_array($hookName,self::$_valid_hooks_special_page)) {
			$include_special_page = true;
			$curSpecialPage = AdvancedSearchCoreClass::_getSmartyVarValue('page_name');
		}
		if (!Tools::getValue('id_seo') && in_array($hookName,self::$_valid_hooks_category)) {
			$include_categories = true;
			if ($_SERVER['SCRIPT_NAME'] == __PS_BASE_URI__.'index.php' && ((!isset($_GET['controller']) || !$_GET['controller']) || $_GET['controller'] == 'index')) {
				$curIdCategory = (_PS_VERSION_ >= 1.5 ? Category::getRootCategory()->id : 1);
			} elseif (isset($_GET['id_category'])) $curIdCategory = $_GET['id_category'];
		}
		if (Tools::getValue('id_seo')) { $include_seo = true; }
		if ($hookName == -1)
			$id_hook = -1;
		else
			$id_hook = AdvancedSearchCoreClass::_getHookIdByName($hookName);
		$result = Db::getInstance()->ExecuteS('SELECT DISTINCT advs.*, advsl.*, advs.`id_search`
		FROM `'._DB_PREFIX_.'pm_advancedsearch` advs
		'.(_PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('pm_advancedsearch', 'advs', 'id_search'):'').'
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_lang` advsl ON (advs.`id_search` = advsl.`id_search` AND advsl.`id_lang` = '.((int) $id_lang).' )
		'.($curIdSearch? '':'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cms` advsc ON (advs.`id_search` = advsc.`id_search`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_category` advsca ON (advs.`id_search` = advsca.`id_search`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_manufacturers` advsm ON (advs.`id_search` = advsm.`id_search`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_suppliers` advssu ON (advs.`id_search` = advssu.`id_search`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_products` advsp ON (advs.`id_search` = advsp.`id_search`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_special_pages` advssp ON (advs.`id_search` = advssp.`id_search`)').'
		'.($include_seo? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo` advss ON (advss.`id_search` = advs.`id_search`)':'').'
		WHERE IF((
			SELECT COUNT(advs.id_search)
			FROM `'._DB_PREFIX_.'pm_advancedsearch` advs
			'.($curIdSearch? '':'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cms` advsc ON (advs.`id_search` = advsc.`id_search`)
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_category` advsca ON (advs.`id_search` = advsca.`id_search`)
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_manufacturers` advsm ON (advs.`id_search` = advsm.`id_search`)
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_suppliers` advssu ON (advs.`id_search` = advssu.`id_search`)
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_products` advsp ON (advs.`id_search` = advsp.`id_search`)
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_special_pages` advssp ON (advs.`id_search` = advssp.`id_search`)').'
			'.($include_seo? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo` advss ON (advss.`id_search` = advs.`id_search`)':'').'
			WHERE advs.`unique_search` = 1
			'.($include_seo? ' AND advss.`id_seo` = '.(int)Tools::getValue('id_seo'):'').'
			'.($active ? 'AND advs.`active` = 1' : '').'
			'.($curIdSearch? ' AND advs.`id_search` = '.(int)$curIdSearch.'':($ignore_include?'':'
			 AND (
			 ('.($include_categories && isset($curIdCategory) && $curIdCategory ? 'advsca.`id_category` = '.intval($curIdCategory).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
			 OR ('.($include_cms && isset($curIdCms) && $curIdCms ? 'advsc.`id_cms` = '.intval($curIdCms).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
			 OR ('.($include_supplier && isset($curIdSupplier) && $curIdSupplier ? 'advssu.`id_supplier` = '.intval($curIdSupplier).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
		 	 OR ('.($include_manufacturer && isset($curIdManufacturer) && $curIdManufacturer ? 'advsm.`id_manufacturer` = '.intval($curIdManufacturer).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
		 	 OR ('.($include_product && isset($curIdProduct) && $curIdProduct ? 'advsp.`id_product` = '.intval($curIdProduct).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
		 	 OR ('.($include_special_page && isset($curSpecialPage) && $curSpecialPage ? 'advssp.`page` = "'.pSQL($curSpecialPage).'" OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
			 )')).'
			 LIMIT 1
		) >= 1, advs.`unique_search`, 1) = 1
		AND advs.`id_hook` = '.intval($id_hook).'
		'.($include_seo? ' AND advss.`id_seo` = '.(int)Tools::getValue('id_seo'):'').'
		'.($active ? 'AND advs.`active` = 1' : '').'
		'.($curIdSearch? ' AND advs.`id_search` = '.(int)$curIdSearch.'
		':($ignore_include?'':
		' AND (
		 ('.($include_categories && $curIdCategory ? 'advsca.`id_category` = '.intval($curIdCategory).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
			 OR ('.($include_cms && $curIdCms ? 'advsc.`id_cms` = '.intval($curIdCms).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
			 OR ('.($include_supplier && $curIdSupplier ? 'advssu.`id_supplier` = '.intval($curIdSupplier).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
		 	 OR ('.($include_manufacturer && $curIdManufacturer ? 'advsm.`id_manufacturer` = '.intval($curIdManufacturer).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
		 	 OR ('.($include_product && $curIdProduct ? 'advsp.`id_product` = '.intval($curIdProduct).' OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
		 	 OR ('.($include_special_page && $curSpecialPage ? 'advssp.`page` = "'.pSQL($curSpecialPage).'" OR ' : '').(!Tools::getValue('id_seo')?'(ISNULL(advsca.`id_category`) AND ISNULL(advsc.`id_cms`) AND ISNULL(advssu.`id_supplier`) AND ISNULL(advsm.`id_manufacturer`) AND ISNULL(advsp.`id_product`) AND ISNULL(advssp.`page`))':'1').')
		)').''));
		return $result;
	}
	
	public static function getSearchsIdFromHook($hookName) {
		$include_categories = false;
		$include_cms = false;
		$curIdSearch = Tools::getValue('id_search',false);
		if (!Tools::getValue('id_seo')) { $include_cms = true;$curIdCms = Tools::getValue('id_cms',false); }
		if (!Tools::getValue('id_seo')) { $include_categories = true;$curIdCategory = Tools::getValue('id_category',false); }

		if ($hookName == -1)
			$id_hook = -1;
		else
			$id_hook = Hook::get($hookName);

		$result = Db::getInstance()->ExecuteS('
		SELECT ads.`id_search`
		FROM `'._DB_PREFIX_.'pm_advancedsearch` ads
		'.($curIdSearch? '':'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cms` advsc ON (ads.`id_search` = advsc.`id_search`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_category` advsca ON (ads.`id_search` = advsca.`id_search`)').'
		WHERE ads.`id_hook` = '.intval($id_hook).'
		AND `active` = 1
		'.($curIdSearch? ' AND ads.`id_search` = '.(int)$curIdSearch.'':' AND ('.($include_cms && $curIdCms ? 'advsc.`id_cms` = '.intval($curIdCms).' OR ' : '').'ISNULL(advsc.`id_cms`))
		 AND ('.($include_categories && $curIdCategory ? 'advsca.`id_category` = '.intval($curIdCategory).' OR ' : '').(!Tools::getValue('id_seo')?'ISNULL(advsca.`id_category`)':'1').')'));
		return $result;
	}
	
	public static function getSearchs($id_lang,$active = true,$multishop = true) {
		if (isset(self::$_cacheSearchs))
			return self::$_cacheSearchs;

		$result = Db::getInstance()->ExecuteS('
		SELECT ads.* '.($id_lang ? ', adsl.*':'').', ads.`id_search`
		FROM `'._DB_PREFIX_.'pm_advancedsearch` ads
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_lang` adsl ON (ads.`id_search` = adsl.`id_search` AND adsl.`id_lang` = '.((int) $id_lang).' )':'').'
		'.($multishop && _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('pm_advancedsearch', 'ads', 'id_search'):'').'
		WHERE 1
		'.($active ? ' AND `active` = 1' : '').'
		GROUP BY ads.`id_search`');
		self::$_cacheSearchs = $result;
		return $result;
	}
	
	public static function getSearchsId($active = true, $id_shop = false) {
		if (isset(self::$_cacheSearchsId[(int)$active.'-'.(int)$id_shop]))
			return self::$_cacheSearchsId[(int)$active.'-'.(int)$id_shop];
		$result = Db::getInstance()->ExecuteS('
		SELECT ads.`id_search`
		FROM `'._DB_PREFIX_.'pm_advancedsearch` ads
		' .($id_shop ? ' JOIN `'._DB_PREFIX_.'pm_advancedsearch_shop` adss ON (ads.`id_search`=adss.`id_search` AND adss.`id_shop`='.(int)$id_shop.') ' : '') .
		' WHERE 1 '
		.($active ? ' AND `active` = 1 ' : '').'');
		self::$_cacheSearchsId[(int)$active.'-'.(int)$id_shop] = $result;
		return $result;
	}
	
	private static $_getSearchCache = array();
	public static function getSearch($id_search,$id_lang,$active = true) {
		$cacheKey = $id_search.'-'.$id_lang.'-'.(int)$active;
		if (isset(self::$_getSearchCache[$cacheKey])) return self::$_getSearchCache[$cacheKey];
		$result = Db::getInstance()->ExecuteS('
		SELECT ads.* '.($id_lang ? ', adsl.*':'').', ads.`id_search`
		FROM `'._DB_PREFIX_.'pm_advancedsearch` ads
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_lang` adsl ON (ads.`id_search` = adsl.`id_search` AND adsl.`id_lang` = '.((int) $id_lang).' )':'').'
		WHERE ads.`id_search` = '.(int) $id_search.'
		'.($active ? 'AND `active` = 1' : '').'
		LIMIT 1');
		
		self::$_getSearchCache[$cacheKey] = $result;
		return self::$_getSearchCache[$cacheKey];
	}
	
	static public function getAttributesGroups($id_lang) {
		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'attribute_group` ag
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND `id_lang` = '.(int)($id_lang).')':'').'
		ORDER BY `name` ASC');
		if (!$id_lang && $result) {
			foreach($result as $key=>$row) {
				$result_lang = Db::getInstance()->ExecuteS('
					SELECT agl.*
					FROM `'._DB_PREFIX_.'attribute_group_lang` agl
					WHERE agl.`id_attribute_group` = '.intval($row['id_attribute_group'])
					);
				foreach($result_lang as $row_lang) {

					$result[$key]['name'][$row_lang['id_lang']] = $row_lang['name'];
				}
			}
		}
		return $result;
	}
	
	static public function getAttributeGroups($id_attribute_group,$id_lang = false) {
		$result = Db::getInstance()->ExecuteS('SELECT *
		FROM `'._DB_PREFIX_.'attribute_group` ag
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group` AND `id_lang` = '.(int)($id_lang).')':'').'
		WHERE ag.`id_attribute_group` = '.(int)$id_attribute_group.'
		LIMIT 1');
		if (!$id_lang && $result) {
			$result_lang = Db::getInstance()->ExecuteS('
				SELECT agl.*
				FROM `'._DB_PREFIX_.'attribute_group_lang` agl
				WHERE agl.`id_attribute_group` = '.intval($id_attribute_group)
				);
			foreach($result_lang as $row_lang) {
				$result[0]['name'][$row_lang['id_lang']] = $row_lang['public_name'];
			}
		}
		return $result[0];
	}
	
	static public function getAttributes($id_attribute_group,$id_lang = false,$id_attribute = false) {
		$result = Db::getInstance()->ExecuteS('
		SELECT a.*'.($id_lang ? ', al.*':'').'
		FROM `'._DB_PREFIX_.'attribute` a
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute` AND al.`id_lang` = '.($id_lang ? (int)($id_lang):Configuration::get('PS_LANG_DEFAULT')).')':'').'
		WHERE a.`id_attribute_group` = '.(int)($id_attribute_group).($id_attribute ? ' AND a.`id_attribute` = '.(int)$id_attribute:''));
		if (!$id_lang && $result) {
			foreach($result as $key=>$row) {
				$result_lang = Db::getInstance()->ExecuteS('
					SELECT al.*
					FROM `'._DB_PREFIX_.'attribute_lang` al
					WHERE al.`id_attribute` = '.intval($row['id_attribute']).'
					ORDER BY al.name'
					);
				foreach($result_lang as $row_lang) {
					$result[$key]['name'][$row_lang['id_lang']] = $row_lang['name'];
				}
			}
		}
		return $result;
	}
	
	public static function getAttributesFromProduct($id_product) {
		$result = Db::getInstance()->ExecuteS('
		SELECT a.id_attribute, a.id_attribute_group FROM '._DB_PREFIX_.'product_attribute pa
		INNER JOIN '._DB_PREFIX_.'product_attribute_combination pac ON (pa.id_product_attribute = pac.id_product_attribute)
		INNER JOIN '._DB_PREFIX_.'attribute a ON (pac.id_attribute = a.id_attribute)
		WHERE pa.id_product = '.intval($id_product));
		return $result;
	}
	
	static public function getProductsIdFromAttribute($id_search,$id_attribute) {
		$result = Db::getInstance()->ExecuteS('SELECT acp.`id_cache_product`, pa.`id_product_attribute`, pa.`quantity`, pa.`id_product`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp
			LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.`id_product` = acp.`id_product`)
			LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product`)
			LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON (pa.`id_product_attribute` = pac.`id_product_attribute`)
			'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'p', 'id_product'):'').'
			WHERE '.(_PS_VERSION_ >= 1.5 && Shop::isFeatureActive() ? 'p_shop' : 'p').'.`active` = 1 AND pac.`id_attribute` = '.(int) $id_attribute.'
			GROUP BY acp.`id_product`');

		return $result;
	}
	
	static public function getFeatures($id_lang) {
		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'feature` f
		'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('feature', 'f','id_feature'):'').'
		'.($id_lang ? 'JOIN `'._DB_PREFIX_.'feature_lang` fl ON (f.`id_feature` = fl.`id_feature` AND fl.`id_lang` = '.(int)($id_lang).')':'').'
		'.( _PS_VERSION_ >= 1.5 ? 'GROUP BY f.`id_feature`':'').'
		ORDER BY fl.`name` ASC');
		if (!$id_lang && $result) {
			foreach($result as $key=>$row) {
				$result_lang = Db::getInstance()->ExecuteS('
					SELECT fl.*
					FROM `'._DB_PREFIX_.'feature_lang` fl
					WHERE fl.`id_feature` = '.intval($row['id_feature'])
					);
				foreach($result_lang as $row_lang) {
					$result[$key]['name'][$row_lang['id_lang']] = $row_lang['name'];
				}
			}
		}
		return $result;
	}
	
	public static function getFeaturesFromProduct($id_product,$id_lang) {
		$result = Db::getInstance()->ExecuteS('
		SELECT fvl.`value`, fp.id_feature FROM '._DB_PREFIX_.'feature_product fp
		LEFT JOIN `'._DB_PREFIX_.'feature_value_lang` fvl ON (fp.`id_feature_value` = fvl.`id_feature_value` AND fvl.`id_lang` = '.(int)($id_lang).')
		WHERE fp.id_product = '.intval($id_product));
		return $result;
	}
	
	static public function getFeature($id_feature,$id_lang = false) {
		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'feature` f
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'feature_lang` fl ON (f.`id_feature` = fl.`id_feature` AND fl.`id_lang` = '.(int)($id_lang).')':'').'
		WHERE f.`id_feature` = '.(int)$id_feature.'
		LIMIT 1');
		if (!$id_lang && $result) {
			$result_lang = Db::getInstance()->ExecuteS('
				SELECT fl.*
				FROM `'._DB_PREFIX_.'feature_lang` fl
				WHERE fl.`id_feature` = '.intval($id_feature)
				);
			foreach($result_lang as $row_lang) {
				$result[0]['name'][$row_lang['id_lang']] = $row_lang['name'];
			}
		}
		return $result[0];
	}
	
	static public function getFeatureValues($id_feature,$id_lang = false,$id_feature_value = false) {
		$result = Db::getInstance()->ExecuteS('
		SELECT fv.*
		FROM `'._DB_PREFIX_.'feature_value` fv
		LEFT JOIN `'._DB_PREFIX_.'feature_value_lang` fvl ON (fv.`id_feature_value` = fvl.`id_feature_value` AND fvl.`id_lang` = '.(int)($id_lang).')
		WHERE fv.`id_feature` = '.(int)($id_feature).($id_feature_value ? ' AND fv.`id_feature_value` = '.(int)$id_feature_value:'').'
		GROUP BY fvl.`value`');
		if ($result) {
			foreach($result as $key=>$row) {
				$result_lang = Db::getInstance()->ExecuteS('
					SELECT fvl.*
					FROM `'._DB_PREFIX_.'feature_value_lang` fvl
					WHERE fvl.`id_feature_value` = '.intval($row['id_feature_value'])
					);
				foreach($result_lang as $row_lang) {
					$result[$key]['name'][$row_lang['id_lang']] = $row_lang['value'];
				}
			}
		}
		return $result;
	}
	
	static public function getFeatureValuesFromValue($id_feature,$id_lang = false,$feature_value = false) {
		$result = Db::getInstance()->ExecuteS('
		SELECT fv.*
		FROM `'._DB_PREFIX_.'feature_value` fv
		LEFT JOIN `'._DB_PREFIX_.'feature_value_lang` fvl ON (fv.`id_feature_value` = fvl.`id_feature_value` AND fvl.`id_lang` = '.(int)($id_lang).')
		WHERE fv.`id_feature` = '.(int)($id_feature).($feature_value ? ' AND fvl.`value` LIKE "'.pSQL($feature_value).'"':'').'
		GROUP BY fvl.`value`');
		if ($result) {
			foreach($result as $key=>$row) {
				$result_lang = Db::getInstance()->ExecuteS('
					SELECT fvl.*
					FROM `'._DB_PREFIX_.'feature_value_lang` fvl
					WHERE fvl.`id_feature_value` = '.intval($row['id_feature_value']).'
					ORDER BY fvl.value'
					);
				foreach($result_lang as $row_lang) {
					$result[$key]['name'][$row_lang['id_lang']] = $row_lang['value'];
				}
			}
		}
		return $result;
	}
	
	// Get feature from value
	static public function getProductsIdFromFeatureValue($id_search, $id_feature, $feature_value, $id_lang) {
		$result = Db::getInstance()->ExecuteS('SELECT acp.`id_cache_product`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp
			LEFT JOIN `'._DB_PREFIX_.'feature_product` fp ON (fp.`id_feature` = '.(int)$id_feature.' AND acp.`id_product` = fp.`id_product`)
			WHERE fp.`id_feature_value` IN (
				SELECT fvl.`id_feature_value` FROM `'._DB_PREFIX_.'feature_value_lang` fvl WHERE fvl.`id_lang`='.(int)($id_lang).' AND REPLACE(TRIM(fvl.`value`), "\t", "")="'.pSQL(trim($feature_value)).'"
			)			
			GROUP BY acp.`id_product`');
		return $result;
	}
	
	// Get all manufacturer available
	static public function getManufacturers($id_lang = false,$id_manufacturer = false) {
		$result = Db::getInstance()->ExecuteS('
		SELECT `name` '.(!$id_lang ? ' as simple_name':'').', `id_manufacturer`
		FROM '._DB_PREFIX_.'manufacturer m
		WHERE m.`active` = 1'.($id_manufacturer ? ' AND `id_manufacturer` = '.(int)$id_manufacturer:'').'
		ORDER BY m.`name`');
		if (!$id_lang && $result) {
			foreach($result as $key=>$row) {
				foreach(Language::getLanguages() as $row_lang) {
					$result[$key]['name'][$row_lang['id_lang']] = $row['simple_name'];
				}
			}
		}
		return $result;
	}
	
	// Get all products id from manufacturer
	static public function getProductsIdFromManufacturer($id_search,$id_manufacturer) {
		return Db::getInstance()->ExecuteS('
		SELECT acp.`id_cache_product`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.`id_product` = acp.`id_product`)
		'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'p', 'id_product'):'').'
		WHERE '.(_PS_VERSION_ >= 1.5 && Shop::isFeatureActive() ? 'p_shop' : 'p').'.`active` = 1 AND p.`id_manufacturer` = '.(int)($id_manufacturer));
	}
	
	// Get all supplier available
	static public function getSuppliers($id_lang = false,$id_supplier = false) {
		$result = Db::getInstance()->ExecuteS('
		SELECT `name` '.(!$id_lang ? ' as simple_name':'').', `id_supplier`
		FROM '._DB_PREFIX_.'supplier s
		WHERE s.`active` = 1'.($id_supplier ? ' AND `id_supplier` = '.(int)$id_supplier:'').'
		ORDER BY s.`name`');
		if (!$id_lang && $result) {
			foreach($result as $key=>$row) {
				foreach(Language::getLanguages() as $row_lang) {
					$result[$key]['name'][$row_lang['id_lang']] = $row['simple_name'];
				}
			}
		}
		return $result;
	}
	
	// Get all values from a product field
	static public function getProductsFieldValues($field,$value = false) {
		if ($value) {
			if ($field == 'weight' || $field == 'width' ||
					$field == 'height' || $field == 'depth') {
				$where_clause = 'ROUND(p.`'.pSQL($field).'`,5) = ROUND('.pSQL($value).',5)';
			}else $where_clause = 'p.`'.pSQL($field).'` = "'.pSQL($value).'"';
		}
		$results = Db::getInstance()->ExecuteS('
				SELECT `'.pSQL($field).'` AS single_value
				FROM `'._DB_PREFIX_.'product` p
				'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'p', 'id_product'):'').'
				WHERE '.(_PS_VERSION_ >= 1.5 && Shop::isFeatureActive() ? 'p_shop' : 'p').'.`active` = 1'.($value ? ' AND '.$where_clause : '').'
				GROUP BY p.`'.pSQL($field).'`
				ORDER BY p.`'.pSQL($field).'`');
		return $results;
	}
	
	// Get all products id from supplier
	static public function getProductsIdFromSupplier($id_search,$id_supplier) {
		return Db::getInstance()->ExecuteS('
		SELECT acp.`id_cache_product`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.`id_product` = acp.`id_product`)
		'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'p', 'id_product'):'').'
		WHERE '.(_PS_VERSION_ >= 1.5 && Shop::isFeatureActive() ? 'p_shop' : 'p').'.`active` = 1 AND p.`id_supplier` = '.(int)($id_supplier));
	}
	
	// Get all categories available
	static public function getCategoriesP($id_lang = false,$id_categorie = false,$level_depth = false, $id_search) {
		$result = Db::getInstance()->ExecuteS('
		SELECT c.`id_category`, c.`id_parent`, c.`level_depth`'.($id_lang ? ', cl.name':'').'
		FROM `'._DB_PREFIX_.'category` c
		'.(_PS_VERSION_ >= 1.5 ? ' INNER JOIN `'._DB_PREFIX_.'category_shop` c_shop ON (c_shop.id_category = c.id_category AND c_shop.`id_shop` IN ('.self::getShopBySearch($id_search).')) ' : '').'
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_lang` = '.($id_lang ? (int)($id_lang):Configuration::get('PS_LANG_DEFAULT'))
		. (_PS_VERSION_ >= 1.5 ? ' AND cl.id_shop IN ('.self::getShopBySearch($id_search).') ' : '').')'
		.'WHERE c.`id_category` != '.(_PS_VERSION_ >= 1.5 ? Category::getRootCategory()->id : 1).' '.($id_categorie ? ' AND c.`id_category` ='.(int)$id_categorie:'').($level_depth ? ' AND c.`level_depth` = '.(_PS_VERSION_ >= 1.5 ? (int)$level_depth+1:(int)$level_depth):'').'
		'.( _PS_VERSION_ >= 1.5 ? ' GROUP BY c.`id_category`':'').'
		ORDER BY cl.`name`
		LIMIT '.self::$start_indexation.', '.self::$limit_indexation.'');
		if (!$id_lang && $result) {
			foreach($result as $key=>$row) {
				$result_lang = Db::getInstance()->ExecuteS('
					SELECT cl.name, cl.id_lang
					FROM `'._DB_PREFIX_.'category_lang` cl
					WHERE cl.`id_category` = '.intval($row['id_category']).'
					ORDER BY cl.`name`');
				foreach($result_lang as $row_lang) {
					$result[$key]['name'][$row_lang['id_lang']] = $row_lang['name'];
				}
			}
		}
		return $result;
	}
	
	static public function getBooleanCriteria() {
		return array(
				array('name'=> Module::getInstanceByName('pm_advancedsearch4')->translateMultiple('yes'),'value'=>1),
				array('name'=> Module::getInstanceByName('pm_advancedsearch4')->translateMultiple('no') ,'value'=>0),
		);
	}
	
	static public function getConditionCriteria($value = false) {
		$return = array(
				'new'=>array('name'=> Module::getInstanceByName('pm_advancedsearch4')->translateMultiple('new'),'value'=>'new'),
				'used'=>array('name'=> Module::getInstanceByName('pm_advancedsearch4')->translateMultiple('used') ,'value'=>'used'),
				'refurbished'=>array('name'=> Module::getInstanceByName('pm_advancedsearch4')->translateMultiple('refurbished') ,'value'=>'refurbished')
		);
		if ($value) {
			return array($return[$value]);
		}
		return $return;
	}
	
	static public function getBooleanTrueCriteria() {
		return array(
				array('name'=> Module::getInstanceByName('pm_advancedsearch4')->translateMultiple('yes'),'value'=>1)
		);
	}
	
	/**
	  * Get Each childs category of this category
	  */
	public static function getChildsCategoriesId($id_category) {
		$categories = null;
		if (!is_array($id_category)) {
			$idsSearch = array($id_category);
			$idsReturn = array($id_category);
		} else {
			$idsSearch = $id_category;
			$idsReturn = $id_category;
		}
		while (true) {
			$query = '
				SELECT c.`id_category`
				FROM `'._DB_PREFIX_.'category` c
				WHERE c.`id_parent` IN( '.implode(',', $idsSearch).')
			';
			$result = Db::getInstance()->ExecuteS($query);
			if (!$result) return $idsReturn;
			$idsSearch = array();
			foreach($result as $row) {
				$idsSearch[] = $row['id_category'];
				$idsReturn[] = $row['id_category'];
			}
		}
	}
	
	/**
	  * Get Each childs category of this category
	  *
	  * @param integer $id_lang Language ID
	  * @return array Corresponding categories
	  */
	public static function getParentsCategoriesId($id_category,$ignore = false) {
		$categories = null;
		if (is_array($id_category)) {
			$idsSearch = $id_category;
			$idsReturn = $id_category;
		} else {
			$idsSearch = array($id_category);
			$idsReturn = array($id_category);
		}
		while (true) {
			$query = '
				SELECT c.`id_parent`
				FROM `'._DB_PREFIX_.'category` c
				WHERE c.`id_category` IN( '.implode(',', $idsSearch).')'.($ignore ?' AND c.`id_parent` NOT IN( '.implode(',', $ignore).')':'').'
			';
			$result = Db::getInstance()->ExecuteS($query);
			if (!$result) return $idsReturn;
			$idsSearch = array();
			foreach($result as $row) {
				$idsSearch[] = $row['id_parent'];
				$idsReturn[] = $row['id_parent'];
			}
		}
	}
	
	/**
	  * Get Each childs category of this category
	  *
	  * @param integer $id_lang Language ID
	  * @return array Corresponding categories
	  */
	public static function getHighestParentCategoryId($id_category,$ignore = false) {
		while (true) {
			$query = '
				SELECT c.`id_category`,c.`id_parent`
				FROM `'._DB_PREFIX_.'category` c
				WHERE c.`id_category` = '.(int)$id_category.($ignore ?' AND c.`id_parent` NOT IN( '.implode(',', $ignore).')':'').'
				LIMIT 1
			';
			$result = Db::getInstance()->ExecuteS($query);
			if (!$result) return $id_category;
			$id_category = $result[0]['id_parent'];
		}
	}
	
	// Get all products id from category
	public static function getProductsIdFromCategory($id_search,$id_category,$recursing_indexing) {
		if ($recursing_indexing)
			$all_childs_categories = self::getChildsCategoriesId($id_category);
		else
			$all_childs_categories = array($id_category);
		return Db::getInstance()->ExecuteS('
		SELECT DISTINCT acp.`id_cache_product`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.`id_product` = acp.`id_product`)
		LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (p.`id_product` = cp.`id_product`)
		'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'p', 'id_product'):'').'
		WHERE '.(_PS_VERSION_ >= 1.5 && Shop::isFeatureActive() ? 'p_shop' : 'p').'.`active` = 1 AND cp.`id_category` IN( '.implode(',',$all_childs_categories).')');
	}
	
	// Get all products id from product sale
	public static function getProductsIdFromProductField($id_search,$field_value,$field) {
		if ($field == 'stock') {
			$field = 'quantity';
			$where_clause = (_PS_VERSION_ >= 1.5 ? 'sa.':'p.').'`'.$field.'` >= '.(int)$field_value;
		} elseif ($field == 'weight' || $field == 'width' || $field == 'height' || $field == 'depth') {
			$where_clause = 'ROUND(p.`'.$field.'`,5) = ROUND('.pSQL($field_value).',5)';
		} else {
			$where_clause = 'p.`'.$field.'` = "'.pSQL($field_value).'"';
		}
		return Db::getInstance()->ExecuteS('
				SELECT acp.`id_cache_product`
				FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp
				LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.`id_product` = acp.`id_product`)
				'.( _PS_VERSION_ >= 1.5 ? AdvancedSearchCoreClass::addSqlAssociation('product', 'p', 'id_product'):'').'
				'.(_PS_VERSION_ >= 1.5 ? 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa ON (p.`id_product` = sa.`id_product` '. self::_addSqlShopRestrictionStockAvailable('sa') .') ':'').'
				WHERE '.(_PS_VERSION_ >= 1.5 && Shop::isFeatureActive() ? 'p_shop' : 'p').'.`active` = 1 AND '.$where_clause);
	}
	
	// Get all products id from product
	public static function getCategoriesFromProduct($id_product,$level_depth = false) {
		$result = Db::getInstance()->ExecuteS('
		SELECT cp.`id_category`
		FROM `'._DB_PREFIX_.'category_product` cp '
		.($level_depth ? ' LEFT JOIN `'._DB_PREFIX_.'category` c ON (cp.`id_category` = c.`id_category`)':'').
		'WHERE cp.`id_product` = '.(int)($id_product).($level_depth ? ' AND c.`level_depth` ='.(int)$level_depth:''));
		$categories = array();
		foreach($result as $row) {
			$categories[] = $row['id_category'];
		}
		return $categories;
	}
	
	// Get all category depth from 1
	public static function getCategoriesLevelDepth() {
		return Db::getInstance()->ExecuteS('
		SELECT c.`level_depth`
		FROM `'._DB_PREFIX_.'category` c
		WHERE c.`level_depth` > 0
		GROUP BY c.`level_depth`
		ORDER BY c.`level_depth`
		');
	}
	
	// Get category level depth
	public static function getCategoryLevelDepth($id_category) {
		$row = Db::getInstance()->getRow('
		SELECT c.`level_depth`
		FROM `'._DB_PREFIX_.'category` c
		WHERE c.`id_category` = '.(int)$id_category);
		return isset($row['level_depth']) ? $row['level_depth'] : false;
	}
	
	// Check if category has childrens
	public static function categoryHasChild($id_category) {
		$row = Db::getInstance()->getRow('
		SELECT c.`id_category`
		FROM `'._DB_PREFIX_.'category` c
		WHERE c.`id_parent` = '.(int)$id_category);
		return isset($row['id_category']);
	}
	
	// Get advanced search criterion category level depth
	public static function getAsCriterionCategoryHigherLevelDepth($id_search,$id_criterion) {
		$row = Db::getInstance()->getRow('
		SELECT ac.`level_depth`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		WHERE ac.`id_criterion` IN('.implode(',',$id_criterion).')
		ORDER BY ac.`level_depth` DESC');
		return isset($row['level_depth']) ? $row['level_depth'] : false;
	}
	
	// Get simple category name
	public static function getCategoryName($id_lang,$id_category) {
		$row = Db::getInstance()->getRow('
		SELECT cl.`name`
		FROM `'._DB_PREFIX_.'category_lang` cl
		WHERE cl.`id_lang` = '.(int)$id_lang.' AND cl.`id_category` = '.(int)$id_category);
		return isset($row['name']) ? $row['name'] : false;
	}
	
	public static function getCriterionsFromCriterionGroup($criterions_group_type,$id_criterion_group_linked,$id_search,$order_by,$order_way,$id_lang = false) {
		if ($order_by == 'position' || !$id_lang) $field_order_by = 'ac.`position`';
		elseif ($criterions_group_type == 'weight' || $criterions_group_type == 'width' || $criterions_group_type == 'height' || $criterions_group_type == 'depth') $field_order_by = '`value`';
		elseif ($order_by == 'numeric') $field_order_by = 'CAST(REPLACE(IF(ac.`single_value` != "",ac.`single_value`,acl.`value`), ",", ".") AS DECIMAL(10,2))';
		else $field_order_by = '`value`';
		$result = Db::getInstance()->ExecuteS('
		SELECT ac.* '.((int) $id_lang ? ', acl.*':'').', IF(ac.`single_value` != "",ac.`single_value`,acl.`value`) AS `value`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')' : '').'
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg ON (acg.`id_criterion_group` = ac.`id_criterion_group`)
		WHERE acg.`criterion_group_type` = "'.pSQL($criterions_group_type).'" AND acg.`id_criterion_group_linked` = '.(int)($id_criterion_group_linked).'
		ORDER BY '.$field_order_by.' '.$order_way);
		if (!$id_lang && $result) {
			foreach($result as $key=>$row) {
				$result_lang = Db::getInstance()->ExecuteS('
					SELECT acl.`name`
					FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl
					WHERE acl.`id_criterion` = '.intval($row['id_criterion'])
					);
				foreach($result_lang as $row_lang) {
					$result[$key]['name'][$row_lang['id_lang']] = $row_lang['name'];
				}
			}
		}
		return $result;
	}
	
	public static function getCriterionsGroupsIndexed($id_search,$id_lang = false,$visible = true) {
		return Db::getInstance()->ExecuteS('
		SELECT acg.* '.((int) $id_lang ? ', acgl.*':'').'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'_lang` acgl ON (acg.`id_criterion_group` = acgl.`id_criterion_group` AND acgl.`id_lang` = '.(int) $id_lang.')' : '').'
		WHERE acg.`id_search` = '.(int)($id_search).'
		'.($visible ? ' AND `visible` = 1' : '').'
		GROUP BY acg.`id_criterion_group`
		ORDER BY acg.`position`');
	}
	
	public static function getProductsSpecificPrices($id_search, $id_product = false, $id_shop = false, $start = 0, $limit = 10000) {
		if (_PS_VERSION_ >= 1.5) {
			if ($id_shop == false) $id_shop = self::getShopBySearch($id_search);
			return Db::getInstance()->ExecuteS('SELECT sp.*, product_shop.`cache_default_attribute`, product_shop.`price` as default_price, acp.`id_cache_product`, '.self::_getScoreQuery((_PS_VERSION_ >= 1.5 ? $id_shop : 0), 0, 0, 0, true, true, true).'
			FROM `'._DB_PREFIX_.'specific_price` sp
			LEFT JOIN `'._DB_PREFIX_.'product` p ON (p.`id_product` = sp.`id_product`)
			INNER JOIN `'._DB_PREFIX_.'product_shop` product_shop ON (product_shop.`id_product` = p.`id_product` AND product_shop.`id_shop` = '.(int)$id_shop.')
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp ON (p.`id_product` = acp.`id_product`)
			WHERE sp.`id_cart`=0
			'.($id_product ? ' AND p.`id_product` = '.(int) $id_product : '').'
			GROUP BY sp.`id_product`,sp.`id_shop`,sp.`id_currency`, sp.`id_country`, sp.`id_group`,sp.`price`,sp.`reduction`,sp.`reduction_type`,sp.`from`,sp.`to`
			ORDER BY sp.`id_product_attribute` DESC, sp.`from_quantity` DESC, sp.`id_specific_price_rule` ASC, `score` DESC
			LIMIT '.(int)($start*$limit).', '.(int)$limit);
		} else {
			return Db::getInstance()->ExecuteS('SELECT sp.*, p.`cache_default_attribute`, p.`price` as default_price, acp.`id_cache_product`, '.self::_getScoreQuery((_PS_VERSION_ >= 1.5 ? $id_shop : 0), 0, 0, 0, true, true, true).'
			FROM `'._DB_PREFIX_.'specific_price` sp
			LEFT JOIN `'._DB_PREFIX_.'product` p ON(p.`id_product` = sp.`id_product`)
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp ON (p.`id_product` = acp.`id_product`)
			'.($id_product ? ' WHERE p.`id_product` = '.(int) $id_product:'').'
			GROUP BY sp.`id_product`,sp.`id_currency`, sp.`id_country`, sp.`id_group`,sp.`price`,sp.`reduction`,sp.`reduction_type`,sp.`from`,sp.`to`
			ORDER BY sp.`from_quantity` DESC, `score` DESC
			LIMIT '.(int)($start*$limit).', '.(int)$limit);
		}
	}
	
	public static function getProductsPriceFromProductTable($id_search,$id_product = false, $id_shop = false) {
		if (_PS_VERSION_ >= 1.5) {
			if ($id_shop == false) $id_shop = self::getShopBySearch($id_search);
			return Db::getInstance()->ExecuteS('SELECT product_shop.`id_shop`, product_shop.`cache_default_attribute`, p.`id_product`, product_shop.`price`, product_shop.`id_tax_rules_group`, acp.`id_cache_product`
			FROM `'._DB_PREFIX_.'product` p
			INNER JOIN `'._DB_PREFIX_.'product_shop` product_shop ON (product_shop.`id_product` = p.`id_product` AND product_shop.`id_shop` = '.(int)$id_shop.')
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp ON (p.`id_product` = acp.`id_product`)
			WHERE product_shop.`active` = 1 AND product_shop.`id_shop` = '.(int)$id_shop.' '.($id_product ? ' AND p.`id_product` = '.(int) $id_product:''));
		} elseif (_PS_VERSION_ >= 1.4) {
			return Db::getInstance()->ExecuteS('SELECT p.`cache_default_attribute`, p.`id_product`, p.`price`, p.`id_tax_rules_group`, acp.`id_cache_product`
			FROM `'._DB_PREFIX_.'product` p
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp ON (p.`id_product` = acp.`id_product`)
			WHERE p.`active` = 1'.($id_product ? ' AND p.`id_product` = '.(int) $id_product:''));
		}
	}
	
	private static $_getDefaultAttributePriceCache = array();
	public static function getDefaultAttributePrice($id_product_attribute, $id_shop) {
		$cacheKey = $id_product_attribute.'-'.$id_shop;
		if (isset(self::$_getDefaultAttributePriceCache[$cacheKey])) return self::$_getDefaultAttributePriceCache[$cacheKey];
		if (_PS_VERSION_ >= 1.5) {
			$row = Db::getInstance()->getRow('SELECT product_attribute_shop.`price`
				FROM `'._DB_PREFIX_.'product_attribute` pa
				INNER JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop ON (product_attribute_shop.`id_product_attribute` = pa.`id_product_attribute` AND product_attribute_shop.`id_shop` = '.(int)$id_shop.')
				WHERE product_attribute_shop.`id_product_attribute` = '.(int)($id_product_attribute).'
				AND product_attribute_shop.`id_shop` = '.(int)$id_shop);
		} else {
			$row = Db::getInstance()->getRow('SELECT `price`
				FROM `'._DB_PREFIX_.'product_attribute`
				WHERE `id_product_attribute` = '.(int)($id_product_attribute));
		}
		self::$_getDefaultAttributePriceCache[$cacheKey] = (isset($row['price']) ? $row['price'] : 0);
		return self::$_getDefaultAttributePriceCache[$cacheKey];
	}
	
	private static $_getShopBySearchCache = array();
	public static function getShopBySearch($id_search) {
		if (isset(self::$_getShopBySearchCache[$id_search])) return self::$_getShopBySearchCache[$id_search];
		self::$_getShopBySearchCache[$id_search] = 0;
		if (_PS_VERSION_ >= 1.5) {
			$row = Db::getInstance()->getRow('SELECT `id_shop` FROM `'._DB_PREFIX_.'pm_advancedsearch_shop` WHERE `id_search` = '.(int)($id_search));
			if ($row && isset($row['id_shop']))
				self::$_getShopBySearchCache[$id_search] = (int)$row['id_shop'];
		}
		return self::$_getShopBySearchCache[$id_search];
	}
	
	private static $_getDefaultAttributeCache = array();
	public static function getDefaultAttribute($id_product, $minimum_quantity = 0) {
		if (isset(self::$_getDefaultAttributeCache[$id_product.'-'.$minimum_quantity])) return self::$_getDefaultAttributeCache[$id_product.'-'.$minimum_quantity];
		self::$_getDefaultAttributeCache[$id_product.'-'.$minimum_quantity] = Product::getDefaultAttribute($id_product, $minimum_quantity);
		return self::$_getDefaultAttributeCache[$id_product.'-'.$minimum_quantity];
	}
	
	private static $_productHasAttributesCache = array();
	private static function _productHasAttributes($id_product) {
		if (isset(self::$_productHasAttributesCache[$id_product])) return self::$_productHasAttributesCache[$id_product];
		if (_PS_VERSION_ >= 1.5) {
			self::$_productHasAttributesCache[$id_product] = (bool)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
				SELECT pa.id_product_attribute
				FROM `'._DB_PREFIX_.'product_attribute` pa
				LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` pas ON (pa.`id_product_attribute` = pas.`id_product_attribute`)
				WHERE pa.`id_product` = '.(int)$id_product
			);
		} else {
			self::$_productHasAttributesCache[$id_product] = (bool)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT `id_product_attribute`
			FROM `'._DB_PREFIX_.'product_attribute`
			WHERE `id_product` = '.(int)$id_product);
		}
		return self::$_productHasAttributesCache[$id_product];
	}
	
	public static function setProductsSpecificPrices($id_search, $id_criterion_group, $id_product = false) {
		$specific_prices_cache = Db::getInstance()->ExecuteS('
			SELECT * FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'` app, `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.$id_search.'` acp
			WHERE app.`id_cache_product`=acp.`id_cache_product`
			AND app.`is_specific`=1
			'.($id_product != false ? ' AND acp.`id_product`='.(int)$id_product : ''). ' 
			'.(_PS_VERSION_ >= 1.5 ? ' AND app.`id_shop`='.(int)self::getShopBySearch($id_search) : ''). ' 
			GROUP BY acp.`id_product`, app.`id_shop`, app.`id_currency`, app.`id_country`, app.`id_group`');
		if ($id_product == false) {
			Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'` SET `valid_id_specific_price`=0');
		} else {
			Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'` app, `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.$id_search.'` acp
			SET app.`valid_id_specific_price`=0
			WHERE app.`id_cache_product`=acp.`id_cache_product` AND acp.`id_product`='.(int)$id_product);
		}
		if ($specific_prices_cache && AdvancedSearchCoreClass::_isFilledArray($specific_prices_cache)) {
			foreach ($specific_prices_cache as $row) {
				if (_PS_VERSION_ >= 1.5) {
					$specific_price = SpecificPrice::getSpecificPrice((int)$row['id_product'], (int)$row['id_shop'], (int)$row['id_currency'], (int)$row['id_country'], (int)$row['id_group'], 1, null, 0, 0, 1);
				} else {
					$specific_price = SpecificPrice::getSpecificPrice((int)$row['id_product'], (int)$row['id_shop'], (int)$row['id_currency'], (int)$row['id_country'], (int)$row['id_group'], 1);
				}
				if ($specific_price && AdvancedSearchCoreClass::_isFilledArray($specific_price)) {
					Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'` SET `valid_id_specific_price`=1 WHERE `id_group`='.(int)$row['id_group'].' AND `id_cache_product`='.(int)$row['id_cache_product'].' AND `id_specific_price`='.(int)$specific_price['id_specific_price']);
				} else {
					Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'` SET `has_no_specific`=1 WHERE `id_group`='.(int)$row['id_group'].' AND `id_cache_product`='.(int)$row['id_cache_product'].(_PS_VERSION_ >= 1.5 ? ' AND `id_shop`='.(int)$row['id_shop'] : ''));
					Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'` WHERE `id_group`='.(int)$row['id_group'].' AND `is_specific`=1 AND `id_cache_product`='.(int)$row['id_cache_product'].(_PS_VERSION_ >= 1.5 ? ' AND `id_shop`='.(int)$row['id_shop'] : ''));
				}
			}
		}
		// Fix has_no_specific per shop
		Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'` app
			JOIN (SELECT `id_cache_product`, `id_shop`, `id_group`
				FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'`
				GROUP BY `id_cache_product`, `id_shop`, `id_group`
				HAVING SUM(`is_specific`)=0) as app2
			ON (app.`id_cache_product`=app2.`id_cache_product` AND app.`id_shop`=app2.`id_shop` AND app.`id_group`=app2.`id_group`)
			SET app.`has_no_specific`=1
		');
	}
	
	public static function setProductsPrices($id_search,$id_criterion_group,$id_product = false) {
		global $cookie;
		// Prepare multiple price criteria insert
		$sql_insert_multiple = array();
		$sql_insert_multiple_header = 'INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.$id_search.'` (`id_criterion_group`, `id_shop`, `id_country`, `id_currency`, `id_group`, `price_wt`, `reduction_amount`, `reduction_type`, `from`, `to`, `is_specific`, `has_no_specific`, `id_specific_price`, `valid_id_specific_price`, `id_cache_product`) VALUES ';
		
		// Limit queries for big catalogs
		$select_limit = 10000;
		$select_iteration = 0;
		$products_price = self::getProductsSpecificPrices($id_search, $id_product, false, $select_iteration, $select_limit);
		$nb_products_specific_price = sizeof($products_price);
		
		$has_specific_price = array();
		
		while ($nb_products_specific_price > 0) {
			foreach ($products_price as $row) {
				if (!$row['id_cache_product']) continue;
				$price = (intval($row['price']) > 0?$row['price']:$row['default_price']);
				
				// ID Shop specials values
				if (isset($row['id_shop']) && $row['id_shop'] > 0) {
					$id_shop = (int)$row['id_shop'];
				} else {
					$id_shop = 0;
				}
				
				if ($id_shop == 0 && _PS_VERSION_ >= 1.5) {
					$liste_id_shop = array(self::getShopBySearch($id_search));
				} else {
					$liste_id_shop = array($id_shop);
				}
				
				foreach ($liste_id_shop as $id_shop) {
					if (self::_productHasAttributes($row['id_product'])) {
						// Default attribute isn't set...
						if ($row['cache_default_attribute'] == 0) {
							Product::updateDefaultAttribute($row['id_product']);
							$cache_default_attribute = self::getDefaultAttribute($row['id_product']);
							$row['cache_default_attribute'] = $cache_default_attribute;
						}
						// If we have a new cache_default_attribute, get the new price
						if ($row['cache_default_attribute'])
							$price += self::getDefaultAttributePrice($row['cache_default_attribute'], $id_shop);
					}
					
					$reduc = 0;
					if ($row['reduction_type'] == 'amount') {
						$reduc = Tools::ps_round($row['reduction'], 6);
					}
					else
						$reduc = Tools::ps_round($price * $row['reduction'], 6);
					$price = Tools::ps_round($price, 6);
					
					// Skip if negative price
					if ($price < 0) { continue; }
					
					// Product have a specific price, we save this state
					if (!isset($has_specific_price[$id_shop]))
						$has_specific_price[$id_shop] = array();
					$has_specific_price[$id_shop][] = (int)$row['id_cache_product'];
					
					$sql_insert_multiple[] = '('.(int)$id_criterion_group.', '.(int)$id_shop.', '.(int)$row['id_country'].', '.(int)$row['id_currency'].', '.(int)$row['id_group'].', '.(float)$price.', '.(float)$reduc.', "'.pSQL($row['reduction_type']).'", "'.$row['from'].'", "'.$row['to'].'", 1, 0, '.(int)$row['id_specific_price'].', 0, '.(int)$row['id_cache_product'].')';
				}
				// Save multiple prices criteria
				self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,200);
			}
			// New iteration needed
			if ($nb_products_specific_price >= $select_limit) {
				$select_iteration++;
				$products_price = self::getProductsSpecificPrices($id_search, $id_product, false, $select_iteration, $select_limit);
				$nb_products_specific_price = sizeof($products_price);
				if ($nb_products_specific_price == 0) break;
			} else {
				$nb_products_specific_price = 0;
				break;
			}
		}
		// Save multiple prices criteria
		self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,200);
		
		$geolocation_enabled = Configuration::get('PS_GEOLOCATION_ENABLED');
		if ($geolocation_enabled) {
			$allowedCountriesIso = explode(';', Configuration::get('PS_ALLOWED_COUNTRIES'));
			$allowedCountries = array();
			foreach($allowedCountriesIso as $iso_code) {
				if (!trim($iso_code)) continue;
				$allowedCountries[] = Country::getByIso($iso_code);
			}
		}
		$products = self::getProductsPriceFromProductTable($id_search,$id_product);
		foreach($products as $row) {
			$id_product = $row['id_product'];
			$price = $row['price'];
			// ID Shop specials values
			if (isset($row['id_shop']) && $row['id_shop'] > 0) {
				$id_shop = (int)$row['id_shop'];
			} else {
				$id_shop = 0;
			}
			
			if (self::_productHasAttributes($id_product)) {
				// Default attribute isn't set...
				if ($row['cache_default_attribute'] == 0) {
					Product::updateDefaultAttribute($id_product);
					$cache_default_attribute = self::getDefaultAttribute($id_product);
					$row['cache_default_attribute'] = $cache_default_attribute;
				}
				
				// If we have a new cache_default_attribute, get the new price
				if ($row['cache_default_attribute'])
					$price += self::getDefaultAttributePrice($row['cache_default_attribute'], $id_shop);
			}
			
			// Skip if negative price
			if ($price < 0) continue;
			
			// Does product have specific price ?
			if (!isset($has_specific_price[$id_shop]))
				$has_specific_price[$id_shop] = array();
			$has_no_specific_price_bool = (int)!in_array((int)$row['id_cache_product'], $has_specific_price[$id_shop]);
			
			$sql_insert_multiple[] = '('.(int) $id_criterion_group.', '.(int)$id_shop.', 0, 0, 0, '.(float) $price.', 0, NULL, "0000-00-00 00:00:00", "0000-00-00 00:00:00", 0, '.(int)$has_no_specific_price_bool.', NULL, 0, '.(int) $row['id_cache_product'].')';
			// Save multiple prices criteria
			self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,200);
		}
		// Save unsaved multiple prices criteria
		self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,1);
	}
	
	public static function criterionsGroupIsIndexed($criterion_group_type, $id_criterion_group_linked, $id_search,$invisible = 0) {
		$row = Db::getInstance()->getRow('
			SELECT acg.`id_criterion_group`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
			WHERE acg.`criterion_group_type` = "'.pSQL($criterion_group_type).'" AND acg.`id_criterion_group_linked` = '.intval($id_criterion_group_linked).
		($invisible ? ' AND `visible` = 0' : ''));
			return isset($row) ? $row['id_criterion_group'] : false;
	}
	
	public static function desIndexFilterByEmplacement($id_search) {
		if (self::criterionsGroupIsIndexed('manufacturer', 0, $id_search,1)) {
			self::desIndexCriterionsGroup('manufacturer', 0, $id_search,0);
		}
		if (self::criterionsGroupIsIndexed('supplier', 0, $id_search,1)) {
			self::desIndexCriterionsGroup('supplier', 0, $id_search,0);
		}
		if (self::criterionsGroupIsIndexed('category', 0, $id_search,1)) {
			self::desIndexCriterionsGroup('category', 0, $id_search,0);
		}
	}
	
	public static function indexFilterByEmplacement($id_search) {
		global $cookie;
		if (!self::criterionsGroupIsIndexed('manufacturer', 0, $id_search)) {
			$objSearch = new AdvancedSearchClass($id_search,$cookie->id_lang);
			self::indexCriterionsGroup('manufacturer', 0, $objSearch,0,false);
		}
		if (!self::criterionsGroupIsIndexed('supplier', 0, $id_search)) {
			$objSearch = new AdvancedSearchClass($id_search,$cookie->id_lang);
			self::indexCriterionsGroup('supplier', 0, $objSearch,0,false);
		}
		if (!self::criterionsGroupIsIndexed('category', 0, $id_search)) {
			$objSearch = new AdvancedSearchClass($id_search,$cookie->id_lang);
			self::indexCriterionsGroup('category', 0, $objSearch,0,false);
		}
	}
	
	public static function reindexingCategoriesGroups($objSearch) {
		$categoriesGroups = self::getCategoriesCriteriaGroup($objSearch->id);
		if ($categoriesGroups) {
			foreach($categoriesGroups as $row) {
				self::indexCriterionsGroup('category', $row['id_criterion_group_linked'], $objSearch,$row['visible'],false,true);
			}
		}
	}
	
	public static function deleteCacheFromIdProduct($id_search,$id_product) {
		Db::getInstance()->Execute('DELETE acpc.* FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $id_search.'` acpc LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp ON (acp.`id_cache_product` = acpc.`id_cache_product`) WHERE acp.`id_product` = '.(int)$id_product);
		Db::getInstance()->Execute('DELETE app.* FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int) $id_search.'` app LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $id_search.'` acp ON (acp.`id_cache_product` = app.`id_cache_product`) WHERE acp.`id_product` = '.(int)$id_product);

	}
	
	public static function deleteCacheCriterionGroup($id_search,$id_criterion_group) {
		Db::getInstance()->Execute('DELETE acpc.* FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $id_search.'` acpc LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac ON (ac.`id_criterion` = acpc.`id_criterion`) WHERE ac.`id_criterion_group` = '.intval($id_criterion_group));
	}
	
	public static function deleteCachePriceGroup($id_search,$id_criterion_group) {
		Db::getInstance()->Execute('DELETE app.* FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int) $id_search.'` app WHERE app.`id_criterion_group` = '.intval($id_criterion_group));
	}
	
	public static function addProductToCache($id_search,$id_product) {
		Db::getInstance()->autoExecute(_DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int)$id_search, array('id_product'=>$id_product), 'INSERT');
	}
	
	public static function desIndexCriterionsFromProduct($id_product) {
		$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false);
		foreach($advanced_searchs_id as $key=>$row) {
			self::deleteCacheFromIdProduct($row['id_search'],$id_product);
		}
		return true;
	}
	
	public static function indexCriterionsFromProduct($product,$add = false) {
		global $cookie;
		$advanced_searchs_id = AdvancedSearchClass::getSearchsId(false);

		foreach($advanced_searchs_id as $key=>$row) {
			$id_search = $row['id_search'];
			$objSearch = new AdvancedSearchClass($id_search,$cookie->id_lang);
			// add product id to cache
			if (!self::getIdCacheProductFromIdProduct($id_search,$product->id)) {
				self::addProductToCache($id_search,$product->id);
			} elseif (!$add)
				self::deleteCacheFromIdProduct($id_search,$product->id);

			$criterions_groups_indexed = AdvancedSearchClass::getCriterionsGroupsIndexed($id_search,$cookie->id_lang,false);
			foreach($criterions_groups_indexed as $key2 => $row2) {
				if ($row2['criterion_group_type'] == 'manufacturer' && $product->id_manufacturer) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,$product->id_manufacturer);
				}elseif ($row2['criterion_group_type'] == 'supplier' && $product->id_supplier) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,$product->id_supplier);
				}elseif ($row2['criterion_group_type'] == 'feature') {
					$features = self::getFeaturesFromProduct($product->id,$cookie->id_lang);
					foreach($features as $feature) {
						self::indexCriterionsGroup($row2['criterion_group_type'], $feature['id_feature'], $objSearch,$row2['visible'],false,true,$product->id,false,$feature['value']);
					}
				}elseif ($row2['criterion_group_type'] == 'attribute') {
					$attributes = self::getAttributesFromProduct($product->id);
					foreach($attributes as $attribute) {
						self::indexCriterionsGroup($row2['criterion_group_type'], $attribute['id_attribute_group'], $objSearch,$row2['visible'],false,true,$product->id,$attribute['id_attribute']);
					}
				}elseif ($row2['criterion_group_type'] == 'category') {
					$categories = self::getCategoriesFromProduct($product->id/*,$row2['id_criterion_group_linked']*/);
					if ($categories && sizeof($categories)) {
						$categories = self::getParentsCategoriesId($categories,array(0,1));
						foreach($categories as $id_category) {
							if ($row2['id_criterion_group_linked'] && $row2['id_criterion_group_linked'] != self::getCategoryLevelDepth($id_category)) continue;
							self::indexCriterionsGroup($row2['criterion_group_type'], $row2['id_criterion_group_linked'], $objSearch,$row2['visible'],false,true,$product->id, $id_category);
						}
					}
				}elseif ($row2['criterion_group_type'] == 'price') {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id);
				}
				elseif ($row2['criterion_group_type'] == 'on_sale' && $product->on_sale) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,$product->on_sale);
				}
				elseif ($row2['criterion_group_type'] == 'available_for_order' && $product->available_for_order) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,$product->available_for_order);
				}
				elseif ($row2['criterion_group_type'] == 'online_only' && $product->online_only) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,$product->online_only);
				}
				elseif ($row2['criterion_group_type'] == 'stock' && $product->quantity > 0) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,1);
				}
				elseif ($row2['criterion_group_type'] == 'weight' && $product->weight) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,false,$product->weight);
				}
				elseif ($row2['criterion_group_type'] == 'height' && $product->height) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,false,$product->height);
				}
				elseif ($row2['criterion_group_type'] == 'condition' && $product->condition) {
					self::indexCriterionsGroup($row2['criterion_group_type'], 0, $objSearch,$row2['visible'],false,true,$product->id,false,$product->condition);
				}
			}
		}
		return true;
	}
	
	public static function desIndexCriterionsGroup($criterions_group_type, $id_criterion_group_linked, $id_search,$force_delete = false,$desindexGroup = true) {
		$id_criterion_group = AdvancedSearchCriterionGroupClass::getIdCriterionGroupByTypeAndIdLinked($id_search,$criterions_group_type,$id_criterion_group_linked);
		$objAdvancedSearchCriterionGroupClass = new AdvancedSearchCriterionGroupClass($id_criterion_group,$id_search);
		$objAdvancedSearchCriterionClass = new AdvancedSearchCriterionClass(false,$id_search);
		$criterions = $objAdvancedSearchCriterionClass->getCriterions($objAdvancedSearchCriterionGroupClass->id);
		foreach($criterions as $row) {
			$objAdvancedSearchCriterionClassD = new AdvancedSearchCriterionClass($row['id_criterion'],$id_search);
			$objAdvancedSearchCriterionClassD->delete();
		}
		if ($desindexGroup) {
			$objAdvancedSearchCriterionGroupClass->delete();
		}

		// Keep hide index if filter_by_emplacement is enable
		$ObjAdvancedSearchClass = new AdvancedSearchClass($id_search);
		if ($ObjAdvancedSearchClass->filter_by_emplacement && !$force_delete)
			self::indexFilterByEmplacement($id_search);
		return true;
	}
	
	public static function indexCriterionsGroup($criterions_group_type, $id_criterion_group_linked, $objSearch,$visible = 1,$checkIfIsIndexed = true,$update = false,$id_product = false,$id_criterion_linked = false,$criterion_value = false) {
		global $cookie;
		
		// Update product cache table, every time a criterion group is indexed (add missing id_product)
		$objSearch->updateCacheProduct();
		
		if ($checkIfIsIndexed && self::criterionsGroupIsIndexed($criterions_group_type, $id_criterion_group_linked, $objSearch->id)) {
			self::desIndexCriterionsGroup($criterions_group_type, $id_criterion_group_linked, $objSearch->id,true,true);
		}

		// For update cache
		$id_criterion_group = false;
		if ($update) {
			$id_criterion_group = AdvancedSearchCriterionGroupClass::getIdCriterionGroupByTypeAndIdLinked($objSearch->id,$criterions_group_type,$id_criterion_group_linked);
			if (!$id_criterion_group) return;
			// Refresh global cache
			if (!$id_product) {
				if ($criterions_group_type == 'price')
					self::deleteCachePriceGroup($objSearch->id,$id_criterion_group);
				else
					self::deleteCacheCriterionGroup($objSearch->id,$id_criterion_group);
			}
		}
		
		// Get array from Type
		if ($criterions_group_type == 'attribute') {
			$criterions_group = AdvancedSearchClass::getAttributeGroups($id_criterion_group_linked,false);
		}
		elseif ($criterions_group_type == 'feature') {
			$criterions_group = AdvancedSearchClass::getFeature($id_criterion_group_linked,false);
		}
		elseif ($criterions_group_type == 'category') {
			$criterions_group = array(
				'name'	=> Module::getInstanceByName('pm_advancedsearch4')->translateMultiple('categories',$id_criterion_group_linked),
			);
		}
		else {
			$criterions_group = array(
					'name'	=> Module::getInstanceByName('pm_advancedsearch4')->translateMultiple($criterions_group_type),
			);
		}

		// Check default language for avoid error
		if (!isset($criterions_group['name'][Configuration::get('PS_LANG_DEFAULT')]) || !trim($criterions_group['name'][Configuration::get('PS_LANG_DEFAULT')])) return;

		// Save on criterion group table
		$objAdvancedSearchCriterionGroupClass = new AdvancedSearchCriterionGroupClass($id_criterion_group,$objSearch->id);
		if (!$update)
			$objAdvancedSearchCriterionGroupClass->name = $criterions_group['name'];
		// Save criterion group only for available shop
		$objAdvancedSearchCriterionGroupClass->visible = (int)$visible;
		if (!$visible) $objAdvancedSearchCriterionGroupClass->position = 100;
		$objAdvancedSearchCriterionGroupClass->criterion_group_type = $criterions_group_type;
		$objAdvancedSearchCriterionGroupClass->id_criterion_group_linked = $id_criterion_group_linked;

		// Default style for boolean search
		if ($criterions_group_type == 'on_sale' || $criterions_group_type == 'stock' ||
				$criterions_group_type == 'available_for_order' || $criterions_group_type == 'online_only') {
			$objAdvancedSearchCriterionGroupClass->is_multicriteria = true;
			$objAdvancedSearchCriterionGroupClass->display_type = 4;
		}

		if ($objAdvancedSearchCriterionGroupClass->save()) {
			if ($criterions_group_type != 'price') {
				// Get array from Type
				if ($criterions_group_type == 'attribute')
					$criterions = AdvancedSearchClass::getAttributes($criterions_group['id_attribute_group'],false,$id_criterion_linked);
				elseif ($criterions_group_type == 'feature')
					$criterions = AdvancedSearchClass::getFeatureValuesFromValue($criterions_group['id_feature'],$cookie->id_lang,$criterion_value);
				elseif ($criterions_group_type == 'manufacturer')
					$criterions = AdvancedSearchClass::getManufacturers(false,$id_criterion_linked);
				elseif ($criterions_group_type == 'supplier')
					$criterions = AdvancedSearchClass::getSuppliers(false,$id_criterion_linked);
				elseif ($criterions_group_type == 'category')
					$criterions = AdvancedSearchClass::getCategoriesP(false,$id_criterion_linked,$id_criterion_group_linked, $objSearch->id);
				/**
				 * New groups from 4.7
				 */
				elseif ($criterions_group_type == 'on_sale' || $criterions_group_type == 'stock' ||
				$criterions_group_type == 'available_for_order' || $criterions_group_type == 'online_only')
					$criterions = self::getBooleanTrueCriteria();

				elseif ($criterions_group_type == 'weight' || $criterions_group_type == 'width' ||
						$criterions_group_type == 'height' || $criterions_group_type == 'depth')
						$criterions = self::getProductsFieldValues($criterions_group_type,$criterion_value);

				elseif ($criterions_group_type == 'condition')
						$criterions = self::getConditionCriteria($criterion_value);

				// Prepare multiple product criteria insert
				$sql_insert_multiple = array();
				$sql_insert_multiple_header = 'INSERT IGNORE INTO `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int)$objSearch->id.'` (`id_cache_product`, `id_criterion`) VALUES ';
				$position = -1;
				$current_criterion_keys = array_keys($criterions);
				
				// Save on criterion table
				while(sizeof($criterions)) {
					$position++;
					$current_criterion = array_shift($current_criterion_keys);
					
					$row = $criterions[$current_criterion];
					unset($criterions[$current_criterion]);
					self::$current_indexation++;
					if ($criterions_group_type == 'category' && self::$current_indexation == self::$limit_indexation) {
						self::$start_indexation += self::$limit_indexation;
						$criterions = AdvancedSearchClass::getCategoriesP(false,$id_criterion_linked,$id_criterion_group_linked, $objSearch->id);
						self::$current_indexation = 0;
						$current_criterion_keys = array_keys($criterions);
						$current_criterion = array_shift($current_criterion_keys);
					}
					if ((!isset($row['single_value']) || !$row['single_value']) && (!isset($row['name'][Configuration::get('PS_LANG_DEFAULT')]) || !trim($row['name'][Configuration::get('PS_LANG_DEFAULT')]))) continue;

					if ($criterions_group_type == 'attribute')
						$current_id_criterion_linked = $row['id_attribute'];
					elseif ($criterions_group_type == 'feature')
						$current_id_criterion_linked = $row['id_feature_value'];
					elseif ($criterions_group_type == 'manufacturer')
						$current_id_criterion_linked = $row['id_manufacturer'];
					elseif ($criterions_group_type == 'supplier')
						$current_id_criterion_linked = $row['id_supplier'];
					elseif ($criterions_group_type == 'category')
						$current_id_criterion_linked = $row['id_category'];
					/**
					 * New groups from 4.7
					 */
					elseif ($criterions_group_type == 'on_sale' || $criterions_group_type == 'stock' ||
				$criterions_group_type == 'available_for_order' || $criterions_group_type == 'online_only')
						$current_id_criterion_linked = $row['value'];
					elseif ($criterions_group_type == 'weight' || $criterions_group_type == 'width' ||
								$criterions_group_type == 'height' || $criterions_group_type == 'depth')
							$current_id_criterion_linked = $row['single_value'];
					elseif ($criterions_group_type == 'condition') {
						$current_id_criterion_linked = 0;
						$criterion_value = $row['name'][$cookie->id_lang];
					}

					// For update cache
					$id_criterion = false;
					if ($update) {
						if ($id_criterion_linked)
							$id_criterion = AdvancedSearchCriterionClass::getIdCriterionByTypeAndIdLinked($objSearch->id,$criterions_group_type,$id_criterion_group_linked,$id_criterion_linked);
						elseif ($criterion_value && ($criterions_group_type == 'weight' || $criterions_group_type == 'width' ||
						$criterions_group_type == 'height' || $criterions_group_type == 'depth'))
							$id_criterion = AdvancedSearchCriterionClass::getIdCriterionByTypeAndSingleValue($objSearch->id,$criterions_group_type,$id_criterion_group_linked,$criterion_value);
						elseif ($criterion_value)
							$id_criterion = AdvancedSearchCriterionClass::getIdCriterionByTypeAndValue($objSearch->id,$cookie->id_lang,$criterions_group_type,$id_criterion_group_linked,$criterion_value);
						elseif ($current_id_criterion_linked && ($criterions_group_type == 'weight' || $criterions_group_type == 'width' ||
								$criterions_group_type == 'height' || $criterions_group_type == 'depth'))
								$id_criterion = AdvancedSearchCriterionClass::getIdCriterionByTypeAndSingleValue($objSearch->id,$criterions_group_type,$id_criterion_group_linked,$current_id_criterion_linked);
						elseif ($current_id_criterion_linked) $id_criterion = AdvancedSearchCriterionClass::getIdCriterionByTypeAndIdLinked($objSearch->id,$criterions_group_type,$id_criterion_group_linked,$current_id_criterion_linked);
					}
					$objAdvancedSearchCriterionClass = new AdvancedSearchCriterionClass($id_criterion,$objSearch->id);

					if ($criterions_group_type == 'attribute' ||
					$criterions_group_type == 'feature' ||
					$criterions_group_type == 'manufacturer' ||
					$criterions_group_type == 'supplier' ||
					$criterions_group_type == 'category' ||
					/**
					 * New groups from 4.7
					 */
					$criterions_group_type == 'on_sale' || $criterions_group_type == 'stock' ||
				$criterions_group_type == 'available_for_order' || $criterions_group_type == 'online_only' ||
							$criterions_group_type == 'condition')
						$objAdvancedSearchCriterionClass->value = $row['name'];

					if (isset($row['single_value']) && $row['single_value'])
							$objAdvancedSearchCriterionClass->single_value = $row['single_value'];
					// Indexation couleurs
					if ($criterions_group_type == 'attribute' && $row['color']) {
						$objAdvancedSearchCriterionClass->color = $row['color'];
					}
					$objAdvancedSearchCriterionClass->id_criterion_group = $objAdvancedSearchCriterionGroupClass->id;
					// Set id linked from Type
					$objAdvancedSearchCriterionClass->id_criterion_linked = $current_id_criterion_linked;
					// Set relative informations for category group
					if ($criterions_group_type == 'category') {
						$objAdvancedSearchCriterionClass->level_depth = $row['level_depth'];
						$objAdvancedSearchCriterionClass->id_parent = $row['id_parent'];
					}

					if (!$update)
						$objAdvancedSearchCriterionClass->position = $position;
					if (!$id_product) {
						// Cache product result for this criterion
						if ($criterions_group_type == 'attribute')
							$productsIdCache = AdvancedSearchClass::getProductsIdFromAttribute($objSearch->id,$row['id_attribute']);
						elseif ($criterions_group_type == 'feature')
							$productsIdCache = AdvancedSearchClass::getProductsIdFromFeatureValue($objSearch->id,$criterions_group['id_feature'],$row['name'][Configuration::get('PS_LANG_DEFAULT')],Configuration::get('PS_LANG_DEFAULT'));
						elseif ($criterions_group_type == 'manufacturer')
							$productsIdCache = AdvancedSearchClass::getProductsIdFromManufacturer($objSearch->id,$row['id_manufacturer']);
						elseif ($criterions_group_type == 'supplier')
							$productsIdCache = AdvancedSearchClass::getProductsIdFromSupplier($objSearch->id,$row['id_supplier']);
						elseif ($criterions_group_type == 'category')
							$productsIdCache = AdvancedSearchClass::getProductsIdFromCategory($objSearch->id,$row['id_category'],$objSearch->recursing_indexing);
						/**
						 * New groups from 4.7
						 */
						elseif ($criterions_group_type == 'on_sale' || $criterions_group_type == 'stock' ||
				$criterions_group_type == 'available_for_order' || $criterions_group_type == 'online_only' ||
							$criterions_group_type == 'condition')
							$productsIdCache = AdvancedSearchClass::getProductsIdFromProductField($objSearch->id,$row['value'],$criterions_group_type);
						elseif ($criterions_group_type == 'weight' || $criterions_group_type == 'width' ||
								$criterions_group_type == 'height' || $criterions_group_type == 'depth')
								$productsIdCache = AdvancedSearchClass::getProductsIdFromProductField($objSearch->id,$row['single_value'],$criterions_group_type);

					} else {
						$productsIdCache = array(array('id_cache_product'=>self::getIdCacheProductFromIdProduct($objSearch->id,$id_product)));
					}
					// Save criteria
					if ($objAdvancedSearchCriterionClass->save()) {
						foreach($productsIdCache as $row) {
							$sql_insert_multiple[] = '('.(int)$row['id_cache_product'].', '.(int)$objAdvancedSearchCriterionClass->id.')';
							// Save multiple products criteria
							self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,200);
						}
						// Save multiple products criteria
						self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,1);
					}
				}
				unset($criterions, $productsIdCache);

				// Save multiple products criteria
				self::sqlBulkInsert($sql_insert_multiple_header,$sql_insert_multiple,1);
			} elseif ($criterions_group_type == 'price') {
				// Update product cache prices
				AdvancedSearchClass::setProductsPrices($objSearch->id, $objAdvancedSearchCriterionGroupClass->id, $id_product);
				// Update specific prices product cache price
				AdvancedSearchClass::setProductsSpecificPrices($objSearch->id, $objAdvancedSearchCriterionGroupClass->id, $id_product);
			}
		}
		self::$start_indexation = 0;
		self::$limit_indexation = 1000;
		self::$current_indexation = 0;
		return $objAdvancedSearchCriterionGroupClass->id;
	}
	
	public static function sqlBulkInsert($sql_insert_multiple_header,&$sql_insert_multiple,$size) {
		if (sizeof($sql_insert_multiple) >= $size) {
			Db::getInstance()->Execute($sql_insert_multiple_header.implode(',',$sql_insert_multiple));
			$sql_insert_multiple = array();
		}
	}
	
	protected static function isMyISAMEngine($tableName) {
		$tablesStatus = Db::getInstance()->ExecuteS('SHOW TABLE STATUS LIKE "'._DB_PREFIX_.$tableName.'"');
		foreach ($tablesStatus as $tableStatus)
			if (isset($tableStatus['Engine']) && strtolower($tableStatus['Engine']) == 'myisam' && isset($tableStatus['Name']) && $tableStatus['Name'] == _DB_PREFIX_.$tableName )
				return true;
		return false;
	}
	
	public static function optimizedSearchTables($idSearch, $optimizeAll = false) {
		if ($optimizeAll) {
			$tableToOptimize = array(
				'category',
				'feature_value',
				'feature_value_lang',
				'feature_product',
				'image',
				'image_lang',
				'manufacturer',
				'pm_advancedsearch_criterion_'.(int)$idSearch,
				'pm_advancedsearch_cache_product_criterion_'.(int)$idSearch,
				'pm_advancedsearch_cache_product_'.(int)$idSearch,
				'pm_advancedsearch_product_price_'.(int)$idSearch,
				'product',
				'product_attribute',
				'product_attribute_combination',
				'product_attribute_image',
				'supplier',
				'specific_price',
				'specific_price_priority',
				'tax',
				'tax_rule',
			);
			if (_PS_VERSION_ >= 1.5)
				$tableToOptimize = array_merge($tableToOptimize, array('category_shop', 'image_shop', 'product_attribute_shop', 'product_shop', 'specific_price_rule', 'stock_available'));
		} else {
			$tableToOptimize = array(
				'pm_advancedsearch_criterion_'.(int)$idSearch,
				'pm_advancedsearch_cache_product_criterion_'.(int)$idSearch,
				'pm_advancedsearch_cache_product_'.(int)$idSearch,
				'pm_advancedsearch_product_price_'.(int)$idSearch,
			);
		}
		foreach ($tableToOptimize as $tableName) {
			// Check if the table engine is MyISAM
			if (self::isMyISAMEngine($tableName))
				Db::getInstance()->Execute('OPTIMIZE TABLE `'._DB_PREFIX_.$tableName.'`');
		}
	}
	
	public static function getIdCacheProductFromIdProduct($id_search,$id_product) {
		$row = Db::getInstance()->getRow('
		SELECT `id_cache_product`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int)$id_search.'`
		WHERE `id_product` = '.(int)($id_product));
		return isset($row['id_cache_product']) ? $row['id_cache_product'] : false;
	}
	
	public static function isColorAttributesGroup($id_attribute_group) {
		$row = Db::getInstance()->getRow('
		SELECT `is_color_group`
		FROM `'._DB_PREFIX_.'attribute_group`
		WHERE `id_attribute_group` = '.(int)($id_attribute_group));
		return isset($row) ? $row['is_color_group'] : false;
	}
	
	/**
	 *
	 * Only use for category criterias
	 */
	public static function getIdLinkedFromCriterion($id_criterion, $id_search, &$level_depth = false) {
		$results = Db::getInstance()->ExecuteS('
		SELECT ac.`id_criterion_linked`, ac.`id_parent`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		WHERE ac.`id_criterion` '.(is_array($id_criterion) ? ' IN ('.implode(', ',$id_criterion).')':' = '.intval($id_criterion)));
		$linked_categories = false;
		if ($results && sizeof($results)) {
			$linked_categories = array();
			foreach($results as $row) {
				$linked_categories[] = $row['id_criterion_linked'];
			}
			// If has no child, get parent
			if (count($results) == 1 && (!self::categoryHasChild($results[0]['id_criterion_linked']))) {
				$linked_categories = array();
				$linked_categories[] = $results[0]['id_parent'];
				// Reduce level_depth
				if ($level_depth)
					$level_depth--;
			}
		}
		return $linked_categories;
	}
	
	public static function getCriterionsWithIdGroupFromIdLinked($criterion_group_type,$id_criterion_linked,$id_search,$current_depth = false) {
		$results = Db::getInstance()->ExecuteS('
		SELECT ac.`id_criterion`, ac.`id_criterion_group`, acg.`visible`,ac.`id_criterion_linked`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg ON acg.`id_criterion_group` = ac.`id_criterion_group`
		WHERE ac.`visible` = 1 AND acg.`criterion_group_type` = "'.pSQL($criterion_group_type).'" AND ac.`id_criterion_linked` '.(is_array($id_criterion_linked) ? ' IN ('.implode(', ',$id_criterion_linked).')':' = '.intval($id_criterion_linked)).'');

		$selected_criterion = false;
		if ($results && sizeof($results)) {
			$selected_criterion = array();
			foreach($results as $row) {
				if (!isset($selected_criterion[$row['id_criterion_group']])) $selected_criterion[$row['id_criterion_group']] = array();
				$selected_criterion[$row['id_criterion_group']][] = $row['id_criterion'];
			}
		}
		return $selected_criterion;
	}
	
	public static function cleanArrayCriterion($selected_criterion) {
		foreach($selected_criterion as $id_criterion_group => $criteria) {
			foreach($criteria as $k => $criterion) {
				if (!trim($criterion)) unset($selected_criterion[$id_criterion_group][$k]);
			}
			if (!$selected_criterion[$id_criterion_group]) unset($selected_criterion[$id_criterion_group]);
			else $selected_criterion[$id_criterion_group] = array_values($selected_criterion[$id_criterion_group]);
		}
		return $selected_criterion;
	}
	
	public static function makeLeftJoinWhereCriterion($fromMethod, $search,$id_lang,$selected_criterion,$selected_criteria_groups_type = array(),$current_id_criterion_group = false,$is_attribute_group = false,$id_currency = false,$id_country = false,$id_group = false,$include_price_table=false,$include_product_table=false,$group_type = false, $criterion_groups = array()) {
		if (_PS_VERSION_ >= 1.5) {
			$context = Context::getContext();
			if (isset($context->cart) && is_object($context->cart) && isset($context->cart->id_customer))
				$id_customer = $context->cart->id_customer;
			else $id_customer = false;
			if (!$id_currency) $id_currency = $context->currency->id;
		} else {
			global $cart;
			if (is_object($cart) && isset($cart->id_customer))
				$id_customer = $cart->id_customer;
			else $id_customer = false;
			if (!$id_currency) $id_currency = Currency::getCurrent()->id;
		}

		$join_criterion_tables = array();
		
		$join_criterion = array();
		$count_criterion = array();
		$where_criterion = array();
		$where_qty 		= array();
		$field_select = array();
		$attribute_selected = false;
		
		// If stock management is disabled, disable stock check on search
		$stock_management = (int)(Configuration::get('PS_STOCK_MANAGEMENT')) ? true : false;
		if (!$stock_management) $search['search_on_stock'] = false;
		
		// If stock management is disabled, disable stock check on search
		if ($group_type == 'stock' && $stock_management)
			$strict_stock = true;
		else
			$strict_stock = false;
		
		// If we have "In stock" criterion group selected, search on stock must be on
		if ($stock_management && AdvancedSearchCoreClass::_isFilledArray($selected_criterion) && AdvancedSearchCoreClass::_isFilledArray($criterion_groups)) {
			foreach ($selected_criterion as $id_criterion_group_tmp=>$id_criterion_tmp) {
				foreach ($criterion_groups as $criterion_group) {
					if ($criterion_group['id_criterion_group'] == $id_criterion_group_tmp && $criterion_group['criterion_group_type'] == 'stock') {
						$search['search_on_stock'] = true;
						$strict_stock = true;
						break;
					}
				}
			}
		}
		
		$having = array();

		$where_price_range = array();
		if (_PS_VERSION_ >= 1.5)
			$table_stock_index = 0;
		$idSelectedCriteria = implode('-',self::array_values_recursive($selected_criterion));
		// $cacheKey = $search['id_search'].$idSelectedCriteria.$current_id_criterion_group.(int)$include_price_table.(int)$include_product_table;
		$cacheKey = $fromMethod.$search['id_search'].$idSelectedCriteria.(int)$current_id_criterion_group.(int)$include_price_table.(int)$include_product_table.(int)$id_lang.(int)$is_attribute_group.(int)$group_type.(int)$strict_stock;
		if (isset(self::$_cacheLeftJoinWhereCriterion[$cacheKey]))
			return self::$_cacheLeftJoinWhereCriterion[$cacheKey];
		// Make union if option display_empty_criteria is activated
		if ($group_type && !$include_product_table && $search['display_empty_criteria'])
			$make_union = true;
		else $make_union = false;
		// Does query include price ?
		$price_is_included = false;
		
		// Compatibility 1.5 multishop
		if (_PS_VERSION_ >= 1.5) {
			$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_shop` ps ON ('.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' ps.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '').'ps.id_shop IN ('.implode(', ', Shop::getContextListShopID()).') AND ps.`id_product` = acp.`id_product`)';
			$join_criterion_tables[] = 'ps';
		}
		
		if (AdvancedSearchCoreClass::_isFilledArray($selected_criterion)) {
			// Check if taxes is enable
			$usetax = Product::getTaxCalculationMethod($id_customer);
			$price_is_included = false;
			$attribute_qty_compare_on_join = array();
			$now = date('Y-m-d H:i:s');
			foreach($selected_criterion as $id_criterion_group => $id_criterion) {
				if ($selected_criteria_groups_type[$id_criterion_group]['criterion_group_type'] == 'stock') {
					$strict_stock = true;
					continue;
				}
				$join_criterion_table = false;
				$join_price_table = false;
				$where_join = array();
				$where_single_value_range = array();
				$where_translatable_value_range = array();
				// Check how the search is maked
				if (isset($selected_criteria_groups_type[$id_criterion_group]) && ($selected_criteria_groups_type[$id_criterion_group]['display_type'] == 5 || $selected_criteria_groups_type[$id_criterion_group]['range'])) {

					$id_currency_default = Configuration::get('PS_CURRENCY_DEFAULT');
					if ($id_currency != $id_currency_default) {
						$currency = new Currency($id_currency);
						$conversion_rate = $currency->conversion_rate;
					} else {
						$conversion_rate = 0;
					}
					$where_price_criterion = array();
					foreach($id_criterion as $range) {
						$range = explode('-',$range);
						$original_range = $range;
						if ($conversion_rate > 0) {
							$range[0] = $range[0] / $conversion_rate;
							if (isset($range[1])) $range[1] = $range[1] / $conversion_rate;
						}
						
						// Join on dedicated criterion table excepted on price criteria group
						if ($selected_criteria_groups_type[$id_criterion_group]['criterion_group_type'] != 'price') {
							if (!in_array('acpc'.(int)$id_criterion_group, $join_criterion_tables)) {
								$join_criterion[] = 'JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $search['id_search'].'` acpc'.(int)$id_criterion_group.' ON ( acp.`id_cache_product` = acpc'.(int)$id_criterion_group.'.`id_cache_product`)';
								$join_criterion_tables[] = 'acpc'.(int)$id_criterion_group;
							}
						}
						// Search by range and single value
						if (in_array($selected_criteria_groups_type[$id_criterion_group]['criterion_group_type'],array('weight','width','height','depth'))) {
							$where_single_value_range[] = 'ROUND(ac'.(int)$id_criterion_group.'.`single_value`,5) >= ROUND("'.$range[0].'",5)'.(isset($range[1]) && $range[1] ? ' AND ROUND(ac'.(int)$id_criterion_group.'.`single_value`,5) <= ROUND("'.$range[1].'",5)':'');
						}
						// Search by price range
						elseif ($selected_criteria_groups_type[$id_criterion_group]['criterion_group_type'] == 'price') {
								$groupReductionValue = ((int)Group::getReductionByIdGroup($id_group) > 0 ? (1 - (int)Group::getReductionByIdGroup($id_group)/100) : 1);
								$price_is_included = true;
								$where_price_criterion[] = ' (
								/*AS4-PR-Start*/
								IF(app.`is_specific` = 1 AND app.`id_currency` IN (0, '.$id_currency.'),
									(app.`price_wt` - IF(app.`reduction_type`=\'amount\', (app.`reduction_amount`'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').'), app.`reduction_amount`) ) * IF(grc.`reduction` > 0, (1 - grc.`reduction`/100), '.$groupReductionValue.') >= FLOOR('.intval($original_range[0]).')'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').'
									,
									(app.`price_wt` - IF(app.`reduction_type`=\'amount\', (app.`reduction_amount`'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').'), app.`reduction_amount`) ) * IF(grc.`reduction` > 0, (1 - grc.`reduction`/100), '.$groupReductionValue.') >= FLOOR('.intval($range[0]).')'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').'
								)
								'.(isset($range[1]) && $range[1] ? '
								AND 
								IF(app.`is_specific` = 1 AND app.`id_currency` IN (0, '.$id_currency.'),
									(app.`price_wt` - IF(app.`reduction_type`=\'amount\', (app.`reduction_amount`'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').'), app.`reduction_amount`) ) * IF(grc.`reduction` > 0, (1 - grc.`reduction`/100), '.$groupReductionValue.') <= CEIL('.intval($original_range[1]).')'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').'
									,
									(app.`price_wt` - IF(app.`reduction_type`=\'amount\', (app.`reduction_amount`'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').'), app.`reduction_amount`) ) * IF(grc.`reduction` > 0, (1 - grc.`reduction`/100), '.$groupReductionValue.') <= CEIL('.intval($range[1]).')'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').'
								)
								' : '').'
								/*AS4-PR-End*/
								AND app.`id_country` IN (0, '.(int)$id_country.') AND 
								app.`id_group` IN (0, '.(int)$id_group.') AND 
								((app.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= app.`from`) AND (app.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= app.`to`)) '.
								(_PS_VERSION_ >= 1.5 ? ' AND app.`id_shop` IN (0, '.implode(', ', Shop::getContextListShopID()).') ' : '') . ') ';
						}
						// Search by range and translatable value
						else {
							$where_single_value_range[] = 'ac'.(int)$id_criterion_group.'.`id_criterion_group` = '.(int)$id_criterion_group;
							$where_translatable_value_range[] = 'ROUND(CAST(REPLACE(acl'.(int)$id_criterion_group.'.`value`, ",", ".") AS DECIMAL(10,2)), 5) >= ROUND("'.$range[0].'",5)'.(isset($range[1]) && $range[1] ? ' AND ROUND(CAST(REPLACE(acl'.(int)$id_criterion_group.'.`value`, ",", ".") AS DECIMAL(10,2)), 5) <= ROUND("'.$range[1].'",5)':'');
						}
					}
					if (isset($where_price_criterion) && AdvancedSearchCoreClass::_isFilledArray($where_price_criterion)) {
						$where_criterion[] = '( '.implode(' OR ', $where_price_criterion) . ' )';
					}
				}
				else {
					$current_where = '`id_criterion` IN('.implode(', ',$id_criterion).')';
					if ($selected_criteria_groups_type[$id_criterion_group]['criterion_group_type'] == 'attribute') { $prev_where_criterion = $current_where; }
					$where_join[] = 'acpc'.(int)$id_criterion_group.'.'.$current_where;
					// Join on dedicated criterion table
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $search['id_search'].'` acpc'.(int)$id_criterion_group.' ON ( acp.`id_cache_product` = acpc'.(int)$id_criterion_group.'.`id_cache_product`'.(AdvancedSearchCoreClass::_isFilledArray($where_join) ?' AND '.implode(' OR ',$where_join) : '' ).')';
					$join_criterion_tables[] = 'acpc'.(int)$id_criterion_group;
				}
				if ($selected_criteria_groups_type[$id_criterion_group]['criterion_group_type'] != 'price')
					$count_criterion[$id_criterion_group] = 'acpc'.(int)$id_criterion_group.'.`id_cache_product`';
				else
					$count_criterion[$id_criterion_group] = 'app.`id_cache_product`';
				// Make join to check attribute qty
				if (isset($selected_criteria_groups_type[$id_criterion_group]) && $selected_criteria_groups_type[$id_criterion_group]['criterion_group_type'] == 'attribute') {
					$attribute_selected = true;
					$join_criterion['criterion_'.(int)$search['id_search'].'_'.(int)$id_criterion_group] = 'JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'` ac'.(int)$id_criterion_group.' ON (acpc'.(int)$id_criterion_group.'.`id_criterion` = ac'.(int)$id_criterion_group.'.`id_criterion`)';
					/*
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute_combination` pac'.(int)$id_criterion_group.' ON (pac'.(int)$id_criterion_group.'.`id_attribute` = ac'.(int)$id_criterion_group.'.`id_criterion_linked`)';
					*/
					
					if (!isset($previousIdCriterionGroupSelected)) $previousIdCriterionGroupSelected = null;
					
					$join_criterion['pa'.(int)$id_criterion_group] = 'JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$id_criterion_group.' ON (pa'.(int)$id_criterion_group.'.`id_product` = acp.`id_product`)';
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute_combination` pac'.(int)$id_criterion_group.' ON (pa'.(int)$id_criterion_group.'.`id_product_attribute` = pac'.(int)$id_criterion_group.'.`id_product_attribute` AND pac'.(int)$id_criterion_group.'.`id_attribute` = ac'.(int)$id_criterion_group.'.`id_criterion_linked`'.($previousIdCriterionGroupSelected != null ? ' AND pa'.(int)$previousIdCriterionGroupSelected.'.`id_product_attribute` = pa'.(int)$id_criterion_group.'.`id_product_attribute` ' : '').')';
					$join_criterion_tables[] = 'ac'.(int)$id_criterion_group;
					$join_criterion_tables[] = 'pa'.(int)$id_criterion_group;
					$join_criterion_tables[] = 'pac'.(int)$id_criterion_group;
					
					$previousIdCriterionGroupSelected = (int)$id_criterion_group;

					// Set the id of join table to check attribute qty
					if (!isset($attribute_check_table) && (!$include_product_table && !$search['display_empty_criteria'])) {
						$attribute_check_table = $id_criterion_group;
					} elseif (!isset($attribute_check_table)) {
						$attribute_check_table = $id_criterion_group;
						// Select attribute image on priority
						if ($search['priority_on_combination_image'] && $include_product_table) {
							$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'product_attribute_image` pai ON (pac'.(int)$attribute_check_table.'.`id_product_attribute` = pai.`id_product_attribute`)';
							$join_criterion_tables[] = 'pai';
							$field_select[] = 'pai.id_image as attribute_image';
						}
					}
					$attribute_qty_compare_on_join[] = 'pa'.(int)$attribute_check_table.'.`id_product_attribute` = pac'.(int)$id_criterion_group.'.`id_product_attribute`';

				}
				// Include table for single value range
				if (AdvancedSearchCoreClass::_isFilledArray($where_single_value_range) && !AdvancedSearchCoreClass::_isFilledArray($where_translatable_value_range)) {
					$join_criterion['criterion_'.(int)$search['id_search'].'_'.(int)$id_criterion_group] = 'JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'` ac'.(int)$id_criterion_group.' ON (acpc'.(int)$id_criterion_group.'.`id_criterion` = ac'.(int)$id_criterion_group.'.`id_criterion` AND ('.implode(' OR ',$where_single_value_range).'))';
				}
				// Include table for translatable value range
				if (AdvancedSearchCoreClass::_isFilledArray($where_translatable_value_range)) {
					$join_criterion['criterion_'.(int)$search['id_search'].'_'.(int)$id_criterion_group] = 'JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'` ac'.(int)$id_criterion_group.' ON (acpc'.(int)$id_criterion_group.'.`id_criterion` = ac'.(int)$id_criterion_group.'.`id_criterion` AND ('.implode(' OR ',$where_single_value_range).'))';
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'_lang` acl'.(int)$id_criterion_group.' ON (ac'.(int)$id_criterion_group.'.`id_criterion` = acl'.(int)$id_criterion_group.'.`id_criterion` AND acl'.(int)$id_criterion_group.'.`id_lang` = '.(int)$id_lang.' AND ('.implode(' OR ',$where_translatable_value_range).'))';
					$join_criterion_tables[] = 'ac'.(int)$id_criterion_group;
					$join_criterion_tables[] = 'acl'.(int)$id_criterion_group;
				}
			}
			if ($strict_stock || $search['search_on_stock'] || $include_product_table || $price_is_included) {
				if ($strict_stock) {
					$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'product` p ON ('.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' p.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '').' p.`id_product` = acp.`id_product`)';
					$join_criterion_tables[] = 'p';
					if ( _PS_VERSION_ < 1.5)
						$where_qty[] = 'p.`quantity` > 0';
				}
				else {
					// Afficher les produits en stock uniquement
					$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'product` p ON ('.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' p.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '').' p.`id_product` = acp.`id_product`)';
					$join_criterion_tables[] = 'p';
					if ($search['search_on_stock'] && _PS_VERSION_ < 1.5)
						$where_qty[] = 'IF(p.`quantity` > 0, 1, IF(p.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, p.`out_of_stock` = 1))';
				}
			}
			// Include Price table
			if ($price_is_included || $include_product_table) {
				// Tax
				$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON ('.(_PS_VERSION_ >= 1.5 ? 'ps' : 'p').'.`id_tax_rules_group` = tr.`id_tax_rules_group`
				AND tr.`id_country` = '.(int)(_PS_VERSION_ >= 1.5?Context::getContext()->country->id:Country::getDefaultCountryId()).'
				AND tr.`id_state` = 0)';
				$join_criterion[] = ' LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)';
				$join_criterion_tables[] = 'tr';
				$join_criterion_tables[] = 't';
				// Group reduction for category
				$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'group_reduction` grc ON (grc.`id_group`='.(int)$id_group.' AND '.(_PS_VERSION_ >= 1.5 ? 'ps' : 'p').'.`id_category_default` = grc.`id_category`)';
				$join_criterion_tables[] = 'grc';
			}

			// Include Price index table
			if ($price_is_included) {
				$field_select[] = self::_getScoreQuery((_PS_VERSION_ >= 1.5 ? Context::getContext()->shop->id : 0), $id_currency, $id_country, $id_group);
				$join_criterion[] = 'JOIN `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int) $search['id_search'].'` app ON ( acp.`id_cache_product` = app.`id_cache_product` AND ((app.`valid_id_specific_price`=1 AND app.`is_specific`=1) OR app.`has_no_specific`=1) '.(_PS_VERSION_ >= 1.5 ? ' AND app.`id_shop` IN (0, '.implode(', ', Shop::getContextListShopID()).') ' : '').')';
				$join_price_table = true;
			}

			// Make join to check stock on product table
			if ($search['search_on_stock'] || $strict_stock && !$group_type && !isset($attribute_check_table)) {
				if (_PS_VERSION_ >= 1.5) {
					$table_stock_index++;
					if ($strict_stock) {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'sa'.$table_stock_index.'.`quantity` > 0';
					} else {
						if (!(($group_type || $include_product_table) && isset($attribute_check_table) && sizeof($attribute_qty_compare_on_join))) {
							$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
							$join_criterion_tables[] = 'sa'.$table_stock_index;
							$where_qty[] = 'IF (sa'.$table_stock_index.'.`quantity` > 0, 1, IF (sa'.$table_stock_index.'.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, sa'.$table_stock_index.'.`out_of_stock` = 1))';
						}
					}
				}
			}
			// Make join for check available stock on search block (during search)
			if ($current_id_criterion_group && isset($attribute_check_table) && $group_type) {
				if ($is_attribute_group) {
					if (!isset($previousIdCriterionGroupSelected)) $previousIdCriterionGroupSelected = null;
					
					// Added 20-06-2013
					if (!in_array('pa'.(int)$current_id_criterion_group, $join_criterion_tables)) {
						$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON (pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product`)';
						$join_criterion_tables[] = 'pa'.(int)$current_id_criterion_group;
					}
					//$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute_combination` pac'.(int)$current_id_criterion_group.' ON (pac'.(int)$current_id_criterion_group.'.`id_attribute` = ac.`id_criterion_linked`)';
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute_combination` pac'.(int)$current_id_criterion_group.' ON (pa'.(int)$current_id_criterion_group.'.`id_product_attribute` = pac'.(int)$current_id_criterion_group.'.`id_product_attribute` AND pac'.(int)$current_id_criterion_group.'.`id_attribute` = ac.`id_criterion_linked`'.($previousIdCriterionGroupSelected != null ? ' AND pa'.(int)$previousIdCriterionGroupSelected.'.`id_product_attribute` = pa'.(int)$current_id_criterion_group.'.`id_product_attribute` ' : '').')';
					// /Added 20-06-2013
					$join_criterion_tables[] = 'pac'.(int)$current_id_criterion_group;
					$attribute_qty_compare_on_join[] = 'pa'.(int)$attribute_check_table.'.`id_product_attribute` = pac'.(int)$current_id_criterion_group.'.`id_product_attribute`';
					
					$previousIdCriterionGroupSelected = (int)$current_id_criterion_group;
				}
				// For count criteria
			} else if (($search['search_on_stock'] || $strict_stock) && $group_type && !isset($attribute_check_table)) {
				if ($strict_stock && _PS_VERSION_ < 1.5) {
					// $join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON ('.($is_attribute_group ? 'pa'.(int)$current_id_criterion_group.'.`id_product_attribute` = pac'.(int)$current_id_criterion_group.'.`id_product_attribute` AND ' : '' ).'pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product`)';
					$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON (pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product` '.($fromMethod != 'getCriterionsForSearchBloc' ? ' AND pa'.(int)$current_id_criterion_group.'.id_product_attribute = ac.id_criterion_linked ' : '').')';
					$join_criterion_tables[] = 'pa'.(int)$current_id_criterion_group;
					$where_qty[] = 'IF (pa'.(int)$current_id_criterion_group.'.`quantity` = NULL, IF (p.`quantity` > 0, 1, IF (p.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, p.`out_of_stock` = 1)), pa'.(int)$current_id_criterion_group.'.`quantity` > 0)';
				}
				else {
					// $join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON ('.($is_attribute_group ? 'pa'.(int)$current_id_criterion_group.'.`id_product_attribute` = pac'.(int)$current_id_criterion_group.'.`id_product_attribute` AND ' : '' ).'pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product`)';
					$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON (pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product` '.($fromMethod != 'getCriterionsForSearchBloc' ? ' AND pa'.(int)$current_id_criterion_group.'.id_product_attribute = ac.id_criterion_linked ' : '').')';
					$join_criterion_tables[] = 'pa'.(int)$current_id_criterion_group;
					if ($search['search_on_stock'] && _PS_VERSION_ < 1.5)
						$where_qty[] = 'IF (pa'.(int)$current_id_criterion_group.'.`quantity` = NULL, IF (p.`quantity` > 0, 1, IF (p.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, p.`out_of_stock` = 1)), IF (pa'.(int)$current_id_criterion_group.'.`quantity` > 0, 1, IF (p.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, p.`out_of_stock` = 1)))';
				}
				if (_PS_VERSION_ >= 1.5 && $search['search_on_stock']) {
					$table_stock_index++;
					if ($strict_stock) {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` AND sa'.$table_stock_index.'.`id_product_attribute` = pa'.(int)$current_id_criterion_group.'.`id_product_attribute` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'sa'.$table_stock_index.'.`quantity` > 0';
					}
					else {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` AND sa'.$table_stock_index.'.`id_product_attribute` = pa'.(int)$current_id_criterion_group.'.`id_product_attribute` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'IF (sa'.$table_stock_index.'.`quantity` > 0,1, IF (sa'.$table_stock_index.'.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, sa'.$table_stock_index.'.`out_of_stock` = 1))';
					}
				}
				if ($is_attribute_group) {
					// $join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute_combination` pac'.(int)$current_id_criterion_group.' ON (pac'.(int)$current_id_criterion_group.'.`id_attribute` = ac.`id_criterion_linked`)';
					if (!in_array('pa'.(int)$current_id_criterion_group, $join_criterion_tables)) {
						$join_criterion['pa'.(int)$current_id_criterion_group] = 'JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON (pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product`)';
						$join_criterion_tables[] = 'pa'.(int)$current_id_criterion_group;
					}
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute_combination` pac'.(int)$current_id_criterion_group.' ON ('.($is_attribute_group ? 'pa'.(int)$current_id_criterion_group.'.`id_product_attribute` = pac'.(int)$current_id_criterion_group.'.`id_product_attribute` AND ' : '' ).'pac'.(int)$current_id_criterion_group.'.`id_attribute` = ac.`id_criterion_linked`)';
					$join_criterion_tables[] = 'pac'.(int)$current_id_criterion_group;
				}
			}

			// Make check attribute qty join
			if (($group_type || $include_product_table) && isset($attribute_check_table) && sizeof($attribute_qty_compare_on_join)) {
				if ($strict_stock && _PS_VERSION_ < 1.5) {
					if (!in_array('pa'.(int)$attribute_check_table, $join_criterion_tables)) {
						$join_criterion['pa'.(int)$attribute_check_table] = 'JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$attribute_check_table.' ON ('.implode(' AND ',$attribute_qty_compare_on_join).' AND pa'.(int)$attribute_check_table.'.`id_product` = acp.`id_product`)';
						$join_criterion_tables[] = 'pa'.(int)$attribute_check_table;
					}
					$where_qty[] = 'pa'.(int)$attribute_check_table.'.`quantity` > 0';
				}
				else {
					if (!in_array('pa'.(int)$attribute_check_table, $join_criterion_tables)) {
						$join_criterion['pa'.(int)$attribute_check_table] = 'JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$attribute_check_table.' ON ('.implode(' AND ',$attribute_qty_compare_on_join).' AND pa'.(int)$attribute_check_table.'.`id_product` = acp.`id_product`)';
						$join_criterion_tables[] = 'pa'.(int)$attribute_check_table;
					}
					if ($search['search_on_stock'] && _PS_VERSION_ < 1.5)
						$where_qty[] = 'IF (pa'.(int)$attribute_check_table.'.`quantity` > 0, 1, IF(p.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, p.`out_of_stock` = 1))';
					elseif (_PS_VERSION_ < 1.5)
						$where_qty[] = 'pa'.(int)$attribute_check_table.'.`quantity` IS NOT NULL';
				}
				if (_PS_VERSION_ >= 1.5 && ($search['search_on_stock'] || $strict_stock) ) {
					$table_stock_index++;
					if ($strict_stock) {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` AND sa'.$table_stock_index.'.`id_product_attribute` = pa'.(int)$attribute_check_table.'.`id_product_attribute` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'sa'.$table_stock_index.'.`quantity` > 0';
					}
					else {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` AND sa'.$table_stock_index.'.`id_product_attribute` = pa'.(int)$attribute_check_table.'.`id_product_attribute` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'IF (sa'.$table_stock_index.'.`quantity` > 0, 1, IF(sa'.$table_stock_index.'.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, sa'.$table_stock_index.'.`out_of_stock` = 1))';
					}
				}

			}
		}
		// Make join for check available attributes stock on search block (before search)
		else {
			if ((($search['search_on_stock'] || $strict_stock) && _PS_VERSION_ < 1.5) || ($include_product_table && $include_price_table)) {
				if ($strict_stock) {
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product` p ON ( '.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' p.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '').' p.`id_product` = acp.`id_product`)';
					$join_criterion_tables[] = 'p';
					if ( _PS_VERSION_ < 1.5)
						$where_qty[] = 'p.`quantity` > 0';
				}
				else {
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product` p ON ( '.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' p.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '').' p.`id_product` = acp.`id_product`)';
					$join_criterion_tables[] = 'p';
					if ($search['search_on_stock'] && _PS_VERSION_ < 1.5)
						$where_qty[] = 'IF (p.`quantity` > 0, 1, IF (p.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, p.`out_of_stock` = 1))';
				}
			}
			// Include Price table
			if (($include_product_table && $include_price_table)) {
				$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON ('.(_PS_VERSION_ >= 1.5 ? 'ps' : 'p').'.`id_tax_rules_group` = tr.`id_tax_rules_group`
				AND tr.`id_country` = '.(int)(_PS_VERSION_ >= 1.5?Context::getContext()->country->id:Country::getDefaultCountryId()).'
				AND tr.`id_state` = 0)';
				$join_criterion[] = ' LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)';
				$join_criterion_tables[] = 'tr';
				$join_criterion_tables[] = 't';
				// Group reduction for category
				$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'group_reduction` grc ON (grc.`id_group`='.(int)$id_group.' AND '.(_PS_VERSION_ >= 1.5 ? 'ps' : 'p').'.`id_category_default` = grc.`id_category`)';
				$join_criterion_tables[] = 'grc';
			}

			if ($is_attribute_group && ($search['search_on_stock'] || $strict_stock)) {
				if ($strict_stock && _PS_VERSION_ < 1.5) {
					// $join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON ('.($is_attribute_group ? 'pa'.(int)$current_id_criterion_group.'.`id_product_attribute` = pac'.(int)$current_id_criterion_group.'.`id_product_attribute` AND ' : '').'pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product`)';
					if (!in_array('pa'.(int)$current_id_criterion_group, $join_criterion_tables)) {
						$join_criterion['pa'.(int)$current_id_criterion_group] = 'JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON (pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product`)';
						$join_criterion_tables[] = 'pa'.(int)$current_id_criterion_group;
					}
					$where_qty[] = 'pa'.(int)$current_id_criterion_group.'.`quantity` > 0';
				} else {
					// $join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON ('.($is_attribute_group ? 'pa'.(int)$current_id_criterion_group.'.`id_product_attribute` = pac'.(int)$current_id_criterion_group.'.`id_product_attribute` AND ' : '').'pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product`)';
					if (!in_array('pa'.(int)$current_id_criterion_group, $join_criterion_tables)) {
						$join_criterion['pa'.(int)$current_id_criterion_group] = 'JOIN `'._DB_PREFIX_.'product_attribute` pa'.(int)$current_id_criterion_group.' ON (pa'.(int)$current_id_criterion_group.'.`id_product` = acp.`id_product`)';
						$join_criterion_tables[] = 'pa'.(int)$current_id_criterion_group;
					}
					if ($search['search_on_stock'] && _PS_VERSION_ < 1.5) {
						$where_qty[] = 'IF (pa'.(int)$current_id_criterion_group.'.`quantity` > 0, 1, IF(p.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, p.`out_of_stock` = 1))';
					}
				}
				if (_PS_VERSION_ >= 1.5) {
					$table_stock_index++;
					if ($strict_stock) {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` AND sa'.$table_stock_index.'.`id_product_attribute` = pa'.(int)$current_id_criterion_group.'.`id_product_attribute` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'sa'.$table_stock_index.'.`quantity` > 0';
					}
					else {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` AND sa'.$table_stock_index.'.`id_product_attribute` = pa'.(int)$current_id_criterion_group.'.`id_product_attribute` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'IF (sa'.$table_stock_index.'.`quantity` > 0, 1, IF (sa'.$table_stock_index.'.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, sa'.$table_stock_index.'.`out_of_stock` = 1))';
					}
				}
				if ($is_attribute_group) {
					// $join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute_combination` pac'.(int)$current_id_criterion_group.' ON (pac'.(int)$current_id_criterion_group.'.`id_attribute` = ac.`id_criterion_linked`)';
					$join_criterion[] = 'JOIN `'._DB_PREFIX_.'product_attribute_combination` pac'.(int)$current_id_criterion_group.' ON ('.($is_attribute_group ? 'pa'.(int)$current_id_criterion_group.'.`id_product_attribute` = pac'.(int)$current_id_criterion_group.'.`id_product_attribute` AND ' : '').'pac'.(int)$current_id_criterion_group.'.`id_attribute` = ac.`id_criterion_linked`)';
					$join_criterion_tables[] = 'pac'.(int)$current_id_criterion_group;
				}
			} elseif ($search['search_on_stock'] || $strict_stock) {
				if (_PS_VERSION_ >= 1.5) {
					$table_stock_index++;
					if ($strict_stock) {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'sa'.$table_stock_index.'.`quantity`';
					}
					else {
						$join_criterion[] = 'LEFT JOIN `'._DB_PREFIX_.'stock_available` sa'.$table_stock_index.' ON ( sa'.$table_stock_index.'.`id_product` = acp.`id_product` '.self::_addSqlShopRestrictionStockAvailable('sa'.$table_stock_index).')';
						$join_criterion_tables[] = 'sa'.$table_stock_index;
						$where_qty[] = 'IF(sa'.$table_stock_index.'.`quantity` > 0,1,IF(sa'.$table_stock_index.'.`out_of_stock` = 2, '.Configuration::get('PS_ORDER_OUT_OF_STOCK').' = 1, sa'.$table_stock_index.'.`out_of_stock` = 1))';
					}
				}
			}
		}

		if ($include_product_table) {
			if (_PS_VERSION_ >= 1.5) {
				// Check active status from product_shop table
				$where_criterion[] = 'ps.`active` = 1';
				$where_criterion[] = 'ps.`visibility` IN ("both", "search")';
			} else {
				if (isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList)) {
					$where_criterion[] = ' p.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') ';
				}
				$where_criterion[] = 'p.`active` = 1';
			}
		} else {
			if (isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList)) {
				$where_criterion[] = ' acp.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') ';
			}
		}
		if (AdvancedSearchCoreClass::_isFilledArray($where_qty)) {
			if ($is_attribute_group || $attribute_selected)
				$where_criterion[] = '('.implode(' AND ',$where_qty).')';
			else $where_criterion[] = '('.implode(' OR ',$where_qty).')';
		}
		
		// Only get max score for specific prices, only if price table is included
		if ($price_is_included && ($fromMethod == 'getCriterionsForSearchBloc' || $fromMethod == 'getQueryCountResults' || $fromMethod == 'getProductsSearched' || $fromMethod == 'getPriceRangeForSearchBloc')) {
			$idCacheProductMaxScoreQuery = 'SELECT DISTINCT app.id_cache_product FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ';
			
			if ($join_criterion && AdvancedSearchCoreClass::_isFilledArray($join_criterion)) {
				foreach ($join_criterion as $tmp_join_criterion) {
					if (_PS_VERSION_ >= 1.5 && preg_match('#stock_available#', $tmp_join_criterion)) continue;
					if (preg_match('#product_attribute_combination|product_attribute_image#', $tmp_join_criterion)) continue;
					$idCacheProductMaxScoreQuery .= ' '.$tmp_join_criterion;
				}
			}
			
			// We do not need quantity check for this query
			if (AdvancedSearchCoreClass::_isFilledArray($where_qty)) {
				$where_criterion_price_included = array_slice($where_criterion, 0, sizeof($where_criterion)-1);
			} else {
				$where_criterion_price_included = $where_criterion;
			}
			
			if ($where_criterion_price_included && AdvancedSearchCoreClass::_isFilledArray($where_criterion_price_included)) {
				$add_where = false;
				foreach ($where_criterion_price_included as $where) {
					// if (preg_match("#id_country#", $where)) continue;
					if (preg_match('#'.preg_quote('/*AS4-PR-Start*/').'#', $where) && preg_match('#'.preg_quote('/*AS4-PR-End*/').'#', $where)) {
						while (strpos($where, '/*AS4-PR-Start*/') !== false) {
							// Replace content
							$where_tmp = substr($where, 0, strpos($where, '/*AS4-PR-Start*/'));
							$where_tmp .= 'app.`id_currency` IN (0, '.$id_currency.')';
							$where_tmp .= substr($where, strpos($where, '/*AS4-PR-End*/') + strlen('/*AS4-PR-End*/'), strlen($where));
							$where = $where_tmp;
						}
					}
					
					if (!$add_where) {
						$idCacheProductMaxScoreQuery .= ' WHERE ' . $where;
						$add_where = true;
					} else {
						$idCacheProductMaxScoreQuery .= ' AND ' . $where;
					}
				}
			}
			
			$idCacheProductMaxScoreSQLResult = Db::getInstance()->ExecuteS($idCacheProductMaxScoreQuery);
			if (AdvancedSearchCoreClass::_isFilledArray($idCacheProductMaxScoreSQLResult)) {
				$idCacheProductMaxScoreResult = array();
				foreach ($idCacheProductMaxScoreSQLResult as $idCacheProductMaxScore) $idCacheProductMaxScoreResult[] = (int)$idCacheProductMaxScore['id_cache_product'];
				$where_criterion[] = 'app.id_cache_product IN ('.implode(',', $idCacheProductMaxScoreResult).')';
			}
		}

		$return = array('count'=>$count_criterion,'join'=>$join_criterion,'where'=>$where_criterion,'select'=>@$field_select,'make_union'=>$make_union,'whereUnion'=>array(),'joinUnion'=>array(), 'nbSelectedCriterions' => sizeof($selected_criterion), 'priceIncluded' => $price_is_included, 'productTableIncluded' => $include_product_table);
		self::$_cacheLeftJoinWhereCriterion[$cacheKey] = $return;

		return $return;
	}
	
	public static function getQueryCountResults($search,$id_lang,$selected_criterion,$selected_criteria_groups_type = array(),$id_currency = false,$id_country = false,$id_group = false) {
		$query_count = false;

		// Check if taxes is enable
		$usetax = Tax::excludeTaxeOption();

		$now = date('Y-m-d H:i:s');
		// Get additional query for get results
		$leftJoinWhereCriterion = self::makeLeftJoinWhereCriterion('getQueryCountResults', $search,$id_lang,$selected_criterion,$selected_criteria_groups_type,false,false,$id_currency,$id_country,$id_group,true,true);

		$query_count = 'SELECT COUNT(DISTINCT acp.`id_product`) as total
			FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ';
		$query_count .= ($leftJoinWhereCriterion && isset($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?'WHERE '.implode(' AND ',$leftJoinWhereCriterion['where']):'');
		
		return $query_count;
	}
	
	public static function getCriterionsForSearchBloc($search,$id_criterion_group,$id_lang,$count_product = false,$selected_criterion = array(),$selected_criteria_groups_type = array(),$id_currency = false,$id_country = false,$id_group = false,$visible = false,$groupInfos = false,$base_selection = false, $criterion_groups) {
		if (($groupInfos['sort_by'] == '' || $groupInfos['sort_by'] == 'position') || !$id_lang) $field_order_by = '`position`';
		elseif ($groupInfos['criterion_group_type'] == 'weight' || $groupInfos['criterion_group_type'] == 'width' || $groupInfos['criterion_group_type'] == 'height' || $groupInfos['criterion_group_type'] == 'depth')
			$field_order_by = '`value`';
		elseif ($groupInfos['sort_by'] == 'numeric')$field_order_by = 'CAST(REPLACE(IF(ac.`single_value` != "",ac.`single_value`,acl.`value`), ",", ".") AS DECIMAL(10,2))';
		elseif ($groupInfos['sort_by'] == 'nb_product') $field_order_by = 'nb_product';
		else $field_order_by = '`value`';

		// Keep criteria on memory
		$selected_criterion_copy = $selected_criterion;
		// Exclusion des criteres du meme groupe que le courant
		if (isset($selected_criterion[$id_criterion_group])) { unset($selected_criterion[$id_criterion_group]);}
		if (!$id_country) $id_country = (int)(_PS_VERSION_ >= 1.5 ? Context::getContext()->country->id : Country::getDefaultCountryId());
		$now = date('Y-m-d H:i:s');

		// Get additional query for get results
		$leftJoinWhereCriterion = self::makeLeftJoinWhereCriterion('getCriterionsForSearchBloc', $search,$id_lang,$selected_criterion,$selected_criteria_groups_type,$id_criterion_group,($groupInfos['criterion_group_type'] == 'attribute'),$id_currency,$id_country,$id_group,false,false,$groupInfos['criterion_group_type'], $criterion_groups);
		// if option enabled, get only categories from current level_depth category search
		if ($groupInfos['criterion_group_type'] == 'category' && !$groupInfos['id_criterion_group_linked'] && !$groupInfos['show_all_depth']) {
			if (isset($selected_criterion_copy[$id_criterion_group]) && sizeof($selected_criterion_copy[$id_criterion_group])) {
				// Get current search level depth
				$current_level_depth = self::getAsCriterionCategoryHigherLevelDepth($search['id_search'],$selected_criterion_copy[$id_criterion_group]);
				// Get child categories. If child is in the latest depth and has no child, get parent id and reduce level_depth
				$current_linked_categories = self::getIdLinkedFromCriterion($selected_criterion_copy[$id_criterion_group],$search['id_search'],$current_level_depth);
				$leftJoinWhereCriterion['where'][] = $leftJoinWhereCriterion['whereUnion'][] = '(ac.`id_criterion` IN ('.implode(',',$selected_criterion_copy[$id_criterion_group]).') OR (ac.`level_depth` = '.((int)$current_level_depth+1).' AND ac.`id_parent` IN ('.implode(',',$current_linked_categories).')))';
			}
			else
				$leftJoinWhereCriterion['where'][] = $leftJoinWhereCriterion['whereUnion'][] = 'ac.`level_depth` = 1';
		}
		
		// Pages SEO & Option ne montrer que les criteres disponibles
		if ($search['filter_by_emplacement'] && Tools::getValue('id_seo') !== false && is_numeric(Tools::getValue('id_seo')) && Tools::getValue('id_seo') > 0) {
			$search['selected_criteres_seo'] = array();
			$seo_search = new AdvancedSearchSeoClass((int)Tools::getValue('id_seo'));
			if (Validate::isLoadedObject($seo_search) && isset($seo_search->criteria) && !empty($seo_search->criteria)) {
				$criteres_seo = @unserialize($seo_search->criteria);
				if (AdvancedSearchCoreClass::_isFilledArray($criteres_seo)) {
					foreach ($criteres_seo as $critere_seo) {
						$critere_seo = explode('_', $critere_seo);
						$id_criterion_group_seo = (int)$critere_seo[0];
						$id_criterion_value = (int)$critere_seo[1];
						if (isset($selected_criterion[$id_criterion_group_seo])) {
							if (!in_array($id_criterion_value, $selected_criterion[$id_criterion_group_seo])) {
								// Sauvegarde des criteres SEO pre-selectionnes
								$search['selected_criteres_seo'][$id_criterion_group_seo][] = $id_criterion_value;
							}
						} else {
							// Sauvegarde des criteres SEO pre-selectionne
							$search['selected_criteres_seo'][$id_criterion_group_seo][] = $id_criterion_value;
						}
					}
				}
			}
		}
		if (isset($search['selected_criteres_seo']) && AdvancedSearchCoreClass::_isFilledArray($search['selected_criteres_seo']) && $search['filter_by_emplacement'] && Tools::getValue('id_seo') !== false && is_numeric(Tools::getValue('id_seo')) && Tools::getValue('id_seo') > 0) {
			$leftJoinWhereCriterion['where'][] = $leftJoinWhereCriterion['whereUnion'][] = '(ac.`id_criterion` IN ('.implode(',',$search['selected_criteres_seo'][$id_criterion_group]).'))';
		}

		// Allow to search only on child category
		if (self::isCategoryGroup($search['id_search'], $id_criterion_group, true)) {
			$current_category_depth = $groupInfos['id_criterion_group_linked'];
			if (is_array($selected_criterion_copy) && sizeof($selected_criterion_copy)) {
				foreach($selected_criterion_copy as $id_criterion_group2 => $criteria2) {
					if ($selected_criteria_groups_type[$id_criterion_group2]['criterion_group_type'] == 'category' && $id_criterion_group2 != $id_criterion_group && $selected_criteria_groups_type[$id_criterion_group2]['id_criterion_group_linked'] < $current_category_depth) {
						if (!isset($prev_category_depth) || $prev_category_depth < $selected_criteria_groups_type[$id_criterion_group2]['id_criterion_group_linked']) {
							$prev_category_depth = $selected_criteria_groups_type[$id_criterion_group2]['id_criterion_group_linked'];
							$criteria_category_parent = $criteria2;
						}
					}
				}
				if (isset($criteria_category_parent)) {
					$childsCategoriesId = self::getChildsCategoriesId(self::getIdLinkedFromCriterion($criteria_category_parent,$search['id_search']));
					$leftJoinWhereCriterion['where'][]/* = $leftJoinWhereCriterion['whereUnion'][]*/ = '(ac.`id_criterion_linked` IN('.implode(', ',$childsCategoriesId).'))';
				}
			}
		}

		// Make join for check category customer groups
		if ($groupInfos['criterion_group_type'] == 'category') {
			$groups = FrontController::getCurrentCustomerGroups();
			$leftJoinWhereCriterion['join'][] = $leftJoinWhereCriterion['joinUnion'][] = 'LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON ( cg.`id_category` = ac.`id_criterion_linked`)';
			$leftJoinWhereCriterion['where'][] = $leftJoinWhereCriterion['whereUnion'][] = 'cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1');
		}
		$query = '';

		if ($leftJoinWhereCriterion['make_union']) {
			$query .= 'SELECT * FROM (';
		}

		$query .= 'SELECT ac.* '.((int) $id_lang ? ', acl.id_lang, acl.icon':'').
		', IF(ac.`single_value` != "",ac.`single_value`,acl.`value`) AS `value`, ('.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['count'])?'COUNT(DISTINCT '.implode(' + ',$leftJoinWhereCriterion['count']).')':'COUNT(DISTINCT acpc.`id_cache_product`)').
		') AS nb_product'.
		'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'` ac
		'.
		($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')' : '').
		($search['display_empty_criteria'] ? 'LEFT ' : '').'JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $search['id_search'].'` acpc ON (ac.`id_criterion` = acpc.`id_criterion`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ON ( '.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' acp.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '').' acp.`id_cache_product` = acpc.`id_cache_product`)
		'.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
		'WHERE '.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' acp.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '') . '
		ac.`id_criterion_group` = '.(int)$id_criterion_group.
		($visible ? ' AND ac.`visible` = 1' : '').
		' AND '.(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?implode(' AND ',$leftJoinWhereCriterion['where']):'1').
		' GROUP BY ac.`id_criterion`'
		.($leftJoinWhereCriterion['make_union'] ? '' : '
		ORDER BY '.$field_order_by.' '.$groupInfos['sort_way']);

		if ($leftJoinWhereCriterion['make_union']) {
			$query .= ' UNION
			 SELECT ac.*, acl.id_lang, acl.icon, IF(ac.`single_value` != "",ac.`single_value`,acl.`value`) AS `value`,
			 0 AS nb_product
			 FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'` ac
			 LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')
			 '.
			(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['joinUnion'])?implode(' ',$leftJoinWhereCriterion['joinUnion']):'').
			($base_selection ? '
			JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $search['id_search'].'` acpc ON (ac.`id_criterion` = acpc.`id_criterion`)
			JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ON ( '.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' acp.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '') . ' acp.`id_cache_product` = acpc.`id_cache_product`)
			JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $search['id_search'].'` acpc2 ON ( acp.`id_cache_product` = acpc2.`id_cache_product` AND acpc2.`id_criterion` IN('.implode(', ',$base_selection).'))
			': '').'
			WHERE '.($base_selection && isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' acp.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '') . '
			ac.`id_criterion_group` = '.$id_criterion_group.
			($visible ? ' AND ac.`visible` = 1' : '').
			' AND '.(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['whereUnion'])?implode(' AND ',$leftJoinWhereCriterion['whereUnion']):'1').
			'
			GROUP BY ac.`id_criterion`
			 ) as tmp GROUP BY `id_criterion`
			ORDER BY '.$field_order_by.' '.$groupInfos['sort_way'];
		}
		return Db::getInstance()->ExecuteS($query);
	}
	
	protected static function getDefaultGroupId() {
		if (_PS_VERSION_ >= 1.5) {
			return (int)Configuration::get('PS_UNIDENTIFIED_GROUP');
		} else {
			return (int)_PS_DEFAULT_CUSTOMER_GROUP_;
		}
	}
	
	// Score generation
	private static $_getScoreQueryCache = array();
	protected static function _getScoreQuery($id_shop, $id_currency, $id_country, $id_group, $add_alias = true, $force_priority = false, $use_native_table = false) {
		$cacheKey = $id_shop.'-'.$id_currency.'-'.$id_country.'-'.$id_group.'-'.(int)$add_alias.'-'.(int)$force_priority.'-'.(int)$use_native_table;
		if (isset(self::$_getScoreQueryCache[$cacheKey])) return self::$_getScoreQueryCache[$cacheKey];
		if (!$use_native_table) {
			$select = '(app.is_specific + app.`has_no_specific` + ';
			$table_alias = 'app';
		} else {
			$select = '( ';
			$table_alias = 'sp';
		}
		$now = date('Y-m-d H:i:s');
		$select .= ' IF (('.$table_alias.'.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= '.$table_alias.'.`from`) AND ('.$table_alias.'.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= '.$table_alias.'.`to`), '.pow(2, 0).', 0) + ';
		$priority = preg_split('/;/', Configuration::get('PS_SPECIFIC_PRICE_PRIORITIES'));
		foreach (array_reverse($priority) AS $k => $field) {
			if ($force_priority) {
				if ($field == 'id_shop' && _PS_VERSION_ < 1.5) {
					$select .= ' IF ('.$table_alias.'.`'.$field.'` IN (0, 1), '.pow(2, $k + 1).', 0) + ';
				} else  {
					$select .= ' IF ('.$table_alias.'.`'.$field.'` = '.(int)(${$field}).', '.pow(2, $k + 1).', 0) + ';
				}
			} else {
				if ($field == 'id_shop' && _PS_VERSION_ < 1.5) {
					$select .= ' IF ('.$table_alias.'.`'.$field.'` IN (0, 1), '.pow(2, $k + 1).', 0) + ';
				} else if ($field == 'id_group' && (int)${$field} > 0 && (int)${$field} != self::getDefaultGroupId()) {
					$select .= ' IF ('.$table_alias.'.`'.$field.'` IN (0, '.(int)(${$field}).'), '.pow(2, $k + 1).', 0) + ';
				} else if ($field != 'id_group') {
					$select .= ' IF ('.$table_alias.'.`'.$field.'` IN (0, '.(int)(${$field}).'), '.pow(2, $k + 1).', 0) + ';
				}
			}
		}
		self::$_getScoreQueryCache[$cacheKey] = rtrim($select, ' +').')'.($add_alias ? ' AS `score`' : '');
		return self::$_getScoreQueryCache[$cacheKey];
	}
	
	public static function getCriterionsRange($search,$id_criterion_group,$id_lang,$count_product = false,$selected_criterion = array(),$selected_criteria_groups_type = array(),$id_currency = false,$id_country = false,$id_group = false,$groupInfos = false) {
		if (!$id_country) $id_country = (int)(_PS_VERSION_ >= 1.5?Context::getContext()->country->id:Country::getDefaultCountryId());
		$now = date('Y-m-d H:i:s');

		// Force parameter
		$search['display_empty_criteria'] = false;

		// Get additional query for get results
		$leftJoinWhereCriterion = self::makeLeftJoinWhereCriterion('getCriterionsRange', $search,$id_lang,$selected_criterion,$selected_criteria_groups_type,$id_criterion_group,($groupInfos['criterion_group_type'] == 'attribute'),$id_currency,$id_country,$id_group);

		$return = array();

		if ($groupInfos['criterion_group_type'] == 'weight' || $groupInfos['criterion_group_type'] == 'width' ||
				$groupInfos['criterion_group_type'] == 'height' || $groupInfos['criterion_group_type'] == 'depth') {
			$field_range = 'ac.`single_value`';
		} else {
			$field_range = 'acl.`value`';
		}

		$row = Db::getInstance()->getRow('
				SELECT '.$field_range.' AS `min`'.
				'
				FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'` ac
				'.($search['display_empty_criteria'] ? /*option disable'LEFT '*/'' : '').'JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $search['id_search'].'` acpc ON (ac.`id_criterion` = acpc.`id_criterion`)
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ON ( acp.`id_cache_product` = acpc.`id_cache_product`)
				'.
				(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
				($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')' : '').
				' WHERE ac.`id_criterion_group` = '.(int)$id_criterion_group.
				' AND '.(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?implode(' AND ',$leftJoinWhereCriterion['where']):'1').
				' GROUP BY ac.`id_criterion`
				ORDER BY CAST(REPLACE('.$field_range.', ",", ".") AS DECIMAL(10,2)) ASC');
		$return[0]['min'] = floor($row['min']);

		$row = Db::getInstance()->getRow('
				SELECT '.$field_range.' AS `max`'.
				'
				FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'` ac
				'.($search['display_empty_criteria'] ? /*option disable'LEFT '*/'' : '').'JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int) $search['id_search'].'` acpc ON (ac.`id_criterion` = acpc.`id_criterion`)
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ON ( acp.`id_cache_product` = acpc.`id_cache_product`)
				'.
				(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
				($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $search['id_search'].'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')' : '').
				' WHERE ac.`id_criterion_group` = '.(int)$id_criterion_group.
				' AND '.(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?implode(' AND ',$leftJoinWhereCriterion['where']):'1').
				' GROUP BY ac.`id_criterion`
				ORDER BY CAST(REPLACE('.$field_range.', ",", ".") AS DECIMAL(10,2)) DESC');
		$return[0]['max'] = ceil($row['max']);

		return $return;
	}
	
	public static function getGroupReducedPrice($id_product, $id_group, $price) {
		$reduction_from_category = GroupReduction::getValueForProduct($id_product, $id_group);
		if ($reduction_from_category !== false)
			$price -= $price * (float)$reduction_from_category;
		else // apply group reduction if there is no group reduction for this category
			$price *= ((100 - Group::getReductionByIdGroup($id_group)) / 100);
		return $price;
	}
	
	protected static function getMinIdProductSlider($search,$id_criterion_group,$id_currency,$id_country,$id_group,$count_product = false,$selected_criterion = array(),$selected_criteria_groups_type = array()) {
		global $cookie;

		if (!$id_country) $id_country = (int)(_PS_VERSION_ >= 1.5 ? Context::getContext()->country->id : Country::getDefaultCountryId());
		
		if (_PS_VERSION_ >= 1.5) {
			$context = Context::getContext();
			if (isset($context->cart) && is_object($context->cart) && isset($context->cart->id_customer))
				$id_customer = $context->cart->id_customer;
			else $id_customer = false;
		} else {
			global $cart;
			if (is_object($cart) && isset($cart->id_customer))
				$id_customer = $cart->id_customer;
			else $id_customer = false;
		}
		$groupReductionValue = ((int)Group::getReductionByIdGroup($id_group) > 0 ? (1 - (int)Group::getReductionByIdGroup($id_group)/100) : 1);
		$usetax = Product::getTaxCalculationMethod($id_customer);
		
		// Force parameter
		$search['display_empty_criteria'] = false;

		// Get additional query for get results
		$leftJoinWhereCriterion = self::makeLeftJoinWhereCriterion('getPriceRangeForSearchBloc', $search,$cookie->id_lang,$selected_criterion,$selected_criteria_groups_type,$id_criterion_group,false,$id_currency,$id_country,$id_group, true, true);

		$now = date('Y-m-d H:i:s');

		$return = array();
		$query_min = 'SELECT acp.id_product, '.self::_getScoreQuery((_PS_VERSION_ >= 1.5 ? Context::getContext()->shop->id : 0), $id_currency, $id_country, $id_group).'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int) $search['id_search'].'` app
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ON (app.`id_cache_product` = acp.`id_cache_product`)'.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
		' WHERE ((app.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= app.`from`) AND (app.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= app.`to`)) AND '.
		' ((app.`valid_id_specific_price`=1 AND app.`is_specific`=1 AND app.`id_currency` IN (0, '.(int)$id_currency.')) OR app.`has_no_specific`=1) AND '.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?implode(' AND ',$leftJoinWhereCriterion['where']):' 1 ').
		' AND app.`id_country` IN (0, '.(int)$id_country.') '.
		' AND app.`id_group` IN (0, '.(int)$id_group.') '.
		(_PS_VERSION_ >= 1.5 ? ' AND app.`id_shop` IN (0, '.implode(', ', Shop::getContextListShopID()).') ' : '') .
		' ORDER BY score DESC, ((app.`price_wt` - IF(app.`reduction_type`=\'amount\', app.`reduction_amount`'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').', app.`reduction_amount`)) '.($leftJoinWhereCriterion['nbSelectedCriterions'] > 0 && ($leftJoinWhereCriterion['priceIncluded'] || $leftJoinWhereCriterion['productTableIncluded']) ? ' * IF(grc.`reduction` > 0, (1 - grc.`reduction`/100), '.$groupReductionValue.')' : '').') ASC';
		$row = Db::getInstance()->getRow($query_min);
		if (isset($row['id_product']) && $row['id_product']) return $row['id_product'];
		return false;
	}
	
	protected static function getMaxIdProductSlider($search,$id_criterion_group,$id_currency,$id_country,$id_group,$count_product = false,$selected_criterion = array(),$selected_criteria_groups_type = array()) {
		global $cookie;

		if (!$id_country) $id_country = (int)(_PS_VERSION_ >= 1.5 ? Context::getContext()->country->id : Country::getDefaultCountryId());
		
		if (_PS_VERSION_ >= 1.5) {
			$context = Context::getContext();
			if (isset($context->cart) && is_object($context->cart) && isset($context->cart->id_customer))
				$id_customer = $context->cart->id_customer;
			else $id_customer = false;
		} else {
			global $cart;
			if (is_object($cart) && isset($cart->id_customer))
				$id_customer = $cart->id_customer;
			else $id_customer = false;
		}
		$groupReductionValue = ((int)Group::getReductionByIdGroup($id_group) > 0 ? (1 - (int)Group::getReductionByIdGroup($id_group)/100) : 1);
		$usetax = Product::getTaxCalculationMethod($id_customer);
		
		// Force parameter
		$search['display_empty_criteria'] = false;

		// Get additional query for get results
		$leftJoinWhereCriterion = self::makeLeftJoinWhereCriterion('getPriceRangeForSearchBloc', $search,$cookie->id_lang,$selected_criterion,$selected_criteria_groups_type,$id_criterion_group,false,$id_currency,$id_country,$id_group, true, true);

		$now = date('Y-m-d H:i:s');

		$return = array();
		$query_max = 'SELECT acp.id_product, '.self::_getScoreQuery((_PS_VERSION_ >= 1.5 ? Context::getContext()->shop->id : 0), $id_currency, $id_country, $id_group).'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int) $search['id_search'].'` app
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ON (app.`id_cache_product` = acp.`id_cache_product`)'.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
		' WHERE ((app.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= app.`from`) AND (app.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= app.`to`)) AND '.
		' ((app.`valid_id_specific_price`=1 AND app.`is_specific`=1 AND app.`id_currency` IN (0, '.(int)$id_currency.')) OR app.`has_no_specific`=1) AND '.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?implode(' AND ',$leftJoinWhereCriterion['where']):' 1 ').
		' AND app.`id_country` IN (0, '.(int)$id_country.') '.
		' AND app.`id_group` IN (0, '.(int)$id_group.') '.
		(_PS_VERSION_ >= 1.5 ? ' AND app.`id_shop` IN (0, '.implode(', ', Shop::getContextListShopID()).') ' : '') .
		' ORDER BY score DESC, ((app.`price_wt` - IF(app.`reduction_type`=\'amount\', app.`reduction_amount`'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').', app.`reduction_amount`))'.($leftJoinWhereCriterion['nbSelectedCriterions'] > 0 && ($leftJoinWhereCriterion['priceIncluded'] || $leftJoinWhereCriterion['productTableIncluded']) ? ' * IF(grc.`reduction` > 0, (1 - grc.`reduction`/100), '.$groupReductionValue.')' : '').') DESC';
		$row = Db::getInstance()->getRow($query_max);
		if (isset($row['id_product']) && $row['id_product']) return $row['id_product'];
		return false;
	}
	
	public static function getPriceRangeForSearchBloc($search,$id_criterion_group,$id_currency,$id_country,$id_group,$count_product = false,$selected_criterion = array(),$selected_criteria_groups_type = array()) {
		global $cookie;
		
		if (!$id_country) $id_country = (int)(_PS_VERSION_ >= 1.5 ? Context::getContext()->country->id : Country::getDefaultCountryId());
		
		if (_PS_VERSION_ >= 1.5) {
			$context = Context::getContext();
			if (isset($context->cart) && is_object($context->cart) && isset($context->cart->id_customer))
				$id_customer = $context->cart->id_customer;
			else $id_customer = false;
		} else {
			global $cart;
			if (is_object($cart) && isset($cart->id_customer))
				$id_customer = $cart->id_customer;
			else $id_customer = false;
		}
		$groupReductionValue = ((int)Group::getReductionByIdGroup($id_group) > 0 ? (1 - (int)Group::getReductionByIdGroup($id_group)/100) : 1);
		$usetax = Product::getTaxCalculationMethod($id_customer);
		
		// Force parameter
		$search['display_empty_criteria'] = false;

		// Get additional query for get results
		$leftJoinWhereCriterion = self::makeLeftJoinWhereCriterion('getPriceRangeForSearchBloc', $search,$cookie->id_lang,$selected_criterion,$selected_criteria_groups_type,$id_criterion_group,false,$id_currency,$id_country,$id_group, true, true);

		$now = date('Y-m-d H:i:s');
		
		$minIdProduct = self::getMinIdProductSlider($search,$id_criterion_group,$id_currency,$id_country,$id_group,$count_product,$selected_criterion,$selected_criteria_groups_type);
		
		$return = array();
		$query_min = 'SELECT FLOOR(app.price_wt) as min_price, app.`reduction_amount`, app.`reduction_type`, app.id_currency, acp.id_product, app.id_country, '.self::_getScoreQuery((_PS_VERSION_ >= 1.5 ? Context::getContext()->shop->id : 0), $id_currency, $id_country, $id_group, true, true).'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int) $search['id_search'].'` app
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ON (app.`id_cache_product` = acp.`id_cache_product`)'.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
		' WHERE acp.`id_product` = ' . (int)$minIdProduct . ' AND ' .
		' ((app.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= app.`from`) AND (app.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= app.`to`)) AND '.
		' ((app.`valid_id_specific_price`=1 AND app.`is_specific`=1 AND app.`id_currency` IN (0, '.(int)$id_currency.')) OR app.`has_no_specific`=1) AND '.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?implode(' AND ',$leftJoinWhereCriterion['where']):' 1 ').
		' AND app.`id_country` IN (0, '.(int)$id_country.') '.
		' AND app.`id_group` IN (0, '.(int)$id_group.') '.
		(_PS_VERSION_ >= 1.5 ? ' AND app.`id_shop` IN (0, '.implode(', ', Shop::getContextListShopID()).') ' : '') .
		' ORDER BY score DESC, ((app.`price_wt` - IF(app.`reduction_type`=\'amount\', app.`reduction_amount`'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').', app.`reduction_amount`))'.($leftJoinWhereCriterion['nbSelectedCriterions'] > 0 && ($leftJoinWhereCriterion['priceIncluded'] || $leftJoinWhereCriterion['productTableIncluded']) ? ' * IF(grc.`reduction` > 0, (1 - grc.`reduction`/100), '.$groupReductionValue.')' : '').') ASC';
		$row = Db::getInstance()->getRow($query_min);
		
		if (_PS_VERSION_ >= 1.5)
			$tax_rate = Tax::getProductTaxRate((int)$row['id_product']);
		else {
			$tax_rate = Tax::getProductTaxRateViaRules((int)$row['id_product'], (int)$id_country, 0, 0);
			if ($tax_rate === false) $tax_rate = 0;
		}
		
		$reduction_amount = $row['reduction_amount'];
		$reduction_type = $row['reduction_type'];

		if (Product::$_taxCalculationMethod != PS_TAX_EXC) {
			if ($reduction_type == 'amount')
				$price_ttc = (($row['min_price'] * (1 + ($tax_rate / 100))) - $reduction_amount);
			else 
				$price_ttc = ((($row['min_price'] - $reduction_amount) * (1 + ($tax_rate / 100))));
			$return[0]['min_price'] = floor($price_ttc);
		} else {
			if ($reduction_type == 'amount')
				$reduction_amount = ($reduction_amount / (1 + ($tax_rate / 100)));
				
			$return[0]['min_price'] = floor($row['min_price']-$reduction_amount);
		}
		$return[0]['min_price_id_currency'] = $row['id_currency'];
		// Group reduction
		$return[0]['min_price'] = self::getGroupReducedPrice((int)$row['id_product'], $id_group, $return[0]['min_price']);
		
		$maxIdProduct = self::getMaxIdProductSlider($search,$id_criterion_group,$id_currency,$id_country,$id_group,$count_product,$selected_criterion,$selected_criteria_groups_type);
		
		$query_max = 'SELECT CEIL(app.price_wt) as max_price, app.`reduction_amount`, app.`reduction_type`, acp.id_product, app.id_currency, app.id_country, '.self::_getScoreQuery((_PS_VERSION_ >= 1.5 ? Context::getContext()->shop->id : 0), $id_currency, $id_country, $id_group, true, true).'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int) $search['id_search'].'` app
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp ON (app.`id_cache_product` = acp.`id_cache_product`)'.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
		' WHERE acp.`id_product` = ' . (int)$maxIdProduct . ' AND ' .
		' ((app.`from` = \'0000-00-00 00:00:00\' OR \''.$now.'\' >= app.`from`) AND (app.`to` = \'0000-00-00 00:00:00\' OR \''.$now.'\' <= app.`to`)) AND '.
		' ((app.`valid_id_specific_price`=1 AND app.`is_specific`=1 AND app.`id_currency` IN (0, '.(int)$id_currency.')) OR app.`has_no_specific`=1) AND '.
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?implode(' AND ',$leftJoinWhereCriterion['where']):' 1 ').
		' AND app.`id_country` IN (0, '.(int)$id_country.') '.
		' AND app.`id_group` IN (0, '.(int)$id_group.') '.
		(_PS_VERSION_ >= 1.5 ? ' AND app.`id_shop` IN (0, '.implode(', ', Shop::getContextListShopID()).') ' : '') .
		' ORDER BY score DESC, ((app.`price_wt` - IF(app.`reduction_type`=\'amount\', app.`reduction_amount`'.($usetax ? '' : ' / IF(t.`rate`,((t.`rate`/100)+1),1)').', app.`reduction_amount`))'.($leftJoinWhereCriterion['nbSelectedCriterions'] > 0 && ($leftJoinWhereCriterion['priceIncluded'] || $leftJoinWhereCriterion['productTableIncluded']) ? ' * IF(grc.`reduction` > 0, (1 - grc.`reduction`/100), '.$groupReductionValue.')' : '').') DESC';
		$row = Db::getInstance()->getRow($query_max);
		
		if (_PS_VERSION_ >= 1.5)
			$tax_rate = Tax::getProductTaxRate((int)$row['id_product']);
		else {
			$tax_rate = Tax::getProductTaxRateViaRules((int)$row['id_product'], (int)$id_country, 0, 0);
			if ($tax_rate === false) $tax_rate = 0;
		}
		
		$reduction_amount = $row['reduction_amount'];
		$reduction_type = $row['reduction_type'];
		
		if (Product::$_taxCalculationMethod != PS_TAX_EXC) {
			if ($reduction_type == 'amount')
				$price_ttc = (($row['max_price'] * (1 + ($tax_rate / 100))) - $reduction_amount);
			else 
				$price_ttc = ((($row['max_price'] - $reduction_amount) * (1 + ($tax_rate / 100))));
			$return[0]['max_price'] = ceil($price_ttc);
		} else {
			if ($reduction_type == 'amount')
				$reduction_amount = ($reduction_amount / (1 + ($tax_rate / 100)));
				
			$return[0]['max_price'] = ceil($row['max_price']-$reduction_amount);
		}
		$return[0]['max_price_id_currency'] = $row['id_currency'];
		// Group reduction
		$return[0]['max_price'] = self::getGroupReducedPrice((int)$row['id_product'], $id_group, $return[0]['max_price']);
		
		return $return;
	}
	
	public static function getProductsSearched($search,$id_lang,$include_price = false,$selected_criterion = array(),$selected_criteria_groups_type = array(), $p, $n, $orderBy = NULL, $orderWay = NULL, $getTotal = false,$id_currency = false,$id_country = false,$id_group = false, $active = true, $step_search = false,$search_on_stock = false) {
		global $cookie;
		if ($p < 1) $p = 1;
		if (!$id_country) $id_country = (int)(_PS_VERSION_ >= 1.5 ? Context::getContext()->country->id : Country::getDefaultCountryId());

		$now = date('Y-m-d H:i:s');
		if (empty($orderBy))
			$orderBy = 'orderprice';
		else
			/* Fix for all modules which are now using lowercase values for 'orderBy' parameter */
			$orderBy = strtolower($orderBy);

		if (empty($orderWay))
			$orderWay = 'ASC';
		if ($orderBy == 'id_product' OR $orderBy == 'date_add' OR $orderBy == 'quantity' OR $orderBy == 'reference')
			$orderByPrefix = 'p';
		elseif ($orderBy == 'name')
			$orderByPrefix = 'pl';
		elseif ($orderBy == 'manufacturer')
		{
			$orderByPrefix = 'm';
			$orderBy = 'name';
		}
		elseif ($orderBy == 'name')
			$orderByPrefix = 'p';
		elseif ($orderBy == 'position' && Tools::getValue('id_category_search')) {
			$id_category = Tools::getValue('id_category_search');
			$orderByPrefix = 'cp';
		}elseif ($orderBy == 'position' && !Tools::getValue('id_category_search')) {
			$orderBy = 'orderprice';
		}
		if ($orderBy == 'price')
			$orderBy = 'orderprice';

		if (!Validate::isBool($active) OR !Validate::isOrderBy($orderBy) OR !Validate::isOrderWay($orderWay))
			die (Tools::displayError());



		/* Return only the number of products */
		if ($getTotal)
		{
			$result = Db::getInstance()->getRow(self::getQueryCountResults($search,$id_lang,$selected_criterion,$selected_criteria_groups_type,$id_currency,$id_country,$id_group));
			return isset($result) ? $result['total'] : 0;
		}

		// Check if taxes is enable
		$usetax = Tax::excludeTaxeOption();

		// Get additional query for get results
		$leftJoinWhereCriterion = self::makeLeftJoinWhereCriterion('getProductsSearched', $search,$id_lang,$selected_criterion,$selected_criteria_groups_type,false,false,$id_currency,$id_country,$id_group,true,true);
		
		// Remove product join from global join list
		foreach ($leftJoinWhereCriterion['join'] as $leftJoinWhereCriterionJoinKey=>$leftJoinWhereCriterionJoinValue) {
			if (
			preg_match('#'.preg_quote('`'._DB_PREFIX_.'product`').'#', $leftJoinWhereCriterionJoinValue)
			&& !preg_match('#specific_max_score#', $leftJoinWhereCriterionJoinValue)) {
				unset($leftJoinWhereCriterion['join'][$leftJoinWhereCriterionJoinKey]);
			}
		}
		
		// ignore undefined images
		if (_PS_VERSION_ >= 1.5) $leftJoinWhereCriterion['where'][] = '((image_shop.id_image IS NOT NULL OR i.id_image IS NULL) OR (image_shop.id_image IS NULL AND i.cover=1))';
		
		$sql = 'SELECT '.(_PS_VERSION_ >= 1.5 ? 'p.*, ps.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, MAX(product_attribute_shop.id_product_attribute) id_product_attribute, product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity, ' : 'p.*, pa.`id_product_attribute`, t.`rate`, ').' pl.`description`, pl.`description_short`, pl.`available_now`,
					pl.`available_later`, pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, '.(_PS_VERSION_ >= 1.5 ?'image_shop.`id_image`':'i.`id_image`').',
					il.`legend`, m.`name` AS manufacturer_name, cl.`name` AS category_default,
					DATEDIFF('.(_PS_VERSION_ >= 1.5 ? 'ps' : 'p').'.`date_add`, DATE_SUB(NOW(),
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).'
						DAY)) > 0 AS new, ('.(_PS_VERSION_ >= 1.5 ? 'ps' : 'p').'.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice' . 
		
		/*Custom Select*/
		($leftJoinWhereCriterion && isset($leftJoinWhereCriterion['select']) && sizeof($leftJoinWhereCriterion['select'])?', '.implode(', ',$leftJoinWhereCriterion['select']):'')
		/*FIN Custom Select*/
		.' FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_'.(int) $search['id_search'].'` acp
		LEFT JOIN `'._DB_PREFIX_.'product` p ON ('.(isset(PM_AdvancedSearch4::$productFilterList) && sizeof(PM_AdvancedSearch4::$productFilterList) ? ' p.`id_product` IN ('.implode(',', PM_AdvancedSearch4::$productFilterList).') AND ' : '').'p.`id_product` = acp.`id_product`)
		'.
		/*Jointure criteres*/
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['join'])?implode(' ',$leftJoinWhereCriterion['join']):'').
		/*FIN Jointure criteres*/
		'LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON (p.`id_product` = pa.`id_product` AND pa.`default_on` = 1)
		'.(_PS_VERSION_ >= 1.5 ? Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.`default_on` = 1') : '').'
		'.(_PS_VERSION_ >= 1.5 ? Product::sqlStock('p', 'product_attribute_shop', false, Context::getContext()->shop) : '').'
		'.(isset($id_category) && $id_category ? 'LEFT JOIN `'._DB_PREFIX_.'category_product` cp ON (cp.`id_product` = p.`id_product` AND cp.`id_category` = '.(int)($id_category).')':'').'
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` AND pl.`id_lang` = '.(int)$id_lang . (_PS_VERSION_ >= 1.5 ? Shop::addSqlRestrictionOnLang('pl'):'').')
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON ('.(_PS_VERSION_ >= 1.5 ? 'ps' : 'p').'.`id_category_default` = cl.`id_category` AND cl.`id_lang` = '.(int)$id_lang . (_PS_VERSION_ >= 1.5 ? Shop::addSqlRestrictionOnLang('cl'):'').')
		LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`'.(_PS_VERSION_ >= 1.5 ? '':' AND i.`cover` = 1').')
		'.(_PS_VERSION_ >= 1.5 ? Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1'):'').'
		'.(_PS_VERSION_ >= 1.5 ? 'LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')':'LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)($id_lang).')').
		' LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON m.`id_manufacturer` = p.`id_manufacturer` ' .
		
		'WHERE '.
		/*Jointure criteres*/
		(AdvancedSearchCoreClass::_isFilledArray($leftJoinWhereCriterion['where'])?implode(' AND ',$leftJoinWhereCriterion['where']):'1').
		/*FIN Jointure criteres*/
		' GROUP BY p.`id_product`';

		$sql .= ' ORDER BY '.(isset($orderByPrefix) ? $orderByPrefix.'.' : '').'`'.pSQL($orderBy).'` '.pSQL($orderWay).'
		LIMIT '.(((int)($p) - 1) * (int)($n)).','.(int)($n);
		
		$result = Db::getInstance()->ExecuteS($sql);
		if ($orderBy == 'orderprice')
			Tools::orderbyPrice($result, $orderWay);
		if (!$result)
			return false;
		/* Modify SQL result */
		return self::getProductsProperties($id_lang, $result);
	}
	
	private static function getProductsProperties($id_lang, $result) {
		if (is_array($result) && sizeof($result)) {
			foreach ($result as $key=>$row) {
				if (isset($row['attribute_image']) && $row['attribute_image'])
					$result[$key]['id_image'] = $row['attribute_image'];
				if (!isset($row['quantity']) || (isset($row['quantity']) && $row['quantity'] == null))
					$result[$key]['quantity'] = Product::getQuantity($row['id_product'], $row['id_product_attribute'], isset($row['cache_is_pack']) ? $row['cache_is_pack'] : null);
			}
		}
		return Product::getProductsProperties($id_lang, $result);
	}
	
	public static function array_values_recursive($array) {
		$arrayValues = array();
		if (AdvancedSearchCoreClass::_isFilledArray($array)) {
			foreach ($array as $value) {
				if (is_scalar($value) OR is_resource($value)) {
					$arrayValues[] = $value;
				} elseif (is_array($value)) {
					$arrayValues = array_merge($arrayValues, self::array_values_recursive($value));
				}
			}
		}
		return $arrayValues;
	}
	
	private static $_isCategoryGroupCache = array();
	public static function isCategoryGroup($id_search,$id_criterion_group, $only_children = false) {
		$cacheKey = $id_search.'-'.$id_criterion_group.'-'.(int)$only_children;
		if (isset(self::$_isCategoryGroupCache[$cacheKey])) return self::$_isCategoryGroupCache[$cacheKey];
		$row = Db::getInstance()->getRow('
			SELECT `id_criterion_group`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'`
			WHERE `criterion_group_type` = "category"
			AND `id_criterion_group` = '.(int)$id_criterion_group .
			($only_children ? ' AND `only_children` = 1' : ''));
		self::$_isCategoryGroupCache[$cacheKey] = isset($row['id_criterion_group']);
		return self::$_isCategoryGroupCache[$cacheKey];
	}
	
	private static $_getCriterionGroupTypeAndDisplayCache = array();
	public static function getCriterionGroupTypeAndDisplay($id_search,$id_criterion_group) {
		$cacheKey = $id_search.'-'.$id_criterion_group;
		if (isset(self::$_getCriterionGroupTypeAndDisplayCache[$cacheKey])) return self::$_getCriterionGroupTypeAndDisplayCache[$cacheKey];
		$row = Db::getInstance()->getRow('
		SELECT `criterion_group_type`, `display_type`, `range`, `id_criterion_group_linked`, `sort_by`, `sort_way`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int)$id_search.'`
		WHERE `id_criterion_group` = '.(int)($id_criterion_group));
		self::$_getCriterionGroupTypeAndDisplayCache[$cacheKey] = isset($row['criterion_group_type']) ? $row : false;
		return self::$_getCriterionGroupTypeAndDisplayCache[$cacheKey];
	}
	
	public static function getCriterionGroupsTypeAndDisplay($id_search,$id_criterion_groups) {
		$criterion_groups_type = array();
		foreach($id_criterion_groups as $id_criterion_group) {
			$criterion_groups_type[$id_criterion_group] = self::getCriterionGroupTypeAndDisplay($id_search,$id_criterion_group);
		}
		return $criterion_groups_type;
	}
	
	public static function getCategoriesCriteriaGroup($id_search) {
		$results = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int)$id_search.'`
		WHERE `criterion_group_type` = "category"');
		return $results;
	}
	
	public static function getHookName($id_hook) {
		$result = Db::getInstance()->getRow('
		SELECT `name`
		FROM `'._DB_PREFIX_.'hook`
		WHERE `id_hook` = '.(int)$id_hook);
		return ($result ? $result['name'] : false);
	}
	
	// Add an sql restriction for shops & stock (PS 1.5 only)
	private static function _addSqlShopRestrictionStockAvailable($alias = null) {
		$shop = Context::getContext()->shop;
		if (!empty($alias))
			$alias .= '.';
		$shop_group = $shop->getGroup();
		if ($shop_group->share_stock)
			$sql = ' AND '.pSQL($alias).'id_shop_group = '.(int)$shop_group->id.' AND '.pSQL($alias).'id_shop = 0 ';
		else
			$sql = ' AND '.pSQL($alias).'id_shop = '.(int)$shop->id.' ';
		return $sql;
	}
}
