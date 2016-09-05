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
	loadFile('core');
	loadFile('order');
	loadFile('option');
} catch(Exception $e)
{
	echo date('Y-m-d : H:i:s ').$e->getMessage().'<br />';
}

/**
 * The Lengow Marketplace Class.
 *
 * @author Team Connector <team-connector@lengow.com>
 * @copyright 2015 Lengow SAS
 */
class LengowMarketplaceAbstract
{
	
	public static $VALID_ACTIONS = array(
								'ship' ,
								'cancel'
								);	

	public static $MARKETPLACES;
	public $marketplace;
	public $name;
	public $is_loaded = false;
	public $states_lengow = array();
	public $states = array();
	public $actions = array();
	public $carriers = array();

	/**
	* Construct a new Markerplace instance with xml configuration.
	*
	* @param string $name The name of the marketplace
	*/
	public function __construct($name)
	{
		self::loadApiMarketplace();
		$this->name = Tools::strtolower($name);
		$this->marketplace = self::$MARKETPLACES->{$this->name};
		if (!empty($this->marketplace))
		{
			foreach ($this->marketplace->orders->status as $key => $state)
			{
				foreach ($state as $value)
				{
					$this->states_lengow[(string)$value] = (string)$key;
					$this->states[(string)$key][(string)$value] = (string)$value;
				}
			}
			foreach ($this->marketplace->orders->actions as $key => $action)
			{
				foreach ($action->status as $state)
					$this->actions[(string)$key]['status'][(string)$state] = (string)$state;
				foreach ($action->args as $arg)
					$this->actions[(string)$key]['args'][(string)$arg] = (string)$arg;
				foreach ($action->optional_args as $optional_arg)
					$this->actions[(string)$key]['optional_args'][(string)$optional_arg] = $optional_arg;		
			}
			if (isset($this->marketplace->orders->carriers))
				foreach ($this->marketplace->orders->carriers as $key => $carrier)
					$this->carriers[(string)$key] = (string)$carrier->label;
			$this->is_loaded = true;
		}
	}

	/**
	 * Load the json configuration of all marketplaces
	 */
	public static function loadApiMarketplace()
	{
		if (!self::$MARKETPLACES)
		{
			$connector  = new LengowConnector(LengowCore::getAccessToken(), LengowCore::getSecretCustomer());
			$results = $connector->get(
									'/v3.0/marketplaces', 
									array(
										'account_id' => LengowCore::getIdAccount()
									),
									'stream'
								);
			self::$MARKETPLACES = Tools::jsonDecode($results);
		}
	}

	/**
	* If marketplace exist in xml configuration file
	*
	* @return boolean
	*/
	public function isLoaded()
	{
		return $this->is_loaded;
	}

	/**
	* Get the real lengow's state
	*
	* @param string $name The marketplace state
	*
	* @return string The lengow state
	*/
	public function getStateLengow($name)
	{
		if (array_key_exists($name, $this->states_lengow))
			return $this->states_lengow[$name];
	}

	/**
	* Get the marketplace's state
	*
	* @param string $name The lengow state
	*
	* @return array 
	*/
	public function getState($name)
	{
		if (array_key_exists($name, $this->states))
			return $this->states[$name];
	}

	/**
	* Get the action with parameters
	*
	* @param string $name The action's name
	*
	* @return array
	*/
	public function getAction($name)
	{
		if (array_key_exists($name, $this->actions))
			return $this->actions[$name];
	}

	/**
	 * Get carrier name by code
	 *
	 * @param string $code carrier given in the API
	 *
	 * @return mixed
	 */
	public function getCarrierByCode($code)
	{
		if (array_key_exists($code, $this->carriers))
			return $this->carriers[$code];
		if (array_key_exists(Tools::strtoupper($code), $this->carriers))
			return $this->carriers[Tools::strtoupper($code)];
		return false;
	}

	/**
	* Return array of marketplaces from the marketplaces.xml file
	*
	* @return array $marketplaces
	*/
	public static function getMarkeplaces()
	{
		$marketplaces = array();
		if (LengowCheck::isValidAuth())
		{
			self::loadApiMarketplace();
			foreach (self::$MARKETPLACES as $key => $marketplace)
				$marketplaces[(string)$key] = (string)$key;
			ksort($marketplaces);
		}
		return array_merge(array('none' => ''), $marketplaces);
	}

	/**
	* Return array of marketplaces formated for select tag
	*
	* @return array 
	*/
	public static function getMarketplaceOptions()
	{
		$marketplaces = self::getMarkeplaces();
		$array_fields = array();
		foreach ($marketplaces as $key => $marketplace_name)
			$array_fields[] = new LengowOption($key, $marketplace_name);
		return $array_fields;
	}

	/**
	* Check if a status is valid for action
	*
	* @param array 		$action_status 	valid status for action
	* @param integer 	$id_status 		curent status id
	*
	* @return boolean 
	*/
	public function isValidState($action_status, $id_status)
	{
		foreach ($action_status as $status)
			if ($id_status == LengowCore::getOrderState($status))
				return true;
		return false;
	}

	/**
	* If action exist
	*
	* @param string $name The marketplace state
	*
	* @return boolean
	*/
	public function isAction($name)
	{
		return array_key_exists($name, $this->actions) ? true : false;
	}

	/**
	* Call the Lengow WSDL for current marketplace
	*
	* @param string $action The name of the action
	* @param string $id_order The order ID
	* @param string $args An array of arguments
	*/
	public function wsdl($action, $id_lengow_order, $args = array())
	{
		if (!in_array($action, self::$VALID_ACTIONS))
			return false;
		if (!$this->isAction($action))
			return false;

		$order = new LengowOrder($args['id_order']);
		$action_array = $this->getAction($action);

		$params = array(
			'account_id'			=> LengowCore::getIdAccount(),
			'marketplace_order_id' 	=> (string)$id_lengow_order,
			'marketplace'			=> (string)$order->lengow_marketplace
		); 

		if (isset($action_array['optional_args']))
			$all_args = array_merge($action_array['args'], $action_array['optional_args']);
		else 
			$all_args = $action_array['args'];

		switch ($action)
		{
			case 'ship' :
				$params['action_type'] = 'ship';  
				if (isset($all_args))
				{
					foreach ($all_args as $arg)
					{
						switch ($arg)
						{
							case 'tracking_number' :
								if (_PS_VERSION_ >= '1.5')
								{
									$id_order_carrier = $order->getIdOrderCarrier();
									$order_carrier = new OrderCarrier($id_order_carrier);
									$tracking_number = $order_carrier->tracking_number;
									if ($tracking_number == '')
										$tracking_number = $order->shipping_number;
								}
								else
									$tracking_number = $order->shipping_number;
								$params['tracking_number'] = $tracking_number;
								break;
							case 'carrier' :
								$carrier = new Carrier($order->id_carrier);
								$params['carrier'] = $this->_matchCarrier($carrier->name);
								break;
							case 'tracking_url' :
								if (_PS_VERSION_ >= '1.5')
								{
									$id_order_carrier = $order->getIdOrderCarrier();
									$order_carrier = new OrderCarrier($id_order_carrier);
									$tracking_number = $order_carrier->tracking_number;
									if ($tracking_number == '')
										$tracking_number = $order->shipping_number;
								}
								else
									$tracking_number = $order->shipping_number;
								$id_order_carrier = $order->getIdOrderCarrier();
								$carrier = new Carrier($order->id_carrier);
								$params['tracking_url'] = str_replace('@', $tracking_number, $carrier->url);
								break;
							case 'shipping_price' :
								$params['shipping_price'] = $order->total_shipping;
								break;
							default :
								break;
						}
					}
				}
				break;
			case 'cancel' :
				$params['action_type'] = 'cancel';
				if (isset($all_args))
				{
					foreach ($all_args as $arg)
					{
						switch ($arg)
						{
							default :
								break;
						}
					}
				}
				break;
		}
		try
		{
			$connector  = new LengowConnector(LengowCore::getAccessToken(), LengowCore::getSecretCustomer());
			// Get all params send
			$param_list = false;
			foreach ($params as $param => $value)
				$param_list .= (!$param_list ? '"'.$param.'": '.$value : ' -- "'.$param.'": '.$value);
			// if line_id is a required parameter -> send a call for each line_id
			if (in_array('line', $all_args)) 
			{
				$order_line_sent = false;
				$order_lines = LengowOrder::getOrderLineFromLengowOrder($order->id);
				if ($order_lines)
				{
					foreach ($order_lines as $order_line)
					{
						$params['line'] = $order_line['id_order_line'];
						if (!Configuration::get('LENGOW_DEBUG'))
							$result = $connector->post('/v3.0/orders/actions', $params);
						$order_line_sent .= (!$order_line_sent ? $params['line'] : ' / '.$params['line']);	
					}
					LengowCore::log('WSDL : '.$param_list.' -- "lines": '.$order_line_sent, false, $order->id);
				}
			} 
			else
			{
				if (!Configuration::get('LENGOW_DEBUG'))
					$result = $connector->post('/v3.0/orders/actions', $params);
				LengowCore::log('WSDL : '.$param_list, false, $order->id);
			}			
		} 
		catch(Exception $e) 
		{
			LengowCore::log('call error WSDL - exception: '.$e->getMessage(), false, $order->id);
		}
	}

	/**
	 * Match carrier's name with accepted values
	 *
	 * @param string   $name            
	 *
	 * @return string The matching carrier name
	 */
	private function _matchCarrier($name)
	{
		// no carrier
		if (count($this->carriers) == 0) 
			return $name;
		// search by code
		// exact match
		foreach ($this->carriers as $key => $carrier)
		{
			$value = (string)$key;
			if (preg_match('`'.$value.'`i', trim($name)))
				return $value;
		}
		// approximately match
		foreach ($this->carriers as $key => $carrier)
		{
			$value = (string)$key;
			if (preg_match('`.*?'.$value.'.*?`i', $name))
				return $value;
		}
		// no match
		return $name;
	}

}

/**
 * Thrown when an WSDL call returns an exception.
 *
 * @author Ludovic Drin <ludovic@lengow.com>
 */
class LengowWsdlExceptionAbstract extends Exception {

	/**
	* The result from the WSDL server that represents the exception information.
	*/
	protected $result;

	/**
	* Make a new WSDL Exception with the given result.
	*
	* @param array $result The error result
	*/
	public function __construct($result, $noerror)
	{
		$this->result = $result;
		if (is_array($result))
			$msg = $result['message'];
		else
			$msg = $result;
		parent::__construct($msg, $noerror);
	}

	/** 
	* Return the associated result object returned by the WSDL server.
	*
	* @return array The result from the WSDL server
	*/
	public function getResult()
	{
		return $this->result;
	}

	/**
	* Returns the associated type for the error.
	*
	* @return string
	*/
	public function getType()
	{
		if (isset($this->result['type']))
			return $this->result['type'];
		return 'LengowWsdlException';
	}

	/**
	* To make debugging easier.
	*
	* @return string The string representation of the error
	*/
	public function __toString()
	{
		if (isset($this->result['message']))
			return $this->result['message'];
	return $this->message;
	}
}