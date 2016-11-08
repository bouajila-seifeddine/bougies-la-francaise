<?php /* Smarty version Smarty-3.1.19, created on 2016-10-28 10:55:37
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/facebook_shopping_cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11697178258131289612318-40350764%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e92783f9a7167a10a0a1536c24c066149b2cc334' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/facebook_shopping_cart.tpl',
      1 => 1475244922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11697178258131289612318-40350764',
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
  'unifunc' => 'content_581312896181d8_39090156',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581312896181d8_39090156')) {function content_581312896181d8_39090156($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<div id="facebook_shopping_cart">
	<?php echo $_smarty_tpl->tpl_vars['facebook_cart_txt']->value;?>

	<div class="reward_facebookcartbutton"><fb:like href="<?php echo $_smarty_tpl->tpl_vars['facebook_page']->value;?>
" show_faces="false" layout="button_count"></fb:like></div>
</div>
<!-- END : MODULE allinone_rewards --><?php }} ?>
