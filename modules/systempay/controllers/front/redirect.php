<?php
/**
 * Systempay payment module 1.2f (revision 61545)
 *
 * Compatible with V2 payment platform. Developped for Prestashop 1.5.0.x.
 * Support contact: supportvad@lyra-network.com.
 * 
 * Copyright (C) 2014 Lyra Network (http://www.lyra-network.com/) and contributors
 * 
 * 
 * NOTICE OF LICENSE
 *
 * This source file is licensed under the Open Software License version 3.0
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
*/

/**
 * This controller prepares form and redirects to Systempay payment gateway.
 */
class SystempayRedirectModuleFrontController extends ModuleFrontController {

	public function __construct() {
		parent::__construct();
	
		$this->display_column_left = false;
		$this->display_column_right = false;
	}
	
	/**
	 * @see FrontController::initContent()
	 */
	public function initContent() {
		parent::initContent();
		
		$this->context->smarty->assign('back_compat', Tools::version_compare(_PS_VERSION_, '1.6'));
		
		if($this->context->cart->nbProducts() <= 0) {
			$this->context->smarty->assign('systempay_empty_cart', true);
		} else {
			$this->context->smarty->assign('systempay_empty_cart', false);
			
			$data = array();
			$logo = '';
			
			$type = Tools::getValue('systempay_payment_type'); /* the selected systempay payment type */
			switch ($type) {
				case 'standard' :
					if (Configuration::get('SYSTEMPAY_STD_CARD_DATA_MODE') == 2 || Configuration::get('SYSTEMPAY_STD_CARD_DATA_MODE') == 3) {
						$data['card_type'] = Tools::getValue('systempay_card_type');
						
						if (Configuration::get('SYSTEMPAY_STD_CARD_DATA_MODE') == 3) {
							$data['card_number'] = Tools::getValue('systempay_card_number');
							$data['cvv'] = Tools::getValue('systempay_cvv');
							$data['expiry_month'] = Tools::getValue('systempay_expiry_month');
							$data['expiry_year'] = Tools::getValue('systempay_expiry_year');
						}
					}
						
					$logo = 'BannerLogo1.png';
					break;
						
				case 'multi' :
					$data['opt'] = Tools::getValue('systempay_opt');
					
					$logo = 'BannerLogo2.png';
					break;
					
				case 'oney' :
					$logo = 'BannerLogo3.png';
					break;
				
				default:
					// TODO define the default behaviour
					break;
			}
			
			$module = new Systempay();
			$params = $module->getFormFields($type, $data);
			
			$module->logger->logInfo('Data to be sent to payment platform : ' . print_r($params, true));

			$this->context->smarty->assign('systempay_params', $params);
			$this->context->smarty->assign('systempay_url', Configuration::get('SYSTEMPAY_PLATFORM_URL'));
			$this->context->smarty->assign('systempay_logo', $logo);
		}
		
		$this->setTemplate('redirect.tpl');	
	}
}