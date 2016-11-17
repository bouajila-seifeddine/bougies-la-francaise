<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 10:57:25
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/paypal/views/templates/hook/express_checkout_payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1514897341582d7f05d396c9-24883222%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e0b78c06f82e60d6c892369457ec2443c72579b3' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/paypal/views/templates/hook/express_checkout_payment.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1514897341582d7f05d396c9-24883222',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'use_paypal_in_context' => 0,
    'base_dir_ssl' => 0,
    'PayPal_payment_type' => 0,
    'PayPal_current_page' => 0,
    'PayPal_tracking_code' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d7f05d86547_88476148',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d7f05d86547_88476148')) {function content_582d7f05d86547_88476148($_smarty_tpl) {?>

<?php if (@constant('_PS_VERSION_')>=1.6) {?>

	<div class="col-sm-6 col-xs-12">
        <p class="payment_module paypal">
        	<?php if ($_smarty_tpl->tpl_vars['use_paypal_in_context']->value) {?>
				<a href="javascript:void(0)" onclick="" id="paypal_process_payment" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
">
			<?php } else { ?>
				<a href="javascript:void(0)" onclick="$('#paypal_payment_form').submit();" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
">
			<?php }?>
				<span>
					<!--  -->
					
					<i class="ycon-paypal-1"></i>
					<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>

				</span>
			</a>
		</p>
    </div>
<?php } else { ?>
<p class="payment_module">
	<a href="javascript:void(0)" id="paypal_process_payment" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
">
		<!--
		
		-->
		<i class="ycon-paypal-1"></i>
		<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>

	</a>
</p>

<?php }?>


<?php if ($_smarty_tpl->tpl_vars['use_paypal_in_context']->value) {?>
	<input type="hidden" id="in_context_checkout_enabled" value="1">
<?php } else { ?>
<script>
	$(document).ready(function(){
		$('#paypal_process_payment').click(function(){
			$('#paypal_payment_form').submit();
		})
	});
</script>
<?php }?>
<form id="paypal_payment_form" action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_dir_ssl']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/paypal/express_checkout/payment.php" data-ajax="false" title="<?php echo smartyTranslate(array('s'=>'Pay with PayPal','mod'=>'paypal'),$_smarty_tpl);?>
" method="post">
	<input type="hidden" name="express_checkout" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_payment_type']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
	<input type="hidden" name="current_shop_url" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_current_page']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" />
	<input type="hidden" name="bn" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_tracking_code']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" />
</form><?php }} ?>
