<?php /* Smarty version Smarty-3.1.19, created on 2016-10-20 12:38:52
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/braintree/views/templates/hook/payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:115630917258089ebcc80076-59215093%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6617d7a0437005324f043ff0da4994b3679d1a53' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/braintree/views/templates/hook/payment.tpl',
      1 => 1475482552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115630917258089ebcc80076-59215093',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58089ebcc92d47_31152696',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58089ebcc92d47_31152696')) {function content_58089ebcc92d47_31152696($_smarty_tpl) {?>

<p class="payment_module braintree_payment">
	<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('braintree','payment'), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo smartyTranslate(array('s'=>'Pay by braintree wire','mod'=>'braintree'),$_smarty_tpl);?>
" class="bankwire">
		<?php echo smartyTranslate(array('s'=>'Pay By Braintree','mod'=>'braintree'),$_smarty_tpl);?>
&nbsp;<span></span>
	</a>
</p><?php }} ?>
