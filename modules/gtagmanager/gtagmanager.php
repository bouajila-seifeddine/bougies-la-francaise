<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crazyegg
 *
 * @author ttranminh
 */
class GTagManager extends Module {
	public function __construct() {
		$this->name = 'gtagmanager';
	 	$this->tab = 'analytics_stats';
	 	$this->version = '1.0.1';
		$this->author = 'Sutunam';
		$this->displayName = 'Google Tag Manager';

		parent::__construct();

		$this->description = $this->l('Integrate Google Tag Manager script into your shop');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details ?');
	}

	public function install(){
		if (!parent::install()
				|| !$this->registerHook('top')
				|| !Configuration::updateValue('GTAGMANAGER_ON', true)
			)
			return false;

		$lang_id = Language::getIdByIso('en');
		$templateVars = array();
		$templateVars['{admin_email}'] = Configuration::get('PS_SHOP_EMAIL');
		$templateVars['{ps_version}'] = _PS_VERSION_;
		$templateVars['{module_name}'] = $this->displayName;
		$templateVars['{module_version}'] = $this->version;
		$to = 'modules@sutunam.com';
		$toName = null;
		Mail::send(
			$lang_id,
			'default',
			Mail::l('installed the following module:') . ' ' . $this->name,
			$templateVars,
			$to, $toName,
			Configuration::get('PS_SHOP_EMAIL'),
			Configuration::get('PS_SHOP_NAME'),
			null,
			null,
			dirname(__FILE__) . DIRECTORY_SEPARATOR . 'mails'. DIRECTORY_SEPARATOR,
			true
		);

		return true;
	}

	public function uninstall() {
		if (!parent::uninstall()
				|| !Configuration::deleteByName('GTAGMANAGER_ON')
				|| !Configuration::deleteByName('GTAGMANAGER_TRACKING_CODE')
				)
			return false;
		return true;
	}

	public function getContent(){
		$output = '';

		if (Tools::isSubmit('submitUpdate')){
			Configuration::updateValue('GTAGMANAGER_ON', Tools::getValue('GTAGMANAGER_ON'));

			$tracking_code = str_replace("\r\n", ' ', Tools::getValue('GTAGMANAGER_TRACKING_CODE'));
			Configuration::updateValue('GTAGMANAGER_TRACKING_CODE', htmlspecialchars($tracking_code));

			$output .= $this->displayConfirmation($this->l('Configuration saved'));
		}

		global $smarty;
		$smarty->assign('GTAGMANAGER_ON', Configuration::get('GTAGMANAGER_ON'));
		$smarty->assign('GTAGMANAGER_TRACKING_CODE', htmlspecialchars_decode(Configuration::get('GTAGMANAGER_TRACKING_CODE')));

		return $output . $this->display(__FILE__, 'config.tpl');
	}

	public function hookTop($params){
		if (Configuration::get('GTAGMANAGER_ON')){
			return htmlspecialchars_decode(Configuration::get('GTAGMANAGER_TRACKING_CODE'));
		} else {
			return null;
		}
	}
}