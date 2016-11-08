<?php /* Smarty version Smarty-3.1.19, created on 2016-11-08 12:40:50
         compiled from "/home/bougies-la-francaise/public_html/administrator/themes/default/template/content.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9564684325821b9c2252cb8-80657484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60176c635620ba5229990e03f79c6046ddcab276' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/administrator/themes/default/template/content.tpl',
      1 => 1478101064,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9564684325821b9c2252cb8-80657484',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5821b9c2259417_94992984',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5821b9c2259417_94992984')) {function content_5821b9c2259417_94992984($_smarty_tpl) {?>
<div id="ajax_confirmation" class="alert alert-success hide"></div>

<div id="ajaxBox" style="display:none"></div>


<div class="row">
	<div class="col-lg-12">
		<?php if (isset($_smarty_tpl->tpl_vars['content']->value)) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div><?php }} ?>
