<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:37:15
         compiled from "/home/bougies-la-francaise/public_html/pdf/delivery-slip.tpl" */ ?>
<?php /*%%SmartyHeaderCode:962263192582d885b6446b1-76100529%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '870de0dc2c124e51740a796f309b98ae83b8a109' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/pdf/delivery-slip.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '962263192582d885b6446b1-76100529',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'style_tab' => 0,
    'addresses_tab' => 0,
    'summary_tab' => 0,
    'product_tab' => 0,
    'payment_tab' => 0,
    'HOOK_DISPLAY_PDF' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d885b650614_08096086',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d885b650614_08096086')) {function content_582d885b650614_08096086($_smarty_tpl) {?>

<?php echo $_smarty_tpl->tpl_vars['style_tab']->value;?>



<table width="100%" id="body" border="0" cellpadding="0" cellspacing="0" style="margin:0;">
	<!-- Addresses -->
	<tr>
		<td colspan="12">

		<?php echo $_smarty_tpl->tpl_vars['addresses_tab']->value;?>


		</td>
	</tr>

	<tr>
		<td colspan="12" height="30">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="12">

		<?php echo $_smarty_tpl->tpl_vars['summary_tab']->value;?>


		</td>
	</tr>

	<tr>
		<td colspan="12" height="20">&nbsp;</td>
	</tr>

	<!-- Products -->
	<tr>
		<td colspan="12">

		<?php echo $_smarty_tpl->tpl_vars['product_tab']->value;?>


		</td>
	</tr>

	<tr>
		<td colspan="12" height="20">&nbsp;</td>
	</tr>
	
	<tr>
		<td colspan="7" class="left">

			<?php echo $_smarty_tpl->tpl_vars['payment_tab']->value;?>


		</td>
		<td colspan="5">&nbsp;</td>
	</tr>

	<!-- Hook -->
	<?php if (isset($_smarty_tpl->tpl_vars['HOOK_DISPLAY_PDF']->value)) {?>
	<tr>
		<td colspan="12" height="30">&nbsp;</td>
	</tr>

	<tr>
		<td colspan="2">&nbsp;</td>
		<td colspan="10">
			<?php echo $_smarty_tpl->tpl_vars['HOOK_DISPLAY_PDF']->value;?>

		</td>
	</tr>
	<?php }?>

</table>
<?php }} ?>
