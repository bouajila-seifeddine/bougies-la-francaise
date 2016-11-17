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
		self::doGTM();
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
				'products' => $products,
				'order_total_paid' => $order->total_paid
			));	
		}
		
		return parent::initContent();
    }	


    public function doGTM()
    {
    	$gtm_datas = array();
    	$site_name = "'" . Configuration::get('PS_SHOP_NAME') . "'";
    	$site_url_t = _PS_BASE_URL_ ;
    	$site_url = "'" . substr($site_url_t, 11) . "'";
    	$page_name = (string)$this->php_self;
    	$page_name_formated =  (string)"'" . $this->php_self . "'";

    	if($page_name == '')
    	{
	 		if(strpos($_SERVER['REQUEST_URI'], '/module/paypal/submit?key=') == 1)
	 		{
				$page_name = 'module-paypal-submit';
				$page_name_formated =  (string) '"'. 'module-paypal-submit' .'"';
	 		}
    	}

    	if($this->context->customer->isLogged())
    		$gtm_datas[$page_name]['USER_ID'] = (int)$this->context->customer->id;

    	if($page_name != 'order')
    		$gtm_datas[$page_name]['step']= '0';

    	// gtm page home / category / search
    	if($page_name == 'index' || $page_name == 'category' || $page_name == 'search' || $page_name == 'product' || $page_name == 'order' || $page_name == 'module-paypal-submit' || $page_name == 'order-confirmation' || $page_name == 'my-account')
    	{
    		$gtm_datas[$page_name]['page_type'] = (string)$page_name_formated;
    		$gtm_datas_cart = self::doGTMCart($gtm_datas,$page_name);
    		if(is_array($gtm_datas) && is_array($gtm_datas_cart))
    			$gtm_datas = array_merge($gtm_datas,$gtm_datas_cart);
    	}

    	if($page_name == 'order' || ($page_name == "authentification" && !empty(Tools::getValue('back'))))
    	{
    		$array_steps = array("summary" => 1 ,"login" => 2 ,"address" => 3 ,"shipping" => 4,"payment" => 5);
    		$this->context->smarty->assign("ARRAY_STEP" , $array_steps);
    	}

    	// page produit 
    	if ($page_name == 'product') 
    	{
    		$id_product = (int)Tools::getValue('id_product');
    		if(!empty($id_product))
    		{
    			$product = new Product((int)($id_product));
    			$gtm_datas[$page_name]['product_ID'] 	= (int)$id_product;
				$gtm_datas[$page_name]['product_name'] 	= "'" . (string)$product->name[$this->context->cookie->id_lang] . "'";
				$gtm_datas[$page_name]['product_price'] = (float)number_format($product->getPublicPrice(),2);
    		}
    	}

    	// gtm page confirm-commande
    	if($page_name == 'order-confirmation' || $page_name == 'module-paypal-submit')
    	{
    		$gtm_datas[$page_name]['step'] = 6;
    		$str = '[';
    		$str_id = '';
			$str_product_name = '';
			$str_product_price = '';
    		$event = "'confirmation'";

    		$id_order = (int)Tools::getValue('id_order');
    		if (!empty($id_order)) 
    		{
    			$order = new Order((int)($id_order));
    			$products = $order->getProducts();
				$order_taxes = ((float)$order->total_paid_tax_incl - (float)$order->total_paid_tax_excl);

	    		$i=0;
				if (is_array($products) && !empty($products)) {
					$len = count($products);

					if($len > 1)
					{
						$str_id .= '[';
						$str_product_name .= '[';
						$str_product_price .= '[';
					}

					foreach($products as $k => $v)
					{
						$cat = new Category($v['id_category_default']);
						$str .= '{';  
						$str .= "product_name: '" . (string)$v['product_name'] . "', ";
						$str .= "product_ID: " . (int)$v['product_id'] . ", ";
						$str .= "price: " . (float)$v['product_price'] . ", ";
						$str .= "category: '" . (string)$cat->name[$this->context->cookie->id_lang] . "', ";
						$str .= "quantity: " . (int)$v['product_quantity'] ;
						

	    				$pdt = new Product($v['id_product']);

	    				$str_id .=  (int)$v['product_id'] ;
	    				$str_product_name .=  "'" . (string)$v['product_name'] . "'"; 
	    				$str_product_price  .= (float)$v['product_price']; 

	    				if ($len > 1 && ($i != $len - 1))
	    				{
	    					$str_id .= ','; 
		    				$str_product_name .= ','; 
		    				$str_product_price  .= ','; 
	    				}
						$str .= '}';
						if ($len > 1 && $i != $len - 1)
							$str .= ',';
						else
							$str .= '';
						$i++;
					}

					if($len > 1)
					{
						$str_id .= ']';
						$str_product_name .= ']';
						$str_product_price .= ']';
					}
				}
				$str .= ']';
				$gtm_datas[$page_name]['event'] 				 = (string)$event;
				$gtm_datas[$page_name]['total_value'] 			 = (float)$order->total_paid;
				$gtm_datas[$page_name]['transactionId'] 		 = (int)$id_order;
				$gtm_datas[$page_name]['transactionAffiliation'] = $site_url;
				$gtm_datas[$page_name]['transactionTotal'] 		 = (float)$order->total_paid;
				$gtm_datas[$page_name]['transactionTax'] 		 = (float)$order_taxes;
				$gtm_datas[$page_name]['transactionShipping'] 	 = (float)$order->total_shipping_tax_excl;
				$gtm_datas[$page_name]['transactionProducts'] 	 = $str;
				$gtm_datas[$page_name]['product_ID'] 			 = $str_id;
				$gtm_datas[$page_name]['product_name']			 = $str_product_name;
				$gtm_datas[$page_name]['product_price']			 = $str_product_price;

    		}
    	}

    	if(!empty($gtm_datas))
    		$this->context->smarty->assign('GTM_DATAS', $gtm_datas);
    	else
    		$this->context->smarty->assign('GTM_DATAS', '');
    }

    public function doGTMCart($gtm_datas,$page_name)
    {
    	$cart_products = $this->context->cart->getProducts();
    	if(empty($cart_products))
    	{
    		$id_order = (int)Tools::getValue('id_order');
    		if(!empty($id_order))
    		{
    			$order = new Order($id_order);
    			$cart_products = $order->getProducts(); 
    		}
    	}
		$currency = Currency::getCurrency((int)$this->context->cart->id_currency);
		$str_id = '';
		$str_product_name = '';
		$str_product_price = '';
		if(!empty($cart_products))
		{
			if (is_array($cart_products) && !empty($cart_products)) {
				$len = count($cart_products);
				if($len > 1)
				{
					$str_id .= '[';
					$str_product_name .= '[';
					$str_product_price .= '[';
				}
				$i = 0;
    			foreach ($cart_products as $k => $v) {
    				$pdt = new Product($v['id_product']);
    				$str_id .= "'" . $v['id_product'] . "'";
    				$str_product_name .= (string) "'" . $pdt->name[$this->context->cookie->id_lang] . "'"; 
    				$str_product_price  .= "'" . (float)number_format($pdt->getPublicPrice(),2)  . "'"; 

    				if ($len > 1 && ($i != $len - 1))
    				{
    					$str_id .= ','; 
	    				$str_product_name .= ','; 
	    				$str_product_price  .= ','; 
    				}
    				$i++;    				
    			}
				if($len > 1)
				{
					$str_id .= ']';
					$str_product_name .= ']';
					$str_product_price .= ']';
				}
			}

			$gtm_datas[$page_name]['total_value'] = (float)$this->context->cart->getOrderTotal();
			$gtm_datas[$page_name]['product_ID'] = $str_id;
			$gtm_datas[$page_name]['product_name'] = $str_product_name;
			$gtm_datas[$page_name]['product_price'] = $str_product_price;

			return $gtm_datas;
		}
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

