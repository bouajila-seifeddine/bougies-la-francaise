<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:44
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/facebook_confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1304035936581a1298cfe969-72737744%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '410192c5a4ee42db0e8c94be8168c79f5185b3cc' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/facebook_confirmation.tpl',
      1 => 1475244921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1304035936581a1298cfe969-72737744',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'facebook_confirm_txt' => 0,
    'facebook_code' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a1298d097a7_24542784',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a1298d097a7_24542784')) {function content_581a1298d097a7_24542784($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<script type="text/javascript">
//<![CDATA[
	var url_allinone_facebook="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','facebook',array(),true);?>
";
//]]>
</script>
<div id="rewards_facebookconfirm">
	<?php echo $_smarty_tpl->tpl_vars['facebook_confirm_txt']->value;?>

	<?php if ($_smarty_tpl->tpl_vars['facebook_code']->value) {?>
	<center><?php echo smartyTranslate(array('s'=>'Code :','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <span id="rewards_facebookcode"></span></center>
	<?php }?>
</div>
<!-- END : MODULE allinone_rewards --><?php }} ?>
