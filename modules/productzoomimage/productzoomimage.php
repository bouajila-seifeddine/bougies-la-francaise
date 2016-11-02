<?php

/*
 * Module ShoppingList
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductZoomImage extends Module {

    public function __construct() {
        $this->name = 'productzoomimage';
        $this->tab = 'others';
		$this->version = '1.0';
		$this->author = 'Vupar';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); 
        $this->module_key = "";

        parent::__construct();

        $this->displayName = $this->l('Popup Image');
        $this->description = $this->l("Permit to add a popup on product detail page");
        
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall Popup Image Module?');
    }

    
    public function install() {

        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);
                                
        if (!parent::install() OR
            !$this->registerHook('displayHeader') OR
            !$this->registerHook('displayFooterProduct') OR
            !Configuration::updateValue('PRODUCT_ZOOM_VERTICAL_POSITION', 'bottom') OR
            !Configuration::updateValue('PRODUCT_ZOOM_HORIZONTAL_POSITION', 'right') OR
            !Configuration::updateValue('PRODUCT_ZOOM_BACKGROUND', '#fff') OR
            !Configuration::updateValue('PRODUCT_ZOOM_COLOR', '#ccc')) {
                return false;
        }
        
        return true;
    }
    
    
    public function uninstall() {       
        
        if (!parent::uninstall() OR
            !Configuration::deleteByName('PRODUCT_ZOOM_VERTICAL_POSITION') OR
            !Configuration::deleteByName('PRODUCT_ZOOM_HORIZONTAL_POSITION') OR
            !Configuration::deleteByName('PRODUCT_ZOOM_BACKGROUND') OR
            !Configuration::deleteByName('PRODUCT_ZOOM_COLOR')) {
                return false;
        }

        return true;
    }
    
    
    /*public function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';

		if (Tools::isSubmit('submitUpdate'))
		{
			if (Tools::getValue('PRODUCT_ZOOM_VERTICAL_POSITION') != false && Validate::isString(Tools::getValue('PRODUCT_ZOOM_VERTICAL_POSITION')))
				Configuration::updateValue('PRODUCT_ZOOM_VERTICAL_POSITION', Tools::getValue('PRODUCT_ZOOM_VERTICAL_POSITION'));

			if (Tools::getValue('PRODUCT_ZOOM_HORIZONTAL_POSITION') != false && Validate::isString(Tools::getValue('PRODUCT_ZOOM_HORIZONTAL_POSITION')))
				Configuration::updateValue('PRODUCT_ZOOM_HORIZONTAL_POSITION', Tools::getValue('PRODUCT_ZOOM_HORIZONTAL_POSITION'));
            
            if (Tools::getValue('PRODUCT_ZOOM_BACKGROUND') != false && Validate::isColor(Tools::getValue('PRODUCT_ZOOM_BACKGROUND')))
				Configuration::updateValue('PRODUCT_ZOOM_BACKGROUND', Tools::getValue('PRODUCT_ZOOM_BACKGROUND'));
            
            if (Tools::getValue('PRODUCT_ZOOM_COLOR') != false && Validate::isColor(Tools::getValue('PRODUCT_ZOOM_COLOR')))
				Configuration::updateValue('PRODUCT_ZOOM_COLOR', Tools::getValue('PRODUCT_ZOOM_COLOR'));

			if (!Validate::isColor(Tools::getValue('PRODUCT_ZOOM_BACKGROUND')) || !Validate::isColor(Tools::getValue('PRODUCT_ZOOM_COLOR')))
				$this->_html .= '<div class="alert">'.$this->l('The color format is invalid. It must be an hexadecimal like #ffffff').'</div>';
		}
		return $this->_displayForm();
	}*/

    
	private function _displayForm()
	{
		$this->_html .= '
        <script type="text/javascript" src="'.(Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').$this->context->shop->domain.$this->context->shop->getBaseURI().'js/jquery/plugins/jquery.colorpicker.js"></script>
		<form method="post" action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'">
			<fieldset>
				<legend><img src="'.$this->_path.'logo.png" width="16" height="16"/>'.$this->l('Settings').'</legend>
				
                <label>'.$this->l('Vertical position of legend').'</label>
				<div class="margin-form">
                    <select name="PRODUCT_ZOOM_VERTICAL_POSITION">
                        <option value="top" '.(Configuration::get('PRODUCT_ZOOM_VERTICAL_POSITION') == 'top' ? 'selected="selected" ' : '').'>'.$this->l('Top').'</option>
                        <option value="bottom" '.(Configuration::get('PRODUCT_ZOOM_VERTICAL_POSITION') == 'bottom' ? 'selected="selected" ' : '').'>'.$this->l('Bottom').'</option>
                    </select>
				</div>
				<div class="clear"></div>
                
                <label>'.$this->l('Horizontal position of legend').'</label>
				<div class="margin-form">
                    <select name="PRODUCT_ZOOM_HORIZONTAL_POSITION">
                        <option value="left" '.(Configuration::get('PRODUCT_ZOOM_HORIZONTAL_POSITION') == 'left' ? 'selected="selected" ' : '').'>'.$this->l('Left').'</option>
                        <option value="right" '.(Configuration::get('PRODUCT_ZOOM_HORIZONTAL_POSITION') == 'right' ? 'selected="selected" ' : '').'>'.$this->l('Right').'</option>
                    </select>
				</div>
				<div class="clear"></div>
                
				<label>'.$this->l('Background color of legend block').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="PRODUCT_ZOOM_BACKGROUND" value="'.Configuration::get('PRODUCT_ZOOM_BACKGROUND').'" class="color mColorPickerInput"	/>
                </div>
				<div class="clear"></div>
                
				<label>'.$this->l('Color of legend font').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="PRODUCT_ZOOM_COLOR" value="'.Configuration::get('PRODUCT_ZOOM_COLOR').'" />
                </div>
				<div class="clear"></div>
                
				<div class="margin-form clear pspace">
                    <input type="submit" name="submitUpdate" value="'.$this->l('Update').'" class="button" />
                </div>
			</fieldset>
		</form>';

		return $this->_html;
	}
    
    
    public function hookDisplayHeader($params) {
        $this->context->controller->addCSS($this->_path.'views/css/productzoomimage.css');
        $this->context->controller->addJS($this->_path.'views/js/productzoomimage.js');
    }
    
    
    public function hookDisplayFooterProduct($params) {
        
        $id_product = (int)Tools::getValue('id_product');
        $product = new Product($id_product, false, $this->context->language->id, $this->context->shop->id);
        $images = $product->getImages((int)$this->context->cookie->id_lang);

        $this->context->smarty->assign(array(
            'product'=> $product,
            'images'=> $images,
            'productPrice'=> $product->getPrice(Product::$_taxCalculationMethod == PS_TAX_INC, false),
            'vertical_position' => Configuration::get('PRODUCT_ZOOM_VERTICAL_POSITION'),
            'horizontal_position' => Configuration::get('PRODUCT_ZOOM_HORIZONTAL_POSITION'),
            'background' => Configuration::get('PRODUCT_ZOOM_BACKGROUND'),
            'color' => Configuration::get('PRODUCT_ZOOM_COLOR'),
        ));

        return $this->display(__FILE__, 'views/templates/hook/productzoomimage.tpl');
    }
}