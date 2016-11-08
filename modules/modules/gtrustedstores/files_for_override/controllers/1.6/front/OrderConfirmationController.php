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
class OrderConfirmationController extends OrderConfirmationControllerCore
{
	// Google Trusted Stores requires order confirmation on https / SSL
	// but PrestaShop does not force SSL on order confirmation
	public $ssl = true;
}

?>