<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:55:02
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/errors.tpl" */ ?>
<?php /*%%SmartyHeaderCode:898285332582d8c861f99d8-41823427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da5da770afe1bf5185f5168e4b3f44b98933b4b6' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/errors.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '898285332582d8c861f99d8-41823427',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'errors' => 0,
    'error' => 0,
    'request_uri' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d8c862207a2_30147178',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c862207a2_30147178')) {function content_582d8c862207a2_30147178($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['errors']->value)&&$_smarty_tpl->tpl_vars['errors']->value) {?>
	<div class="container">
		<div class="row">
			<div class="alert alert-danger">
				<p><?php if (count($_smarty_tpl->tpl_vars['errors']->value)>1) {?><?php echo smartyTranslate(array('s'=>'There are %d errors','sprintf'=>count($_smarty_tpl->tpl_vars['errors']->value)),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'There is %d error','sprintf'=>count($_smarty_tpl->tpl_vars['errors']->value)),$_smarty_tpl);?>
<?php }?></p>
				<ol>
				<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['error']->key;
?>
					<li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
				<?php } ?>
				</ol>
				<?php if (isset($_SERVER['HTTP_REFERER'])&&!strstr($_smarty_tpl->tpl_vars['request_uri']->value,'authentication')&&preg_replace('#^https?://[^/]+/#','/',$_SERVER['HTTP_REFERER'])!=$_smarty_tpl->tpl_vars['request_uri']->value) {?>
					<p class="lnk"><a class="alert-link" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['secureReferrer'][0][0]->secureReferrer(htmlspecialchars($_SERVER['HTTP_REFERER'], ENT_QUOTES, 'UTF-8', true));?>
" title="<?php echo smartyTranslate(array('s'=>'Back'),$_smarty_tpl);?>
"><i class="icon-chevron-left"></i> <?php echo smartyTranslate(array('s'=>'Back'),$_smarty_tpl);?>
</a></p>
				<?php }?>
			</div>
		</div>
	</div>
<?php }?>
<?php }} ?>
