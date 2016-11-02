<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:30
         compiled from "/raid/www/blf/modules/allinone_rewards/views/templates/hook/facebook_confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4779730275819dc66d1a6c6-39548877%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eae3fdb650c29f8c2fd33b4bd159f6e2d4247df1' => 
    array (
      0 => '/raid/www/blf/modules/allinone_rewards/views/templates/hook/facebook_confirmation.tpl',
      1 => 1466504679,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4779730275819dc66d1a6c6-39548877',
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
  'unifunc' => 'content_5819dc66d297d2_16222838',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc66d297d2_16222838')) {function content_5819dc66d297d2_16222838($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
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
