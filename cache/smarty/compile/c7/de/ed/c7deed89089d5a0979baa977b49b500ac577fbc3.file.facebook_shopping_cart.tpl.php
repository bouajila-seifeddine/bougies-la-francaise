<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:19
         compiled from "/raid/www/blf/modules/allinone_rewards/views/templates/hook/facebook_shopping_cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9084143865819dc5bb1d248-01210801%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c7deed89089d5a0979baa977b49b500ac577fbc3' => 
    array (
      0 => '/raid/www/blf/modules/allinone_rewards/views/templates/hook/facebook_shopping_cart.tpl',
      1 => 1466504679,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9084143865819dc5bb1d248-01210801',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'facebook_cart_txt' => 0,
    'facebook_page' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dc5bb22336_17891887',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc5bb22336_17891887')) {function content_5819dc5bb22336_17891887($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<div id="facebook_shopping_cart">
	<?php echo $_smarty_tpl->tpl_vars['facebook_cart_txt']->value;?>

	<div class="reward_facebookcartbutton"><fb:like href="<?php echo $_smarty_tpl->tpl_vars['facebook_page']->value;?>
" show_faces="false" layout="button_count"></fb:like></div>
</div>
<!-- END : MODULE allinone_rewards --><?php }} ?>
