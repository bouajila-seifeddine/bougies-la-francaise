<?php

include_once(dirname(__FILE__).'/../../config/config.inc.php');
include_once(dirname(__FILE__).'/ExpeditorModule.php');
$cookie = new Cookie('psAdmin', Tools::substr($_SERVER['PHP_SELF'], Tools::strlen(__PS_BASE_URI__), -10));
Tools::setCookieLanguage();

ini_set('display_errors', 'On');

function formatItem($string)
{
	return '"' . $string . '";';
}

function changeGender($gender)
{
	if ($gender == '1')
		return '2';
	elseif ($gender == '2')
		return '3';
	elseif ($gender == '3')
		return '4';
}
function getStandardSize($value)
{
	$ret = 'N';
	if ($value == true OR $value == '1' OR $value == 1)
		$ret = 'O';
	return formatItem($ret);
}

if (version_compare(_PS_VERSION_, '1.5.0.0') >= 0) {
	Autoload::getInstance()->generateIndex();
}

$expeditors = ExpeditorModule::getList();

$downloadFile = 'expeditor_'.date('Y-m-d').'_prestashop.csv';
ob_clean();
header("Content-Transfer-Encoding: binary");
header('Content-Type: application/vnd.ms-excel; charset=ISO-8859-1'); // Should work for IE & Opera
header("Content-Type: application/x-msexcel; charset=ISO-8859-1"); // Should work for the rest
header('Content-Disposition: attachment; filename="' . $downloadFile . '"');


foreach ($expeditors as $expeditor)
{	
	$order = new Order(intval($expeditor['id_order']));
	$customer = new Customer(intval($order->id_customer));
	$address = new Address(intval($order->id_address_delivery));
	$address_invoice = new Address(intval($order->id_address_invoice));
	$country = new Country(intval($address->id_country));
	$delivery_info = array();
	
	if (Configuration::get('EXPEDITOR_CARRIER_CODES_'.intval($expeditor['id_carrier'])) == 'SO')
		$delivery_info = Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'socolissimo_delivery_info WHERE id_cart = '.intval($order->id_cart).' AND id_customer = '.intval($customer->id));	
	
	if (isset($delivery_info) && !empty($delivery_info))
	{
		// Les numéros en commentaires correspondent aux emplacements dans le fichier .fmt de base.
		echo utf8_decode(formatItem(trim($delivery_info['delivery_mode']))); // code produit = 1
		echo formatItem('EXP'.intval($order->id)); // ref EXP + id_order

		/*echo utf8_decode(formatItem('1')); // 1
		echo utf8_decode(formatItem('2')); // 1*/
		
		if (in_array($delivery_info['delivery_mode'], array('RDV', 'DOM', 'DOS')))
		{	
			echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $delivery_info['prname']), 0, 35))); // Nom = 3
			echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $delivery_info['pradress3']), 0, 35))); // Numéro de voie = 4
			echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $delivery_info['pradress1']), 0, 35))); // Etage, couloir = 5
			echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $delivery_info['pradress2']), 0, 35))); // entrée, batiment escalier = 6
			echo utf8_decode(formatItem(Tools::substr($delivery_info['przipcode'], 0, 35))); // code postale 7
			echo utf8_decode(formatItem(Tools::substr($delivery_info['prtown'], 0, 35))); // ville 8

			/*echo utf8_decode(formatItem('3.1')); // 1
			echo utf8_decode(formatItem('4.1')); // 1
			echo utf8_decode(formatItem('5.1')); // 1
			echo utf8_decode(formatItem('6.1')); // 1
			echo utf8_decode(formatItem('7.1')); // 1
			echo utf8_decode(formatItem('8.1')); // 1*/

		}
		else
		{
			echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $address_invoice->lastname), 0, 35))); // Nom = 3
			echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $address_invoice->address1), 0, 35))); //  = 4
			echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $address_invoice->address2), 0, 35))); //  = 5
			echo utf8_decode(formatItem('')); //  = 6
			echo formatItem(str_replace(' ', '', $address_invoice->postcode)); // code postale 7
			echo utf8_decode(formatItem($address_invoice->city)); // ville 8

			/*echo utf8_decode(formatItem('3.2')); // 1
			echo utf8_decode(formatItem('4.2')); // 1
			echo utf8_decode(formatItem('5.2')); // 1
			echo utf8_decode(formatItem('6.2')); // 1
			echo utf8_decode(formatItem('7.2')); // 1
			echo utf8_decode(formatItem('8.2')); // 1*/
		}
	}
	else 
	{
		echo utf8_decode(formatItem(Configuration::get('EXPEDITOR_CARRIER_CODES_'.intval($expeditor['id_carrier'])))); // code produit = 1
		echo formatItem('EXP'.intval($order->id)); // ref EXP + id_order
		echo utf8_decode(formatItem(trim($customer->lastname))); // Nom = 3
		echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $address->address1), 0, 35))); // addresse1 = 4
		echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $address->address2), 0, 35))); //  = 5
		echo formatItem(''); // addresse3 = 6
		echo formatItem(str_replace(' ', '', $address->postcode)); // code postale 7
		echo utf8_decode(formatItem($address->city)); // ville 8*/

		/*echo utf8_decode(formatItem('1.3')); // 1
		echo utf8_decode(formatItem('2.3')); // 1
		echo utf8_decode(formatItem('3.3')); // 1
		echo utf8_decode(formatItem('4.3')); // 1
		echo utf8_decode(formatItem('5.3')); // 1
		echo utf8_decode(formatItem('6.3')); // 1
		echo utf8_decode(formatItem('7.3')); // 1
		echo utf8_decode(formatItem('8.3')); // 1*/
	}
	
	echo utf8_decode(formatItem($country->iso_code)); // Code pays iso 9
	echo formatItem($expeditor['weight']); // poids 10
	echo utf8_decode(formatItem('0')); // montant 11
	echo getStandardSize($expeditor['standard_size']); // 12

	/*echo utf8_decode(formatItem('9')); // 1
	echo utf8_decode(formatItem('10')); // 10
	echo utf8_decode(formatItem('11')); // 1
	echo utf8_decode(formatItem('12')); // 1*/
	
	if (Configuration::get('EXPEDITOR_CARRIER_CODES_'.intval($expeditor['id_carrier'])) == 'SO' && $delivery_info)
	{
		echo utf8_decode(formatItem(($delivery_info['cephonenumber']))); // 13
		echo utf8_decode(formatItem($customer->email)); // 14
		if (in_array($delivery_info['delivery_mode'], array('RDV', 'DOM', 'DOS')))
			echo utf8_decode(formatItem(Tools::substr(str_replace(',', '', $delivery_info['pradress4']), 0, 35))); // 15
		else
			echo utf8_decode(formatItem('')); // 15
		echo utf8_decode(formatItem(changeGender($customer->id_gender))); // civilité 16
		if (isset($delivery_info['prfirstname']) AND !empty($delivery_info['prfirstname']))
			echo utf8_decode(formatItem($delivery_info['prfirstname'])); // prenom = 17
		else
			echo utf8_decode(formatItem($customer->firstname)); // prenom = 17
		echo utf8_decode(formatItem($delivery_info['cecompanyname'])); // 18
		echo utf8_decode(formatItem(($delivery_info['cephonenumber']))); // 19
		echo utf8_decode(formatItem($delivery_info['cedoorcode1'])); // 20
		echo utf8_decode(formatItem($delivery_info['cedoorcode2'])); // 21

		/*echo utf8_decode(formatItem('13.1')); // 1
		echo utf8_decode(formatItem('14.1')); // 1
		echo utf8_decode(formatItem('15.1')); // 1
		echo utf8_decode(formatItem('16.1')); // 1
		echo utf8_decode(formatItem('17.1')); // 1
		echo utf8_decode(formatItem('18.1')); // 1
		echo utf8_decode(formatItem('19.1')); // 1
		echo utf8_decode(formatItem('20.1')); // 20
		echo utf8_decode(formatItem('21.1')); // 1*/
	} 
	else
	{
		echo str_replace(' ', '', formatItem((($address->phone != '') ? $address->phone : $address->phone_mobile != '' ? $address->phone_mobile : ''))); // 13
		echo formatItem((($customer->email != '') ? $customer->email : '')); // 14
		echo utf8_decode(formatItem('')); // addresse4 = 15
		echo utf8_decode(formatItem(changeGender($customer->id_gender))); // civilité 16
		echo utf8_decode(formatItem($address->firstname)); // Prenom > 17
		echo utf8_decode(formatItem($address->company)); // 18
		echo formatItem($address->phone_mobile); // 19
		echo formatItem(''); // 20
		echo formatItem(''); // 21

		/*echo utf8_decode(formatItem('13.2')); // 1
		echo utf8_decode(formatItem('14.2')); // 1
		echo utf8_decode(formatItem('15.2')); // 1
		echo utf8_decode(formatItem('16.2')); // 1
		echo utf8_decode(formatItem('17.2')); // 1
		echo utf8_decode(formatItem('18.2')); // 1
		echo utf8_decode(formatItem('19.2')); // 1
		echo utf8_decode(formatItem('20.2')); // 20
		echo utf8_decode(formatItem('21.2')); // 1*/
	}
	
	if ((isset($delivery_info) && !empty($delivery_info) && in_array($delivery_info['delivery_mode'], array('BPR', 'ACP', 'CIT', 'CDI', 'A2P', 'CMT', 'BDP'))) OR Configuration::get('EXPEDITOR_CARRIER_CODES_'.intval($expeditor['id_carrier'])) == 'SO' )
		echo utf8_decode(formatItem($delivery_info['prid'])); // 22
	else
		echo formatItem(''); // other 22
		
	echo formatItem(Configuration::get('PS_SHOP_NAME')); // 23
	
	if (isset($delivery_info) && !empty($delivery_info) && in_array($delivery_info['delivery_mode'], array('RDV', 'DOM', 'BPR', 'A2P')))
		echo utf8_decode(formatItem($delivery_info['cedeliveryinformation'])); // 24
	else
		echo formatItem(''); // 24
		
	if (isset($delivery_info) && !empty($delivery_info) && in_array($delivery_info['delivery_mode'], array('CMT', 'BDP')))
		echo utf8_decode(formatItem($delivery_info['przipcode'])); // 25
	else
		echo formatItem(''); // 25

	echo chr(13); // CR --> carriage return
	echo chr(10); // LF --> new line
}

exit();