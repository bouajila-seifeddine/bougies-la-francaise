<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:31
         compiled from "/raid/www/blf/themes/bougie-la-francaise/modules/blockcontactinfos/blockcontactinfos-nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:745006855819dc67471e78-28486128%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19b67c283939d5f7e4a851d30f4da801f8b61c49' => 
    array (
      0 => '/raid/www/blf/themes/bougie-la-francaise/modules/blockcontactinfos/blockcontactinfos-nav.tpl',
      1 => 1467126959,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '745006855819dc67471e78-28486128',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blockcontactinfos_phone' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dc6747e448_14381079',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc6747e448_14381079')) {function content_5819dc6747e448_14381079($_smarty_tpl) {?>

<!-- MODULE Block contact infos -->
<?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value!='') {?>
<div id="block_contact_infos" class="bloc-contact-infos-nav bloc-top-nav">
	<i class="ycon-phone"></i> 
    <span><?php echo smartyTranslate(array('s'=>'Customer service','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>
</div>
<?php }?>
<!-- /MODULE Block contact infos -->
<?php }} ?>
