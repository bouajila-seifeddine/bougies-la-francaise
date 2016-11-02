<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 12:54:46
         compiled from "/raid/www/blf/administrator/themes/default/template/helpers/modules_list/modal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12547816995819d4064e77b3-63520377%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df4d6ad82da41855a32dde60e55021ccc9fe81a3' => 
    array (
      0 => '/raid/www/blf/administrator/themes/default/template/helpers/modules_list/modal.tpl',
      1 => 1466506471,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12547816995819d4064e77b3-63520377',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819d4064ea8f4_44911184',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819d4064ea8f4_44911184')) {function content_5819d4064ea8f4_44911184($_smarty_tpl) {?><div class="modal fade" id="modules_list_container">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title"><?php echo smartyTranslate(array('s'=>'Recommended Modules and Services'),$_smarty_tpl);?>
</h3>
			</div>
			<div class="modal-body">
				<div id="modules_list_container_tab_modal" style="display:none;"></div>
				<div id="modules_list_loader"><i class="icon-refresh icon-spin"></i></div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
