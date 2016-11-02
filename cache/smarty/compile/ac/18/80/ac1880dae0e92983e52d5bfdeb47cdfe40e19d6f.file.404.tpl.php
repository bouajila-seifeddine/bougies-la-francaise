<?php /* Smarty version Smarty-3.1.19, created on 2016-10-25 12:11:51
         compiled from "/raid/www/blf/themes/bougie-la-francaise/404.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1387403345580f2fe7094a49-98408080%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac1880dae0e92983e52d5bfdeb47cdfe40e19d6f' => 
    array (
      0 => '/raid/www/blf/themes/bougie-la-francaise/404.tpl',
      1 => 1472469569,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1387403345580f2fe7094a49-98408080',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'force_ssl' => 0,
    'base_dir_ssl' => 0,
    'base_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_580f2fe70e1d79_40343516',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_580f2fe70e1d79_40343516')) {function content_580f2fe70e1d79_40343516($_smarty_tpl) {?>
<div class="pagenotfound">
	<h1><?php echo smartyTranslate(array('s'=>'This page is not available'),$_smarty_tpl);?>
</h1>

	<p>
		<?php echo smartyTranslate(array('s'=>'We\'re sorry, but the Web address you\'ve entered is no longer available.'),$_smarty_tpl);?>

	</p>
	<div class="box">
		<h3><?php echo smartyTranslate(array('s'=>'To find a product, please type its name in the field below.'),$_smarty_tpl);?>
</h3>
		<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search'), ENT_QUOTES, 'UTF-8', true);?>
" method="post" class="std">
			<fieldset>
				<div>
					<label for="search_query"><?php echo smartyTranslate(array('s'=>'Search our product catalog:'),$_smarty_tpl);?>
</label>
					<br />
					<input id="search_query" name="search_query" type="text" class="form-control grey" />
					<button type="submit" name="Submit" value="OK" class="btn btn-default button button-small"><span><?php echo smartyTranslate(array('s'=>'Ok'),$_smarty_tpl);?>
</span></button>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="buttons">
		<a class="btn-blf-cart-back" href="<?php if (isset($_smarty_tpl->tpl_vars['force_ssl']->value)&&$_smarty_tpl->tpl_vars['force_ssl']->value) {?><?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
<?php }?>" title="<?php echo smartyTranslate(array('s'=>'Home'),$_smarty_tpl);?>
">
			<i class="ycon-left-open-big"></i>
			<span><?php echo smartyTranslate(array('s'=>'Home page'),$_smarty_tpl);?>
</span>
		</a>
	</div>
</div>
<?php }} ?>
