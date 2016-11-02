<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 12:54:46
         compiled from "/raid/www/blf/administrator/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19534270245819d406394f52-07350826%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f1fa64c00bd00f7c4e1303034ba40fcf4372e3ec' => 
    array (
      0 => '/raid/www/blf/administrator/themes/default/template/content.tpl',
      1 => 1466506470,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19534270245819d406394f52-07350826',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819d40639d321_92910354',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819d40639d321_92910354')) {function content_5819d40639d321_92910354($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
