<?php

class BT_GTSChecks 
{
	// constructor class
	public function __construct()
	{
		// nothing special to do for now...
	}


	// Check shop context. We only allow all shops or one shop at a time, no groups
	public static function checkShopGroup()
	{
		if (version_compare(_PS_VERSION_, '1.5', '>') && Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') && strpos(Context::getContext()->cookie->shopContext, 'g-') !== FALSE) 
			return false;

		return true;
	}


	// Check that the PHP file for feeds output is present at root directory
	public function checkOutputFile()
	{
		return is_file(_PS_ROOT_DIR_.'/gtrustedstores.feed.php');
	}


	// Make sure the header.tpl starts with the <!DOCTYPE html tag as Google requires it
	// -1: could not access or read header.tpl file
	//  0: file found but not DOCTYPE tag
	//  1: tag found, all good
	public function checkThemeDocType()
	{
		$file = _PS_THEME_DIR_.'header.tpl';
		if (is_file($file)) {
			if ($fh = fopen($file, 'r')) {
				$content = fread($fh, filesize($file));
				fclose($fh);
				if (!empty($content)) {
					if (strpos($content, '<!DOCTYPE html') === false) {
						return 0;
					}
					else {
						return 1;
					}
				}
			}
		}
		return -1;
	}


	// Check shop prefix concistency between GTS and GMC, used to build unique product ID
	// -1: prefix not configured at all in GTS
	//  0: prefix configured in GTS but does not match GMC
	//  1: prefix configured in GTS and no GMC installed
	//  2 prefix configured in GTS and matches GMC prefix
	public function shopPrefixCheck()
	{
		if ( Configuration::get('GMERCHANTCENTER_ID_PREFIX') )
		{
			$sPrefix = 'GMERCHANTCENTER';
		}
		elseif (  Configuration::get('GMCP_ID_PREFIX') )
		{
			$sPrefix = 'GMCP';
		}

		if (Configuration::get('GTRUSTEDSTORES_ID_PREFIX') && Configuration::get($sPrefix . '_ID_PREFIX')) {
			if (Configuration::get('GTRUSTEDSTORES_ID_PREFIX') != Configuration::get($sPrefix  . '_ID_PREFIX')) {
				return 0;
			}
			else {
				return 2;
			}
		}
		elseif (Configuration::get('GTRUSTEDSTORES_ID_PREFIX')) {
			return 1;
		}
		else {
			return -1;
		}
	}


	// Check that the override file is installed
	// to force SSL on order confirmation page
	// -2: override file missing
	// -1: override file present, but ssl instruction missing
	//  0: override file OK, but class_index not updated (1.5 only)
	//  1: all good
	public function checkSSLOverride()
	{
		// 1.5
		if (version_compare(_PS_VERSION_, '1.5', '>')) 
		{
			$override_file = _PS_ROOT_DIR_.'/override/controllers/front/OrderConfirmationController.php';
			$class_index_file = _PS_ROOT_DIR_.'/cache/class_index.php';

			if (!is_file($override_file)) {
				return -2;
			}
			else {
				if ($fh = fopen($override_file, 'r')) {
					$content = fread($fh, filesize($override_file));
					fclose($fh);
					if (strpos($content, 'public $ssl = true') === false) {
						return -1;
					}
					else {
						if ($fh = fopen($class_index_file, 'r')) {
							$content = fread($fh, filesize($class_index_file));
							fclose($fh);
							if (strpos($content, 'override/controllers/front/OrderConfirmationController.php') === false) {
								return 0;
							}
						}
					}
				}
				return 1;
			}
		} // end 1.5

		// 1.4
		else 
		{
			$override_file = _PS_ROOT_DIR_.'/override/controllers/OrderConfirmationController.php';

			if (!is_file($override_file)) {
				return -2;
			}
			else {
				if ($fh = fopen($override_file, 'r')) {
					$content = fread($fh, filesize($override_file));
					fclose($fh);
					if (strpos($content, 'public $ssl = true') === false) {
						return -1;
					}
				}
				return 1;
			}
		} // end 1.4

	} // end function

}

?>