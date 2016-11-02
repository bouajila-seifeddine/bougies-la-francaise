<?php
include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include(dirname(__FILE__).'/pm_advancedsearch4.php');
if (php_sapi_name() != 'cli') {
	if (isset($_GET['secure_key'])) {
		$secureKey = (_PS_VERSION_ >= 1.5 ? Configuration::getGlobalValue('PM_AS4_SECURE_KEY') : Configuration::get('PM_AS4_SECURE_KEY'));
		if (!empty($secureKey) AND $secureKey === $_GET['secure_key']) {
			$PM_AdvancedSearch4 = new PM_AdvancedSearch4();
			$PM_AdvancedSearch4->cronTask();
			echo 'Reindexation done';
		}
	}
} else {
	$PM_AdvancedSearch4 = new PM_AdvancedSearch4();
	$PM_AdvancedSearch4->cronTask();
	echo 'Reindexation done via PHP Cli';
}
