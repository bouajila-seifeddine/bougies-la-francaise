<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:37:15
         compiled from "/home/bougies-la-francaise/public_html/pdf/delivery-slip.addresses-tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:448780800582d885b5ad0a4-59325989%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ec217ac1f79fe29d1ccb513c63da991ab3fe7cd' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/pdf/delivery-slip.addresses-tab.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '448780800582d885b5ad0a4-59325989',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_invoice' => 0,
    'invoice_address' => 0,
    'delivery_address' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d885b5c1439_07993027',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d885b5c1439_07993027')) {function content_582d885b5c1439_07993027($_smarty_tpl) {?>
<table id="addresses-tab" cellspacing="0" cellpadding="0">
	<tr>
		<td width="33%"><span class="bold"> </span><br/><br/>
			<?php echo $_smarty_tpl->tpl_vars['order_invoice']->value->shop_address;?>

		</td>
		<?php if (!empty($_smarty_tpl->tpl_vars['invoice_address']->value)) {?>
			<td width="33%"><?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?><span class="bold"><?php echo smartyTranslate(array('s'=>'Delivery Address','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
					<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

				<?php }?>
			</td>
			<td width="33%"><span class="bold"><?php echo smartyTranslate(array('s'=>'Billing Address','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
				<?php echo $_smarty_tpl->tpl_vars['invoice_address']->value;?>

			</td>
		<?php } else { ?>
			<td width="66%"><?php if ($_smarty_tpl->tpl_vars['delivery_address']->value) {?><span class="bold"><?php echo smartyTranslate(array('s'=>'Billing & Delivery Address','pdf'=>'true'),$_smarty_tpl);?>
</span><br/><br/>
					<?php echo $_smarty_tpl->tpl_vars['delivery_address']->value;?>

				<?php }?>
			</td>
		<?php }?>
	</tr>
</table>
<?php }} ?>
