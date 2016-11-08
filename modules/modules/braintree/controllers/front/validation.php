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

class BraintreeValidationModuleFrontController extends ModuleFrontController
{
    public $json = array(
        'errorMsg' => true,
        'msg' => ''
    );

    /**
    * @see FrontController::postProcess()
    */
    public function postProcess()
    {
        $bt_merchant_id = '';
        $currency = $this->context->currency;
        $submit_for_settlement = false;
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

        $environment = Configuration::get('ENVIRONMENT');
        if ($environment) {
            $mode = 'production';
        } else {
            $mode = 'sandbox';
        }

        if (Configuration::get('SUBMITFORSETTLEMENT') == 1) {
            $submit_for_settlement = true;
        }

        if (Configuration::get('THREEDSECURE') == 1) {
            $three_d_secure = true;
        } else {
            $three_d_secure = false;
        }

        $cart = $this->context->cart;
        if ($cart->id_customer == 0 ||
            $cart->id_address_delivery == 0 ||
            $cart->id_address_invoice == 0 ||
            !$this->module->active) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        // Check that this payment option is still available in case the customer
        // changed his address just before the end of the checkout process
        $authorized = false;
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'braintree') {
                $authorized = true;
                break;
            }
        }

        if (!$authorized) {
            die($this->module->l('This payment method is not available.', 'validation'));
        }

        if (Configuration::get('FORM_TYPE') == 0) {
            $validation = false;
            $error = '<div class="alert alert-danger">';
            // validate the user input first.
            if (Tools::getValue('card_name') == null) {
                $validation = true;
                $error .= $this->module->l('Card Name is required.') . ' ';
            }

            if (Tools::getValue('card_number') == null) {
                $validation = true;
                $error .= $this->module->l('Card Number is required.').' ';
            }

            if (Tools::getValue('expiration_month') == null && Tools::getValue('expiration_year') == null) {
                $validation = true;
                $error .= $this->module->l('Expiration Date is required.').' ';
            }

            $card_exp = strtotime(Tools::getValue('expiration_year') . '-' . Tools::getValue('expiration_month') . '-' . date('d', time()));

            if ($card_exp <= time()) {
                $validation = true;
                $error .= $this->module->l('Expiration Date is invalid.').' ';
            }

            if (Tools::getValue('cvv') == null) {
                $validation = true;
                $error .= $this->module->l('CVV is required.').' ';
            }

            $error .= '</div>';

            if ($validation) {
                $json = array(
                    'errorMsg' => true,
                    'msg' => $error
                );

                echo Tools::jsonEncode($json);
                die();
            }
        }

        $customer = new Customer((int)$cart->id_customer);

        if (!Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }
        
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);

        require_once _PS_MODULE_DIR_.'/braintree/lib/Braintree.php';

        Braintree_Configuration::environment($mode);
        Braintree_Configuration::merchantId(Configuration::get('MERCHANT_ID'));
        Braintree_Configuration::publicKey(Configuration::get('PUBLIC_KEY'));
        Braintree_Configuration::privateKey(Configuration::get('PRIVATE_KEY'));

        if (Configuration::get('FORM_TYPE') == 1) {
            if (Tools::getValue('payment_method_nonce') == '') {
                $this->json['msg'] = '<div class="alert alert-danger">'.$this->module->l('Please select a payment method.').'</div>';
                echo Tools::jsonEncode($this->json);
                die();
            }

            if ($bt_merchant_id != '') {
                $result = Braintree_Transaction::sale(array(
                    'amount' => $total,
                    'merchantAccountId' => $bt_merchant_id,
                    'paymentMethodNonce' => Tools::getValue('payment_method_nonce'),
                    'options' => array(
                        'submitForSettlement' => $submit_for_settlement,
                        'three_d_secure' => array(
                            'required' => $three_d_secure
                        )
                    )
                ));

            } else {
                $result = Braintree_Transaction::sale(array(
                    'amount' => $total,
                    'paymentMethodNonce' => Tools::getValue('payment_method_nonce'),
                    'options' => array(
                        'submitForSettlement' => $submit_for_settlement,
                        'three_d_secure' => array(
                            'required' => $three_d_secure
                        )
                    )
                ));
            }
        } else {
            if ($bt_merchant_id != '') {
                $result = Braintree_Transaction::sale(array(
                    'amount' => $total,
                    'merchantAccountId' => $bt_merchant_id,
                    'creditCard' => array(
                        'cardholderName' => Tools::getValue('card_name'),
                        // 'number' => '3566002020360505',
                        'number' => Tools::getValue('card_number'),
                        'expirationDate' => Tools::getValue('expiration_month') . '/' . Tools::getValue('expiration_year'),
                        'cvv' => Tools::getValue('cvv')
                    ),
                    'options' => array(
                        'submitForSettlement' => $submit_for_settlement
                    )
                ));
            } else {
                $result = Braintree_Transaction::sale(array(
                    'amount' => $total,
                    'creditCard' => array(
                        'cardholderName' => Tools::getValue('card_name'),
                        // 'number' => '3566002020360505',
                        'number' => Tools::getValue('card_number'),
                        'expirationDate' => Tools::getValue('expiration_month') . '/' . Tools::getValue('expiration_year'),
                        'cvv' => Tools::getValue('cvv')
                    ),
                    'options' => array(
                        'submitForSettlement' => $submit_for_settlement
                    )
                ));
            }
            
        }

        if ($result->success) {
            // Braintree_Transaction::submitForSettlement($result->transaction->id);

            $this->module->validateOrder(
                (int)$cart->id,
                Configuration::get('PS_OS_PAYMENT'),
                $total,
                $this->module->displayName,
                null,
                array(),
                (int)$currency->id,
                false,
                $customer->secure_key
            );

            // $custom = explode(';', Tools::getValue('custom'));
            // $shop = new Shop((int)$custom[1]);
            // $context = Context::getContext();
            // $context->shop = $shop;

            $environment = Configuration::get('ENVIRONMENT');
            if ($environment) {
                $mode = 'production';
            } else {
                $mode = 'sandbox';
            }

            $data = array(
                'type' => 'payment',
                'status' => $result->transaction->status,
                'id_shop' => 0,
                'id_customer' => (int)$this->context->cart->id_customer,
                'id_cart' => (int)$this->context->cart->id,
                'id_order' => (int)$this->module->currentOrder,
                'id_transaction' => $result->transaction->id,
                'mode' => $mode,
                'current_state' => 0
            );

            $this->addTransaction($data, 'payment');

            // Tools::redirect('index.php?controller=history');
            $this->json['errorMsg'] = false;
            $this->json['msg'] = 'index.php?controller=history';

            if (Configuration::get('FORM_TYPE') == 1) {
                Tools::redirect('index.php?controller=history');
            }
        } elseif ($result->transaction) {
            // print_r($result);
            // print_r("Error processing transaction:");
            // print_r("\n  code: " . $result->transaction->processorResponseCode);
            // print_r("\n  text: " . ;

            $error_msg = $result->transaction->processorResponseText;
            $this->json['msg'] = '<div class="alert alert-danger">'.$error_msg.'</div>';
        } else {
            // print_r("Validation errors: \n");
            // print_r($result->errors->deepAll());

            $this->json['msg'] = '<div class="alert alert-danger">'.$result->message.'</div>';
        }

        echo Tools::jsonEncode($this->json);
        die();
    }

    private function addTransaction($details, $type = 'payment')
    {
        $current_state = 0;

        return Db::getInstance()->Execute('
            INSERT INTO '._DB_PREFIX_.'braintree (
                type,
                status,
                id_shop,
                id_customer,
                id_cart,
                id_order,
                id_transaction,
                mode,
                current_state,
                date_add)
            VALUES (
                \''.pSQL($type).'\',
                \''.pSQL($details['status']).'\',
                '.(int)$details['id_shop'].',
                '.(int)$details['id_customer'].',
                '.(int)$details['id_cart'].',
                '.(int)$details['id_order'].',
                \''.pSQL($details['id_transaction']).'\',
                \''.pSQL($details['mode']).'\',
                '.(int)$current_state.',
                NOW())');
    }
}
