<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:55:10
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockuserinfo/nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:30973429582d8c8e3b3f54-36005688%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '40533fa589c6b10181c582d0198488b9e3350c9d' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockuserinfo/nav.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30973429582d8c8e3b3f54-36005688',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_logged' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d8c8e3ce134_65948067',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c8e3ce134_65948067')) {function content_582d8c8e3ce134_65948067($_smarty_tpl) {?><!-- Block user information module NAV  -->
<div class="header_user_info bloc-top-nav">
	<?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
		<a class="logout" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('index',true,null,"mylogout"), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log me out','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
			<i class="icon-power-off"></i>
			
		</a>
	<?php } else { ?>
		<a class="login" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Log in to your customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
">
			
			<i class="ycon-compte"></i>
		</a>
	<?php }?>
</div>
<?php if ($_smarty_tpl->tpl_vars['is_logged']->value) {?>
	<div class="header_user_info bloc-top-nav">
		<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'View my customer account','mod'=>'blockuserinfo'),$_smarty_tpl);?>
" class="account" rel="nofollow">
			<span>
				
				<i class="ycon-compte"></i>
			</span>
		</a>
	</div>
<?php }?>

<!-- /Block usmodule NAV -->
<?php }} ?>
