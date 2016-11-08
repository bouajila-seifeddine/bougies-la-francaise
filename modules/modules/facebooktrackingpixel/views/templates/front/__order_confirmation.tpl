{*
 * The module integrates Facebook Tracking Pixel for order conversion measurement into your e-shop.
 * 
 * @author    Esentra <prestashop@esentra.sk>
 * @copyright 2013 Esentra, s.r.o.
 * @version   Release: $Revision$
 * @license   Commercial 
 *}
 
<!-- BEGIN: Facebook Conversion Code for "{$tracking_pixel_name|escape:'htmlall':'UTF-8'}" -->
<script>
    {literal}
    (function() {
        var _fbq = window._fbq || (window._fbq = []);
        if (!_fbq.loaded) {
          var fbds = document.createElement('script');
          fbds.async = true;
          fbds.src = '//connect.facebook.net/en_US/fbds.js';
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(fbds, s);
          _fbq.loaded = true;
        }
    })();
    window._fbq = window._fbq || [];
    window._fbq.push(['track', '{/literal}{$tracking_pixel_id|escape:'htmlall':'UTF-8'}{literal}', {'value':'{/literal}{$order_total|escape:'htmlall':'UTF-8'}{literal}','currency':'{/literal}{$order_currency|escape:'htmlall':'UTF-8'}{literal}'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev={/literal}{$tracking_pixel_id|escape:'htmlall':'UTF-8'}{literal}&amp;cd[value]={/literal}{$order_total|escape:'htmlall':'UTF-8'}{literal}&amp;cd[currency]={/literal}{$order_currency|escape:'htmlall':'UTF-8'}{literal}&amp;noscript=1" /></noscript>
{/literal}
<!-- END: Facebook Conversion Code for "{$tracking_pixel_name|escape:'htmlall':'UTF-8'}" -->