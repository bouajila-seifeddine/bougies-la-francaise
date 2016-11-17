<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:01:24
         compiled from "/home/bougies-la-francaise/public_html/modules/gtrustedstores/views/templates/hook/order-confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1996762240582d7ff407ada4-90804697%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '22a2b657f3bafbb339cc30632006d28bf591596e' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/gtrustedstores/views/templates/hook/order-confirmation.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1996762240582d7ff407ada4-90804697',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gts_merchant_order_id' => 0,
    'gts_merchant_order_domain' => 0,
    'gts_customer_email' => 0,
    'gts_customer_country' => 0,
    'gts_currency' => 0,
    'gts_order_total' => 0,
    'gts_order_discounts' => 0,
    'gts_order_shipping' => 0,
    'gts_order_tax' => 0,
    'gts_order_est_ship_date' => 0,
    'gts_order_est_delivery_date' => 0,
    'gts_has_backorder_preorder' => 0,
    'gts_has_digital_goods' => 0,
    'gts_items' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d7ff4117102_59737988',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d7ff4117102_59737988')) {function content_582d7ff4117102_59737988($_smarty_tpl) {?>

<!-- START Google Trusted Stores module: Order Confirmation -->
<div id="gts-order" style="display:none;" translate="no">

  <!-- start order and merchant information -->
  <span id="gts-o-id"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_merchant_order_id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <span id="gts-o-domain"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_merchant_order_domain']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <span id="gts-o-email"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_customer_email']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <span id="gts-o-country"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_customer_country']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <span id="gts-o-currency"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_currency']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <span id="gts-o-total"><?php echo number_format($_smarty_tpl->tpl_vars['gts_order_total']->value,2,".",'');?>
</span>
  <span id="gts-o-discounts"><?php echo number_format($_smarty_tpl->tpl_vars['gts_order_discounts']->value,2,".",'');?>
</span>
  <span id="gts-o-shipping-total"><?php echo number_format($_smarty_tpl->tpl_vars['gts_order_shipping']->value,2,".",'');?>
</span>
  <span id="gts-o-tax-total"><?php echo number_format($_smarty_tpl->tpl_vars['gts_order_tax']->value,2,".",'');?>
</span>
  <span id="gts-o-est-ship-date"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_order_est_ship_date']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <span id="gts-o-est-delivery-date"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_order_est_delivery_date']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <span id="gts-o-has-preorder"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_has_backorder_preorder']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <span id="gts-o-has-digital"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_has_digital_goods']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  <!-- end order and merchant information -->

  <!-- start repeated item specific information -->
  <?php  $_smarty_tpl->tpl_vars["i"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["i"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gts_items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["i"]->key => $_smarty_tpl->tpl_vars["i"]->value) {
$_smarty_tpl->tpl_vars["i"]->_loop = true;
?>
  <span class="gts-item">
      <span class="gts-i-name"><?php echo stripslashes($_smarty_tpl->tpl_vars['i']->value['name']);?>
</span>
      <span class="gts-i-price"><?php echo number_format($_smarty_tpl->tpl_vars['i']->value['price'],2,".",'');?>
</span>
      <span class="gts-i-quantity"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['i']->value['quantity'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
      <span class="gts-i-prodsearch-id"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['i']->value['google_shopping_id'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
      <span class="gts-i-prodsearch-store-id"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['i']->value['google_shopping_account_id'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
      <span class="gts-i-prodsearch-country"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['i']->value['google_shopping_country'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
      <span class="gts-i-prodsearch-language"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['i']->value['google_shopping_language'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
  </span>
  <?php } ?>
  <!-- end repeated item specific information -->

</div>
<!-- END Google Trusted Stores module: Order Confirmation -->
<?php }} ?>
