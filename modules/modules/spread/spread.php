<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once 'SpreadOrderState.php';

class Spread extends Module
{

    const SPREAD_ORDER_CREATE_URL = 'https://social-sb.com/api/CreateOrder';
    const SPREAD_ORDER_UPDATE_URL = 'https://social-sb.com/api/UpdateOrder';
    const SPREAD_ACCOUNT_CREATE_URL = 'https://social-sb.com/api/CreateAccount';
    const SPREAD_ACCOUNT_UPDATE_URL = 'https://social-sb.com/api/UpdateAccount';
    const SPREAD_ACCOUNT_GET_COOKIE_KEY = 'https://social-sb.com/api/RegenCookie';
    const SPREAD_COOKIE_LIFETIME = 15552000;

    /*Coupons limits*/
    const SPREAD_COUPON_MAX_PERCENT = 10;
    const SPREAD_COUPON_MAX_FIXED = 10;
    const SPREAD_COUPON_LIFETIME = 30;
    const SPREAD_COUPON_MIN_AMOUNT = 30;

    public function __construct()
    {

        $this->name = 'spread';
        $this->tab = 'advertising_marketing';
        $this->version = '2.2';
        $this->author = 'Spread';
        $this->need_instance = 1;

        $this->currencies = false;

        parent::__construct();

        $this->displayName = $this->l('Spread');
        $this->description = $this->l('Automatically integrates Spread in Prestashop to increase your sales through social networks');

        /* Backward compatibility */
        if (_PS_VERSION_ < '1.5')
            require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
    }

    /**
     * Install the module
     * @return bool
     */
    public function install() {
        $install_query = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'spread_order_state` (`id_order_state` int(11) unsigned NOT NULL, `spread_order_state` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;ALTER TABLE `' . _DB_PREFIX_ . 'spread_order_state` ADD UNIQUE KEY `id_order_state` (`id_order_state`);';

        if (!parent::install() || !$this->installTabs() || !Db::getInstance()->execute($install_query) || !$this->registerHook('displayOrderConfirmation') || !$this->registerHook('actionOrderStatusUpdate') || !$this->registerHook('ActionObjectCustomerAddAfter') || !$this->registerHook('ActionObjectCustomerUpdateAfter') || !$this->registerHook('ActionObjectAddressAddAfter') || !$this->registerHook('ActionObjectAddressUpdateAfter') || !$this->registerHook('footer') || !$this->registerHook('actionAuthentication') || !$this->registerHook('ActionObjectOrderAddAfter') || !$this->isWellConfigured() || !Configuration::updateValue('SB_PUBLICKEY', '') || !Configuration::updateValue('SB_PRIVATEKEY', '') || !Configuration::updateValue('SB_COUPON_PERCENT', Spread::SPREAD_COUPON_MAX_PERCENT) || !Configuration::updateValue('SB_COUPON_FIXED', Spread::SPREAD_COUPON_MAX_FIXED) || !Configuration::updateValue('SB_COUPON_LIFETIME', Spread::SPREAD_COUPON_LIFETIME) || !Configuration::updateValue('SB_COUPON_MIN_AMOUNT', Spread::SPREAD_COUPON_MIN_AMOUNT)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Uninstall the module
     * @return bool
     */
    public function uninstall() {
        $uninstall_query = 'DROP TABLE ' . _DB_PREFIX_ . 'spread_order_state';
        if (!Db::getInstance()->execute($uninstall_query) || !parent::uninstall() || !$this->uninstallTabs() || !Configuration::deleteByName('SB_PUBLICKEY') || !Configuration::deleteByName('SB_PRIVATEKEY') || !Configuration::deleteByName('SB_COUPON_MAX_PERCENT') || !Configuration::deleteByName('SB_COUPON_MAX_FIXED') || !Configuration::deleteByName('SB_COUPON_LIFETIME')) {
            return false;
        }

        return true;
    }

    /**
     * Install the SPREAD tab
     * @return mixed
     */
    public function installTabs() {
        $tab = new Tab();
        $tab->active = 1;
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = 'Spread';
        }

        $tab->class_name = 'AdminSpread';
        $tab->id_parent = Tab::getIdFromClassName('AdminCustomers');
        $tab->module = $this->name;

        return $tab->add();
    }

    /**
     * Uninstall the SPREAD tab
     * @return bool
     */
    public function uninstallTabs() {

        $id_tab = (int) Tab::getIdFromClassName('AdminSpread');
        if ($id_tab) {
            $tab = new Tab($id_tab);

            return $tab->delete();
        } else {
            return false;
        }
    }

    public function isWellConfigured() {
        if (function_exists('curl_version')) {
            return true;
        }

        return false;
    }

    // HOOKS

    public function hookActionAuthentication($params) {

        if (!$this->context->customer->isLogged()) {
            return false;
        }

        if (isset($params['customer']))
        {
            $params['object'] = $params['customer'];
            unset($params['customer']);
        }

        $data = $this->getCustomerData($params);
        $this->sendSpreadCurl(self::SPREAD_ACCOUNT_UPDATE_URL, $data);
        $curl = $this->sendSpreadCurl(self::SPREAD_ACCOUNT_GET_COOKIE_KEY, $data);
        $response = $curl->getResponse();

        if ($response && isset($response->datas) && isset($response->datas->cookie))
        {
            $cookie_lifetime = self::SPREAD_COOKIE_LIFETIME;
            $expire = time() + (int) $cookie_lifetime;
            setcookie('sbtl', $response->datas->cookie, $expire, '/');
        }
    }


    public function hookActionObjectOrderAddAfter($params) {
        $id_lang = $params['object']->id_lang;
        $order = new Order(Order::getOrderByCartId($params['object']->id_cart));

        $spread_order_state = SpreadOrderState::getSpreadOrderStateByIdOrderState($order->getCurrentState());
        $spread_order_state = $spread_order_state ? $spread_order_state : 10;

        $customer = new Customer($order->id_customer);

        $address = new Address($order->id_address_delivery);
        $country = new Country(Country::getIdByName($id_lang, $address->country));
        $gender = new Gender($customer->id_gender, $id_lang);

        $data = array(
            'data' => array(
                'customer_firstname' => $customer->firstname,
                'customer_name' => $customer->lastname,
                'customer_email' => $customer->email,
                'order_amount' => $order->total_paid_tax_incl,
                'order_idorder' => Order::getOrderByCartId($params['object']->id_cart),
                'date' => $order->date_add,
                'order_state' => $spread_order_state,
                'customer_isoptin' => $customer->newsletter,
                'customer_country' => $country->iso_code,
                'customer_birthday' => $customer->birthday,
                'customer_gender' => $gender->name,
                'action' => 'order'

                /* Autres champs disponibles */

                // 'customer_tel' => '01********',
                // 'customer_mobile' => '06********',
                // 'custom_fields' => array('52' => 'animaux', '<id_du_champ_perso>' => 'affilié'),
                // 'add_tag' => '<tag1>, <tag2>',
            )
        );

        if (isset($_COOKIE['sbt'])) {
            $data['data']['customer_cookie'] = $_COOKIE['sbt'];
        }

        $data['request'] = array('order_idorder' => Order::getOrderByCartId($params['object']->id_cart));


        $this->sendSpreadCurl(self::SPREAD_ORDER_CREATE_URL, $data);

        return true;
    }

    public function hookActionOrderStatusUpdate($params) {
        $order = new Order($params['id_order']);
        $id_lang = $order->id_lang;

        $spread_order_state = SpreadOrderState::getSpreadOrderStateByIdOrderState($params['newOrderStatus']->id);

        if (in_array($spread_order_state, SpreadOrderState::getSpreadOrderStateAvailable())) {

            $customer = new Customer($order->id_customer);

            $address = new Address($order->id_address_delivery);
            $country = new Country(Country::getIdByName($id_lang, $address->country));
            $gender = new Gender($customer->id_gender, $id_lang);

            $data = array(
                'data' => array(
                    'customer_firstname' => $customer->firstname,
                    'customer_name' => $customer->lastname,
                    'customer_email' => $customer->email,
                    'order_amount' => $order->total_paid_tax_incl,
                    'order_idorder' => $order->id,
                    'date' => $order->date_add,
                    'order_state' => $spread_order_state,
                    'customer_isoptin' => $customer->newsletter,
                    'customer_country' => $country->iso_code,
                    'customer_birthday' => $customer->birthday,
                    'customer_gender' => $gender->name,
                    'action' => 'order'
                /* Autres champs disponibles */

                // 'customer_tel' => '01********',
                // 'customer_mobile' => '06********',
                // 'custom_fields' => array('52' => 'animaux', '<id_du_champ_perso>' => 'affilié'),
                // 'add_tag' => '<tag1>, <tag2>',
                )
            );

            if (isset($_COOKIE['sbt'])) {
                $data['data']['customer_cookie'] = $_COOKIE['sbt'];
            }

            $data['request'] = array('order_idorder' => $order->id);

            $this->sendSpreadCurl(self::SPREAD_ORDER_UPDATE_URL, $data);

            return true;
        }
    }

    public function getCustomerData($params) {
        $customer = $params['object'];

        $id_lang = $customer->id_lang;
        $gender = new Gender($customer->id_gender, $id_lang);
        $customer_group = new Group($customer->id_default_group, $id_lang);
        $data = array(
            'customer_birthday' => $customer->birthday,
            'customer_gender' => $gender->name,
            'customer_firstname' => $customer->firstname,
            'customer_name' => $customer->lastname,
            'customer_email' => $customer->email,
            'group' => $customer_group->name,
            'customer_isoptin' => $customer->newsletter
                /* Autres champs disponibles */

                // 'customer_tel' => '01********',
                // 'customer_mobile' => '06********',
                // 'custom_fields' => array('52' => 'animaux', '<id_du_champ_perso>' => 'affilié'),
                // 'add_tag' => '<tag1>, <tag2>',
        );

        if (isset($_COOKIE['sbt'])) {
            $data['customer_cookie'] = $_COOKIE['sbt'];
        }

        $address = Address::getFirstCustomerAddressId($customer->id, true);
        $address_data = array();
        if ($address && isset($address->id_country)) {
            $country = new Country($address->id_country, $id_lang);
            $address_data = array(
                'customer_address' => $address->address1 . ', ' . $address->address2,
                'customer_cp' => $address->postcode,
                'customer_city' => $address->city,
                'customer_country' => $country->iso_code,
                'customer_tel' => $address->phone,
                'customer_mobile' => $address->phone_mobile,
                'customer_company' => $address->company,
                'customer_fonction' => '',
                'action' => 'signup'
                    /* Autres champs disponibles */

                    // 'customer_tel' => '01********',
                    // 'customer_mobile' => '06********',
                    // 'custom_fields' => array('52' => 'animaux', '<id_du_champ_perso>' => 'affilié'),
                    // 'add_tag' => '<tag1>, <tag2>',
            );
            $data = array('data' => array_merge($data, $address_data));
        }
        $data = array('data' => array_merge($data, $address_data));
        return $data;
    }

    public function getCustomerDataFromAddress($params) {
        $address = $params['object'];
        if ($address->id_customer == 0) {
            return false;
        }
        $customer = new Customer($address->id_customer);
        $id_lang = $customer->id_lang;
        $gender = new Gender($customer->id_gender, $id_lang);
        $customer_group = new Group($customer->id_default_group, $id_lang);
        $data = array(
            'customer_birthday' => $customer->birthday,
            'customer_gender' => $gender->name,
            'customer_firstname' => $customer->firstname,
            'customer_name' => $customer->lastname,
            'customer_email' => $customer->email,
            'group' => $customer_group->name,
            'customer_isoptin' => $customer->newsletter
                /* Autres champs disponibles */

                // 'customer_tel' => '01********',
                // 'customer_mobile' => '06********',
                // 'custom_fields' => array('52' => 'animaux', '<id_du_champ_perso>' => 'affilié'),
                // 'add_tag' => '<tag1>, <tag2>',
        );

        if (isset($_COOKIE['sbt'])) {
            $data['customer_cookie'] = $_COOKIE['sbt'];
        }

        $country = new Country($address->id_country, $id_lang);
        $address_data = array(
            'customer_address' => $address->address1 . ', ' . $address->address2,
            'customer_cp' => $address->postcode,
            'customer_city' => $address->city,
            'customer_country' => $country->iso_code,
            'customer_tel' => $address->phone,
            'customer_mobile' => $address->phone_mobile,
            'customer_company' => $address->company,
            'customer_fonction' => ''
        );
        $data = array('data' => array_merge($data, $address_data));

        return $data;
    }

    public function hookActionObjectCustomerAddAfter($params) {
        $data = $this->getCustomerData($params);
        $this->sendSpreadCurl(self::SPREAD_ACCOUNT_CREATE_URL, $data);
    }

    public function hookActionObjectCustomerUpdateAfter($params) {
        $data = $this->getCustomerData($params);
        $this->sendSpreadCurl(self::SPREAD_ACCOUNT_UPDATE_URL, $data);
    }

    public function hookActionObjectAddressUpdateAfter($params) {
        $data = $this->getCustomerDataFromAddress($params);
        $this->sendSpreadCurl(self::SPREAD_ACCOUNT_UPDATE_URL, $data);
    }

    public function hookActionObjectAddressAddAfter($params) {
        $data = $this->getCustomerDataFromAddress($params);
        $this->sendSpreadCurl(self::SPREAD_ACCOUNT_UPDATE_URL, $data);
    }

    public function sendSpreadCurl($url, $data) {
        require_once _PS_MODULE_DIR_ . $this->name . '/SpreadCurl.php';
        $curl = SpreadCurl::getInstance($url, $data);
        return $curl;
    }

    public function hookfooter($params) {
        $this->smarty->assign('publicKeySb', Configuration::get('SB_PUBLICKEY'));

        return $this->display(__FILE__, 'footer.tpl');
    }

    public function getContent() {

        $this->context->controller->addCss(_MODULE_DIR_ . $this->name . '/css/admin.css', 'screen');

        $output = '';
        // Check requirements
        if (!$this->isWellConfigured()) {
            $output .= '<div class="error">' . $this->l('Curl seems not to be installed on your server') . '</div>';
        }
        // Form treatments
        $output .= $this->postProcess();

        // Header
        $output .= '<div id="SpreadAdminHeader"></div>';

        $output .= '<div id="SpreadAdminContent">';

        // Keys
        $output .= '<form class="form" action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" method="post" style="width:100%;display:inline-block">';
        $output .= '<input type="hidden" name="saveKeys"/>';
        $output .= '<fieldset>';
        $output .= '<div class="legend">' . $this->l('Configure your keys') . '</div>';
        $output .= '<label for="public_key">' . $this->l('Public key') . '&nbsp;&nbsp;</label>';
        $output .= '<div class="margin-form">';
        $output .= '<input type="text" name="public key" value="' . Configuration::get('SB_PUBLICKEY') . '"/>';
        $output .= '</div>';
        $output .= '<label for="private_key">' . $this->l('Private key') . '&nbsp;&nbsp;</label>';
        $output .= '<div class="margin-form">';
        $output .= '<input type="text" name="private_key" value="' . Configuration::get('SB_PRIVATEKEY') . '"/>';
        $output .= '</div>';
        $output .= '<button class="button">' . $this->l('Save keys') . '</button>';
        $output .= '</fieldset>';
        $output .= '</form>';

        // Spread Order States
        $output .= '<form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" class="form" method="post">';
        $order_states = OrderState::getOrderStates(Context::getContext()->language->id);
        $output .= '<input type="hidden" name="saveOrderStates" value="' . count($order_states) . '"/>';
        $output .= '<fieldset>';
        $output .= '<div class="legend">' . $this->l('Matching order statuses') . '</div>';
        if (count($order_states)) {
            $output .= '<table class="table table_grid">';
            $output .= '<tr class="nodrag nodrop">';
            $output .= '<th>' . $this->l('Order state') . '</th>';
            $output .= '<th>' . $this->l('Spread Order state') . '</th>';
            $output .= '</tr>';
            foreach ($order_states as $i => $order_state) {
                $output .= '<tr class="';
                $output .= (is_int($i / 2)) ? 'alt_row' : '';
                $output .= ' row_hover">';
                $output .= '<td>' . $order_state['name'] . '</td>';
                $output .= '<td>';
                $output .= '<input type="hidden" name="idOrderState_' . $i . '" value="' . $order_state['id_order_state'] . '"/>';
                $output .= '<select class="spreadOrderState" name="orderState_' . $i . '">' . $this->getOrderStatesAsOptions($order_state['id_order_state']) . '</select>';
                $output .= '</td>';
                $output .= '</tr>';
            }
            $output .= '</table>';
        }
        $output .= '<button class="button">' . $this->l('Save order states') . '</button>';
        $output .= '</fieldset>';
        $output .= '</form>';

        // Spread coupons
        $output .= '<form action="' . Tools::safeOutput($_SERVER['REQUEST_URI']) . '" class="form" method="post">';
        $output .= '<input type="hidden" name="saveCouponsConf" value=""/>';
        $output .= '<fieldset>';
        $output .= '<div class="legend">' . $this->l('Configure your coupons generation') . '</div>';

        $output .= '<label for="public_key">' . $this->l('Coupon max percent') . '&nbsp;&nbsp;</label>';
        $output .= '<div class="margin-form">';
        $output .= '<input type="text" name="coupon_max_percent" value="';
        $output .= (Configuration::get('SB_COUPON_MAX_PERCENT')) ? Configuration::get('SB_COUPON_MAX_PERCENT') : self::SPREAD_COUPON_MAX_PERCENT;
        $output .= '"/>';
        $output .= '<span>' . $this->l('0 by default') . '</span>';
        $output .= '</div>';

        $output .= '<label for="public_key">' . $this->l('Coupon max fixed') . '&nbsp;&nbsp;</label>';
        $output .= '<div class="margin-form">';
        $output .= '<input type="text" name="coupon_max_fixed" value="';
        $output .= (Configuration::get('SB_COUPON_MAX_FIXED')) ? Configuration::get('SB_COUPON_MAX_FIXED') : self::SPREAD_COUPON_MAX_FIXED;
        $output .= '"/>';
        $output .= '<span>' . $this->l('0 by default') . '</span>';
        $output .= '</div>';

        $output .= '<label for="public_key">' . $this->l('Coupon lifetime in days') . '&nbsp;&nbsp;</label>';
        $output .= '<div class="margin-form">';
        $output .= '<input type="text" name="coupon_lifetime" value="';
        $output .= (Configuration::get('SB_COUPON_LIFETIME')) ? Configuration::get('SB_COUPON_LIFETIME') : self::SPREAD_COUPON_LIFETIME;
        $output .= '"/>';
        $output .= '<span>' . $this->l('30 by default') . '</span>';
        $output .= '</div>';

        $output .= '<label for="public_key">' . $this->l('Minimum amount') . '&nbsp;&nbsp;(' . $this->l('Excluding tax, postage and handling charges.') . ')</label>';
        $output .= '<div class="margin-form">';
        $output .= '<input type="text" name="coupon_min_amount" value="';
        $output .= (Configuration::get('SB_COUPON_MIN_AMOUNT')) ? Configuration::get('SB_COUPON_MIN_AMOUNT') : self::SPREAD_COUPON_MIN_AMOUNT;
        $output .= '"/>';
        $output .= '<span>' . $this->l('30 by default') . '</span>';
        $output .= '</div>';

        $output .= '<button class="button">' . $this->l('Save coupons configuration') . '</button>';
        $output .= '</fieldset>';
        $output .= '</form>';

        $output .= '</div>';

        // Return Content
        return $output;
    }
    
    public function postProcess() {
        $errors = array();
        $html = '';

        if (version_compare(_PS_VERSION_, '1.6', '>')) {
            $success_class = 'alert alert-success';
            $error_class = 'alert alert-error';
        } else {
            $success_class = 'conf';
            $error_class = 'error';
        }

        // Keys
        if (Tools::isSubmit('saveKeys')) {
            if (Tools::isSubmit('public_key')) {
                if (Configuration::updateValue('SB_PUBLICKEY', Tools::getValue('public_key'))) {
                    $success[] = $this->l('Public key has been saved');
                } else {
                    $errors[] = $this->l('An error occured, Public key has not been saved');
                }
            }
            if (Tools::isSubmit('private_key')) {
                if (Configuration::updateValue('SB_PRIVATEKEY', Tools::getValue('private_key'))) {
                    $success[] = $this->l('Private key has been saved');
                } else {
                    $errors[] = $this->l('An error occured, Private key has not been saved');
                }
            }

            $html .= (version_compare(_PS_VERSION_, '1.6', '>')) ? '<div class="bootstrap">' : '';
            if (count($errors)) {
                $html .= '<div class="' . $error_class . '">' . implode('<br/>', $errors) . '</div>';
            } else {
                $html .= '<div class="' . $success_class . '">' . implode('<br/>', $success) . '</div>';
            }
            $html .= (version_compare(_PS_VERSION_, '1.6', '>')) ? '</div>' : '';
        }

        // Spread Order States
        if (Tools::isSubmit('saveOrderStates')) {
            require_once _PS_MODULE_DIR_ . $this->name . '/SpreadOrderState.php';
            $order_states_count = Tools::getValue('saveOrderStates');
            if ($order_states_count > 0) {
                for ($i = 0; $i <= $order_states_count; $i++) {
                    if (Tools::isSubmit('orderState_' . $i)) {
                        $value = Tools::getValue('orderState_' . $i);
                        $id_order_state = Tools::getValue('idOrderState_' . $i);
                        if (isset($value) && $id_order_state) {
                            if (!SpreadOrderState::save($id_order_state, $value)) {
                                $errors[] = $this->l('Order state `' . $id_order_state . '` have not been saved');
                            }
                        }
                    }
                }
            }
            $html .= (version_compare(_PS_VERSION_, '1.6', '>')) ? '<div class="bootstrap">' : '';
            if (count($errors)) {
                $html .= '<div class="' . $error_class . '">' . implode('<br/>', $errors) . '</div>';
            } else {
                $html .= '<div class="' . $success_class . '">' . $this->l('Orders states have been saved') . '</div>';
            }
            $html .= (version_compare(_PS_VERSION_, '1.6', '>')) ? '</div>' : '';
        }
        // Spread Coupon Configuration
        if (Tools::isSubmit('saveCouponsConf')) {
            if (Tools::isSubmit('coupon_max_percent')) {
                $coupon_max_percent = Tools::getValue('coupon_max_percent');
                if (!filter_var($coupon_max_percent, FILTER_VALIDATE_INT)){
                    //$errors[] = $this->l('Max percent should be an integer');
                }
            } else {
                $coupon_max_percent = self::SPREAD_COUPON_MAX_PERCENT;
            }


            if (Tools::isSubmit('coupon_max_fixed')) {
                $coupon_max_fixed = Tools::getValue('coupon_max_fixed');
                if (!filter_var($coupon_max_fixed, FILTER_VALIDATE_INT)){
                    //$errors[] = $this->l('Max fixed should be an integer');
                }
            } else {
                $coupon_max_fixed = self::SPREAD_COUPON_MAX_FIXED;
            }


            if (Tools::isSubmit('coupon_lifetime')) {
                $coupon_lifetime = Tools::getValue('coupon_lifetime');
                if (!filter_var($coupon_max_percent, FILTER_VALIDATE_INT)){
                    $errors[] = $this->l('Lifetime should be an integer');
                }
            } else {
                $coupon_lifetime = self::SPREAD_COUPON_LIFETIME;
            }

            if (Tools::isSubmit('coupon_min_amount')) {
                $coupon_min_amount = Tools::getValue('coupon_min_amount');
                if (!filter_var($coupon_min_amount, FILTER_VALIDATE_INT)){
                    $errors[] = $this->l('Amount should be an integer');
                }
            } else {
                $coupon_min_amount = self::SPREAD_COUPON_MIN_AMOUNT;
            }

            $html .= (version_compare(_PS_VERSION_, '1.6', '>')) ? '<div class="bootstrap">' : '';
            if (count($errors)) {
                $html .= '<div class="' . $error_class . '">' . implode('<br/>', $errors) . '</div>';
            } else {
                Configuration::updateValue('SB_COUPON_MAX_PERCENT', $coupon_max_percent);
                Configuration::updateValue('SB_COUPON_MAX_FIXED', $coupon_max_fixed);
                Configuration::updateValue('SB_COUPON_LIFETIME', $coupon_lifetime);
                Configuration::updateValue('SB_COUPON_MIN_AMOUNT', $coupon_min_amount);
                $html .= '<div class="' . $success_class . '">' . $this->l('Coupon configuration has been saved') . '</div>';
            }
            $html .= (version_compare(_PS_VERSION_, '1.6', '>')) ? '</div>' : '';
        }

        return $html;
    }

    public function getOrderStatesAsOptions($id_order_state) {
        $html = '';
        require_once _PS_MODULE_DIR_ . $this->name . '/SpreadOrderState.php';
        $spread_order_states = SpreadOrderState::getOrderStates();
        if (count($spread_order_states)) {
            foreach ($spread_order_states as $spread_id_order_state => $spread_order_state) {
                $retrieved_spread_order_state = SpreadOrderState::getSpreadOrderStateByIdOrderState($id_order_state);
                $html .= '<option value="' . $spread_id_order_state . '"';
                $html .= ($retrieved_spread_order_state !== false && $retrieved_spread_order_state == $spread_id_order_state) ? ' selected="selected"' : '';
                $html .= '>' . $spread_order_state . '</option>';
            }
        }

        return $html;
    }

}
