<?php

class ExpeditorModule extends ObjectModel
{
	public $id_order;
	public $weight;
	public $standard_size;
	public $is_send;
	public $date_add;
	public $date_upd;

	public $product_codes = array(
		'CORE' => array(
			'ref' => 'CORE',
			'name' => 'CORE - Retour Colissimo France',
			'prefix' => '8R'
		),
		'CORI' => array(
			'ref' => 'CORI',
			'name' => 'CORI - Retour Colissimo Inter',
			'prefix' => '7A'
		),
		'CDS' => array(
			'ref' => 'CDS',
			'name' => 'CDS - Colissimo Expert OM',
			'prefix' => '7A'
		),
		'COLI' => array(
			'ref' => 'COLI',
			'name' => 'COLI - Colissimo Expert Inter',
			'prefix' => 'CD,CY'
		),
		'COL' => array(
			'ref' => 'COL',
			'name' => 'COL - Colissimo Expert France',
			'prefix' => '8V'
		),
		'COM' => array(
			'ref' => 'COM',
			'name' => 'COM - Colissimo Access OM',
			'prefix' => '8Q'
		),
		'COLD' => array(
			'ref' => 'COLD',
			'name' => 'COLD - Colissimo Access France',
			'prefix' => '8L'
		),
		'ACCI' => array(
			'ref' => 'ACCI',
			'name' => 'ACCI - Colissimo Acces Inter',
			'prefix' => 'CL,LC'
		),
		'COE' => array(
			'ref' => 'COE',
			'name' => 'COE - Colissimo Economique OM',
			'prefix' => '8M'
		),
		'SO' => array(
			'ref' => 'SO',
			'name' => 'SO - Socolissimo tout service',
			'prefix' => ''
		)
	);

	protected $fieldsRequired = array('id_order');
	protected $fieldsSize = array(
		'weight' => 16,
		'standard_size' => 1
	);
	protected $fieldsValidate = array(
		'id_order' => 'isUnsignedId',
		'weight' => 'isFloat',
		'standard_size' => 'isBool'
	);

	protected $table = 'expeditor';
	protected $identifier = 'id_expeditor';

	public function getFields()
	{
		parent::validateFields();
		$fields = array();
		$fields['id_order']      = (int)$this->id_order;
		$fields['weight']        = (float)$this->weight;
		$fields['standard_size'] = (int)$this->standard_size;
		$fields['is_send']       = (int)$this->is_send;
		$fields['date_add']      = pSQL($this->date_add);
		$fields['date_upd']      = pSQL($this->date_upd);
		return $fields;
	}

	static public function getByIdOrder($id_order)
	{
		$sql = '
			SELECT id_expeditor as id
			FROM `'._DB_PREFIX_.'expeditor` e
			WHERE e.`id_order` = '.(int)$id_order.'
		';
		$result = Db::getInstance()->getRow($sql);
		if ($result['id'] > 0)
			return $result['id'];
		return ;
	}

	static function getOrders()
	{
		if (version_compare(_PS_VERSION_, '1.5.0.0') >= 0) {
			$context = Context::getContext();
			$id_shop = $context->shop->id;
		}
		else {
			$id_shop = 1;
		}

		$id_order_state = Configuration::get('EXPEDITOR_STATE_EXP');
		$id_carrier = explode(',',Configuration::get('EXPEDITOR_CARRIER', NULL, NULL, $id_shop));
		
		foreach ($id_carrier as $value) 
		{
			$reference = Db::getInstance()->getValue("SELECT `id_reference` FROM `" . _DB_PREFIX_ . "carrier` WHERE `id_carrier`='" . pSQL($value) . "'");
			$result = Db::getInstance()->ExecuteS("SELECT `id_carrier` FROM `" . _DB_PREFIX_ . "carrier` WHERE `id_reference`='" . pSQL($reference) . "'");
			foreach ($result as $key => $carrier)
				$id_carrier[] = $carrier['id_carrier'];
		}

		$sql = '
			SELECT o.id_order as id_order, o.`id_customer` as id_customer,
				CONCAT(c.`firstname`, \' \', c.`lastname`) AS `customer`,
				o.total_paid_real as total, o.total_shipping as shipping,
				o.date_add as date, o.id_currency as id_currency, o.id_lang as id_lang,
				SUM(od.product_weight * od.product_quantity) as weight, e.standard_size as standard_size, e.is_send as is_send
			FROM `'._DB_PREFIX_.'orders` o
				LEFT JOIN `'._DB_PREFIX_.'order_detail` od ON (o.`id_order` = od.`id_order`)
				LEFT JOIN `'._DB_PREFIX_.'expeditor` e ON (e.`id_order` = o.`id_order`)
				LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = o.`id_customer`)
				LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (oh.`id_order` = o.`id_order`)
				LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
				LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = o.`id_lang`)
			WHERE  (SELECT moh.`id_order_state` FROM `'._DB_PREFIX_.'order_history` moh WHERE moh.`id_order` = o.`id_order` ORDER BY moh.date_add DESC LIMIT 1) = '.(int)$id_order_state;
			if ($id_carrier)
			{
				$sql .= ' AND o.id_carrier in (';
				foreach ($id_carrier as $val) {
					$sql .= (int)$val.',';
				}
				$sql = rtrim($sql, ',');
			}
			$sql .= ')
			GROUP BY o.`id_order`, od.`id_order`
			ORDER BY o.`date_add` ASC';
		return Db::getInstance()->ExecuteS($sql);
	}

	static function getList()
	{
		if (version_compare(_PS_VERSION_, '1.5.0.0') >= 0) {
			$context = Context::getContext();
			$id_shop = $context->shop->id;
		}
		else {
			$id_shop = 1;
		}

		$id_order_state = Configuration::get('EXPEDITOR_STATE_EXP');
		$id_carrier = explode(',',Configuration::get('EXPEDITOR_CARRIER', NULL, NULL, $id_shop));

		foreach ($id_carrier as $value) 
		{
			$reference = Db::getInstance()->getValue("SELECT `id_reference` FROM `" . _DB_PREFIX_ . "carrier` WHERE `id_carrier`='" . pSQL($value) . "'");
			$result = Db::getInstance()->ExecuteS("SELECT `id_carrier` FROM `" . _DB_PREFIX_ . "carrier` WHERE `id_reference`='" . pSQL($reference) . "'");
			foreach ($result as $key => $carrier)
				$id_carrier[] = $carrier['id_carrier'];
		}

		$sql = '
			SELECT e.id_order as id_order, e.weight as weight, e.standard_size as standard_size,
				o.id_carrier as id_carrier
			FROM `'._DB_PREFIX_.'orders` o
				LEFT JOIN `'._DB_PREFIX_.'expeditor` e ON (e.`id_order` = o.`id_order`)
				LEFT JOIN `'._DB_PREFIX_.'customer` c ON (c.`id_customer` = o.`id_customer`)
				LEFT JOIN `'._DB_PREFIX_.'order_history` oh ON (oh.`id_order` = o.`id_order`)
				LEFT JOIN `'._DB_PREFIX_.'order_state` os ON (os.`id_order_state` = oh.`id_order_state`)
				LEFT JOIN `'._DB_PREFIX_.'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = o.`id_lang`)
			WHERE  e.weight != 0 AND (SELECT moh.`id_order_state` FROM `'._DB_PREFIX_.'order_history` moh WHERE moh.`id_order` = o.`id_order` ORDER BY moh.date_add DESC LIMIT 1) = '.(int)$id_order_state;
			if ($id_carrier)
			{
				$sql .= ' AND o.id_carrier in (';
				foreach ($id_carrier as $val) {
					$sql .= (int)$val.',';
				}
				$sql = rtrim($sql, ',');
			}
			$sql .= ')';
			$sql .= ' GROUP BY o.`id_order` ORDER BY o.`date_add` ASC';

		return Db::getInstance()->ExecuteS($sql);
	}
}