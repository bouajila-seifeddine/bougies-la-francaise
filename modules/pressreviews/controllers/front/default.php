<?php

require_once _PS_MODULE_DIR_ . 'pressreviews/models/PrReviews.php';

class pressreviewsdefaultModuleFrontController extends ModuleFrontController {

	//public $php_self = 'module-pressreviews-default.php';

	public function initContent() {

		parent::initContent();

		$imgHeight = (int)Configuration::get('PR_THUMB_HEIGHT');
		$imgWidth = (int)Configuration::get('PR_THUMB_WIDTH');
		$intro = array();
		$date_conf = array();
		$nbItems = PrReviews::countItems();
		$pagi = $nbItems;
		$n = abs((int)(Tools::getValue('n', (int)Configuration::get('PR_ITEMS_PER_PAGE'))));
		$p = abs((int)(Tools::getValue('p', 1)));

		$range = 3;
		if ($p > (($nbItems / $n) + 1))
	        Tools::redirect(preg_replace('/[&?]p=\d+/', '', $_SERVER['REQUEST_URI']));
	    
	    ($n == 0 ? $pages_nb = 1 : $pages_nb = ceil($nbItems / (int)($n)));

	    $start = (int)($p - $range);
	    
	    if ($start < 1)
	        $start = 1;
	    
	    $end = (int)($p + $range);
	    
	    if ($end > $pages_nb)
	        $end = (int)($pages_nb);
		
	    $items = PrReviews::getItems($p, $n);
		
		$langs = Language::getLanguages();
		foreach ($langs as $language)
		{
			$intro[$language['id_lang']] = Configuration::get('PR_INTRO_TEXT', $language['id_lang']);
			$date_conf[$language['id_lang']] = $language['date_format_lite'];
		}

		if ($items !== FALSE) {
			$this->context->smarty->assign('reviews', $items);
		}
		
		$itemsDisplay = Tools::unSerialize(Configuration::get('PR_ELEMENTS_DISPLAY'));
		
		$this->context->smarty->assign(
			array(
				'imgHeight'		=>	$imgHeight,
				'imgWidth'		=>	$imgWidth,
				'date_conf'		=>	$date_conf,
				'intro'			=>	$intro,
				'pagi'			=>	$pagi,
				'p' 			=> (int)$p,
				'n' 			=> (int)$n,
				'nbItems'		=>	(int)$nbItems,
				'range' 		=> (int)$range,
		        'start' 		=> (int)$start,
		        'end' 			=> (int)$end,
		        'pages_nb' 		=> (int)$pages_nb,
		        'itemsDisplay'	=>	$itemsDisplay,
		   )
	    );
			
		$controller = new FrontController();
		$controller->pagination((int)PrReviews::countItems());
		
		$this->setTemplate('pressreviews.tpl');

	}
	
	public function setMedia() {
	
		parent::setMedia();
		/**
		* JS Files
		**/
		/*COmmented by Olivier
         * if(file_exists(_PS_JS_DIR_.'jquery/jquery-1.7.2.min.js'))
			$this->context->controller->addJS(_PS_JS_DIR_.'jquery/jquery-1.7.2.min.js');
		else
			$this->context->controller->addJS(_MODULE_DIR_.'pressreviews/views/js/jquery-1.7.2.min.js');
		
		if(file_exists(_PS_JS_DIR_.'jquery/plugins/fancybox/jquery.fancybox.js'))
			$this->context->controller->addJS(_PS_JS_DIR_.'jquery/plugins/fancybox/jquery.fancybox.js');
		else
			$this->context->controller->addJS(_MODULE_DIR_.'pressreviews/views/js/jquery.fancybox.js');
        */
			
		/**
		* CSS Files	
		**/	
		if(file_exists(_PS_JS_DIR_.'jquery/plugins/fancybox/jquery.fancybox.css'))
			$this->context->controller->addCSS(_PS_JS_DIR_.'jquery/plugins/fancybox/jquery.fancybox.css', 'all');
		else
			$this->context->controller->addCSS(_MODULE_DIR_.'pressreviews/views/css/jquery.fancybox.css', 'all');
			
		$this->context->controller->addCSS(_MODULE_DIR_.'pressreviews/views/css/pressreviews.css', 'all');
		$this->context->controller->addJS(_MODULE_DIR_.'pressreviews/views/js/pressreviews.js');
	}

}

?>