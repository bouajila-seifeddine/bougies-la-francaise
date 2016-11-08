<?php


class Product extends ProductCore
{
	public $description_lengow;

	public $universe;

	public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null)
	{
		Product::$definition['fields']['description_lengow'] = array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isString');
		Product::$definition['fields']['universe'] = array('type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml');
		parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
	}
	

	/**
	 * For a given reference, returns the corresponding id
	 *
	 * @param string $reference
	 * @return int id
	 */
	public static function getIdByReference($reference)
	{
		if (empty($reference))
			return 0;
		
		if(!Validate::isReference($reference))
			return 0;

		$query = new DbQuery();
		$query->select('p.id_product');
		$query->from('product', 'p');
		$query->where('p.reference = \''.pSQL($reference).'\'');

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);
        
        
	}
	
}
