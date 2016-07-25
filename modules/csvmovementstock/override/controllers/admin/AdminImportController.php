<?php
/**
* Override Class AdminImportController
*/

class AdminImportController extends AdminImportControllerCore {


	public function __construct()
	{
		parent::__construct();

		$this->entities[$this->l('Stock')] = count($this->entities);

		switch ((int)Tools::getValue('entity'))
		{
			case $this->entities[$this->l('Stock')]:
				//Overwrite required_fields AS only email is required whereas other entities
				$this->required_fields = array('reference', 'quantity');

				$this->available_fields = array(
                    'no' => array('label' => $this->l('Ignore this column')),
                    'reference' => array('label' => $this->l('reference of Product/Combinaison')),
                    'quantity' => array('label' => $this->l('Quantity')),
					'id_shop' => array(
						'label' => $this->l('ID / Name of shop'),
						'help' => $this->l('Ignore this field if you don\'t use the Multistore tool. If you leave this field empty, the default shop will be used.'),
					),
				);

				self::$default_values = array(
					'id_shop' => Configuration::get('PS_SHOP_DEFAULT'),
				);
			break;
		}
	}

	public function postProcess()
	{
        parent::postProcess();
        
        if (Tools::getValue('import')) {
            
            if (Tools::getValue('csv'))
			{
                $import_type = false;
                switch ((int)Tools::getValue('entity'))
				{
					case $this->entities[$import_type = $this->l('Stock')]:
						$this->stockImport();
						$this->clearSmartyCache();
						break;
                }
                if ($import_type !== false)
				{
					$log_message = sprintf($this->l('%s import', 'AdminTab', false, false), $import_type);
					if (Tools::getValue('truncate'))
						$log_message .= ' '.$this->l('with truncate', 'AdminTab', false, false);
					Logger::addLog($log_message, 1, null, $import_type, null, true, (int)$this->context->employee->id);
				}
            }
        }
	}
    
    public function stockImport() {
        $this->receiveTab();
		$handle = $this->openCsvFile();
		AdminImportController::setLocale();
		for ($current_line = 0; $line = fgetcsv($handle, MAX_LINE_SIZE, $this->separator); $current_line++)
		{            
			if (Tools::getValue('convert'))
				$line = $this->utf8EncodeArray($line);
			$info = AdminImportController::getMaskedRow($line);

			AdminImportController::setDefaultValues($info);
            
            if(empty($info['id_shop'])) {
                $id_shop = null;
            }
            else {
                $id_shop = $info['id_shop'];
            }
            
            //Test if Combination have reference********************************
            $productId = Combination::getIdProductByReference($info['reference']);
            if($productId != false) {
                $idProductAttribute = Combination::getIdByReference($productId, $info['reference']);
                
                $currentStock = StockAvailable::getQuantityAvailableByProduct($productId, $idProductAttribute, $id_shop);
                $newStock = (int) ($currentStock + $info['quantity']);
                
                StockAvailable::setQuantity($productId, $idProductAttribute, $newStock, $id_shop);
            }
            else {
                $productId = Product::getIdByReference($info['reference']);
                $product = new Product($productId);
                $combination = $product->getAttributeCombinations($this->context->language->id);
                
                //Test if Product have NO Combinaison***************************
                if($productId != false && count($combination) == 0) {
                    $currentStock = StockAvailable::getQuantityAvailableByProduct($productId, 0, $id_shop);
                    $newStock = (int) ($currentStock + $info['quantity']);

                    StockAvailable::setQuantity($productId, 0, $newStock, $id_shop);
                }
                //Test if Product have ONE Combinaison**************************
                else if($productId != false && count($combination) == 1) {
                    $currentStock = StockAvailable::getQuantityAvailableByProduct($productId, $combination[0]['id_product_attribute'], $id_shop);
                    $newStock = (int) ($currentStock + $info['quantity']);

                    StockAvailable::setQuantity($productId, $combination[0]['id_product_attribute'], $newStock, $id_shop);
                }
                else {
                    $this->errors[] = $this->l('Reference').' ('.$info['reference'].') '.$this->l('Cannot be saved');
                }
            }
		}
		$this->closeCsvFile($handle);
    }
}
?>
