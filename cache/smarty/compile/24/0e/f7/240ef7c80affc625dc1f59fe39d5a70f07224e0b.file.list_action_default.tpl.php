<?php /* Smarty version Smarty-3.1.19, created on 2016-10-25 13:48:34
         compiled from "/raid/www/blf/administrator/themes/default/template/helpers/list/list_action_default.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1652677036580f4692d4cd91-05160240%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '240ef7c80affc625dc1f59fe39d5a70f07224e0b' => 
    array (
      0 => '/raid/www/blf/administrator/themes/default/template/helpers/list/list_action_default.tpl',
      1 => 1466506471,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1652677036580f4692d4cd91-05160240',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'action' => 0,
    'name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_580f4692d7f0c9_25764462',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_580f4692d7f0c9_25764462')) {function content_580f4692d7f0c9_25764462($_smarty_tpl) {?>
<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo $_smarty_tpl->tpl_vars['action']->value;?>
"<?php if (isset($_smarty_tpl->tpl_vars['name']->value)) {?> name="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true);?>
"<?php }?> class="default">
	<i class="icon-asterisk"></i> <?php echo $_smarty_tpl->tpl_vars['action']->value;?>

</a><?php }} ?>
