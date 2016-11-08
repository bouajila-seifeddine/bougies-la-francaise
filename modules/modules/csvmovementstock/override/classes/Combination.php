<?php
/**
* Override Class Combination
*/

class Combination extends CombinationCore
{

	/**
	 * For a given product_attribute reference, returns the corresponding id product corresponding
	 *
	 * @param int $id_product
	 * @param string $reference
	 * @return int id
	 */
	public static function getIdProductByReference($reference)
	{
		if (empty($reference))
			return 0;

		$query = new DbQuery();
		$query->select('pa.id_product');
		$query->from('product_attribute', 'pa');
		$query->where('pa.reference = \''.pSQL($reference).'\'');

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($query);
	}
}
