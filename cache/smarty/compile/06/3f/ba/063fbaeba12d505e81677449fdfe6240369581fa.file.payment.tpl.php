<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 10:57:25
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/braintree/views/templates/hook/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:336855103582d7f05cc8b63-90076998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '063fbaeba12d505e81677449fdfe6240369581fa' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/braintree/views/templates/hook/payment.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '336855103582d7f05cc8b63-90076998',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d7f05cd1bc7_19232565',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d7f05cd1bc7_19232565')) {function content_582d7f05cd1bc7_19232565($_smarty_tpl) {?>
<div class="col-sm-6 col-xs-12">
	<div class="payment_module braintree_payment">
		<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('braintree','payment'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo smartyTranslate(array('s'=>'Pay by braintree wire','mod'=>'braintree'),$_smarty_tpl);?>
" class="bankwire">
			<span>
				<i class="ycon-credit-card"></i>
				
				<?php echo smartyTranslate(array('s'=>'Pay by credit card','mod'=>'braintree'),$_smarty_tpl);?>

			</span>
		</a>
	</div>
</div><?php }} ?>
