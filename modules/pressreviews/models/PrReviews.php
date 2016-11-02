<?php

class PrReviews extends ObjectModel {

	public $id;
	public $id_pressreviews;
    public $position = 0;
    public $active = 1;
    public $type;
    public $thumb_img;
    public $big_img;
    public $creation_date;
    
    public $title;
    public $thumb_txt;
    public $big_txt;
    public $link;

    public static $definition = array(
	        'table' => 'pressreviews',
	        'primary' => 'id_pressreviews',
	        'multilang' => true,
	        'fields' => array(
	            'id_pressreviews' => array(
	                'type' => ObjectModel::TYPE_INT,
	                'validate' => 'isUnsignedId'
	            ),
	            'position' => array(
	                'type' => ObjectModel::TYPE_INT,
	                'validate' => 'isUnsignedId'
	            ),
	            'active' => array(
	                'type' => ObjectModel::TYPE_BOOL,
	                'validate' => 'isBool'
	            ),
	            'type' => array(
	                'type' => ObjectModel::TYPE_STRING,
	            ),
	            'creation_date' => array(
	                'type' => ObjectModel::TYPE_DATE,
	            ),

	            /* Fields with lang */	
	            'title' => array(
	                'type' => ObjectModel::TYPE_STRING,
	                'lang' => true,
	                'required' => true,
	                'validate' => 'isString', 
	                'size' => 255
	            ),
	            'thumb_txt' => array(
	                'type' => ObjectModel::TYPE_STRING,
	                'lang' => true,
	                'validate' => 'isString', 
	                'size' => 255
	            ),
	            'big_txt' => array(
	                'type' => ObjectModel::TYPE_STRING,
	                'lang' => true,
	                'validate' => 'isString', 
	                'size' => 255
	            ),
	            'link' => array(
	                'type' => ObjectModel::TYPE_STRING,
	                'lang' => true,
	                'validate' => 'isString'
	            ),
	        )
    );
	
	public function __construct($id_pressreviews = null)
	{
		parent::__construct($id_pressreviews);
	}
    
    public function updatePosition($way, $position)
	{
		if (!$res = Db::getInstance()->executeS('
			SELECT `id_pressreviews`, `position`
			FROM `'._DB_PREFIX_.'pressreviews`
			ORDER BY `position` ASC'
		))
			return false;

		foreach ($res as $item)
			if ((int)$item['id_pressreviews'] == (int)$this->id)
				$moved_item = $item;

		if (!isset($moved_item) || !isset($position))
			return false;

		// < and > statements rather than BETWEEN operator
		// since BETWEEN is treated differently according to databases
		$sqla = 'UPDATE `'._DB_PREFIX_.'pressreviews`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position`
			'.($way
				? '> '.(int)$moved_item['position'].' AND `position` <= '.(int)$position
				: '< '.(int)$moved_item['position'].' AND `position` >= '.(int)$position.'
			AND `active` = 1');
		
		$sqlb = 'UPDATE `'._DB_PREFIX_.'pressreviews`
			SET `position` = '.(int)$position.'
			WHERE `id_pressreviews` = '.(int)$moved_item['id_pressreviews'];
	
		return (Db::getInstance()->execute($sqla) && Db::getInstance()->execute($sqlb));
	}
	
	public function deleteImages($id) {
		
		if (file_exists(_PS_PR_THUMB_IMG_DIR_.$id.'.jpg')) {
			unlink(_PS_PR_THUMB_IMG_DIR_.$id.'.jpg');
		}
		
		if (file_exists(_PS_PR_BIG_IMG_DIR_.$id.'.jpg')) {
			unlink(_PS_PR_BIG_IMG_DIR_.$id.'.jpg');
		}
		
		PrReviews::deleteTmpImages($id);
		
		return true;
	}
	
	public function deleteTmpImages($id) {
		
		if (file_exists(_PS_TMP_IMG_DIR_.$this->table.'_'.$id.'-thumb.jpg')) {
			unlink(_PS_TMP_IMG_DIR_.$this->table.'_'.$id.'-thumb.jpg');
		}
		
		if (file_exists(_PS_TMP_IMG_DIR_.$this->table.'_'.$id.'-big.jpg')) {
			unlink(_PS_TMP_IMG_DIR_.$this->table.'_'.$id.'-big.jpg');
		}
		
		return true;
	}
	
	public static function cleanPositions()
	{
		$return = true;

		$sql = '
		SELECT `id_pressreviews`
		FROM `'._DB_PREFIX_.'pressreviews`
		ORDER BY `position` ASC';
		$result = Db::getInstance()->executeS($sql);

		$i = 0;
		foreach ($result as $value)
			$return = Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'pressreviews`
			SET `position` = '.(int)$i++.'
			WHERE `id_pressreviews` = '.(int)$value['id_pressreviews']);
		return $return;
	}
		
	public static function getItems($p = 1, $n = null) {
			
		$cont = Context::getContext();
		$id_lang = $cont->language->id;
		
		$p = (int)$p;
		$n = (int)$n;
		if ($p <= 1)
			$p = 1;
		if ($n != null && $n <= 0)
			$n = 5;
		
	    $sql = 'SELECT * 
	    FROM `'._DB_PREFIX_.'pressreviews` pr
	    LEFT JOIN `'._DB_PREFIX_.'pressreviews_lang` lpr
	    ON pr.`id_pressreviews` = lpr.`id_pressreviews`
	    WHERE pr.`active` = 1
	    AND lpr.`id_lang` = '.(int)$id_lang;
	    
		if(Configuration::get('PR_ORDER') == 'd_asc') {
			$sql .= '
			ORDER BY `creation_date` ASC
			';
		} elseif (Configuration::get('PR_ORDER') == 'd_desc') {
			$sql .= '
			ORDER BY `creation_date` DESC
			';
		} elseif (Configuration::get('PR_ORDER') == 'p_asc') {
			$sql .= '
			ORDER BY `position` ASC
			';
		} elseif (Configuration::get('PR_ORDER') == 'p_desc') {
			$sql .= '
			ORDER BY `position` DESC
			';
		}
		
		$sql .= ($n ? 'LIMIT '.(int)(($p - 1) * $n).', '.(int)($n) : '');

	    if ($rows = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql)) {
	        return ObjectModel::hydrateCollection(__CLASS__, $rows);
	    }
	    else {
	    	return false;
	    }
	}
	
	public static function countItems() {
		$cont = Context::getContext();
		$id_lang = $cont->language->id;
		
		$sql = 'SELECT count(*) 
		FROM `'._DB_PREFIX_.'pressreviews` 
		WHERE `active` = 1';
		
		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
	}
	
	
}