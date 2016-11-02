{*
* 2003-2015 Business Tech
*
* @author Business Tech SARL <http://www.businesstech.fr/en/contact-us>
* @copyright  2003-2015 Business Tech SARL
*}

<!-- START Google Trusted Stores module: Order Confirmation -->
<div id="gts-order" style="display:none;" translate="no">

  <!-- start order and merchant information -->
  <span id="gts-o-id">{$gts_merchant_order_id|escape:'htmlall':'UTF-8'}</span>
  <span id="gts-o-domain">{$gts_merchant_order_domain|escape:'htmlall':'UTF-8'}</span>
  <span id="gts-o-email">{$gts_customer_email|escape:'htmlall':'UTF-8'}</span>
  <span id="gts-o-country">{$gts_customer_country|escape:'htmlall':'UTF-8'}</span>
  <span id="gts-o-currency">{$gts_currency|escape:'htmlall':'UTF-8'}</span>
  <span id="gts-o-total">{$gts_order_total|number_format:2:".":""}</span>
  <span id="gts-o-discounts">{$gts_order_discounts|number_format:2:".":""}</span>
  <span id="gts-o-shipping-total">{$gts_order_shipping|number_format:2:".":""}</span>
  <span id="gts-o-tax-total">{$gts_order_tax|number_format:2:".":""}</span>
  <span id="gts-o-est-ship-date">{$gts_order_est_ship_date|escape:'htmlall':'UTF-8'}</span>
  <span id="gts-o-est-delivery-date">{$gts_order_est_delivery_date|escape:'htmlall':'UTF-8'}</span>
  <span id="gts-o-has-preorder">{$gts_has_backorder_preorder|escape:'htmlall':'UTF-8'}</span>
  <span id="gts-o-has-digital">{$gts_has_digital_goods|escape:'htmlall':'UTF-8'}</span>
  <!-- end order and merchant information -->

  <!-- start repeated item specific information -->
  {foreach from=$gts_items item="i"}
  <span class="gts-item">
      <span class="gts-i-name">{$i.name|stripslashes}</span>
      <span class="gts-i-price">{$i.price|number_format:2:".":""}</span>
      <span class="gts-i-quantity">{$i.quantity|escape:'htmlall':'UTF-8'}</span>
      <span class="gts-i-prodsearch-id">{$i.google_shopping_id|escape:'htmlall':'UTF-8'}</span>
      <span class="gts-i-prodsearch-store-id">{$i.google_shopping_account_id|escape:'htmlall':'UTF-8'}</span>
      <span class="gts-i-prodsearch-country">{$i.google_shopping_country|escape:'htmlall':'UTF-8'}</span>
      <span class="gts-i-prodsearch-language">{$i.google_shopping_language|escape:'htmlall':'UTF-8'}</span>
  </span>
  {/foreach}
  <!-- end repeated item specific information -->

</div>
<!-- END Google Trusted Stores module: Order Confirmation -->
