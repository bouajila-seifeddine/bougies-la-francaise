<?php /* Smarty version Smarty-3.1.19, created on 2016-10-25 09:56:42
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/pdf/invoice.note-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:34691048580f103a505694-54375074%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd50a4976802eb1968537f5a4a3631d4433481587' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/pdf/invoice.note-tab.tpl',
      1 => 1473094113,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '34691048580f103a505694-54375074',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_invoice' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_580f103a50fef0_01654767',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_580f103a50fef0_01654767')) {function content_580f103a50fef0_01654767($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['order_invoice']->value->note)&&$_smarty_tpl->tpl_vars['order_invoice']->value->note) {?>
	<tr>
		<td colspan="12" height="10">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="6" class="left">
			<table id="note-tab" style="width: 100%">
				<tr>
					<td class="grey"><?php echo smartyTranslate(array('s'=>'Note','pdf'=>'true'),$_smarty_tpl);?>
</td>
				</tr>
				<tr>
					<td class="note"><?php echo nl2br($_smarty_tpl->tpl_vars['order_invoice']->value->note);?>
</td>
				</tr>
			</table>
		</td>
		<td colspan="1">&nbsp;</td>
	</tr>
<?php }?>
<?php }} ?>
