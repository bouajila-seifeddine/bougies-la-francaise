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

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/allinone_rewards.php');

if (Tools::getValue('secure_key') && Configuration::get('REWARDS_USE_CRON')) {
	$secureKey = Configuration::get('REWARDS_CRON_SECURE_KEY');
	if (!empty($secureKey) AND $secureKey === Tools::getValue('secure_key')) {
		RewardsModel::checkRewardsStates();
		RewardsAccountModel::sendReminder();
	}
}