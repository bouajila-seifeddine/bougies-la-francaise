<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:16:47
         compiled from "/home/bougies-la-francaise/public_html/pdf/invoice.shipping-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1701863013582d838f0eb5e4-45542047%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a7dc3df7276625fc2108190a0118f8fa072c660f' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/pdf/invoice.shipping-tab.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1701863013582d838f0eb5e4-45542047',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'carrier' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d838f0f0460_05650608',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d838f0f0460_05650608')) {function content_582d838f0f0460_05650608($_smarty_tpl) {?>
<table id="shipping-tab" width="100%">
	<tr>
		<td class="shipping center small grey bold" width="44%"><?php echo smartyTranslate(array('s'=>'Carrier','pdf'=>'true'),$_smarty_tpl);?>
</td>
		<td class="shipping center small white" width="56%"><?php echo $_smarty_tpl->tpl_vars['carrier']->value->name;?>
</td>
	</tr>
</table>
<?php }} ?>
