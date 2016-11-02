<?php

class BT_GTSOrders 
{
	var $GTSObject = null;

	// Constructor class
	public function __construct($oGTS)
	{
		// We'll neeed access to some functions and parameters from the main module class here
		$this->GTSObject = $oGTS;
	}

	// Determine if order has correct properties and a status that is included in the config
	// The order confirmation code will only be written if all is OK
	public function orderIsValidForConfirmation($oOrder)
	{
		// Start with the basics 
		if (!$oOrder->valid || empty($oOrder->date_add))
			return false;

		// Check order status
		$status = $oOrder->getCurrentState();
		$ok_statuses = explode(',', $this->GTSObject->configuration['GTRUSTEDSTORES_OK_ORDER_STATES']);

		if (!in_array((string)$status, $ok_statuses)) {
			return false;
		}

		return true;
	}

	// Check if any products in the order are on back-order
	public function hasBackOrderPreorder($aProducts)
	{
		foreach ($aProducts as $p) {
			// for 1.5
			if (isset($p['current_stock'])) {
				$stock_available_after_order = (int)($p['current_stock']);
			}
			// for 1.4
			elseif (method_exists('Product', 'getQuantity')) {
				$stock_available_after_order = Product::getQuantity((int)($p['product_id']), (int)($p['product_attribute_id']));
			}
			// Should never happen, but just in case...
			else {
				$stock_available_after_order = 0;
			}

			if ((int)($stock_available_after_order) < 0) {
				return true;
			}
		}

		return false;
	}

	// Check if any products in the order are digital / downloadable products
	public function hasDigitalGoods($oOrder)
	{
		return $oOrder->isVirtual(false);
	}
	
	// Add Google specific data to items ordered
	public function prepareOrderItems($aProducts, $aLocaleData)
	{
		foreach ($aProducts as &$p) {
			$p['google_shopping_id'] = $this->GTSObject->getHookProductId($aLocaleData, (int)($p['id_product']));
			$p['google_shopping_account_id'] = $this->GTSObject->configuration['GTRUSTEDSTORES_GMC_ID'];
			$p['google_shopping_country'] = $aLocaleData['country'];
			$p['google_shopping_language'] = strtolower($aLocaleData['language']);
		}

		return $aProducts;
	}



	/* -------------- */
	/* DATE FUNCTIONS */
	/* -------------- */

	// Allows adding a day to a date
	public static function nextDay($date) 
	{
		$ts = strtotime($date);
		return date("Y-m-d", ($ts + 86400));
	}

	// Check to see if an order can be shipped on a specific date 
	public function canShipOnThatDay($date) 
	{
		// Let's check closed weekdays first
		$ts = strtotime($date);
		$daynum = date("w", $ts);
		if (in_array($daynum, explode(',', $this->GTSObject->configuration['GTRUSTEDSTORES_CLOSED_DAYS']))) {
			return false;
		}

		// Then, let's check for holidays
		list($y, $m, $d) = explode('-', $date);
		$datekey = $m.'_'.$d;
		if (in_array($datekey, explode(',', $this->GTSObject->configuration['GTRUSTEDSTORES_HOLIDAYS']))) {
			return false;
		}

		return true;
	}

	// Get standard expected shipping date when same-day shipping is not checked
	public function getStandardExpectedDate($order_date)
	{
		// if value of GTRUSTEDSTORES_PROCESS_TIME is 2, 2013-12-10 becomes 2013-12-12 for example
		for ($i = 1; $i <= (int)($this->GTSObject->configuration['GTRUSTEDSTORES_PROCESS_TIME']); $i++) {
			$order_date = self::nextDay($order_date);
		}

		return $order_date;
	}

	// Determine estimated shipping date based on order and order products data
	public function getEstimatedShippingDate($oOrder, $aProducts)
	{
		// Set necessary variables
		$order_date_time = $oOrder->date_add;
		list($order_date, $order_time) = explode(' ', $order_date_time);
		$tomorrow_date = self::nextDay($order_date);
		$order_state = $oOrder->getCurrentState();
		$cutoff_time = $this->GTSObject->configuration['GTRUSTEDSTORES_CUTOFF_HOURS'].':'.$this->GTSObject->configuration['GTRUSTEDSTORES_CUTOFF_MINUTES'].':00';

		// Date / time formating / init for comparison
		list($oh, $om, $os) = explode(':', $order_time);
		list($ch, $cm, $cs) = explode(':', $cutoff_time);
		$order_time_ts = mktime($oh, $om, $os);
		$cutoff_time_ts = mktime($ch, $cm, $cs);

		// Let's first determine the basic expected shipping date based on order processing preferences
		if ($this->GTSObject->configuration['GTRUSTEDSTORES_SAME_DAY']) {
			$ship_date = ((($order_time_ts < $cutoff_time_ts)) ? $order_date : $tomorrow_date);
		}
		else {
			$ship_date = $this->getStandardExpectedDate($order_date);
		}

		// Next, let's check if the order has back-order items 
		// and change the date accordingly if necessary
		if ($this->hasBackOrderPreorder($aProducts)) {
			$ship_date = $this->modulateDateWithBackOrder($ship_date, $aProducts);
		}

		// Finally, let's test the date until we get a date that is OK for shipping
		$cnt = 1;
		$limit = 30; // let's avoid infinite loops in case all week days or holidays are checked. 30 will do

		while ($this->canShipOnThatDay($ship_date) === false && $cnt < $limit) {
			$ship_date = self::nextDay($ship_date);
			$cnt++;
		}

		return $ship_date;
	}

	function getEstimatedDeliveryDate($order, $shipping_date) 
	{
		$delivery_date = $shipping_date;

		$shipping_times = unserialize($this->GTSObject->configuration['GTRUSTEDSTORES_SHIP_TIME']);
		$ship_time = (int)$shipping_times[$order->id_carrier];

		for ($i = 1; $i <= (int)$ship_time; $i++) {
			$delivery_date = self::nextDay($delivery_date);
		}

		return $delivery_date;
	}

	// If the order has back-order items, we set the estimated shipping date
	// to be the date + 1 day of the latest date indicated in the product list for 
	// the $p['available_date'] product_property, which is the date when the product
	// is expected to be back in stock
	public function modulateDateWithBackOrder($shipping_date, $aProducts)
	{
		$latest_date = $shipping_date;

		foreach ($aProducts as $p) {
			if (!empty($p['available_date']) && $p['available_date'] > $latest_date) {
				$latest_date = $p['available_date'];
			}
		}

		return self::nextDay($latest_date);
	}
	
}

?>