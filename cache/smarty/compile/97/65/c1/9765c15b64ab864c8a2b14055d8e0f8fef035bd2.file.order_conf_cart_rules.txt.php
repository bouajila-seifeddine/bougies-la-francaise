<?php /* Smarty version Smarty-3.1.19, created on 2016-11-16 21:30:44
         compiled from "/home/bougies-la-francaise/public_html/mails/fr/order_conf_cart_rules.txt" */ ?>
<?php /*%%SmartyHeaderCode:1759318082582cc1f4a82026-96609833%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9765c15b64ab864c8a2b14055d8e0f8fef035bd2' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/mails/fr/order_conf_cart_rules.txt',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1759318082582cc1f4a82026-96609833',
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
  'unifunc' => 'content_582cc1f4a92bd9_01216208',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582cc1f4a92bd9_01216208')) {function content_582cc1f4a92bd9_01216208($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['cart_rule'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cart_rule']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cart_rule']->key => $_smarty_tpl->tpl_vars['cart_rule']->value) {
$_smarty_tpl->tpl_vars['cart_rule']->_loop = true;
?>
	<?php echo $_smarty_tpl->tpl_vars['cart_rule']->value['voucher_name'];?>
  <?php echo $_smarty_tpl->tpl_vars['cart_rule']->value['voucher_reduction'];?>

<?php } ?><?php }} ?>
