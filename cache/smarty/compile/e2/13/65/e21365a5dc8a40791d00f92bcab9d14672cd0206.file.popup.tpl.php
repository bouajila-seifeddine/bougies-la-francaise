<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:38:38
         compiled from "/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:534832747582d88aea6e3a7-69610878%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e21365a5dc8a40791d00f92bcab9d14672cd0206' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/popup.tpl',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '534832747582d88aea6e3a7-69610878',
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
  'unifunc' => 'content_582d88aea7a7b3_71648488',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d88aea7a7b3_71648488')) {function content_582d88aea7a7b3_71648488($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='module-allinone_rewards-sponsorship') {?>
<script>
	var url_allinone_sponsorship="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
";
</script>
<div id="sponsorship_popup" class="<?php if ($_smarty_tpl->tpl_vars['scheduled']->value) {?>scheduled<?php }?>" style="display: none"></div>
<?php }?>
<!-- END : MODULE allinone_rewards --><?php }} ?>
