<?php
/**
 * Copyright 2015 Lengow SAS.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 *  @author    Team Connector <team-connector@lengow.com>
 *  @copyright 2015 Lengow SAS
 *  @license   http://www.apache.org/licenses/LICENSE-2.0
 */

$sep = DIRECTORY_SEPARATOR;
require_once dirname(__FILE__).$sep.'..'.$sep.'loader.php';
try
{
	loadFile('option');
	loadFile('connector');
	loadFile('marketplace');
	loadFile('marketplacev2');
} catch(Exception $e)
{
	echo date('Y-m-d : H:i:s ').$e->getMessage().'<br />';
}

/**
 * The Lengow Core Class.
 *
 * @author Team Connector <team-connector@lengow.com>
 * @copyright 2015 Lengow SAS
 */
class LengowCoreAbstract
{

	/**
	 * Version.
	 */
	const VERSION = '1.0.0';

	/**
	 * @var LengowLog Lengow log file instance
	 */
	public static $log;

	/**
	* Registers.
	*/
	public static $registers;

	/**
	* Registers V2
	*/
	public static $registers_v2;

	/**
	 * @var integer	life of log files in days
	 */
	public static $LOG_LIFE = 7;

	/**
	 * @var array 	Lengow tracker types.
	 */
	public static $TRACKER_LENGOW = array(
		'none' => 'No tracker',
		'simpletag' => 'SimpleTag'
	);

	/**
	 * @var array 	Lengow tracker types V2
	 */
	public static $TRACKER_LENGOW_V2 = array(
		'none' => 'No tracker',
		'tagcapsule' => 'TagCapsule',
		'simpletag' => 'SimpleTag'
	);

	/**
	 * @var array 	product ids available to track products
	 */
	public static $TRACKER_CHOICE_ID = array(
		'id' => 'Product ID',
		'ean' => 'Product EAN',
		'upc' => 'Product UPC',
		'ref' => 'Product Reference',
	);

	/**
	 * @var array 	Lengow shipping types
	 */
	public static $SHIPPING_LENGOW = array(
		'lengow' => 'Lengow',
		'marketplace' => 'Markeplace\'s name',
	);

	/**
	 * Lengow Authorized IPs
	 */
	protected static $IPS_LENGOW = array(
		'46.19.183.204',
		'46.19.183.218',
		'46.19.183.222',
		'89.107.175.172',
		'89.107.175.186',
		'185.61.176.129',
		'185.61.176.130',
		'185.61.176.131',
		'185.61.176.132',
		'185.61.176.133',
		'185.61.176.134',
		'185.61.176.137',
		'185.61.176.138',
		'185.61.176.139',
		'185.61.176.140',
		'185.61.176.141',
		'185.61.176.142',
		'95.131.137.18',
		'95.131.137.19',
		'95.131.137.21',
		'95.131.137.26',
		'95.131.137.27',
		'88.164.17.227',
		'88.164.17.216',
		'109.190.78.5',
		'95.131.141.168',
		'95.131.141.169',
		'95.131.141.170',
		'95.131.141.171',
		'82.127.207.67',
		'80.14.226.127',
		'80.236.15.223',
		'92.135.36.234',
		'81.64.72.170',
		'80.11.36.123'
	);

	/**
	* Lengow XML Marketplace configuration.
	*/
	private static $MP_CONF_LENGOW = 'http://kml.lengow.com/mp.xml';
	public static $image_type_cache;

	protected static $LENGOW_CONFIG_FOLDER = 'config';

	/**
	* Lengow XML Plugins status
	*/
	public static $LENGOW_PLUGINS_VERSION = 'http://kml.lengow.com/plugins.xml';

	/**
	 * The Prestashop compare version with current version.
	 *
	 * @param varchar $version The version to compare
	 *
	 * @return boolean The comparaison
	 */
	public static function compareVersion($version = '1.4')
	{
		$sub_version = Tools::substr(_PS_VERSION_, 0, 3);
		return version_compare($sub_version, $version);
	}

	/**
	 * Get lengow folder path
	 *
	 * @return string
	 */
	public static function getLengowFolder()
	{
		return _PS_MODULE_DIR_.'lengow';
	}

	/**
	* Get available export formats
	*
	* @return array Formats
	*/
	public static function getExportFormats()
	{
		$array_formats = array();
		foreach (LengowFeed::$AVAILABLE_FORMATS as $value)
			$array_formats[] = new LengowOption($value, $value);
		return $array_formats;
	}

	public static function getFeaturesOptions()
	{
		$features_options = array();
		$features = Feature::getFeatures(Context::getContext()->language->id);
		foreach ($features as $feature)
			$features_options[] = new LengowOption($feature['id_feature'], $feature['name']);
		return $features_options;
	}

	/**
	 * Get Lengow ID Account.
	 *
	 * @return integer
	 */
	public static function getIdAccount()
	{
		return Configuration::get('LENGOW_ID_ACCOUNT');
	}

	/**
	 * Get access token
	 *
	 * @return string
	 */
	public static function getAccessToken()
	{
		return Configuration::get('LENGOW_ACCESS_TOKEN');
	}

	/**
	 * Get the secret.
	 *
	 * @return string
	 */
	public static function getSecretCustomer()
	{
		return Configuration::get('LENGOW_SECRET');
	}

	public static function getImportMarketplaces()
	{
		$marketplaces = Tools::jsonDecode(Configuration::get('LENGOW_IMPORT_MARKETPLACES'));
		if (empty($marketplaces))
			$marketplaces = array();
		return $marketplaces;
	}

	/**
	 * Get the matching Prestashop order state id to the one given
	 *
	 * @param string $state	state to be matched
	 *
	 * @return integer
	 */
	public static function getOrderState($state)
	{
		switch ($state)
		{
			case 'accepted':
			case 'waiting_shipment':
				return Configuration::get('LENGOW_ORDER_ID_PROCESS');
				break;
			case 'shipped':
			case 'closed':
				return Configuration::get('LENGOW_ORDER_ID_SHIPPED');
				break;
			case 'refused':
			case 'canceled':
				return Configuration::get('LENGOW_ORDER_ID_CANCEL');
				break;
			case 'shippedByMp':
				return Configuration::get('LENGOW_ORDER_ID_SHIPPEDBYMP');
				break;
		}
		return false;
	}

	/**
	 * Temporary disable mail sending
	 */
	public static function disableMail()
	{
		if (_PS_VERSION_ < '1.5.4.0')
		{
			Configuration::set('PS_MAIL_METHOD', 2);
			// Set fictive stmp server to disable mail
			Configuration::set('PS_MAIL_SERVER', 'smtp.lengow.com');
		}
		else
			Configuration::set('PS_MAIL_METHOD', 3);
	}

	/**
	 * The image export format used.
	 *
	 * @return varchar Format
	 */
	public static function getImageFormat()
	{
		if (LengowCore::$image_type_cache)
			return LengowCore::$image_type_cache;
		$id_type_image = Configuration::get('LENGOW_IMAGE_TYPE');
		$image_type = new ImageType($id_type_image);
		LengowCore::$image_type_cache = $image_type->name;
		return LengowCore::$image_type_cache;
	}

	/**
	 * Get tracker options.
	 *
	 * @return array
	 */
	public static function getTrackers()
	{
		$array_tracker = array();
		$trackers = Configuration::get('LENGOW_SWITCH_V3') ? self::$TRACKER_LENGOW : self::$TRACKER_LENGOW_V2;
		foreach ($trackers as $name => $value)
			$array_tracker[] = new LengowOption($name, $value);
		return $array_tracker;
	}

	/**
	 * Get tracker id options
	 *
	 * @return array
	 */
	public static function getTrackerChoiceId()
	{
		$array_choice_id = array();
		foreach (self::$TRACKER_CHOICE_ID as $name => $value)
			$array_choice_id[] = new LengowOption($name, $value);
		return $array_choice_id;
	}

	/**
	 * The images number to export.
	 *
	 * @return array Images count option
	 */
	public static function getImagesCount()
	{
		$lengow = new Lengow();
		$array_images = array(new LengowOption('all', $lengow->l('All images')));
		for ($i = 3; $i < 11; $i++)
			$array_images[] = new LengowOption($i, $lengow->l($i.' image'.($i > 1 ? 's' : '')));
		return $array_images;
	}

	/**
	 * The shipping names options.
	 *
	 * @return array Lengow shipping names option
	 */
	public static function getShippingName()
	{
		$array_shipping = array();
		foreach (self::$SHIPPING_LENGOW as $name => $value)
			$array_shipping[] = new LengowOption($name, $value);
		return $array_shipping;
	}

	/**
	 * Get export shipping carrier chose in config
	 *
	 * @return LengowCarrier
	 */
	public static function getExportCarrier()
	{
		$id_carrier = Configuration::get('LENGOW_CARRIER_DEFAULT');
		return new LengowCarrier($id_carrier);
	}

	/**
	 * The shipping names options.
	 *
	 * @return array Lengow shipping names option
	 */
	public static function getMarketplaceSingleton($name)
	{
		if (!isset(LengowCore::$registers[$name]))
			LengowCore::$registers[$name] = new LengowMarketplace($name);
		return LengowCore::$registers[$name];
	}

	/**
	 * Clean html.
	 *
	 * @param string $html The html content
	 *
	 * @return string Text cleaned.
	 */
	public static function cleanHtml($html)
	{
		$string = str_replace('<br />', '', nl2br($html));
		$string = trim(strip_tags(htmlspecialchars_decode($string)));
		$string = preg_replace('`[\s]+`sim', ' ', $string);
		$string = preg_replace('`"`sim', '', $string);
		$string = nl2br($string);
		$pattern = '@<[\/\!]*?[^<>]*?>@si'; //nettoyage du code HTML
		$string = preg_replace($pattern, ' ', $string);
		$string = preg_replace('/[\s]+/', ' ', $string); //nettoyage des espaces multiples
		$string = trim($string);
		$string = str_replace('&nbsp;', ' ', $string);
		$string = str_replace('|', ' ', $string);
		$string = str_replace('"', '\'', $string);
		$string = str_replace('’', '\'', $string);
		$string = str_replace('&#39;', '\' ', $string);
		$string = str_replace('&#150;', '-', $string);
		$string = str_replace(chr(9), ' ', $string);
		$string = str_replace(chr(10), ' ', $string);
		$string = str_replace(chr(13), ' ', $string);
		return $string;
	}

	/**
	 * Clean data
	 *
	 * @param 	string $value The content
	 * 
	 * @return 	string
	 */
	public static function cleanData($value)
	{
		$value = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
				'|[\x00-\x7F][\x80-\xBF]+'.
				'|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
				'|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
				'|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S', '', $value);
		$value = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]'.
				'|\xED[\xA0-\xBF][\x80-\xBF]/S', '', $value);
		$value = preg_replace('/[\s]+/', ' ', $value);
		$value = trim($value);
		$value = str_replace(
			array(
				'&nbsp;',
				'|',
				'"',
				'’',
				'&#39;',
				'&#150;',
				chr(9),
				chr(10),
				chr(13),
				chr(31),
				chr(30),
				chr(29),
				chr(28),
				"\n",
				"\r"
			), array(
			' ',
			' ',
			'\'',
			'\'',
			' ',
			'-',
			' ',
			' ',
			' ',
			'',
			'',
			'',
			'',
			'',
			''
		), $value);
		return $value;
	}

	/**
	 * Format float.
	 *
	 * @param float $float The float to format
	 *
	 * @return float Float formated
	 */
	public static function formatNumber($float)
	{
		return number_format(round($float, 2), 2, '.', '');
	}

	/**
	 * Get host for generated email.
	 *
	 * @return string Hostname
	 */
	public static function getHost()
	{
		$domain = defined('_PS_SHOP_DOMAIN_') ? _PS_SHOP_DOMAIN_ : _PS_BASE_URL_;
		preg_match('`([a-zàâäéèêëôöùûüîïç0-9-]+\.[a-z]+$)`', $domain, $out);
		if ($out[1])
			return $out[1];
		return $domain;
	}

	/**
	 * Check if current IP is authorized.
	 *
	 * @return boolean.
	 */
	public static function checkIP()
	{
		$ips = Configuration::get('LENGOW_AUTHORIZED_IP');
		$ips = trim(str_replace(array("\r\n", ',', '-', '|', ' '), ';', $ips), ';');
		$ips = explode(';', $ips);
		$authorized_ips = array_merge($ips, LengowCore::$IPS_LENGOW);
		$authorized_ips[] = $_SERVER['SERVER_ADDR'];
		$hostname_ip = $_SERVER['REMOTE_ADDR'];
		if (in_array($hostname_ip, $authorized_ips))
			return true;
		return false;
	}

	/**
	 * Check and update xml of plugins version
	 *
	 * @return boolean
	 */
	public static function updatePluginsVersion()
	{
		$plg_update = Configuration::get('LENGOW_PLG_CONF');
		if ((!$plg_update || $plg_update != date('Y-m-d')) && function_exists('curl_version'))
		{
			try
			{
				if ($plugins_stream = LengowFile::getRessource(self::$LENGOW_PLUGINS_VERSION, 'r'))
				{
					$plugins_file = new LengowFile(LengowCore::$LENGOW_CONFIG_FOLDER, LengowCheck::$XML_PLUGINS, 'w');
					stream_copy_to_stream($plugins_stream, $plugins_file->instance);
					$plugins_file->close();
					Configuration::updateValue('LENGOW_PLG_CONF', date('Y-m-d'));
				}
			} catch (LengowFileException $lfe)
			{
				LengowCore::log($lfe->getMessage(), false);
			}
		}
	}

	/**
	 * Writes log
	 *
	 * @param string	$txt 				log message
	 * @param boolean	$force_output 		output on screen
	 * @param string	$id_order_lengow	lengow order id
	 */
	public static function log($txt, $force_output = false, $id_order_lengow = null)
	{
		$log = LengowCore::getLogInstance();
		$log->write($txt, $force_output, $id_order_lengow);
	}

	/**
	 * Suppress log files when too old.
	 */
	public static function cleanLog()
	{
		$log_files = LengowLog::getFiles();

		$days = array();
		$days[] = 'logs-'.date('Y-m-d').'.txt';
		for ($i = 1; $i < LengowCore::$LOG_LIFE; $i++)
			$days[] = 'logs-'.date('Y-m-d', strtotime('-'.$i.'day')).'.txt';
		if (empty($log_files))
			return;
		foreach ($log_files as $log)
		{
			if (!in_array($log->file_name, $days))
				$log->delete();
		}
	}

	/**
	 * Clean phone number
	 *
	 * @param string $phone Phone to clean
	 */
	public static function cleanPhone($phone)
	{
		$replace = array('.', ' ', '-', '/');
		if (!$phone)
			return null;
		if (Validate::isPhoneNumber($phone))
			return str_replace($replace, '', $phone);
		else
			return str_replace($replace, '', preg_replace('/[^0-9]*/', '', $phone));
	}

	/**
	 * Replace all accented chars by their equivalent non accented chars.
	 *
	 * @param string $str string to have its characters replaced
	 *
	 * @return string
	 */
	public static function replaceAccentedChars($str)
	{
		/* One source among others:
		  http://www.tachyonsoft.com/uc0000.htm
		  http://www.tachyonsoft.com/uc0001.htm
		*/
		$patterns = array(
			/* Lowercase */
			/* a */ '/[\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}\x{0101}\x{0103}\x{0105}]/u',
			/* c */ '/[\x{00E7}\x{0107}\x{0109}\x{010D}]/u',
			/* d */ '/[\x{010F}\x{0111}]/u',
			/* e */ '/[\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{0113}\x{0115}\x{0117}\x{0119}\x{011B}]/u',
			/* g */ '/[\x{011F}\x{0121}\x{0123}]/u',
			/* h */ '/[\x{0125}\x{0127}]/u',
			/* i */ '/[\x{00EC}\x{00ED}\x{00EE}\x{00EF}\x{0129}\x{012B}\x{012D}\x{012F}\x{0131}]/u',
			/* j */ '/[\x{0135}]/u',
			/* k */ '/[\x{0137}\x{0138}]/u',
			/* l */ '/[\x{013A}\x{013C}\x{013E}\x{0140}\x{0142}]/u',
			/* n */ '/[\x{00F1}\x{0144}\x{0146}\x{0148}\x{0149}\x{014B}]/u',
			/* o */ '/[\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F8}\x{014D}\x{014F}\x{0151}]/u',
			/* r */ '/[\x{0155}\x{0157}\x{0159}]/u',
			/* s */ '/[\x{015B}\x{015D}\x{015F}\x{0161}]/u',
			/* ss */ '/[\x{00DF}]/u',
			/* t */ '/[\x{0163}\x{0165}\x{0167}]/u',
			/* u */ '/[\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{0169}\x{016B}\x{016D}\x{016F}\x{0171}\x{0173}]/u',
			/* w */ '/[\x{0175}]/u',
			/* y */ '/[\x{00FF}\x{0177}\x{00FD}]/u',
			/* z */ '/[\x{017A}\x{017C}\x{017E}]/u',
			/* ae */ '/[\x{00E6}]/u',
			/* oe */ '/[\x{0153}]/u',
			/* Uppercase */
			/* A */ '/[\x{0100}\x{0102}\x{0104}\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}]/u',
			/* C */ '/[\x{00C7}\x{0106}\x{0108}\x{010A}\x{010C}]/u',
			/* D */ '/[\x{010E}\x{0110}]/u',
			/* E */ '/[\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{0112}\x{0114}\x{0116}\x{0118}\x{011A}]/u',
			/* G */ '/[\x{011C}\x{011E}\x{0120}\x{0122}]/u',
			/* H */ '/[\x{0124}\x{0126}]/u',
			/* I */ '/[\x{0128}\x{012A}\x{012C}\x{012E}\x{0130}]/u',
			/* J */ '/[\x{0134}]/u',
			/* K */ '/[\x{0136}]/u',
			/* L */ '/[\x{0139}\x{013B}\x{013D}\x{0139}\x{0141}]/u',
			/* N */ '/[\x{00D1}\x{0143}\x{0145}\x{0147}\x{014A}]/u',
			/* O */ '/[\x{00D3}\x{014C}\x{014E}\x{0150}]/u',
			/* R */ '/[\x{0154}\x{0156}\x{0158}]/u',
			/* S */ '/[\x{015A}\x{015C}\x{015E}\x{0160}]/u',
			/* T */ '/[\x{0162}\x{0164}\x{0166}]/u',
			/* U */ '/[\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{0168}\x{016A}\x{016C}\x{016E}\x{0170}\x{0172}]/u',
			/* W */ '/[\x{0174}]/u',
			/* Y */ '/[\x{0176}]/u',
			/* Z */ '/[\x{0179}\x{017B}\x{017D}]/u',
			/* AE */ '/[\x{00C6}]/u',
			/* OE */ '/[\x{0152}]/u');

		// ö to oe
		// å to aa
		// ä to ae

		$replacements = array(
			'a', 'c', 'd', 'e', 'g', 'h', 'i', 'j', 'k', 'l', 'n', 'o', 'r', 's', 'ss', 't', 'u', 'y', 'w', 'z', 'ae', 'oe',
			'A', 'C', 'D', 'E', 'G', 'H', 'I', 'J', 'K', 'L', 'N', 'O', 'R', 'S', 'T', 'U', 'Z', 'AE', 'OE'
		);

		return preg_replace($patterns, $replacements, $str);
	}

	/**
	 * Check logs table and send mail for order not imported correctly
	 *
	 * @return void
	 */
	public static function sendMailAlert()
	{
		$cookie = Context::getContext()->cookie;
		$subject = 'Lengow imports logs';
		$mail_body = '';
		$sql_logs = 'SELECT `id`, `lengow_order_id`, `message` FROM `'._DB_PREFIX_.'lengow_logs_import` WHERE `is_finished` = 0 AND `mail` = 0';
		$logs = Db::getInstance()->ExecuteS($sql_logs);
		if (empty($logs))
			return true;
		foreach ($logs as $log)
		{
			$mail_body .= '<li>Order '.$log['lengow_order_id'];
			if ($log['message'] != '')
				$mail_body .= ' - '.$log['message'];
			else
				$mail_body .= ' - No error message, contact support via https://supportlengow.zendesk.com/agent/';
			$mail_body .= '</li>';
			LengowCore::logSent($log['id']);
		}
		$datas = array(
			'{mail_title}' => 'Lengow imports logs',
			'{mail_body}' => $mail_body,
		);
		$emails = explode(',', Configuration::get('LENGOW_EMAIL_ADDRESS'));
		if (empty($emails[0]))
			$emails[0] = Configuration::get('PS_SHOP_EMAIL');
		foreach ($emails as $to)
		{
			if (!Mail::send((int)$cookie->id_lang,
						'report',
						$subject,
						$datas,
						$to,
						null,
						null,
						null,
						null,
						null,
						_PS_MODULE_DIR_.'lengow/views/templates/mails/',
						true))
				LengowCore::log('Unable to send report email to '.$to);
			else
				LengowCore::log('Report email sent to '.$to);
		}
	}

	/**
	 * Mark log as sent by email
	 *
	 * @param integer $id_order_log
	 */
	public static function logSent($id_order_log)
	{
		$db = Db::getInstance();
		if (_PS_VERSION_ >= '1.5')
		{
			$db->update(
				'lengow_logs_import',
				array(
					'mail' => 1
				),
				'`id` = \''.$id_order_log.'\'',
				1
			);
		}
		else
		{
			$db->autoExecute(
				_DB_PREFIX_.'lengow_logs_import',
				array(
					'mail' => 1
				),
				'UPDATE',
				'`id` = \''.$id_order_log.'\'', 1
			);
		}
	}

	/**
	 * Check if a given module is installed and active
	 *
	 * @param string $module_name name of module
	 *
	 * @return boolean
	 */
	public static function isModuleInstalled($module_name)
	{
		if (!Module::isInstalled($module_name))
			return false;

		if (_PS_VERSION_ >= '1.5')
			if (!Module::isEnabled($module_name))
				return false;
		return true;
	}

	/**
	 * Check if Mondial Relay is installed, active and if version is supported
	 *
	 * @return boolean true if installed and active
	 */
	public static function isMondialRelayAvailable()
	{
		$module_name = 'mondialrelay';
		$supported_version = '2.1.0';
		$sep = DIRECTORY_SEPARATOR;
		$module_dir = _PS_MODULE_DIR_.$module_name.$sep;

		if (!LengowCore::isModuleInstalled($module_name))
			return false;

		require_once($module_dir.$module_name.'.php');
		$mr = new MondialRelay();
		if (version_compare($mr->version, $supported_version, '>='))
			return true;
		else
			return false;

	}

	/**
	 * Check is soColissimo is installed, activated and if version is supported
	 *
	 * @return boolean true if installed and active
	 */
	public static function isSoColissimoAvailable()
	{
		$module_name = 'socolissimo';
		$supported_version = '2.8.5';
		$sep = DIRECTORY_SEPARATOR;
		$module_dir = _PS_MODULE_DIR_.$module_name.$sep;

		if (!LengowCore::isModuleInstalled($module_name))
			return false;

		require_once($module_dir.$module_name.'.php');
		$soColissimo = new Socolissimo();
		if (version_compare($soColissimo->version, $supported_version, '>='))
			return true;
		else
			return false;
	}

	/**
	 * Get prestashop state id corresponding to the current order state
	 *
	 * @param string			$order_state	order state
	 * @param LengowMarketplace	$marketplace	order marketplace
	 * @param bool				$shipment_by_mp	order shipped by mp
	 *
	 * @return int
	 */
	public static function getPrestahopStateId($order_state, $marketplace, $shipment_by_mp)
	{
		if ($marketplace->getStateLengow($order_state) == 'shipped' || $marketplace->getStateLengow($order_state) == 'closed')
		{
			if ($shipment_by_mp)
				return LengowCore::getOrderState('shippedByMp');
			else
				return LengowCore::getOrderState('shipped');
		}
		else
			return LengowCore::getOrderState('accepted');
	}

	/**
	 * Get order state list
	 *
	 * @param int $id_lang
	 *
	 * @return array
	 */
	public static function getOrderStates($id_lang)
	{
		$states = OrderState::getOrderStates($id_lang);
		$id_state_lengow = LengowCore::getLengowErrorStateId();
		$index = 0;
		foreach ($states as $state)
		{
			if ($state['id_order_state'] == $id_state_lengow)
				unset($states[$index]);
			$index++;
		}
		return $states;
	}

	/**
	 * Get log Instance
	 *
	 * @return LengowLog
	 */
	public static function getLogInstance()
	{
		if (is_null(LengowCore::$log))
			LengowCore::$log = new LengowLog();
		return LengowCore::$log;
	}

	/**
	 * Get webservices links
	 *
	 * @return array
	 */
	public static function getWebservicesLinks()
	{
		$base = LengowCore::getLengowBaseUrl();
		$feed_export_url = $base.'webservice/export.php';
		$feed_import_url = $base.'webservice/import.php';
		return array('link_feed_export' => '<div class="lengow-margin"><a href="'.$feed_export_url.'" target="_blank">'.$feed_export_url.'</a></div>',
			'link_feed_import' => '<div class="lengow-margin"><a href="'.$feed_import_url.'" target="_blank">'.$feed_import_url.'</a></div>',
			'url_feed_export' => $feed_export_url,
			'url_feed_import' => $feed_import_url);
	}

	/**
	 * Get base url for Lengow webservices and files
	 *
	 * @param Shop $shop shop
	 *
	 * @return string
	 */
	public static function getLengowBaseUrl($shop = null)
	{
		$is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 's' : '';
		if (_PS_VERSION_ < '1.5')
		{
			$base = (defined('_PS_SHOP_DOMAIN_') ? 'http'.$is_https.'://'._PS_SHOP_DOMAIN_ : _PS_BASE_URL_).__PS_BASE_URI__;
			$url = $base.'modules/lengow/';
		}
		else
		{
			if (is_null($shop))
				$shop = Context::getContext()->shop;
			$shop_url = new ShopUrl($shop->id);
			$base = 'http'.$is_https.'://'.$shop_url->domain.$shop_url->physical_uri;
			$url = $base.'modules/lengow/';
		}
		return $url;
	}

	/**
	 * Add cron tasks to cronjobs table
	 *
	 * @param integer	$id_shop	shop id
	 *
	 * @return boolean
	 */
	public static function addCronTasks($id_shop, $lengow)
	{
		if (!class_exists('CronJobs'))
			return;
		$shop = new Shop((int)$id_shop);
		$description_export = 'Lengow Export - '.$shop->name;
		$description_import = 'Lengow Import - '.$shop->name;
		$webservices = LengowCore::getWebservicesLinks();


		$query_import_select = 'SELECT 1 FROM '.pSQL(_DB_PREFIX_.'cronjobs').' '
								.'WHERE `description` = \''.pSQL($description_import).'\' '
								.'AND `id_shop` = '.(int)$id_shop.' '
								.'AND `id_shop_group` ='.(int)$shop->id_shop_group;
		$query_export_select = 'SELECT 1 FROM '.pSQL(_DB_PREFIX_.'cronjobs').' '
								.'WHERE `description` = \''.pSQL($description_export).'\' '
								.'AND `id_shop` = '.(int)$id_shop.' '
								.'AND `id_shop_group` ='.(int)$shop->id_shop_group;

		$query_export_insert = 'INSERT INTO '.pSQL(_DB_PREFIX_.'cronjobs').' '
								.'(`description`, `task`, `hour`, `day`, `month`, `day_of_week`, `updated_at`, `active`, `id_shop`, `id_shop_group`) '
								.'VALUES (\''
								.pSQL($description_export)
								.'\', \''
								.pSQL($webservices['url_feed_export'])
								.'\', \'-1\', \'-1\', \'-1\', \'-1\', NULL, TRUE, '
								.(int)$id_shop.', '
								.(int)$shop->id_shop_group
								.')';

		$query_import_insert = 'INSERT INTO '.pSQL(_DB_PREFIX_.'cronjobs').' '
								.'(`description`, `task`, `hour`, `day`, `month`, `day_of_week`, `updated_at`, `active`, `id_shop`, `id_shop_group`) '
								.'VALUES (\''
								.pSQL($description_import)
								.'\', \''
								.pSQL($webservices['url_feed_import'])
								.'\', \'-1\', \'-1\', \'-1\', \'-1\', NULL, TRUE, '
								.(int)$id_shop
								.', '
								.(int)$shop->id_shop_group
								.')';

		$result = array();
		if (!Db::getInstance()->executeS($query_import_select))
			$add_import = Db::getInstance()->execute($query_import_insert);
		if (Configuration::get('LENGOW_EXPORT_FILE')) // create export cron task if export in file only
			if (!Db::getInstance()->executeS($query_export_select))
				$add_export = Db::getInstance()->execute($query_export_insert);

		if (isset($add_import))
		{
			if ($add_import)
				$result['success'][] = $lengow->l('Lengow import cron task sucessfully created.');
			else
				$result['error'][] = $lengow->l('Lengow import cron task could not be created.');
		}
		if (isset($add_export))
		{
			if ($add_export)
				$result['success'][] = $lengow->l('Lengow export cron task sucessfully created.');
			else
				$result['error'][] = $lengow->l('Lengow export cron task could not be created.');
		}
		return $result;
	}

	/**
	 * Remove cron tasks from cronjobs table
	 *
	 * @param integer	$id_shop	shop id
	 *
	 * @return boolean
	 */
	public static function removeCronTasks($id_shop, $lengow)
	{
		if (!class_exists('CronJobs'))
			return;
		$shop = new Shop((int)$id_shop);
		$description_export = 'Lengow Export - '.$shop->name;
		$description_import = 'Lengow Import - '.$shop->name;

		$query_import_select = 'SELECT 1 FROM '.pSQL(_DB_PREFIX_.'cronjobs').' '
								.'WHERE `description` = \''.pSQL($description_import).'\' '
								.'AND `id_shop` = '.(int)$id_shop.' '
								.'AND `id_shop_group` ='.(int)$shop->id_shop_group;
		$query_export_select = 'SELECT 1 FROM '.pSQL(_DB_PREFIX_.'cronjobs').' '
								.'WHERE `description` = \''.pSQL($description_export).'\' '
								.'AND `id_shop` = '.(int)$id_shop.' '
								.'AND `id_shop_group` ='.(int)$shop->id_shop_group;

		$result = array();
		if (Db::getInstance()->executeS($query_import_select) || Db::getInstance()->executeS($query_export_select))
		{
			$query = 'DELETE FROM '.pSQL(_DB_PREFIX_.'cronjobs').' '
					.'WHERE `description` IN (\''.pSQL($description_import).'\', \''.pSQL($description_export).'\') '
					.'AND `id_shop` = '.(int)$id_shop.' '
					.'AND `id_shop_group` ='.(int)$shop->id_shop_group;
			if (Db::getInstance()->execute($query))
				$result['success'] = $lengow->l('Cron tasks sucessfully removed.');
			else
				$result['error'] = $lengow->l('Import and/or export cron task(s) could not be removed.');
		}
		return $result;
	}

	/**
	 * Get Lengow technical error state id
	 *
	 * @param integer	$id_lang	lang id
	 *
	 * @return mixed
	 */
	public static function getLengowErrorStateId($id_lang = null)
	{
		if (!$id_lang)
			$id_lang = Context::getContext()->language->id;
		$states = OrderState::getOrderStates($id_lang);
		foreach ($states as $state)
		{
			if ($state['module_name'] == 'lengow')
				return $state['id_order_state'];
		}
		return false;
	}

	/**
	 * Get Lengow ID Customer.
	 *
	 * @return integer
	 */
	public static function getIdCustomer()
	{
		return Configuration::get('LENGOW_ID_CUSTOMER');
	}

	/**
	 * Get the ID Group.
	 *
	 * @return integer
	 */
	public static function getGroupCustomer($all = true)
	{
		if ($all)
			return Configuration::get('LENGOW_ID_GROUP');

		$group = Configuration::get('LENGOW_ID_GROUP');
		$array_group = explode(',', $group);
		return $array_group[0];
	}

	/**
	 * Get the token API.
	 *
	 * @return integer
	 */
	public static function getTokenCustomer()
	{
		return Configuration::get('LENGOW_TOKEN');
	}
	
	/**
	 * Get the matching Prestashop order state id to the one given
	 *
	 * @param string $state	state to be matched
	 *
	 * @return integer
	 */
	public static function getOrderStateV2($state)
	{
		switch ($state)
		{
			case 'process' :
			case 'processing' :
				return Configuration::get('LENGOW_ORDER_ID_PROCESS');
				break;
			case 'shipped' :
				return Configuration::get('LENGOW_ORDER_ID_SHIPPED');
				break;
			case 'cancel' :
			case 'canceled' :
				return Configuration::get('LENGOW_ORDER_ID_CANCEL');
				break;
			case 'shippedByMp' :
				return Configuration::get('LENGOW_ORDER_ID_SHIPPEDBYMP');
				break;
		}
		return false;
	}

	/**
	 * The shipping names options.
	 *
	 * @return array Lengow shipping names option
	 */
	public static function getMarketplaceSingletonV2($name)
	{
		if (!isset(LengowCore::$registers_v2[$name]))
			LengowCore::$registers_v2[$name] = new LengowMarketplaceV2($name);
		return LengowCore::$registers_v2[$name];
	}

	/**
	 * Check and update xml of marketplace's configuration.
	 *
	 * @return boolean.
	 */
	public static function updateMarketPlaceConfiguration()
	{
		$mp_update = Configuration::get('LENGOW_MP_CONF');
		if (!$mp_update || $mp_update != date('Y-m-d'))
		{
			try
			{
				if ($mp_stream = LengowFile::getRessource(self::$MP_CONF_LENGOW, 'r'))
				{
					$mp_file = new LengowFile(LengowCore::$LENGOW_CONFIG_FOLDER, LengowMarketplaceV2::$XML_MARKETPLACES, 'w');
					stream_copy_to_stream($mp_stream, $mp_file->instance);
					$mp_file->close();
					Configuration::updateValue('LENGOW_MP_CONF', date('Y-m-d'));
				}
			} catch (LengowFileException $lfe)
			{
				LengowCore::log($lfe->getMessage(), false);
			}
		}
	}

}
