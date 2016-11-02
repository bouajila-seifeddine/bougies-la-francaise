<?php

class FrontController extends FrontControllerCore
{
	// Google Trusted Stores requires order confirmation on https / SSL
	// but PrestaShop does not force SSL on order confirmation
	public function __construct()
	{
		$this->controller_type = 'front';

		global $useSSL;

		parent::__construct();

		// BT - add override on detecting PayPal's payment controller
		if (Configuration::get('PS_SSL_ENABLED') && Configuration::get('PS_SSL_ENABLED_EVERYWHERE')
			|| (strstr($_SERVER['SCRIPT_NAME'], 'paypal') || strstr($_SERVER['REQUEST_URI'], 'paypal'))
		) {
			$useSSL = true;
		}

		if (isset($useSSL))
			$this->ssl = $useSSL;
		else
			$useSSL = $this->ssl;
	}

	
    public function initContent() {
		$id_order = (int)Tools::getValue('id_order');

		if (!empty($id_order)) {
			$order = new Order((int)($id_order));
			$currency = new Currency($order->id_currency);
			$products = $order->getProducts();
			
			if (is_array($products) && !empty($products)) {
				foreach($products as &$product) {
					$category_obj = new Category($product['id_category_default'], $this->context->cookie->id_lang);
					$product['product_category'] = $category_obj->name;
				}
			}
			
			$this->context->smarty->assign(array(			
				'order_data' => $order,
				'currency' => $currency,
				'products' => $products,
				'order_total_paid' => $order->total_paid	
			));	
		}
		
		return parent::initContent();
    }	
    
    public function setMedia()
    {
        parent::setMedia();

        /* déplacer dans le fichier /themes/blf/footer.tpl
		$this->addJS(_THEME_JS_DIR_.'vendor/modernizr-2.6.2.min.js');
        $this->addJS(_THEME_JS_DIR_.'vendor/plugins.js');
        $this->addJS(_THEME_JS_DIR_.'script.js'); 
		*/
    }
}

