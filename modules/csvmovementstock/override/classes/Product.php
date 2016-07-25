<?php
/**
* Override Class Product
*/

class Product extends ProductCore
{

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
