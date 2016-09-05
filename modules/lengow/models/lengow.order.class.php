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

/**
 * The Lengow Order Class.
 *
 * @author Team Connector <team-connector@lengow.com>
 * @copyright 2015 Lengow SAS
 */

$sep = DIRECTORY_SEPARATOR;
require_once dirname(__FILE__).$sep.'..'.$sep.'loader.php';
require dirname(__FILE__).$sep.'..'.$sep.'interface'.$sep.'LengowObject.php';

try
{
	loadFile('core');
	loadFile('marketplace');
	loadFile('marketplacev2');
	loadFile('connector');
	loadFile('check');
} catch(Exception $e)
{
	echo date('Y-m-d : H:i:s ').$e->getMessage().'<br />';
}
class LengowOrderAbstract extends Order
{

	/**
	* Version.
	*/
	const VERSION = '1.0.0';

	/**
	 * Marketplace's name.
	 */
	public $lengow_marketplace;

	/**
	 * Message.
	 */
	public $lengow_message;

	/**
	 * Total paid on marketplace.
	 */
	public $lengow_total_paid;

	/**
	* Carrier from marketplace.
	*/
	public $lengow_carrier;

	/**
	* Carrier Method from marketplace.
	*/
	public $lengow_method;

	/**
	* Tracking.
	*/
	public $lengow_tracking;

	/**
	* Shipped by markeplace
	*/
	public $lengow_sent_marketplace;

	/**
	* Extra information (json node form import).
	*/
	public $lengow_extra;

	/**
	* Is importing, prevent multiple import
	*/
	public $is_import;

	/**
	 * Lengow order id
	 *
	 * @var string
	 */
	public $id_lengow;

	/**
	 * Lengow flux id
	 *
	 * @var integer
	 */
	public $id_flux;

	/**
	 * ID of the delivery address
	 *
	 * @var integer
	 */
	public $lengow_delivery_address_id;

	/**
	 * Data of lengow order
	 *
	 * @var SimpleXmlElement
	 */
	public $data;

	/**
	 * Order is already fully imported
	 *
	 * @var bool
	 */
	public $is_finished = false;

	/**
	 * First time order is being processed
	 *
	 * @var bool
	 */
	public $first_import = true;

	/**
	 * Log message saved in DB
	 *
	 * @var string
	 */
	public $log_message = null;

	/**
	 * Order marketplace
	 *
	 * @var LengowMarketplace
	 */
	protected $marketplace;

	/**
	 * @var boolean order is disabled (ready to be reimported)
	 */
	public $is_disabled;

	/**
	* Construct a Lengow order based on Prestashop order.
	*
	* @param integer $id 		Lengow order id
	* @param integer $id_lang 	id lang
	*/
	public function __construct($id = null, $id_lang = null)
	{
		parent::__construct($id, $id_lang);
		$this->loadLengowFields();
	}

	/**
	 * Get order id
	 *
	 * @param string    $lengow_id        		Lengow order id
	 * @param integer   $delivery_address_id    devivery address id
	 * @param string    $marketplace            marketplace name 
	 *
	 * @return mixed
	 */
	public static function getOrderIdFromLengowOrders($lengow_id, $delivery_address_id, $marketplace)
	{
		$query = 'SELECT `id_order`, `delivery_address_id`,`id_flux` 
			FROM `'._DB_PREFIX_.'lengow_orders`
			WHERE `id_order_lengow` = \''.pSQL($lengow_id).'\'
			AND `marketplace` = \''.pSQL(Tools::strtolower($marketplace)).'\'
			ORDER BY `id_order` DESC';

		$results = Db::getInstance()->executeS($query);
		if (count($results) == 0)
			return false;

		foreach ($results as $result)
		{
			if (is_null($result['delivery_address_id']) && !is_null($result['id_flux']))
				return $result['id_order'];
			elseif ($result['delivery_address_id'] == $delivery_address_id)
				return $result['id_order'];
		}
		return false;
	}

	/**
	 * Get Lengow ID with order ID Prestashop and delivery address ID
	 *
	 * @param integer 	$id_order				prestashop order id
	 * @param integer 	$delivery_address_id	delivery address id
	 *
	 * @return mixed
	 */
	public static function getLengowIdFromLengowDeliveryAddress($id_order, $delivery_address_id)
	{
		$query = 'SELECT `id_order_lengow` FROM `'._DB_PREFIX_.'lengow_orders` '
				.'WHERE `id_order` = \''.pSQL($id_order).'\' '
				.'AND `delivery_address_id` = \''.pSQL($delivery_address_id).'\' ';
		$r = Db::getInstance()->getRow($query);
		if ($r)
			return $r['id_order_lengow'];
		return false;
	}

	/**
	 * Get order id from Lengow Order
	 *
	 * @param string  	$lengow_id  	Lengow order id
	 * @param string  	$marketplace	marketplace name
	 *
	 * @return array
	 */
	public static function getOrderIdFromLengowOrder($lengow_id, $marketplace)
	{
		$query = 'SELECT `id_order` FROM `'._DB_PREFIX_.'lengow_orders` '
				.'WHERE `id_order_lengow` = \''.pSQL($lengow_id).'\' '
				.'AND `marketplace` = \''.pSQL(Tools::strtolower($marketplace)).'\' '
				.'AND `is_disabled` = \'0\'';
		return Db::getInstance()->executeS($query);
	}

	/**
	 * Get order line from Lengow Order
	 *
	 * @param integer $order_id	prestashop order id
	 *
	 * @return array
	 */
	public static function getOrderLineFromLengowOrder($order_id)
	{
		$query = 'SELECT `id_order_line` FROM `'._DB_PREFIX_.'lengow_order_line` '
				.'WHERE `id_order` = \''.pSQL($order_id).'\' ';
		return Db::getInstance()->executeS($query);
	}

	/**
	 * Load information from lengow_orders table
	 *
	 * @return boolean.
	 */
	protected function loadLengowFields()
	{
		$query = 'SELECT lo.`id_order_lengow`, lo.`id_flux`, lo.`delivery_address_id`, lo.`marketplace`, lo.`message`, lo.`total_paid`, lo.`carrier`, lo.`method`, lo.`tracking`, lo.`sent_marketplace`, lo.`extra`, lo.`is_disabled` '
				.'FROM `'._DB_PREFIX_.'lengow_orders` lo '
				.'WHERE lo.id_order = \''.(int)$this->id.'\'';

		if ($result = Db::getInstance()->getRow($query))
		{
			$this->id_lengow = $result['id_order_lengow'];
			$this->id_flux = $result['id_flux'];
			$this->lengow_delivery_address_id = $result['delivery_address_id'];
			$this->lengow_marketplace = $result['marketplace'];
			$this->lengow_message = $result['message'];
			$this->lengow_total_paid = $result['total_paid'];
			$this->lengow_carrier = $result['carrier'];
			$this->lengow_method = $result['method'];
			$this->lengow_tracking = $result['tracking'];
			$this->lengow_sent_marketplace = $result['sent_marketplace'];
			$this->lengow_extra = $result['extra'];
			$this->is_disabled = (bool)$result['is_disabled'];
			return true;
		}
		else
			return false;
	}

	/**
	 * Update order status
	 *
	 * @param LengowMarketplace $marketplace 	Lengow marketplace
	 * @param string 			$api_state 		marketplace state
	 * @param string 			$lengow_id 		tracking number
	 *
	 * @return bool true if order has been updated
	 */
	public function updateState(LengowMarketplace $marketplace, $api_state, $tracking_number)
	{
		// get prestashop equivalent state id to Lengow API state
		$id_order_state = LengowCore::getOrderState($marketplace->getStateLengow($api_state));

		// if state is different between API and Prestashop
		if ($this->getCurrentState() != $id_order_state)
		{
			// Change state process to shipped
			if ($this->getCurrentState() == LengowCore::getOrderState('accepted')
					&&	($marketplace->getStateLengow($api_state) == 'shipped' || $marketplace->getStateLengow($api_state) == 'closed'))
			{
				$history = new OrderHistory();
				$history->id_order = $this->id;
				$history->changeIdOrderState(LengowCore::getOrderState('shipped'), $this, true);
				$history->validateFields();
				$history->add();

				if (!empty($tracking_number))
				{
					$this->shipping_number = $tracking_number;
					$this->validateFields();
					$this->update();
				}
				LengowCore::getLogInstance()->write('state updated to shipped', true, $this->id_lengow);
				return true;
			}
			// Change state process or shipped to cancel
			elseif (($this->getCurrentState() == LengowCore::getOrderState('accepted') || $this->getCurrentState() == LengowCore::getOrderState('shipped'))
					&& ($marketplace->getStateLengow($api_state) == 'canceled' || $marketplace->getStateLengow($api_state) == 'refused'))
			{
				$history = new OrderHistory();
				$history->id_order = $this->id;
				$history->changeIdOrderState(LengowCore::getOrderState('canceled'), $this, true);
				$history->validateFields();
				$history->add();
				LengowCore::getLogInstance()->write('state updated to canceled', true, $this->id_lengow);
				return true;
			}
		}
		return false;
	}

	/**
	 * Get the shipping price with current method
	 *
	 * @param float $total The total of order
	 *
	 * @return float The shipping price.
	 */
	public static function getShippingPrice($total)
	{
		$context = Context::getContext();
		$carrier = LengowCore::getExportCarrier();
		$id_zone = $context->country->id_zone;
		$id_currency = $context->cart->id_currency;
		$shipping_method = $carrier->getShippingMethod();
		if ($shipping_method != Carrier::SHIPPING_METHOD_FREE)
		{
			if ($shipping_method == Carrier::SHIPPING_METHOD_WEIGHT)
				return LengowCore::formatNumber($carrier->getDeliveryPriceByWeight($total, (int)$id_zone));
			else
				return LengowCore::formatNumber($carrier->getDeliveryPriceByPrice($total, (int)$id_zone, (int)$id_currency));
		}
		return 0;
	}

	/**
	 * Rebuild OrderCarrier after validateOrder
	 *
	 * @param int $id_carrier
	 * 
	 * @return void
	 */
	public function forceCarrier($id_carrier)
	{
		if ($id_carrier == '')
			return null;

		$this->id_carrier = $id_carrier;
		$this->update();
		if ($this->getIdOrderCarrier() != '')
		{
			$order_carrier = new OrderCarrier($this->getIdOrderCarrier());
			$order_carrier->id_carrier = $id_carrier;
			$order_carrier->update();
		}
		else
		{
			$order_carrier = new OrderCarrier();
			$order_carrier->id_order = $this->id;
			$order_carrier->id_carrier = $id_carrier;
			$order_carrier->add();
		}
	}

	public function getIdOrderCarrier()
	{
		if (_PS_VERSION_ < '1.5.5')
			return (int)Db::getInstance()->getValue('
					SELECT `id_order_carrier`
					FROM `'._DB_PREFIX_.'order_carrier`
					WHERE `id_order` = '.(int)$this->id);
		else
			return parent::getIdOrderCarrier();
	}

	/**
	 * Check if a lengow order
	 *
	 * @param integer 	$id	prestashop order id
	 *
	 * @return boolean
	 */
	public static function isFromLengow($id)
	{
		$r = Db::getInstance()->executeS(
			'SELECT `id_order_lengow` '.
			'FROM `'._DB_PREFIX_.'lengow_orders` '.
			'WHERE `id_order` = '.(int)$id);
		if (empty($r) || $r[0]['id_order_lengow'] == '')
			return false;
		else
			return true;
	}

	/**
	 * Sets order state to Lengow technical error
	 */
	public function setStateToError()
	{
		$id_error_lengow_state = LengowCore::getLengowErrorStateId();
		// update order to Lengow error state if not already updated
		if ($this->getCurrentState() !== $id_error_lengow_state)
			$this->setCurrentState($id_error_lengow_state, Context::getContext()->employee->id);
	}

	/**
	 * Mark order as disabled in lengow_orders table
	 *
	 * @param integer 	$id	prestashop order id
	 *
	 * @return boolean
	 */
	public static function disable($id)
	{
		$update = 'UPDATE '._DB_PREFIX_.'lengow_orders '
				.'SET `is_disabled` = 1 '
				.'WHERE `id_order`= '.(int)$id;
		return DB::getInstance()->execute($update);
	}

	/**
	 * Check and change the name of the marketplace for v3 compatibility
	 */
	public function checkAndChangeMarketplaceName()
	{
		if (LengowCheck::isValidAuth())
		{
			$connector = new LengowConnector(LengowCore::getAccessToken(), LengowCore::getSecretCustomer());
			$results = $connector->get(
									'/v3.0/orders',
									array(
										'marketplace_order_id' 	=> $this->id_lengow,
										'marketplace'			=> $this->lengow_marketplace,
										'account_id' 			=> LengowCore::getIdAccount()
									),
									'stream'
								);
			if (is_null($results))
				return;
			$results = Tools::jsonDecode($results);
			if (isset($results->error))
				return;
			foreach ($results->results as $order)
			{
				if ($this->lengow_marketplace != (string)$order->marketplace)
				{
					$update = 'UPDATE '._DB_PREFIX_.'lengow_orders '
						.'SET `marketplace` = \''.pSQL(Tools::strtolower((string)$order->marketplace)).'\' '
						.'WHERE `id_order` = \''.(int)$this->id.'\'';
					DB::getInstance()->execute($update);
					$this->loadLengowFields();
				}
			}
		}
	}

	/**
	 * Get order id
	 *
	 * @return mixed
	 */
	public static function getOrderIdFromLengowOrdersV2($lengow_id, $feed_id, $marketplace)
	{
		$query = 'SELECT `id_order` FROM '
				._DB_PREFIX_.'lengow_orders '
				.'WHERE `id_order_lengow` = \''.pSQL($lengow_id).'\' '
				.'AND `id_flux` = \''.(int)$feed_id.'\' '
				.'AND `marketplace` = \''.pSQL(Tools::strtolower($marketplace)).'\' '
				.'ORDER BY `id_order` DESC';
		$r = Db::getInstance()->getRow($query);
		if ($r)
			return $r['id_order'];
		return false;
	}

	/**
	 * Update order status
	 *
	 * @return bool true if order has been updated
	 */
	public function updateStateV2(LengowMarketplaceV2 $marketplace, $api_state, $tracking_number)
	{
		// get prestashop equivalent state id to Lengow API state
		$id_order_state = LengowCore::getOrderStateV2($marketplace->getStateLengow($api_state));
		// if state is different between API and Prestashop
		if ($this->getCurrentState() != $id_order_state)
		{
			// Change state process to shipped
			if ($this->getCurrentState() == LengowCore::getOrderStateV2('process') && $marketplace->getStateLengow($api_state) == 'shipped')
			{
				$history = new OrderHistory();
				$history->id_order = $this->id;
				$history->changeIdOrderState(LengowCore::getOrderStateV2('shipped'), $this, true);
				$history->validateFields();
				$history->add();

				if (!empty($tracking_number))
				{
					$this->shipping_number = $tracking_number;
					$this->validateFields();
					$this->update();

				}
				LengowCore::getLogInstance()->write('state updated to shipped', true, $this->id_lengow);
				return true;
			}
			// Change state process or shipped to cancel
			elseif (($this->getCurrentState() == LengowCore::getOrderStateV2('process') || $this->getCurrentState() == LengowCore::getOrderStateV2('shipped'))
						&& $marketplace->getStateLengow($api_state) == 'canceled')
			{
				$history = new OrderHistory();
				$history->id_order = $this->id;
				$history->changeIdOrderState(LengowCore::getOrderStateV2('cancel'), $this, true);
				$history->validateFields();
				$history->add();
				LengowCore::getLogInstance()->write('state updated to cancel', true, $this->id_lengow);
				return true;
			}
		}
		return false;
	}

}