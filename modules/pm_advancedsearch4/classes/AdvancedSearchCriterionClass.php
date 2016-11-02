<?php

class AdvancedSearchCriterionClass extends ObjectModel {
	public 		$id;
	public 		$id_criterion_group;
	public		$id_criterion_linked;
	public 		$value;
	public 		$icon;
	public 		$color;
	public 		$single_value;
	public		$visible = 1;
	public 		$level_depth;
	public 		$id_parent;
	public 		$position;

	protected 	$tables = array ('pm_advancedsearch_criterion','pm_advancedsearch_criterion_lang');

	public 	$id_search;

	protected 	$fieldsRequired = array('id_criterion_group');
 	protected 	$fieldsSize = array();
 	protected 	$fieldsValidate = array();

 	protected 	$fieldsRequiredLang = array();
 	protected 	$fieldsSizeLang = array();
 	protected 	$fieldsValidateLang = array();

	protected 	$table = 'pm_advancedsearch_criterion';
	protected 	$identifier = 'id_criterion';

	//Compatibility 1.5
	public static $definition = array(
		'table' => 'pm_advancedsearch_criterion',
		'primary' => 'id_criterion',
		'multishop' => false,
		'fields' => array(
			'value' 		=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'icon' 			=> 				array('type' => 3, 'lang' => true, 'required' => false)
		)
	);
	
	public function __construct($id_criterion = NULL,$id_search = NULL,$id_lang=NULL, $id_shop = null) {
		foreach($this->tables as $key => $table) {
			$this->tables[$key] = $table.'_'.(int) $id_search;
		}
		$this->table = $this->table.'_'.(int) $id_search;
		$this->id_search = $id_search;
		if (_PS_VERSION_ >= 1.5) {
			self::$definition['table'] = $this->table;
			parent::__construct($id_criterion, $id_lang, $id_shop);
		} else {
			parent::__construct($id_criterion, $id_lang);
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
	
	public function save($nullValues = false, $autodate = true) {
		return parent::save($nullValues, $autodate);
	}
	
	public function delete() {
		if(isset($this->icon) && AdvancedSearchCoreClass::_isFilledArray($this->icon)) {
			foreach ($this->icon as $icon) {
				if($icon && file_exists(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/search_files/criterions/'.$icon)) {
					@unlink(_PS_ROOT_DIR_ . '/modules/pm_advancedsearch4/search_files/criterions/'.$icon);
				}
			}
		}
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_cache_product_criterion_'.(int)$this->id_search.'` WHERE `id_criterion` = '.(int) $this->id);
		return parent::delete ();
	}
	
	public function getFields() {
		parent::validateFields();
		if (isset($this->id))
			$fields['id_criterion'] = intval($this->id);
		$fields['id_criterion_group'] = intval($this->id_criterion_group);
		$fields['id_criterion_linked'] = intval($this->id_criterion_linked);
		$fields['level_depth'] = intval($this->level_depth);
		$fields['color'] = pSQL($this->color);
		$fields['single_value'] = pSQL($this->single_value);
		$fields['visible'] = intval($this->visible);
		$fields['id_parent'] = intval($this->id_parent);
		$fields['position'] = intval($this->position);
		return $fields;
	}
	
	/**
	  * Check then return multilingual fields for database interaction
	  *
	  * @return array Multilingual fields
	  */
	public function getTranslationsFieldsChild() {
		parent::validateFieldsLang();
		return parent::getTranslationsFields(array('value','icon'));
	}
	
	public function add($autodate = true, $nullValues = false) {
	 	return parent::add($autodate, true);
	}
	
	public static function getCriterionsStatic($id_search,$id_criterion_group,$id_lang = false) {
		return Db::getInstance()->ExecuteS('SELECT ac.* '.((int) $id_lang ? ', acl.*':'').'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')' : '').'
		WHERE ac.`id_criterion_group` = '.(int)$id_criterion_group);
	}
	
	public function getCriterions($id_criterion_group,$id_lang = false) {
		return self::getCriterionsStatic($this->id_search,$id_criterion_group,$id_lang = false);
	}
	
	public static function getIdCriterionsGroupByIdCriterion($id_search,$selected_criterion,$visible = false) {
		$results = Db::getInstance()->ExecuteS('
		SELECT DISTINCT ac.`id_criterion_group`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		WHERE ac.`id_criterion` IN('.implode(',',$selected_criterion).')
		'.($visible ? ' AND `visible` = 1' : '').'');
		$return = array();
		foreach($results as $row) {
			$return[] = $row['id_criterion_group'];
		}
		return $return;
	}
	
	public static function getCriterionsById($id_search,$id_lang,$selected_criterion,$visible = false) {
		$results = Db::getInstance()->ExecuteS('
		SELECT ac.* '.((int) $id_lang ? ', acl.*':'').'
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')' : '').'
		WHERE ac.`id_criterion` IN('.implode(',',$selected_criterion).')
		'.($visible ? ' AND `visible` = 1' : '').'');

		return $results;
	}
	
	public static function getCriterionValueById($id_search,$id_lang,$id_criterion) {
		$row = Db::getInstance()->getRow('
				SELECT ac.id_criterion, IF(ac.`single_value` != "",ac.`single_value`,acl.`value`) AS `value`
				FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')
				WHERE ac.`id_criterion` = '.(int)$id_criterion);
		return $row;
	}
	
	public static function getIdCriterionByTypeAndIdLinked($id_search,$criterions_group_type,$id_criterion_group_linked,$id_criterion_linked) {
		$row = Db::getInstance()->getRow('
		SELECT ac.`id_criterion`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac ON (ac.`id_criterion_group` = acg.`id_criterion_group`)
		WHERE acg.`criterion_group_type` = "'.pSQL($criterions_group_type).'" AND acg.`id_criterion_group_linked` = '.(int)($id_criterion_group_linked).' AND ac.`id_criterion_linked` = '.(int)($id_criterion_linked));
		return (isset($row['id_criterion']) AND $row['id_criterion']) ? (int)$row['id_criterion'] : 0;
	}
	
	public static function getIdCriterionByTypeAndValue($id_search,$id_lang,$criterions_group_type,$id_criterion_group_linked,$criterion_value) {
		$row = Db::getInstance()->getRow('
		SELECT ac.`id_criterion`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac ON (ac.`id_criterion_group` = acg.`id_criterion_group`)
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'_lang` acl ON (ac.`id_criterion` = acl.`id_criterion` AND acl.`id_lang` = '.(int) $id_lang.')
		WHERE acg.`criterion_group_type` = "'.pSQL($criterions_group_type).'" AND acg.`id_criterion_group_linked` = '.(int)($id_criterion_group_linked).' AND TRIM(acl.`value`) LIKE "'.trim(pSQL($criterion_value)).'"');
		return (isset($row['id_criterion']) AND $row['id_criterion']) ? (int)$row['id_criterion'] : 0;
	}
	
	public static function getIdCriterionByTypeAndSingleValue($id_search,$criterions_group_type,$id_criterion_group_linked,$criterion_value) {
		$row = Db::getInstance()->getRow('
				SELECT ac.`id_criterion`
				FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_group_'.(int) $id_search.'` acg
				LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac ON (ac.`id_criterion_group` = acg.`id_criterion_group`)
				WHERE acg.`criterion_group_type` = "'.pSQL($criterions_group_type).'" AND acg.`id_criterion_group_linked` = '.(int)($id_criterion_group_linked).' AND TRIM(ac.`single_value`) LIKE "'.trim(pSQL($criterion_value)).'"');
		return (isset($row['id_criterion']) AND $row['id_criterion']) ? (int)$row['id_criterion'] : 0;
	}
	
	public static function getIdCriterionGroupByIdCriterion($id_search,$id_criterion) {
		$row = Db::getInstance()->getRow('
		SELECT ac.`id_criterion_group`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_criterion_'.(int) $id_search.'` ac
		WHERE ac.`id_criterion` = "'.(int)($id_criterion).'"');
		return (isset($row['id_criterion_group']) AND $row['id_criterion_group']) ? (int)$row['id_criterion_group'] : 0;
	}
}
