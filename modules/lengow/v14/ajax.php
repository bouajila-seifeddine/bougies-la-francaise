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

@set_time_limit(0);
$sep = DIRECTORY_SEPARATOR;
require_once '..'.$sep.'..'.$sep.'..'.$sep.'config'.$sep.'config.inc.php';
require_once '..'.$sep.'..'.$sep.'..'.$sep.'init.php';
require_once '..'.$sep.'lengow.php';
require_once _PS_MODULE_DIR_.'lengow'.$sep.'models'.$sep.'lengow.connector.class.php';
require_once _PS_MODULE_DIR_.'lengow'.$sep.'models'.$sep.'lengow.order.class.php';
require_once _PS_MODULE_DIR_.'lengow'.$sep.'models'.$sep.'lengow.import.class.php';
require_once _PS_MODULE_DIR_.'lengow'.$sep.'models'.$sep.'lengow.importv2.class.php';

$action = Tools::getValue('action');

switch ($action)
{
	case 'reimport_order':
		$error = false;
		$order_id = Tools::getValue('orderid');
		if (LengowOrder::isFromLengow($order_id))
		{
			$order = new LengowOrder($order_id);
			$lengow_order_id = Tools::getValue('lengoworderid');
			LengowOrder::disable($order->id);
			if ($order->id_order_line != null)
				LengowLog::deleteLogByOrderId($lengow_order_id, $order->id_order_line);
			else
				LengowLog::deleteLogByOrderIdV2($lengow_order_id);
			$result = false;
			if (Configuration::get('LENGOW_SWITCH_V3'))
			{
				if ($order->id_flux != null)
					$order->checkAndChangeMarketplaceName();
				$import = new LengowImport($lengow_order_id, $order->lengow_marketplace);
				$result = $import->exec();
			}
			else
			{
				if ($order->id_flux != null)
				{
					$importV2 = new LengowImportV2($lengow_order_id, $order->id_flux);
					$result = $importV2->exec();
				}
			}
			if ($result != false)
			{
				$id_state_cancel = Configuration::get('LENGOW_STATE_ERROR');
				$order->setCurrentState($id_state_cancel, (int)Context::getContext()->employee->id);
			}
		}
		break;
	default:
		$is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 's' : '';
		$lengow_connector = new LengowConnector((integer)LengowCore::getIdCustomer(), LengowCore::getTokenCustomer());
		$params = 'format='.Tools::getValue('format');
		$params .= '&mode='.Tools::getValue('mode');
		$params .= '&all='.Tools::getValue('all');
		$params .= '&shop='.Tools::getValue('shop');
		$params .= '&cur='.Tools::getValue('cur');
		$params .= '&lang='.Tools::getValue('lang');
		$new_flow = (defined('_PS_SHOP_DOMAIN_') ? 'http'.$is_https.'://'._PS_SHOP_DOMAIN_ : _PS_BASE_URL_).__PS_BASE_URI__.'modules/lengow/webservice/export.php?'.$params;
		$args = array(
					'idClient' => LengowCore::getIdCustomer(),
					'idGroup' => LengowCore::getGroupCustomer(),
					'urlFlux' => $new_flow
				);
		$data_flows = get_object_vars(Tools::jsonDecode(Configuration::get('LENGOW_FLOW_DATA')));
		if ($id_flow = Tools::getValue('idFlow'))
		{
			$args['idFlux'] = $id_flow;
			$data_flows[$id_flow] = array(
				'format' => Tools::getValue('format'),
				'mode' => Tools::getValue('mode') == 'yes' ? 1 : 0,
				'all' => Tools::getValue('all') == 'yes' ? 1 : 0 ,
				'currency' => Tools::getValue('cur') ,
				'shop' => Tools::getValue('shop') ,
				'language' => Tools::getValue('lang') ,
			);
			Configuration::updateValue('LENGOW_FLOW_DATA', Tools::jsonEncode($data_flows));
		}
		if ($call = $lengow_connector->api('updateRootFeed', $args))
			echo Tools::jsonEncode(array('return' => true, 'flow' => $new_flow));
		else
			echo Tools::jsonEncode(array('return' => false));
		break;
}