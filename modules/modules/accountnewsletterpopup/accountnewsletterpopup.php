<?php
/**
* MODULE ACCOUNT NEWSLETTER POPUP
*/

if (!defined('_PS_VERSION_'))
	exit;

define('_PS_NEWSLETTER_IMG_DIR_', _PS_IMG_DIR_.'newsletter/');
if (!file_exists(_PS_NEWSLETTER_IMG_DIR_)) {
	mkdir(_PS_NEWSLETTER_IMG_DIR_);
}

class AccountNewsletterPopup extends Module
{
	protected $config_form = false;

	public function __construct()
	{
		$this->name = 'accountnewsletterpopup';
		$this->tab = 'others';
		$this->version = '1.0.0';
		$this->author = 'Vupar';
		$this->need_instance = 0;

		/**
		 * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
		 */
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Account Newsletter Popup');
		$this->description = $this->l('Display a newsletter popup at login when user forgot to subscribe');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall Account Newsletter Popup?');
	}

	/**
	 * Don't forget to create update methods if needed:
	 * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
	 */
	public function install()
	{
		return parent::install() &&
			$this->registerHook('displayCustomerAccount');
	}

	public function uninstall()
	{
		return parent::uninstall();
	}

	/**
	 * Load the configuration form
	 */
	public function getContent()
	{
		/**
		 * If values have been submitted in the form, process.
		 */
		if (((bool)Tools::isSubmit('submitAccountnewsletterpopupModule')) == true)
			$this->postProcess();

		$this->context->smarty->assign('module_dir', $this->_path);

		return $this->renderForm();
	}

	/**
	 * Create the form that will be displayed in the configuration of your module.
	 */
	protected function renderForm()
	{
		$helper = new HelperForm();

		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$helper->module = $this;
		$helper->default_form_language = $this->context->language->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitAccountnewsletterpopupModule';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
			.'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');

		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id,
		);

		return $helper->generateForm(array($this->getConfigForm()));
	}

	/**
	 * Create the structure of your form.
	 */
	protected function getConfigForm()
	{
		return array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Settings'),
					'icon' => 'icon-cogs',
				),
				'input' => array(
					array(
						'col' => 6,
						'type' => 'file',
						'desc' => $this->l('Enter an image for newsletter Popup'),
						'name' => 'POPUP_NEWSLETTER_IMAGE',
						'label' => $this->l('Image Newsletter Popup')." (700px * 480px)",
						'lang' => false,
					)
				),
				'submit' => array(
					'title' => $this->l('Save'),
				),
			),
		);
	}

	/**
	 * Set values for the inputs.
	 */
	protected function getConfigFormValues()
	{
		return array(
			'POPUP_NEWSLETTER_IMAGE' => Configuration::get('POPUP_NEWSLETTER_IMAGE', true),
		);
	}

	/**
	 * Save form data.
	 */
	protected function postProcess()
	{
		$form_values = $this->getConfigFormValues();

		/*foreach (array_keys($form_values) as $key)
			Configuration::updateValue($key, Tools::getValue($key));*/

		$this->updateImage('POPUP_NEWSLETTER_IMAGE', 'newsletter.jpg');
	}

	protected function updateImage($field_name, $name)
	{
		if (isset($_FILES[$field_name]['tmp_name']) && $_FILES[$field_name]['tmp_name'])
		{
			if ($error = ImageManager::validateUpload($_FILES[$field_name], 300000))
				$this->errors[] = $error;

			if (!move_uploaded_file($_FILES[$field_name]['tmp_name'], _PS_NEWSLETTER_IMG_DIR_.$name))
				return false;

			Configuration::updateValue($field_name, $name);
		}
	}

	public function hookDisplayCustomerAccount()
	{
		//Registration customer newsletter
		if(Tools::getValue("subscribe") == "yes") {
			$this->context->customer->newsletter = 1;
			$this->context->customer->newsletter_date_add = date("Y-m-d h:i:s", time());
			$this->context->customer->save();
		}

		//If not registrated to newsletter and come from login or creation page
		if($this->context->customer->newsletter == 0 && strpos($_SERVER['HTTP_REFERER'], "my-account") !== false) {
			$this->context->controller->addJS($this->_path.'/js/front.js');
			$this->context->controller->addCSS($this->_path.'/css/front.css');

			$this->context->smarty->assign(array(
				'POPUP_NEWSLETTER_IMAGE' => _PS_IMG_."newsletter/".Configuration::get('POPUP_NEWSLETTER_IMAGE')
			));

			return $this->display(__FILE__, 'views/templates/hook/account.tpl');
		}
	}
}
