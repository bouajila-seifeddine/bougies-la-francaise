<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:31
         compiled from "/raid/www/blf/themes/bougie-la-francaise/modules/blockuserinfo/nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11264529155819dc673c9498-29687035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6ce179e04687bff1e6aab727cad92aac1ffd09b' => 
    array (
      0 => '/raid/www/blf/themes/bougie-la-francaise/modules/blockuserinfo/nav.tpl',
      1 => 1470924722,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11264529155819dc673c9498-29687035',
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
  'unifunc' => 'content_5819dc673efb58_09710960',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc673efb58_09710960')) {function content_5819dc673efb58_09710960($_smarty_tpl) {?><!-- Block user information module NAV  -->
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
