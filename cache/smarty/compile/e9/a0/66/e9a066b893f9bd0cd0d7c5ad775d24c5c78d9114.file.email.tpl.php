<?php /* Smarty version Smarty-3.1.19, created on 2016-11-16 21:21:16
         compiled from "/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/front/email.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1051283464582cbfbcba6e09-62113560%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9a066b893f9bd0cd0d7c5ad775d24c5c78d9114' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/front/email.tpl',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1051283464582cbfbcba6e09-62113560',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sback' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582cbfbcbad085_83719598',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582cbfbcbad085_83719598')) {function content_582cbfbcbad085_83719598($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['sback']->value==1) {?>
<div style="font-size: 12px; font-family: Arial; padding-bottom: 10px; text-align: left"><a style="color: #000000" href="#" onClick="return parent.openPopup(true)">« <?php echo smartyTranslate(array('s'=>'Back','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a></div>
<?php }?>
<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
<?php }} ?>
