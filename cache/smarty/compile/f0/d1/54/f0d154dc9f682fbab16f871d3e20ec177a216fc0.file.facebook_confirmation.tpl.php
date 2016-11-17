<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:55:09
         compiled from "/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/facebook_confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:246601370582d8c8e0109d5-47076016%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0d154dc9f682fbab16f871d3e20ec177a216fc0' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/facebook_confirmation.tpl',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '246601370582d8c8e0109d5-47076016',
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
  'unifunc' => 'content_582d8c8e01a953_08324649',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c8e01a953_08324649')) {function content_582d8c8e01a953_08324649($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
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
