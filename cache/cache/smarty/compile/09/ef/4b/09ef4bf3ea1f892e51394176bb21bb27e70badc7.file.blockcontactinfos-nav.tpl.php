<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:45
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blockcontactinfos/blockcontactinfos-nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1107779445581a12991cd4f6-19161169%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09ef4bf3ea1f892e51394176bb21bb27e70badc7' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blockcontactinfos/blockcontactinfos-nav.tpl',
      1 => 1475245116,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1107779445581a12991cd4f6-19161169',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blockcontactinfos_phone' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a12991d6a92_04079983',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a12991d6a92_04079983')) {function content_581a12991d6a92_04079983($_smarty_tpl) {?>

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
