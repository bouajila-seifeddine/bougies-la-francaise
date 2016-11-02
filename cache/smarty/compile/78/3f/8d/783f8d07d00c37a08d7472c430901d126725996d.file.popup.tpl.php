<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:29:37
         compiled from "/raid/www/blf/modules/allinone_rewards/views/templates/hook/popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16758323995819dc311b4d38-92566654%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '783f8d07d00c37a08d7472c430901d126725996d' => 
    array (
      0 => '/raid/www/blf/modules/allinone_rewards/views/templates/hook/popup.tpl',
      1 => 1466504679,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16758323995819dc311b4d38-92566654',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_name' => 0,
    'link' => 0,
    'scheduled' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dc311f7035_20161231',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc311f7035_20161231')) {function content_5819dc311f7035_20161231($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='module-allinone_rewards-sponsorship') {?>
<script>
	var url_allinone_sponsorship="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
";
</script>
<div id="sponsorship_popup" class="<?php if ($_smarty_tpl->tpl_vars['scheduled']->value) {?>scheduled<?php }?>" style="display: none"></div>
<?php }?>
<!-- END : MODULE allinone_rewards --><?php }} ?>
