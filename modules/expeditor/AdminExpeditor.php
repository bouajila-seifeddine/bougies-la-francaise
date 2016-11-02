<?php

include_once(dirname(__FILE__).'/ExpeditorModule.php');

class AdminExpeditor extends AdminTab
{
	private $columnName = 'ReferenceExpedition';
	private $prefix = 'EXP';
	private $displayInfos = true;

	public function __construct()
	{
		$this->table = 'expeditor';
		$this->className = 'ExpeditorModule';

		parent::__construct();
	}

	private function _treatCsvFile($file)
	{
		global $cookie;

		/*
		 * get all informations of CSV file
		 */
		$row = 0;
		$infos = array();
		$handle = fopen($file, "r");
		while (($data = fgetcsv($handle, 2000, ';', '"')) !== FALSE)
		{
			for ($c=0; $c < sizeof($data); $c++)
			{
				$infos[$row][$c] = $data[$c];
			}
			$row++;
		}
		
		/*
		 * Extract all needings informations
		 */
		 
		if (($keyId = array_search($this->columnName, $infos[0])) === false)
			return false;
		$keyShippingNumber = array_search('NumeroColis', $infos[0]);

		echo '<p>' . $this->l('List of orders recognized') . '</p>';
		echo '<ul>';

		unset($infos[0]); // delete csv header
		foreach ($infos as $info)
		{
			$id_order = (int)eregi_replace($this->prefix, '', $info[$keyId]);
			$shipping_number = $info[$keyShippingNumber];

			$id_expeditor = ExpeditorModule::getByIdOrder($id_order);
			if (!is_numeric($id_expeditor)) continue;
			$expeditor = new ExpeditorModule($id_expeditor);
			$expeditor->is_send = 1;
			$expeditor->save();

			$order = new Order($id_order);
			// Avoid to make multiple submissions
			if (version_compare(_PS_VERSION_, '1.5.0.4') >= '0')
			{
				$id_order_carrier = Db::getInstance()->getValue('
				SELECT `id_order_carrier`
				FROM `'._DB_PREFIX_.'order_carrier`
				WHERE `id_order` = ' . (int)$id_order );
				
				$order_carrier = NULL;
				if ($id_order_carrier)
					$order_carrier = new OrderCarrier( $id_order_carrier );
			
				if ($order_carrier && !$order_carrier->tracking_number )
				{
					$order_carrier->tracking_number = $shipping_number;
					$order_carrier->update();
				}
			}
			else if ($order->shipping_number == '')
			{
				$order->shipping_number = $shipping_number;
				$order->update();
			}

			$customer = new Customer($order->id_customer);
			$carrier = new Carrier((int)$order->id_carrier, (int)$order->id_lang);
			$templateVars = array('{followup}' => str_replace('@', $shipping_number, $carrier->url));

			$history = new OrderHistory();
			$history->id_order = $id_order;
			$history->changeIdOrderState(Configuration::get('EXPEDITOR_STATE_IMP'), $id_order); // Shipping
			$history->id_employee = intval($cookie->id_employee);
			$history->addWithemail(true, $templateVars);
			
			global $_LANGMAIL;
			$templateVars = array(
				'{followup}' => str_replace('@', $shipping_number, $carrier->url),
				'{firstname}' => $customer->firstname,
				'{lastname}' => $customer->lastname,
				'{id_order}' => intval($order->id),
                '{order_name}' => $order->getUniqReference(),
			);
			//send email with traking number
			$subject = 'Package in transit';
			if (Mail::Send(intval($order->id_lang), 'in_transit', ((is_array($_LANGMAIL) AND key_exists($subject, $_LANGMAIL)) ? $_LANGMAIL[$subject] : $subject), $templateVars, $customer->email, $customer->firstname.' '.$customer->lastname))
				echo '<br/>' . $this->l('Email send to') . ':&nbsp;' . $customer->email;
			else
				echo '<br/>' . $this->l('Email faild to') . ':&nbsp;' . $customer->email;
			echo '<li>' . $this->l('Order number') . ':&nbsp;' . $id_order;
			echo '<br/>' . $this->l('Shipping number') . ':&nbsp;' . $shipping_number;
			echo "</li>\n";
		}
		echo '</ul>';
		echo '
		<form action="index.php" method="get">
			<p>
				<input type="hidden" name="tab" value="AdminExpeditor" />
				<input type="hidden" name="token" value="'.Tools::getValue('token').'" />
				<input type="submit" value="'.$this->l('   Back   ').'" class="button" />
			</p>
		</form>';

		return true;
	}

	private function _importNumber()
	{
		$file = $_FILES['file']['tmp_name'];
		if ($html = $this->_treatCsvFile($file))
		{
			$this->displayInfos = false;
			return true;
		}
		return false;
	}

	private function _generateCsvFile()
	{
		foreach($_POST['order'] as $field)
		{
			if (is_numeric($field['weight']) AND $field['weight'] > 0)
			{
				$id_expeditor = ExpeditorModule::getByIdOrder($field['id']);
				$expeditor = new ExpeditorModule($id_expeditor);
				$expeditor->id_order = $field['id'];
				$expeditor->weight = $field['weight'];
				$expeditor->standard_size = 0;
				if ($field['standard_size'] == '0')
					$expeditor->standard_size = 1;
				$expeditor->save();
			}
		}
		header('Location: http://'. htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ .'modules/expeditor/getCsv.php');
	}

	private function _postProcess()
	{
		if (isset($_POST['generate']))
		{
			$this->_generateCsvFile();
		}
		else if (isset($_POST['import']))
		{
			if (empty($_FILES['file']['tmp_name']) OR !isset($_FILES['file']))
			{
				return '<p class="alert">' . $this->l('Please upload a CSV file.') . '</p>';
			}
			else
			{
				if (!$this->_importNumber())
					return '<p class="alert">'.$this->l('Column').' '.$this->columnName.' '.$this->l('is required').'.'.'</p>';
			}
		}
	}

	private function displayOrdersTable()
	{
		global $cookie;

		$order_state = new OrderState(Configuration::get('EXPEDITOR_STATE_EXP'));
		
		$html = '';
		$html.= '<p>'.$this->l('All orders which have the state').' "<b>'.$order_state->name[$cookie->id_lang].'</b>"';

		foreach(explode(',',Configuration::get('EXPEDITOR_CARRIER')) as $val ) {
		$carrier = new Carrier($val);
		if ($carrier->id) $html.= '&nbsp;'.$this->l('and the carrier').' "<b>'.$carrier->name.'</b>"';
		}
		$html.= '.&nbsp;<p><a href="index.php?tab=AdminModules&configure=expeditor&token='.Tools::getAdminToken('AdminModules'.intval(Tab::getIdFromClassName('AdminModules')).intval($cookie->id_employee)).'" class="green">' . $this->l('Change configuration') . '</a></p>';

		$orders = ExpeditorModule::getOrders();
		if (empty($orders))
		{
			$html.= '<h3>' . $this->l('No orders with this state.') . '</h3>';
		}
		else
		{
			$html.= '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
			$html.= "\n<table class=\"table\" cellpadding=\"0\" cellspacing=\"0\">";
			$html.= '<tr>';
			$html.= '<th>' . $this->l('Order ID') . '</th>';
			$html.= '<th>' . $this->l('Customer') . '</th>';
			$html.= '<th>' . $this->l('Total price') . '</th>';
			$html.= '<th>' . $this->l('Total shipping') . '</th>';
			$html.= '<th>' . $this->l('Date') . '</th>';
			$html.= '<th>' . $this->l('Weight (grams)') . '</th>';
			$html.= '<th>' . $this->l('Non-standard size') . '</th>';
			$html.= '<th>' . $this->l('Detail') . '</th>';
			$html.= '</tr>';
			foreach ($orders as $order)
			{
				$oOrder = new Order($order['id_order']);
				
				$products = $oOrder->getProducts();
				$total_weight = 0;
				foreach($products AS $product)
					$total_weight += $product['product_weight'] * $product['product_quantity'];
				
				$html.= "\n<tr>";
				$html.= '<td>' . $order['id_order'] . '<input type="hidden" name="order[' . $order['id_order'] . '][id]" id="id_order_' . $order['id_order'] . '" value="' . $order['id_order'] . '" /></td>';
				$html.= '<td>' . $order['customer'] . '</td>';
				$html.= '<td>' . Tools::displayPrice($order['total'], new Currency($order['id_currency'])) . '</td>';
				$html.= '<td>' . Tools::displayPrice($order['shipping'], new Currency($order['id_currency'])) . '</td>';
				if (version_compare(_PS_VERSION_, '1.5.0.0') >= 0) 
					$html.= '<td>' . Tools::displayDate($order['date']) . '</td>';
				else
					$html.= '<td>' . Tools::displayDate($order['date'], $order['id_lang']) . '</td>';
				$html.= '<td><input type="text" name="order[' . $order['id_order'] . '][weight]" id="weight_' . $order['id_order'] . '" size="8" value="';
				if (($total_weight * Configuration::get('EXPEDITOR_MULTIPLY')) == 0) 
					$html.=  '1'; 
				else 
					$html.= ($total_weight * Configuration::get('EXPEDITOR_MULTIPLY'));
				$html.= '" /></td>';
				$html.= '<td><input type="checkbox" name="order[' . $order['id_order'] . '][standard_size]" id="standard_size_' . $order['id_order'] . '" value="0" /><label for="standard_size_' . $order['id_order'] . '" class="t">&nbsp;' . $this->l('tick this') . '</label></td>';
				$html.= '<td class="center">
					<a href="index.php?tab=AdminOrders&id_order='.$order['id_order'].'&vieworder&token='.Tools::getAdminToken('AdminOrders'.intval(Tab::getIdFromClassName('AdminOrders')).intval($cookie->id_employee)).'">
					<img border="0" title="'.$this->l('View').'" alt="'.$this->l('View').'" src="'._PS_IMG_.'admin/details.gif"/></a>
				</td>';
				$html.= '</tr>';
			}
			$html.= '</table><br>';
			$html.= '<input type="submit" name="generate" id="generate" value="' . $this->l('Generate') . '" class="button" />';
			$html.= '</form>';
		}
		return $html;
	}

	public function displayImportForm()
	{
		$_html = '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';
		$_html.= '<fieldset>';
		$_html.= '<legend>' . $this->l('Import Shipping Number') . '</legend>';
		$_html.= '<p><label for="file" class="t">' . $this->l('Select a CSV file generated by Expeditor') . '</label></p>';
		$_html.= '<input type="hidden" name="MAX_FILE_SIZE" value="500000" />';
		$_html.= '<input type="file" name="file" id="file" class="button" size="60" />';
		$_html.= '<p><input type="submit" name="import" id="import" value="' . $this->l('Import file') . '" class="button" /></p>';
		$_html.= '</fieldset>';
		$_html.= '</form>';
		return $_html;
	}

	public function display()
	{
		$html = '<div class="leadin"></div><fieldset>';

		if (!empty($_POST))
			$html.= $this->_postProcess();

		if ($this->displayInfos)
		{
			$html.= $this->displayOrdersTable();
			$html.= '<br/><br/>';
			$html.= $this->displayImportForm();
		}
		$html .= '</fieldset>';
		echo $html;
	}

}