<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:45
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blocktopmenu/blocktopmenu-infos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:890370162581a1299149771-34360490%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a33f9b977d70934edc60350a02d293f54f0e0c8e' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blocktopmenu/blocktopmenu-infos.tpl',
      1 => 1475245118,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '890370162581a1299149771-34360490',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MENU' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a129914e3e6_82141931',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a129914e3e6_82141931')) {function content_581a129914e3e6_82141931($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['MENU']->value!='') {?>
	<!-- Menu -->
	<ul class="menu-infos">
		<?php echo $_smarty_tpl->tpl_vars['MENU']->value;?>

	</ul>
	<!--/ Menu -->
<?php }?><?php }} ?>
