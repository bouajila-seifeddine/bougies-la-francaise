<?php
class DiscountsController{

	public function __construct (){

	}
	
	public static function getDiscounts()
	{
		$query = "SELECT *
				  FROM `"._DB_PREFIX_."cartabandonmentpro_cartrule` cc
				  ORDER BY tranche";
		$results = Db::getInstance()->ExecuteS($query);
		return $results;
	}
	
	public static function createDiscount($id_customer,$value, $id_cart, $validity, $type, $min, $max)
	{
		$code = 'CAV'.substr(sha1(microtime()), 6, 5);

		$voucher = new CartRule();
		$voucher->id_customer = (int)$id_customer;
		$voucher->code = $code;
		$voucher->name[Configuration::get('PS_LANG_DEFAULT')] = 'Cart Abandonment Pro Cart Id'.(int)$id_cart;
		$voucher->quantity = 1;
		$voucher->quantity_per_user = 1;
		$voucher->active = true;
		$voucher->shop_restriction = true;
		$voucher->cart_rule_restriction = 1;
		$voucher->highlight = false;
		//$voucher->cumulable_reduction = 1;
		$now = time();
		$voucher->date_from = date('Y-m-d H:i:s', $now);
		$voucher->date_to = date('Y-m-d H:i:s', $now + (3600 * 24 * $validity));

		$voucher->description = 'Cart Abandonment Pro '.$code;

		if($type == 'shipping')
		{
			$type = Discount::FREE_SHIPPING;
			$voucher->free_shipping = true;
		}
		elseif($type == 'percent')
		{
			$voucher->free_shipping = false;
			$type = Discount::PERCENT;
		}
		else
		{
			$voucher->free_shipping = false;
			$type = Discount::AMOUNT;
		}
			
		$voucher->id_discount_type = (int)$type;
		$voucher->minimun_amount = $min;
		$voucher->minimum_amount_currency = (int)Configuration::get('PS_CURRENCY_DEFAULT');

		if($type == Discount::AMOUNT)
		{
			$voucher->reduction_currency = (int)Configuration::get('PS_CURRENCY_DEFAULT');
			$voucher->reduction_amount = $value;
		}
		elseif ($type == Discount::PERCENT)
		{
			$voucher->reduction_percent = $value;
		}
		$voucher->save();

		Db::getInstance()->execute('
				INSERT INTO `'._DB_PREFIX_.'cart_rule_shop` (`id_cart_rule`, `id_shop`)
				VALUES ('.(int)$voucher->id.', '.(int)Shop::getContextShopId().')');
		return $voucher;
	}
}