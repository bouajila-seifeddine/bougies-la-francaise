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
            if (Tools::getValue('card_name') == null && Configuration::get('CARDHOLDERNAME') && !Configuration::get('ONEPAGECHECKOUT')) {
                $validation = true;
                $error .= '<p>'.$this->module->l('Card Name is required.') . '</p>';
            }

            if (Tools::getValue('card_number') == null) {
                $validation = true;
                $error .= '<p>'.$this->module->l('Card Number is required.').'</p>';
            }

            if (Tools::getValue('expiration_month') == null && Tools::getValue('expiration_year') == null) {
                $validation = true;
                $error .= '<p>'.$this->module->l('Expiration Date is required.').'</p>';
            }

            $card_exp = strtotime(Tools::getValue('expiration_year') . '-' . Tools::getValue('expiration_month') . '-' . date('d', time()));

            if ($card_exp <= time()) {
                $validation = true;
                $error .= '<p>'.$this->module->l('Expiration Date is invalid.').'</p>';
            }

            if (Tools::getValue('cvv') == null) {
                $validation = true;
                $error .= '<p>'.$this->module->l('CVV is required.').' ';
            }

            if (Tools::getValue('postal_code') == null && Configuration::get('POSTALCODE')) {
                $validation = true;
                $error .= '<p>'.$this->module->l('Postal Code is required.').'</p>';
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

            $user_data = array(
                'amount' => $total,
                'paymentMethodNonce' => Tools::getValue('payment_method_nonce'),
                'options' => array(
                    'submitForSettlement' => $submit_for_settlement,
                    'three_d_secure' => array(
                        'required' => $three_d_secure
                    )
                ),
                'customer' => array(
                    'firstName' => $this->context->customer->firstname,
                    'lastName' => $this->context->customer->lastname
                )
            );

            if ($bt_merchant_id != '') {
                $user_data['merchantAccountId'] = $bt_merchant_id;
            }
        } else {
            $cardholderName = Tools::getValue('card_name');
            $postalcode = Tools::getValue('postal_code');

            $user_data = array(
                'amount' => $total,
                'creditCard' => array(
                    'cardholderName' => $cardholderName,
                    // 'number' => '3566002020360505',
                    'number' => Tools::getValue('card_number'),
                    'expirationDate' => Tools::getValue('expiration_month') . '/' . Tools::getValue('expiration_year'),
                    'cvv' => Tools::getValue('cvv')
                ),
                'options' => array(
                    'submitForSettlement' => $submit_for_settlement
                ),
                'billing' => array(
                    'postalCode' => $postalcode
                ),
                'customer' => array(
                    'firstName' => $this->context->customer->firstname,
                    'lastName' => $this->context->customer->lastname
                )
            );

            if ($bt_merchant_id != '') {
                $user_data['merchantAccountId'] = $bt_merchant_id;
            }     
        }

        $result = Braintree_Transaction::sale($user_data);

        if ($result->success) {
            Braintree_Transaction::submitForSettlement($result->transaction->id);

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

            $custom = explode(';', Tools::getValue('custom'));
            // $shop = new Shop((int)$custom[1]);
            $context = Context::getContext();
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

            $this->json['errorMsg'] = false;
            $this->json['msg'] = __PS_BASE_URI__.'index.php?controller=order-confirmation&id_cart='.(int)$this->context->cart->id.'&id_module='.(int)$this->module->id.'&id_order='.(int)$this->module->currentOrder.'&key='.$customer->secure_key;
        } else {
            $this->json['msg'] = '<div class="alert alert-danger">';
            $this->json['msg'] .= '<p>There was an error processing your card. Please try again.</p>';

            foreach ($result->errors->deepAll() as $row) {
                $this->json['msg'] .= $this->validation_error_messages($row->code);
            }

            $this->json['msg'] .= '</div>';
        }

        echo Tools::jsonEncode($this->json);
        die();
    }

    private function validation_error_messages($code){
        $message = '';

        if ($code == 81723) {
            $message .= '<p>'.$this->module->l('Cardholder name is too long.').'</p>';
        }

        if ($code == 81703 || $code == 91726 || $code == 91734) {
            $message .= '<p>'.$this->module->l('Credit card type is not accepted by this merchant account.').'</p>';
        }

        if ($code == 81707) {
            $message .= '<p>'.$this->module->l('CVV verification failed.').'</p>';
        }

        if ($code == 81736) {
            $message .= '<p>'.$this->module->l('CVV must be 4 digits for American Express and 3 digits for other card types.').'</p>';
        }

        if ($code == 81710) {
            $message .= '<p>'.$this->module->l('Expiration date is invalid.').'</p>';
        }

        if ($code == 81715) {
            $message .= '<p>'.$this->module->l('Credit card number is invalid.').'</p>';
        }

        if ($code == 81716) {
            $message .= '<p>'.$this->module->l('Credit card number must be 12-19 digits.').'</p>';
        }

        if ($code == 81737) {
            $message .= '<p>'.$this->module->l('Postal code verification failed.').'</p>';
        }

        if ($code == 81750) {
            $message .= '<p>'.$this->module->l('Credit card number is prohibited.').'</p>';
        }

        return $message;
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
