<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:45
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blockuserinfo/nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1216397366581a1299150a08-93057947%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '572df56d80374474d35eb773c3f7877844d9d7cc' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blockuserinfo/nav.tpl',
      1 => 1475245114,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1216397366581a1299150a08-93057947',
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
  'unifunc' => 'content_581a129916dde2_40285382',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a129916dde2_40285382')) {function content_581a129916dde2_40285382($_smarty_tpl) {?><!-- Block user information module NAV  -->
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
