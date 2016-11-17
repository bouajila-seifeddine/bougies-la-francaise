<?php
/**
* @copyright Enter-Solutions since 2015
* @license see licence.txt for details
* @author Enter-Solutions
*
* Provides Google Analytics measurement protocol & conversion
* 
* Change logs: (last first)
*   dk: 23-11-2015: 1.16: Isolate UA from ganalitycs +fix gclid (pasthru)
*   dk: 14-11-2015: 1.15: Fix pageview, event ordering
*   dk: 10-11-2015: 1.14: Option for robots exclusion
*   			  php-fpm fix
*   			  change session cookie (_gas) timeout
*   			  page load time + vp and sd fix
*   			  transaction step 6 of Enhanced Ecommerce
*   dk: 09-11-2015: 1.13: Fix url based goal during checkout
*   dk: 09-11-2015: 1.12: Fix robots tainting
*   dk: 06-11-2015: 1.11: Various fixes + product details + vp and sd 
*   dk: 06-11-2015: 1.10: Implement refund/cancel on transaction
*   dk: 04-11-2015: 1.9: Detect/isolate robots traffic 
*   dk: 02-11-2015: 1.8: Implement (experimental) display features beacon
*   dk: 02-11-2015: 1.7: Fixes enhanced ecommerce feed on transaction
*   dk: 02-11-2015: 1.6: Try hard to recover session to avoid conversion referal lost
*   dk: 01-11-2015: 1.5: Fixes authentication / new registration
*   dk: 31-10-2015: 1.4: remove hook displayProductList + prune some query strings
*   dk: 31-10-2015: 1.3: Better handle adwords + fix php5.3 array() vs []
*   dk: 29-10-2015: 1.2: Better handling of sandbox mode + installer update
*   dk: 17-10-2015: 1.1: Cosmetics and 1.3.1.1 support
*   dk: 14-10-2015: 1.0: Initial version
**/

if (!defined('_PS_VERSION_'))
	exit;

define('_GAMP_DEV_', false);
define('_GAMP_BETA_', false);

if (_GAMP_DEV_)
{
	error_reporting(E_ALL | E_STRICT );
	@ini_set('display_error','on');
	set_error_handler(create_function('$errno,$errmsg,$errfile,$errline',<<< FUNC
		{
			if (error_reporting() == 0) return true;

			if (substr(basename(\$errfile),-8) == '.tpl.php') return true;
			if (basename(\$errfile) != 'gampModule.php') return true;
			
			error_reporting(0);
			restore_error_handler();
			while (ob_get_level()) ob_end_flush();
			echo '<pre>'.print_r(debug_backtrace(),true).'</pre>';
			exit(0);
		}
FUNC
	),E_ALL | E_STRICT);
}

// Quick normalization 1.3  vs 1.4
defined('_PS_USE_SQL_SLAVE_') OR define('_PS_USE_SQL_SLAVE_', 0);
defined('_MYSQL_ENGINE_') OR define('_MYSQL_ENGINE_', 'MyISAM');
defined('PS_ADMIN_DIR') AND !defined('_PS_ADMIN_DIR_') AND define('_PS_ADMIN_DIR_', PS_ADMIN_DIR); 

class gamp extends Module
{
	public static $HOOKS = 'header,newOrder,cart,createAccount,updateOrderStatus';

	protected $smarty = NULL;
	protected static $id_lang = 1;
	protected $page_name = 'none';
	protected $specific = 'none';
	protected static $cookie = NULL;

	protected $_assigns = array();
	
	public $analytics = array();
	public $payloads = array();
	public $referer = null;
	public $ga_endpoint = 'https://www.google-analytics.com/collect';
	public $cid = 0;
	public $__utma = null;
	public $sid = 0;
	public $time0;
	public $time1;
	public $timeb = null;
	static protected $trace = false;
	static protected $categories = null;
	public static $passthru = array(
			'utm_id'	=> 'utm_id',
			'utm_campaign'	=> 'utm_campaign',
			'utm_source'	=> 'utm_source',
			'utm_medium'	=> 'utm_medium',	
			'utm_term'	=> 'utm_term',
			'utm_content'	=> 'utm_content',
			'gclid'		=> 'gclid',
			'dclid'		=> 'dclid',	
			'gclsrc'	=> 'gclsrc',
	);
	
	function __construct()
	{
		$this->time1 = $this->time0 = microtime(true);
		
		$this->_errors = array();
		$this->name = strtolower(__CLASS__);
		$this->specific = strtolower(basename(__FILE__,'.php'));

		if (version_compare(_PS_VERSION_,'1.4','<'))
			$this->tab = 'Stats';
		else
			$this->tab = 'analytics_stats';
		$this->version = '1.16';
		$this->author = 'Enter-Solutions';
		$this->ps_versions_compliancy = array('min' => '1.3.1.1', 'max' => _PS_VERSION_);
		$this->need_instance = 0;

		parent::__construct();

		if (!$this->active && defined('_PS_ADMIN_DIR_'))
		{ // initial idea by Eolia
 			if (defined('Module::CACHE_FILE_TRUSTED_MODULES_LIST') == true)
			{ 
				if (    isset($this->context->controller) 
					&& $this->context->controller->controller_name == 'AdminModules'
					&& !file_exists(_PS_ROOT_DIR_.'/config/xml/themes/'.$this->name.'.xml'))
				{
					$sxe = new SimpleXMLElement('<theme/>');
					$modules = $sxe->addChild('modules');
					$module = $modules->addChild('module');
					$module->addAttribute('action', 'install');
					$module->addAttribute('name', $this->name);

					$trusted =  $sxe->saveXML();				
					@file_put_contents( _PS_ROOT_DIR_.'/config/xml/themes/'.$this->name.'.xml', $trusted);
					@unlink(_PS_ROOT_DIR_.Module::CACHE_FILE_TRUSTED_MODULES_LIST);
					@unlink(_PS_ROOT_DIR_.Module::CACHE_FILE_UNTRUSTED_MODULES_LIST);
					@Module::generateTrustedXml();				
				}
			}
		}
		
		if (!defined('_PS_ADMIN_DIR_'))
		{
			self::gaSession();
			self::gaClientID();
		}
			
		// Proxy some common vars
		global $smarty, $cookie, $cart, $defaultCountry;
		$this->smarty = &$smarty;
		self::$id_lang = (int)((!isset($cookie) OR !is_object($cookie)) ? Configuration::get('PS_LANG_DEFAULT') : $cookie->id_lang);
		
		// page_name
		// what a nightmare
		if (isset($this->context)
			&& isset($this->context->controller)) {
			
			if ($this->context->controller->controller_type == 'front') {
				if (!empty($this->context->controller->php_self)) {
					$this->page_name = $this->context->controller->php_self;
				}
				else {
					$this->page_name = Tools::getValue('controller');
				}
			}
			else {
				$this->page_name = Tools::getValue('controller');
			}
		}
		else { // before 1.5 - try to figureout 
			method_exists($this->smarty,'get_template_vars') && $this->page_name = $this->smarty->get_template_vars('page_name');
			method_exists($this->smarty,'getTemplateVars') && $this->page_name = $this->smarty->getTemplateVars('page_name');
			
			if (empty($this->page_name)) {
				$pathinfo = pathinfo(__FILE__);
				$this->page_name = basename($_SERVER['PHP_SELF'], '.'.$pathinfo['extension']);
			}
		}
		
		self::$cookie = &$cookie;

		$this->page = basename(dirname(__FILE__));
		$this->displayName = $this->l('Google Measurement Protocol', $this->specific);
		$this->description = $this->l('Performs server side analytics data collection (out-of-band)', $this->specific);
		
		if ($this->id AND !Configuration::get('GAMP_ACCOUNT_ID') AND defined('_PS_ADMIN_DIR_'))
                        $this->warning = $this->l('You have not yet set your Google Analytics ID');
		
		Configuration::get('GAMP_DISPLAYFEATURES') && $this->ga_endpoint = 'https://stats.g.doubleclick.net/r/collect';
		!Configuration::get('GAMP_MEASUREMENT_PROD') && $this->ga_endpoint = 'https://www.google-analytics.com/debug/collect';
		
		self::$trace = !Configuration::get('GAMP_MEASUREMENT_PROD');
		
		// Some referer magick
		$this->referer = array(
			'self'	=> parse_url(Tools::getHttpHost(true)),
			'vanilla' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '',
			'host'	=> 'localhost',
			'path'	=> '/',
			'query'	=> '',
		);
		$this->referer = array_merge(
			$this->referer,			
			$this->referer['self'],
			parse_url($this->referer['vanilla'])
		);
		$this->referer['true'] = self::trueReferer($this->referer['vanilla'], !!Configuration::get('GAMP_MERGE_WWW'));
		$this->referer['filtered'] = $this->referer['vanilla'];
		if ($this->referer['host'] == $this->referer['self']['host'])
			$this->referer['filtered'] = self::filterRequestURI($this->referer['filtered']);
		
		register_shutdown_function(array($this,'sendOffline'));
	}

	public function mangleSQL($content, $extra = NULL)
	{
		static $const = array(
			'PREFIX_'      => _DB_PREFIX_,
			'ENGINE_TYPE'  => _MYSQL_ENGINE_,
		);

		$meta = array_merge($const,(array)$extra);
		$content = str_replace(array_keys($meta), array_values($meta), $content);
		return $content;
	}

	public function runSqlScript($content)
	{
		!defined('PS_INSTALLATION_IN_PROGRESS') && define('PS_INSTALLATION_IN_PROGRESS', 1);
		$db = Db::getInstance();
		$errors = array();
		//TODO: Should implement a more sophisticated handler
		// for delimiters. Required for trigger install
		$queries = preg_split('~;\s*[\r\n]+~', $content);
		$line = 0;
		foreach($queries as $query)
		{
			$line++;
			$query = trim($query);
			if (!empty($query))
			{
				try {
					if (!$db->execute($query))
						throw new Exception('SQL error');
				} catch (Exception $e) {
					// Handle non mariaDb missing conditionnal DCL for COLUMN  
					if (preg_match('~near\s+\'IF\s+NOT\s+EXISTS~mis',$db->getMsgError())) {
						if (false !== preg_match('~(.*ALTER.*ADD\s+COLUMN\s+)(?:IF\s+NOT\s+EXISTS)(.*)~mis',$query, $matches)) {
							if (!$db->execute($matches[1].$matches[2])) {
								if ($db->getNumberError() != 1060){
									$errors[] = 'line '.$line
											.': SQL('.$db->getNumberError().') => '
											.$db->getMsgError().PHP_EOL
											.$matches[1].$matches[2];
								}
							}
						}
					}
					else {
						$errors[] = 'line '.$line.': SQL('.$db->getNumberError().') => '.$db->getMsgError().PHP_EOL.$query;
					}
				}
			}
		}
		$this->_errors = array_merge($this->_errors, $errors);
		return (count($errors));
	}

	public function unrunSqlScript($content)
	{
		!defined('PS_INSTALLATION_IN_PROGRESS') && define('PS_INSTALLATION_IN_PROGRESS', 1);
		$db = Db::getInstance();
		$errors = array();
		$matches = array();
		preg_match_all('~CREATE\s+([^\s]+)\s+(IF\s+NOT\s+EXISTS\s+|)([^\s;]+)~mi', $content, $matches);
		$queries = array();
		foreach($matches[0] as $k => $v)
			if (empty($matches[2][$k])) // Do not drop "IF NOT EXISTS" tagged table
				$queries[$k] = 'DROP '.$matches[1][$k].' IF EXISTS '.$matches[3][$k];
		foreach ($queries as $query)
		{
			try {
				if (!$db->execute($query))
					throw new Exception('SQL error');
			} catch (Exception $e) {
				$errors[] = '~SQL('.$db->getNumberError().') => '.$db->getMsgError().PHP_EOL.$query;
			}
		}
		$this->_errors = array_merge($this->_errors, $errors);
		return (count($errors));
	}

	public function install()
	{
		$ret = true;
		$this->_errors = array();
		
		$v = str_replace('.','_',$this->version);
		$sqls = glob(dirname(__FILE__).'/upgrade/sql/db_schema_*.sql');
		if (!empty($sqls))
		{
			natsort($sqls);
			$sqls = array_reverse($sqls);
			foreach($sqls as $file)
			{
				if ($file <= dirname(__FILE__).'/upgrade/sql/db_schema_'.$v.'.sql')
				{
					$script = file_get_contents($file);
					$script = self::mangleSQL($script);
					if (self::runSqlScript($script))
						$ret = false;
					
					break;
				}
			}
		}
			
		if (!Module::install()) { $ret = false; $this->_errors[] = 'Prestashop rejected module installation.'; }
		if ($ret AND !empty( self::$HOOKS ) )
		foreach(explode(',', self::$HOOKS) as $hook)
		{
			if (!$this->installPrivateHooks(array($hook)));
			if (!$this->registerHook($hook))
			{
			  $this->_errors[] = 'Failed installing hook ('.$hook.')';
			  $ret = false;
			}
		}

		if (!$ret)
		{
			$errors = $this->_errors;
			self::uninstall();
			$this->_errors = $errors;
		}
		
		self::buildRobotsFile();
		return (bool)$ret;
	}
	
	public function uninstall()
	{
		$ret = Module::uninstall();

		$v = str_replace('.','_',$this->version);
		$sqls = glob(dirname(__FILE__).'/upgrade/sql/db_schema_*.sql');
		if (!empty($sqls))
		{
			natsort($sqls);
			$sqls = array_reverse($sqls);
			foreach($sqls as $file)
			{
				if ($file <= dirname(__FILE__).'/upgrade/sql/db_schema_'.$v.'.sql')
				{
					$script = file_get_contents($file);
					$script = self::mangleSQL($script);
					if (self::unrunSqlScript($script))
						$ret &= false;
					
					break;
				}
			}
		}

		return (bool)$ret;
	}
	
	private function installPrivateHooks($hookset)
	{
		$ret = true;
		if (!is_array($hookset) || empty($hookset))
			return $ret;
		
		foreach($hookset as $h)
		{
			$id_hook = Hook::get($h);
			if ($id_hook)
				continue;
		
			$hook = new Hook();
			$hook->name = $h;
			$ret &= $hook->add();
		}
		return $ret;
	}
	
	static public function moduleFilepath()
	{
		return dirname(__FILE__).'/'.basename(dirname(__FILE__)).'.php';
	}

	static public function moduleURI()
	{
		return _MODULE_DIR_.basename(dirname(__FILE__)).'/';
	}

	static public function moduleThemeURI()
	{
		if (file_exists(_PS_THEME_DIR_.'modules/'.basename(dirname(__FILE__))))
			return  _THEMES_DIR_._THEME_NAME_.'/modules/'.basename(dirname(__FILE__)).'/';
		else
			return self::moduleURI();
	}
	
	///////////////////////////// back-office /////////////////////////////////////
	
	public function postProcess()
	{
		if (Tools::isSubmit('submitGAMP'))
		{
			Configuration::updateValue('GAMP_ACCOUNT_ID',		Tools::getValue('ga_account_id',''));
			Configuration::updateValue('GAMP_USERID_ENABLED', 	Tools::getValue('ga_userid_enabled','0'));
			Configuration::updateValue('GAMP_DETAIL_ENABLED', 	Tools::getValue('ga_detail_enabled','0'));
			Configuration::updateValue('GAMP_ECOMMERCE_ENHANCED', 	Tools::getValue('ga_ecommerce_enhanced','0'));
			Configuration::updateValue('GAMP_MEASUREMENT_PROD', 	Tools::getValue('ga_measurement_prod','0'));
			Configuration::updateValue('GAMP_SESSION_TIMEOUT', 	Tools::getValue('ga_session_timeout','1800'));
			Configuration::updateValue('GAMP_DISPLAYFEATURES', 	Tools::getValue('ga_displayfeatures','0'));
			Configuration::updateValue('GAMP_MERGE_WWW', 		Tools::getValue('ga_merge_www','0'));
			Configuration::updateValue('GAMP_EXCLUDE_BOTS',	 	Tools::getValue('ga_exclude_bots','0'));
			
			$this->smarty->assign('growl','<div class="conf confirm"><img src="../img/admin/ok.gif" alt="" title="" />'.$this->l('Settings updated').'</div>');
		}
	}

	public function displayForm()
	{
		$this->smarty->assign('current_index', Tools::safeOutput($_SERVER['REQUEST_URI']));
		$this->smarty->assign(array(
			'ga_account_id'		=> Configuration::get('GAMP_ACCOUNT_ID'),
			'ga_userid_enabled'	=> Configuration::get('GAMP_USERID_ENABLED'),
			'ga_detail_enabled'	=> Configuration::get('GAMP_DETAIL_ENABLED'),
			'ga_ecommerce_enhanced'	=> Configuration::get('GAMP_ECOMMERCE_ENHANCED'),
			'ga_measurement_prod'	=> Configuration::get('GAMP_MEASUREMENT_PROD'),
			'ga_session_timeout'	=> (Configuration::get('GAMP_SESSION_TIMEOUT')?Configuration::get('GAMP_SESSION_TIMEOUT'):1800),
			'ga_displayfeatures'	=> Configuration::get('GAMP_DISPLAYFEATURES'),
			'ga_merge_www'		=> Configuration::get('GAMP_MERGE_WWW'),
			'ga_exclude_bots'	=> Configuration::get('GAMP_EXCLUDE_BOTS'),
		));
		return $this->display(self::moduleFilePath(), 'admin_gamp.tpl');
	}

	public function getContent()
	{
		$this->postProcess();
		return $this->displayForm();;
	}
	
	static public function debugLog($something)
	{
		if(self::$trace || _GAMP_DEV_)
			file_put_contents(dirname(__FILE__).'/debug.log',$something.PHP_EOL,FILE_APPEND);
		return $something;
	}

	///////////////////////////// helpers ///////////////////////////

	private static function parsed_urls_equivalent($needle, $haystack, $ignore_hosts = true)
	{
		if (!$ignore_hosts)
			if ($needle['host'] != $haystack['host'])
				return false;
			
		if (isset($needle['path']) && (!isset($haystack['path']) || ($needle['path'] != $haystack['path'])))
			return false;

		if (isset($needle['query']) && !isset($haystack['query']))
			return false;
		
		if (empty($needle['query']))
			return true;		// <-- Success return if no query string
		
		parse_str($needle['query'], $n);
		parse_str($haystack['query'], $h);
		
		foreach($n as $k => &$v)
			if (!isset($h[$k]) || $v != $h[$k])
				return false;
		
		return true;
	}
	 
	public function filterRequestURI($uri)
	{
		static $prune = array(
			'token',
			'live_edit',
			'liveToken',
			'id_employee',
			'ad',
			'adtoken',
			'key',
		);
		$parsed = parse_url('https://localhost'.$uri);
		
		if (!empty($parsed['query']))
		{
			$old = $parsed['query'];
			
			parse_str($parsed['query'], $qsa);
			foreach($qsa as $k => $v)
				if (in_array($k,$prune))
					unset($qsa[$k]);
				
			$new = http_build_query($qsa);
			
			if (strlen($new) != strlen($old))
				$uri = str_replace($old,$new,$uri);
		}
		return $uri;
	}
	
	public function getPageLink($controller, $ssl = null, $id_lang = null, $request = null, $request_url_encode = false, $id_shop = null, $relative_protocol = false)
	{
		static $link = null;
		
		if ($link === null)
			$link = new Link();
		
		if (method_exists($link,'getPageLink'))
			return $link->getPageLink($controller,$ssl,$id_lang,$request,$request_url_encode,$id_shop,$relative_protocol);
		
		// Probably PS version lower than 1.4
		if (Configuration::get('PS_REWRITING_SETTINGS')
			&& ($friendly = Meta::getMetaByPage($controller,self::$id_lang))
			&& !empty($friendly['url_rewrite'])) {
			return (_PS_BASE_URL_.__PS_BASE_URI__.strval($link->getLangLink(self::$id_lang)).$friendly['url_rewrite']);
		}
		return (_PS_BASE_URL_.__PS_BASE_URI__.$controller.'.php');
	}
	
	private function getOrderCoupon($order)
	{
		if (version_compare(_PS_VERSION_,'1.5','>='))
			$sql = 'SELECT ocr.name, cr.code
				FROM `'._DB_PREFIX_.'order_cart_rule` ocr
				LEFT JOIN `'._DB_PREFIX_.'cart_rule` cr on cr.id_cart_rule = ocr.id_cart_rule
				WHERE ocr.id_order = '.(int)$order->id;
		else 
			$sql = 'SELECT od.name, d.code
				FROM `'._DB_PREFIX_.'order_discount` od
				LEFT JOIN `'._DB_PREFIX_.'discount` d on d.id_discount = od.id_discount
				WHERE d.id_order = '.(int)$order->id;
		
		$coupons = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
		if (!empty($coupons))
			foreach($coupons as $k => &$v)
				$v = (empty($v['code'])?$v['name']:$v['code']);
		else
			$coupons = array();
			
		return $coupons;
	}
	
	private static function getCategories()
	{
		if (self::$categories === null) {
			self::$categories = array();
			$category = Category::getSimpleCategories(self::$id_lang);
			foreach($category as $k => &$v)
				self::$categories[$v['id_category']] = $v;
			
		}
		
		return self::$categories;
	}
	
	///////////////////////////// hooks /////////////////////////////
	
	public function hookHeader($params)
	{
		static $excluded_pages = array(
			//'404','order-confirmation','supplier','addresses','order-detail',
			//'discount','prices-drop','manufacturer','search','category','new-products','best-sales',
		        //'address','cms','order-follow','product','order','get-file','order-return','attachment',
			//'order-slip','sitemap','authentication','contact-form','history','my-account',
			//'identity','password','cart','pdf-invoice','pdf-order-return','index','pdf-order-slip',
			'statistics',
		);
		
		if (!Configuration::get('GAMP_ACCOUNT_ID') || defined('_PS_ADMIN_DIR_') || defined('PS_ADMIN_DIR') || !$this->active)
			return '';
		
		if ($this->page_name =='statistics')
			$this->gaBrowserCaracteristics();
		
		if (in_array($this->page_name, $excluded_pages))
			return '';

		if (version_compare(_PS_VERSION_,'1.5', '>=') && !$this->isEnabledForShopContext() )
			return '';

		$this->smarty->assign('gamp',$this,false);
		
		$this->gaCreate();
		$this->gaPageview();
		
		switch($this->page_name)
		{
			case 'order':
			case 'order-opc':
				$this->gaCheckout();
				break;
		}
		
		$return = '';
		if (false && Configuration::get('GAMP_DISPLAYFEATURES') && !isset($_COOKIE['_gat']))
		{
			$payload = array(
				't'	=> 'dc',
				'aip'	=> 1,
				'_r'	=> 3,
				'v'	=> 1,
			//	'_v'	=> 'j39',
				'cid'	=> $this->cid,
				'jid'	=> rand(),
				'tid'	=> Configuration::get('GAMP_ACCOUNT_ID'),
			//	'_u'	=> 'SCCAgEIJ~',
				'z'	=> rand(),
			);
			$payload = http_build_query($payload);
			$return .= <<< EOF
			<script>
				(function(f,a,s,t){
					i=a.createElement(s);
					b=a.getElementsByTagName('body')[0];
					i.src = t;
					b.appendChild(i);
				})(window,document,'img','//stats.g.doubleclick.net/r/collect?{$payload}');
			</script>
EOF;
		}
		return $return;
	}

	public function hookCreateAccount($params)
	{
		if (empty($this->analytics))
			$this->gaCreate();
		
		$payload = array(
			't'	=> 'event',
			'ec'	=> 'Customer',
			'ea'	=> 'Registration',
			'el'	=> 'New customer',
			'ev'	=> 1,
			'ni'	=> 1,
		);
		$this->_push($payload);
	}
	
	public function hookPaymentConfirm($params)
	{
		if (!Configuration::get('GAMP_ACCOUNT_ID') || !$this->active)
			return;
		
		if (version_compare(_PS_VERSION_,'1.5', '>=') && !$this->isEnabledForShopContext() )
			return;

		$id_order = $params['id_order'];
		$order = new Order($id_order);
		
		if (Validate::isLoadedObject($order))
		{
			$cart		= new Cart((int)$order->id_cart);
			$customer	= new Customer((int)$order->id_customer);
			$currency	= new Currency((int)$order->id_currency);
			$address	= new Address((int)$order->id_address_delivery);

			$this->gaCreate();
			$this->gaTransaction($cart,$order,$customer,$currency,$address);
		}
	}

	public function hookNewOrder($params)
	{
		if ($params['orderStatus']->id == _PS_OS_ERROR_)
			return '';
		
		if (!Configuration::get('GAMP_ACCOUNT_ID') /*|| defined('_PS_ADMIN_DIR_') || defined('PS_ADMIN_DIR')*/ || !$this->active)
			return '';
		
		if (version_compare(_PS_VERSION_,'1.5', '>=') && !$this->isEnabledForShopContext() )
			return '';

		$order		= $params['order'];
		
		if (Validate::isLoadedObject($order))
		{
			$cart		= $params['cart'];
			$customer	= $params['customer'];
			$currency	= $params['currency'];
		
			$address	= new Address((int)$order->id_address_invoice);

			if(empty($this->analytics))
				$this->gaCreate();
			
			// hook may by missing pageview, force one 
			$this->_push(array(
				't'	=> 'pageview',
				'dl'	=> '/order-confirmation.html',
				'dt'	=> 'Order Confirmation',
			));
			
			$this->gaTransaction($cart,$order,$customer,$currency,$address);
		}
	}
	
	public function hookActionBeforeCartUpdateQty($params)
	{
		//TODO: or not?
	}
	
	public function hookUpdateOrderStatus($params)
	{
		$newOrderStatus = $params['newOrderStatus'];
		$id_order = $params['id_order'];

		if ((int)$newOrderStatus->id != _PS_OS_CANCELED_)
			return;

		$order = new Order($id_order);
		if (!Validate::isLoadedObject($order))
			return;
		
		// The order get cancelled bit by bit
		// This case is already tracked by cart changes 
		if (!$order->total_paid)
			return;

		if (empty($this->analytics))
			$this->gaCreate();
		
		$cart = new Cart($order->id_cart);
		$customer = new Customer($order->id_customer);
		$currency = new Currency($order->id_currency);
		$address = new Address((int)$order->id_address_invoice);
		
		$overrides = array(
			'paid'		=> -(version_compare(_PS_VERSION_,'1.5','>=')?$order->total_paid_tax_incl:$order->total_products_wt),
			'shipping'	=> -($order->total_shipping),
			'paid_tax_incl'	=> -(version_compare(_PS_VERSION_,'1.5','>=')?$order->total_paid_tax_incl:$order->total_products_wt),
			'paid_tax_excl'	=> -(version_compare(_PS_VERSION_,'1.5','>=')?$order->total_paid_tax_excl:$order->total_products),
		);
		
		$this->gaTransaction($cart, $order, $customer, $currency, $address, $overrides);
	}
 
	public function hookCart($params)
	{
		if (!Validate::isLoadedObject($params['cart']))
			return;
		
		if (empty($this->analytics))
			$this->gaCreate();
		
		$qty = 0;
		if (Tools::isSubmit('add') || Tools::isSubmit('update'))
		{
			if (Tools::getValue('op','up') == 'up')
				$qty = (int)Tools::getValue('qty',0);
			else
				$qty = - ((int)Tools::getValue('qty',0));
		}
		elseif (Tools::getValue('remove'))
		{
			// Previous quantity is unknown on remove (assume -1)
			// The new hook actionBeforeCartUpdateQty requires
			// full recalculation - not worth the effort
			$qty = - (Tools::getValue('qty',1));
		}
			
		$product = new Product(Tools::getValue('id_product'),true, self::$id_lang);
		$cart = $params['cart'];
		$currency = new Currency($cart->id_currency); 
		$ipa = (int)Tools::getValue('ipa',0);

		if (($dummy = Order::getOrderByCartId($cart->id)) && !empty($dummy) && $qty)
		{
			// FIXME: To date (2015-11) PrestaShop's hook are
			// just a highway to fatal failure. Feature is actually
			// disabled 
			return;  
			// This is not quite a cart add/remove, but rather 
			// a backoffice transaction change (product remove)
			// Let's adjust the associated transaction accordingly
			$order = new Order(Order::getOrderByCartId($params['cart']->id));
			$customer = new Customer($order->id_customer);
			$address = new Address((int)$order->id_address_invoice);
			
			$overrides = array();
			//Find the amount assuciated to the transaction
			foreach($order->getProducts($product->id) as $k => $line)
			{
				if ($line['product_attribute_id'] == $ipa)
				{
					if (version_compare(_PS_VERSION_,'1.6','>=')) {
						$unit_price_tax_incl = $line['unit_price_tax_incl'];
						$unit_price_tax_excl = $line['unit_price_tax_excl'];
					}
					else {
						$unit_price_tax_incl = $line['product_price_wt'];
						$unit_price_tax_excl = $line['product_price'];
					}
					
					$overrides = array(
						'paid'		=> -($unit_price_tax_incl * $qty),
						'shipping'	=> 0,
						'paid_tax_incl'	=> -($unit_price_tax_incl * $qty),
						'paid_tax_excl'	=> -($unit_price_tax_excl * $qty),
					);
				}
				return $this->gaTransaction($cart, $order, $customer, $currency, $address, $overrides);
			}
			
			return;
		}
			
		
		if (Validate::isLoadedObject($product) && $qty) {
			
			$categories = self::getCategories();

			$combination = array();
			if (!empty($ipa)) {
				$result = $cart->getProducts(false, $product->id);
				foreach($result as $k => $v)
					if ($v['id_product_attribute'] == $ipa)
						$combination = $v;				
			}

			$payload = array(
				't'	=> 'event',
				'cu'	=> $currency->iso_code, 
				'dl'	=> $this->referer['path'],	// The event occured on the referer request
				'pa'	=> ($qty > 0 ? 'add' : 'remove'),
				'in'	=> trim($product->name),
				'ic'	=> $product->id.($ipa ? '-'.$ipa : ''),
				'ip'	=> $product->getPrice(true,$ipa),
				'iq'	=> abs($qty),
				'ea'	=> ($qty > 0 ? 'Add to Cart' : 'Remove from Cart'),
				'ec'	=> 'Ecommerce',
			);
			!empty($categories[$product->id_category_default]['name']) && $payload['iv'] = $categories[$product->id_category_default]['name'];
			
			if (Configuration::get('GAMP_ECOMMERCE_ENHANCED'))
			{
				$payload = array_merge($payload,array(
					'pr1id'	=> $product->id.($ipa ? '-'.$ipa : ''),
					'pr1nm'	=> $product->name,
					'pr1qt'	=> $qty,
					'pr1pr'	=> $product->getPrice(true,Tools::getValue('ipa')),
				));
				!empty($categories[$product->id_category_default]['name']) && $payload['pr1ca'] = $categories[$product->id_category_default]['name'];
				!empty($product->manufacturer_name) && $payload['pr1br'] = $product->manufacturer_name;
				!empty($combination['attributes_small']) && $payload['pr1va'] = $combination['attributes_small'];
			}
			
			$this->_push($payload);
		}
	}
	
	public function onDisplayProductList($products, $list = '', $force = false)
	{
		static $l = 0;
		static $currency = null;
		
		if ($currency === null)
			$currency = new Currency(self::$cookie->id_currency);
		
		if (!empty($products) && is_array($products))
		{
			$l++;
			$payload = array(
				't'	=> 'event',
				'ea'	=> 'Impression',
				'pa'	=> 'detail',
				'ec'	=> 'Display',
				'ni'	=> 1, // Do not impact bounce rate
				'cu'	=> $currency->iso_code,
				'il'.$l.'nm'	=> (!empty($list) ? $list . ($force ? '' : $l) : 'List '. $l),	
			);
			
			$categories = self::getCategories();
			$i = 0;
			foreach($products as $k => $p)
			{
				$i++;
				if (is_object($p))
					$p = (array)$v;

				$default_attribute = Product::getDefaultAttribute($p['id_product']);
				
				$payload = array_merge($payload,array(
					'il'.$l.'pi'.$i.'id'	=> $p['id_product'].(!empty($default_attribute) ? '-'.$default_attribute : ''),
					'il'.$l.'pi'.$i.'nm'	=> trim($p['name']),
					'il'.$l.'pi'.$i.'ps'	=> $i,
				));
				
				$price = Product::getPriceStatic((int)$p['id_product'], true, (int)$default_attribute);
				!empty($price) && $payload['il'.$l.'pi'.$i.'pr'] = round($price,2);
				!empty($p['id_manufacturer']) && $payload['il'.$l.'pi'.$i.'br'] = Manufacturer::getNameById($p['id_manufacturer']);
				!empty($categories['id_category_default']['name']) && $payload['il'.$l.'ca'] = $categories[$p['id_category_default']]['name'];
			}
			
			$this->_push($payload);
		}
	}
	
	/////////////////////////// analytics events /////////////////////////////////
	
	public function gaUserSign()
	{
		if (empty($this->analytics))
			$this->gaCreate();
		
		if ( !empty(self::$cookie->id_customer))
		{
			$ga_context = $this->cid.'|'.$this->sid;
			Db::getInstance()->execute('UPDATE `'._DB_PREFIX_.'customer` SET `ga_context`=\''.pSQL($ga_context).'\' WHERE `id_customer`='.(int)self::$cookie->id_customer);

			$payload = array(
				't'	=> 'event',
				'ea'	=> 'Checkout',
				'ec'	=> 'Ecommerce',
				'pa'	=> 'checkout',
				'dl'	=> '/authentication.html',		//legacy
				'cos'	=> 2,
				'col'	=> 'authentication',
				'el'	=> 'authentication',
				'ev'	=> 1,
			);
			$this->gaOverridePageUrl('/authentication.html');
			$this->_push($payload);
		}
	}
	
	public function gaCheckout()
	{
		static $steps = array('summary','authentication', 'address', 'carrier', 'payment',);
		global $cart;
		
		$products = $cart->getProducts();
		if (empty($products))
			return;
		
		$step = Tools::getValue('step',0);
		
		// Skip over authentication - done on authentication page
		if ($step)
			$step ++;
		
		$payload = array(
			't'	=> 'event',
			'ea'	=> 'Checkout',
			'ec'	=> 'Ecommerce',
			'pa'	=> 'checkout',
			'dl'	=> '/order/step'.$step.'.html',		//legacy
			'cos'	=> ($step+1),
			'col'	=> $steps[$step],
			'el'	=> $steps[$step],
			'ev'	=> 1,
		);
		$this->gaOverridePageUrl('/order/step'.$step.'.html');
		$pos = 0;

		$categories = self::getCategories();
		foreach($products as $k => &$product)
		{
			$k++;
			$pl = array(
				'pr'.$k.'id'	=> $product['id_product'].(!empty($product['id_product_attribute']) ? '-'.$product['id_product_attribute'] : ''),
				'pr'.$k.'nm'	=> trim($product['name']),
				'pr'.$k.'qt'	=> $product['cart_quantity'],
				'pr'.$k.'pr'	=> $product['total_wt'],
				'pr'.$k.'ps'	=> ++$pos,
			);
			!empty($categories[$product['id_category_default']]['name']) && $pl['pr'.$k.'ca'] = $categories[$product['id_category_default']]['name'];
			!empty($product['attributes_small']) && $pl['pr'.$k.'va'] = $product['attributes_small'];
			!empty($product['id_manufacturer']) && $pl['pr'.$k.'br'] = Manufacturer::getNameById((int)$product['id_manufacturer']);
			
			$payload = array_merge($payload,$pl);
		}
		
		$this->_push($payload);
	} 

	public function gaPageview($page = null)
	{
		if (preg_match('/statistics/',$this->referer['filtered']))
			return;
		
		$request_uri = parse_url($_SERVER['REQUEST_URI']);
		if ($request_uri['host'] = $this->referer['self']['host']) {
			
		}
		$payload = array(
			't'	=> 'pageview',
			'dl'	=> (!empty($page) ? $page : self::filterRequestURI($_SERVER['REQUEST_URI'])),
		);
		method_exists($this->smarty,'get_template_vars') && $payload['dt'] = $this->smarty->get_template_vars('meta_title');
		method_exists($this->smarty,'getTemplateVars') && $payload['dt'] = $this->smarty->getTemplateVars('meta_title');
		
		$this->_push(array_merge($payload,($this->page_name == 'product'?$this->gaProductDetail():array())));
	}

	public function gaProductDetail()
	{
		// Pig-tail product details
		$product = new Product(Tools::getValue('id_product'), true, self::$id_lang);
		global $cart;
		$currency = new Currency((int)$cart->id_currency);
		$payload = array();
		
		if (Validate::isLoadedObject($product) && $product->active)
		{
			$categories = self::getCategories();
			$ipa = (int)Product::getDefaultAttribute($product->id);
			if ($ipa) {
				$small = Db::getInstance()->getValue(
					'SELECT GROUP_CONCAT(al.name SEPARATOR ", ")
					FROM `'._DB_PREFIX_.'product_attribute_combination` pac
					LEFT JOIN `'._DB_PREFIX_.'attribute` a ON a.`id_attribute` = pac.`id_attribute`
					LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON a.`id_attribute` = al.`id_attribute`
					WHERE al.id_lang = '.(int)self::$id_lang.' AND pac.id_product_attribute = '.(int)$ipa);
			}
			
			if (Configuration::get('GAMP_ECOMMERCE_ENHANCED')) {
				$payload = array(
					'pa'	=> 'detail',
					'pr1id'	=> $product->id.($ipa ? '-'.$ipa : ''),
					'pr1nm'	=> $product->name,
					'pr1pr'	=> $product->getPrice(true, $ipa),
					'cu'	=> $currency->iso_code,
				);
				!empty($categories[$product->id_category_default]['name']) && $payload['pr1ca'] = $categories[$product->id_category_default]['name'];
				!empty($small) && $payload['pr1va'] = $small;
				!empty($product->id_manufacturer) && $payload['pr1br'] = Manufacturer::getNameById((int)$product->id_manufacturer);
			}
			else {
				$payload = array(
					'pa'	=> 'detail',
					'in'	=> $product->name,
					'ic'	=> $product->id.($ipa ? '-'.$ipa : ''),
					'ip'	=> $product->getPrice(true, $ipa),
					'cu'	=> $currency->iso_code,
				);
				!empty($categories[$product->id_category_default]['name']) && $payload['iv'] = $categories[$product->id_category_default]['name'];
			}
		}
		
		return $payload;
	}
	public function gaTransaction($cart,$order,$customer,$currency,$address,$overrides = array())
	{
		if (version_compare(_PS_VERSION_,'1.5','>=')) {
			$id_shop = $this->context->shop->id;
			$shopname = Shop::isFeatureActive() ? $this->context->shop->name : Configuration::get('PS_SHOP_NAME');
		} else {
			$id_shop = 1;
			$shopname = Configuration::get('PS_SHOP_NAME');
		}

		empty($this->analytics) && $this->gaCreate();
		
		if (Validate::isLoadedObject($order)
			&& (
				!empty($overrides)
				||
				!Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue(
					'SELECT id_order FROM `'._DB_PREFIX_.'ganalytics` WHERE id_order = '.(int)$order->id)
				)
			) {
			
			// https://support.google.com/analytics/answer/2795983?hl=en&ref_topic=2790009 
			// See full comment inside gaCreate()
			unset($this->analytics['dr']);

			if (empty($this->referer['true']) || $this->referer['host'] != $this->referer['self']['host'])
			{
				//Try the hard way to recover the *real* session to preserve referals
				$ga_context = Db::getInstance()->getValue('SELECT ga_context FROM `'._DB_PREFIX_.'customer` WHERE id_customer='.(int)$order->id_customer);
				if (!empty($ga_context)) {
					list($this->cid, $this->sid) = explode('|',$ga_context,2);

					$this->gaSession($this->sid);
					unset($this->analytics['uip']);
					unset($this->analytics['ua']);
					$this->analytics['cid'] = $this->cid;
					
					Configuration::get('GAMP_USERID_ENABLED') && $this->analytics['uid'] = $order->id_customer;
				}
				
			}
		
			// Fake order data should we have to. When the order need to reflect
			// adjustments
			if (!empty($overrides))
			{
				$order->total_paid = $overrides['paid'];
				$order->total_shipping = $overrides['shipping'];
				if (version_compare(_PS_VERSION_,'1.5','>='))
				{
					$order->total_paid_tax_incl = $overrides['paid_tax_incl'];
					$order->total_paid_tax_excl = $overrides['paid_tax_excl'];
				}
				else
				{
					$order->total_products_wt = $overrides['paid_tax_incl'];
					$order->total_products = $overrides['paid_tax_excl'];
				} 
			}
			
			$payload = array(
				't'	=> 'transaction',
				'ta'	=> $shopname,
				'ni'	=> 1,
				'ti'	=> $order->id,
				'tr'	=> $order->total_paid,
				'cu'	=> $currency->iso_code,
			);
			
			//TODO:
			// analytics + enhanced ecommerce does not supper city/state/country override vs ga
			//
			// implement a complete geoid override
			// http://developers.google.com/analytics/devguides/collection/protocol/v1/geoid
			$payload['geoid'] = Country::getIsoById($address->id_country);
			
			if (Configuration::get('GAMP_DETAIL_ENABLED'))
			{
				$payload = array_merge($payload, array(
					'ts'	=> $order->total_shipping,
					'tt'	=> (version_compare(_PS_VERSION_,'1.5','>=')
							?$order->total_paid_tax_incl - $order->total_paid_tax_excl
							:$order->total_products_wt - $order->total_products
						),	
				));
			}
			Db::getInstance()->Execute(
				'INSERT INTO `'._DB_PREFIX_.'ganalytics` (id_order, id_shop, sent, date_add) VALUES ('.(int)$order->id.', '.(int)$id_shop.', 1, NOW())'
			);
			
			$i = 1;
			
			$payload['pa'] = !empty($overrides)?'refund':'purchase';
			if (!empty($overrides) && Configuration::get('GAMP_ECOMMERCE_ENHANCED')) {
				$enh_payload = array(
					't'	=> 'event',
					'ec'	=> 'Transaction',
					'ea'	=> $payload['pa'],
					'el'	=> $order->id,
					'ev'	=> round($order->total_paid), // Let's have some ~good~ display number on real-time vue
					'cos'	=> 6,
					'col'	=> 'transaction',
				);
			}
			else {
				$enh_payload = array();
			}

			if (empty($overrides))
				foreach ($order->getProducts() AS $product) {
					if (version_compare(_PS_VERSION_,'1.5','<'))
						$product['unit_price_tax_incl']	=
							($product['product_quantity_discount']
								?$product['product_quantity_discount']
								:$product['product_price']
							)
							*
							(1+($product['tax_rate']/100));

					$categories = self::getCategories();
					if (Configuration::get('GAMP_ECOMMERCE_ENHANCED')) {
						$enh_payload = array_merge($enh_payload, array(
							'pr'.($i).'id'	=> $product['product_id'].(!empty($product['product_attribute_id']) ? '-'.$product['product_attribute_id'] : ''),
							'pr'.($i).'nm'	=> trim($product['product_name']),
							'pr'.($i).'pr'	=> round($product['unit_price_tax_incl'],2),
							'pr'.($i).'qt'	=> $product['product_quantity'],
						));
						!empty($categories[$product['id_category_default']]['name']) && $enh_payload['pr'.($i).'ca'] = $categories[$product['id_category_default']]['name'];
						!empty($product['id_manufacturer']) && $enh_payload['pr'.($i).'br'] = Manufacturer::getNameById((int)$product['id_manufacturer']);
					}
					$i++;
					
					$item = array(
						't'	=> 'item',
						'ti'	=> $order->id,
						'ic'	=> $product['product_id'].(!empty($product['product_attribute_id']) ? '-'.$product['product_attribute_id'] : ''),
						'in'	=> trim($product['product_name']),
						'ip'	=> round($product['unit_price_tax_incl'],2),
						'iq'	=> $product['product_quantity'],
						'cu'	=> $currency->iso_code,
					);
					!empty($categories[$product['id_category_default']]['name']) && $item['iv'] = $categories[$product['id_category_default']]['name'];
					
					!Configuration::get('GAMP_ECOMMERCE_ENHANCED') && $this->_push($item);
				}
			
			$this->_push(array_merge(
				$payload,
				$enh_payload
			));
		}
	}

	public function gaBrowserCaracteristics()
	{
		if (empty($this->analytics)) {
			$this->gaSession();	
			$this->gaCreate();
		}
		
		// https://developers.google.com/analytics/devguides/collection/analyticsjs/single-page-applications
		// Prevent sending dl / dt to permit correct data-flow
		if (Tools::isSubmit('type')) {
			if (Tools::getValue('type') == 'pagetime' && $this->timeb !== null) {
				$plt = (int)((microtime(true) - $this->timeb)*1000);
				if ($plt > 100 && $plt < 30000)
					$payload = array(
						't'	=> 'timing',
						'utc'	=> '(pagespeed)',
						'utv'	=> '(loadtime)',
						'utt'	=> $plt,
						'plt'	=> $plt,
						//'dl'	=> $this->referer['path'],	// The event occured on the referer request
					);
			}
			if (Tools::getValue('type') == 'navinfo' && $this->timeb !== null) {
				$vp = array(
					substr(Tools::getValue('screen_resolution_x','0'), 0, 5),
					substr(Tools::getValue('screen_resolution_y','0'), 0, 5),
				);
				$sr = array(
					max($vp[0],$vp[1]),
					min($vp[0],$vp[1]),
				);
						
				$plt = (int)((microtime(true) - $this->timeb)*1000);
				if ($plt > 100 && $plt < 30000)
					$payload = array(
						't'	=> 'timing',
						'utc'	=> '(pagespeed)',
						'utv'	=> '(loadtime)',
						'utt'	=> $plt,
						'plt'	=> $plt,
						//'dl'	=> $this->referer['path'],	// The event occured on the referer request
						'vp'	=> implode('x',$vp),
						'sr'	=> implode('x',$sr),
						'sd'	=> substr(Tools::getValue('screen_color','0'),0,3).'-bits',
						'je'	=> !!Tools::getValue('sun_java',0),
					);
			}
		}
		
		if (!empty($payload))
			$this->_push($payload);
	}
	
	//////////////////////////// internals ////////////////////////////////
	
	public function gaOverridePageUrl($page)
	{
		foreach($this->payloads as $k => &$v)
			if (isset($v['dl']))
				$v['dl'] = $page;
	}
	
	public function gaCreate()
	{
		if (!empty($this->analytics))
			return;

		$this->analytics = array(
				'v' 	=> 1,
				'tid'	=> Configuration::get('GAMP_ACCOUNT_ID'),
				'did'	=> 'd6YPbH', //TODO: implement developper personnal key
				'cid'	=> self::gaClientID(),
				'uip'	=> self::getCustomerUIP(),
				'ua'	=> $_SERVER['HTTP_USER_AGENT'],
				'de'	=> 'UTF-8',
				'ul'	=> Language::getIsoById(self::$id_lang),
		);
		
		foreach(self::$passthru as $p)
		{
			if (isset($_REQUEST[$p]))
			{
				$this->analytics[$p] = $_REQUEST[$p];
			}
			elseif (isset($_COOKIE['__'.$p]))
			{
				$this->analytics[$p] = $_COOKIE['__'.$p];
			}
		}
			
		//
		// By default the HTTP referrer URL, which is used to attribute traffic sources, is only sent when the hostname of
		// the referring site differs from the hostname of the current page.
		// Unless 'alwaysSendReferrer': true - not implemented 
		//
		// https://support.google.com/analytics/answer/2795983?hl=en&ref_topic=2790009 
		// By default, *all* referrals trigger a new session in Universal Analytics. For example, if a user is on your site,
		// leaves but then immediately returns, this user has logged 2 sessions. You can, however, modify your tracking code
		// to exclude all traffic from specific domains as referral traffic with the referral exclusions.
		// 
		// Don't mess session on order-confirmation by not sending referer - never
		// 
		if (!($this->referer['host'] == $this->referer['self']['host'] && $this->page_name == 'order-confirmation'))
			!empty($this->referer['true']) && $this->analytics['dr'] = $this->referer['filtered'];
		
		// The referer is authentication, try kick-off the
		// authentication events
		if ($this->referer['host'] == $this->referer['self']['host'])
		{
			if (self::parsed_urls_equivalent(parse_url(self::getPageLink('authentication',true)),$this->referer))
				$this->gaUserSign();
		}
		
		
		if (Configuration::get('GAMP_USERID_ENABLED') && isset(self::$cookie->id_customer) && self::$cookie->id_customer)
			$this->analytics['uid'] = self::$cookie->id_customer;
	}
	
	private function getCustomerUIP()
	{
		$ips = array('127.0.0.1');

		!empty($_SERVER['REMOTE_ADDR']) 	&& $ips[] = $_SERVER['REMOTE_ADDR'];
		!empty($_SERVER['HTTP_FORWARDED']) 	&& $ips[] = $_SERVER['HTTP_FORWARDED'];
		!empty($_SERVER['HTTP_FORWARDED_FOR']) 	&& $ips[] = $_SERVER['HTTP_FORWARDED_FOR'];
		!empty($_SERVER['HTTP_X_FORWARDED']) 	&& $ips[] = $_SERVER['HTTP_X_FORWARDED'];
		!empty($_SERVER['HTTP_X_FORWARDED_FOR'])&& $ips[] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		!empty($_SERVER['HTTP_CLIENT_IP']) 	&& $ips[] = $_SERVER['HTTP_CLIENT_IP'];
		
		return end($ips);
	}
	
	private static function __utma()
	{
		static $utma = null;
		
		if ($utma === null) {
			if (isset($_COOKIE['__utma'])) {
				try {
					$a = explode('.',$_COOKIE['__utma']);
					if (count($a < 6)) 					throw new Exception('-');
					if ((int)$a[0] < 1 || (int)$utma[0] > 0x7FFFFFFF)  	throw new Exception('-');
					if ((int)$a[1] < 1 || (int)$utma[1] > 0x7FFFFFFF)  	throw new Exception('-');
					if ((int)$a[2] < 1 || (int)$utma[2] > 0x7FFFFFFF)  	throw new Exception('-');
					if ((int)$a[3] < 1 || (int)$utma[3] > 0x7FFFFFFF)  	throw new Exception('-');
					if ((int)$a[4] < 1 || (int)$utma[4] > 0x7FFFFFFF)  	throw new Exception('-');
					if ((int)$a[5] < 1) 					throw new Exception('-');
					$utma = $a;
				} catch (Exception $e) {}
			}
			if ($utma === null)
				$utma = array(
					self::dash(self::topDomain($_SERVER['SERVER_NAME'])),
					(rand() & 0x7FFFFFFF),
					time(),
					time(),
					time(),
					0
			);
		}
		return $utma;
	}
	
	private function gaClientID()
	{
		static $once = 0;
		static $cookie = null;
		static $base_uri;

		if ($cookie == null) {
			if(version_compare(_PS_VERSION_,'1.5','>=')) {
				$shopurl = new ShopUrl(Context::getContext()->shop->id);
				$bu = explode('/',$shopurl->getBaseURI(),2);
				$base_uri = array($bu[0], '/'.$bu[1]);
			} else 
				$base_uri = array(Tools::getHttpHost(false), __PS_BASE_URI__);

			$utma = $this->__utma();
			
			if (isset($_COOKIE['_ga'])) {
				$cookie = explode('.',$_COOKIE['_ga']);
			} else {
				$d = count(explode('.',$base_uri[0]));
				$f = -1;
				foreach(explode('/',$base_uri[1]) as $p)
					if (!empty($p))
						$f++;
					
				$cookie = array(
						'GA1',
						$d.($f>1?'-'.$f:''),
						$utma[1],
						$utma[2],	
					);
			}
		}
		
		if(!headers_sent() && !$once++)
		{
			setcookie('_ga', implode('.',$cookie), time()+63072000, '.'.$base_uri[1], $base_uri[0]); // 2 years
			
			// Preserve passtru trackings as session cookies
			foreach(self::$passthru as $p) {
				if (isset($_REQUEST[$p]))
					setcookie('__'.$p,$_REQUEST[$p],0,'.'.$base_uri[1], $base_uri[0]);
			}
			
		}
		$this->cid = $cookie[2].'.'.$cookie[3];
		return $cookie[2].'.'.$cookie[3];
	}

	public function gaSession($force = null)
	{
		static $session = null;
		
		if ($force !== null) {
			$session = array();
			$this->sid = $force;
		}
		
		if ($session === null)
		{
			!empty($_COOKIE['_gas']) && $this->timeb = $_COOKIE['_gas'];
			
			if (!isset($_COOKIE['_gas']) || ($_COOKIE['_gas'] + (int)Configuration::get('GAMP_SESSION_TIMEOUT')) < time())
				$session = array( 'sc' => 'start');
			else
				$session = array();
			
			$this->sid = time();
			if(!headers_sent())
				setcookie('_gas', $this->sid, (time() + (int)Configuration::get('GAMP_SESSION_TIMEOUT')), '/');
		}
		
		return $session;
	}
	
	private function _push($payload)
	{
		$this->payloads[] = array_merge($this->analytics,
			$payload
		);
	}

	public static function socket($url, $payload)
	{
		static $_s = 1; // undocumented
		static $stream_context = null;
		static $curl = null;
		$content = false;
		
		if ($stream_context === null) {
			$stream_context = stream_context_create(
				array(
					'http' => array(
						'timeout'		=> 10,
						'method'		=> 'POST',
						'follow_location'	=> 1,
						'max_redirect'		=> 20,
					),
					'https' => array(
						'timeout'		=> 10,
						'method'		=> 'POST',
						'follow_location'	=> 1,
						'max_redirect'		=> 20,
							
					),
					'ssl'	=> array(
						'verify_peer'		=> false,
					),
				)
			);
		}
		
		stream_context_set_option($stream_context,array(
			'http' => array(
				'content' => self::traceLog(http_build_query($payload).'&_s='.$_s++/*.'&z='.microtime(true)*/),
			),	
		));
		
		if (in_array(ini_get('allow_url_fopen'), array('On', 'on', '1'))) {
			self::debugLog($url.' *socket*');
			$content = @file_get_contents($url, false, $stream_context);
		} elseif (function_exists('curl_init'))	{
			self::debugLog($url.' *curl*');
			$opts = stream_context_get_options($stream_context);
			if ($curl === null) {
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
				curl_setopt($curl, CURLOPT_TIMEOUT, isset($opts['http']['timeout'])?$opts['http']['timeout']:10);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, isset($opts['http']['follow_location'])?$opts['http']['follow_location']:0);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, isset($opts['ssl']['verify_peer'])?$opts['ssl']['verify_peer']:1);
			}
			if (isset($opts['http']['method']) && Tools::strtolower($opts['http']['method']) == 'post')
			{
				curl_setopt($curl, CURLOPT_POST, true);
				if (isset($opts['http']['content']))
				{
					// parse_str($opts['http']['content'], $datas);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
				}
			}
			else
				curl_setopt($curl, CURLOPT_POST, true);
			
			$content = @curl_exec($curl);
		}
		
		return $content;
	}
	
	static public function traceLog($something)
	{
		if(_GAMP_BETA_ || self::$trace)
			file_put_contents(dirname(__FILE__).'/debug.log',$something.PHP_EOL,FILE_APPEND);
		return $something;
	}
	
	private static function buildRobotsFile()
	{
		static $url = 'http://www.useragentstring.com/pages/';
		static $classes = array(
			'Crawlerlist',
			'Offline Browserlist',
			'Link Checkerlist',
			'E-mail Collectorlist',
			'Validatorlist',
			'Feed Readerlist',
			'Librarielist',
			'Otherlist',
		);
		
		if (file_exists(__DIR__.'/robots.php'))
			return true;
		
		$results = array();
		foreach($classes as $class)
		{
			$html = file_get_contents($url.urlencode($class).'/');
			libxml_use_internal_errors(true);
			$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'utf-8');
			$doc = new DOMDocument();
			$doc->loadHTML($html);
			$xml = simplexml_import_dom($doc);
			
			if (empty($xml))
				continue; 
			
			foreach( $xml->xpath('//div[@id="liste"]/h3') as $item) {
				$species = (string)$item;
	
	
				$signatures = array();
				// Ain't there any more effective way ?
				foreach ( $item->xpath('./following-sibling::*') as $sibbling)
				{
					$name = $sibbling->getName();
					if (strtolower($name) == 'h3')
						break;
					if (strtolower($name) == 'ul')
						foreach($sibbling->xpath('./li/a') as $p)
							$signatures[] = preg_quote((string)$p,'/');
	                        }
	                        $results[$species] = $signatures;
	                }
		}
                if ($results)
			file_put_contents(
				__DIR__.'/robots.php',
				'<?php'.PHP_EOL.'$robots = '.var_export($results,true).';'.PHP_EOL,
				0
			);
                return true;
	}
	
	public static function isKnownBot($ua)
	{
		$robots = array();
		@include_once(__DIR__.'/robots.php');
		$robots = array_merge(
			(array)$robots,
			array('Unknown Robot' => array('(curl|wget|libwww-perl|robot|spider|harvest|bot|(?<!msie)crawler)'),)
		);
		
		if (!empty($robots))
			foreach($robots as $species => &$patterns)
				foreach($patterns as $k => &$p) {
					if (preg_match('/'.$p.'/i',$ua))
						return $species;
				}
					
		return false;
	}

	public function gaTrackBot($bot)
	{
		if (!!Configuration::get('GAMP_EXCLUDE_BOTS'))
			return;
		
		// Remove sessions 
		unset($this->analytics['sc']);
		
		// Reflect robot as campaign 
		$flavor = array(
			'cs'	=> $bot,
			'cm'	=> '(robots)',
			'cn'	=> 'robots',
			// 'ni'	=> 1,	// Avoid bounce calculation
		);
		
		$this->time1 = microtime(true);
		$this->payloads[0] = array_merge($this->payloads[0],array('srt' => round(($this->time1 - $this->time0)*1000)));
		
		// Perform as usual, but force non-interactive
		foreach($this->payloads as $payload)
			self::debugLog(self::socket($this->ga_endpoint, array_merge($payload,$flavor)));
		
	}
	
	public function sendOffline()
	{
		ignore_user_abort(true);
		ob_start();
		function_exists('fastcgi_finish_request') && fastcgi_finish_request();
		
		if (empty($this->analytics) || empty($this->payloads))
			return;
		
		// Since analytics robots exclusion does not operate as expected 
		// do not trigger tracking on "known-robots" user agent or the like.
		if (!empty($this->analytics['ua']) && ($bot = self::isKnownBot($this->analytics['ua'])) !== false)
			return $this->gaTrackBot($bot);
		
		$this->payloads[0] = array_merge($this->payloads[0],defined('_PS_ADMIN_DIR_')?array():self::gaSession());
		$this->time1 = microtime(true);
		$this->payloads[0] = array_merge($this->payloads[0],array('srt' => round(($this->time1 - $this->time0)*1000)));
		
		foreach($this->payloads as $payload)
			self::debugLog(self::socket($this->ga_endpoint, $payload));
		
		ob_end_clean();
	}

	
	// function La(a) - domain hash
	private static function dash($s)
	{
		$h = 1;
		
		if (!empty($s)) {
			for( $h = 0, $l = strlen($s); $l; $l--) {
				$c = ord($s[$l - 1]);
				$h = (($h << 6) & 0x0FFFFFFF) + $c + ($c << 14);
				$b = ($h & 0xFE00000) >> 21;
				$b && $h = $h^$b;	
			}
		}
		
		return $h;
	}
	
	private static function encode($w)
	{
		static $_ = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
		
		for ($a = array(), $b = 0, $l = count($w); $b < $l; $b++)
            		$w[$b] && ($a[floor($b / 6)] ^= 1 << ($b % 6));
		
		for ($b = 0, $l = max(array_keys($a)); $b < $l; $b++)
			$a[$b] = $_[isset($a[$b])?$a[$b]:0];
		
		return implode('',$a).'~';
	}
	
	private static function trueReferer($url, $www = false)
	{
		$u = preg_replace('#https?\://'.($www?'(:?:www\.)':'').preg_quote($_SERVER['SERVER_NAME'],'#').'#i','',$url);
		if (empty($u[0]) || $u[0] == '/' || $u[0] == '?' || $u[0] == ':')
			return '';
		
		return $url;
	}
	
	private static function topDomain($h)
	{
		return preg_replace('/^www\./i','',$h);
	}
}
