<?php

class BT_GTSFeeds 
{
	var $GTSObject = null;
	var $column_delimiter = "\t";
	var $line_delimiter = "\n";

	// Constructor class
	public function __construct($oGTS)
	{
		// We'll neeed access to some functions and parameters from the main module class here
		$this->GTSObject = $oGTS;
	}

	
	// There are 2 types of feeds: shipments and cancellations
	public function generateFeed($action, $id_country)
	{
		switch ($action) {
			case 'shipments':
				return $this->generateShipmentsFeed($id_country);
				break;

			case 'cancellations':
				return $this->generateCancellationsFeed($id_country);
				break;
			
			default:
				die('invalid action');
				break;
		}

		return true;
	}


	// Just like it says...
	public function generateShipmentsFeed($id_country)
	{
		$content = $this->createShippedFeedHeader();
		$shipped_orders = $this->getShippedOrders($id_country);
		foreach ($shipped_orders as $o) {
			$content .= $this->createShippedFeedLine($o);
		}

		return trim($content, $this->line_delimiter);
	}


	// Just like it says...
	public function generateCancellationsFeed($id_country)
	{
		$content = $this->createCancelledFeedHeader();
		$cancelled_orders = $this->getCancelledOrders($id_country);
		foreach ($cancelled_orders as $o) {
			$content .= $this->createCancelledFeedLine($o);
		}

		return trim($content, $this->line_delimiter);
	}


	// First line with column labels, required by Google
	public function createShippedFeedHeader()
	{
		return 
		'merchant order id'.$this->column_delimiter.
		'tracking number'.$this->column_delimiter.
		'carrier code'.$this->column_delimiter.
		'other carrier name'.$this->column_delimiter.
		'ship date'.$this->line_delimiter;
	}

	// First line with column labels, required by Google
	public function createCancelledFeedHeader()
	{
		return 
		'merchant order id'.$this->column_delimiter.
		'reason'.$this->line_delimiter;
	}


	// Get shipped orders
	public function getShippedOrders($id_country)
	{
		$carrier_codes = unserialize($this->GTSObject->configuration['GTRUSTEDSTORES_CARRIERS']);
		$today = date("Y-m-d");

		$sql = 'SELECT DISTINCT(o.`id_order`), o.`id_carrier`, o.`shipping_number`, DATE_FORMAT(MAX(oh.`date_add`), "%Y-%m-%d") as ship_date
		FROM `'._DB_PREFIX_.'orders` o 
		LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (o.`id_order` = oh.`id_order`)
		LEFT JOIN `'._DB_PREFIX_.'address` a ON (o.`id_address_delivery` = a.`id_address`)
		WHERE o.`valid`= 1
		AND a.`id_country` = '.(int)($id_country).'
		AND oh.`date_add` LIKE "%'.$today.'%"
		AND o.`id_order` > '.(int)($this->GTSObject->configuration['GTRUSTEDSTORES_LAST_ORDER_LOG_S']).'
		AND oh.`id_order_state` IN ('.$this->GTSObject->configuration['GTRUSTEDSTORES_SHIPPED_STATUS'].')
		GROUP BY o.`id_order`
		ORDER BY o.`id_order`
		';

		$shipped_orders = Db::getInstance()->ExecuteS($sql);

		foreach ($shipped_orders as &$o) {
			if (strpos($carrier_codes[(int)($o['id_carrier'])], 'Other') !== FALSE) {
				list($carrier_code, $other_carrier_name) = explode('_', $carrier_codes[(int)($o['id_carrier'])]);
			}
			else {
				$carrier_code = $carrier_codes[(int)($o['id_carrier'])];
				$other_carrier_name = '';
			}

			$o['carrier_code'] = $carrier_code;
			$o['other_carrier_name'] = $other_carrier_name;	
		}

		return $shipped_orders;
	}

	// Get cancelled orders
	public function getCancelledOrders($id_country)
	{
		$reason_codes = array_flip(unserialize($this->GTSObject->configuration['GTRUSTEDSTORES_CANCEL_MATCHING']));
		$today = date("Y-m-d");

		$sql = 'SELECT o.`id_order`, oh.`date_add` as cancel_date, oh.`id_order_state`
		FROM `'._DB_PREFIX_.'orders` o 
		LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (o.`id_order` = oh.`id_order`)
		LEFT JOIN `'._DB_PREFIX_.'address` a ON (o.`id_address_delivery` = a.`id_address`)
		WHERE o.`valid`= 0
		AND a.`id_country` = '.(int)($id_country).'
		AND oh.`date_add` LIKE "%'.$today.'%"
		AND o.`id_order` > '.(int)($this->GTSObject->configuration['GTRUSTEDSTORES_LAST_ORDER_LOG_C']).'
		AND oh.`id_order_state` IN ('.$this->GTSObject->configuration['GTRUSTEDSTORES_CANCEL_STATUSES'].')
		AND oh.`id_order_history` = (SELECT MAX(`id_order_history`) FROM `'._DB_PREFIX_.'order_history` moh WHERE moh.`id_order` = o.`id_order` GROUP BY moh.`id_order`)
		ORDER BY o.`id_order`
		';

		$cancelled_orders = Db::getInstance()->ExecuteS($sql);

		foreach ($cancelled_orders as &$o) {
			$o['reason_code'] = $reason_codes[$o['id_order_state']];
		}

		return $cancelled_orders;
	}


	// 1 line of data for 1 order
	public function createShippedFeedLine($aOrder)
	{
		return 
		$aOrder['id_order'].$this->column_delimiter.
		$aOrder['shipping_number'].$this->column_delimiter.
		$aOrder['carrier_code'].$this->column_delimiter.
		$aOrder['other_carrier_name'].$this->column_delimiter.
		$aOrder['ship_date'].$this->line_delimiter;
	}

	// 1 line of data for 1 order
	public function createCancelledFeedLine($aOrder)
	{
		return 
		$aOrder['id_order'].$this->column_delimiter.
		$aOrder['reason_code'].$this->line_delimiter;
	}

}

?>