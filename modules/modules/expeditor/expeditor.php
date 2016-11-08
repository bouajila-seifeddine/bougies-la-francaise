<?php

include_once(dirname(__FILE__).'/ExpeditorModule.php');

class Expeditor extends Module
{
	private $_html;
	private $_postErrors = array();
	public $_errors = array();

	private $orderStateExp;
	private $orderStateImp;
	private $carrier;
	private $file_path;

	public function __construct ()
	{
		$this->name = 'expeditor';
		if (preg_match("/1\.4/", _PS_VERSION_))
			$this->tab = 'administration';
		else
			$this->tab = 'Import/export';
		$this->version = '2.3.3';
		$this->author = 'PrestaShop';
		$this->module_key = 'f4caec1f4133b3333c081cd6a4cadfca';

		parent::__construct();

 		/** Backward compatibility */
 		require(_PS_MODULE_DIR_.'/expeditor/backward_compatibility/backward.php');

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Expeditor Inet') . '&nbsp;&#169;';
		$this->description = $this->l('Manage yours orders between Prestashop and your Expeditor Inet software');
	}

	public function install()
	{
		global $cookie;

		if (!parent::install())
			return false;

		$this->installDB();
		if (!$id_tab = $this->installAdmin())
			return false;

		if (!Configuration::get('EXPEDITOR_STATE_EXP'))
			Configuration::updateValue('EXPEDITOR_STATE_EXP', _PS_OS_PREPARATION_);
		if (!Configuration::get('EXPEDITOR_STATE_IMP'))
			Configuration::updateValue('EXPEDITOR_STATE_IMP', _PS_OS_PREPARATION_);
		if (!Configuration::get('EXPEDITOR_CARRIER'))
			Configuration::updateValue('EXPEDITOR_CARRIER', 0);
		if (!Configuration::get('EXPEDITOR_MULTIPLY'))
			Configuration::updateValue('EXPEDITOR_MULTIPLY', 1000);
		if (!Configuration::get('EXPEDITOR_CARRIER_CODES'))
			Configuration::updateValue('EXPEDITOR_CARRIER_CODES', NULL);

		if (!sizeof($this->_errors))
			Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)));

		foreach ($this->_errors as $errors)
			echo $errors.'<br />';
		unset($errors);

		return false;
	}
	function installDB()
	{
		Db::getInstance()->Execute('
		CREATE TABLE IF NOT EXISTS  `'._DB_PREFIX_.'expeditor` (
			`id_expeditor` INT NOT NULL AUTO_INCREMENT,
			`id_order` INT NOT NULL,
			`weight` FLOAT NOT NULL DEFAULT 0,
			`standard_size` BOOLEAN NOT NULL DEFAULT 1,
			`is_send` BOOLEAN NOT NULL DEFAULT 0,
			`date_add` DATETIME NOT NULL,
			`date_upd` DATETIME NOT NULL,
			PRIMARY KEY (`id_expeditor`),
			INDEX index_order_expeditor (`id_order`)
		);');
	}
	function installAdmin()
	{
		$tab = new Tab();
		$tab->class_name = 'AdminExpeditor';
		if (version_compare(_PS_VERSION_, '1.5.0.0') >= 0) {
			$tab->id_parent = 10;
			Autoload::getInstance()->generateIndex();
		}
		else
			$tab->id_parent = 3;

		$tab->module = $this->name;
		$tab->name[Configuration::get('PS_LANG_DEFAULT')] = $this->l('Expeditor Inet');

		if ($tab->add())
			return $tab->id;

		return false;
	}

	function uninstall()
	{
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'tab` WHERE `class_name` = \'AdminExpeditor\'');
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'tab_lang` WHERE `id_tab` NOT IN (SELECT `id_tab` FROM `'._DB_PREFIX_.'tab`)');

		return (parent::uninstall(false));
	}

	public function getContent()
	{
		if (version_compare(_PS_VERSION_, '1.5.0.0') >= 0) {
			Autoload::getInstance()->generateIndex();
		}
		$this->_html .= '<h2>' . $this->l('Expeditor Inet') . '&nbsp;&#169;</h2>';

		$this->_displayDownloadFile();

		if (!empty($_POST) AND isset($_POST['id_order_state_exp']) AND isset($_POST['id_order_state_imp']))
		{
			$this->_postValidation();
			if (!sizeof($this->_postErrors))
				$this->_postProcess();
			else {
				foreach ($this->_postErrors AS $err) {
					$this->_html .= '<div class="warning">'.$err.'</div>';
				}
				unset($err);
			}
		}
		$this->_displayForm();

		global $cookie;
		$this->_html .= '<p><a href="index.php?tab=AdminExpeditor&token='.Tools::getAdminToken('AdminExpeditor'.intval(Tab::getIdFromClassName('AdminExpeditor')).intval($cookie->id_employee)).'">'.$this->l('Direct access to Expeditor tab.').'</a></p>';

		return $this->_html;
	}

	private function _displayForm()
	{
		global $cookie;
		$this->orderStateExp = Configuration::get('EXPEDITOR_STATE_EXP');
		$this->orderStateImp = Configuration::get('EXPEDITOR_STATE_IMP');

		$this->_html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" class="form">';
		$this->_html .= '<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" /> '.$this->l('Settings').'</legend>';
		$this->_html .= '<label for="id_order_state">' . $this->l('Order state export') . '</label>';
		$this->_html .= '<div class="margin-form">';
		$this->_html .= '<select id="id_order_state_exp" name="id_order_state_exp">';

		$order_states_exp = OrderState::getOrderStates($cookie->id_lang);
		foreach ($order_states_exp as $order_state_exp)
		{
			$this->_html .= '<option value="' . $order_state_exp['id_order_state'] . '" style="background-color:' . $order_state_exp['color'] . ';"';
			if ($this->orderStateExp == $order_state_exp['id_order_state'] ) $this->_html .= ' selected="selected"';
			$this->_html .= '>' . $order_state_exp['name'] . '</option>';
		}
		unset($order_states_exp, $order_state_exp);

		$this->_html .= '</select>';
		$this->_html .= "<p>" . $this->l('Choose the order state which orders can be export to Expeditor.') . "</p>";
		$this->_html .= '</div>';

		$this->_html .= '<label for="id_order_state">' . $this->l('Order state import') . '</label>';
		$this->_html .= '<div class="margin-form">';
		$this->_html .= '<select id="id_order_state_imp" name="id_order_state_imp">';

		$order_states_imp = OrderState::getOrderStates($cookie->id_lang);
		foreach ($order_states_imp as $order_state_imp)
		{
			$this->_html .= '<option value="' . $order_state_imp['id_order_state'] . '" style="background-color:' . $order_state_imp['color'] . ';"';
			if ($this->orderStateImp == $order_state_imp['id_order_state'] ) $this->_html .= ' selected="selected"';
			$this->_html .= '>' . $order_state_imp['name'] . '</option>';
		}
		unset($order_states_imp, $order_state_imp);
		$this->_html .= '</select>';
		$this->_html .= "<p>" . $this->l('Choose the order state when orders are import into Prestashop.') . "</p>";
		$this->_html .= '</div>';

		//Carrier choice

		$this->_html .= $this->_displayCarrierSelects();
		$this->_html .= '<label for="id_carrier">' . $this->l('Carrier') . '</label>';
		$this->_html .= '<div class="margin-form">';
		$this->_html .= '<table class="table" cellpadding="0" cellspacing="0">
						<thead><tr>
						<th align="center"><input name="checkme" class="noborder" onclick="checkDelBoxes(this.form, \'carrierbox[]\', this.checked)" type="checkbox"</th>
						<th align="center">'.$this->l('Carrier').'</th>
						<th align="center">'.$this->l('Carrier_code').'</th>
						<thead></tr>';

		$this->carrier = Configuration::get('EXPEDITOR_CARRIER');
		$carriers = Carrier::getCarriers($cookie->id_lang, false, false, false, NULL, 5);

		foreach ($carriers as $carrier)
		{
			$this->_html .= '<tr><td align="center"><input name="carrierbox[]" type="checkbox" value="'.$carrier['id_carrier'].'"';
			if (in_array($carrier['id_carrier'],explode(',', Configuration::get('EXPEDITOR_CARRIER'))))
			$this->_html .= ' checked="true" ';
			$this->_html .= '></td><td align="center">'.$carrier['name'].'</td>';

			//list of Carriers codes
			$expeditor = new ExpeditorModule();
			$product_codes = $expeditor->product_codes;
			$this->_html .= '<td align="center">
							<select name="product_codes_'.$carrier['id_carrier'].'">';
			foreach($product_codes as $code => $subarray)
			{
				$this->_html .= '<option';
				if ($subarray['ref'] == Configuration::get('EXPEDITOR_CARRIER_CODES_'.$carrier['id_carrier']))
					$this->_html .= ' selected="selected" ' ;
				$this->_html .= ' value="'.$subarray['ref'].'" >'.$subarray['name'].'</option>';
			}
			$this->_html .= '</select></td></tr>';
		}
		unset($carriers, $carrier);

		$this->_html .= '</table>';
		$this->_html .= "<p>" . $this->l('Choose the carrier "LaPoste", "ColiPoste" or like this.') . "</p>";
		$this->_html .= '</div>';

		$this->_html .= '
		<label for="id_order_state">'.$this->l('Weight Multiplier').'</label>
		<div class="margin-form">
			<input type="text" name="EXPEDITOR_MULTIPLY" value="'.Tools::getValue('EXPEDITOR_MULTIPLY', Configuration::get('EXPEDITOR_MULTIPLY')).'" />
		</div>
		<div class="margin-form">
			<input type="submit" value="'.$this->l('Save').'" class="button" />
		</div class="margin-form">
		<a href="index.php?tab=AdminExpeditor&token='.Tools::getAdminToken('AdminExpeditor'.intval(Tab::getIdFromClassName('AdminExpeditor')).intval($cookie->id_employee)).'" class="green">' . $this->l('Liste Orders') . '</a>
		</fieldset>
		</form>
		<div class="clear">&nbsp;</div>
		<fieldset>
			<legend>PrestaShop Addons</legend>
			'.$this->l('This module has been developped by PrestaShop SA and can only be sold through').' <a href="http://addons.prestashop.com">addons.prestashop.com</a>.<br />
			'.$this->l('Please report all bugs to').' <a href="mailto:addons@prestashop.com">addons@prestashop.com</a> '.$this->l('or using our').' <a href="http://addons.prestashop.com/contact-form.php">'.$this->l('contact form').'</a>.
		</fieldset>';
	}

	private function _displayCarrierSelects()
	{
		$class = new ExpeditorModule();
	}

	private function _postValidation()
	{
		if (!isset($_POST['id_order_state_imp']) OR empty($_POST['id_order_state_imp']) OR !is_numeric($_POST['id_order_state_imp']) )
			$this->_postErrors[]  = $this->l('No order state import specified');
		if (!isset($_POST['id_order_state_exp']) OR empty($_POST['id_order_state_exp']) OR !is_numeric($_POST['id_order_state_exp']) )
			$this->_postErrors[]  = $this->l('No order state export specified');
		if (!isset($_POST['EXPEDITOR_MULTIPLY']) OR empty($_POST['EXPEDITOR_MULTIPLY']) OR !is_numeric($_POST['EXPEDITOR_MULTIPLY']) )
			$this->_postErrors[]  = $this->l('Multiplier required (0 is allowed)');
	}

	private function _postProcess()
	{

		global $cookie;
		Configuration::updateValue('EXPEDITOR_MULTIPLY', $_POST['EXPEDITOR_MULTIPLY']);
		$ids_carrier_conf = array();

		if (isset($_POST['carrierbox'])) {
			foreach (Tools::getValue('carrierbox') as $id)
				$ids_carrier_conf[] = $id;
			Configuration::updateValue('EXPEDITOR_CARRIER', implode(',', $ids_carrier_conf));
		}
		else
		$this->_html .= '<div class="alert error">'.$this->l('Invalid carrier').'</div>';

		$carriers = Carrier::getCarriers($cookie->id_lang, false, false, false, NULL, 5);
		foreach ($carriers as $carrier) {
			if (isset($_POST['product_codes_'.$carrier['id_carrier']]))
			{
				Configuration::updateValue('EXPEDITOR_CARRIER_CODES_'.$carrier['id_carrier'], $_POST['product_codes_'.$carrier['id_carrier']]);
			}
			else
				$this->_html .= '<div class="alert error">'.$this->l('Invalid carrier code').'</div>';
		}
		unset($carriers,$carrier);

		Configuration::updateValue('EXPEDITOR_STATE_EXP', Tools::getValue('id_order_state_exp'));
		Configuration::updateValue('EXPEDITOR_STATE_IMP', Tools::getValue('id_order_state_imp'));

		$this->_html .= '<div class="conf confirm"><img src="' . _PS_IMG_ . 'admin/enabled.gif" alt="ok" />&nbsp;'.$this->l('Settings updated').'</div>';
	}

	private function _displayDownloadFile()
	{
		$this->_html .= '<p class="warning">';
		$this->_html .= '<a href="' . __PS_BASE_URI__ . 'modules/expeditor/getFmt.php"><img src="' . _PS_IMG_ . 'admin/download_page.png" alt="download" />&nbsp;' . $this->l('Download format file for import data') . '</a>';
		$this->_html .= '</p>';
	}
}