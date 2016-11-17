<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:30:59
         compiled from "/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/facebook_shopping_cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1676070997582d86e3dae8b0-22721967%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f6b8100d975b06fa50d6e2a0acdc64d125629e0' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/facebook_shopping_cart.tpl',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1676070997582d86e3dae8b0-22721967',
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
  'unifunc' => 'content_582d86e3db2953_73349129',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d86e3db2953_73349129')) {function content_582d86e3db2953_73349129($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<div id="facebook_shopping_cart">
	<?php echo $_smarty_tpl->tpl_vars['facebook_cart_txt']->value;?>

	<div class="reward_facebookcartbutton"><fb:like href="<?php echo $_smarty_tpl->tpl_vars['facebook_page']->value;?>
" show_faces="false" layout="button_count"></fb:like></div>
</div>
<!-- END : MODULE allinone_rewards --><?php }} ?>
