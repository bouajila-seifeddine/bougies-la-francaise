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

class Allinone_rewardsFacebookModuleFrontController extends ModuleFrontController
{
	public $content_only = true;
	public $display_header = false;
	public $display_footer = false;

	public function initContent()
	{
		parent::initContent();

		// check if the "like" clicked is for the fan page
		if (Tools::getValue('url') != Configuration::get('RFACEBOOK_FAN_PAGE') && Tools::getValue('url') != urldecode(Configuration::get('RFACEBOOK_FAN_PAGE')))
			die();

		$facebook = new RewardsFacebookModel();
		// User didn't like the page in the past
		if (Tools::getValue('like') == 1) {
			$facebook->like();
		} else if(Tools::getValue('like') == 0) {
			$facebook->unlike();
		}
	}
}