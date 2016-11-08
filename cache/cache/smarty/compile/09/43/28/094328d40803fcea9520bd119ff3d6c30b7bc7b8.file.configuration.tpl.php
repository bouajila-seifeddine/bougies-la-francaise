<?php /* Smarty version Smarty-3.1.19, created on 2016-10-31 13:49:02
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/ganalytics/views/templates/admin/configuration.tpl" */ ?>
<?php /*%%SmartyHeaderCode:165593599658173dbe1bb0d0-82985254%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '094328d40803fcea9520bd119ff3d6c30b7bc7b8' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/ganalytics/views/templates/admin/configuration.tpl',
      1 => 1475244938,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165593599658173dbe1bb0d0-82985254',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58173dbe1e87b2_26730009',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58173dbe1e87b2_26730009')) {function content_58173dbe1e87b2_26730009($_smarty_tpl) {?>

<div class="panel">
	<div class="row" id="google_analytics_top">
		<div class="col-lg-6">
			<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/ga_logo.png" alt="Google Analytics" />
		</div>
		<div class="col-lg-6 text-right">
			<a href="https://support.google.com/analytics/answer/1008015" rel="external"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/create_account_btn.png" alt="" /></a>
		</div>
	</div>
	<hr/>
	<div id="google_analytics_content">
		<div class="row">
			<div class="col-lg-6">
				<p>
					<?php echo smartyTranslate(array('s'=>'Your customers go everywhere; shouldn\'t your analytics.','mod'=>'ganalytics'),$_smarty_tpl);?>

				</p><p>
					<?php echo smartyTranslate(array('s'=>'Google Analytics shows you the full customer picture across ads and videos, websites and social tools, tables and smartphones. That makes it easier to serve your current customers and win new ones.','mod'=>'ganalytics'),$_smarty_tpl);?>

				</p>
				<p><b><?php echo smartyTranslate(array('s'=>'With ecommerce functionality in Google Analytics you can gain clear insight into important metrics about shopper behavior and conversion, including:','mod'=>'ganalytics'),$_smarty_tpl);?>
</b></p>
				<div id="advantages_list">
					<div class="col-xs-6"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/product_detail_icon.png" alt="" /><?php echo smartyTranslate(array('s'=>'Product detail views','mod'=>'ganalytics'),$_smarty_tpl);?>
</div>
					<div class="col-xs-6"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/merchandising_tools_icon.png" alt="" /><?php echo smartyTranslate(array('s'=>'Internal merchandising Success','mod'=>'ganalytics'),$_smarty_tpl);?>
</div>
					<div class="col-xs-6"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/add_to_cart_icon.png" alt="" /><?php echo smartyTranslate(array('s'=>'"Add to cart" actions','mod'=>'ganalytics'),$_smarty_tpl);?>
</div>
					<div class="col-xs-6"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/checkout_icon.png" alt="" /><?php echo smartyTranslate(array('s'=>'The checkout process','mod'=>'ganalytics'),$_smarty_tpl);?>
</div>
					<div class="col-xs-6"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/campaign_clicks_icon.png" alt="" /><?php echo smartyTranslate(array('s'=>'Internal campaign clicks','mod'=>'ganalytics'),$_smarty_tpl);?>
</div>
					<div class="col-xs-6"><img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/purchase_icon.png" alt="" /><?php echo smartyTranslate(array('s'=>'And purchase','mod'=>'ganalytics'),$_smarty_tpl);?>
</div>
				</div>
			</div>
			<div class="col-lg-6 text-center">
				<p>
					<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_dir']->value, ENT_QUOTES, 'UTF-8', true);?>
views/img/stats.png" alt="" /><br />
					<span class="small"><em><?php echo smartyTranslate(array('s'=>'Merchants are able to understand how far along users get in the buying process and where they are dropping off.','mod'=>'ganalytics'),$_smarty_tpl);?>
</em></span>
				</p>
				<p class="text-right">
					<b><a href="https://support.google.com/analytics/answer/1008015" rel="external"><?php echo smartyTranslate(array('s'=>'Create your account to get started.','mod'=>'ganalytics'),$_smarty_tpl);?>
</a></b>
				</p>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
