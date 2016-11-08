<?php
/*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class GAnalytics extends GAnalyticsModule
{

	public function hookHeader($params)
	{
		if ((method_exists('Language', 'isMultiLanguageActivated') && Language::isMultiLanguageActivated())
			|| Language::countActiveLanguages() > 1
		)
			$multilang = (string)Tools::getValue('isolang') . '/';
		else
			$multilang = '';

		$default_meta_order = Meta::getMetaByPage('order', $this->context->language->id);
		if (strpos($_SERVER['REQUEST_URI'], __PS_BASE_URI__ . 'order.php') === 0 || strpos($_SERVER['REQUEST_URI'], __PS_BASE_URI__ . $multilang . $default_meta_order['url_rewrite']) === 0)
			$this->context->smarty->assign('pageTrack', '/order/step' . (int)Tools::getValue('step') . '.html');

		$this->context->smarty->assign('ganalytics_id', Configuration::get('GANALYTICS_ID'));
		$this->context->smarty->assign('universal_analytics', Configuration::get('UGANALYTICS'));
		$this->context->smarty->assign('isOrder', false);

		//Olivier : To avoid that Colissimo in iframe change source page in analytics stats
		if ((int)Context::getContext()->controller->step != 3) {
			return $this->display(__FILE__, 'views/templates/hook/header.tpl');
		}
	}
}
