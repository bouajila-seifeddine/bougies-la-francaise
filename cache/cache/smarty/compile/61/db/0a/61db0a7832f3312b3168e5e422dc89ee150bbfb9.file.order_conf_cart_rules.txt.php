<?php /* Smarty version Smarty-3.1.19, created on 2016-10-25 09:56:40
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/mails/fr/order_conf_cart_rules.txt" */ ?>
<?php /*%%SmartyHeaderCode:41427236580f103821ea05-39091784%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61db0a7832f3312b3168e5e422dc89ee150bbfb9' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/mails/fr/order_conf_cart_rules.txt',
      1 => 1473094126,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41427236580f103821ea05-39091784',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'cart_rule' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_580f103822dc34_86705649',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_580f103822dc34_86705649')) {function content_580f103822dc34_86705649($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['cart_rule'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cart_rule']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cart_rule']->key => $_smarty_tpl->tpl_vars['cart_rule']->value) {
$_smarty_tpl->tpl_vars['cart_rule']->_loop = true;
?>
	<?php echo $_smarty_tpl->tpl_vars['cart_rule']->value['voucher_name'];?>
  <?php echo $_smarty_tpl->tpl_vars['cart_rule']->value['voucher_reduction'];?>

<?php } ?><?php }} ?>
