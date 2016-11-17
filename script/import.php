<?php
// trouver solution pour requete message customer   

// 4275 - recuperation des clients a partir de cet ID (les autres sont identiques)
// 4274 - recuperation des commandes a partir de cet ID (les autres sont identiques)

// connexion a la bdd BLF
require('../config/config.inc.php');

$connect = mysql_connect('localhost', 'root','a8GReg1VXxqw') or die('erreur de connexion');
mysql_select_db('bougies_la_francaise', $connect) or die('erreur de bdd');

// limit
$limit_customer_begin = 4384;
$limit_order_begin = 4418;

function doInsertSql($array_res_sql, $str_sql)
{
	$i = 0;
	$len = count($array_res_sql);
	foreach ($array_res_sql as $key => $value) 
	{
		$str_sql .= "\r\n"."(";
		$j = 0;
		$len_value = count($value);
		foreach ($value as $k => $v){
			// $str_sql .= '"'. $v . '"';
			$str_sql .=  mysql_real_escape_string($v) ;
			if($j != $len_value - 1)
				$str_sql .= ",";
			$j++;
		} 
		$str_sql .= ")";
		if($i != $len - 1)
			$str_sql .= ",";
		$i++;
	}
	return $str_sql;
} 

function executeSelectReq($sql){
	$array = array();
	$a = mysql_query($sql);
	while ($row = mysql_fetch_assoc($a)) 
		$array[] = $row;
	mysql_free_result($a);
	return $array;
}

// REQUETES DE RECUPERATIONS 
$sql_customers = "SELECT * FROM `ps_customer` ps_c WHERE ps_c.`id_customer` > ". $limit_customer_begin . ";";
$sql_customer_group = "SELECT * FROM `ps_customer_group` ps_g WHERE ps_g.`id_customer` > ". $limit_customer_begin . ";";
$sql_customer_thread = "SELECT * FROM `ps_customer_thread` ps_t WHERE ps_t.`id_customer` > ". $limit_customer_begin . ";";
$sql_customer_address = "SELECT * FROM `ps_address` ps_a WHERE ps_a.`id_customer` > ". $limit_customer_begin . ";";
// $sql_customer_message = "SELECT * FROM `ps_customer_message` ps_m WHERE ps_m.`id_customer` > 4275;";

$sql_orders = "SELECT * FROM `ps_orders` ps_o WHERE ps_o.`id_customer` > ". $limit_customer_begin . ";";
$sql_order_carrier = "SELECT * FROM `ps_order_carrier` ps_oc WHERE ps_oc.`id_order` > ". $limit_customer_begin . ";";
$sql_order_cart_rule = "SELECT * FROM `ps_order_cart_rule` ps_ocr WHERE ps_ocr.`id_order` > ". $limit_customer_begin . ";";
$sql_order_detail = "SELECT * FROM `ps_order_detail` ps_od WHERE ps_od.`id_order` > ". $limit_customer_begin . ";";
$sql_order_detail_tax = "SELECT ps_od.`id_order_detail`, ps_odt.* FROM `ps_order_detail` ps_od INNER JOIN `ps_order_detail_tax` ps_odt ON (ps_od.`id_order_detail` = ps_odt.`id_order_detail`) WHERE ps_od.`id_order` > ". $limit_customer_begin . ";";
$sql_order_history = "SELECT * FROM `ps_order_history` ps_oh WHERE ps_oh.`id_order` > ". $limit_customer_begin . ";";
$sql_order_invoice = "SELECT * FROM `ps_order_invoice` ps_oi WHERE ps_oi.`id_order` > ". $limit_customer_begin . ";";
$sql_order_invoice_payment = "SELECT * FROM `ps_order_invoice_payment` ps_oip WHERE ps_oip.`id_order` > ". $limit_customer_begin . ";";
$sql_order_invoice_tax = "SELECT ps_oi.`id_order_invoice`, ps_oit.* FROM `ps_order_invoice` ps_oi INNER JOIN `ps_order_invoice_tax` ps_oit ON (ps_oi.`id_order_invoice` = ps_oit.`id_order_invoice`) WHERE ps_oi.`id_order` > ". $limit_customer_begin . ";";
$sql_order_payment = "SELECT ps_op.* FROM `ps_orders` ps_o INNER JOIN `ps_order_payment` ps_op ON (ps_o.`reference` = ps_op.`order_reference`) WHERE ps_o.`id_order` > ". $limit_customer_begin . ";";
// $sql_order_return = "SELECT * FROM `ps_order_return` ps_or WHERE ps_or.`id_order` > ". $limit_customer_begin . ";";

// $res_customer = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql_customers);
$res_customer = executeSelectReq($sql_customers);

$res_customer_group = executeSelectReq($sql_customer_group);
$res_customer_thread = executeSelectReq($sql_customer_thread);
$res_customer_address = executeSelectReq($sql_customer_address);
// $res_customer_message = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql_customer_message);

$res_orders = executeSelectReq($sql_orders);
$res_order_carrier = executeSelectReq($sql_order_carrier);
$res_order_cart_rule = executeSelectReq($sql_order_cart_rule);
$res_order_detail = executeSelectReq($sql_order_detail);
$res_order_detail_tax = executeSelectReq($sql_order_detail_tax);
$res_order_history = executeSelectReq($sql_order_history);
$res_order_invoice = executeSelectReq($sql_order_invoice);
$res_order_invoice_payment = executeSelectReq($sql_order_invoice_payment);
$res_order_invoice_tax = executeSelectReq($sql_order_invoice_tax);
$res_order_payment = executeSelectReq($sql_order_payment);
// $res_order_return = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql_order_return);

// CUSTOMER
$sql_new_ps_c = "INSERT INTO `ps_customer` (`id_customer`,`id_shop_group`,`id_shop`,`id_gender`,`id_default_group`,`id_lang`,`id_risk`,`company`,`siret`,`ape`,`firstname`,`lastname`,`email`,`passwd`,`last_passwd_gen`,`birthday`, `newsletter`, `ip_registration_newsletter`,`newsletter_date_add`,`optin`,`website`,`outstanding_allow_amount`,`show_public_prices`,`max_payment_days`,`secure_key`,`note`,`active`,`is_guest`,`deleted`,`date_add`,`date_upd`) VALUES ";
$sql_new_ps_g = "INSERT INTO `ps_customer_group` (`id_customer`,`id_group`) VALUES ";
$sql_new_ps_t = "INSERT INTO `ps_customer_thread` (`id_customer_thread`,`id_shop`,`id_lang`,`id_contact`, `id_customer`,`id_order`,`id_product`,`status`,`email`,`token`,`date_add`,`date_upd`) VALUES ";
$sql_new_ps_a = "INSERT INTO `ps_address` (`id_address`,`id_country`,`id_state`,`id_customer`,`id_manufacturer`,`id_supplier`,`id_warehouse`,`alias`,`company`,`lastname`,`firstname`,`address1`,`address2`,`postcode`,`city`,`other`,`phone`,`phone_mobile`,`vat_number`,`dni`,`date_add`,`date_upd`,`active`,`deleted`) VALUES ";
// $sql_new_ps_m = "INSERT INTO `ps_customer_message` (`id_customer_message`,`id_customer_thread`,`id_employee`,`message`,`file_name`,`ip_address`,`user_agent`,`date_add`,`date_upd`,`private`,`read`) VALUES ";

$sql_new_ps_o = "INSERT INTO `ps_orders` (`id_order`,`reference`,`id_shop_group`,`id_shop`,`id_carrier`,`id_lang`,`id_customer`,`id_cart`,`id_currency`,`id_address_delivery`,`id_address_invoice`,`current_state`,`secure_key`,`payment`,`conversion_rate`,`module`,`recyclable`,`gift`,`gift_message`,`mobile_theme`,`shipping_number`,`total_discounts`,`total_discounts_tax_incl`,`total_discounts_tax_excl`,`total_paid`,`total_paid_tax_incl`,`total_paid_tax_excl`,`total_paid_real`,`total_products`,`total_products_wt`,`total_shipping`,`total_shipping_tax_incl`,`total_shipping_tax_excl`,`carrier_tax_rate`,`total_wrapping`,`total_wrapping_tax_incl`,`total_wrapping_tax_excl`,`invoice_number`,`delivery_number`,`invoice_date`,`delivery_date`,`valid`,`date_add`,`date_upd`) VALUES ";
$sql_new_ps_oc = "INSERT INTO `ps_order_carrier` (`id_order_carrier`,`id_order`,`id_carrier`,`id_order_invoice`,`weight`,`shipping_cost_tax_excl`,`shipping_cost_tax_incl`,`tracking_number`,`date_add`) VALUES ";
$sql_new_ps_ocr = "INSERT INTO `ps_order_cart_rule` (`id_order_cart_rule`,`id_order`,`id_cart_rule`,`id_order_invoice`,`name`,`value`,`value_tax_excl`,`free_shipping`) VALUES ";

$sql_new_ps_od = "INSERT INTO `ps_order_detail` (`id_order_detail`,`id_order`,`id_order_invoice`,`id_warehouse`,`id_shop`,`product_id`,`product_attribute_id`,`product_name`,`product_quantity`,`product_quantity_in_stock`,`product_quantity_refunded`,`product_quantity_return`,`product_quantity_reinjected`,`product_price`,`reduction_percent`,`reduction_amount`,`reduction_amount_tax_incl`,`reduction_amount_tax_excl`,`group_reduction`,`product_quantity_discount`,`product_ean13`,`product_upc`,`product_reference`,`product_supplier_reference`,`product_weight`,`tax_computation_method`,`tax_name`,`tax_rate`,`ecotax`,`ecotax_tax_rate`,`discount_quantity_applied`,`download_hash`,`download_nb`,`download_deadline`,`total_price_tax_incl`,`total_price_tax_excl`,`unit_price_tax_incl`,`unit_price_tax_excl`,`total_shipping_price_tax_incl`,`total_shipping_price_tax_excl`,`purchase_supplier_price`,`original_product_price`) VALUES ";
$sql_new_ps_odt = "INSERT INTO `ps_order_detail_tax` (`id_order_detail`,`id_tax`,`unit_amount`,`total_amount`) VALUES ";
$sql_new_ps_oh = "INSERT INTO `ps_order_history` (`id_order_history`,`id_employee`,`id_order`,`id_order_state`,`date_add`) VALUES ";
$sql_new_ps_oi = "INSERT INTO `ps_order_invoice` (`id_order_invoice`,`id_order`,`number`,`delivery_number`,`delivery_date`,`total_discount_tax_excl`,`total_discount_tax_incl`,`total_paid_tax_excl`,`total_paid_tax_incl`,`total_products`,`total_products_wt`,`total_shipping_tax_excl`,`total_shipping_tax_incl`,`shipping_tax_computation_method`,`total_wrapping_tax_excl`,`total_wrapping_tax_incl`,`note`,`date_add`) VALUES ";
$sql_new_ps_oip = "INSERT INTO `ps_order_invoice_payment` (`id_order_invoice`,`id_order_payment`,`id_order`) VALUES ";
$sql_new_ps_oit = "INSERT INTO `ps_order_invoice_tax` (`id_order_invoice`,`type`,`id_tax`,`amount`) VALUES ";
$sql_new_ps_op = "INSERT INTO `ps_order_payment` (`id_order_payment`,`order_reference`,`id_currency`,`amount`,`payment_method`,`conversion_rate`,`transaction_id`,`card_number`,`card_brand`,`card_expiration`,`card_holder`,`date_add`) VALUES ";
$sql_new_ps_or = "INSERT INTO `ps_order_return` (`id_order_return`,`id_customer`,`id_order`,`state`,`question`,`date_add`,`date_upd`) VALUES ";

$customer_request = doInsertSql($res_customer, $sql_new_ps_c); //ok
$customer_group_request = doInsertSql($res_customer_group, $sql_new_ps_g); //ok
$customer_group_thread_request = doInsertSql($res_customer_thread, $sql_new_ps_t); //ok
// $customer_group_message_request = doInsertSql($res_customer_message, $sql_new_ps_m); //notok
$customer_group_address_request = doInsertSql($res_customer_address, $sql_new_ps_a); //ok
$orders_request = doInsertSql($res_orders, $sql_new_ps_o);//ok
$order_carrier_request = doInsertSql($res_order_carrier, $sql_new_ps_oc); //ok
$order_cart_rule_request = doInsertSql($res_order_cart_rule, $sql_new_ps_ocr); //ok
$order_detail_request = doInsertSql($res_order_detail, $sql_new_ps_od); //ok
$order_detail_tax_request = doInsertSql($res_order_detail_tax, $sql_new_ps_odt); //ok
$order_history = doInsertSql($res_order_history, $sql_new_ps_oh); //ok
$order_invoice = doInsertSql($res_order_invoice, $sql_new_ps_oi); //ok
$order_invoice_payment = doInsertSql($res_order_invoice_payment, $sql_new_ps_oip); //ok
$order_invoice_tax = doInsertSql($res_order_invoice_tax, $sql_new_ps_oit); //ok
$order_payment = doInsertSql($res_order_payment, $sql_new_ps_op); //ok
// $order_return = doInsertSql($res_order_return, $sql_new_ps_or); //notok

$data_req = array("CUSTOMER" => $customer_request,
				"CUSTOMER_GROUP" => $customer_group_request,
				"CUSTOMER_GROUP_THREAD" => $customer_group_thread_request,
				"CUSTOMER_GROUP_ADDRESS" => $customer_group_address_request,
				"ORDERS" => $orders_request,
				"ORDER_CARRIER" => $order_carrier_request,
				"ORDER_CART_RULE" => $order_cart_rule_request,
				"ORDER_DETAIL" => $order_detail_request,
				"ORDER_DETAIL_TAX_REQUEST" => $order_detail_tax_request,
				"ORDER_HISTORY" => $order_history,
				"ORDER_INVOICE" => $order_invoice,
				"ORDER_INVOICE_PAYMENT" => $order_invoice_payment,
				"ORDER_INVOICE_TAX" => $order_invoice_tax,
				"ORDER_PAYMENT" => $order_payment,
				);

$fp_z = fopen('request_for_new_blf.txt','w');
$fp = fopen('request_for_new_blf.txt','r+');
$res_ord_det_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("SELECT `id_order_detail` FROM `ps_order_detail` WHERE `id_order` > ". $limit_order_begin);
foreach ($res_ord_det_id as $key => $value) 
	fputs($fp, "DELETE FROM `ps_order_detail_tax` WHERE `id_order_detail`  > ". $value['id_order_detail'] . ";\r\n");//ok
$res_ord_invpay_id = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("SELECT `id_order_invoice` FROM `ps_order_invoice` WHERE `id_order` > ". $limit_order_begin);
foreach ($res_ord_invpay_id as $key => $value) 
	fputs($fp, "DELETE FROM `ps_order_invoice_tax` WHERE `id_order_invoice` > ". $value['id_order_invoice'] . ";\r\n");//ok
$res_ord_ref = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS("SELECT `reference` FROM `ps_order` WHERE `id_order` > ". $limit_order_begin);
foreach ($res_ord_ref as $key => $value) 
	fputs($fp, "DELETE FROM `ps_order_payment` WHERE `order_reference` = '". $value['id_order_detail'] . "';\r\n");//ok
fputs($fp, "DELETE FROM `ps_customer` WHERE `id_customer`  > ". $limit_customer_begin . ";\r\n"); //ok
fputs($fp, "DELETE FROM `ps_address` WHERE `id_customer`  > ". $limit_customer_begin . ";\r\n"); //ok
fputs($fp, "DELETE FROM `ps_customer_group` WHERE `id_customer`  > ". $limit_customer_begin . ";\r\n");//ok
fputs($fp, "DELETE FROM `ps_customer_thread` WHERE `id_customer`  > ". $limit_customer_begin . ";\r\n");//ok 
fputs($fp, "DELETE FROM `ps_order_carrier` WHERE `id_order`  > ". $limit_order_begin . ";\r\n"); //ok
fputs($fp, "DELETE FROM `ps_order_history` WHERE `id_order`  > ". $limit_order_begin . ";\r\n");
fputs($fp, "DELETE FROM `ps_order_invoice_payment` WHERE `id_order`  > ". $limit_order_begin . ";\r\n");
fputs($fp, "DELETE FROM `ps_order_cart_rule` WHERE `id_order`  > ". $limit_order_begin . ";\r\n"); //ok
fputs($fp, "DELETE FROM `ps_order_detail` WHERE `id_order`  > ". $limit_order_begin . ";\r\n");//ok
fputs($fp, "DELETE FROM `ps_order_invoice` WHERE `id_order`  > ". $limit_order_begin . ";\r\n");//ok
fputs($fp, "DELETE FROM `ps_order` WHERE `id_order`  > ". $limit_order_begin . ";\r\n");//ok
echo "<div style='color:green;'>REQUETE(S) DE SUPPRESSION ORDER CREEE(S) ! </div>";
echo "------------------------------------------------------------------------------------------<br/>";
echo " <br/>CREATION DES REQUETES D'INSERTION <br/><br/>";
foreach ($data_req as $key => $value) {
	fputs($fp, "############## TABLE " . $key. " ############## " . "\r\n");
	fputs($fp, $value);
	fputs($fp, "\r\n" . "############## END TABLE " . $key . " ############# " . "\r\n");
	fputs($fp, "\r\n\r\n");
	echo "<div>REQUETE(S) DE LA TABLE <span style='color:green;'>PS_" . $key . "</span> CREEE(S) ! </div>";
	echo "------------------------------------------------------------------------------------------<br/>";
}
fclose($fp);

echo '<br />Les requetes sont dans le fichier <a href="http://www.bougies-la-francaise.com/script/request_for_new_blf.txt">ICI</a><br />';
echo "SCRIPT END";
die();