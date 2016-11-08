<?php /* Smarty version Smarty-3.1.19, created on 2016-10-26 11:43:32
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/socolissimo/views/templates/front/error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:93360795658107ac414b8f9-80404112%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4b77bfb9444cc48d499e289a63a6c4abff0cbc9' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/socolissimo/views/templates/front/error.tpl',
      1 => 1477386487,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93360795658107ac414b8f9-80404112',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'error_list' => 0,
    'current_error' => 0,
    'so_url_back' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58107ac4169804_78134193',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58107ac4169804_78134193')) {function content_58107ac4169804_78134193($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['error_list']->value)) {?>
	<div class="alert error">
		<?php echo smartyTranslate(array('s'=>'Socolissimo errors list:','mod'=>'socolissimo'),$_smarty_tpl);?>

		<ul style="margin-top: 10px;">
			<?php  $_smarty_tpl->tpl_vars['current_error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['current_error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['error_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['current_error']->key => $_smarty_tpl->tpl_vars['current_error']->value) {
$_smarty_tpl->tpl_vars['current_error']->_loop = true;
?>
				<li><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['current_error']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</li>
			<?php } ?>
		</ul>
	</div>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['so_url_back']->value)) {?>
	<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['so_url_back']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
step=2&cgv=1" class="button_small" title="<?php echo smartyTranslate(array('s'=>'Back','mod'=>'socolissimo'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Back','mod'=>'socolissimo'),$_smarty_tpl);?>
</a>
<?php }?>
<?php }} ?>
