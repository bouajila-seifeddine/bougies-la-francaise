<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:38:47
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/my-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1869653633582d88b706f183-43018680%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f57974fe5a1224a5360c609dd10ba34f367d44d9' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/my-account.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1869653633582d88b706f183-43018680',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'account_created' => 0,
    'has_customer_an_address' => 0,
    'link' => 0,
    'returnAllowed' => 0,
    'voucherAllowed' => 0,
    'HOOK_CUSTOMER_ACCOUNT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d88b70b70b9_22882398',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d88b70b70b9_22882398')) {function content_582d88b70b70b9_22882398($_smarty_tpl) {?>

<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<h1 class="page-heading"><?php echo smartyTranslate(array('s'=>'My account'),$_smarty_tpl);?>
</h1>
<?php if (isset($_smarty_tpl->tpl_vars['account_created']->value)) {?>
	<p class="alert alert-success">
		<?php echo smartyTranslate(array('s'=>'Your account has been created.'),$_smarty_tpl);?>

	</p>
<?php }?>
<p class="info-account">
	<strong><?php echo smartyTranslate(array('s'=>'Welcome to your account.'),$_smarty_tpl);?>
</strong>
	<br /><?php echo smartyTranslate(array('s'=>'Here you can manage all of your personal information and orders.'),$_smarty_tpl);?>

</p>
<div class="row addresses-lists">
	<ul class="myaccount-link-list clearfix">
		<?php if ($_smarty_tpl->tpl_vars['has_customer_an_address']->value) {?>
		<li class="col-md-4 col-sm-6">
			<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('address',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Add my first address'),$_smarty_tpl);?>
">
				<i class="icon-building"></i><span><?php echo smartyTranslate(array('s'=>'Add my first address'),$_smarty_tpl);?>
</span>
			</a>
		</li>
		<?php }?>
		<li class="col-md-4 col-sm-6 order-history-list"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('history',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Orders'),$_smarty_tpl);?>
"><i class="icon-list-ol"></i><span><?php echo smartyTranslate(array('s'=>'Order history and details'),$_smarty_tpl);?>
</span></a></li>
		<?php if ($_smarty_tpl->tpl_vars['returnAllowed']->value) {?>
			<li class="col-md-4 col-sm-6"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order-follow',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Merchandise returns'),$_smarty_tpl);?>
"><i class="icon-refresh"></i><span><?php echo smartyTranslate(array('s'=>'My merchandise returns'),$_smarty_tpl);?>
</span></a></li>
		<?php }?>
		<li class="col-md-4 col-sm-6"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('order-slip',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Credit slips'),$_smarty_tpl);?>
"><i class="icon-file-o"></i><span class="short"><?php echo smartyTranslate(array('s'=>'My credit slips'),$_smarty_tpl);?>
</span></a></li>
		<li class="col-md-4 col-sm-6"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('addresses',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Addresses'),$_smarty_tpl);?>
"><i class="icon-building"></i><span class="short"><?php echo smartyTranslate(array('s'=>'My addresses'),$_smarty_tpl);?>
</span></a></li>
		<li class="col-md-4 col-sm-6"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('identity',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Information'),$_smarty_tpl);?>
"><i class="icon-user"></i><span><?php echo smartyTranslate(array('s'=>'My personal information'),$_smarty_tpl);?>
</span></a></li>
		<?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value||isset($_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value)&&$_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value!='') {?>
			<?php if ($_smarty_tpl->tpl_vars['voucherAllowed']->value) {?>
				<li class="col-md-4 col-sm-6"><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('discount',true), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Vouchers'),$_smarty_tpl);?>
"><i class="icon-barcode"></i><span class="short"><?php echo smartyTranslate(array('s'=>'My vouchers'),$_smarty_tpl);?>
</span></a></li>
			<?php }?>
			<?php echo $_smarty_tpl->tpl_vars['HOOK_CUSTOMER_ACCOUNT']->value;?>

		<?php }?>
	</ul>
	
</div>
<?php }} ?>
