<?php

class AdvancedSearchSeoClass extends ObjectModel {
	public 		$id;
	public 		$id_search;
	public 		$id_currency;
	public 		$meta_title;
	public 		$meta_description;
	public 		$meta_keywords;
	public		$title;
	public		$seo_url;
	public		$description;
	public		$criteria;
	public		$deleted;
	public		$seo_key;
	public		$cross_links;
	protected 	$tables = array ('pm_advancedsearch_seo','pm_advancedsearch_seo_lang');

	protected 	$fieldsRequired = array('id_search','criteria','seo_key');
 	protected 	$fieldsSize = array();
 	protected 	$fieldsValidate = array();

 	protected 	$fieldsRequiredLang = array('meta_title','meta_description','title','seo_url');
 	protected 	$fieldsSizeLang = array('meta_title' => 128, 'meta_description' => 255,
		'title' => 128, 'seo_url' => 128, 'meta_keywords' => 255);
 	protected 	$fieldsValidateLang = array('meta_title'=>'isGenericName',
	 	'meta_description'	=>'isGenericName',
	 	'meta_keywords'		=>'isGenericName',
	 	'title'				=>'isGenericName',
	 	'description'		=>'isString',
	 	'seo_url'			=>'isGenericName'
 	);

 	//Compatibility 1.5
	public static $definition = array(
		'table' => 'pm_advancedsearch_seo',
		'primary' => 'id_seo',
		'multishop' => false,
		'fields' => array(
			'meta_title' 				=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'meta_description' 			=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'title' 					=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'seo_url' 					=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'meta_keywords' 			=> 				array('type' => 3, 'lang' => true, 'required' => false),
			'description' 				=> 				array('type' => 3, 'lang' => true, 'required' => false)
		)
	);

	protected 	$table = 'pm_advancedsearch_seo';
	public 	$identifier = 'id_seo';

	public function __construct($id_seo = NULL, $id_lang=NULL, $id_shop=NULL) {
		if (_PS_VERSION_ >= 1.5) {
			parent::__construct($id_seo, $id_lang, $id_shop);
		} else {
			parent::__construct($id_seo, $id_lang);
		}
	}

	public function getFields() {
		parent::validateFields();
		if (isset($this->id))
			$fields['id_seo'] = intval($this->id);
		$fields['id_search'] = intval($this->id_search);
		$fields['id_currency'] = intval($this->id_currency);
		$fields['criteria'] = pSQL($this->criteria);
		$fields['deleted'] = intval($this->deleted);
		$fields['seo_key'] = pSQL($this->seo_key);

		return $fields;
	}
	
	/**
	  * Check then return multilingual fields for database interaction
	  *
	  * @return array Multilingual fields
	  */
	public function getTranslationsFieldsChild() {
		parent::validateFieldsLang();
		$fieldsArray = array('meta_title','meta_description','title','seo_url','meta_keywords');
		$fields = array();
		$languages = Language::getLanguages(false);
		$defaultLanguage = Configuration::get('PS_LANG_DEFAULT');

		foreach ($languages as $language)
		{
			$fields[$language['id_lang']]['id_lang'] = $language['id_lang'];
			$fields[$language['id_lang']][$this->identifier] = intval($this->id);
			$fields[$language['id_lang']]['description'] = (isset($this->description[$language['id_lang']]) AND !empty($this->description[$language['id_lang']])) ? pSQL($this->description[$language['id_lang']], true) : pSQL($this->description[$defaultLanguage], true);
			foreach ($fieldsArray as $field)
			{
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
	
	public	function save($nullValues = false, $autodate = true) {
		$newCriteria = array();

		if(!preg_match('#\{i:#',$this->criteria)) {
			$criteria = explode(',',$this->criteria);
			if(sizeof($criteria)) {
				foreach ( $criteria as $k => $value ) {
					$newCriteria[] = preg_replace('/^biscriterion_/','', $value);
				}
				$this->criteria = serialize($newCriteria);
			}
		}

		//Reset crosslinks
		if($this->id)
			$this->cleanCrossLinks();

		//Set id_currency if not yet
		if(!$this->id_currency)$this->id_currency = Configuration::get('PS_CURRENCY_DEFAULT');
		$ret = parent::save($nullValues, $autodate);

		//Save crosslinks
		if(is_array($this->cross_links) && sizeof($this->cross_links))
			$this->saveCrossLinks();

		return $ret;
	}
	
	public function delete() {
		$this->cleanCrossLinks();
		return parent::delete();
	}
	
	public static function deleteByIdSearch($id_search) {
		Db::getInstance()->Execute('DELETE adss.*, adssl.*, ascl.*  FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` )
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_crosslinks` ascl ON (ascl.`id_seo_linked` = adssl.`id_seo` )
		WHERE `id_search` = '.intval($id_search));
	}
	
	public function cleanCrossLinks() {
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'pm_advancedsearch_seo_crosslinks` WHERE `id_seo` = '.intval($this->id));
	}
	
	public function saveCrossLinks() {
		foreach($this->cross_links as $id_seo_linked) {
			$row = array('id_seo' => intval($this->id), 'id_seo_linked' => intval($id_seo_linked));
			Db::getInstance()->AutoExecute(_DB_PREFIX_.'pm_advancedsearch_seo_crosslinks', $row, 'INSERT');
		}
	}
	
	public function getCrossLinksOptionsSelected($id_lang) {
		$result = Db::getInstance()->ExecuteS('
		SELECT ascl.`id_seo_linked`, adssl.`title`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo_crosslinks` ascl
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (ascl.`id_seo_linked` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )
		WHERE ascl.`id_seo` = '.(int)($this->id));

		$return = array();
		foreach($result as $row) {
			$return[$row['id_seo_linked']] = $row['title'];
		}
		return $return;
	}
	
	public static function getCrossLinksAvailable($id_lang,$id_excludes = false,$query_search = false,$count = false,$limit = false,$start = 0) {
		if($count) {
			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT COUNT(adss.`id_seo`) AS nb
			FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
			LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )
			WHERE '.($id_excludes ? ' adss.`id_seo` NOT IN('.pSQL(implode(',',$id_excludes)).') AND ':'').'adss.`deleted` = 0
			'.($query_search ? ' AND adssl.`title` LIKE "%'.pSQL($query_search).'%"' : '').'
			ORDER BY adss.`id_seo`');
			return (int)($result['nb']);
		}
		$result = Db::getInstance()->ExecuteS('
		SELECT adss.`id_seo`, adssl.`title`
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )
		WHERE '.($id_excludes ? ' adss.`id_seo` NOT IN('.pSQL(implode(',',$id_excludes)).') AND ':'').'adss.`deleted` = 0
		'.($query_search ? ' AND adssl.`title` LIKE "%'.pSQL($query_search).'%"' : '').'
		ORDER BY adss.`id_seo`
		'.($limit? 'LIMIT '.$start.', '.(int)$limit : ''));
		$return = array();

		foreach($result as $row) {
			$return[$row['id_seo']] = $row['title'];
		}
		return $return;
	}
	
	public static function getSeoSearchs($id_lang = false,$withDeleted = 0,$id_search = false) {
		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		'.($id_lang ? 'LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )' : '').'
		WHERE 1
		'.(!$withDeleted ? ' AND adss.`deleted` = 0':'').'
		'.($id_search ? ' AND adss.`id_search` = '.(int)$id_search:'').'
		GROUP BY adss.`id_seo`
		ORDER BY adss.`id_seo`');
		return $result;
	}

	public static function getCrossLinksSeo($id_lang,$id_seo) {
		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_crosslinks` ascl ON (adss.`id_seo` = ascl.`id_seo_linked` )
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).' )
		WHERE ascl.`id_seo` = '.(int)$id_seo.' AND adss.`id_seo` != '.(int)$id_seo.' AND adss.`deleted` = 0
		GROUP BY adss.`id_seo`
		ORDER BY adss.`id_seo`');
		return $result;
	}
	
	public static function getSeoSearchBySeoUrl($seo_url,$id_lang) {
		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo`'.($id_lang?' AND adssl.`id_lang` = '.((int) $id_lang):'').' )
		WHERE `seo_url` = "'.pSQL($seo_url).'"
		LIMIT 1');
		return $result;
	}
	
	public static function getSeoSearchByIdSeo($id_seo,$id_lang) {
		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'pm_advancedsearch_seo` adss
		LEFT JOIN `'._DB_PREFIX_.'pm_advancedsearch_seo_lang` adssl ON (adss.`id_seo` = adssl.`id_seo` AND adssl.`id_lang` = '.((int) $id_lang).')
		WHERE adss.`id_seo` = "'.((int) $id_seo).'"
		GROUP BY adss.`id_seo`
		LIMIT 1');
		return $result;
	}
	
	public static function seoExists($seo_key) {
		$row = Db::getInstance()->getRow('
			SELECT `id_seo`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_seo`
			WHERE `seo_key` = "'.pSQL($seo_key).'"');
		return (isset($row['id_seo'])?$row['id_seo']:false);
	}
	
	public static function seoDeletedExists($seo_key) {
		$row = Db::getInstance()->getRow('
			SELECT `id_seo`
			FROM `'._DB_PREFIX_.'pm_advancedsearch_seo`
			WHERE `seo_key` = "'.pSQL($seo_key).'" AND `deleted` = 1');
		return (isset($row['id_seo'])?$row['id_seo']:false);
	}
	
	public static function undeleteSeoBySeoKey($seo_key) {
		$row = array('deleted' => 0);
		Db::getInstance()->AutoExecute(_DB_PREFIX_.'pm_advancedsearch_seo', $row, 'UPDATE','`seo_key` = "'.pSQL($seo_key).'" AND deleted = 1');
	}
}
