<?php /* Smarty version Smarty-3.1.19, created on 2016-10-28 10:55:37
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/shopping-cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:219657009581312895e6273-01737087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ad75d1ad1767b0fbcec47702201e8a35e0cd865' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/shopping-cart.tpl',
      1 => 1475244921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '219657009581312895e6273-01737087',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'credits' => 0,
    'guest_checkout' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5813128960c6d6_99669322',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5813128960c6d6_99669322')) {function content_5813128960c6d6_99669322($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<p id="loyalty">
	<?php if ($_smarty_tpl->tpl_vars['credits']->value>0) {?>
		<?php echo smartyTranslate(array('s'=>'By checking out of this shopping cart you can collect up to','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <b><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>floatval($_smarty_tpl->tpl_vars['credits']->value)),$_smarty_tpl);?>
</b>
		<?php echo smartyTranslate(array('s'=>'that can be converted into a voucher','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php if (isset($_smarty_tpl->tpl_vars['guest_checkout']->value)&&$_smarty_tpl->tpl_vars['guest_checkout']->value) {?><sup>*</sup><?php }?>.<br />
		<?php if (isset($_smarty_tpl->tpl_vars['guest_checkout']->value)&&$_smarty_tpl->tpl_vars['guest_checkout']->value) {?><sup>*</sup> <?php echo smartyTranslate(array('s'=>'Not available for Instant checkout order','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php }?>
	<?php } else { ?>
		<?php echo smartyTranslate(array('s'=>'Add some products to your shopping cart to collect some loyalty credits.','mod'=>'allinone_rewards'),$_smarty_tpl);?>

	<?php }?>
</p>
<!-- END : MODULE allinone_rewards --><?php }} ?>
