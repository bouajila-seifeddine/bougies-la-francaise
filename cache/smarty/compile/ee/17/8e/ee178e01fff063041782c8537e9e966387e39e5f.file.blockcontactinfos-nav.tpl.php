<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:55:10
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockcontactinfos/blockcontactinfos-nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1717826462582d8c8e425bd5-04502297%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '1717826462582d8c8e425bd5-04502297',
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
  'unifunc' => 'content_582d8c8e433547_70189757',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c8e433547_70189757')) {function content_582d8c8e433547_70189757($_smarty_tpl) {?>

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
