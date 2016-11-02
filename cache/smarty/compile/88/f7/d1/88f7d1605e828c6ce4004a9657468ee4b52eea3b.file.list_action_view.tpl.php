<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 12:54:26
         compiled from "/raid/www/blf/administrator/themes/default/template/helpers/list/list_action_view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5015195565819d3f2abe2e4-56705651%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '88f7d1605e828c6ce4004a9657468ee4b52eea3b' => 
    array (
      0 => '/raid/www/blf/administrator/themes/default/template/helpers/list/list_action_view.tpl',
      1 => 1466506471,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5015195565819d3f2abe2e4-56705651',
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
  'unifunc' => 'content_5819d3f2acbcc5_16963712',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819d3f2acbcc5_16963712')) {function content_5819d3f2acbcc5_16963712($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" >
	<i class="icon-search-plus"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
