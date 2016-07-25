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

require_once(_PS_MODULE_DIR_.'/allinone_rewards/plugins/RewardsLoyaltyPlugin.php');
require_once(_PS_MODULE_DIR_.'/allinone_rewards/plugins/RewardsSponsorshipPlugin.php');
require_once(_PS_MODULE_DIR_.'/allinone_rewards/plugins/RewardsFacebookPlugin.php');
require_once(_PS_MODULE_DIR_.'/allinone_rewards/models/RewardsStateModel.php');
require_once(_PS_MODULE_DIR_.'/allinone_rewards/models/RewardsModel.php');
require_once(_PS_MODULE_DIR_.'/allinone_rewards/models/RewardsPaymentModel.php');
require_once(_PS_MODULE_DIR_.'/allinone_rewards/models/RewardsFacebookModel.php');
require_once(_PS_MODULE_DIR_.'/allinone_rewards/models/RewardsAccountModel.php');

class allinone_rewards extends Module
{
	public $html = '';
	public $confirmation = '';
	public $errors = '';
	public $path = __FILE__;
	private $_categories;
	private $_top_category;

	public function __construct($init=true)
	{
		$this->name = 'allinone_rewards';
		$this->tab = 'advertising_marketing';
		$this->version = '1.9.4';
		$this->author = 'Prestaplugins';
		$this->need_instance = 1;
		$this->ps_versions_compliancy['min'] = '1.5.0.1';
		$this->module_key = 'a5f535f18bd0a7a74d44b578250baca1';

		// Plugins to install : loyalty, sponsorship, then facebook, sendtoafriend...
		$this->loyalty = new RewardsLoyaltyPlugin($this);
		$this->sponsorship = new RewardsSponsorshipPlugin($this);
		$this->facebook = new RewardsFacebookPlugin($this);
		$this->plugins = array($this->loyalty, $this->sponsorship, $this->facebook);

		parent::__construct();

		$this->displayName = $this->l('All-in-one Rewards : loyalty, multi levels sponsorship, affiliation, Facebook...');
		$this->description = $this->l('This module allows your customers to earn rewards while developing SEO and reputation of your shop: loyalty program, sponsorship program (multi-level, self-promotional),... In addition, the rewards are all grouped into a single account!');
		$this->confirmUninstall = $this->l('Do you really want to remove this module and all of its settings (customer\'s rewards and sponsorship won\'t be removed) ?');

		// add the warnings for each plugin
		if ($this->active)
			foreach($this->plugins as $plugin)
				$plugin->checkWarning();

		// Can happen if upgraded from a version of the module made for presta 1.4 and > 1.7 (so update 1.7 of the module made for 1.5 has not been executed)
		// so we have to launch the update 1.7 manually
		if ($init && Configuration::get('REWARDS_VERSION') && version_compare(Configuration::get('REWARDS_VERSION'), '1.7', '>=') && Configuration::get('REWARDS_MINIMAL_SHIPPING')==NULL) {
			include(_PS_MODULE_DIR_.'/allinone_rewards/upgrade/install-1.7.php');
			upgrade_module_1_7($this);
		}

		// Bug in the first prestashop version 1.5.3.1, upgrades are not executed
		if ($init && version_compare(_PS_VERSION_, '1.5.3.1', '=') && Configuration::get('REWARDS_VERSION') && version_compare($this->version, Configuration::get('REWARDS_VERSION'), '>') && Module::needUpgrade($this) == null) {
			$this->installed = true;
			Module::initUpgradeModule($this);
			Module::$modules_cache[$this->name]['upgrade']['upgraded_from'] = Configuration::get('REWARDS_VERSION');
			Module::loadUpgradeVersionList($this->name, $this->version, Configuration::get('REWARDS_VERSION'));
			$this->runUpgradeModule();
		}
	}

	public function instanceDefaultStates() {
		$this->rewardStateDefault = new RewardsStateModel(RewardsStateModel::getDefaultId());
		$this->rewardStateValidation = new RewardsStateModel(RewardsStateModel::getValidationId());
		$this->rewardStateCancel = new RewardsStateModel(RewardsStateModel::getCancelId());
		$this->rewardStateConvert = new RewardsStateModel(RewardsStateModel::getConvertId());
		$this->rewardStateDiscounted = new RewardsStateModel(RewardsStateModel::getDiscountedId());
		$this->rewardStateReturnPeriod = new RewardsStateModel(RewardsStateModel::getReturnPeriodId());
		$this->rewardStateWaitingPayment = new RewardsStateModel(RewardsStateModel::getWaitingPaymentId());
		$this->rewardStatePaid = new RewardsStateModel(RewardsStateModel::getPaidId());
	}

	public function install() {
		if (!parent::install() || !$this->_installConf() || !$this->_installDB() || !$this->_installPlugins()
			|| !$this->registerHook('displayHeader') || !$this->registerHook('displayAdminCustomers')
			|| !$this->registerHook('displayCustomerAccount') || !$this->registerHook('displayMyAccountBlock') || !$this->registerHook('displayMyAccountBlockFooter'))
			return false;

		if (!RewardsStateModel::insertDefaultData())
			return false;
		return true;
	}

	private function _installConf() {
		$idEn = Language::getIdByIso('en');
		$desc = array();
		$rewards_payment_txt = array();
		foreach (Language::getLanguages() AS $language) {
			$tmp = $this->l2('Loyalty reward', (int)$language['id_lang']); // $this->l('Loyalty reward')
			$desc[(int)$language['id_lang']] = isset($tmp) && !empty($tmp) ? $tmp : $this->l2('Loyalty reward', $idEn);
			$tmp = $this->l2('rewards_payment_txt', (int)$language['id_lang']);
			$rewards_payment_txt[(int)$language['id_lang']] = isset($tmp) && !empty($tmp) ? $tmp : $this->l2('rewards_payment_txt', $idEn); // $this->l('rewards_payment_txt')
		}

		$groups_config = '';
		$groups = Group::getGroups((int)Configuration::get('PS_LANG_DEFAULT'));
		foreach ($groups AS $group)
			$groups_config .= (int)$group['id_group'].',';
		$groups_config = rtrim($groups_config, ',');

		$category_config = '';
		$categories = Category::getSimpleCategories((int)Configuration::get('PS_LANG_DEFAULT'));
		foreach ($categories AS $category)
			$category_config .= (int)$category['id_category'].',';
		$category_config = rtrim($category_config, ',');

		if (!Configuration::updateValue('REWARDS_VERSION', $this->version)
		|| !Configuration::updateValue('REWARDS_PAYMENT', 0)
		|| !Configuration::updateValue('REWARDS_VOUCHER', 1)
		|| !Configuration::updateValue('REWARDS_VOUCHER_GROUPS', $groups_config)
		|| !Configuration::updateValue('REWARDS_PAYMENT_INVOICE',  1)
		|| !Configuration::updateValue('REWARDS_PAYMENT_RATIO',  100)
		|| !Configuration::updateValue('REWARDS_PAYMENT_TXT', $rewards_payment_txt)
		|| !Configuration::updateValue('REWARDS_MINIMAL', 0)
		|| !Configuration::updateValue('REWARDS_MINIMAL_TAX', 0)
		|| !Configuration::updateValue('REWARDS_MINIMAL_SHIPPING', 0)
		|| !Configuration::updateValue('REWARDS_VOUCHER_DETAILS', $desc)
		|| !Configuration::updateValue('REWARDS_VOUCHER_CATEGORY', $category_config)
		|| !Configuration::updateValue('REWARDS_VOUCHER_CUMUL_S', 0)
		|| !Configuration::updateValue('REWARDS_VOUCHER_PREFIX', 'FID')
		|| !Configuration::updateValue('REWARDS_VOUCHER_DURATION', 365)
		|| !Configuration::updateValue('REWARDS_VOUCHER_BEHAVIOR', 0)
		|| !Configuration::updateValue('REWARDS_DISPLAY_CART', 1)
		|| !Configuration::updateValue('REWARDS_WAIT_RETURN_PERIOD', 1)
		|| !Configuration::updateValue('REWARDS_USE_CRON', 0)
		|| !Configuration::updateValue('REWARDS_CRON_SECURE_KEY', strtoupper(Tools::passwdGen(16)))
		|| !Configuration::updateValue('REWARDS_REMINDER', 0)
		|| !Configuration::updateValue('REWARDS_REMINDER_MINIMUM', 5)
		|| !Configuration::updateValue('REWARDS_REMINDER_FREQUENCY', 30)
		|| !Configuration::updateValue('REWARDS_INITIAL_CONDITIONS', 0)
		|| !Configuration::updateGlobalValue('PS_CART_RULE_FEATURE_ACTIVE', 1))
			return false;

		foreach (Currency::getCurrencies() as $currency) {
			Configuration::updateValue('REWARDS_PAYMENT_MIN_VALUE_'.(int)($currency['id_currency']), 0);
			Configuration::updateValue('REWARDS_VOUCHER_MIN_VALUE_'.(int)($currency['id_currency']), 0);
		}

		return true;
	}

	private function _installDB() {
		Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'rewards` (
			`id_reward` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`id_reward_state` INT UNSIGNED NOT NULL DEFAULT 1,
			`id_customer` INT UNSIGNED NOT NULL,
			`id_order` INT UNSIGNED DEFAULT NULL,
			`id_cart_rule` INT UNSIGNED DEFAULT NULL,
			`id_payment` INT UNSIGNED DEFAULT NULL,
			`credits` DECIMAL(20,2) NOT NULL DEFAULT \'0.00\',
			`plugin` VARCHAR(20) NOT NULL DEFAULT \'loyalty\',
			`reason` VARCHAR(80) DEFAULT NULL,
			`date_add` DATETIME NOT NULL,
			`date_upd` DATETIME NOT NULL,
			PRIMARY KEY (`id_reward`),
			INDEX index_rewards_reward_state (`id_reward_state`),
			INDEX index_rewards_order (`id_order`),
			INDEX index_rewards_cart_rule (`id_cart_rule`),
			INDEX index_rewards_customer (`id_customer`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'rewards_history` (
			`id_reward_history` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`id_reward` INT UNSIGNED DEFAULT NULL,
			`id_reward_state` INT UNSIGNED NOT NULL DEFAULT 1,
			`credits` DECIMAL(20,2) NOT NULL DEFAULT \'0.00\',
			`date_add` DATETIME NOT NULL,
			PRIMARY KEY (`id_reward_history`),
			INDEX `index_rewards_history_reward` (`id_reward`),
			INDEX `index_rewards_history_reward_state` (`id_reward_state`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'rewards_state` (
			`id_reward_state` INT UNSIGNED NOT NULL,
			`id_order_state` TEXT,
			PRIMARY KEY (`id_reward_state`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'rewards_state_lang` (
			`id_reward_state` INT UNSIGNED NOT NULL,
			`id_lang` INT UNSIGNED NOT NULL,
			`name` varchar(64) NOT NULL,
			UNIQUE KEY `index_unique_rewards_state_lang` (`id_reward_state`,`id_lang`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		/* Create table for rewards payments */
		Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'rewards_payment` (
			`id_payment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
			`credits` DECIMAL(20,2) NOT NULL DEFAULT \'0.00\',
			`detail` TEXT,
			`invoice` VARCHAR(100) DEFAULT NULL,
			`paid` TINYINT(1) NOT NULL DEFAULT \'0\',
			`date_add` DATETIME NOT NULL,
			`date_upd` DATETIME NOT NULL,
			PRIMARY KEY (`id_payment`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		/* Create table for rewards account */
		Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'rewards_account` (
			`id_customer` INT UNSIGNED NOT NULL,
			`date_last_remind` DATETIME DEFAULT NULL,
			`date_add` DATETIME NOT NULL,
			`date_upd` DATETIME NOT NULL,
			PRIMARY KEY (`id_customer`)
		) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');
		return true;
	}

	public function uninstall() {
		if (!parent::uninstall() || !$this->_uninstallDB() || !$this->_uninstallPlugins())
			return false;
		// reload configuration cache
		Configuration::loadConfiguration();
		return true;
	}

	private function _uninstallDB() {
		//Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'rewards`;');
		//Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'rewards_state`;');
		//Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'rewards_state_lang`;');
		//Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'rewards_history`;');
		//Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'rewards_payment`;');
		//Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'rewards_account`;');
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'hook` WHERE `name` like \'rewards%\'');

		Db::getInstance()->Execute('
			DELETE FROM `'._DB_PREFIX_.'configuration_lang`
			WHERE `id_configuration` IN (SELECT `id_configuration` from `'._DB_PREFIX_.'configuration` WHERE `name` like \'REWARDS_%\')');

		Db::getInstance()->Execute('
			DELETE FROM `'._DB_PREFIX_.'configuration`
			WHERE `name` like \'REWARDS_%\'');

		return true;
	}

	private function _installPlugins() {
		foreach($this->plugins as $plugin) {
			if (!$plugin->install()) {
				return false;
			}
		}
		return true;
	}

	private function _uninstallPlugins() {
		foreach($this->plugins as $plugin) {
			if (!$plugin->uninstall()) {
				return false;
			}
		}
		return true;
	}

	public function getContent() {
		if (!Configuration::get('REWARDS_INITIAL_CONDITIONS') &&
			($result=$this->_checkRequiredConditions()) !== true) {
				return $result;
		}

		$this->instanceDefaultStates();
		$this->_postProcess();

		$this->context->controller->addCSS($this->getPath() . 'css/jqueryui/flick/jquery-ui-1.8.16.custom.css', 'all');
		$this->context->controller->addCSS($this->getPath() . 'js/multiselect/jquery.multiselect.css', 'all');
		$this->context->controller->addCSS($this->getPath() . 'css/admin.css', 'all');
		$this->context->controller->addJS(_PS_JS_DIR_.'tiny_mce/tiny_mce.js');
		$this->context->controller->addJS(_PS_JS_DIR_.'tinymce.inc.js');
		if (version_compare(_PS_VERSION_, '1.6', '>='))
			$this->context->controller->addJqueryPlugin('ui.tabs.min', _PS_JS_DIR_.'jquery/ui/');
		else
			$this->context->controller->addJS($this->getPath() . 'js/jquery-ui-1.8.16.custom.min.js');
		$this->context->controller->addJS($this->getPath() . 'js/admin.js');
		$this->context->controller->addJS($this->getPath() . 'js/multiselect/jquery.multiselect.js');


		$iso = Language::getIsoById((int)$this->context->language->id);
		$isoTinyMCE = file_exists(_PS_ROOT_DIR_.'/js/tiny_mce/langs/'.$iso.'.js') ? $iso : 'en';
		$defaultLanguage = (int)Configuration::get('PS_LANG_DEFAULT');

		$this->html .= '
		<div class="tabs" style="display: none; margin-bottom: 50px">
			<ul>
				<li><a href="#tabs-news">'.$this->l('About / News').'</a></li>
				<li><a href="#tabs-general">'.$this->l('Rewards account').'</a></li>';
		foreach($this->plugins as $plugin) {
			$this->html .= '
				<li><a href="#tabs-'.$plugin->name.'">'.$plugin->getTitle().'</a></li>';
		}
		$this->html .= '
			</ul>
			<div id="tabs-general">'.$this->_getForm().'</div>';
		foreach($this->plugins as $plugin) {
			$this->html .= '
			<div id="tabs-'.$plugin->name.'">'.$plugin->getContent().'</div>';
		}

		$suffix = ($this->context->language->iso_code == 'fr') ? '_fr' : '_en';
		$this->html .= '
			<div id="tabs-news">
				<fieldset>
					<legend>'.$this->l('Information').'</legend>'.
					$this->l('This module has been created by').' <b>Yann BONNAILLIE - Prestaplugins</b><br>'.
					$this->l('Please report any bug to').' <a href="mailto:contact@prestaplugins.com">contact@prestaplugins.com</a>'.(file_exists(dirname(__FILE__).'/readme'.$suffix.'.pdf') ? '<a style="margin-left: 20px" href="'._MODULE_DIR_.'allinone_rewards/readme'.$suffix.'.pdf"><img src="../img/admin/pdf.gif"></a><a href="'._MODULE_DIR_.'allinone_rewards/readme'.$suffix.'.pdf">'.$this->l('Installation guide').'</a>' : '') . '
				</fieldset>
				<fieldset>
					<legend>'.$this->l('News').'</legend>'.
				$this->_getXmlRss().'
				</fieldset>
			</div>
		</div>
		<script>
			jQuery(function($){'.
				(version_compare(_PS_VERSION_, '1.6', '<') ? '$(".tabs").tabs("select", "tabs-'.Tools::getValue('plugin').'");' : '$("li a[href=\'#tabs-'.Tools::getValue('plugin').'\']").trigger("click");').'
				/* if we were on a subtab, select it again */'.
				(Tools::getValue('tabs-' . Tools::getValue('plugin')) ?
					(version_compare(_PS_VERSION_, '1.6', '<') ? '$(".tabs").tabs("select", "'.Tools::getValue('tabs-' . Tools::getValue('plugin')).'");' : '$("li a[href=\'#'.Tools::getValue('tabs-' . Tools::getValue('plugin')).'\']").trigger("click");') : '').'
				$(".multiselect").multiselect({
					height: "auto",
					checkAllText: "'.$this->l('Check all').'",
					uncheckAllText: "'.$this->l('Uncheck all').'",
					selectedText: "'.$this->l('# value(s) checked').'",
					noneSelectedText: "'.$this->l('Choose the values').'"
				});

				var languages = new Array();
				var id_language = Number('.$defaultLanguage.');';

		foreach (Language::getLanguages() AS $key => $language) {
			$this->html .= '
				languages['.$key.'] = {
					id_lang: '.$language['id_lang'].',
					iso_code: "'.$language['iso_code'].'",
					name: "'.$language['name'].'",
					is_default: '.($language['id_lang'] == $defaultLanguage ? 'true' : 'false').'
				};';
		}
		$this->html .= '
				iso = \''.$isoTinyMCE.'\' ;
				ad = \''.dirname($_SERVER["PHP_SELF"]).'\' ;
				pathCSS = \''._THEME_CSS_DIR_.'\' ;
				tinySetup({
					editor_selector :"autoload_rte"
				});

				displayFlags(languages, id_language, false);
			});
		</script>';

		$this->html = $this->confirmation.$this->errors.$this->html;

		return $this->html;
	}

	private function _postProcess($params = null)	{
		if (Tools::isSubmit('submitInitialConditions') && !Configuration::get('REWARDS_INITIAL_CONDITIONS')) {
			// import existing loyalty
			if (Tools::getValue('loyalty_import'))
				RewardsModel::importFromLoyalty();
			// import existing sponsorship
			if (Tools::getValue('advancedreferralprogram_import'))
				RewardsSponsorshipModel::importFromReferralProgram(true);
			else if (Tools::getValue('referralprogram_import'))
				RewardsSponsorshipModel::importFromReferralProgram();
			// import existing fancoupon
			if (Tools::getValue('fbpromote_import'))
				RewardsFacebookModel::importFromFbpromote();

			// inactive old modules
			$modules = array('loyalty', 'advancedreferralprogram', 'referralprogram', 'fbpromote');
			foreach($modules as $tmpmod) {
				if (Module::isInstalled($tmpmod) && $mod=Module::getInstanceByName($tmpmod))
					$mod->disable();
			}
			Configuration::updateValue('REWARDS_INITIAL_CONDITIONS', 1);
			$this->confirmation = $this->displayConfirmation($this->l('The module has been initialized.'));
		} else if (Tools::isSubmit('submitReward')) {
			$this->_postValidation();
			if (!sizeof($this->_errors)) {
				Configuration::updateValue('REWARDS_USE_CRON', (int)Tools::getValue('rewards_use_cron'));
				Configuration::updateValue('REWARDS_PAYMENT', (int)Tools::getValue('rewards_payment'));
				Configuration::updateValue('REWARDS_PAYMENT_GROUPS', implode(",", (array)Tools::getValue('rewards_payment_groups')));
				Configuration::updateValue('REWARDS_PAYMENT_INVOICE',  (int)Tools::getValue('rewards_payment_invoice'));
				Configuration::updateValue('REWARDS_PAYMENT_RATIO', (float)Tools::getValue('rewards_payment_ratio'));
				Configuration::updateValue('REWARDS_VOUCHER', (int)Tools::getValue('rewards_voucher'));
				Configuration::updateValue('REWARDS_VOUCHER_GROUPS', implode(",", (array)Tools::getValue('rewards_voucher_groups')));
				Configuration::updateValue('REWARDS_VOUCHER_CATEGORY', implode(",", Tools::getValue('voucher_category')));
				Configuration::updateValue('REWARDS_VOUCHER_PREFIX', Tools::getValue('voucher_prefix'));
				Configuration::updateValue('REWARDS_VOUCHER_DURATION', (int)Tools::getValue('voucher_duration'));
				Configuration::updateValue('REWARDS_VOUCHER_BEHAVIOR', (int)Tools::getValue('voucher_behavior'));
				Configuration::updateValue('REWARDS_MINIMAL', (float)Tools::getValue('minimal'));
				Configuration::updateValue('REWARDS_MINIMAL_TAX', Tools::getValue('include_tax'));
				Configuration::updateValue('REWARDS_MINIMAL_SHIPPING', Tools::getValue('include_shipping'));
				Configuration::updateValue('REWARDS_VOUCHER_CUMUL_S', (int)Tools::getValue('cumulative_voucher_s'));
				Configuration::updateValue('REWARDS_DISPLAY_CART', (int)Tools::getValue('display_cart'));
				Configuration::updateValue('REWARDS_WAIT_RETURN_PERIOD', (int)Tools::getValue('wait_order_return'));

				foreach (Tools::getValue('rewards_payment_min_value') as $id_currency => $value)
					Configuration::updateValue('REWARDS_PAYMENT_MIN_VALUE_'.(int)($id_currency), (float)$value);
				foreach (Tools::getValue('rewards_voucher_min_value') as $id_currency => $value)
					Configuration::updateValue('REWARDS_VOUCHER_MIN_VALUE_'.(int)($id_currency), (float)$value);

				$this->rewardStateValidation->id_order_state = implode(",", Tools::getValue('id_order_state_validation'));
				$this->rewardStateCancel->id_order_state = implode(",", Tools::getValue('id_order_state_cancel'));
				$this->rewardStateValidation->save();
				$this->rewardStateCancel->save();

				$arrayVoucherDetails = array();
				$languages = Language::getLanguages();
				foreach ($languages AS $language) {
					$arrayVoucherDetails[(int)($language['id_lang'])] = Tools::getValue('voucher_details_'.(int)($language['id_lang']));
				}
				Configuration::updateValue('REWARDS_VOUCHER_DETAILS', $arrayVoucherDetails);
				$this->confirmation = $this->displayConfirmation($this->l('Settings updated.'));
			} else
				$this->errors = $this->displayError(implode('<br />', $this->_errors));
		} else if (Tools::isSubmit('submitRewardsNotifications')) {
			$this->_postValidation();
			if (!sizeof($this->_errors)) {
				Configuration::updateValue('REWARDS_REMINDER', (int)Tools::getValue('rewards_reminder'));
				Configuration::updateValue('REWARDS_REMINDER_MINIMUM', (float)Tools::getValue('rewards_reminder_minimum'));
				Configuration::updateValue('REWARDS_REMINDER_FREQUENCY', (int)Tools::getValue('rewards_reminder_frequency'));
				$this->confirmation = $this->displayConfirmation($this->l('Settings updated.'));
			} else
				$this->errors = $this->displayError(implode('<br />', $this->_errors));
		} else if (Tools::isSubmit('submitRewardText')) {
			$this->_postValidation();
			if (!sizeof($this->_errors)) {
				foreach (Language::getLanguages() AS $language) {
					$this->rewardStateDefault->name[(int)($language['id_lang'])] = Tools::getValue('default_reward_state_'.(int)($language['id_lang']));
					$this->rewardStateValidation->name[(int)($language['id_lang'])] = Tools::getValue('validation_reward_state_'.(int)($language['id_lang']));
					$this->rewardStateCancel->name[(int)($language['id_lang'])] = Tools::getValue('cancel_reward_state_'.(int)($language['id_lang']));
					$this->rewardStateConvert->name[(int)($language['id_lang'])] = Tools::getValue('convert_reward_state_'.(int)($language['id_lang']));
					$this->rewardStateDiscounted->name[(int)($language['id_lang'])] = Tools::getValue('discounted_reward_state_'.(int)($language['id_lang']));
					$this->rewardStateReturnPeriod->name[(int)($language['id_lang'])] = Tools::getValue('return_period_reward_state_'.(int)($language['id_lang']));
					$this->rewardStateWaitingPayment->name[(int)($language['id_lang'])] = Tools::getValue('waiting_payment_reward_state_'.(int)($language['id_lang']));
					$this->rewardStatePaid->name[(int)($language['id_lang'])] = Tools::getValue('paid_reward_state_'.(int)($language['id_lang']));
				}
				Configuration::updateValue('REWARDS_GENERAL_TXT', Tools::getValue('rewards_general_txt'), true);
				Configuration::updateValue('REWARDS_PAYMENT_TXT', Tools::getValue('rewards_payment_txt'), true);
				if (version_compare(_PS_VERSION_, '1.5.2', '<'))
					Configuration::set('REWARDS_PAYMENT_TXT', Tools::getValue('rewards_payment_txt'));
				$this->rewardStateDefault->save();
				$this->rewardStateValidation->save();
				$this->rewardStateCancel->save();
				$this->rewardStateConvert->save();
				$this->rewardStateDiscounted->save();
				$this->rewardStateReturnPeriod->save();
				$this->rewardStateWaitingPayment->save();
				$this->rewardStatePaid->save();
				$this->confirmation = $this->displayConfirmation($this->l('Settings updated.'));
			} else
				$this->errors = $this->displayError(implode('<br />', $this->_errors));
		} else if (Tools::getValue('accept_payment')) {
			RewardsPaymentModel::acceptPayment((int)Tools::getValue('accept_payment'));
		} else if (Tools::isSubmit('submitRewardReminder')) {
			RewardsAccountModel::sendReminder((int)$params['id_customer']);
		} else if (Tools::isSubmit('submitRewardUpdate')) {
			// manage rewards update
			$this->_postValidation();
			if (!sizeof($this->_errors)) {
				$reward = new RewardsModel((int)Tools::getValue('id_reward_to_update'));
				$reward->id_reward_state = (int)Tools::getValue('reward_state_' . Tools::getValue('id_reward_to_update'));
				$reward->credits = (float)Tools::getValue('reward_value_' . Tools::getValue('id_reward_to_update'));
				if ($reward->plugin=="free")
					$reward->reason = Tools::getValue('reward_reason_' . Tools::getValue('id_reward_to_update'));
				$reward->save();
				return $this->displayConfirmation($this->l('The reward has been updated.'));
			} else
				return $this->displayError(implode('<br />', $this->_errors));
		} else if (Tools::isSubmit('submitNewReward')) {
			$this->_postValidation();
			if (!sizeof($this->_errors)) {
				$reward = new RewardsModel();
				$reward->id_reward_state = (int)Tools::getValue('new_reward_state');
				$reward->id_customer = (int)$params['id_customer'];
				$reward->credits = (float)Tools::getValue('new_reward_value');
				$reward->plugin = 'free';
				$reward->reason = Tools::getValue('new_reward_reason');
				$reward->save();
				$_POST['new_reward_value'] = $_POST['new_reward_reason'] = $_POST['new_reward_state'] = null;
				return $this->displayConfirmation($this->l('The new reward has been created.'));
			} else
				return $this->displayError(implode('<br />', $this->_errors));
		}
	}

	private function _postValidation() {
		$languages = Language::getLanguages();
		if (Tools::isSubmit('submitReward')) {
			$currencies = Currency::getCurrencies();
			foreach ($currencies as $value) {
				$currency[$value['id_currency']] = htmlentities($value['name'], ENT_NOQUOTES, 'utf-8');
			}

			$states_valid = Tools::getValue('id_order_state_validation');
			$states_cancel = Tools::getValue('id_order_state_cancel');
			Tools::getValue('id_order_state_cancel');
			if (!is_array($states_valid) || !sizeof($states_valid))
				$this->_errors[] = $this->l('You must choose the states when reward is awarded');
			if (!is_array($states_cancel) || !sizeof($states_cancel))
				$this->_errors[] = $this->l('You must choose the states when reward is cancelled');
			if (is_array($states_valid) && is_array($states_cancel) && count(array_intersect($states_valid, $states_cancel)) > 0)
				$this->_errors[] = $this->l('You can\'t choose the same state(s) for validation and cancellation');
			if (!Tools::getValue('rewards_payment') && !Tools::getValue('rewards_voucher'))
				$this->_errors[] = $this->l('You have to enable payment or/and transformation into vouchers');
			if (Tools::getValue('rewards_payment') && !is_array(Tools::getValue('rewards_payment_groups')))
				$this->_errors[] = $this->l('Please select at least 1 customer group allowed to ask for payment');
			if (Tools::getValue('rewards_voucher') && !is_array(Tools::getValue('rewards_voucher_groups')))
				$this->_errors[] = $this->l('Please select at least 1 customer group allowed to transform rewards into vouchers');
			if (!Tools::getValue('rewards_payment_ratio') || !Validate::isUnsignedFloat(Tools::getValue('rewards_payment_ratio')) || (float)Tools::getValue('rewards_payment_ratio') > 100 || (float)Tools::getValue('rewards_payment_ratio') < 1)
				$this->_errors[] = $this->l('The convertion rate must be a number between 1 and 100');
			foreach (Tools::getValue('rewards_payment_min_value') as $id_currency => $value)
				if (!empty($value) && !Validate::isUnsignedFloat($value))
					$this->_errors[] = $this->l('Minimum required in account for payment and the currency').' '.$currency[$id_currency].' '.$this->l('is invalid.');
			foreach (Tools::getValue('rewards_voucher_min_value') as $id_currency => $value)
				if (!empty($value) && !Validate::isUnsignedFloat($value))
					$this->_errors[] = $this->l('Minimum required in account for transformation and the currency').' '.$currency[$id_currency].' '.$this->l('is invalid.');
			foreach ($languages as $language) {
				if (Tools::getValue('voucher_details_'.(int)($language['id_lang'])) == '')
					$this->_errors[] = $this->l('Voucher description is required for').' '.$language['name'];
			}
			if (Tools::getValue('voucher_prefix') == '' || !Validate::isDiscountName(Tools::getValue('voucher_prefix')))
				$this->_errors[] = $this->l('Prefix for the voucher code is required/invalid.');
			if (!is_numeric(Tools::getValue('voucher_duration')) || Tools::getValue('voucher_duration') <= 0)
				$this->_errors[] = $this->l('The validity of the voucher is required/invalid.');
			if (!is_numeric(Tools::getValue('minimal')) || Tools::getValue('minimal') < 0)
				$this->_errors[] = $this->l('The minimum value is required/invalid.');
			if (!is_array(Tools::getValue('voucher_category')) || !sizeof(Tools::getValue('voucher_category')))
				$this->_errors[] = $this->l('You must choose at least one category for voucher\'s action');
		} else if (Tools::isSubmit('submitRewardsNotifications') && (int)Tools::getValue('rewards_reminder') == 1) {
			if (Tools::getValue('rewards_reminder_minimum') && !Validate::isUnsignedFloat(Tools::getValue('rewards_reminder_minimum')))
				$this->_errors[] = $this->l('Minimum required in account to receive a mail is required/invalid.');
			if (!is_numeric(Tools::getValue('rewards_reminder_frequency')) || Tools::getValue('rewards_reminder_frequency') <= 0)
				$this->_errors[] = $this->l('The frequency of the emails is required/invalid.');
		} else if (Tools::isSubmit('submitRewardText')) {
			foreach ($languages as $language) {
				if (Tools::getValue('default_reward_state_'.(int)($language['id_lang'])) == '')
					$this->_errors[] = $this->l('Label is required for Initial state in').' '.$language['name'];
				if (Tools::getValue('validation_reward_state_'.(int)($language['id_lang'])) == '')
					$this->_errors[] = $this->l('Label is required for validation state in').' '.$language['name'];
				if (Tools::getValue('cancel_reward_state_'.(int)($language['id_lang'])) == '')
					$this->_errors[] = $this->l('Label is required for cancellation state in').' '.$language['name'];
				if (Tools::getValue('convert_reward_state_'.(int)($language['id_lang'])) == '')
					$this->_errors[] = $this->l('Label is required for converted state in').' '.$language['name'];
				if (Tools::getValue('discounted_reward_state_'.(int)($language['id_lang'])) == '')
					$this->_errors[] = $this->l('Label is required for unavailable state in').' '.$language['name'];
				if (Tools::getValue('return_period_reward_state_'.(int)($language['id_lang'])) == '')
					$this->_errors[] = $this->l('Label is required for Return period not exceeded state in').' '.$language['name'];
			}
		} else if (Tools::isSubmit('submitRewardUpdate') && (int)Tools::getValue('id_reward_to_update') != 0) {
			 if (!Validate::isUnsignedFloat(Tools::getValue('reward_value_' . Tools::getValue('id_reward_to_update'))) || (float)Tools::getValue('reward_value_' . Tools::getValue('id_reward_to_update')) == 0)
			 	$this->_errors[] = $this->l('The value of the reward is required/invalid.');
			 if (isset($_POST['reward_reason_' . Tools::getValue('id_reward_to_update')]) && Tools::getValue('reward_reason_' . Tools::getValue('id_reward_to_update')) == '')
			 	$this->_errors[] = $this->l('The reason of the reward is required/invalid.');
		} else if (Tools::isSubmit('submitNewReward')) {
			 if (!Validate::isUnsignedFloat(Tools::getValue('new_reward_value')) || (float)Tools::getValue('new_reward_value') == 0)
			 	$this->_errors[] = $this->l('The value of the reward is required/invalid.');
			 if (Tools::getValue('new_reward_reason') == '')
			 	$this->_errors[] = $this->l('The reason of the reward is required/invalid.');
		}
	}


	private function _checkRequiredConditions() {
		if (Tools::isSubmit('submitInitialConditions')) {
			$this->_postProcess();
			return true;
		}

		// Are rewards, sponsorships or facebook empty in database ?
		// Could contains datas, if not removed by the uninstall action
		// If not empty, skip that step.
		if (RewardsModel::isNotEmpty() || RewardsSponsorshipModel::isNotEmpty() || RewardsFacebookModel::isNotEmpty())
			return true;

		// Loyalty installed ?
		$bContinue = false;
		$nbLoyalty = 0;
		$bLoyalty = false;
		if (Module::isInstalled('loyalty')) {
			$loyalty = Module::getInstanceByName('loyalty');
			$bLoyalty = (bool)$loyalty->active;
			if ((float)Configuration::get('PS_LOYALTY_POINT_VALUE') > 0)
				$nbLoyalty = Db::getInstance()->getValue('SELECT count(*) AS nb FROM `'._DB_PREFIX_.'loyalty`');
			if ($bLoyalty || $nbLoyalty > 0)
				$bContinue = true;
		}
		// Advancedreferralprogram or referralprogram installed ?
		$nbAdvancedReferralProgram = 0;
		$nbReferralProgram = 0;
		$bAdvancedReferralProgram = false;
		$bReferralProgram = false;
		if (Module::isInstalled('advancedreferralprogram')) {
			$referralprogram = Module::getInstanceByName('advancedreferralprogram');
			$bAdvancedReferralProgram = (bool)$referralprogram->active;
			$nbAdvancedReferralProgram = Db::getInstance()->getValue('SELECT count(*) AS nb FROM `'._DB_PREFIX_.'advreferralprogram`');
			if ($bAdvancedReferralProgram || $nbAdvancedReferralProgram > 0)
				$bContinue = true;
		} else if (Module::isInstalled('referralprogram')) {
			$referralprogram = Module::getInstanceByName('referralprogram');
			$bReferralProgram = (bool)$referralprogram->active;
			$nbReferralProgram = Db::getInstance()->getValue('SELECT count(*) AS nb FROM `'._DB_PREFIX_.'referralprogram`');
			if ($bReferralProgram || $nbReferralProgram > 0)
				$bContinue = true;
		}
		// Fbpromote installed ?
		$nbFbpromote = 0;
		$bFbpromote = false;
		if (Module::isInstalled('fbpromote')) {
			$fbpromote = Module::getInstanceByName('fbpromote');
			$bFbpromote = (bool)$fbpromote->active;
			$nbFbpromote = Db::getInstance()->getValue('SELECT count(*) AS nb FROM `'._DB_PREFIX_.'fb_promote`');
			if ($bFbpromote || $nbFbpromote > 0)
				$bContinue = true;
		}
		if (!$bContinue)
			return true;

		$this->html .= '
		<form style="margin-bottom: 50px" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset>
				<legend>'.$this->l('Initial conditions').'</legend>
				<div align="center" style="color: red; font-weight: bold; padding-bottom: 10px">'.$this->l('Since this is the first time you install this module, it must be initialized.').'</div>'.
				((int) $nbLoyalty > 0 && (float)Configuration::get('PS_LOYALTY_POINT_VALUE') > 0 ?
					'<div class="clear" style="padding-top: 10px"></div>
					<label>'.$this->l('Import the existing accounts from').' "'.$loyalty->displayName.'" </label>
					<div class="margin-form">
						<label class="t" for="loyalty_import_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
						<input type="radio" id="loyalty_import_on" name="loyalty_import" value="1" checked /> <label class="t" for="loyalty_import_on">' . $this->l('Yes') . '</label>
						<label class="t" for="loyalty_import_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
						<input type="radio" id="loyalty_import_off" name="loyalty_import" value="0" /> <label class="t" for="loyalty_import_off">' . $this->l('No') . '</label>
					</div>' : '').
				($bLoyalty === true ? '<div class="clear" style="font-weight: bold; font-style: italic; padding-bottom: 10px">'.$this->l('The module').' "'.$loyalty->displayName.'" '.$this->l('is actually active, it will be disabled automatically').'</div>' : '').
				((int) $nbAdvancedReferralProgram > 0 ?
					'<div class="clear" style="padding-top: 10px"></div>
					<label>'.$this->l('Import the existing sponsorships from').' "'.$referralprogram->displayName.'" </label>
					<div class="margin-form">
						<label class="t" for="advancedreferralprogram_import_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
						<input type="radio" id="advancedreferralprogram_import_on" name="advancedreferralprogram_import" value="1" checked /> <label class="t" for="advancedreferralprogram_import_on">' . $this->l('Yes') . '</label>
						<label class="t" for="advancedreferralprogram_import_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
						<input type="radio" id="advancedreferralprogram_import_off" name="advancedreferralprogram_import" value="0" /> <label class="t" for="advancedreferralprogram_import_off">' . $this->l('No') . '</label>
					</div>' : '').
				($bAdvancedReferralProgram === true ? '<div class="clear" style="font-weight: bold; font-style: italic; padding-bottom: 10px">'.$this->l('The module').' "'.$referralprogram->displayName.'" '.$this->l('is actually active, it will be disabled automatically').'</div>' : '').
				((int) $nbReferralProgram > 0 ?
					'<div class="clear" style="padding-top: 10px"></div>
					<label>'.$this->l('Import the existing sponsorships from').' "'.$referralprogram->displayName.'" </label>
					<div class="margin-form">
						<label class="t" for="referralprogram_import_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
						<input type="radio" id="referralprogram_import_on" name="referralprogram_import" value="1" checked /> <label class="t" for="referralprogram_import_on">' . $this->l('Yes') . '</label>
						<label class="t" for="referralprogram_import_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
						<input type="radio" id="referralprogram_import_off" name="referralprogram_import" value="0" /> <label class="t" for="referralprogram_import_off">' . $this->l('No') . '</label>
					</div>' : '').
				($bReferralProgram === true ? '<div class="clear" style="font-weight: bold; font-style: italic">'.$this->l('The module').' "'.$referralprogram->displayName.'" '.$this->l('is actually active, it will be disabled automatically').'</div>' : '').
				((int) $nbFbpromote > 0 ?
					'<div class="clear" style="padding-top: 10px"></div>
					<label>'.$this->l('Import the existing Facebook "Like" from').' "'.$fbpromote->displayName.'" </label>
					<div class="margin-form">
						<label class="t" for="fbpromote_import_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
						<input type="radio" id="fbpromote_import_on" name="fbpromote_import" value="1" checked /> <label class="t" for="fbpromote_import_on">' . $this->l('Yes') . '</label>
						<label class="t" for="fbpromote_import_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
						<input type="radio" id="fbpromote_import_off" name="fbpromote_import" value="0" /> <label class="t" for="fbpromote_import_off">' . $this->l('No') . '</label>
					</div>' : '').
				($bFbpromote === true ? '<div class="clear" style="font-weight: bold; font-style: italic; padding-bottom: 10px">'.$this->l('The module').' "'.$fbpromote->displayName.'" '.$this->l('is actually active, it will be disabled automatically').'</div>' : '').'
			</fieldset>
			<div class="clear center"><input type="submit" name="submitInitialConditions" id="submitInitialConditions" value="'.$this->l('   Initialize the module   ').'" class="button" /></div>
		</form>';

		return $this->html;
	}

	public function getCategories() {
		if (!$this->_categories)
			$this->_categories = Category::getCategories((int)$this->context->language->id, false);
		return $this->_categories;
	}

	private function _getForm()	{
		$categories = $this->getCategories();
		$order_states = OrderState::getOrderStates((int)$this->context->language->id);
		$groups = Group::getGroups($this->context->language->id);
		$rewards_voucher_groups = explode(',', Configuration::get('REWARDS_VOUCHER_GROUPS'));
		$rewards_payment_groups = explode(',', Configuration::get('REWARDS_PAYMENT_GROUPS'));

		$currencies = Currency::getCurrencies();
		$defaultLanguage = (int)Configuration::get('PS_LANG_DEFAULT');
		$languages = Language::getLanguages();

		$html = '
		<div class="tabs" style="display: none">
			<ul>
				<li><a href="#tabs-general-1">'.$this->l('Settings').'</a></li>
				<li><a href="#tabs-general-2">'.$this->l('Notifications').'</a></li>
				<li><a href="#tabs-general-3">'.$this->l('Texts').'</a></li>
			</ul>
			<div id="tabs-general-1">
				<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">
					<input type="hidden" name="plugin" id="plugin" value="general" />
					<input type="hidden" name="tabs-general" value="tabs-general-1" />
					<fieldset>
						<label class="t" style="width: 100% !important"><strong>'.$this->l('Settings for rewards obtained through a command').'</strong></label>
						<div class="clear" style="padding-top: 5px"></div>
						<label class="indent">'.$this->l('Reward is awarded when the order is').'</label>
						<div class="margin-form">
							<select name="id_order_state_validation[]" multiple="multiple" class="multiselect">';
		foreach ($order_states AS $order_state)	{
			$html .= '			<option '.(is_array($this->rewardStateValidation->getValues()) && in_array($order_state['id_order_state'], $this->rewardStateValidation->getValues()) ? 'selected':'').' value="' . $order_state['id_order_state'] . '" style="background-color:' . $order_state['color'] . '"> '.$order_state['name'].'</option>';
		}
		$html .= '
							</select>
						</div>
						<div class="clear"></div>
						<label class="indent">'.$this->l('Reward is cancelled when the order is').'</label>
						<div class="margin-form">
							<select name="id_order_state_cancel[]" multiple="multiple" class="multiselect">';
		foreach ($order_states AS $order_state)	{
			$html .= '			<option '.(is_array($this->rewardStateCancel->getValues()) && in_array($order_state['id_order_state'], $this->rewardStateCancel->getValues()) ? 'selected':'').' value="' . $order_state['id_order_state'] . '" style="background-color:' . $order_state['color'] . '"> '.$order_state['name'].'</option>';
		}
		$html .= '
							</select>
						</div>
						<div class="clear"></div>
						<label class="indent">'.$this->l('Transformation is allowed only when return period is exceeded').'</label>&nbsp;
						<div class="margin-form">
							<label class="t" for="wait_order_return_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="wait_order_return_on" name="wait_order_return" value="1" '.(Tools::getValue('wait_return_period', Configuration::get('REWARDS_WAIT_RETURN_PERIOD')) ? 'checked="checked"' : '').' /> <label class="t" for="wait_order_return_on">' . $this->l('Yes') . '</label>
							<label class="t" for="wait_order_return_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="wait_order_return_off" name="wait_order_return" value="0" '.(!Tools::getValue('wait_return_period', Configuration::get('REWARDS_WAIT_RETURN_PERIOD')) ? 'checked="checked"' : '').' /> <label class="t" for="wait_order_return_off">' . $this->l('No') . '</label>
							- '.(Configuration::get('PS_ORDER_RETURN')==1 ? $this->l('Order return period = ') . ' ' . Configuration::get('PS_ORDER_RETURN_NB_DAYS') . ' ' . $this->l('days') : $this->l('Actually, order return is not allowed')).'
						</div>
						<div class="clear"></div>
						<label class="t" style="width: 100% !important; padding-top: 10px; display: block"><strong>'.$this->l('Payment settings').'</strong></label>
						<div class="clear" style="padding-top: 5px"></div>
						<label class="indent">'.$this->l('Allow customers to ask for payment (cash)').'</label>
						<div class="margin-form">
							<label class="t" for="rewards_payment_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="rewards_payment_on" name="rewards_payment" value="1" '.(Tools::getValue('rewards_payment', Configuration::get('REWARDS_PAYMENT')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_payment_on">' . $this->l('Yes') . '</label>
							<label class="t" for="rewards_payment_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="rewards_payment_off" name="rewards_payment" value="0" '.(Tools::getValue('rewards_payment', Configuration::get('REWARDS_PAYMENT')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_payment_off">' . $this->l('No') . '</label>
						</div>
						<div class="clear"></div>
						<label class="indent">'.$this->l('Allow customers to transform rewards into vouchers').'</label>
						<div class="margin-form">
							<label class="t" for="rewards_voucher_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="rewards_voucher_on" name="rewards_voucher" value="1" '.(Tools::getValue('rewards_voucher', Configuration::get('REWARDS_VOUCHER')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_voucher_on">' . $this->l('Yes') . '</label>
							<label class="t" for="rewards_voucher_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="rewards_voucher_off" name="rewards_voucher" value="0" '.(Tools::getValue('rewards_voucher', Configuration::get('REWARDS_VOUCHER')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_voucher_off">' . $this->l('No') . '</label>
						</div>
						<div class="clear"></div>
						<label class="t" style="width: 100% !important; padding-top: 10px; display: block"><strong>'.$this->l('Settings for automatic actions').'</strong></label>
						<div class="clear" style="padding-top: 5px"></div>
						<label class="indent">'.$this->l('How do you want to execute automatic actions (unlock rewards, send reminders)').'</label>
						<div class="margin-form">
							<label class="t" for="rewards_use_cron_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="rewards_use_cron_on" name="rewards_use_cron" value="1" '.(Tools::getValue('rewards_use_cron', Configuration::get('REWARDS_USE_CRON')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_use_cron_on">' . $this->l('Crontab') . '</label>
							<label class="t" for="rewards_use_cron_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="rewards_use_cron_off" name="rewards_use_cron" value="0" '.(Tools::getValue('rewards_use_cron', Configuration::get('REWARDS_USE_CRON')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_use_cron_off">' . $this->l('I don\'t know') . '</label> - ' . $this->l('will be called on every page load') . '
						</div>
						<div class="clear optional rewards_use_cron_optional">
							<div class="margin-form" style="width: 95% !important; padding-left: 30px">'.$this->l('Place this URL in crontab or call it manually daily :').' '.Tools::getShopDomain(true, true).__PS_BASE_URI__.'modules/allinone_rewards/cron.php?secure_key='.Configuration::get('REWARDS_CRON_SECURE_KEY').'</div>
						</div>
					</fieldset>
					<fieldset id="rewards_payment" class="rewards_payment_optional">
						<legend>'.$this->l('Settings applied for the rewards payment').'</legend>
						<label>'.$this->l('Customers groups allowed to ask for payment').'</label>
						<div class="margin-form">
							<select name="rewards_payment_groups[]" multiple="multiple" class="multiselect">';
		foreach($groups as $group) {
			$html .= '			<option '.(is_array($rewards_payment_groups) && in_array($group['id_group'], $rewards_payment_groups) ? 'selected':'').' value="'.$group['id_group'].'"> '.$group['name'].'</option>';
		}
		$html .= '
							</select>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('An invoice must be uploaded to ask for payment').'</label>
						<div class="margin-form">
							<label class="t" for="rewards_payment_invoice_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="rewards_payment_invoice_on" name="rewards_payment_invoice" value="1" '.(Tools::getValue('rewards_payment_invoice', Configuration::get('REWARDS_PAYMENT_INVOICE')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_payment_invoice_on">' . $this->l('Yes') . '</label>
							<label class="t" for="rewards_payment_invoice_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="rewards_payment_invoice_off" name="rewards_payment_invoice" value="0" '.(Tools::getValue('rewards_payment_invoice', Configuration::get('REWARDS_PAYMENT_INVOICE')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_payment_invoice_off">' . $this->l('No') . '</label>
						</div>
						<div class="clear"></div>
						<div>
							<table>
								<tr>
									<td class="label">' . $this->l('Currency used by the member') . '</td>
									<td align="left">' . $this->l('Minimum required in account to be able to ask for payment') . '</td>
								</tr>';
		foreach ($currencies as $currency) {
			$html .= '
								<tr>
									<td><label class="indent">' . htmlentities($currency['name'], ENT_NOQUOTES, 'utf-8') . '</label></td>
									<td align="left"><input '. ((int)$currency['id_currency'] == (int)Configuration::get('PS_CURRENCY_DEFAULT') ? 'class="currency_default"' : '') . ' type="text" size="8" maxlength="8" name="rewards_payment_min_value['.(int)($currency['id_currency']).']" id="rewards_payment_min_value['.(int)($currency['id_currency']).']" value="'.Tools::getValue('rewards_payment_min_value['.(int)($currency['id_currency']).']', Configuration::get('REWARDS_PAYMENT_MIN_VALUE_'.(int)($currency['id_currency']))).'" /> <label class="t">'.$currency['sign'].'</label>'.((int)$currency['id_currency'] != (int)Configuration::get('PS_CURRENCY_DEFAULT') ? ' <a href="#" onClick="return convertCurrencyValue(this, \'rewards_payment_min_value\', '.$currency['conversion_rate'].')"><img src="'._MODULE_DIR_.'allinone_rewards/images/convert.gif" style="vertical-align: middle !important"></a>' : '').'</td>
								</tr>';
		}
		$html .= '
							</table>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Convertion rate').'<br/><small>'.$this->l('Example: for 100€ in reward account, if ratio is 75 then the customer will get only 75€ payment').'</small></label>
						<div class="margin-form">
							<input type="text" size="4" maxlength="4" id="rewards_payment_ratio" name="rewards_payment_ratio" value="'.Tools::getValue('rewards_payment_ratio', Configuration::get('REWARDS_PAYMENT_RATIO')).'" />
						</div>
					</fieldset>
					<fieldset id="rewards_voucher" class="rewards_voucher_optional">
						<legend>'.$this->l('Settings applied when transforming rewards into vouchers').'</legend>
						<label>'.$this->l('Customers groups allowed to transform rewards into vouchers').'</label>
						<div class="margin-form">
							<select name="rewards_voucher_groups[]" multiple="multiple" class="multiselect">';
		foreach($groups as $group) {
			$html .= '			<option '.(is_array($rewards_voucher_groups) && in_array($group['id_group'], $rewards_voucher_groups) ? 'selected':'').' value="'.$group['id_group'].'"> '.$group['name'].'</option>';
		}
		$html .= '
							</select>
						</div>
						<div class="clear"></div>
						<div style="padding-bottom: 5px">
							<table>
								<tr>
									<td class="label">' . $this->l('Currency used by the member') . '</td>
									<td align="left">' . $this->l('Minimum required in account to be able to transform rewards into vouchers') . '</td>
								</tr>';
		foreach ($currencies as $currency) {
			$html .= '
								<tr>
									<td><label class="indent">' . htmlentities($currency['name'], ENT_NOQUOTES, 'utf-8') . '</label></td>
									<td align="left"><input '. ((int)$currency['id_currency'] == (int)Configuration::get('PS_CURRENCY_DEFAULT') ? 'class="currency_default"' : '') . ' type="text" size="8" maxlength="8" name="rewards_voucher_min_value['.(int)($currency['id_currency']).']" id="rewards_voucher_min_value['.(int)($currency['id_currency']).']" value="'.Tools::getValue('rewards_voucher_min_value['.(int)($currency['id_currency']).']', Configuration::get('REWARDS_VOUCHER_MIN_VALUE_'.(int)($currency['id_currency']))).'" /> <label class="t">'.$currency['sign'].'</label>'.((int)$currency['id_currency'] != (int)Configuration::get('PS_CURRENCY_DEFAULT') ? ' <a href="#" onClick="return convertCurrencyValue(this, \'rewards_voucher_min_value\', '.$currency['conversion_rate'].')"><img src="'._MODULE_DIR_.'allinone_rewards/images/convert.gif" style="vertical-align: middle !important"></a>' : '').'</td>
								</tr>';
		}
		$html .= '
							</table>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Voucher details (will appear in cart next to voucher code)').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="voucher_details_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="voucher_details_'.$language['id_lang'].'" value="'.htmlentities(Tools::getValue('voucher_details_'.$language['id_lang'], Configuration::get('REWARDS_VOUCHER_DETAILS', (int)$language['id_lang'])), ENT_QUOTES, 'utf-8').'" />
							</div>';
		$html .= '
						</div>
						<div class="clear" style="margin-top: 20px"></div>
						<label>'.$this->l('Prefix for the voucher code (at least 3 letters long)').'</label>
						<div class="margin-form">
							<input type="text" size="10" maxlength="10" id="voucher_prefix" name="voucher_prefix" value="'.Tools::getValue('voucher_prefix', Configuration::get('REWARDS_VOUCHER_PREFIX')).'" />
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Validity of the voucher (in days)').'</label>
						<div class="margin-form">
							<input type="text" size="4" maxlength="4" id="voucher_duration" name="voucher_duration" value="'.Tools::getValue('voucher_duration', Configuration::get('REWARDS_VOUCHER_DURATION')).'" />
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Display vouchers in the cart summary').'</label>&nbsp;
						<div class="margin-form">
							<label class="t" for="display_cart_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="display_cart_on" name="display_cart" value="1" '.(Tools::getValue('display_cart', Configuration::get('REWARDS_DISPLAY_CART')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="display_cart_on">' . $this->l('Yes') . '</label>
							<label class="t" for="display_cart_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="display_cart_off" name="display_cart" value="0" '.(Tools::getValue('display_cart', Configuration::get('REWARDS_DISPLAY_CART')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="display_cart_off">' . $this->l('No') . '</label>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Cumulative with other vouchers').'</label>
						<div class="margin-form">
							<label class="t" for="cumulative_voucher_s_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="cumulative_voucher_s_on" name="cumulative_voucher_s" value="1" '.(Tools::getValue('cumulative_voucher_s', Configuration::get('REWARDS_VOUCHER_CUMUL_S')) ? 'checked="checked"' : '').' /> <label class="t" for="cumulative_voucher_s_on">' . $this->l('Yes') . '</label>
							<label class="t" for="cumulative_voucher_s_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="cumulative_voucher_s_off" name="cumulative_voucher_s" value="0" '.(!Tools::getValue('cumulative_voucher_s', Configuration::get('REWARDS_VOUCHER_CUMUL_S')) ? 'checked="checked"' : '').' /> <label class="t" for="cumulative_voucher_s_off">' . $this->l('No') . '</label>
						</div>
						<div class="clear" style="margin-top: 20px"></div>
						<label>'.$this->l('Minimum amount in which the voucher can be used').'</label>
						<div class="margin-form">
							<input type="text" size="2" name="minimal" value="'.Tools::getValue('minimal', (float)Configuration::get('REWARDS_MINIMAL')).'" /> '.$this->context->currency->sign.'&nbsp;
							<select name="include_tax">
								<option '.(!Tools::getValue('include_tax', Configuration::get('REWARDS_MINIMAL_TAX'))?'selected':'').' value="0">'.$this->l('VAT Excl.').'</option>
								<option '.(Tools::getValue('include_tax', Configuration::get('REWARDS_MINIMAL_TAX'))?'selected':'').' value="1">'.$this->l('VAT Incl.').'</option>
							</select>
							<select name="include_shipping">
								<option '.(!Tools::getValue('include_shipping', Configuration::get('REWARDS_MINIMAL_SHIPPING'))?'selected':'').' value="0">'.$this->l('Shipping Excluded').'</option>
								<option '.(Tools::getValue('include_shipping', Configuration::get('REWARDS_MINIMAL_SHIPPING'))?'selected':'').' value="1">'.$this->l('Shipping Included').'</option>
							</select>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('If the voucher is not depleted when used').'</label>&nbsp;
						<div class="margin-form">
							<select name="voucher_behavior">
								<option '.(!Tools::getValue('voucher_behavior', (int)Configuration::get('REWARDS_VOUCHER_BEHAVIOR')) ?'selected':'').' value="0">'.$this->l('Cancel the remaining amount').'</option>
								<option '.(Tools::getValue('voucher_behavior', (int)Configuration::get('REWARDS_VOUCHER_BEHAVIOR')) ?'selected':'').' value="1">'.$this->l('Create a new voucher with remaining amount').'</option>
							</select>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Vouchers can be used in the following categories :').'</label>
						<div class="margin-form">
							<table cellspacing="0" cellpadding="0" class="table">
								<tr>
									<th><input type="checkbox" name="checkme" class="noborder" onclick="checkDelBoxes(this.form, \'voucher_category[]\', this.checked)" /></th>
									<th>'.$this->l('ID').'</th>
									<th style="width: 400px">'.$this->l('Name').'</th>
								</tr>';
		$index =  isset($_POST['voucher_category']) ? $_POST['voucher_category'] : explode(',', Configuration::get('REWARDS_VOUCHER_CATEGORY'));
		$current = current(current($categories));
		$html .= $this->recurseCategoryForInclude('voucher_category', $index, $categories, $current, $current['infos']['id_category']);
		$html .= '
							</table>
						</div>
					</fieldset>
					<div class="clear center"><input type="submit" name="submitReward" id="submitReward" value="'.$this->l('Save settings').'" class="button" /></div>
				</form>
			</div>
			<div id="tabs-general-2">
				<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
				<input type="hidden" name="plugin" id="plugin" value="general" />
				<input type="hidden" name="tabs-general" value="tabs-general-2" />
				<fieldset>
					<legend>'.$this->l('Notifications').'</legend>
					<label>'.$this->l('Send a periodic email to the customer with his rewards account balance').'</label>
					<div class="margin-form">
						<label class="t" for="rewards_reminder_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
						<input type="radio" id="rewards_reminder_on" name="rewards_reminder" value="1" '.(Tools::getValue('rewards_reminder', Configuration::get('REWARDS_REMINDER')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_reminder_on">' . $this->l('Yes') . '</label>
						<label class="t" for="rewards_reminder_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
						<input type="radio" id="rewards_reminder_off" name="rewards_reminder" value="0" '.(Tools::getValue('rewards_reminder', Configuration::get('REWARDS_REMINDER')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="rewards_reminder_off">' . $this->l('No') . '</label>
					</div>
					<div class="clear optional rewards_reminder_optional">
						<div class="clear"></div>
						<label>'.$this->l('Minimum required in account to receive an email').'</label>
						<div class="margin-form">
							<input type="text" size="3" name="rewards_reminder_minimum" value="'.Tools::getValue('rewards_reminder_minimum', (float)Configuration::get('REWARDS_REMINDER_MINIMUM')).'" /> '.$this->context->currency->sign.'&nbsp;
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Frequency of the emails (in days)').'</label>
						<div class="margin-form">
							<input type="text" size="3" name="rewards_reminder_frequency" value="'.Tools::getValue('rewards_reminder_frequency', (float)Configuration::get('REWARDS_REMINDER_FREQUENCY')).'" />
						</div>
					</div>
				</fieldset>
				<div class="clear center"><input class="button" name="submitRewardsNotifications" id="submitRewardsNotifications" value="'.$this->l('Save settings').'" type="submit" /></div>
				</form>
			</div>
			<div id="tabs-general-3">
				<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">
					<input type="hidden" name="plugin" id="plugin" value="general" />
					<input type="hidden" name="tabs-general" value="tabs-general-3" />
					<fieldset>
						<legend>'.$this->l('Labels of the different rewards states displayed in the rewards account').'</legend>
						<label>'.$this->l('Initial').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="default_reward_state_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="default_reward_state_'.$language['id_lang'].'" value="'.(isset($this->rewardStateDefault->name[(int)$language['id_lang']]) ? htmlentities($this->rewardStateDefault->name[(int)$language['id_lang']], ENT_QUOTES, 'utf-8') : htmlentities($this->rewardStateDefault->name[(int)$defaultLanguage], ENT_QUOTES, 'utf-8')).'" />
							</div>';
		$html .= '
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Unavailable').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="discounted_reward_state_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="discounted_reward_state_'.$language['id_lang'].'" value="'.(isset($this->rewardStateDiscounted->name[(int)$language['id_lang']]) ? htmlentities($this->rewardStateDiscounted->name[(int)$language['id_lang']], ENT_QUOTES, 'utf-8') : htmlentities($this->rewardStateDiscounted->name[(int)$defaultLanguage], ENT_QUOTES, 'utf-8')).'" />
							</div>';
		$html .= '
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Converted').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="convert_reward_state_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="convert_reward_state_'.$language['id_lang'].'" value="'.(isset($this->rewardStateConvert->name[(int)$language['id_lang']]) ? htmlentities($this->rewardStateConvert->name[(int)$language['id_lang']], ENT_QUOTES, 'utf-8') : htmlentities($this->rewardStateConvert->name[(int)$defaultLanguage], ENT_QUOTES, 'utf-8')).'" />
							</div>';
		$html .= '
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Validation').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="validation_reward_state_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="validation_reward_state_'.$language['id_lang'].'" value="'.(isset($this->rewardStateValidation->name[(int)$language['id_lang']]) ? htmlentities($this->rewardStateValidation->name[(int)$language['id_lang']], ENT_QUOTES, 'utf-8') : htmlentities($this->rewardStateValidation->name[(int)$defaultLanguage], ENT_QUOTES, 'utf-8')).'" />
							</div>';
		$html .= '
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Return period not exceeded').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="return_period_reward_state_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="return_period_reward_state_'.$language['id_lang'].'" value="'.(isset($this->rewardStateReturnPeriod->name[(int)$language['id_lang']]) ? htmlentities($this->rewardStateReturnPeriod->name[(int)$language['id_lang']], ENT_QUOTES, 'utf-8') : htmlentities($this->rewardStateReturnPeriod->name[(int)$defaultLanguage], ENT_QUOTES, 'utf-8')).'" />
							</div>';
		$html .= '
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Cancelled').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="cancel_reward_state_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="cancel_reward_state_'.$language['id_lang'].'" value="'.(isset($this->rewardStateCancel->name[(int)$language['id_lang']]) ? htmlentities($this->rewardStateCancel->name[(int)$language['id_lang']], ENT_QUOTES, 'utf-8') : htmlentities($this->rewardStateCancel->name[(int)$defaultLanguage], ENT_QUOTES, 'utf-8')).'" />
							</div>';
		$html .= '
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Waiting for payment').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="waiting_payment_reward_state_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="waiting_payment_reward_state_'.$language['id_lang'].'" value="'.(isset($this->rewardStateWaitingPayment->name[(int)$language['id_lang']]) ? htmlentities($this->rewardStateWaitingPayment->name[(int)$language['id_lang']], ENT_QUOTES, 'utf-8') : htmlentities($this->rewardStateWaitingPayment->name[(int)$defaultLanguage], ENT_QUOTES, 'utf-8')).'" />
							</div>';
		$html .= '
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Paid').'</label>
						<div class="margin-form translatable">';
		foreach ($languages as $language)
			$html .= '
							<div class="lang_'.$language['id_lang'].'" id="paid_reward_state_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').'; float: left;">
								<input size="33" type="text" name="paid_reward_state_'.$language['id_lang'].'" value="'.(isset($this->rewardStatePaid->name[(int)$language['id_lang']]) ? htmlentities($this->rewardStatePaid->name[(int)$language['id_lang']], ENT_QUOTES, 'utf-8') : htmlentities($this->rewardStatePaid->name[(int)$defaultLanguage], ENT_QUOTES, 'utf-8')).'" />
							</div>';
		$html .= '
						</div>
					</fieldset>
					<fieldset>
						<legend>'.$this->l('Text to display in the rewards account').'</legend>
						<div class="translatable">';
		foreach ($languages AS $language) {
			$html .= '
							<div class="lang_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;">
								<textarea class="rte autoload_rte" cols="80" rows="25" name="rewards_general_txt['.$language['id_lang'].']">'.Configuration::get('REWARDS_GENERAL_TXT', (int)$language['id_lang']).'</textarea>
							</div>';
		}
		$html .= '
						</div>
					</fieldset>
					<fieldset>
						<legend>'.$this->l('Recommendations for the payment (bank information, invoice, delay...)').'</legend>
						<div class="translatable">';
		foreach ($languages AS $language) {
			$html .= '
							<div class="lang_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $defaultLanguage ? 'block' : 'none').';float: left;">
								<textarea class="rte autoload_rte" cols="80" rows="25" name="rewards_payment_txt['.$language['id_lang'].']">'.Configuration::get('REWARDS_PAYMENT_TXT', (int)$language['id_lang']).'</textarea>
							</div>';
		}
		$html .= '
						</div>
					</fieldset>
					<div class="clear center"><input type="submit" name="submitRewardText" id="submitRewardText" value="'.$this->l('Save settings').'" class="button" /></div>
				</form>
			</div>
		</div>';

		return $html;
	}

	public function recurseCategoryForInclude($boxName, $indexedCategories, $categories, $current, $id_category = 1, $id_category_default = NULL, &$done = NULL, $has_suite = array()) {
		static $irow;
		$html = '';

		if (!isset($done[$current['infos']['id_parent']]))
			$done[$current['infos']['id_parent']] = 0;
		$done[$current['infos']['id_parent']] += 1;

		$todo = sizeof($categories[$current['infos']['id_parent']]);
		$doneC = $done[$current['infos']['id_parent']];

		$level = $current['infos']['level_depth'] + 1;

		$html .= '
		<tr class="'.($irow++ % 2 ? 'alt_row' : '').'">
			<td>
				<input type="checkbox" name="'.$boxName.'[]" class="categoryBox'.($id_category_default == $id_category ? ' id_category_default' : '').'" id="'.$boxName.'_'.$id_category.'" value="'.$id_category.'"'.(in_array($id_category, $indexedCategories) ? ' checked="checked"' : '').' />
			</td>
			<td>
				'.$id_category.'
			</td>
			<td>';
			for ($i = 2; $i < $level; $i++)
				$html .= '<img src="../img/admin/lvl_'.$has_suite[$i - 2].'.gif" alt="" style="vertical-align: middle;"/>';
			$html .= '<img src="../img/admin/'.($level == 1 ? 'lv1.gif' : 'lv2_'.($todo == $doneC ? 'f' : 'b').'.gif').'" alt="" style="vertical-align: middle;"/> &nbsp;
			<label for="'.$boxName.'_'.$id_category.'" class="t">'.stripslashes($current['infos']['name']).'</label></td>
		</tr>';

		if ($level > 1)
			$has_suite[] = ($todo == $doneC ? 0 : 1);
		if (isset($categories[$id_category]))
			foreach ($categories[$id_category] AS $key => $row)
				if ($key != 'infos')
					$html .= $this->recurseCategoryForInclude($boxName, $indexedCategories, $categories, $categories[$id_category][$key], $key, $id_category_default, $done, $has_suite);
		return $html;
	}

	// display news and check if a new version is available
	private function _getXmlRss() {
		$html = '';
		$bError = false;
		if (function_exists('curl_init') && $ch = @curl_init('www.prestaplugins.com/news/allinone_rewards.php')) {
			curl_setopt($ch, CURLOPT_POST, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
            $response = @curl_exec($ch);
            @curl_close($ch);
		} else if (ini_get('allow_url_fopen')) {
			if ($fp = @fsockopen('http://www.prestaplugins.com', 80, $errno, $errstr, 50)){
				fputs($fp, "GET /news/allinone_rewards.php HTTP/1.0\r\n");
				fputs($fp, "Host: www.prestaplugins.com\r\n");
				fputs($fp, "Referer: ".$_SERVER['HTTP_HOST']."\r\n");
				fputs($fp, "Connection: close\r\n");
				$response = '';
				while (!feof($fp))
					$response .= fgets($fp, 1024);
				fclose($fp);
			} else
				$bError = true;
		} else
			$bError = true;

		if ($bError) {
			$html .= '<div style="font-weight: bold; color: red">'.$this->l('You need to enable CURL extension or fsockopen, to be informed about new version of the module').'</div>';
		} else if (!empty($response)) {
			$doc = new DOMDocument('1.0', 'UTF-8');
			@$doc->loadXML($response);
			$version = $doc->getElementsByTagName('version')->item(0)->nodeValue;
			$newslist = $doc->getElementsByTagName('news');

			if (!empty($version)) {
				if (version_compare($this->version, $version, '>='))
					$html .= '<div style="font-weight: bold; margin-bottom: 20px; color: green">'.$this->l('You are currently using the last version of this module').' - '.$this->l('Version').' '.$version.'</div>';
				else {
					$html .= '
						<div style="font-weight: bold; color: red">'.$this->l('A new version of this module is available').' - '.$this->l('Version').' '.$version.'</div>
						<div>You can download it using the link in your invoice on <a href="http://www.prestaplugins.com">http://www.prestaplugins.com</a>
						<div style="margin-bottom: 20px">If you bought it on the Prestashop addons store, please send your proof of payment at <a href="mailto:contact@prestaplugins.com">contact@prestaplugins.com</a> to receive the new version.</div>';
				}
			}

			$html .= '<div id="news_list" style="height: 500px; overflow: auto">';
			$i = 0;
			$suffix = ($this->context->language->iso_code == 'fr') ? '_fr' : '_en';
			foreach($newslist as $news) {
				$date = $news->getElementsByTagName('date')->item(0)->nodeValue;
				$localDate = ($this->context->language->iso_code == 'fr') ? date('d/m/Y', strtotime($date)) : date('Y-m-d', strtotime($date));
				$title = $news->getElementsByTagName('title'.$suffix)->item(0)->nodeValue;
				$text = $news->getElementsByTagName('text'.$suffix)->item(0)->nodeValue;

				$new = '';
				if (empty($this->context->cookie->rewards_news) || $this->context->cookie->rewards_news <= $date) {
					$new .= '<img src="../img/admin/news-new.gif"> ';
				}
				$html .= '
					<div style="float: left; width: 10%; font-weight: bold">'.$localDate.'</div>
					<div style="float: left; width: 90%">
						<div style="font-weight: bold">'.$new.$title.'</div>
						<div style="text-align: justify">'.nl2br($text).'</div>
					</div>
					<div class="clear" style="padding-bottom: 20px"></div>';
				if ($i == 0) {
					$max_date = $date;
					$i++;
				}
			}
			$html .= '</div>';
			$this->context->cookie->rewards_news = $max_date . '00:00:00';
		}
		return $html;
	}

	/**
     * idem than Module::l but with $id_lang
     **/
    public function l2($string, $id_lang=null, $specific=false)
    {
        global $_MODULE, $_MODULES;

        if (!isset($id_lang))
        	$id_lang = Context::getContext()->language->id;

        $_MODULEStmp = $_MODULES;
        $_MODULES = array();

		$filesByPriority = array(
			// Translations in theme
			_PS_THEME_DIR_.'modules/'.$this->name.'/translations/'.Language::getIsoById((int)$id_lang).'.php',
			_PS_MODULE_DIR_.$this->name.'/translations/'.Language::getIsoById((int)$id_lang).'.php',
		);

		foreach ($filesByPriority as $file) {
			if (Tools::file_exists_cache($file) && include($file)) {
				$_MODULES = !empty($_MODULES) ? array_merge($_MODULES, $_MODULE) : $_MODULE;
			}
		}

		$source = Tools::strtolower($specific ? $specific : $this->name);
		$key = md5(str_replace('\'', '\\\'', $string));

		$ret = $string;
		$current_key = strtolower('<{'.$this->name.'}'._THEME_NAME_.'>'.$source).'_'.$key;
		$default_key = strtolower('<{'.$this->name.'}prestashop>'.$source).'_'.$key;
		if (isset($_MODULES[$current_key]))
			$ret = stripslashes($_MODULES[$current_key]);
		elseif (isset($_MODULES[$default_key]))
			$ret = stripslashes($_MODULES[$default_key]);

		$ret = str_replace('"', '&quot;', $ret);
        $_MODULES = $_MODULEStmp;
        return $ret;
    }

	public function getL($key, $id_lang=null) {
		$translations = array(
		'awaiting_validation' => $this->l2('Awaiting validation', $id_lang), // $this->l('Awaiting validation')
		'available' => $this->l2('Available', $id_lang), // $this->l('Available')
		'cancelled' => $this->l2('Cancelled', $id_lang), // $this->l('Cancelled')
		'already_converted' => $this->l2('Already converted', $id_lang), // $this->l('Already converted')
		'unavailable_on_discounts' => $this->l2('Unavailable on discounts', $id_lang), // $this->l('Unavailable on discounts')
		'return_period' => $this->l2('Waiting for return period exceeded', $id_lang), // $this->l('Waiting for return period exceeded')
		'awaiting_payment' => $this->l2('Awaiting payment', $id_lang), // $this->l('Awaiting payment')
		'paid' => $this->l2('Paid', $id_lang), // $this->l('Paid')
		'invitation' => $this->l2('Invitation from your friend', $id_lang), // $this->l('Invitation from your friend')
		'reminder' => $this->l2('Don\'t forget your rewards', $id_lang)); // $this->l('Don\'t forget your rewards')
		return (array_key_exists($key, $translations)) ? $translations[$key] : $key;
	}

	public function sendMail($id_lang, $template, $subject, $data, $mail, $name, $attachment=null) {
		$iso = Language::getIsoById((int)$id_lang);
		if (file_exists(dirname(__FILE__).'/mails/'.$iso.'/'.$template.'.txt') && file_exists(dirname(__FILE__).'/mails/'.$iso.'/'.$template.'.html'))
			return Mail::Send((int)$id_lang, $template, $subject, $data, strval($mail), $name, strval(Configuration::get('PS_SHOP_EMAIL')), strval(Configuration::get('PS_SHOP_NAME')), NULL, NULL, dirname(__FILE__).'/mails/', $attachment);
		else if (file_exists(dirname(__FILE__).'/mails/en/'.$template.'.txt') && file_exists(dirname(__FILE__).'/mails/en/'.$template.'.html')) {
			$id_lang = Language::getIdByIso('en');
			return Mail::Send((int)$id_lang, $template, $subject, $data, strval($mail), $name, strval(Configuration::get('PS_SHOP_EMAIL')), strval(Configuration::get('PS_SHOP_NAME')), NULL, NULL, dirname(__FILE__).'/mails/', $attachment);
		}
	}

	public function getDiscountReadyForDisplay($type, $freeshipping, $value, $id_currency=0) {
		$discount = 0;
		if ((int)$type == 1)
			$discount = (float)$value.chr(37);
		elseif ((int)$type == 2) {
			// when sponsorship generated from back-end, id_currency is provided
			if ($id_currency == 0)
				$id_currency = $this->context->currency;
			$discount = Tools::displayPrice((float)$value, $id_currency);
		}
		if ((int)$freeshipping == 1)
				$discount .= ' + '.$this->l('Free shipping');
		return $discount;
	}

	public function getPath() {
		return $this->_path;
	}


	/*********/
	/* HOOKS */
	/*********/
	public function __call($method, $arguments) {
		return $this->_genericHook($method, isset($arguments[0]) ? $arguments[0] : null);
	}

	private function _genericHook($method, $arguments=NULL) {
		$result = '';
		$temp = NULL;
		foreach($this->plugins as $plugin) {
			if ($plugin->isActive() && method_exists($plugin, $method)) {
				$temp = $plugin->$method($arguments);
				if ($temp !== false && $temp !== true)
				$result .= $temp;
			}
		}
		if (!empty($result))
			return $result;
		return false;
	}


	// add the css used by the module
	public function hookDisplayHeader() {
		$this->context->controller->addCSS($this->getPath().'css/allinone_rewards.css', 'all');

		// Convertit les récompenses à l'état ReturnPeriodId en ValidationId si la date de retour est dépassée, et envoie les mails de rappel
		if (!Configuration::get('REWARDS_USE_CRON')) {
			RewardsModel::checkRewardsStates();
			RewardsAccountModel::sendReminder();
		}

		// add hook from plugins if needed
		return $this->_genericHook(__FUNCTION__);
	}

	// display the link to access to the rewards account
	public function hookDisplayCustomerAccount($params)
	{
		$smarty_values = array(
			'version16' => version_compare(_PS_VERSION_, '1.6', '>=')
		);
		$this->context->smarty->assign($smarty_values);
		$this->html = $this->display($this->path, 'customer-account.tpl');
		// add hook from plugins if needed
		$this->html .= $this->_genericHook(__FUNCTION__, $params);
		return $this->html;
	}

	public function hookDisplayMyAccountBlock($params)
	{
		$this->html = $this->display($this->path, 'my-account.tpl');
		// add hook from plugins if needed
		$this->html .= $this->_genericHook(__FUNCTION__, $params);
		return $this->html;
	}

	public function hookDisplayMyAccountBlockFooter($params)
	{
		return $this->hookDisplayMyAccountBlock($params);
	}

	// display rewards account information in customer admin page
	public function hookDisplayAdminCustomers($params)
	{
		$customer = new Customer((int)$params['id_customer']);
		if ($customer && !Validate::isLoadedObject($customer))
			die(Tools::displayError('Incorrect object Customer.'));

		$msg = $this->_postProcess($params);
		$totals = RewardsModel::getAllTotalsByCustomer((int)$params['id_customer']);
		$rewards = RewardsModel::getAllByIdCustomer((int)$params['id_customer'], true);
		$payments = RewardsPaymentModel::getAllByIdCustomer((int)$params['id_customer']);
		$rewards_account = new RewardsAccountModel((int)$params['id_customer']);

		$this->instanceDefaultStates();
		$states_for_update = array(RewardsStateModel::getDefaultId(), RewardsStateModel::getValidationId(), RewardsStateModel::getCancelId(), RewardsStateModel::getReturnPeriodId());

		$smarty_values = array(
			'customer' => $customer,
			'msg' => $msg,
			'totals' => $totals,
			'rewards' => $rewards,
			'payments' => $payments,
			'payment_authorized' => (int)Configuration::get('REWARDS_PAYMENT'),
			'rewards_account' => $rewards_account,
			'states_for_update' => $states_for_update,
			'sign' => $this->context->currency->sign,
			'rewardStateDefault' => $this->rewardStateDefault->name[(int)$this->context->language->id],
			'rewardStateValidation' => $this->rewardStateValidation->name[(int)$this->context->language->id],
			'rewardStateCancel' => $this->rewardStateCancel->name[(int)$this->context->language->id],
			'rewardStateConvert' => $this->rewardStateConvert->name[(int)$this->context->language->id],
			'rewardStateDiscounted' => $this->rewardStateDiscounted->name[(int)$this->context->language->id],
			'rewardStateReturnPeriod' => $this->rewardStateReturnPeriod->name[(int)$this->context->language->id],
			'rewardStateWaitingPayment' => $this->rewardStateWaitingPayment->name[(int)$this->context->language->id],
			'rewardStatePaid' => $this->rewardStatePaid->name[(int)$this->context->language->id],
			'new_reward_value' => (float)Tools::getValue('new_reward_value'),
			'new_reward_state' => (int)Tools::getValue('new_reward_state'),
			'new_reward_reason' => Tools::getValue('new_reward_reason'),
			'version16' => version_compare(_PS_VERSION_, '1.6', '>=')
		);
		$this->context->smarty->assign($smarty_values);

		// add hook from plugins if needed
		$this->html = $this->display($this->path, 'admincustomer.tpl');
		$this->html .= $this->_genericHook(__FUNCTION__, $params);
		return $this->html;
	}
}