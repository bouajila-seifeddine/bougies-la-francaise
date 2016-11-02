{*
 * The module integrates Facebook Tracking Pixel for order conversion measurement into your e-shop.
 * 
 * @author    Esentra <prestashop@esentra.sk>
 * @copyright 2013 Esentra, s.r.o.
 * @version   Release: $Revision$
 * @license   Commercial 
 *}
 
<!-- BEGIN: Facebook Conversion Code for "{$tracking_pixel_name|escape:'htmlall':'UTF-8'}" -->
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev={$tracking_pixel_id|escape:'htmlall':'UTF-8'}&amp;cd[value]={$order_total|escape:'htmlall':'UTF-8'}&amp;cd[currency]={$order_currency|escape:'htmlall':'UTF-8'}&amp;noscript=1" /></noscript>
<!-- END: Facebook Conversion Code for "{$tracking_pixel_name|escape:'htmlall':'UTF-8'}" -->