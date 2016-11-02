<?php

require_once dirname(__FILE__) . '/../../spread.php';

class SpreadGeneratecouponcodeModuleFrontController extends ModuleFrontController {

    const DEFAULT_DISCOUNT_TYPE = 'reduction_percent';

    public function run() {
        $this->process();
        return true;
    }

    public function process() {

        if (!Tools::getValue('configuration') || !Tools::getValue('public_key')) {
            return false;
        }

        $datas = json_decode(Tools::getValue('configuration'));
        $public_key = Configuration::get('SB_PUBLICKEY');
        $private_key = Configuration::get('SB_PRIVATEKEY');

        if (Tools::getValue('private_key')) { // version sans basic auth
            $username = Tools::getValue('public_key');
            $password = Tools::getValue('private_key');

            $private_key = md5(trim($private_key) . trim(Tools::getValue('configuration')));
        } elseif (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])) {
            header('HTTP/ 401 Unauthorized');
            echo 'bad auth';
            return false;
        } else {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
        }

        if ($username != $public_key || $password != $private_key) {
            return false;
        }
        if (!$datas->name)
            return false;

        if (!$datas->code)
            return false;

        if (!$datas->amount)
            return false;

        $coupon_max_fixed = (Configuration::get('SB_COUPON_MAX_FIXED')) ? Configuration::get('SB_COUPON_MAX_FIXED') : Spread::SPREAD_COUPON_MAX_FIXED;
        $coupon_max_percent = (Configuration::get('SB_COUPON_MAX_PERCENT')) ? Configuration::get('SB_COUPON_MAX_PERCENT') : Spread::SPREAD_COUPON_MAX_PERCENT;
        $coupon_lifetime = (Configuration::get('SB_COUPON_LIFETIME')) ? Configuration::get('SB_COUPON_LIFETIME') : Spread::SPREAD_COUPON_LIFETIME;
        $coupon_min_amount = (Configuration::get('SB_COUPON_MIN_AMOUNT')) ? Configuration::get('SB_COUPON_MIN_AMOUNT') : Spread::SB_COUPON_MIN_AMOUNT;

        if (empty($datas->discount_type)) {
            $discount_type = self::DEFAULT_DISCOUNT_TYPE;
        } elseif ($datas->discount_type == 'fixed') {
            $discount_type = 'reduction_amount';
            if ($datas->amount > $coupon_max_fixed) {
                return false;
            }
        } else {
            $discount_type = 'reduction_percent';
            if ($datas->amount > $coupon_max_percent) {
                return false;
            }
        }

        $cart_rule = new CartRule();
        $cart_rule->name = array(Configuration::get('PS_LANG_DEFAULT') => $datas->name);
        $cart_rule->code = $datas->code;
        $cart_rule->minimum_amount = $coupon_min_amount;
        $cart_rule->$discount_type = $datas->amount;
        $cart_rule->date_from = date('Y-m-d h:i:s', time());
        $cart_rule->date_to = date('Y-m-d h:i:s', time() + ( $coupon_lifetime * 24 * 10 * 60 * 60));
        $cart_rule->save();
    }

}
