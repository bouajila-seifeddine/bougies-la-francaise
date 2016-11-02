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

if (!defined('_PS_VERSION_')) {
    exit;
}

class BrainTree extends PaymentModule
{
    private $html = '';
    private $postErrors = array();
    public $merchant_id;
    public $public_key;
    public $private_key;
    public $environment;
    public $extra_mail_vars;

    public function __construct()
    {
        $this->name = 'braintree';
        $this->version = '1.1.4';
        $this->author = 'Peter Michael Solidum';
        $this->controllers = array('payment', 'validation');
        $this->tab = 'payments_gateways';
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->is_eu_compatible = 1;
        $this->bootstrap = true;
        $this->module_key = 'b400009e344185adb4b8b749e8506158';

        parent::__construct();

        $config = Configuration::getMultiple(array('MERCHANT_ID', 'PUBLIC_KEY', 'PRIVATE_KEY', 'ENVIRONMENT', 'FORM_TYPE', 'SUBMITFORSETTLEMENT', 'MULTICURRENCY', 'THREEDSECURE'));
        if (isset($config['MERCHANT_ID'])) {
            $this->merchant_id = $config['MERCHANT_ID'];
        }
        if (isset($config['PUBLIC_KEY'])) {
            $this->public_key = $config['PUBLIC_KEY'];
        }
        if (isset($config['PRIVATE_KEY'])) {
            $this->private_key = $config['PRIVATE_KEY'];
        }
        if (isset($config['ENVIRONMENT'])) {
            $this->environment = $config['ENVIRONMENT'];
        }
        if (isset($config['SECURE_KEY'])) {
            $this->environment = $config['SECURE_KEY'];
        }
        if (isset($config['FORM_TYPE'])) {
            $this->environment = $config['FORM_TYPE'];
        }
        if (isset($config['SUBMITFORSETTLEMENT'])) {
            $this->environment = $config['SUBMITFORSETTLEMENT'];
        }
        if (isset($config['MULTICURRENCY'])) {
            $this->environment = $config['MULTICURRENCY'];
        }
        if (isset($config['THREEDSECURE'])) {
            $this->environment = $config['THREEDSECURE'];
        }

        $this->displayName = $this->l('BrainTree Payment Gateway');
        $this->description = $this->l('Allow you to accept credit cards from your website using BrainTree.');
        $this->confirmUninstall = $this->l('Are you sure you want to delete these details?');

        $this->extra_mail_vars = array(
            '{merchant_id}' => Configuration::get('MERCHANT_ID'),
            '{public_key}' => Configuration::get('PUBLIC_KEY'),
            '{private_key}' => Configuration::get('PRIVATE_KEY'),
            '{environment}' => Configuration::get('ENVIRONMENT'),
            '{secure_key}' => Configuration::get('SECURE_KEY'),
            '{form_type}' => Configuration::get('FORM_TYPE'),
            '{submitforsettlement}' => Configuration::get('SUBMITFORSETTLEMENT'),
            '{multicurrency}' => Configuration::get('MULTICURRENCY'),
            '{threedsecure}' => Configuration::get('THREEDSECURE')
        );
    }

    public function install()
    {
        return parent::install() && $this->registerHook('payment') && $this->registerHook('header')
            && $this->registerHook('displayPaymentEU') && $this->registerHook('adminOrder')
            && $this->registerHook('BackOfficeHeader') && $this->installDb();
    }

    public function uninstall()
    {
        if (!Configuration::deleteByName('MERCHANT_ID') ||
            !Configuration::deleteByName('PUBLIC_KEY') ||
            !Configuration::deleteByName('PRIVATE_KEY') ||
            !Configuration::deleteByName('ENVIRONMENT') ||
            !Configuration::deleteByName('SECURE_KEY') ||
            !Configuration::deleteByName('FORM_TYPE') ||
            !Configuration::deleteByName('SUBMITFORSETTLEMENT') ||
            !Configuration::deleteByName('displayPaymentEU') ||
            !Configuration::deleteByName('MULTICURRENCY') ||
            !Configuration::deleteByName('THREEDSECURE') ||
            !parent::uninstall()) {
            return false;
        }
        return true;
    }

    private function installDb()
    {
        return Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'braintree` (
			`id_braintree_transaction` int(11) NOT NULL AUTO_INCREMENT,
			`type` enum(\'payment\',\'refund\') NOT NULL,
			`status` varchar(32) NOT NULL,
			`id_shop` int(11) unsigned NOT NULL DEFAULT \'0\',
			`id_customer` int(11) unsigned NOT NULL,
			`id_cart` int(11) unsigned NOT NULL,
			`id_order` int(11) unsigned NOT NULL,
			`id_transaction` varchar(32) NOT NULL,
			`mode` enum(\'production\',\'sandbox\') NOT NULL,
			`current_state` int(11) unsigned NOT NULL DEFAULT \'0\',
			`date_add` datetime NOT NULL,
		PRIMARY KEY (`id_braintree_transaction`), KEY `idx_transaction` (`type`,`id_order`))
		ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
    }

    public function hookPayment($params)
    {
        if (!$this->adminSettings()) {
            return;
        }

        $this->smarty->assign(array(
            'this_path' => $this->_path,
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/'
        ));

        return $this->display(__FILE__, 'payment.tpl');
    }

    public function getContent()
    {
        $this->html = '';
        if (Tools::isSubmit('btnSubmit')) {
            $this->postValidation();
            if (!count($this->postErrors)) {
                $this->postProcess();
            } else {
                foreach ($this->postErrors as $err) {
                    $this->html .= $this->displayError($err);
                }
            }
        }

        $this->html .= $this->renderForm();
        $this->html .= '<div style="margin: 30px">';
        $this->html .= '<h3>Additional Instructions:</h3>';
        $this->html .= '<span style="font-weight:bold">3D SECURE - IMPORTANT NOTE</span></p>';
        $this->html .= '<p>This feature only works for <strong>Drop-in Payment UI</strong></p>';
        $this->html .= '<p>When enabling 3D Secure feature. Make sure you have activated it on your braintree admin panel, otherwise this feature will not work.<br>If using multi-currency: ALL Merchant Account MUST have 3D Secure faeture enabled.</p>';
        $this->html .= '<span style="font-weight:bold">Sample Credit Card</span></p>';
        $this->html .= '<p>Sample Valid Credit Card # for sandbox ONLY: ';
        $this->html .= '<span style="font-weight:bold">3566002020360505</span></p>';
        $this->html .= '<p>More info of Test Credit Card ';
        $this->html .= '<a href="https://developers.braintreepayments.com';
        $this->html .= '/ios+ruby/reference/general/testing" target="_blank">here</a>:</p>';
        $this->html .= '<p style="font-weight:bold">Currency Setup(Single):</p>';
        $this->html .= '<ul><li>Merchant Account ID=Currency ISO Code</li><li>Example: MerchantAccountID=USD</li><li>If none added, it will select the default currency of Prestashop & your Braintree Account</li></ul>';
        $this->html .= '<p style="font-weight:bold">Currency Setup(Multiple):</p>';
        $this->html .= '<ul><li>Merchant Account ID=Currency ISO Code</li><li>Example: MerchantAccountID=USD, MechantAccountIDtwo=EUR, MechantAccountIDthree=GBP</li><li>Each currency must be separated by COMMA.</li><li>If none added, it will select the default currency of Prestashop & your Braintree Account</li></ul>';
        $this->html .= '<p style="font-weight:bold">NOTE: If currency setup left blank or wrong Merchant Account ID, it will charge the customer with the default currency setup in Braintree Account.</p>';
        $this->html .= '</div>';

        return $this->html;
    }

    public function hookDisplayPaymentEU($params)
    {
        if (!$this->adminSettings()) {
            return;
        }

        if (!$this->active) {
            return;
        }

        if (!$this->checkCurrency($params['cart'])) {
            return;
        }
        $payment_options = array(
            'cta_text' => $this->l('Pay by Braintree'),
            'logo' => Media::getMediaPath(_PS_MODULE_DIR_.$this->name.'/logo.png'),
            'action' => $this->context->link->getModuleLink($this->name, 'payment', array('token' => Tools::getToken(false), 'redirect' => true), true)
        );

        return $payment_options;
    }

    private function adminSettings()
    {
        $setup = true;

        if (Configuration::get('MERCHANT_ID') == '' || Configuration::get('PUBLIC_KEY') == '' || Configuration::get('PRIVATE_KEY') == '') {
            $setup = false;
        }

        return $setup;
    }

    public function checkCurrency($cart)
    {
        $currency_order = new Currency($cart->id_currency);
        $currencies_module = $this->getCurrency($cart->id_currency);

        if (is_array($currencies_module)) {
            foreach ($currencies_module as $currency_module) {
                if ($currency_order->id == $currency_module['id_currency']) {
                    return true;
                }
            }
        }
        return false;
    }

    private function postValidation()
    {
        if (Tools::isSubmit('btnSubmit')) {
            if (!Tools::getValue('MERCHANT_ID')) {
                $this->postErrors[] = $this->l('The "Merchant ID" field is required.');
            }
            if (!Tools::getValue('PUBLIC_KEY')) {
                $this->postErrors[] = $this->l('The "Public Key" field is required.');
            }
            if (!Tools::getValue('PRIVATE_KEY')) {
                $this->postErrors[] = $this->l('The "Private Key" field is required.');
            }


            if (Tools::getValue('MERCHANT_ID') != '' && Tools::getValue('PUBLIC_KEY') != '' && Tools::getValue('PRIVATE_KEY') != '' && Tools::getValue('ENVIRONMENT') != '') {
                // CHECK IF THE CONFIGURATION IS CORRECT.
                require_once _PS_MODULE_DIR_.'/braintree/lib/Braintree.php';

                $environment = Tools::getValue('ENVIRONMENT');
                if ($environment) {
                    $mode = 'production';
                } else {
                    $mode = 'sandbox';
                }
                Braintree_Configuration::environment($mode);
                Braintree_Configuration::merchantId(Tools::getValue('MERCHANT_ID'));
                Braintree_Configuration::publicKey(Tools::getValue('PUBLIC_KEY'));
                Braintree_Configuration::privateKey(Tools::getValue('PRIVATE_KEY'));

                try {
                    Braintree_ClientToken::generate();
                } catch (Exception $e) {
                    $this->postErrors[] = $this->l('The configuration is incorrect. Please double check your credentials.');
                }
            }
        }
    }

    private function postProcess()
    {
        if (Tools::isSubmit('btnSubmit')) {
            Configuration::updateValue('MERCHANT_ID', Tools::getValue('MERCHANT_ID'));
            Configuration::updateValue('PUBLIC_KEY', Tools::getValue('PUBLIC_KEY'));
            Configuration::updateValue('PRIVATE_KEY', Tools::getValue('PRIVATE_KEY'));
            Configuration::updateValue('ENVIRONMENT', Tools::getValue('ENVIRONMENT'));
            Configuration::updateValue('FORM_TYPE', Tools::getValue('FORM_TYPE'));
            Configuration::updateValue('SUBMITFORSETTLEMENT', Tools::getValue('SUBMITFORSETTLEMENT'));
            Configuration::updateValue('MULTICURRENCY', Tools::getValue('MULTICURRENCY'));
            Configuration::updateValue('THREEDSECURE', Tools::getValue('THREEDSECURE'));
        }
        $this->html .= $this->displayConfirmation($this->l('Settings updated'));
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('BrainTree Settings'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Environment'),
                        'name' => 'ENVIRONMENT',
                        'values' =>	array(
                            array(
                                'id' => 'prod',
                                'value' => 1,
                                'label' => $this->l('Production')
                            ),
                            array(
                                'id' => 'test',
                                'value' => 0,
                                'label' => $this->l('Sandbox')
                            )
                        ),
                        'is_bool' => true,
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Merchant ID'),
                        'name' => 'MERCHANT_ID',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Public Key'),
                        'name' => 'PUBLIC_KEY',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Private Key'),
                        'name' => 'PRIVATE_KEY',
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Form Type'),
                        'name' => 'FORM_TYPE',
                        'values' => array(
                            array(
                                'id' => 'dropin',
                                'value' => 1,
                                'label' => $this->l('Drop-in Payment UI')
                            ),
                            array(
                                'id' => 'custom',
                                'value' => 0,
                                'label' => $this->l('Custom Payment UI')
                            )
                        ),
                        'is_bool' => true,
                        'required' => true,
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('Automatically Submit for Settlement?'),
                        'name' => 'SUBMITFORSETTLEMENT',
                        'values' => array(
                            array(
                                'id' => 'yes',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'no',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                        'is_bool' => true,
                        'required' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Currency setup'),
                        'name' => 'MULTICURRENCY',
                    ),
                    array(
                        'type' => 'radio',
                        'label' => $this->l('3D Secure'),
                        'name' => 'THREEDSECURE',
                        'values' => array(
                            array(
                                'id' => 'yes',
                                'value' => 1,
                                'label' => $this->l('Yes')
                            ),
                            array(
                                'id' => 'no',
                                'value' => 0,
                                'label' => $this->l('No')
                            )
                        ),
                        'is_bool' => true,
                        'required' => true,
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save')
                )
            ),
        );

        if (Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG')) {
            $allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG');
        } else {
            $allow_employee_form_lang = 0;
        }
        
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table =  $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = $allow_employee_form_lang;
        $this->fields_form = array();
        $helper->id = (int)Tools::getValue('id_carrier');
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'btnSubmit';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'MERCHANT_ID' => Tools::getValue('MERCHANT_ID', Configuration::get('MERCHANT_ID')),
            'PUBLIC_KEY' => Tools::getValue('PUBLIC_KEY', Configuration::get('PUBLIC_KEY')),
            'PRIVATE_KEY' => Tools::getValue('PRIVATE_KEY', Configuration::get('PRIVATE_KEY')),
            'ENVIRONMENT' => Tools::getValue('ENVIRONMENT', Configuration::get('ENVIRONMENT')),
            'FORM_TYPE' => Tools::getValue('FORM_TYPE', Configuration::get('FORM_TYPE')),
            'SUBMITFORSETTLEMENT' => Tools::getValue('SUBMITFORSETTLEMENT', Configuration::get('SUBMITFORSETTLEMENT')),
            'MULTICURRENCY' => Tools::getValue('MULTICURRENCY', Configuration::get('MULTICURRENCY')),
            'THREEDSECURE' => Tools::getValue('THREEDSECURE', Configuration::get('THREEDSECURE')),
        );
    }

    public function hookAdminOrder($params)
    {
        if (Db::getInstance()->getValue('SELECT module FROM '._DB_PREFIX_.'orders WHERE id_order = '.(int)Tools::getValue('id_order')) == $this->name) {
            $total_paid = Db::getInstance()->getValue('SELECT total_paid FROM '._DB_PREFIX_.'orders WHERE id_order = '.(int)Tools::getValue('id_order'));

            $braintree_data = Db::getInstance()
                ->getRow('SELECT id_transaction, status, id_braintree_transaction, current_state FROM '._DB_PREFIX_.'braintree WHERE id_order = '.(int)Tools::getValue('id_order'));

            if ($braintree_data && $braintree_data['current_state'] == 0) {
                $this->context->smarty->assign(
                    array(
                        'total_paid' => $total_paid,
                        'id_transaction' => $braintree_data['id_transaction'],
                        'status' => $braintree_data['status'],
                        'id_braintree_transaction' => $braintree_data['id_braintree_transaction']
                    )
                );

                return $this->display(__FILE__, 'views/templates/admin/admin-order.tpl');
            }
        }
    }

    private function processRefund($data)
    {
        $order_state = '';
        $braintree_status = '';
        // print_r($data);
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

        switch ($data['status']) {
            case 'settled':
                $result = Braintree_Transaction::refund($data['id_transaction']);
                if ($result->success) {
                    $order_state = 7;
                    $braintree_status = 'refunded';
                }
                break;
            case 'settling':
                $result = Braintree_Transaction::refund($data['id_transaction']);
                if ($result->success) {
                    $order_state = 7;
                    $braintree_status = 'refunded';
                }
                break;
            case 'authorized':
                $result = Braintree_Transaction::void($data['id_transaction']);

                if ($result->success) {
                    $order_state = 6;
                    $braintree_status = 'voided';
                }
                break;
            case 'submitted_for_settlement':
                $result = Braintree_Transaction::void($data['id_transaction']);
                if ($result->success) {
                    $order_state = 6;
                    $braintree_status = 'voided';
                }
                break;
            case 'settlement_pending':
                $result = Braintree_Transaction::void($data['id_transaction']);
                if ($result->success) {
                    $order_state = 6;
                    $braintree_status = 'voided';
                }
                break;
            default:
                # code...
                break;
        }

        if ($order_state != '') {
            // update add this to ps_order_history table
            $objOrder = new Order($data['id_order']);
            $history = new OrderHistory();
            $history->id_order = (int)$objOrder->id;
            $history->changeIdOrderState($order_state, (int)($objOrder->id));
            $history->save();

            $current_state = 1;

            // change the braintree table status.
            Db::getInstance()->Execute("
                UPDATE "._DB_PREFIX_."braintree SET status = '".pSQL($braintree_status)."', 
                current_state = ".(int)$current_state." WHERE id_order = ".(int)$data['id_order']."");
        }
    }

    /*
    * Call this function if refund button has been submitted.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::isSubmit('braintree_refund')) {
            $data = array(
                'amount' => (int)Tools::getValue('amount'),
                'id_transaction' => Tools::getValue('id_transaction'),
                'status' => Tools::getValue('status'),
                'id_order' => (int)Tools::getValue('id_order'),
                'id_employee' => (int)$this->context->cookie->id_employee
            );

            $this->processRefund($data);
        }
    }
}
