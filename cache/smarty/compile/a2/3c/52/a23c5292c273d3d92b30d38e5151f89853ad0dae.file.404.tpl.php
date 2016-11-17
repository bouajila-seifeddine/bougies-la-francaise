<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:54:00
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/404.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1761943271582d8c48d4daa6-14515979%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a23c5292c273d3d92b30d38e5151f89853ad0dae' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/404.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1761943271582d8c48d4daa6-14515979',
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
  'unifunc' => 'content_582d8c48d61800_43012508',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c48d61800_43012508')) {function content_582d8c48d61800_43012508($_smarty_tpl) {?>
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
