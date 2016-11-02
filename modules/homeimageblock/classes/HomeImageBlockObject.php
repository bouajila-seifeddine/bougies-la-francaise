<?php
/**
* Class HomeImageBlockObject
* 
* @author Olivier Michaud
* @copyright  Olivier Michaud
* @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

class HomeImageBlockObject extends ObjectModel
{
    public $id;
    
    /** @var int Id Image */
	public $id_home_image_block;
		
	/** @var string Title */
	public $title;
    
    /** @var string Descrition */
	public $description;
    
    /** @var string Url */
    public $url;
    
    /** @var string Legend */
    public $legend;
	
	/** @var date Date Add */
	public $date_add;
    
    /** @var date Date Update */
	public $date_upd;
    
    /** @var int Status */
	public $active;
    
    /** @var int Position */
	public $position;

    
	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'home_image_block',
		'primary' => 'id_home_image_block',
		'multilang' => true,
        'multishop' => true,
		'fields' => array(
            'position'          => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'date_add'          => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd'          => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'active'            => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            
            //Lang fields
            'title'             => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'required' => true, 'lang' => true, 'size' => 255),
            'description'       => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'lang' => true, 'size' => 500),
            'url'               => array('type' => self::TYPE_STRING, 'validate' => 'isUrl', 'required' => false, 'lang' => true, 'size' => 255),
            'legend'            => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml', 'lang' => true, 'size' => 255),
		)
	);

    
	public function __construct($id = null, $id_lang = null)
	{
        Shop::addTableAssociation(self::$definition['table'], array('type' => 'shop'));
		parent::__construct($id, $id_lang);
        $this->image_dir = _PS_HOMEIMAGE_IMG_DIR_;
	}

    
    public function add($autodate = true, $nullValues = false)
	{
		if ($this->position <= 0)
			$this->position = HomeImageBlockObject::getHigherPosition() + 1;

		return parent::add($autodate, true);
	}
    
    
    /**
	 * getHigherPosition
	 *
	 * Get the higher image position
	 *
	 * @return integer $position
	 */
	public static function getHigherPosition()
	{
		$sql = 'SELECT MAX(`position`)
				FROM `'._DB_PREFIX_.'home_image_block`';
		$position = DB::getInstance()->getValue($sql);
		return (is_numeric($position)) ? $position : -1;
	}
    
    
    public function delete()
	{
		$return = parent::delete();
        
		/* Reinitializing position */
		$this->cleanPositions();

		return $return;
	}
    
    
    /**
	 * Reorders all images positions.
	 * Called after deleting an image.
	 *
	 * @since 1.5.0
	 * @return bool $return
	 */
	public static function cleanPositions()
	{
		$return = true;

		$sql = '
		SELECT `id_home_image_block`
		FROM `'._DB_PREFIX_.'home_image_block`
		ORDER BY `position` ASC';
		$result = Db::getInstance()->executeS($sql);

		$i = 0;
		foreach ($result as $value)
			$return = Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'home_image_block`
			SET `position` = '.(int)$i++.'
			WHERE `id_home_image_block` = '.(int)$value['id_home_image_block']);
		return $return;
	}
    
    
    /**
	 * Moves an image
	 *
	 * @since 1.5.0
	 * @param boolean $way Up (1) or Down (0)
	 * @param integer $position
	 * @return boolean Update result
	 */
	public function updatePosition($way, $position)
	{
		if (!$res = Db::getInstance()->executeS('
			SELECT `id_home_image_block`, `position`
			FROM `'._DB_PREFIX_.'home_image_block`
			ORDER BY `position` ASC'
		))
			return false;

		foreach ($res as $image)
			if ((int)$image['id_home_image_block'] == (int)$this->id_home_image_block)
				$moved_image = $image;

		if (!isset($moved_image) || !isset($position))
			return false;

		// < and > statements rather than BETWEEN operator
		// since BETWEEN is treated differently according to databases
		return (Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'home_image_block`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position`
			'.($way
				? '> '.(int)$moved_image['position'].' AND `position` <= '.(int)$position
				: '< '.(int)$moved_image['position'].' AND `position` >= '.(int)$position))
		&& Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'home_image_block`
			SET `position` = '.(int)$position.'
			WHERE `id_home_image_block` = '.(int)$moved_image['id_home_image_block']));
	}
    
    
    /**
	 * Get all image
	 * @return result
	 */
    public static function getAllImages($id_lang, $id_shop) {
        Shop::addTableAssociation(self::$definition['table'], array('type' => 'shop'));
        $results = Db::getInstance()->executeS('
            SELECT *
            FROM `'._DB_PREFIX_.'home_image_block` hib
            INNER JOIN `'._DB_PREFIX_.'home_image_block_lang` hibl ON hib.id_home_image_block = hibl.id_home_image_block
            '.Shop::addSqlAssociation('home_image_block', 'hib').'
            WHERE id_lang='.$id_lang.'
            AND active = 1
            ORDER BY position'
        );
        return $results;
    }
}
