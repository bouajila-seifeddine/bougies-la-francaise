<?php /* Smarty version Smarty-3.1.19, created on 2016-10-25 09:56:42
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/pdf/invoice.shipping-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:790102923580f103a5556b0-07911741%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c487a3335dc43d49f4869061295633694e84fc76' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/pdf/invoice.shipping-tab.tpl',
      1 => 1473094114,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '790102923580f103a5556b0-07911741',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'carrier' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_580f103a55a102_28853179',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_580f103a55a102_28853179')) {function content_580f103a55a102_28853179($_smarty_tpl) {?>
<table id="shipping-tab" width="100%">
	<tr>
		<td class="shipping center small grey bold" width="44%"><?php echo smartyTranslate(array('s'=>'Carrier','pdf'=>'true'),$_smarty_tpl);?>
</td>
		<td class="shipping center small white" width="56%"><?php echo $_smarty_tpl->tpl_vars['carrier']->value->name;?>
</td>
	</tr>
</table>
<?php }} ?>
