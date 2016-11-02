<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:31
         compiled from "/raid/www/blf/themes/bougie-la-francaise/modules/blocktopmenu/blocktopmenu-infos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3655404795819dc673bdf08-86754936%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '342cfb490e9bb884eafda242a82768034e7c10ce' => 
    array (
      0 => '/raid/www/blf/themes/bougie-la-francaise/modules/blocktopmenu/blocktopmenu-infos.tpl',
      1 => 1469008536,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3655404795819dc673bdf08-86754936',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MENU' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dc673c4a91_45957968',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc673c4a91_45957968')) {function content_5819dc673c4a91_45957968($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['MENU']->value!='') {?>
	<!-- Menu -->
	<ul class="menu-infos">
		<?php echo $_smarty_tpl->tpl_vars['MENU']->value;?>

	</ul>
	<!--/ Menu -->
<?php }?><?php }} ?>
