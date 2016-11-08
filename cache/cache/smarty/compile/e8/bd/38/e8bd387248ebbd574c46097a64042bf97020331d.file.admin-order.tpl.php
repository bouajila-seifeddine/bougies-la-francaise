<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 10:49:49
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/braintree/views/templates/admin/admin-order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17543930425819b6bddc05a9-70399754%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8bd387248ebbd574c46097a64042bf97020331d' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/braintree/views/templates/admin/admin-order.tpl',
      1 => 1475482552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17543930425819b6bddc05a9-70399754',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'total_paid' => 0,
    'id_transaction' => 0,
    'status' => 0,
    'id_braintree_transaction' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819b6bddea9a0_36071678',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819b6bddea9a0_36071678')) {function content_5819b6bddea9a0_36071678($_smarty_tpl) {?>
<div style="background-color: #fff; border: 1px solid #e6e6e6; border-radius: 5px; box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1), 0 0 0 3px #fff inset; margin-bottom: 20px; padding: 20px;">
	<form method="post" action="">
		<h3><i class="icon-credit-card"></i> <?php echo smartyTranslate(array('s'=>'Process BrainTree Refund','mod'=>"braintree"),$_smarty_tpl);?>
</h3>
		<input type="text" class="form-control" name="amount" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['total_paid']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
		<input type="hidden" class="form-control" name="id_transaction" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_transaction']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
		<input type="hidden" class="form-control" name="status" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['status']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
		<input type="hidden" class="form-control" name="id_braintree_transaction" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_braintree_transaction']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
		<input type="submit" name="braintree_refund" value="<?php echo smartyTranslate(array('s'=>'Process Refund','mod'=>'braintree'),$_smarty_tpl);?>
" class="btn btn-primary">
	</form>
</div><?php }} ?>
