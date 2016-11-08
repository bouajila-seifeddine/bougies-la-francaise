<?php

class AdvancedSearchCriterionGroupClass extends ObjectModel {
	public 		$id;
	public 		$id_search;
	public 		$name;
	public 		$icon;
	public		$criterion_group_type;
	public 		$display_type = 1;
	public		$is_multicriteria;
	public		$id_criterion_group_linked;
	public		$max_display;
	public		$overflow_height;
	public		$width;
	public		$visible;
	public		$position;
	public		$show_all_depth;
	public		$only_children;
	public		$is_collapsed;
	public		$hidden;
	public		$range;
	public		$range_sign;
	public		$range_interval;
	public		$sort_by = 'position';
	public		$sort_way = 'ASC';
	public		$range_nb = 15;

	protected 	$tables = array ('pm_advancedsearch_criterion_group','pm_advancedsearch_criterion_group_lang');

	protected 	$fieldsRequired = array('id_search','criterion_group_type','display_type');
 	protected 	$fieldsSize = array();
 	protected 	$fieldsValidate = array();

 	protected 	$fieldsRequiredLang = array('name');
 	protected 	$fieldsSizeLang = array();
 	protected 	$fieldsValidateLang = array('name'=>'isGenericName','icon'=>'isString','range_sign'=>'isGenericName','range_interval'=>'isGenericName');

	protected 	$table = 'pm_advancedsearch_criterion_group';
	public 	$identifier = 'id_criterion_group';

	//Compatibility 1.5
	public static $definition = array(
		'table' => 'pm_advancedsearch_criterion_group',
		'primary' => 'id_criterion_group',
		'multishop' => false,
		'fields' => array(
			'name' 				=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'icon' 				=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'range_sign' 		=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'range_interval' 	=> 				array('type' => 3, 'lang' => true, 'required' => false)
		)
	);

	public function __construct($id_criterion_group = NULL,$id_search = NULL,$id_lang=NULL, $id_shop = null) {
		if(!isset($id_search) || !$id_search && Tools::getValue('id_search')) $id_search = Tools::getValue('id_search');
		foreach($this->tables as $key => $table) {
			$this->tables[$key] = $table.'_'.(int) $id_search;
		}
		$this->table = $this->table.'_'.(int) $id_search;
		$this->id_search = $id_search;
		if (_PS_VERSION_ >= 1.5) {
			self::$definition['table'] = $this->table;
			parent::__construct($id_criterion_group, $id_lang, $id_shop);
		} else {
			parent::__construct($id_criterion_group, $id_lang);
		}
	}
	
	public function __destruct() {
		// Clear object model definition & cache values
		if (is_object($this)) {
			$class = get_class($this);
			if (method_exists('Cache', 'clean')) Cache::clean('objectmodel_def_'.$class);
			if (method_exists($this, 'clearCache')) $this->clearCache(true);
		}
	}
	
	public function getFields() {
		parent::validateFields();
		if (isset($this->id))
			$fields['id_criterion_group'] = intval($this->id);
		$fields['id_search'] = intval($this->id_search);
		$fields['criterion_group_type'] = pSQL($this->criterion_group_type);
		$fields['display_type']		=	intval($this->display_type);
		$fields['is_multicriteria']	=	intval($this->is_multicriteria);
		$fields['id_criterion_group_linked'] = intval($this->id_criterion_group_linked);
		$fields['max_display']		=	intval($this->max_display);
		$fields['width']			=	intval($this->width);
		$fields['visible']			=	intval($this->visible);
		$fields['position']			=	intval($this->position);
		$fields['overflow_height']	=	intval($this->overflow_height);
		$fields['show_all_depth']	=	intval($this->show_all_depth);
		$fields['only_children']	=	intval($this->only_children);
		$fields['is_collapsed']		=	intval($this->is_collapsed);
		$fields['hidden']			=	intval($this->hidden);
		$fields['range'] 			= intval($this->range);
		$fields['range_nb'] 		= floatval($this->range_nb);
		$fields['sort_by'] 			= pSQL($this->sort_by);
		$fields['sort_way'] 		= pSQL($this->sort_way);
		return $fields;
	}
	
	public function delete() {
		if(isset($this->icon) && AdvancedSearchCoreClass::_isFilledArray($this->icon)) {
			foreach ($this->icon as $icon) {
				if($icon && file_exists(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/search_files/criterions_group/'.$icon)) {
					@unlink(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/search_files/criterions_group/'.$icon);
				}
			}
		}
		if($this->criterion_group_type == 'price') {
			Db::getInstance()->Execute('TRUNCATE TABLE `'._DB_PREFIX_.'pm_advancedsearch_product_price_'.(int)$this->id_search.'`');
		}
		return parent::delete();
	}
	
	/**
	  * Check then return multilingual fields for database interaction
	  *
	  * @return array Multilingual fields
	  */
	public function getTranslationsFieldsChild() {
		parent::validateFieldsLang();
		return parent::getTranslationsFields(array('name','icon','range_sign','range_interval'));
	}
	
	public function save($nullValues = false, $autodate = true) {
		/*If price, force display as slide*/
		if(!$this->id && $this->criterion_group_type == 'price')
			$this->display_type = 5;

		$ret = parent::save($nullValues, $autodate);
	 	return $ret;
	}
	
	public static function getIdCriterionGroupByTypeAndIdLinked($id_search,$criterions_group_type,$id_criterion_group_linked,$id_lang = false) {
		$row = Db::getInstance()->getRow('
		SELECT acg.`id_criterion_group`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		WHERE acg.`criterion_group_type` = "'.pSQL($criterions_group_type).'" AND acg.`id_criterion_group_linked` = '.(int)($id_criterion_group_linked));
		return (isset($row['id_criterion_group']) AND $row['id_criterion_group']) ? (int)$row['id_criterion_group'] : 0;
	}
	public static function getCriterionsGroupsFromIdSearch($id_search,$id_lang,$visible = false)
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT acg.*, acgl.*
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'_lang` acgl ON (acg.`id_criterion_group` = acgl.`id_criterion_group` AND acgl.`id_lang` = '.((int) $id_lang).' )
		WHERE acg.`id_search` = '.((int)$id_search).'
		'.($visible ? ' AND `visible` = 1' : '').'
		ORDER BY `position`');
		return $result;
	}
	
	public static function getCriterionsGroup($id_search,$id_criterion_group,$id_lang) {
		$result = Db::getInstance()->ExecuteS('
		SELECT acg.*, acgl.*
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'_lang` acgl ON (acg.`id_criterion_group` = acgl.`id_criterion_group` AND acgl.`id_lang` = '.((int) $id_lang).' )
		WHERE acg.`id_criterion_group`  '.((is_array($id_criterion_group)?'IN('.implode(',',$id_criterion_group).')':'='.(int)$id_criterion_group)).'
		ORDER BY `position`');
		return $result;
	}
	
	public static function getNextIdCriterionGroup($id_search,$id_criterion_group) {
		$result = Db::getInstance()->ExecuteS('
		SELECT acg.`id_criterion_group`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		WHERE `visible` = 1
		ORDER BY acg.`position`');
		$return = false;
		foreach($result as $row) {
			if($return) return $row['id_criterion_group'];
			if($row['id_criterion_group'] == $id_criterion_group) $return = true;
		}
		return false;
	}
	
	public static function getCriterionGroupTypeAndRangeSign($id_search,$id_criterion_group,$id_lang) {
		$row = Db::getInstance()->getRow('
				SELECT acgl.`range_sign`,  acg.`criterion_group_type`
				FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'_lang` acgl ON (acg.`id_criterion_group` = acgl.`id_criterion_group` AND acgl.`id_lang` = '.((int) $id_lang).' )
				WHERE acg.`id_criterion_group` = '.(int)$id_criterion_group.'');
		return (isset($row['range_sign'])) ? $row : '';
	}
	
	public static function getCriterionGroupType($id_search, $id_criterion_group) {
		$row = Db::getInstance()->getRow('
				SELECT acg.`criterion_group_type`
				FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
				WHERE acg.`id_criterion_group` = '.(int)$id_criterion_group.'');
		return (isset($row['criterion_group_type'])) ? $row['criterion_group_type'] : false;
	}
}
