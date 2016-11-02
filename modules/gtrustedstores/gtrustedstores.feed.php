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


/** Includes **/
require_once(dirname(__FILE__).'/config/config.inc.php');
require_once(dirname(__FILE__).'/init.php');
require_once(_PS_MODULE_DIR_.'/gtrustedstores/gtrustedstores.php');
require_once(_PS_MODULE_DIR_.'/gtrustedstores/lib/GTSFeeds.php');

/** Object instantiation **/
$GTS = new GTrustedStores();
$GTSFeed = new BT_GTSFeeds($GTS);

/** Valid actions: for now, only 2 types of feeds: shipments and cancellations **/
$valid_actions = array('shipments', 'cancellations');

if (!Tools::getValue('action') || !in_array(Tools::getValue('action'), $valid_actions)) {
	die('invalid action');
}

/** Check security token **/
if (!Tools::getValue('token') || Tools::getValue('token') != $GTS->configuration['GTRUSTEDSTORES_FEED_TOKEN']) {
	die('invalid security token');
}

/** Check country ID **/
if (!Tools::getValue('id_country') || !is_numeric(Tools::getValue('id_country'))) {
	die('invalid country ID');
}

/** OK, let's secure and assign values **/
$action = pSQL(Tools::getValue('action'));
$token = pSQL(Tools::getValue('token'));
$id_country = (int)(Tools::getValue('id_country'));

/** Prevent caching **/
header("Expires: Fri, 13 Sep 2002 04:15:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: text/plain");

/** Generate feed and output it **/
echo $GTSFeed->generateFeed($action, $id_country);
die();

?>