<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:32:10
         compiled from "/home/bougies-la-francaise/public_html/administrator/themes/default/template/helpers/list/list_action_edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1273633340582d872a286a40-01467271%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb81d2c383eafac577b3fda9870a4839f18f8415' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/administrator/themes/default/template/helpers/list/list_action_edit.tpl',
      1 => 1478101064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1273633340582d872a286a40-01467271',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d872a2a56e5_99387344',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d872a2a56e5_99387344')) {function content_582d872a2a56e5_99387344($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="edit">
	<i class="icon-pencil"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
