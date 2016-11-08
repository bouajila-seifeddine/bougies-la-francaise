<?php /* Smarty version Smarty-3.1.19, created on 2016-10-27 11:12:39
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/administrator/themes/default/template/helpers/list/list_action_details.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20678764695811c5076ca0b9-46611898%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '223e068a5334111998833a3bf4d656de3d240d6e' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/administrator/themes/default/template/helpers/list/list_action_details.tpl',
      1 => 1473092479,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20678764695811c5076ca0b9-46611898',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'href' => 0,
    'params' => 0,
    'id' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5811c5076d9681_05887152',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5811c5076d9681_05887152')) {function content_5811c5076d9681_05887152($_smarty_tpl) {?>

<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['href']->value, ENT_QUOTES, 'UTF-8', true);?>
" id="details_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value['action'], ENT_QUOTES, 'UTF-8', true);?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>
" class="">
	<i class="icon-eye-open"></i> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['action']->value, ENT_QUOTES, 'UTF-8', true);?>

</a><?php }} ?>
