<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:05:31
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/popup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:243585076581a0ecb1621c7-94169040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27caea6ab518a231bf8c80a2427a86aa40092ff7' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/popup.tpl',
      1 => 1475244922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '243585076581a0ecb1621c7-94169040',
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
  'unifunc' => 'content_581a0ecb16e093_99374231',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a0ecb16e093_99374231')) {function content_581a0ecb16e093_99374231($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='module-allinone_rewards-sponsorship') {?>
<script>
	var url_allinone_sponsorship="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
";
</script>
<div id="sponsorship_popup" class="<?php if ($_smarty_tpl->tpl_vars['scheduled']->value) {?>scheduled<?php }?>" style="display: none"></div>
<?php }?>
<!-- END : MODULE allinone_rewards --><?php }} ?>
