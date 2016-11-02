<?php
/**
 * Google Trusted Stores
*
* @author  Business Tech (www.businesstech.fr) - Contact: http://www.businesstech.fr/en/contact-us
* @license Business Tech
* @version 1.1.7
* @category smart_shopping
* @copyright Business Tech
* 
* Languages: EN, FR
* PS versions: 1.4, 1.5, 1.6
* 
*/

if (!defined('_PS_VERSION_')) exit ;

class GTrustedStores extends Module
{
	/* External URL's */
	const BT_FAQ_MAIN_URL = 'http://faq.businesstech.fr/faq.php?id=';
	const BT_API_MAIN_URL = 'https://api.businesstech.fr:441/prestashop-modules/';

	/* SQL files */
	const INSTALL_SQL_FILE = 'install.sql';
	const UNINSTALL_SQL_FILE = 'uninstall.sql';
	
	/* Module configuration main variables */
	private $_html = '';
	private $_postErrors = array();
	private $_fieldErrorStyles = array();
	private $_checkedFields = array('gts_id', 'gmc_id', 'ok_order_states', 'process_time', 'feed_token', 'shipped_status');
	var $configuration = array();
	var $id_shop = null;

	/*
	As of the last update of this module, Google Trusted Stores is only available for the countries below.
	All orders must have a shipping address that is in the same country as the feed's country,
	ie: for a US feed, only orders shipped to US can be present in the feed
	*/
	var $gTrustedStoresCountries = array(
		'US' => array('language' => 'en', 'currency' => 'USD', 'ps_languages' => array('en', 'gb', 'en-us', 'en-gb')),
		'GB' => array('language' => 'en', 'currency' => 'GBP', 'ps_languages' => array('en', 'gb', 'en-us', 'en-gb')),
		'AU' => array('language' => 'en', 'currency' => 'AUD', 'ps_languages' => array('en', 'gb', 'en-us', 'en-gb')),
		'FR' => array('language' => 'fr', 'currency' => 'EUR', 'ps_languages' => array('fr')),
		'DE' => array('language' => 'de', 'currency' => 'EUR', 'ps_languages' => array('de')),
		'JP' => array('language' => 'ja', 'currency' => 'JPY', 'ps_languages' => array('ja')),
	);

	/* 
	Used to determine country based on language and currency
	recorded in the front-office context object
	required for the Google Trusted Stores badge (footer.tpl)
	*/
	var $gTrustedStoresLocaleMatrix = array(
		'en_gbp' => 'GB',
		'en-gb_gbp' => 'GB',
		'gb_gbp' => 'GB',
		'en_aud' => 'AU',
		'en-gb_aud' => 'AU',
		'gb_aud' => 'AU',
		'en_usd' => 'US',
		'en-us_usd' => 'AU',
		'fr_eur' => 'FR',
		'de_eur' => 'DE',
		'ja_jpy' => 'JP',
	);

	// Predefined list of recognized carriers for Google
	var $gCarriers = array();

	// List of order cancellation reasons
	var $gCancelReasons = array();

	function __construct()
	{
		$this->name = 'gtrustedstores';
		$this->tab = 'smart_shopping';
		$this->version = '1.1.8';
//		$this->ps_versions_compliancy = array('min' => '1.4.1.0', 'max' => '1.6');
		$this->author = 'Business Tech';
		$this->module_key = '676c386a901fe37b86d6e6ef25993c0e';
		$this->page = basename(__FILE__, '.php');

		parent::__construct();

		$this->displayName = $this->l('Google Trusted Stores');
		$this->description = $this->l('Benefit from Google\'s Trusted Stores program and increase your sales');
		$this->confirmUninstall = $this->l('Are you sure you want to remove Google Trusted Stores ?');

		// Backward compatibility & context init
		require_once(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php'); 

		// Assign id_shop in module so as not call all the heavy files every time
		if (!empty($this->context) && is_object($this->context))
			$this->id_shop = (int)($this->context->shop->id);
		if (empty($this->id_shop))
			$this->id_shop = 1;

		// Load configuration
		$this->_loadConfig();

		// Set carrier names here because we need $this->l()
		$this->gCarriers = array(
			'UPS' 				=> 'UPS',
			'USPS' 				=> 'UPS Mail Innovations',
			'FedEx' 			=> 'FedEx',
			'USPS' 				=> 'US Postal Service',
			'Other_ABFS' 		=> $this->l('Other: ABF Freight Systems'),
			'Other_AMWST' 		=> $this->l('Other: America West'),
			'Other_BEKINS' 		=> $this->l('Other: Bekins'),
			'Other_CNWY' 		=> $this->l('Other: Conway'),
			'Other_DHL' 		=> $this->l('Other: DHL'),
			'Other_ESTES' 		=> $this->l('Other: Estes'),
			'Other_HDUSA' 		=> $this->l('Other: Home Direct USA'),
			'Other_LASERSHIP' 	=> $this->l('Other: LaserShip'),
			'Other_MYFLWR' 		=> $this->l('Other: Mayflower'),
			'Other_ODFL' 		=> $this->l('Other: Old Dominion Freight'),
			'Other_RDAWAY' 		=> $this->l('Other: Reddaway'),
			'Other_TWW' 		=> $this->l('Other: Team Worldwide'),
			'Other_WATKINS' 	=> $this->l('Other: Watkins'),
			'Other_YELL' 		=> $this->l('Other: Yellow Freight'),
			'Other_YRC' 		=> $this->l('Other: YRC'),
			'Other_OTHER' 		=> $this->l('Other: All other carriers'),
		);

		// Same thing for cancellation reasons, we need $this->l()
		$this->gCancelReasons = array(
			'BuyerCanceled' 	=> $this->l('Customer cancelled order'),
			'MerchantCanceled' 	=> $this->l('Merchant unable to fulfill order'),
			'DuplicateInvalid' 	=> $this->l('Duplicate or invalid / test order'),
			'FraudFake' 		=> $this->l('Fraudulent order'),
		);

		// Initialize HTML
		$this->_html = '';
	}


	public function install()
	{
		// Create tables from install.sql
		if (!file_exists(_PS_MODULE_DIR_.$this->name.'/'.self::INSTALL_SQL_FILE))
			return false;

		if (!$sql =  Tools::file_get_contents(_PS_MODULE_DIR_.$this->name.'/'.self::INSTALL_SQL_FILE))
			return false;

		$sql = str_replace('PREFIX_', _DB_PREFIX_, $sql);
		$sql = explode("\n", $sql);

		foreach ($sql as $q)
			Db::getInstance()->Execute(trim($q));

		// Try to get id_prefix from GMC module
		$id_prefix = ((Configuration::get('GMERCHANTCENTER_ID_PREFIX')) ? Configuration::get('GMERCHANTCENTER_ID_PREFIX') : '');

		// For shipment feed, we need to initialize the last order ID
		// so we only export orders placed after the module installation
		$last_order_id = Db::getInstance()->getValue('SELECT MAX(`id_order`) FROM `'._DB_PREFIX_.'orders`');

		// For PS 1.4
		if (version_compare(_PS_VERSION_, '1.5', '<'))
		{
			if (!parent::install()
				OR !Configuration::updateValue('GTRUSTEDSTORES_VERSION', $this->version)
				OR !Configuration::updateValue('GTRUSTEDSTORES_GTS_ID', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHOP_USA', 0)
				OR !Configuration::updateValue('GTRUSTEDSTORES_GMC_ID', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_ID_PREFIX', $id_prefix)
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHOW_BADGE', 1)
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHOW_BADGE_CSS', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_OK_ORDER_STATES', (int)(Configuration::get('PS_OS_PAYMENT')))
				OR !Configuration::updateValue('GTRUSTEDSTORES_SAME_DAY', 0)
				OR !Configuration::updateValue('GTRUSTEDSTORES_PROCESS_TIME', 1)
				OR !Configuration::updateValue('GTRUSTEDSTORES_CUTOFF_HOURS', '11')
				OR !Configuration::updateValue('GTRUSTEDSTORES_CUTOFF_MINUTES', '00')
				OR !Configuration::updateValue('GTRUSTEDSTORES_CLOSED_DAYS', '6,0')
				OR !Configuration::updateValue('GTRUSTEDSTORES_HOLIDAYS', '12_25,1_1')
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHIP_TIME', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_FEED_TOKEN', md5(rand(1000, 1000000).time()))
				OR !Configuration::updateValue('GTRUSTEDSTORES_CARRIERS', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHIPPED_STATUS', (int)(Configuration::get('PS_OS_SHIPPING')))
				OR !Configuration::updateValue('GTRUSTEDSTORES_LAST_ORDER_LOG_S', (int)($last_order_id))
				OR !Configuration::updateValue('GTRUSTEDSTORES_LAST_ORDER_LOG_C', (int)($last_order_id))
				OR !Configuration::updateValue('GTRUSTEDSTORES_CANCEL_STATUSES', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_CANCEL_MATCHING', '')
				OR !$this->registerHook('header')
				OR !$this->registerHook('orderConfirmation')
			)
				return false;
		}

		// For PS 1.5
		else {
			if (!parent::install()
				OR !Configuration::updateValue('GTRUSTEDSTORES_VERSION', $this->version)
				OR !Configuration::updateValue('GTRUSTEDSTORES_GTS_ID', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_GMC_ID', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHOP_USA', 0)
				OR !Configuration::updateValue('GTRUSTEDSTORES_ID_PREFIX', $id_prefix)
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHOW_BADGE', 1)
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHOW_BADGE_CSS', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_OK_ORDER_STATES', (int)(Configuration::get('PS_OS_PAYMENT')))
				OR !Configuration::updateValue('GTRUSTEDSTORES_SAME_DAY', 0)
				OR !Configuration::updateValue('GTRUSTEDSTORES_PROCESS_TIME', 1)
				OR !Configuration::updateValue('GTRUSTEDSTORES_CUTOFF_HOURS', '11')
				OR !Configuration::updateValue('GTRUSTEDSTORES_CUTOFF_MINUTES', '00')
				OR !Configuration::updateValue('GTRUSTEDSTORES_CLOSED_DAYS', '6,0')
				OR !Configuration::updateValue('GTRUSTEDSTORES_HOLIDAYS', '12_25,1_1')
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHIP_TIME', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_FEED_TOKEN', md5(rand(1000, 1000000).time()))
				OR !Configuration::updateValue('GTRUSTEDSTORES_CARRIERS', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_SHIPPED_STATUS', (int)(Configuration::get('PS_OS_SHIPPING')))
				OR !Configuration::updateValue('GTRUSTEDSTORES_LAST_ORDER_LOG_S', (int)($last_order_id))
				OR !Configuration::updateValue('GTRUSTEDSTORES_LAST_ORDER_LOG_C', (int)($last_order_id))
				OR !Configuration::updateValue('GTRUSTEDSTORES_CANCEL_STATUSES', '')
				OR !Configuration::updateValue('GTRUSTEDSTORES_CANCEL_MATCHING', '')
				OR !$this->registerHook('displayHeader')
				OR !$this->registerHook('displayOrderConfirmation')
			)
				return false;
		}

		$this->_copyOutputFile();

		return true;
	}

	public function uninstall()
	{
		if (!parent::uninstall()
			OR !Configuration::deleteByName('GTRUSTEDSTORES_VERSION')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_GTS_ID')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_GMC_ID')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_SHOP_USA')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_ID_PREFIX')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_SHOW_BADGE')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_SHOW_BADGE_CSS')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_OK_ORDER_STATES')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_SAME_DAY')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_PROCESS_TIME')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_CUTOFF_HOURS')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_CUTOFF_MINUTES')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_CLOSED_DAYS')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_HOLIDAYS')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_SHIP_TIME')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_FEED_TOKEN')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_CARRIERS')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_SHIPPED_STATUS')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_LAST_ORDER_LOG_S')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_LAST_ORDER_LOG_C')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_CANCEL_STATUSES')
			OR !Configuration::deleteByName('GTRUSTEDSTORES_CANCEL_MATCHING')
		)
			return false;

		$this->_removeOutputFile();

		return true;
	}

	// Copy the on the fly output file to site root
	private function _copyOutputFile()
	{
		$source = _PS_MODULE_DIR_.$this->name.'/gtrustedstores.feed.php';
		$dest = _PS_ROOT_DIR_.'/gtrustedstores.feed.php';
		@copy($source, $dest);
		return true;
	}

	/* Remove XML files when module is uninstalled */
	private function _removeOutputFile()
	{
		@unlink(_PS_ROOT_DIR_.'/gtrustedstores.feed.php');
		return true;
	}
	
	// Check module version and perform any necessary updates
	private function _updateModule()
	{
		$need_update = false;
		$update_ok = true;

		// Display message
		if ($need_update)
		{
			if (!$update_ok)
				$this->_displayVersionUpdateError();
			else
				$this->_displayVersionUpdateConfirm();
		}
		
		// Make sure we record / update version number
		Configuration::updateValue('GTRUSTEDSTORES_VERSION', $this->version);
		
		// Reload config
		$this->_loadConfig();
		
		return $this->_html;
	}

	// Available shop languages
	public function getAvailableLanguages($id_shop)
	{
		if (version_compare(_PS_VERSION_, '1.5', '>'))
			$shopLanguages = Language::getLanguages(false, (int)($id_shop));
		else
			$shopLanguages = Language::getLanguages(false);
			
		return $shopLanguages;
	}

	// Performs a "JOIN" of $gTrustedStoresCountries and active countries on shop
	public function getValidCountries()
	{
		$validCountries = array();

		foreach ($this->gTrustedStoresCountries as $iso => $data) {
			$country_id = Country::getByIso($iso);
			if (!empty($country_id)) {
				$country = new Country((int)($country_id), (int)($this->context->cookie->id_lang));
				if (Validate::isLoadedObject($country) && $country->active) {
					$validCountries[(int)($country_id)] = Tools::stripslashes($country->name);
				}
			}
		}
			
		return $validCountries; 
	}

	public function getAvailableCarriers()
	{
		return Carrier::getCarriers((int)($this->context->cookie->id_lang), true, false, false, null, 5);
	}

	// Show confirmation message
	private function _displayConfirm()
	{
		$this->_html .= '
		<div class="bootstrap">
			<div class="alert alert-success">
				'.$this->l('Settings updated').'
			</div>
		</div>';

		
		return true;
	}

	// Show error messages
	private function _displayErrors()
	{
		$nbErrors = sizeof($this->_postErrors);
		$this->_html .= '
		<div class="bootstrap">
			<div id="formError" class="alert alert-danger">
				<!--<img class="pointer" style="float: right;" src="../views/img/admin/icon-invalid.gif" alt="'.$this->l('Close').'" onclick="$(\'#formError\').hide();" />-->
				<h3>'.($nbErrors > 1 ? $this->l('There are') : $this->l('There is')).' '.$nbErrors.' '.($nbErrors > 1 ? $this->l('errors') : $this->l('error')).'</h3>
				<ol>';
			foreach ($this->_postErrors AS $error)
				$this->_html .= '<li>'.$error.'</li>';
			$this->_html .= '
				</ol>
			</div>
		</div>';
		
		return true;
	}

	// Initialize CSS classes to none on all form fields that go through sanity checks
	private function _initErrorStyles()
	{
		foreach ($this->_checkedFields as $key) {
			if (!array_key_exists($key, $this->_fieldErrorStyles)) {
				$this->_fieldErrorStyles[$key] = '';
			}
		}
	}
	
	// Show confirmation after successful module update
	private function _displayVersionUpdateConfirm()
	{
		$this->_html .= '
		<div class="conf confirm">
			'.$this->l('The module was just successfully updated to its latest version. Please update your module settings.').'
		</div>';
	}
	
	// Show error message after failed module update
	private function _displayVersionUpdateError()
	{
		$this->_html .= '
		<div class="alert alert-danger">
			'.$this->l('The module needs to be updated but the necessary database operations could not be completed. Please make sure the MySQL database user has ALTER TABLE privileges.').'
		</div>';
	}

	// Load configuration variables in module object
	// to avoid constant calls to Configuration::get()
	private function _loadConfig()
	{
		/* Load configuration */
		$this->configuration = Configuration::getMultiple(array(
			'GTRUSTEDSTORES_VERSION',
			'GTRUSTEDSTORES_GTS_ID',
			'GTRUSTEDSTORES_GMC_ID',
			'GTRUSTEDSTORES_SHOP_USA',
			'GTRUSTEDSTORES_ID_PREFIX',
			'GTRUSTEDSTORES_SHOW_BADGE',
			'GTRUSTEDSTORES_SHOW_BADGE_CSS',
			'GTRUSTEDSTORES_OK_ORDER_STATES',
			'GTRUSTEDSTORES_SAME_DAY',
			'GTRUSTEDSTORES_PROCESS_TIME',
			'GTRUSTEDSTORES_CUTOFF_HOURS',
			'GTRUSTEDSTORES_CUTOFF_MINUTES',
			'GTRUSTEDSTORES_CLOSED_DAYS',
			'GTRUSTEDSTORES_HOLIDAYS',
			'GTRUSTEDSTORES_SHIP_TIME',
			'GTRUSTEDSTORES_FEED_TOKEN',
			'GTRUSTEDSTORES_CARRIERS',
			'GTRUSTEDSTORES_SHIPPED_STATUS',
			'GTRUSTEDSTORES_LAST_ORDER_LOG_S',
			'GTRUSTEDSTORES_LAST_ORDER_LOG_C',
			'GTRUSTEDSTORES_CANCEL_STATUSES',
			'GTRUSTEDSTORES_CANCEL_MATCHING',
		));

		return true;
	}

	// Main module configuration function: update module config,
	// display config form, and perform other back-office module actions
	public function getContent()
	{
		// Check if the module needs to be updated from previous versions
		$this->_updateModule();

		// On form submission
		if (Tools::getValue('updateGTS'))
		{
			// Check form for missing values
			$this->_checkForm();
			$this->updateConfig();
			
		}

		$this->_loadConfig();
		$this->_displayForm();
		return $this->_html;
	}

	// Display module configuration form
	private function _displayForm()
	{
		$this->_initErrorStyles();
		require _PS_MODULE_DIR_.$this->name.'/form_config.php';	
		return true;
	}

	// Check mandatory fields
	private function _checkForm()
	{
		$this->_fieldErrorStyles['gts_id'] = '';
		if (!Tools::getValue('gts_id')) {
			$this->_postErrors['gts_id'] = $this->l('Google Trusted Stores ID is required (Basic settings tab)');
			$this->_fieldErrorStyles['gts_id'] = ' class="form-error"';
		}

		$this->_fieldErrorStyles['gmc_id'] = '';
		if (!Tools::getValue('gmc_id')) {
			$this->_postErrors['gmc_id'] = $this->l('Google Merchant Center ID is required (Basic settings tab)');
			$this->_fieldErrorStyles['gmc_id'] = ' class="form-error"';
		}

		$this->_fieldErrorStyles['ok_order_states'] = '';

		if (!Tools::getValue('ok_order_states')) {
			$this->_postErrors['ok_order_states'] = $this->l('Please select at least one order status (Order settings tab)');
			$this->_fieldErrorStyles['ok_order_states'] = ' class="form-error"';
		}

		$this->_fieldErrorStyles['process_time'] = '';
		if (!Tools::getValue('process_time') && !Tools::getValue('same_day')) {
			$this->_postErrors['process_time'] = $this->l('Please indicate your order processing time (Shipping settings tab)');
			$this->_fieldErrorStyles['process_time'] = ' class="form-error"';
		}

		if( $this->configuration['GTRUSTEDSTORES_SHOP_USA'] == 1) {
			$this->_fieldErrorStyles['feed_token'] = '';
			if (!Tools::getValue('feed_token')) {
				$this->_postErrors['feed_token'] = $this->l('Please indicate your feed security token (Feed settings tab)');
				$this->_fieldErrorStyles['feed_token'] = ' class="form-error"';
			}
		}

		if( $this->configuration['GTRUSTEDSTORES_SHOP_USA'] == 1) {
			$this->_fieldErrorStyles['shipped_status'] = '';
			if (!Tools::getValue('shipped_status')) {
				$this->_postErrors['shipped_status'] = $this->l('Please select at least one order status for shipments (Feed settings tab)');
				$this->_fieldErrorStyles['shipped_status'] = ' class="form-error"';
			}
		}
	}

	// Update the module's configuration
	// This function has several form inputs that are checkboxes with [] in the name and return an array. 
	// Therefore, we are using $_POST instead of Tools::getValue() as the latter only 
	// works with arrays starting at version 1.4.7 and we need compatibility with earlier
	// version in the 1.4 branch
	public function updateConfig()
	{
		if (!sizeof($this->_postErrors))
		{
			Configuration::updateValue('GTRUSTEDSTORES_GTS_ID', strip_tags(Tools::getValue('gts_id')));
			Configuration::updateValue('GTRUSTEDSTORES_GMC_ID', strip_tags(Tools::getValue('gmc_id')));
			Configuration::updateValue('GTRUSTEDSTORES_SHOP_USA', (int)(Tools::getValue('shop_usa')));
			Configuration::updateValue('GTRUSTEDSTORES_ID_PREFIX', strip_tags(Tools::getValue('id_prefix')));
			Configuration::updateValue('GTRUSTEDSTORES_SHOW_BADGE', (int)(Tools::getValue('show_badge')));
			Configuration::updateValue('GTRUSTEDSTORES_SHOW_BADGE_CSS', (string)(Tools::getValue('set_css')));

			if (Tools::getValue('ok_order_states') && is_array(Tools::getValue('ok_order_states'))) { // array
				Configuration::updateValue('GTRUSTEDSTORES_OK_ORDER_STATES', strip_tags(implode(',', Tools::getValue('ok_order_states'))));
			}
			else {
				Configuration::updateValue('GTRUSTEDSTORES_OK_ORDER_STATES', '');
			}

			Configuration::updateValue('GTRUSTEDSTORES_SAME_DAY', (int)(Tools::getValue('same_day')));
			Configuration::updateValue('GTRUSTEDSTORES_PROCESS_TIME', (int)(Tools::getValue('process_time')));
			Configuration::updateValue('GTRUSTEDSTORES_CUTOFF_HOURS', strip_tags(Tools::getValue('cutoff_hours')));
			Configuration::updateValue('GTRUSTEDSTORES_CUTOFF_MINUTES', strip_tags(Tools::getValue('cutoff_minutes')));

			if (Tools::getValue('closed_days') && is_array(Tools::getValue('closed_days'))) { // array
				Configuration::updateValue('GTRUSTEDSTORES_CLOSED_DAYS', strip_tags(implode(',', Tools::getValue('closed_days'))));
			}
			else {
				Configuration::updateValue('GTRUSTEDSTORES_CLOSED_DAYS', '');
			}

			if (Tools::getValue('holidays') && is_array(Tools::getValue('holidays'))) { // array
				Configuration::updateValue('GTRUSTEDSTORES_HOLIDAYS', strip_tags(implode(',', Tools::getValue('holidays'))));
			}
			else {
				Configuration::updateValue('GTRUSTEDSTORES_HOLIDAYS', '');
			}

			if (Tools::getValue('ship_time')) { // array
				Configuration::updateValue('GTRUSTEDSTORES_SHIP_TIME', strip_tags(serialize(Tools::getValue('ship_time'))));
			}
			else { 
				Configuration::updateValue('GTRUSTEDSTORES_SHIP_TIME', '');
			}

			Configuration::updateValue('GTRUSTEDSTORES_FEED_TOKEN', strip_tags(Tools::getValue('feed_token')));

			if (Tools::getValue('carriers')) { // array
				Configuration::updateValue('GTRUSTEDSTORES_CARRIERS', strip_tags(serialize(Tools::getValue('carriers'))));
			}
			else { 
				Configuration::updateValue('GTRUSTEDSTORES_CARRIERS', '');
			}

			if (Tools::getValue('shipped_status') && is_array(Tools::getValue('shipped_status'))) { // array
				Configuration::updateValue('GTRUSTEDSTORES_SHIPPED_STATUS', strip_tags(implode(',', Tools::getValue('shipped_status'))));
			}
			else {
				Configuration::updateValue('GTRUSTEDSTORES_SHIPPED_STATUS', '');
			}

			if (Tools::getValue('cancel_statuses') && is_array(Tools::getValue('cancel_statuses'))) { // array
				Configuration::updateValue('GTRUSTEDSTORES_CANCEL_STATUSES', strip_tags(implode(',', Tools::getValue('cancel_statuses'))));
				Configuration::updateValue('GTRUSTEDSTORES_CANCEL_MATCHING', strip_tags(serialize(Tools::getValue('cancel_statuses'))));
			}
			else {
				Configuration::updateValue('GTRUSTEDSTORES_CANCEL_STATUSES', '');
				Configuration::updateValue('GTRUSTEDSTORES_CANCEL_MATCHING', '');
			}

			// All good ? Show confirmation message
			$this->_displayConfirm();
		}
		else {
			// Show errors if form values are missing
			$this->_displayErrors();
		}
	}


	/* -------------- */
	/* HOOK FUNCTIONS */
	/* -------------- */

	// Used to display Google Trusted STores certification badge
	public function hookHeader($params)
	{
		//  Only if setting to display badge is on
		if ($this->configuration['GTRUSTEDSTORES_SHOW_BADGE']) {
			$locale_data = $this->getHookLocaleData();

			$iShowCssCutom = $this->configuration['GTRUSTEDSTORES_SHOW_BADGE'];

			if ( $iShowCssCutom == 2)
			{
				$sShowCssCutom = true;
			}
			else
			{
				$sShowCssCutom = false;
			}


			// Assign to Smarty and display template
			$this->context->smarty->assign(
			array(
				'gts_manage_badge' => $this->configuration['GTRUSTEDSTORES_SHOP_USA'],
				'gts_id' => $this->configuration['GTRUSTEDSTORES_GTS_ID'],
				'gts_gmc_id' => $this->configuration['GTRUSTEDSTORES_GMC_ID'],
				'gts_product_id' => $this->getHookProductId($locale_data, (int)(Tools::getValue('id_product'))),
				'gts_language' => Tools::strtolower($locale_data['language']),
				'gts_country' => $locale_data['country'],
				'gts_customize_css' => $sShowCssCutom,
				'gts_custom_css' => $this->configuration['GTRUSTEDSTORES_SHOW_BADGE_CSS'],
			));

			return $this->display(__FILE__, 'views/templates/hook/header.tpl');
		}
		else {
			return '';
		}
	}
	
	// Same as hookHeader, but for 1.5
	public function hookDisplayHeader($params)
	{
		return $this->hookHeader($params);
	}

	// Used to display Google Trusted Stores order confirmation tracking code
	public function hookOrderConfirmation($params)
	{
		/* For order related helper functions */
		require_once(_PS_MODULE_DIR_.$this->name.'/lib/GTSOrders.php');
		$GTSOrders = new BT_GTSOrders($this);

		// for 1.5: params is an array with object order
		if (is_array($params) && !empty($params['objOrder']) && Validate::isLoadedObject($params['objOrder'])) {
			$id_order = $params['objOrder']->id;
		}

		// for 1.4: params is an integer = id_order
		else {
			$id_order = $params;
		}

		$order = new Order((int)($id_order));

		if (Validate::isLoadedObject($order)) {
			$customer = new Customer((int)($order->id_customer));
			$currency = new Currency((int)($order->id_currency));
			$cart = new Cart((int)($order->id_cart));
			$delivery_address = new Address((int)($order->id_address_delivery));
			if (Validate::isLoadedObject($delivery_address)) {
				$delivery_country = new Country((int)($delivery_address->id_country), (int)($this->context->cookie->id_lang));
			}
			$order_products = $order->getProducts();
			$cart_products = $cart->getProducts(true);
		}

		// Let's make sure we have everything we need, before going any further
		if (!Validate::isLoadedObject($order) || !Validate::isLoadedObject($customer) || !Validate::isLoadedObject($currency)  || !Validate::isLoadedObject($cart) 
			|| !Validate::isLoadedObject($delivery_address) || !Validate::isLoadedObject($delivery_country) || !is_array($order_products) || !is_array($cart_products)) {
			return '';
		}

		// OK, order state check
		if (!$GTSOrders->orderIsValidForConfirmation($order)) {
			return '';
		}

		// Tax calculation
		$product_tax = (float)($order->total_products_wt) - (float)($order->total_products);
		$shipping_tax = (float)$order->total_shipping - ((float)($order->total_shipping) / (1 + ((float)($order->carrier_tax_rate) / 100)));
		$total_tax = (float)($product_tax) + (float)($shipping_tax);

		// Shipping date
		$estShippingDate = $GTSOrders->getEstimatedShippingDate($order, $order_products);

		// Assign to Smarty and display template
		$smarty_vars = array(
			'gts_merchant_order_id' => (int)($id_order),
			'gts_merchant_order_domain' => ((Configuration::get('PS_SHOP_DOMAIN')) ? Tools::strtolower(Configuration::get('PS_SHOP_DOMAIN')) : ''),
			'gts_customer_email' => $customer->email,
			'gts_customer_country' => $delivery_country->iso_code,
			'gts_currency' => $currency->iso_code,
			'gts_order_total' => number_format((float)($order->total_paid), 2, '.', ''),
			'gts_order_discounts' => number_format((float)($order->total_discounts), 2, '.', ''),
			'gts_order_shipping' => number_format((float)($order->total_shipping), 2, '.', ''),
			'gts_order_tax' => number_format((float)($total_tax), 2, '.', ''),
			'gts_order_est_ship_date' => $estShippingDate,
			'gts_order_est_delivery_date' => $GTSOrders->getEstimatedDeliveryDate($order, $estShippingDate),
			'gts_has_backorder_preorder' => (($GTSOrders->hasBackOrderPreorder($order_products)) ? 'Y' : 'N'),
			'gts_has_digital_goods' => (($GTSOrders->hasDigitalGoods($order)) ? 'Y' : 'N'),
			'gts_items' => $GTSOrders->prepareOrderItems($cart_products, $this->getHookLocaleData()),
		);

		$this->context->smarty->assign($smarty_vars);

		return $this->display(__FILE__, 'views/templates/hook/order-confirmation.tpl');
	}

	// Same as hookOrderConfirmation, but for 1.5
	public function hookDisplayOrderConfirmation($params)
	{
		return $this->hookOrderConfirmation($params);
	}

	// Get all the required ISO codes for the Google badge JavaScript code
	public function getHookLocaleData()
	{
		$data = array();

		// Get current language
		if (!empty($this->context->language->iso_code))
			$data['language'] = Tools::strtoupper($this->context->language->iso_code);
		else
			$data['language'] = '';

		// Get current currency
		if (!empty($this->context->currency->iso_code))
			$data['currency'] = Tools::strtoupper($this->context->currency->iso_code);
		else
			$data['currency'] = '';

		// Try to determine country
		$key = Tools::strtolower($data['language']).'_'.Tools::strtolower($data['currency']);

		if (!empty($key))
		{
			if (!empty($this->gTrustedStoresLocaleMatrix[$key]))
			{
				$data['country'] = Tools::strtoupper($this->gTrustedStoresLocaleMatrix[$key]);
			}
		}


		if (empty($data['country'])) {
			if (!empty($this->context->country->iso_code))
				$data['country'] = Tools::strtoupper($this->context->country->iso_code);
			else
				$data['country'] = '';
		}

		return $data;
	}

	// Get product ID in correct Google format (matches Merchant Center product ID 
	// if module is installed, otherwise simple ID product)
	public function getHookProductId($locale, $id_product, $id_attribute=null)
	{
		if (!empty($locale) && !empty($locale['country'])) {
			if (!empty($id_product)) {
				if (!empty($id_attribute) && Configuration::get('GMERCHANTCENTER_P_COMBOS')) {
					if (Configuration::get('GMERCHANTCENTER_ID_PREFIX')) {
						return Tools::strtoupper($this->configuration['GTRUSTEDSTORES_ID_PREFIX']).$locale['country'].(int)($id_product).'v'.(int)($id_attribute);
					}
					// If no merchant center module installed, then simple ID product
					else {
						return (int)($id_product);
					}
				}
				else {
					if (Configuration::get('GMERCHANTCENTER_ID_PREFIX')) {
						return Tools::strtoupper($this->configuration['GTRUSTEDSTORES_ID_PREFIX']).$locale['country'].(int)($id_product);
					}
					// If no merchant center module installed, then simple ID product
					else {
						return (int)($id_product);
					}
				}
			}
			else {
				return '';
			}
		}
	}
}
?>