<?php /* Smarty version Smarty-3.1.19, created on 2016-11-08 12:40:55
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockcontactinfos/blockcontactinfos-nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19894309395821b9c7e87089-04646560%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee178e01fff063041782c8537e9e966387e39e5f' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockcontactinfos/blockcontactinfos-nav.tpl',
      1 => 1478278551,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19894309395821b9c7e87089-04646560',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blockcontactinfos_phone' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5821b9c7e945b7_45692861',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5821b9c7e945b7_45692861')) {function content_5821b9c7e945b7_45692861($_smarty_tpl) {?>

<!-- MODULE Block contact infos -->
<?php if ($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value!='') {?>
<div class="bloc-top-nav">
	<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('stores'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Our stores'),$_smarty_tpl);?>
"><i class="ycon-boutiques"></i></a>
</div>
<div id="block_contact_infos" class="bloc-contact-infos-nav bloc-top-nav">
	<i class="ycon-phone"></i> 
    <span><?php echo smartyTranslate(array('s'=>'Customer service','mod'=>'blockcontactinfos'),$_smarty_tpl);?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blockcontactinfos_phone']->value, ENT_QUOTES, 'UTF-8', true);?>
</span>
</div>
<?php }?>
<!-- /MODULE Block contact infos -->
<?php }} ?>
