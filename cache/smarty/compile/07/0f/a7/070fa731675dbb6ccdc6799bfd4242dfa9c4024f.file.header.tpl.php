<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:55:19
         compiled from "/home/bougies-la-francaise/public_html/modules/gtrustedstores/views/templates/hook/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1981697323582d8c97080744-15382369%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '070fa731675dbb6ccdc6799bfd4242dfa9c4024f' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/gtrustedstores/views/templates/hook/header.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1981697323582d8c97080744-15382369',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gts_id' => 0,
    'gts_customize_css' => 0,
    'gts_language' => 0,
    'gts_gmc_id' => 0,
    'gts_country' => 0,
    'gts_product_id' => 0,
    'gts_custom_css' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d8c970a3f75_81317790',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c970a3f75_81317790')) {function content_582d8c970a3f75_81317790($_smarty_tpl) {?>

<!-- START: Google Trusted Stores module: Badge -->
	<script type="text/javascript">
		var gts = gts || [];

		gts.push(["id", "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"]);
		<?php if ($_smarty_tpl->tpl_vars['gts_customize_css']->value==true) {?>
			gts.push(["badge_position", "USER_DEFINED"]);
			gts.push(["badge_container", "GTS_CONTAINER"]);
		<?php } else { ?>
			gts.push(["badge_position", "BOTTOM_RIGHT"]);
		<?php }?>
		gts.push(["locale", "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_language']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"]);
		gts.push(["google_base_subaccount_id", "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_gmc_id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"]);
		gts.push(["google_base_country", "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_country']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"]);
		gts.push(["google_base_language", "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_language']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"]);
		<?php if (mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_product_id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8')) {?>gts.push(["google_base_offer_id", "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_product_id']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"]);<?php }?>

		
		(function() {
	    var gts = document.createElement("script");
	    gts.type = "text/javascript";
	    gts.async = true;
	    gts.src = "https://www.googlecommerce.com/trustedstores/api/js";
	    var s = document.getElementsByTagName("script")[0];
	    s.parentNode.insertBefore(gts, s);
	    })();
		
	</script>

	<?php if ($_smarty_tpl->tpl_vars['gts_customize_css']->value==true) {?>
		<style>
			<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['gts_custom_css']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

		</style>
	<?php }?>
<!-- END: Google Trusted Stores module: Badge -->
<?php }} ?>
