<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:37:15
         compiled from "/home/bougies-la-francaise/public_html/pdf/delivery-slip.summary-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1708847962582d885b5c38b3-78571632%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '689ed67fe361bfe2f63f6b47c31a8d31841758ad' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/pdf/delivery-slip.summary-tab.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1708847962582d885b5c38b3-78571632',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'carrier' => 0,
    'order' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d885b5d6200_54785865',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d885b5d6200_54785865')) {function content_582d885b5d6200_54785865($_smarty_tpl) {?>
<table id="summary-tab" width="100%">
	<tr>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Order Reference','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Order Date','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<?php if (isset($_smarty_tpl->tpl_vars['carrier']->value)) {?>
			<th class="header small" valign="middle"><?php echo smartyTranslate(array('s'=>'Carrier','pdf'=>'true'),$_smarty_tpl);?>
</th>
		<?php }?>
	</tr>
	<tr>
		<td class="center small white"><?php echo $_smarty_tpl->tpl_vars['order']->value->getUniqReference();?>
</td>
		<td class="center small white"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['order']->value->date_add,'full'=>0),$_smarty_tpl);?>
</td>
		<?php if (isset($_smarty_tpl->tpl_vars['carrier']->value)) {?>
			<td class="center small white"><?php echo $_smarty_tpl->tpl_vars['carrier']->value->name;?>
</td>
		<?php }?>
	</tr>
</table>

<?php }} ?>
