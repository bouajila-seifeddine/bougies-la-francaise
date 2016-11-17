<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:38:46
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockwishlist/my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:80380754582d88b6e1d1f5-99783967%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1026c20d22fd530c9e4db30b4f04b0a6fcb0f106' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockwishlist/my-account.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '80380754582d88b6e1d1f5-99783967',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d88b6e27762_89879896',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d88b6e27762_89879896')) {function content_582d88b6e27762_89879896($_smarty_tpl) {?>

<!-- MODULE WishList -->
<li class="lnk_wishlist col-md-4 col-sm-6">
	<a 	href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('blockwishlist','mywishlist',array(),true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
">
		<i class="icon-heart"></i>
		<span class="short"><?php echo smartyTranslate(array('s'=>'My wishlists','mod'=>'blockwishlist'),$_smarty_tpl);?>
</span>
	</a>
</li>
<!-- END : MODULE WishList --><?php }} ?>
