<?php
/**
 *
 * PM_MultipleFeatures Front Office Feature
 *
 * @category front_office_features
 * @author Presta-Module.com <support@presta-module.com>
 * @copyright Presta-Module 2014
 * @version 1.1.9
 *
 * 		 	 ____     __  __
 * 			|  _ \   |  \/  |
 * 			| |_) |  | |\/| |
 * 			|  __/   | |  | |
 * 			|_|      |_|  |_|
 *
 *
 *************************************
 **        Multiple Features         *
 **   http://www.presta-module.com   *
 **             V 1.1.9              *
 *************************************
 * +
 * + Languages: EN, FR
 * + PS version: 1.4, 1.5, 1.6
 *
 ****/

if (!defined('_PS_VERSION_'))
	exit;

class PM_MultipleFeatures extends Module
{
	private $_base_config_url;
	private $_languages;
	private $_defaultFormLanguage;
	public $_errors = array();
	protected $submitted_tabs;
	public function __construct()
	{
		$this->name = 'pm_multiplefeatures';
		$this->tab = 'front_office_features';
		$this->version = '1.1.9';
		$this->author = 'Presta-Module';
		$this->module_key = 'ba224a2fe8a2bd0c86589860fab0decb';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Multiple Features');
		$this->description = $this->l('Allow to define multiple features values per features');
	}

	public function install()
	{
		$result = Db::getInstance()->ExecuteS('SHOW INDEX FROM `' . _DB_PREFIX_ . 'feature_product` WHERE `Key_name` = "PRIMARY"');
		if ($result) {
			Db::getInstance()->Execute('ALTER TABLE `' . _DB_PREFIX_ . 'feature_product` DROP PRIMARY KEY , ADD INDEX ( `id_feature` , `id_product` )');
		}
		return (parent::install() AND $this->registerHook('backOfficeTop')  AND $this->registerHook('backOfficeHeader'));
	}
	// Checking customs feature
	private function checkFeatures($languages, $feature_id)
	{
		$rules = call_user_func(array('FeatureValue', 'getValidationRules'), 'FeatureValue');
		$feature = Feature::getFeature(Configuration::get('PS_LANG_DEFAULT'), $feature_id);
		$val = 0;
		foreach ($languages AS $language)
			if ($val = Tools::getValue('custom_'.$feature_id.'_'.$language['id_lang']))
			{

				$currentLanguage = new Language($language['id_lang']);
				if (Tools::strlen($val) > $rules['sizeLang']['value'])
					$this->_errors[] = Tools::displayError('name for feature').' <b>'.$feature['name'].'</b> '.Tools::displayError('is too long in').' '.$currentLanguage->name;
				elseif (!call_user_func(array('Validate', $rules['validateLang']['value']), $val))
					$this->_errors[] = Tools::displayError('Valid name required for feature.').' <b>'.$feature['name'].'</b> '.Tools::displayError('in').' '.$currentLanguage->name;
				if (sizeof($this->_errors))
					return (0);

				// Getting default language
				if ($language['id_lang'] == Configuration::get('PS_LANG_DEFAULT'))
					return ($val);
			}
		return (0);
	}
	public static function getFeatureValuesWithLang($id_lang, $id_feature,$query = false,$start = false,$limit = false,$count = false)
	{
		if($count) {
			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
			SELECT COUNT(v.`id_feature_value`) AS nb
			FROM `'._DB_PREFIX_.'feature_value` v
			WHERE v.`id_feature` = '.(int)$id_feature.' AND (v.`custom` IS NULL OR v.`custom` = 0)');
			return (int)($result['nb']);
		}
		return Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'feature_value` v
		LEFT JOIN `'._DB_PREFIX_.'feature_value_lang` vl ON (v.`id_feature_value` = vl.`id_feature_value` AND vl.`id_lang` = '.(int)$id_lang.')
		WHERE v.`id_feature` = '.(int)$id_feature.' AND (v.`custom` IS NULL OR v.`custom` = 0) '.($query ? ' AND vl.value LIKE "%'.pSQL($query).'%"':'').'
		ORDER BY vl.`value` ASC
		'.($limit? 'LIMIT '.$start.', '.(int)$limit : ''));
	}
	public function pm_getFeatureValues() {
		global $cookie;
		$id_feature = Tools::getValue('id_feature', false);
		$query = urldecode(Tools::getValue('q', false));
		self::_cleanBuffer();
		$limit = Tools::getValue('limit', 100);
		$start = Tools::getValue('start', 0);
		$featureValues = self::getFeatureValuesWithLang((int)$cookie->id_lang, $id_feature,$query,$start,$limit);
		// try utf8 decode (prevent empty result with accents in query string
		if (!sizeof($featureValues))
			$featureValues = self::getFeatureValuesWithLang((int)$cookie->id_lang, $id_feature,utf8_encode($query),$start,$limit);
			
		$nbFeatureValue = self::getFeatureValuesWithLang(false, $id_feature,false,false,false,true);
		if($featureValues) {
				foreach($featureValues as $row)
					$this->_html .= $row['id_feature_value']. '=' .$row['value']. "\n";
			if ($nbFeatureValue > ($start + $limit))
				$this->_html .= 'DisplayMore' . "\n";
		}

		self::_cleanBuffer();
		echo $this->_html;
		die();
	}
	public static function getProductFeaturesStatic($id_product, $id_lang)
	{
			return Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
			SELECT fp.id_feature, fp.id_product, fp.id_feature_value, vl.value, v.custom
			FROM `'._DB_PREFIX_.'feature_product` fp
			LEFT JOIN `'._DB_PREFIX_.'feature_value` v ON (fp.`id_feature_value` = v.`id_feature_value`)
			LEFT JOIN `'._DB_PREFIX_.'feature_value_lang` vl ON (v.`id_feature_value` = vl.`id_feature_value` AND vl.`id_lang` = '.(int)$id_lang.')
			WHERE fp.`id_product` = '.(int)$id_product);
	}
	
	/*
	To add to product.tpl, before "{foreach from=$features item=feature}" :
	{* Multiple Features *}
	{assign var="features" value=Module::getInstanceByName('pm_multiplefeatures')->getFrontFeatures($product->id, ', ')}
	{* /Multiple Features *}
	*/
	public function getFrontFeatures($id_product, $separator = ', ') {
		global $id_lang;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) $id_lang = (int)Context::getContext()->cookie->id_lang;
		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT fp.id_feature, vl.value, fl.name
		FROM `'._DB_PREFIX_.'feature_product` fp
		LEFT JOIN `'._DB_PREFIX_.'feature_value` v ON (fp.`id_feature_value` = v.`id_feature_value`)
		LEFT JOIN `'._DB_PREFIX_.'feature_value_lang` vl ON (v.`id_feature_value` = vl.`id_feature_value` AND vl.`id_lang` = '.(int)$id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'feature` f ON (f.`id_feature` = v.`id_feature`)
		'.(version_compare(_PS_VERSION_, '1.5.0.0', '>=') && Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP ? Shop::addSqlAssociation('feature', 'f') : '').'
		LEFT JOIN `'._DB_PREFIX_.'feature_lang` fl ON (fl.`id_feature` = f.`id_feature` AND fl.`id_lang` = '.(int)$id_lang.')
		WHERE fp.`id_product` = '.(int)$id_product);
		$return = array();
		if ($result && is_array($result) && sizeof($result)) {
			foreach ($result as $row) {
				$return[$row['id_feature']]['values'][] = $row['value'];
				$return[$row['id_feature']]['name'] = $row['name'];
			}
			foreach ($return as $key=>$row) $return[$key]['value'] = implode($separator, $row['values']);
		}
		return $return;
	}
	
	private static function getFeatures($id_lang)
	{
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
			return Feature::getFeatures($id_lang, (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP));
		} else {
			return Db::getInstance()->ExecuteS('
			SELECT *
			FROM `'._DB_PREFIX_.'feature` f
			LEFT JOIN `'._DB_PREFIX_.'feature_lang` fl ON (f.`id_feature` = fl.`id_feature` AND fl.`id_lang` = '.(int)$id_lang.')
			ORDER BY fl.`name` ASC');
		}
	}
	
	function displayFormFeatures($obj)
	{
		global $cookie, $currentIndex;

		if(version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
			include_once(PS_ADMIN_DIR.'/tabs/AdminCatalog.php');
			$adminTabCatalog = new AdminCatalog();
			$adminTabCatalog->displayForm();
		}else
			echo '<input type="hidden" value="Features" name="submitted_tabs[]">';

		if ($obj->id)
		{
			$feature = self::getFeatures((int)($cookie->id_lang));
			
			if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
				echo '
				<div id="product-features" class="panel product-tab">
					<h3>'.$this->l('Assign features to this product:').'</h3>
					<div class="alert alert-info">
						'.$this->l('You can specify a value for each relevant feature regarding this product, empty fields will not be displayed.').'<br />
						'.$this->l('You can either set a specific value, or select among existing pre-defined values you added previously.').'
					</div>
				';
			} else {
				echo '
				<table cellpadding="5">
					<tr>
						<td colspan="2">
							<b>'.$this->l('Assign features to this product:').'</b><br />
							<ul style="margin: 10px 0 0 20px;">
								<li>'.$this->l('You can specify a value for each relevant feature regarding this product, empty fields will not be displayed.').'</li>
								<li>'.$this->l('You can either set a specific value, or select among existing pre-defined values you added previously.').'</li>
							</ul>
						</td>
					</tr>
				</table>
				<hr style="width:100%;" /><br />';
			}
			// Header
			$nb_feature = Feature::nbFeatures((int)($cookie->id_lang));
			
			if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
				echo '
				<table class="table">
					<thead>
						<tr>
							<th><span class="title_box">'.$this->l('Feature').'</span></td>
							<th><span class="title_box">'.$this->l('Pre-defined values').'</span></td>
							<th><span class="title_box"><u>'.$this->l('or').'</u> '.$this->l('Customized value').'</span></td>
						</tr>
					</thead>';
				if (!$nb_feature)
					echo '
					<tbody>
						<tr>
							<td colspan="3" style="text-align:center;">'.$this->l('No features defined').'</td>
						</tr>
					</tbody>';
			} else {
				echo '
				<table border="0" class="table" style="width:100%;" cellpadding="0" cellspacing="0">
					<tr>
						<th style="width:20%">'.$this->l('Feature').'</td>
						<th style="width:51%" align="center">'.$this->l('Pre-defined values').' <u>'.$this->l('or').'</u> '.$this->l('Customized value').'</td>
					</tr>';
				if (!$nb_feature)
					echo '<tr><td colspan="2" style="text-align:center;">'.$this->l('No features defined').'</td></tr>';
				echo '</table>';
			}
			
			// Listing
			if ($nb_feature) {
				if (version_compare(_PS_VERSION_, '1.6.0.0', '>='))
					echo '<tbody>';
				
				foreach ($feature AS $tab_features) {
					if(version_compare(_PS_VERSION_, '1.6.0.0', '<')) {
						echo '<table cellpadding="5" style="width:100%;background-color:#fff; width: 100%;border:1px solid #ccc; border-top:none; padding:4px 6px;" cellpadding="0" cellspacing="10">';
					}
					$current_item = false;
					$current_items = array();
					$custom = true;
					foreach (self::getProductFeaturesStatic($obj->id, (int)($cookie->id_lang)) as $tab_products)
						if ($tab_products['id_feature'] == $tab_features['id_feature']) {
							$current_item = $tab_products['id_feature_value'];
							if(!$tab_products['custom'])
								$current_items[$tab_products['id_feature_value']] = $tab_products['value'];
						}
					$featureValues = self::getFeatureValuesWithLang((int)$cookie->id_lang, (int)$tab_features['id_feature'],false,0,1);
					if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
						echo '<tr><td>'.$tab_features['name'].'</td>';
						echo '<td>';
					} else {
						echo '<tr>
							<td style="width: 20%;" valign="top">'.$tab_features['name'].'</td>
							<td>
								<p><b>'.$this->l('Pre-defined values').'</b></p>';
					}
					if (sizeof($featureValues)) {
						echo '<select style="width: 700px; height: 150px;" id="multiselect' . $tab_features['id_feature'] . '" class="multiselect" multiple="multiple" name="feature_'.$tab_features['id_feature'].'_value[]">';
						foreach ($current_items AS $id_feature_value => $value) {
							if ($current_item == $id_feature_value)
								$custom = false;
							echo '<option value="'.$id_feature_value.'" selected="selected">'.$value.'</option>';
						}
						echo '</select>';
						$remoteUrl = (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? $currentIndex.'?' : $_SERVER['SCRIPT_NAME'].(($controller = Tools::getValue('controller')) ? '?controller='.$controller.'&': '')) . 'getFeatureValues=1&token=' . Tools::getValue('token') . '&id_feature='.(int)$tab_features['id_feature'];

						echo '
							<script type="text/javascript">
								$(document).ready(function() {
									$("#multiselect' . $tab_features['id_feature'] . '").multiselect({
										remoteUrl: "' . $remoteUrl.'",
										remoteLimit:10,
										remoteStart:0,
										dividerLocation: 0.4,
										searchAtStart:true,
										sInputShowMore:"' . $this->l('Show more') . '",
										sInputSearch:"",
										remoteLimitIncrement:200
									}).bind("change",function() {
										$(this).parent("td").find("textarea").val("");
									});
								});
							</script>';
					} else {
						echo '<input type="hidden" name="feature_'.$tab_features['id_feature'].'_value" value="0" />';
						if (version_compare(_PS_VERSION_, '1.6.0.0', '>='))
							echo '<span style="font-size: 10px; color: #666;">'.$this->l('N/A').' - <a class="confirm_leave btn btn-link" href="index.php?tab=AdminFeatures&addfeature_value&id_feature='.(int)$tab_features['id_feature'].'&token='.Tools::getAdminToken('AdminFeatures'.(int)(Tab::getIdFromClassName('AdminFeatures')).(int)($cookie->id_employee)).'"><i class="icon-plus-sign"/> '.$this->l('Add pre-defined values first').' <i class="icon-external-link-sign"/></a></span>';
						else
							echo '<span style="font-size: 10px; color: #666;">'.$this->l('N/A').' - <a href="index.php?tab=AdminFeatures&addfeature_value&id_feature='.(int)$tab_features['id_feature'].'&token='.Tools::getAdminToken('AdminFeatures'.(int)(Tab::getIdFromClassName('AdminFeatures')).(int)($cookie->id_employee)).'" style="color: #666; text-decoration: underline;">'.$this->l('Add pre-defined values first').'</a></span>';
					}
					if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
						echo '<td class="translatable">';
					} else {
						echo '
									<br />
								</td>
							</tr>
							<tr>
								<td></td>
								<td class="translatable">';
						echo '<p><b><u>'.$this->l('or').'</u> '.$this->l('Customized value').'</b></p>';
					}
					$tab_customs = ($custom ? FeatureValue::getFeatureValueLang($current_item) : array());
					foreach ($this->_languages as $language)
						echo '
							<div class="lang_'.$language['id_lang'].'" style="display: '.($language['id_lang'] == $this->_defaultFormLanguage ? 'block' : 'none').'; float: left;">
								<textarea class="custom_'.$tab_features['id_feature'].'_" name="custom_'.$tab_features['id_feature'].'_'.$language['id_lang'].'" cols="40" rows="1"
									onkeyup="if (isArrowKey(event)) return ;if($(\'#multiselect' . $tab_features['id_feature'] . ' option:selected\').length)$(\'#multiselect' . $tab_features['id_feature'] . '\').next(\'.ui-multiselect\').find(\'a.remove-all\').trigger(\'click\');" onkeydown="if (isArrowKey(event)) return ;if($(\'#multiselect' . $tab_features['id_feature'] . ' option:selected\').length)$(\'#multiselect' . $tab_features['id_feature'] . '\').next(\'.ui-multiselect\').find(\'a.remove-all\').trigger(\'click\');" >'.htmlentities(Tools::getValue('custom_'.$tab_features['id_feature'].'_'.$language['id_lang'], FeatureValue::selectLang($tab_customs, $language['id_lang'])), ENT_COMPAT, 'UTF-8').'</textarea>
							</div>';

					echo '
						</td>
					</tr>';
					if (version_compare(_PS_VERSION_, '1.6.0.0', '<'))
						echo '</table>';
				}
				if (version_compare(_PS_VERSION_, '1.6.0.0', '>='))
					echo '</tbody>';
				else if (version_compare(_PS_VERSION_, '1.5.0.0', '<'))
					echo '
					<table cellpadding="5" style="width:100%;background-color:#fff; width: 100%;border:1px solid #ccc; border-top:none;  padding:4px 6px;" cellpadding="0" cellspacing="10">
						<tr>
							<td style="height: 50px; text-align: center;" colspan="3">
								<input type="submit" name="submitProductFeature" id="submitProductFeature" value="'.$this->l('Save modifications').'" class="button" />
							</td>
						</tr>
					</table>';
			}
			
			if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
				echo '
					</table>
					<a class="btn btn-link confirm_leave button" href="index.php?tab=AdminFeatures&addfeature&token='.Tools::getAdminToken('AdminFeatures'.(int)(Tab::getIdFromClassName('AdminFeatures')).(int)($cookie->id_employee)).'"><i class="icon-plus-sign" /> '.$this->l('Add a new feature').' <i class="icon-external-link-sign" /></a>
					<div class="panel-footer">
						<a class="btn btn-default" href="index.php?tab=AdminProducts&token='.Tools::getAdminToken('AdminProducts'.(int)(Tab::getIdFromClassName('AdminProducts')).(int)($cookie->id_employee)).'"><i class="process-icon-cancel" /> '.$this->l('Cancel').'</a>
						<button class="btn btn-default pull-right" name="submitAddproduct" type="submit"><i class="process-icon-save" /> '.$this->l('Save').'</button>
						<button class="btn btn-default pull-right" name="submitAddproductAndStay" type="submit"><i class="process-icon-save" /> '.$this->l('Save and stay').'</button>
					</div>
				</div>
				<style type="text/css">td.translatable div.language_flags { display: none; }</style>';
			} else {
				echo '
				<hr style="width:100%;" />
				<div style="text-align:center;">
					<a href="index.php?tab=AdminFeatures&addfeature&token='.Tools::getAdminToken('AdminFeatures'.(int)(Tab::getIdFromClassName('AdminFeatures')).(int)($cookie->id_employee)).'" onclick="return confirm(\''.$this->l('You will lose all modifications not saved, you may want to save modifications first?', __CLASS__, true, false).'\');"><img src="../img/admin/add.gif" alt="new_features" title="'.$this->l('Add a new feature').'" />&nbsp;'.$this->l('Add a new feature').'</a>
				</div>';
			}
		} else {
			echo '<b>'.$this->l('You must save this product before adding features').'.</b>';
		}
	}
	protected function isTabSubmitted($tab_name)
	{
		if (!is_array($this->submitted_tabs))
			$this->submitted_tabs = Tools::getValue('submitted_tabs');

		if (is_array($this->submitted_tabs) && in_array($tab_name, $this->submitted_tabs))
			return true;

		return false;
	}
	protected function deleteTabSubmitted($tab_name)
	{
		if (!is_array($this->submitted_tabs))
			$this->submitted_tabs = Tools::getValue('submitted_tabs');

		if (is_array($this->submitted_tabs) && in_array($tab_name, $this->submitted_tabs)) {
			unset($_POST['submitted_tabs'][array_search($tab_name, $_POST['submitted_tabs'])]);
		}

		return;
	}
	public function hookBackOfficeHeader($params) {
		global $currentIndex;

		//Display features form
		if(Tools::getValue('getFeatureMultiplePanel') == 1 || ((Tools::getValue('controller') == 'adminproducts' || Tools::getValue('controller') == 'AdminProducts') && Tools::getValue('id_product') && (isset($_GET ['updateproduct']) || isset($_GET['addproduct'])) && isset($_GET['ajax']) && Tools::getValue('action') == 'Features')) {
			$id_product = Tools::getValue('id_product');
			$obj = new Product($id_product);
			$this->_languages = Language::getLanguages(false);
			$this->_defaultFormLanguage = intval(Configuration::get('PS_LANG_DEFAULT'));
			$this->displayFormFeatures($obj);
			die;
		}elseif(Tools::getValue('getFeatureValues') == 1) {
			$this->pm_getFeatureValues();
			die;
		}
		//Features save process
		elseif((version_compare(_PS_VERSION_, '1.5.0.0', '<') && Tools::isSubmit('submitProductFeature')) || (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && $this->isTabSubmitted('Features'))) {
			if (Validate::isLoadedObject($product = new Product((int)(Tools::getValue('id_product')))))
			{

				// delete all objects
				$product->deleteFeatures();

				// add new objects
				$languages = Language::getLanguages(false);
				foreach ($_POST AS $key => $val)
				{

					if (preg_match('/^(?:feature|custom)_([0-9]+)_(value|[0-9]+)/i', $key, $match))
					{

						if (preg_match('/^feature/i', $key) && ((is_array($val) && sizeof($val)) || (!is_array($val) && $val))) {

							if(is_array($val))
								foreach($val as $val2) {
									$product->addFeaturesToDB($match[1], $val2);
								}
							else
								$product->addFeaturesToDB($match[1], $val);
						}
						else if(preg_match('/^custom/i', $key) && $match[2] == Configuration::get('PS_LANG_DEFAULT') && $val)
						{

							if ($default_value = $this->checkFeatures($languages, $match[1]))
							{
								$id_value = $product->addFeaturesToDB($match[1], 0, 1);
								foreach ($languages AS $language)
								{
									if ($cust = Tools::getValue('custom_'.$match[1].'_'.(int)$language['id_lang'])) {
										$product->addFeaturesCustomToDB($id_value, (int)$language['id_lang'], $cust);
									}
									else {
										$product->addFeaturesCustomToDB($id_value, (int)$language['id_lang'], $default_value);
									}
								}
							}
						}
					}
				}
				if(version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
					Tools::redirectAdmin($currentIndex.'&id_product='.(int)$product->id.'&id_category='.(!empty($_REQUEST['id_category'])?$_REQUEST['id_category']:'1').'&addproduct&tabs=4&conf=4&token='.Tools::getValue('token'));
					die;
				}else {
					//Delete post flag to avoid double save (PS 1.5)
					$this->deleteTabSubmitted('Features');
				}
			}
		}
		//Delete "key_tab" GET var to avoid natif load of feature tab (PS 1.5)
		elseif(Tools::getValue('key_tab')=='Features') {
			$_GET['key_tab_onload'] = 'Features';
			unset($_GET['key_tab']);
		}

	}
	public function hookBackOfficeTop($params) {
		global $currentIndex;

		//Override feature tab on product edition
		if ((Tools::getValue('tab') == 'AdminCatalog' && Tools::getValue('id_product') && (isset($_GET ['updateproduct']) || isset($_GET['addproduct'])))
			|| (Tools::getValue('controller') == 'adminproducts' || Tools::getValue('controller') == 'AdminProducts') && Tools::getValue('id_product') && (isset($_GET ['updateproduct']) || isset($_GET['addproduct'])) && !isset($_GET['ajax'])) {
			$this->_base_config_url = (version_compare(_PS_VERSION_, '1.5.0.0', '<') ? $currentIndex : $_SERVER['SCRIPT_NAME'].(($controller = Tools::getValue('controller')) ? '?controller='.$controller: '')) . '&getFeatureMultiplePanel=1&token=' . Tools::getValue('token');
			$return = '<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />';

			if (version_compare(_PS_VERSION_, '1.5.0.0', '<'))
				$return .= '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>';

			$return .= '<link type="text/css" rel="stylesheet" href="' . $this->_path . 'js/multiselect/ui.multiselect.css" />
						 <script type="text/javascript" src="' . $this->_path . 'js/multiselect/jquery.tmpl.1.1.1.js"></script>
						 <script type="text/javascript" src="' . $this->_path . 'js/multiselect/jquery.blockUI.js"></script>
						 <script type="text/javascript" src="' . $this->_path . 'js/multiselect/ui.multiselect.js"></script>';

			if(version_compare(_PS_VERSION_, '1.5.0.0', '<')) {
				$return .= '<script type="text/javascript">';
				$return .= '$(window).load(function() {';
				$return .= '
					// Makes sure that CSS are correctly loaded...
					$("head").append("<link type=\"text/css\" rel=\"stylesheet\" href=\"' . $this->_path . 'js/multiselect/ui.multiselect.css\" />");
					$("head").append("<link type=\"text/css\" rel=\"stylesheet\" href=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css\" />");
					var curIOverrideFeatureTab = 1;
					var timer = setInterval(function() {
					$("form#product #tabPane1 .tab-row .tab:eq(4) a").unbind("click").bind("click",function() {
						toload[5] = false;
						$("#step5").load("'.$_SERVER['SCRIPT_NAME'].'?token='.Tools::getValue('token').'&getFeatureMultiplePanel=1&id_product='.Tools::getValue('id_product').'",function() {
							var languages = new Array();
							$("#tabPane1 .tab-page").hide();
							$("#tabPane1 .tab-row .tab").removeClass("selected");
							$("#step5").show();
							$("form#product #tabPane1 .tab-row .tab:eq(4)").addClass("selected");
							$("input#tabs").val(4);
						});
						return true;
					});
					$("form#product #tabPane1 .tab-row .tab:not(:eq(4)) a").unbind("click").bind("click",function() {
						$("form#product #tabPane1 .tab-row .tab:eq(4)").removeClass("selected");
					});
					if(curIOverrideFeatureTab > 20) {
						clearInterval(timer);
					}
					curIOverrideFeatureTab++;
				}, 100);';
				if(Tools::getValue('tabs') == 4) {
					$return .= '
					pos_select = 0;
					setTimeout( function() {
						var languages = new Array();
						$("#tabPane1 .tab-page").hide();
						$("#tabPane1 .tab-row .tab").removeClass("selected");
						$("#step5").show();
						$("form#product #tabPane1 .tab-row .tab:eq(4)").addClass("selected");
						$("input#tabs").val(4);
						$("form#product #tabPane1 .tab-row .tab:eq(4) a").trigger("click");
					},500);';
				}
				$return .= '});</script>';
				echo $return;
			} else {
				//load overrided Feature Tab
				if(Tools::getValue('key_tab_onload')=='Features') {
					$return .= '<script type="text/javascript">';
					$return .= '$(window).load(function() {';
					$return .= '$(".productTabs .tab-row #link-Features").trigger("click");';
					$return .= '});</script>';
				}
				return $return;
			}
		}
	}
	// Begin _cleanBuffer()
	private static function _cleanBuffer() {
		if (ob_get_length() > 0) ob_clean();
	}
	// End _cleanBuffer()
}