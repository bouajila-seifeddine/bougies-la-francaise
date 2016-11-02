<?php
/*
 * @module    All-in-one Rewards
 * @copyright  Copyright (c) 2012 Yann BONNAILLIE (http://www.prestaplugins.com)
 * @author     Yann BONNAILLIE
 * @license    Commercial license
 * Support by mail  : contact@prestaplugins.com
 * Support on forum : Patanock
 * Support on Skype : Patanock13
 */

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_8_2($object)
{
	$result = true;

	/* drop bad index */
	try {
		@Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'rewards_facebook` DROP INDEX `index_unique_facebook_customer`');
	} catch (Exception $e) {}

	/* shorten the key */
	foreach (Currency::getCurrencies() as $currency) {
		Configuration::updateValue('RSPONSORSHIP_VOUCHER_VALUE_GC_'.(int)($currency['id_currency']), (float)Configuration::get('RSPONSORSHIP_DISCOUNT_VALUE_GC_'.(int)($currency['id_currency'])));
		Configuration::deleteByName('RSPONSORSHIP_DISCOUNT_VALUE_GC_'.(int)($currency['id_currency']));
	}

	/* new version */
	Configuration::updateValue('REWARDS_VERSION', $object->version);

	return $result;
}