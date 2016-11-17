<?php /* Smarty version Smarty-3.1.19, created on 2016-11-16 16:52:27
         compiled from "/home/bougies-la-francaise/public_html/modules/paypal//views/templates/admin/admin_order/refund.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2038702667582c80bb7b7fa4-52980848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5125feea408288852e53fc9d6e74794c16214781' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/paypal//views/templates/admin/admin_order/refund.tpl',
      1 => 1478104349,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2038702667582c80bb7b7fa4-52980848',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_url' => 0,
    'module_name' => 0,
    'list_captures' => 0,
    'list' => 0,
    'params' => 0,
    'ps_version' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582c80bb81ae30_63923975',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582c80bb81ae30_63923975')) {function content_582c80bb81ae30_63923975($_smarty_tpl) {?>
<?php if (@constant('_PS_VERSION_')>=1.6) {?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-heading"><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/logo.gif" alt="" /> <?php echo smartyTranslate(array('s'=>'PayPal Refund','mod'=>'paypal'),$_smarty_tpl);?>
</div>
			<table class="table" width="100%" cellspacing="0" cellpadding="0">
			  <tr>
			    <th><?php echo smartyTranslate(array('s'=>'Capture date','mod'=>'paypal'),$_smarty_tpl);?>
</th>
			    <th><?php echo smartyTranslate(array('s'=>'Capture Amount','mod'=>'paypal'),$_smarty_tpl);?>
</th> 
			    <th><?php echo smartyTranslate(array('s'=>'Result Capture','mod'=>'paypal'),$_smarty_tpl);?>
</th>
			  </tr>
			<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_captures']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
?>
			  <tr>
			    <td><?php echo mb_convert_encoding(htmlspecialchars(Tools::displayDate($_smarty_tpl->tpl_vars['list']->value['date_add'],@constant('null'),true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
			    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['list']->value['capture_amount'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td> 
			    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['list']->value['result'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
			  </tr>
			<?php } ?>
			</table>
			<form method="post" action="<?php echo mb_convert_encoding(htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
				<input type="hidden" name="id_order" value="<?php echo intval($_smarty_tpl->tpl_vars['params']->value['id_order']);?>
" />
				<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'Payment accepted','mod'=>'paypal'),$_smarty_tpl);?>
</p>
				<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'When you refund a product, a partial refund is made unless you select "Generate a voucher".','mod'=>'paypal'),$_smarty_tpl);?>
</p>
				<p class="center">
					<button type="submit" class="btn btn-default" name="submitPayPalRefund" onclick="if (!confirm('<?php echo smartyTranslate(array('s'=>'Are you sure?','mod'=>'paypal'),$_smarty_tpl);?>
'))return false;">
						<i class="icon-undo"></i>
						<?php echo smartyTranslate(array('s'=>'Refund total transaction','mod'=>'paypal'),$_smarty_tpl);?>

					</button>
				</p>
			</form>
		</div>
	</div>
</div>
<?php } else { ?>
<br />
<fieldset <?php if (isset($_smarty_tpl->tpl_vars['ps_version']->value)&&($_smarty_tpl->tpl_vars['ps_version']->value<'1.5')) {?>style="width: 400px"<?php }?>>
	<legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['base_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
modules/<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['module_name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'PayPal Refund','mod'=>'paypal'),$_smarty_tpl);?>
</legend>
	<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'Payment accepted','mod'=>'paypal'),$_smarty_tpl);?>
</p>
	<p><b><?php echo smartyTranslate(array('s'=>'Information:','mod'=>'paypal'),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'When you refund a product, a partial refund is made unless you select "Generate a voucher".','mod'=>'paypal'),$_smarty_tpl);?>
</p>
	<table class="table" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
		    <th><?php echo smartyTranslate(array('s'=>'Capture date','mod'=>'paypal'),$_smarty_tpl);?>
</th>
		    <th><?php echo smartyTranslate(array('s'=>'Capture Amount','mod'=>'paypal'),$_smarty_tpl);?>
</th> 
		    <th><?php echo smartyTranslate(array('s'=>'Result Capture','mod'=>'paypal'),$_smarty_tpl);?>
</th>
		  </tr>
		<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list_captures']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
?>
		  <tr>
		    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['list']->value['date'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
		    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['list']->value['capture_amount'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
		    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['list']->value['result'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
		  </tr>
		<?php } ?>
		</table>
	<form method="post" action="<?php echo mb_convert_encoding(htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
		<input type="hidden" name="id_order" value="<?php echo intval($_smarty_tpl->tpl_vars['params']->value['id_order']);?>
" />
		<p class="center">
			<input type="submit" class="button" name="submitPayPalRefund" value="<?php echo smartyTranslate(array('s'=>'Refund total transaction','mod'=>'paypal'),$_smarty_tpl);?>
" onclick="if (!confirm('<?php echo smartyTranslate(array('s'=>'Are you sure?','mod'=>'paypal'),$_smarty_tpl);?>
'))return false;" />
		</p>
	</form>
</fieldset>

<?php }?>
<?php }} ?>
