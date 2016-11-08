<?php /* Smarty version Smarty-3.1.19, created on 2016-10-28 10:55:37
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/braintree/views/templates/hook/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:115885436958131289471cd3-69794025%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36dfb2d08780e38c90c460a4d7eff86c46bc3705' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/braintree/views/templates/hook/payment.tpl',
      1 => 1476960653,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115885436958131289471cd3-69794025',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5813128947b631_16423815',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5813128947b631_16423815')) {function content_5813128947b631_16423815($_smarty_tpl) {?>
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
