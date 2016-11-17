<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:49:28
         compiled from "/home/bougies-la-francaise/public_html/modules/lengow/views/templates/admin/order/info_16.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1127782170582d8b38bd24a5-68777055%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3cf5adc7b368558bfd4227d3740bc6fcf8a72b87' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/lengow/views/templates/admin/order/info_16.tpl',
      1 => 1478172775,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1127782170582d8b38bd24a5-68777055',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id_order_lengow' => 0,
    'marketplace' => 0,
    'id_flux' => 0,
    'total_paid' => 0,
    'tracking_carrier' => 0,
    'tracking_method' => 0,
    'tracking' => 0,
    'message' => 0,
    'sent_markeplace' => 0,
    'action_reimport' => 0,
    'action_synchronize' => 0,
    'add_script' => 0,
    'url_script' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d8b38c2f709_11872037',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8b38c2f709_11872037')) {function content_582d8b38c2f709_11872037($_smarty_tpl) {?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-heading">
				<i class="icon-shopping-cart"></i>
				<?php echo smartyTranslate(array('s'=>'This order has been imported from Lengow','mod'=>'lengow'),$_smarty_tpl);?>

			</div>
			<div class="well">
				<ul>
					<li><?php echo smartyTranslate(array('s'=>'Lengow order ID','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_order_lengow']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></li>
					<li><?php echo smartyTranslate(array('s'=>'Marketplace','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['marketplace']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></li>
					<?php if ($_smarty_tpl->tpl_vars['id_flux']->value!=0) {?>
						<li><?php echo smartyTranslate(array('s'=>'Feed ID','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_flux']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></li>
					<?php }?>
					<li><?php echo smartyTranslate(array('s'=>'Total amount paid on Marketplace','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['total_paid']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></li>
					<li><?php echo smartyTranslate(array('s'=>'Carrier from marketplace','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tracking_carrier']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></li>
					<li><?php echo smartyTranslate(array('s'=>'Shipping method','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tracking_method']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></li>
					<li><?php echo smartyTranslate(array('s'=>'Tracking number','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tracking']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></li>
					<li><?php echo smartyTranslate(array('s'=>'Message','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['message']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong></li>
					<li><?php echo smartyTranslate(array('s'=>'Shipping by marketplace','mod'=>'lengow'),$_smarty_tpl);?>
 : <strong><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['sent_markeplace']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</strong>
				</ul>
			</div>
			<div class="btn-group">
				<a class="btn btn-default" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['action_reimport']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo smartyTranslate(array('s'=>'Cancel and re-import order','mod'=>'lengow'),$_smarty_tpl);?>
</a>
				<a class="btn btn-default" href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['action_synchronize']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo smartyTranslate(array('s'=>'Synchronize ID','mod'=>'lengow'),$_smarty_tpl);?>
</a>
			</div>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['add_script']->value==true) {?>
		<script type="text/javascript" src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['url_script']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"></script>
		<?php }?>
	</div>
</div><?php }} ?>
