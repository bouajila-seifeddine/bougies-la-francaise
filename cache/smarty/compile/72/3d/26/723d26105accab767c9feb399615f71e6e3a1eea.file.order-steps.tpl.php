<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:31:10
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/order-steps.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2057487241582d86eea68045-76284768%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '723d26105accab767c9feb399615f71e6e3a1eea' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/order-steps.tpl',
      1 => 1478532983,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2057487241582d86eea68045-76284768',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'back' => 0,
    'multi_shipping' => 0,
    'opc' => 0,
    'current_step' => 0,
    'link' => 0,
    'ARRAY_STEP' => 0,
    'k' => 0,
    'step' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d86eeb3a2c7_77427432',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d86eeb3a2c7_77427432')) {function content_582d86eeb3a2c7_77427432($_smarty_tpl) {?>


<?php $_smarty_tpl->_capture_stack[0][] = array("url_back", null, null); ob_start(); ?>
<?php if (isset($_smarty_tpl->tpl_vars['back']->value)&&$_smarty_tpl->tpl_vars['back']->value) {?>back=<?php echo $_smarty_tpl->tpl_vars['back']->value;?>
<?php }?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php if (!isset($_smarty_tpl->tpl_vars['multi_shipping']->value)) {?>
	<?php $_smarty_tpl->tpl_vars['multi_shipping'] = new Smarty_variable('0', null, 0);?>
<?php }?>

<?php if (!$_smarty_tpl->tpl_vars['opc']->value&&((!isset($_smarty_tpl->tpl_vars['back']->value)||empty($_smarty_tpl->tpl_vars['back']->value))||(isset($_smarty_tpl->tpl_vars['back']->value)&&preg_match("/[&?]step=/",$_smarty_tpl->tpl_vars['back']->value)))) {?>
<!-- Steps -->
<ul class="step clearfix" id="order_step">
	<li class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='summary') {?>step_current <?php } elseif ($_smarty_tpl->tpl_vars['current_step']->value=='login') {?>step_done_last step_done<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'||$_smarty_tpl->tpl_vars['current_step']->value=='address'||$_smarty_tpl->tpl_vars['current_step']->value=='login') {?>step_done<?php } else { ?>step_todo<?php }?><?php }?> first">
		<div>
			<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'||$_smarty_tpl->tpl_vars['current_step']->value=='address'||$_smarty_tpl->tpl_vars['current_step']->value=='login') {?>
			<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true);?>
">
				<em>01.</em> <?php echo smartyTranslate(array('s'=>'Summary'),$_smarty_tpl);?>

			</a>
			<?php } else { ?>
				<span><em>01.</em> <?php echo smartyTranslate(array('s'=>'Summary'),$_smarty_tpl);?>
</span>
			<?php }?>
		</div>
	</li>
	<li class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='login') {?>step_current<?php } elseif ($_smarty_tpl->tpl_vars['current_step']->value=='address') {?>step_done step_done_last<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'||$_smarty_tpl->tpl_vars['current_step']->value=='address') {?>step_done<?php } else { ?>step_todo<?php }?><?php }?> second">
		<div>
			<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping'||$_smarty_tpl->tpl_vars['current_step']->value=='address') {?>
			<a href="<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['multi_shipping']->value) {?><?php echo "&multi-shipping=";?><?php echo (string)$_smarty_tpl->tpl_vars['multi_shipping']->value;?><?php }?><?php $_tmp3=ob_get_clean();?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true,null,((string)Smarty::$_smarty_vars['capture']['url_back'])."&step=1".$_tmp3), ENT_QUOTES, 'UTF-8', true);?>
">
				<em>02.</em> <?php echo smartyTranslate(array('s'=>'Sign in'),$_smarty_tpl);?>

			</a>
			<?php } else { ?>
				<span><em>02.</em> <?php echo smartyTranslate(array('s'=>'Sign in'),$_smarty_tpl);?>
</span>
			<?php }?>
		</div>
	</li>
	<li class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='address') {?>step_current<?php } elseif ($_smarty_tpl->tpl_vars['current_step']->value=='shipping') {?>step_done step_done_last<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping') {?>step_done<?php } else { ?>step_todo<?php }?><?php }?> third">
		<div>
			<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment'||$_smarty_tpl->tpl_vars['current_step']->value=='shipping') {?>
			<a href="<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['multi_shipping']->value) {?><?php echo "&multi-shipping=";?><?php echo (string)$_smarty_tpl->tpl_vars['multi_shipping']->value;?><?php }?><?php $_tmp4=ob_get_clean();?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true,null,((string)Smarty::$_smarty_vars['capture']['url_back'])."&step=1".$_tmp4), ENT_QUOTES, 'UTF-8', true);?>
">
				<em>03.</em> <?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>

			</a>
			<?php } else { ?>
				<span><em>03.</em> <?php echo smartyTranslate(array('s'=>'Address'),$_smarty_tpl);?>
</span>
			<?php }?>
		</div>
	</li>
	<li class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='shipping') {?>step_current<?php } else { ?><?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment') {?>step_done step_done_last<?php } else { ?>step_todo<?php }?><?php }?> four">
		<div>
			<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment') {?>
			<a href="<?php ob_start();?><?php if ($_smarty_tpl->tpl_vars['multi_shipping']->value) {?><?php echo "&multi-shipping=";?><?php echo (string)$_smarty_tpl->tpl_vars['multi_shipping']->value;?><?php }?><?php $_tmp5=ob_get_clean();?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order',true,null,((string)Smarty::$_smarty_vars['capture']['url_back'])."&step=2".$_tmp5), ENT_QUOTES, 'UTF-8', true);?>
">
				<span><em>04.</em> <?php echo smartyTranslate(array('s'=>'Shipping'),$_smarty_tpl);?>
</span>
			</a>
			<?php } else { ?>
				<span><em>04.</em> <?php echo smartyTranslate(array('s'=>'Shipping'),$_smarty_tpl);?>
</span>
			<?php }?>
		</div>
	</li>
	<li id="step_end" class="<?php if ($_smarty_tpl->tpl_vars['current_step']->value=='payment') {?>step_current<?php } else { ?>step_todo<?php }?> last">
		<div>
			<span><em>05.</em> <?php echo smartyTranslate(array('s'=>'Payment'),$_smarty_tpl);?>
</span>
		</div>
	</li>
</ul>
<!-- /Steps -->
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['ARRAY_STEP']->value)&&!empty($_smarty_tpl->tpl_vars['ARRAY_STEP']->value)) {?>
<?php  $_smarty_tpl->tpl_vars['step'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['step']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ARRAY_STEP']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['step']->key => $_smarty_tpl->tpl_vars['step']->value) {
$_smarty_tpl->tpl_vars['step']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['step']->key;
?>
	<?php if ($_smarty_tpl->tpl_vars['k']->value==$_smarty_tpl->tpl_vars['current_step']->value) {?>
		<script type="text/javascript">
			var step = <?php echo $_smarty_tpl->tpl_vars['step']->value;?>
;
		</script>
	<?php }?>
<?php } ?>
<?php }?>

<?php }} ?>
