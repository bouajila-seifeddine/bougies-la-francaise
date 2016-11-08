<?php
/**
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    Peter Michael Solidum <myke021403@yahoo.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class BraintreePaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;
    public $client_token = '';

    /**
    * @see FrontController::initContent()
    */
    public function initContent()
    {
        parent::initContent();

        $bt_merchant_id = '';

        // for custom

        $cart = $this->context->cart;
        $year_now = date('Y', time());
        $year_end = date('Y', time()) + 8;
        $exp_dates = array();

        for ($x = $year_now; $x < $year_end; $x++) {
            array_push($exp_dates, $x);
        }

        // for drop-in feature
        $environment = Configuration::get('ENVIRONMENT');
        if ($environment) {
            $mode = 'production';
        } else {
            $mode = 'sandbox';
        }
        
        require_once _PS_MODULE_DIR_.'/braintree/lib/Braintree.php';

        Braintree_Configuration::environment($mode);
        Braintree_Configuration::merchantId(Configuration::get('MERCHANT_ID'));
        Braintree_Configuration::publicKey(Configuration::get('PUBLIC_KEY'));
        Braintree_Configuration::privateKey(Configuration::get('PRIVATE_KEY'));

        $currency = $this->context->currency;
        $multicurrency = Configuration::get('MULTICURRENCY');
        if ($multicurrency != '') {
            $multicurrency_array = explode(',', $multicurrency);
            foreach ($multicurrency_array as $row) {
                $exploded_currency = explode('=', $row);
                if ($exploded_currency[1] == $currency->iso_code) {
                    $bt_merchant_id = $exploded_currency[0];
                }
            }
        }

        if ($bt_merchant_id != '') {
            $this->client_token = Braintree_ClientToken::generate(
                array(
                    'merchantAccountId' => $bt_merchant_id
                )
            );
        } else {
            $this->client_token = Braintree_ClientToken::generate();
        }

        $this->context->smarty->assign(array(
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'currencies' => $this->module->getCurrency((int)$cart->id_currency),
            'total' => $cart->getOrderTotal(true, Cart::BOTH),
            'this_path' => $this->module->getPathUri(),
            'this_path_bw' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/',
            'exp_dates' => $exp_dates,
            'client_token' => $this->client_token,
            'form_type' => Configuration::get('FORM_TYPE'),
            'three_d_secure' => Configuration::get('THREEDSECURE'),
        ));

        $this->setTemplate('payment_execution.tpl');
    }
}
