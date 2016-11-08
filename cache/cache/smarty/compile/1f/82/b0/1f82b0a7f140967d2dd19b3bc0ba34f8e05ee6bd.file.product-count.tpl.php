<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 14:36:24
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/product-count.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14042266465819ebd840a302-35512507%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f82b0a7f140967d2dd19b3bc0ba34f8e05ee6bd' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/product-count.tpl',
      1 => 1475245096,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14042266465819ebd840a302-35512507',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'n' => 0,
    'p' => 0,
    'nb_products' => 0,
    'productShowingStart' => 0,
    'productShowing' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819ebd8441e85_00894503',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819ebd8441e85_00894503')) {function content_5819ebd8441e85_00894503($_smarty_tpl) {?><div class="product-count">
	<?php if (($_smarty_tpl->tpl_vars['n']->value*$_smarty_tpl->tpl_vars['p']->value)<$_smarty_tpl->tpl_vars['nb_products']->value) {?>
		<?php $_smarty_tpl->tpl_vars['productShowing'] = new Smarty_variable($_smarty_tpl->tpl_vars['n']->value*$_smarty_tpl->tpl_vars['p']->value, null, 0);?>
	<?php } else { ?>
		<?php $_smarty_tpl->tpl_vars['productShowing'] = new Smarty_variable(($_smarty_tpl->tpl_vars['n']->value*$_smarty_tpl->tpl_vars['p']->value-$_smarty_tpl->tpl_vars['nb_products']->value-$_smarty_tpl->tpl_vars['n']->value*$_smarty_tpl->tpl_vars['p']->value)*-1, null, 0);?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['p']->value==1) {?>
		<?php $_smarty_tpl->tpl_vars['productShowingStart'] = new Smarty_variable(1, null, 0);?>
	<?php } else { ?>
		<?php $_smarty_tpl->tpl_vars['productShowingStart'] = new Smarty_variable($_smarty_tpl->tpl_vars['n']->value*$_smarty_tpl->tpl_vars['p']->value-$_smarty_tpl->tpl_vars['n']->value+1, null, 0);?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['nb_products']->value>1) {?>
		<?php echo smartyTranslate(array('s'=>'Showing %1$d - %2$d of %3$d items','sprintf'=>array($_smarty_tpl->tpl_vars['productShowingStart']->value,$_smarty_tpl->tpl_vars['productShowing']->value,$_smarty_tpl->tpl_vars['nb_products']->value)),$_smarty_tpl);?>

	<?php } else { ?>
		<?php echo smartyTranslate(array('s'=>'Showing %1$d - %2$d of 1 item','sprintf'=>array($_smarty_tpl->tpl_vars['productShowingStart']->value,$_smarty_tpl->tpl_vars['productShowing']->value)),$_smarty_tpl);?>

	<?php }?>
</div><?php }} ?>
