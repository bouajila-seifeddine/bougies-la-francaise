<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:55:10
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blocktopmenu/blocktopmenu-infos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:833452820582d8c8e3ad007-40564185%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '65455aab5ffe07a72dad361254eb5f6c68f2304d' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blocktopmenu/blocktopmenu-infos.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '833452820582d8c8e3ad007-40564185',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MENU' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d8c8e3b1875_32225357',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c8e3b1875_32225357')) {function content_582d8c8e3b1875_32225357($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['MENU']->value!='') {?>
	<!-- Menu -->
	<ul class="menu-infos">
		<?php echo $_smarty_tpl->tpl_vars['MENU']->value;?>

	</ul>
	<!--/ Menu -->
<?php }?><?php }} ?>
