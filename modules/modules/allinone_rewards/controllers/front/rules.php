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

class Allinone_rewardsRulesModuleFrontController extends ModuleFrontController
{
	public $content_only = true;
	public $display_header = false;
	public $display_footer = false;

	public function init()
	{
		$this->content_only = true;
		$this->display_header = false;
		$this->display_footer = false;
		parent::init();
	}

	public function initContent()
	{
		// allow to not add the javascript at the end causing JS issue (presta 1.6)
		$this->controller_type = 'modulefront';
		parent::initContent();

		$this->context->smarty->assign(array('sback' => Tools::getValue('sback'), 'rules' => Configuration::get('RSPONSORSHIP_RULES_TXT', $this->context->language->id)));
		$this->setTemplate('rules.tpl');
	}
}