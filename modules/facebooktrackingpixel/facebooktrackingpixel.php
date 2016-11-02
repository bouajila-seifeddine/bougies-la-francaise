<?php
/**
 * The module integrates Facebook Tracking Pixel for order conversion measurement into your e-shop.
 * 
 * @author    Esentra <prestashop@esentra.sk>
 * @copyright 2013 Esentra, s.r.o.
 * @version   Release: $Revision$
 * @license   Commercial 
 */

if (!defined('_PS_VERSION_'))
	exit;
                
class FacebookTrackingPixel extends Module
{	
	public function __construct()
	{
	 	$this->name = 'facebooktrackingpixel';
		if(version_compare(_PS_VERSION_, '1.4.0.0') >= 0)
                    $this->tab = 'analytics_stats';
		else
                    $this->tab = 'analytics_stats';
	 	$this->version = '1.0.1';
		$this->author = 'Esentra';
		$this->displayName = 'Facebook Ads Conversion Tracking Pixel';
        $this->module_key = 'cfc6f223b6019638fa8d47520f488975';
		
	 	parent::__construct();
		
		$this->description = $this->l('Integrate Facebook ads conversion tracking pixel into your shop.');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details?');

		/** Backward compatibility */
		require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
	}

	public function install()
	{
		if (!parent::install() || !$this->registerHook('orderConfirmation'))
			return false;
		
                Configuration::updateValue('ESENTRA_FBTP_ID', '');
                Configuration::updateValue('ESENTRA_FBTP_NAME', '');
                Configuration::updateValue('ESENTRA_FBTP_PRICE', 'default');
                
		return true;
	}
	
	public function uninstall()
	{
		if (!Configuration::deleteByName('ESENTRA_FBTP_ID') || 
                    !Configuration::deleteByName('ESENTRA_FBTP_NAME') || 
                    !Configuration::deleteByName('ESENTRA_FBTP_PRICE') || 
                    !parent::uninstall()
                )
			return false;
		return true;
	}
	
	public function getContent()
	{
		$output = '';
		if (Tools::isSubmit('submitFacebook'))
		{        
            if (Tools::getValue('tracking_pixel_id') != Configuration::get('ESENTRA_FBTP_ID') || 
                Tools::getValue('tracking_pixel_name') != Configuration::get('ESENTRA_FBTP_NAME') ||
                Tools::getValue('tracking_pixel_price') != Configuration::get('ESENTRA_FBTP_PRICE')
            ) 
            {
                $output .= '
                <div class="conf confirm">
                        <img src="../img/admin/ok.gif" alt="" title="" />
                        '.$this->l('Settings updated').'
                </div>';
            }

			Configuration::updateValue('ESENTRA_FBTP_ID', Tools::getValue('tracking_pixel_id'));
			Configuration::updateValue('ESENTRA_FBTP_NAME', Tools::getValue('tracking_pixel_name'));
			Configuration::updateValue('ESENTRA_FBTP_PRICE', Tools::getValue('tracking_pixel_price'));
        }
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		$output = '
                <fieldset>
                        <legend><img src="../img/admin/choose.gif" alt="" class="middle" />'.$this->l('About the Facebook Ads Conversion Tracking').'</legend>
			<p><img style="float:left; margin-right: 10px; margin-top: -12px;" src="../modules/facebooktrackingpixel/views/img/facebooktrackingpixel.png" alt="" class="middle" />' .$this->l('Facebook Ads conversion tracking helps businesses measure the return on investment of their Facebook Ads by reporting on the actions people take after your ads are served. Advertisers can create pixels that track conversions, add them to the pages of their website where the conversions will happen, and then track these conversions back to ads they are running on Facebook.').'</p>
                </fieldset>				
                <br/>
		<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset>
				<legend><img src="../img/admin/cog.gif" alt="" class="middle" />'.$this->l('Tracking Pixel Settings').'</legend>
				<label>'.$this->l('Pixel ID').'</label>
				<div class="margin-form">
					<input style="width: 390px;" type="text" name="tracking_pixel_id" value="'.Tools::safeOutput(Tools::getValue('tracking_pixel_id', Configuration::get('ESENTRA_FBTP_ID'))).'" />
					<p class="clear">'.$this->l('ID of the Facebook Ads Conversion Tracking Pixel. This is required setting.').'</p>
				</div>
				<label>'.$this->l('Pixel Name').'</label>
				<div class="margin-form">
					<input style="width: 390px;" type="text" name="tracking_pixel_name" value="'.Tools::safeOutput(Tools::getValue('tracking_pixel_name', Configuration::get('ESENTRA_FBTP_NAME'))).'" />
					<p class="clear">'.$this->l('Name of the Facebook Ads Conversion Tracking Pixel. This is optional setting.').'</p>
				</div>
				<label>'.$this->l('Price Calculation').'</label>
				<div class="margin-form">
                                    <select style="width: 400px;" name="tracking_pixel_price">
                                            <option value="-" '.(Tools::getValue('default', Configuration::get('ESENTRA_FBTP_PRICE')) == 'default' ? 'selected="selected" ' : '').'>'.$this->l('Default').'</option>
                                            <option value="total_products_incl_tax" '.(Tools::getValue('tracking_pixel_price', Configuration::get('ESENTRA_FBTP_PRICE')) == 'total_products_incl_tax' ? 'selected="selected" ' : '').'>'.$this->l('Including tax (products only)').'</option>
                                            <option value="total_paid_incl_tax" '.(Tools::getValue('tracking_pixel_price', Configuration::get('ESENTRA_FBTP_PRICE')) == 'total_paid_incl_tax' ? 'selected="selected" ' : '').'>'.$this->l('Including tax (total paid /incl. shipping, wrapping, etc./)').'</option>
                                            <option value="total_products_excl_tax" '.(Tools::getValue('tracking_pixel_price', Configuration::get('ESENTRA_FBTP_PRICE')) == 'total_products_excl_tax' ? 'selected="selected" ' : '').'>'.$this->l('Excluding tax (products only)').'</option>
                                            <option value="total_paid_excl_tax" '.(Tools::getValue('tracking_pixel_price', Configuration::get('ESENTRA_FBTP_PRICE')) == 'total_paid_excl_tax' ? 'selected="selected" ' : '').'>'.$this->l('Excluding tax (total paid /incl. shipping, wrapping, etc./)').'</option>
                                    </select>
                                    <p class="clear">'.$this->l('Specification of price calculation for Facebook conversion tracking.') . '<br/>' . $this->l('Please use "Default" for getting price from the order confirmation screen.').'</p>
				</div>
				<center><input type="submit" name="submitFacebook" value="'.$this->l('Save').'" class="button" /></center>
			</fieldset>
		</form>
                <br/>
                <fieldset>
                        <legend><img src="../img/admin/help.png" alt="" class="middle" />'.$this->l('How to setup').'</legend>
	                <p>' .$this->l('Navigate to your Facebook Account and go to the Facebook Ads page, where you click on the "Conversion Tracking" tab. Now click on the "Create Conversion Pixel" tab and the pop-up box will appear which will ask you for "Name" & "Category". Immediately Facebook will then generate a code (your offsite pixel) including your tracking pixel ID which must be used for module configuration.').'</p>
                </fieldset>				
                <br/>
                <fieldset>
                        <legend><img src="../img/admin/details.gif" alt="" class="middle" />'.$this->l('About the Authors').'</legend>
			<p><strong>'.$this->l('Esentra').'</strong></p>
                        <p> '.$this->l('Building of e-shops based on the Prestashop and Magento platforms, webdesign and web solutions realization with self content management (CMS), services in the field of information systems (CRM) integration and IT consulting (internet marketing & search engine optimization).').'</p>
                </fieldset>';				
		return $output;
	}

	public function hookOrderConfirmation($params)
	{
        $tracking_pixel_id = Configuration::get('ESENTRA_FBTP_ID');
        $name = Tools::isEmpty(trim(Configuration::get('ESENTRA_FBTP_NAME'))) ? Configuration::get('PS_SHOP_NAME') : Configuration::get('ESENTRA_FBTP_NAME');
        switch (Configuration::get('ESENTRA_FBTP_PRICE')) {
            case 'total_products_incl_tax': $price = $params['objOrder']->total_products_wt; break;
            case 'total_products_excl_tax': $price = $params['objOrder']->total_products; break;
            case 'total_paid_incl_tax': $price = $params['objOrder']->total_paid_tax_incl; break;
            case 'total_paid_excl_tax': $price = $params['objOrder']->total_paid_tax_excl; break;
            default: $price = $params['total_to_pay'];
        }
        if ($tracking_pixel_id) {
            $this->context->smarty->assign('tracking_pixel_id', $tracking_pixel_id);
            $this->context->smarty->assign('tracking_pixel_name', $name);
            $this->context->smarty->assign('order_currency', $params['currencyObj']->iso_code);
            $this->context->smarty->assign('order_total', $price);
            return $this->display(__FILE__, 'views/templates/front/order_confirmation.tpl');
        }
	}        

}
