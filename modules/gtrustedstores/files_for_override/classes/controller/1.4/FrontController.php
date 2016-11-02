<?php
/**
 * Google Trusted Stores
 *
 * @author  Business Tech (www.businesstech.fr) - Contact: http://www.businesstech.fr/en/contact-us
 * @license Business Tech
 * @version 1.1.7
 * @category smart_shopping
 * @copyright Business Tech
 *
 * Languages: EN, FR
 * PS versions: 1.4, 1.5, 1.6
 *
 */
class FrontController extends FrontControllerCore
{
	// Google Trusted Stores requires order confirmation on https / SSL
	// but PrestaShop does not force SSL on order confirmation
	public function __construct()
	{
		global $useSSL;

		// BT - add override on detecting PayPal's payment controller
		if (strstr($_SERVER['SCRIPT_NAME'], 'paypal')|| strstr($_SERVER['REQUEST_URI'], 'paypal')) {
			$this->ssl = true;
		}

		$useSSL = $this->ssl;
	}
}