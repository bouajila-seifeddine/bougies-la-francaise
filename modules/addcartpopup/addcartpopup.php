<?php

/*
 * Module ShoppingList
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class AddCartPopup extends Module {

    public function __construct() {
        $this->name = 'addcartpopup';
        $this->tab = 'others';
		$this->version = '1.0';
		$this->author = 'Vupar';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6'); 
        $this->module_key = "";

        parent::__construct();

        $this->displayName = $this->l('Popup Cart');
        $this->description = $this->l("Permit add a popup when add a product to cart");
        
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall Popup Cart Module?');
    }

    
    public function install() {

        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);
                                
        if (!parent::install() OR
            !$this->registerHook('displayHeader') OR
            !$this->registerHook('displayFooterProduct') OR
            !Configuration::updateValue('CART_POPUP_ANIMATE', '0') OR
            !Configuration::updateValue('CART_POPUP_FONT_COLOR', '#1A1A18') OR
            !Configuration::updateValue('CART_POPUP_BG_COLOR', '#FFFFFF') OR
            !Configuration::updateValue('CART_POPUP_MESSAGE_FONT_COLOR', '#EF0E78') OR
            !Configuration::updateValue('CART_POPUP_BASKET_FONT_COLOR', '#FFFFFF') OR
            !Configuration::updateValue('CART_POPUP_BASKET_BG_COLOR', '#EF0E78') OR
            !Configuration::updateValue('CART_POPUP_BASKET_HOVER_COLOR', '#1A1A18') OR
            !Configuration::updateValue('CART_POPUP_CONTINUE_FONT_COLOR', '#FFFFFF') OR
            !Configuration::updateValue('CART_POPUP_CONTINUE_BG_COLOR', '#ADAEAE') OR
            !Configuration::updateValue('CART_POPUP_CONTINUE_HOVER_COLOR', '#1A1A18')) {
                return false;
        }
        
        return true;
    }
    
    
    public function uninstall() {       
        
        if (!parent::uninstall() OR
            !Configuration::deleteByName('CART_POPUP_ANIMATE') OR
            !Configuration::deleteByName('CART_POPUP_FONT_COLOR') OR
            !Configuration::deleteByName('CART_POPUP_BG_COLOR') OR
            !Configuration::deleteByName('CART_POPUP_MESSAGE_FONT_COLOR') OR
            !Configuration::deleteByName('CART_POPUP_BASKET_FONT_COLOR') OR
            !Configuration::deleteByName('CART_POPUP_BASKET_BG_COLOR') OR
            !Configuration::deleteByName('CART_POPUP_BASKET_HOVER_COLOR') OR
            !Configuration::deleteByName('CART_POPUP_CONTINUE_FONT_COLOR') OR
            !Configuration::deleteByName('CART_POPUP_CONTINUE_BG_COLOR') OR
            !Configuration::deleteByName('CART_POPUP_CONTINUE_HOVER_COLOR')) {
                return false;
        }

        return true;
    }
    
    
    /*public function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';

		if (Tools::isSubmit('submitUpdate'))
		{
			if (Tools::getValue('CART_POPUP_ANIMATE') != false && Validate::isBool(Tools::getValue('CART_POPUP_ANIMATE')))
				Configuration::updateValue('CART_POPUP_ANIMATE', Tools::getValue('CART_POPUP_ANIMATE'));

			if (Tools::getValue('CART_POPUP_FONT_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_FONT_COLOR')))
				Configuration::updateValue('CART_POPUP_FONT_COLOR', Tools::getValue('CART_POPUP_FONT_COLOR'));
            
            if (Tools::getValue('CART_POPUP_BG_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_BG_COLOR')))
				Configuration::updateValue('CART_POPUP_BG_COLOR', Tools::getValue('CART_POPUP_BG_COLOR'));
            
            if (Tools::getValue('CART_POPUP_MESSAGE_FONT_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_MESSAGE_FONT_COLOR')))
				Configuration::updateValue('CART_POPUP_MESSAGE_FONT_COLOR', Tools::getValue('CART_POPUP_MESSAGE_FONT_COLOR'));
            
            if (Tools::getValue('CART_POPUP_BASKET_FONT_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_BASKET_FONT_COLOR')))
				Configuration::updateValue('CART_POPUP_BASKET_FONT_COLOR', Tools::getValue('CART_POPUP_BASKET_FONT_COLOR'));
            
            if (Tools::getValue('CART_POPUP_BASKET_BG_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_BASKET_BG_COLOR')))
				Configuration::updateValue('CART_POPUP_BASKET_BG_COLOR', Tools::getValue('CART_POPUP_BASKET_BG_COLOR'));
            
            if (Tools::getValue('CART_POPUP_BASKET_HOVER_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_BASKET_HOVER_COLOR')))
				Configuration::updateValue('CART_POPUP_BASKET_HOVER_COLOR', Tools::getValue('CART_POPUP_BASKET_HOVER_COLOR'));
            
            if (Tools::getValue('CART_POPUP_CONTINUE_FONT_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_CONTINUE_FONT_COLOR')))
				Configuration::updateValue('CART_POPUP_CONTINUE_FONT_COLOR', Tools::getValue('CART_POPUP_CONTINUE_FONT_COLOR'));
            
            if (Tools::getValue('CART_POPUP_CONTINUE_BG_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_CONTINUE_BG_COLOR')))
				Configuration::updateValue('CART_POPUP_CONTINUE_BG_COLOR', Tools::getValue('CART_POPUP_CONTINUE_BG_COLOR'));
            
            if (Tools::getValue('CART_POPUP_CONTINUE_HOVER_COLOR') != false && Validate::isColor(Tools::getValue('CART_POPUP_CONTINUE_HOVER_COLOR')))
				Configuration::updateValue('CART_POPUP_CONTINUE_HOVER_COLOR', Tools::getValue('CART_POPUP_CONTINUE_HOVER_COLOR'));
            
			if (!Validate::isColor(Tools::getValue('CART_POPUP_FONT_COLOR')) || !Validate::isColor(Tools::getValue('CART_POPUP_BG_COLOR')) ||
                !Validate::isColor(Tools::getValue('CART_POPUP_MESSAGE_FONT_COLOR')) || !Validate::isColor(Tools::getValue('CART_POPUP_BASKET_FONT_COLOR')) ||
                !Validate::isColor(Tools::getValue('CART_POPUP_BASKET_BG_COLOR')) || !Validate::isColor(Tools::getValue('CART_POPUP_BASKET_HOVER_COLOR')) ||
                !Validate::isColor(Tools::getValue('CART_POPUP_CONTINUE_FONT_COLOR')) || !Validate::isColor(Tools::getValue('CART_POPUP_CONTINUE_BG_COLOR')) ||
                !Validate::isColor(Tools::getValue('CART_POPUP_CONTINUE_HOVER_COLOR')))
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
                    
                <div class="info">
                    '.$this->l("To use this module, we need to activate blockcart module and place addcartpopup module under 
                    blockcart module in the hook 'Header' (in the position page). Furthermore you need to activate
                    Ajax Cart in Blockcart module.").'
                </div>
				
                <label>'.$this->l('Desactivate Ajax Animation').'</label>
				<div class="margin-form">
                    <input type="radio" name="CART_POPUP_ANIMATE" id="animate_on" value="1" '.(Configuration::get('CART_POPUP_ANIMATE') == '1' ? 'checked="checked" ' : '').'/>
					<label class="t" for="animate_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
					<input type="radio" name="CART_POPUP_ANIMATE" id="animate_off" value="0" '.(Configuration::get('CART_POPUP_ANIMATE') == '0' ? 'checked="checked" ' : '').'/>
					<label class="t" for="animate_off"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
					<p class="clear">'.$this->l('By default, the module BlockCart play an animation when you add a product in the cart. This option can desactivate them').'</p>
				</div>
				<div class="clear"></div>
                
                <label>'.$this->l('Font color of popup').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_FONT_COLOR" value="'.Configuration::get('CART_POPUP_FONT_COLOR').'" class="color mColorPickerInput"/>
                </div>
				<div class="clear"></div>
                
                <label>'.$this->l('Background color of popup').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_BG_COLOR" value="'.Configuration::get('CART_POPUP_BG_COLOR').'" class="color mColorPickerInput"/>
                </div>
				<div class="clear"></div>
                
                <label>'.$this->l('Message font color').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_MESSAGE_FONT_COLOR" value="'.Configuration::get('CART_POPUP_MESSAGE_FONT_COLOR').'" class="color mColorPickerInput"/>
                </div>
				<div class="clear"></div>
                
                <label>'.$this->l('Font color of basket button').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_BASKET_FONT_COLOR" value="'.Configuration::get('CART_POPUP_BASKET_FONT_COLOR').'" class="color mColorPickerInput"/>
                </div>
				<div class="clear"></div>
                
                <label>'.$this->l('Background color of basket button').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_BASKET_BG_COLOR" value="'.Configuration::get('CART_POPUP_BASKET_BG_COLOR').'" class="color mColorPickerInput"/>
                </div>
				<div class="clear"></div>
                
                <label>'.$this->l('Hover Background color of basket button').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_BASKET_HOVER_COLOR" value="'.Configuration::get('CART_POPUP_BASKET_HOVER_COLOR').'" class="color mColorPickerInput"/>
                </div>
				<div class="clear"></div>
                
                <label>'.$this->l('Font color of continue button').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_CONTINUE_FONT_COLOR" value="'.Configuration::get('CART_POPUP_CONTINUE_FONT_COLOR').'" class="color mColorPickerInput"/>
                </div>
				<div class="clear"></div>
                
                <label>'.$this->l('Background color of continue button').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_CONTINUE_BG_COLOR" value="'.Configuration::get('CART_POPUP_CONTINUE_BG_COLOR').'" class="color mColorPickerInput"/>
                </div>
				<div class="clear"></div>
                
                <label>'.$this->l('Hover Background color of continue button').'</label>
				<div class="margin-form">
					<input type="color" data-hex="true" name="CART_POPUP_CONTINUE_HOVER_COLOR" value="'.Configuration::get('CART_POPUP_CONTINUE_HOVER_COLOR').'" class="color mColorPickerInput"/>
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
        $this->context->controller->addCSS($this->_path.'views/css/addcartpopup.css');
        $this->context->controller->addJS($this->_path.'views/js/addcartpopup.js');
    }
    
    
    public function hookDisplayFooterProduct($params) {
        
        
        
        $id_product = (int)Tools::getValue('id_product');
        $product = new Product($id_product, false, $this->context->language->id, $this->context->shop->id);
        $image = Product::getCover($id_product);
        
        $this->context->smarty->assign(array(
            'product'=> $product,
            'image'=> $image,
            'productPrice'=> $product->getPrice(Product::$_taxCalculationMethod == PS_TAX_INC, false),
            'order_process' => Configuration::get('PS_ORDER_PROCESS_TYPE') ? 'order-opc' : 'order',
            'animate' => Configuration::get('CART_POPUP_ANIMATE'),
            'font_color' => Configuration::get('CART_POPUP_FONT_COLOR'),
            'background_color' => Configuration::get('CART_POPUP_BG_COLOR'),
            'message_font_color' => Configuration::get('CART_POPUP_MESSAGE_FONT_COLOR'),
            'basket_font_color' => Configuration::get('CART_POPUP_BASKET_FONT_COLOR'),
            'basket_background_color' => Configuration::get('CART_POPUP_BASKET_BG_COLOR'),
            'basket_hover_color' => Configuration::get('CART_POPUP_BASKET_HOVER_COLOR'),
            'continue_font_color' => Configuration::get('CART_POPUP_CONTINUE_FONT_COLOR'),
            'continue_background_color' => Configuration::get('CART_POPUP_CONTINUE_BG_COLOR'),
            'continue_hover_color' => Configuration::get('CART_POPUP_CONTINUE_HOVER_COLOR')
        ));
        
        return $this->display(__FILE__, 'views/templates/hook/addcartpopup.tpl');
    }
}