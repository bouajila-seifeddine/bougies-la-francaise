<?php /* Smarty version Smarty-3.1.19, created on 2016-10-25 16:32:17
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/systempay/views/templates/front/redirect.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1650984973580f6cf1d571b9-29510216%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fcf4241457c6ff54e71c8f4bec0a3d3a2345817b' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/systempay/views/templates/front/redirect.tpl',
      1 => 1475244964,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1650984973580f6cf1d571b9-29510216',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'back_compat' => 0,
    'systempay_params' => 0,
    'systempay_empty_cart' => 0,
    'systempay_url' => 0,
    'key' => 0,
    'value' => 0,
    'base_dir' => 0,
    'systempay_logo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_580f6cf1d8a7b6_46799834',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_580f6cf1d8a7b6_46799834')) {function content_580f6cf1d8a7b6_46799834($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?>Systempay<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<?php if ($_smarty_tpl->tpl_vars['back_compat']->value) {?>
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['systempay_params']->value)&&$_smarty_tpl->tpl_vars['systempay_params']->value['vads_action_mode']=='SILENT') {?>
	<h2><?php echo smartyTranslate(array('s'=>'Payment processing','mod'=>'systempay'),$_smarty_tpl);?>
</h2>
<?php } else { ?>
	<h2><?php echo smartyTranslate(array('s'=>'Redirection to payment gateway','mod'=>'systempay'),$_smarty_tpl);?>
</h2>
<?php }?>

<?php $_smarty_tpl->tpl_vars['current_step'] = new Smarty_variable('payment', null, 0);?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./order-steps.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php if (isset($_smarty_tpl->tpl_vars['systempay_empty_cart']->value)&&$_smarty_tpl->tpl_vars['systempay_empty_cart']->value) {?>
	<p class="warning"><?php echo smartyTranslate(array('s'=>'Your shopping cart is empty.','mod'=>'systempay'),$_smarty_tpl);?>
</p>
<?php } else { ?>
	<h3><?php echo smartyTranslate(array('s'=>'Payment by bank card','mod'=>'systempay'),$_smarty_tpl);?>
</h3>
	
	<form action="<?php echo $_smarty_tpl->tpl_vars['systempay_url']->value;?>
" method="post" id="systempay_form" name="systempay_form"> 
	    <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['systempay_params']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
			<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" />
		<?php } ?>

		<p>
			<img src="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
modules/systempay/views/images/<?php echo $_smarty_tpl->tpl_vars['systempay_logo']->value;?>
" alt="Systempay" style="margin-bottom: 5px" />
			<br />
			
			<?php if ($_smarty_tpl->tpl_vars['systempay_params']->value['vads_action_mode']=='SILENT') {?>
				<?php echo smartyTranslate(array('s'=>'Please wait a moment. Your order payment is now processing.','mod'=>'systempay'),$_smarty_tpl);?>

			<?php } else { ?>
				<?php echo smartyTranslate(array('s'=>'Please wait, you will be redirected to the payment platform.','mod'=>'systempay'),$_smarty_tpl);?>

			<?php }?>
			
			<br /> <br />
			<?php echo smartyTranslate(array('s'=>'If nothing happens in 10 seconds, please click the button below.','mod'=>'systempay'),$_smarty_tpl);?>
 
			<br /><br />
		</p>
	
	<?php if ($_smarty_tpl->tpl_vars['back_compat']->value) {?>
		<p class="cart_navigation">
			<input type="submit" name="submitPayment" value="<?php echo smartyTranslate(array('s'=>'Pay','mod'=>'systempay'),$_smarty_tpl);?>
" class="exclusive" />
		</p>
	<?php } else { ?>
		<p class="cart_navigation clearfix">
			<button type="submit" name="submitPayment" class="button btn btn-default standard-checkout button-medium" >
				<span><?php echo smartyTranslate(array('s'=>'Pay','mod'=>'systempay'),$_smarty_tpl);?>
</span>
			</button>
		</p>
	<?php }?>
	</form>
	
	<script type="text/javascript">
		
			$(function() {
				setTimeout(function() {
					$('#systempay_form').submit();
				}, 1000);
			});
		
	</script>
<?php }?><?php }} ?>
