<?php /* Smarty version Smarty-3.1.19, created on 2016-10-26 15:28:28
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blockwishlist/my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10085071695810af7caa46b6-93512866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '419e21cdc318e15432a0bf6c4937b8fcc74b56f0' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blockwishlist/my-account.tpl',
      1 => 1475245117,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10085071695810af7caa46b6-93512866',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5810af7cab0205_70711626',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5810af7cab0205_70711626')) {function content_5810af7cab0205_70711626($_smarty_tpl) {?>

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
