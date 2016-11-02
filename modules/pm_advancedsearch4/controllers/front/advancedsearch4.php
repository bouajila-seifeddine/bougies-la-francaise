<?php
/* For PS 1.4.X */
if (!class_exists('ModuleFrontController')) {
	class ModuleFrontController extends FrontController {
		public $ajax = false;
		public function __construct(){
			parent::__construct();
		}
		public function displayHeader() {
			if ($this->display_header) {
				parent::displayHeader();
			}
		}
		public function displayFooter() {
			if ($this->display_footer) {
				parent::displayFooter();
			}
		}
	}
}

class pm_advancedsearch4advancedsearch4ModuleFrontController extends ModuleFrontController {
	private $id_seo = false;
	private $id_search = false;
	private $hookName = false;
	private $realURI;
	protected $context;
	public 		$display_column_left = true;
	public 		$display_column_right = true;
	protected 	$display_header = true;
	protected 	$display_footer = true;

	private  $criterions 				= array();
	private  $criterions_hidden 		= array();
	private  $next_id_criterion_group 	= false;
	private  $reset 					= false;

	public function __construct() {
		if (Tools::getValue('ajaxMode')) {
			$this->ajax = true;
			$this->display_column_left = false;
			$this->display_column_right = false;
			$this->display_header = false;
			$this->display_footer = false;
		}

		parent::__construct();
		if (_PS_VERSION_ >= 1.5)
			$this->context = Context::getContext();
		else
			$this->context = (object) null;
	}
	
	public function setMedia() {
		parent::setMedia();
		if (_PS_VERSION_ >= 1.5 && (method_exists($this->context, 'getMobileDevice') && $this->context->getMobileDevice() == false || !method_exists($this->context, 'getMobileDevice'))) {
			$this->addCSS(array(
				_THEME_CSS_DIR_.'scenes.css' => 'all',
				_THEME_CSS_DIR_.'category.css' => 'all',
				_THEME_CSS_DIR_.'product_list.css' => 'all',
			));
			if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0) $this->addJS(_THEME_JS_DIR_.'products-comparison.js');
		} else if (_PS_VERSION_ >= 1.4) {
			Tools::addCSS(array(
				_PS_CSS_DIR_.'jquery.cluetip.css' => 'all',
				_THEME_CSS_DIR_.'scenes.css' => 'all',
				_THEME_CSS_DIR_.'category.css' => 'all',
				_THEME_CSS_DIR_.'product_list.css' => 'all'));
			if (Configuration::get('PS_COMPARATOR_MAX_ITEM') > 0) Tools::addJS(_THEME_JS_DIR_.'products-comparison.js');
		}
	}
	
	public function init() {
		parent::init();
		if (_PS_VERSION_ < 1.5) {
			$this->context->cookie = self::$cookie;
			$this->context->smarty = self::$smarty;
		}
		// Define title, meta_*
		$this->_setSEOTags();
		$this->_setProductFilterList();
	}
	
	private function _setProductFilterList() {
		$productFilterList = Tools::getValue('productFilterList');
		if ($productFilterList && !empty($productFilterList)) {
			if (function_exists('gzcompress') && function_exists('gzuncompress')) {
				$productFilterList = gzuncompress(@base64_decode($productFilterList));
			} else {
				$productFilterList = @base64_decode($productFilterList);
			}
			if ($productFilterList !== false) {
				$productFilterList = explode(',', $productFilterList);
				if (is_array($productFilterList) && sizeof($productFilterList)) {
					PM_AdvancedSearch4::$productFilterList = array_unique($productFilterList);
				}
			}
		}
	}
	
	private function _setSEOTags() {
		$this->id_seo = Tools::getValue('id_seo',false);
		$seo_url = Tools::getValue('seo_url',false);
		// Get SEO search
		if ($seo_url && $this->id_seo && !Tools::getValue('getShareBlock')) {
			$resultSeoUrl = AdvancedSearchSeoClass::getSeoSearchByIdSeo($this->id_seo,$this->context->cookie->id_lang);
			// if !result 404
			if (!$resultSeoUrl) {Tools::redirect('404.php');die;}
			// 301 redirect if deleted
			if ($resultSeoUrl[0]['deleted']) {
				header("Status: 301 Moved Permanently", false, 301);
				Tools::redirect('index.php');
				die();
			}
			
			// Set metatags and SEO var
			$pageNumber = (int)Tools::getValue('p');
			$this->context->smarty->assign(array(
				'page_name'				=>	'advancedsearch-seo-'.(int)$this->id_seo,
				'meta_title'			=>	$resultSeoUrl[0]['meta_title'].(!empty($pageNumber) ? ' ('.$pageNumber.')' : ''),
				'meta_description'		=>	$resultSeoUrl[0]['meta_description'],
				'meta_keywords'			=>	$resultSeoUrl[0]['meta_keywords'],
				'as_seo_title'			=>	$resultSeoUrl[0]['title'],
				'as_seo_description'	=>	$resultSeoUrl[0]['description']
			));
		}
	}
	
	public function process() {
		$seo_url = Tools::getValue('seo_url',false);
		// Fix product comparaison 404
		if ($seo_url == 'products-comparison') {
			ob_end_clean();
			header("Status: 301 Moved Permanently", false, 301);
			Tools::redirect('products-comparison.php?ajax='.Tools::getValue('ajax').'&action='.Tools::getValue('action').'&id_product='.Tools::getValue('id_product'));
			die();
		}

		// Get SEO search
		if ($seo_url && $this->id_seo && !Tools::getValue('getShareBlock')) {
			$resultSeoUrl = AdvancedSearchSeoClass::getSeoSearchByIdSeo($this->id_seo,$this->context->cookie->id_lang);
			// if !result 404
			if (!$resultSeoUrl) {Tools::redirect('404.php');die;}
			// 301 redirect if deleted
			if ($resultSeoUrl[0]['deleted']) {
				header("Status: 301 Moved Permanently", false, 301);
				Tools::redirect('index.php');
				die();
			}
			$currentUri = explode('?', $_SERVER['REQUEST_URI']);
			$currentUri = $currentUri[0];
			$this->realURI = __PS_BASE_URI__.(Language::countActiveLanguages() > 1 ? Language::getIsoById($this->context->cookie->id_lang).'/': '').'s/'.$resultSeoUrl[0]['id_seo'].'/'.$resultSeoUrl[0]['seo_url'];
			
			// ([a-z]{2})?/?s/([0-9]+)/([a-zA-Z0-9/_-]*)
			if (!preg_match('#([a-z]{2})?/?s/([0-9]+)/([a-zA-Z0-9/_-]*)#', $_SERVER['REQUEST_URI'])) {
				// URL NOK - Redirect with pagination
				header("Status: 301 Moved Permanently", false, 301);
				header("Location: ".$this->realURI . ((int)Tools::getValue('p') > 1 ? '?p='.(int)Tools::getValue('p') : ''));
				die();
			}
			
			// If seo_url is different to current language, redirect 301 to real URL (for prevent language switch)
			if (!Tools::getValue('id_seo_id_search') && ($resultSeoUrl[0]['seo_url'] != $seo_url || $currentUri != $this->realURI)) {
				header("Status: 301 Moved Permanently", false, 301);
				header("Location: ".$this->realURI);
				die();
			}
			$this->id_search = $resultSeoUrl[0]['id_search'];
			$AdvancedSearchClass = new AdvancedSearchClass($this->id_search,$this->context->cookie->id_lang);
			
			if (!$AdvancedSearchClass->active) {
				header("Status: 302 Moved Temporarily", false, 302);
				Tools::redirect('index.php');
				die();
			}

			// Set criteria and price range
			$criteria = unserialize($resultSeoUrl[0]['criteria']);

			if (sizeof($criteria)) {
				$this->criterions = PM_AdvancedSearch4::getArrayCriteriaFromSeoArrayCriteria($criteria);
			}
			$_GET['id_seo_id_search'] = $this->id_search;
			$_GET['as4c'] = $this->criterions;

			$this->hookName = AdvancedSearchClass::getHookName($AdvancedSearchClass->id_hook);

			// Force currency
			if ($resultSeoUrl[0]['id_currency'] && $this->context->cookie->id_currency != (int)$resultSeoUrl[0]['id_currency']) {
				$this->context->cookie->id_currency = $resultSeoUrl[0]['id_currency'];
				header('Refresh: 1; URL='.$_SERVER['REQUEST_URI']);
				die;
			}

			// Get crooslinks
			$this->context->smarty->assign('as_cross_links',AdvancedSearchSeoClass::getCrossLinksSeo($this->context->cookie->id_lang,$resultSeoUrl[0]['id_seo']));
		} else {
			if (Tools::getValue('setCollapseGroup')) {
				ob_end_clean();
				$this->id_search = Tools::getValue('id_search');
				$id_criterion_group = Tools::getValue('id_criterion_group');
				$state = Tools::getValue('state');
				$id_criterion_group = $this->id_search . '_' . $id_criterion_group;
				$criterion_state = array($id_criterion_group =>$state);
				$previous_criterion = array();
				if (isset($this->context->criterion_group_state)){
					$previous_criterion = unserialize($this->context->criterion_group_state);
					if (sizeof($previous_criterion)){
						foreach($previous_criterion as $k => $v){
							if ($k == $id_criterion_group)
								$criterion_state[$k] = $state;
							else
								$criterion_state[$k] = $v;
						}
						$this->context->criterion_group_state = serialize($criterion_state);
						die;
					}
					else
						$this->context->criterion_group_state = serialize($criterion_state);
					die;
				}
				else
					$this->context->criterion_group_state = serialize($criterion_state);
				die;
			} elseif (Tools::getValue('setHideCriterionStatus')) {
				ob_end_clean();
				$this->id_search = Tools::getValue('id_search');
				$state = Tools::getValue('state');
				if (isset($this->context->hidden_criteria_state)){
					$hidden_criteria_state = unserialize($this->context->hidden_criteria_state);
					$hidden_criteria_state[$this->id_search] = $state;
					$this->context->hidden_criteria_state = serialize($hidden_criteria_state);
				} else {
					$this->context->hidden_criteria_state = serialize(array($this->id_search=>$state));
				}
				die;
			} elseif (Tools::getValue('getShareBlock')) {
				ob_end_clean();
				echo Module::getInstanceByName('pm_advancedsearch4')->getShareBlock(Tools::getValue('ASSearchTitle'), Tools::getValue('ASSearchUrl'));
				die;
			} else if (Tools::getValue('resetSearchSelection')) {
				ob_end_clean();
				$this->id_search = Tools::getValue('id_search');
				Module::getInstanceByName('pm_advancedsearch4')->resetSearchSelection($this->id_search);
				die('1');
			}
			
			$this->criterions = Tools::getValue('as4c',array());
			$this->criterions_hidden = Tools::getValue('as4c_hidden',array());
			$this->next_id_criterion_group = Tools::getValue('next_id_criterion_group',false);
			
			$this->reset = Tools::getValue('reset',false);
			$this->reset_group = Tools::getValue('reset_group',false);
			if ($this->reset) {
				$this->criterions = array();
			}
			if ($this->reset_group) {
				unset($this->criterions[$this->reset_group]);
			}
			$this->hookName = Tools::getValue('hookName');
			$this->id_search = Tools::getValue('id_search');
			
			// Save next_id_criterion_group into cookie
			$this->context->cookie->{'next_id_criterion_group_'.(int)$this->id_search} = $this->next_id_criterion_group;
		}
	}
	
	private function fixPaginationLinks($pageContent) {
		if (_PS_VERSION_ >= 1.5) {
			// $this->realURI;
			$pageContent = str_replace('?controller=advancedsearch4?fc=module', '?controller=advancedsearch4&fc=module', $pageContent);
		}
		return $pageContent;
	}
	
	/**
	 * @see FrontController::initContent()
	 */
	public function displayContent() {
		if ((!$this->id_seo && !$this->hookName) || !$this->id_search) {die; }
		if (Tools::getValue('ajaxMode')) {
			$this->ajax = true;
		}
		
		$objPM_AdvancedSearch4 = new PM_AdvancedSearch4();
		if (!Tools::getValue('ajaxMode')) {
			$_GET['only_products'] = 1;
			echo $this->fixPaginationLinks($objPM_AdvancedSearch4->displayAjaxSearchBlocks($this->id_search,$this->hookName, 'pm_advancedsearch.tpl',intval(Tools::getValue('with_product',true)),$this->criterions,$this->criterions_hidden,true));
			unset($_GET['only_products']);
		} else {
			// Exec hook header fore some modules
			AdvancedSearchCoreClass::_hookExec('header');
			$ajaxMode = true;
			if (Tools::getValue('only_products')) {
				$objPM_AdvancedSearch4->displayAjaxSearchBlocks($this->id_search,$this->hookName, 'pm_advancedsearch.tpl',intval(Tools::getValue('with_product',true)),$this->criterions,$this->criterions_hidden,true);
			}
			// If step mode, get next step
			else if ($this->next_id_criterion_group && !$this->reset) {
				if (is_array($this->criterions) && sizeof($this->criterions)) {
					// Get all blocks
					$objPM_AdvancedSearch4->displayAjaxSearchBlocks($this->id_search,$this->hookName, 'pm_advancedsearch.tpl',intval(Tools::getValue('with_product',true)),$this->criterions,$this->criterions_hidden);
				} else {
					// Only get one block
					$objPM_AdvancedSearch4->displayNextStepSearch($this->id_search,$this->hookName,$this->next_id_criterion_group,intval(Tools::getValue('with_product',true)),$this->criterions,$this->criterions_hidden);
				}
			}
			// Else get all groups
			else {
				$objPM_AdvancedSearch4->displayAjaxSearchBlocks($this->id_search,$this->hookName, 'pm_advancedsearch.tpl',intval(Tools::getValue('with_product',true)),$this->criterions,$this->criterions_hidden);
			}
		}
		if ($this->ajax) {
			die;
		}
	}
}
