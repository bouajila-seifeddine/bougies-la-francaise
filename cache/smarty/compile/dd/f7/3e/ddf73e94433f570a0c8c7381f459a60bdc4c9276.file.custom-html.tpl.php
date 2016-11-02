<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:30
         compiled from "/raid/www/blf/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/types/custom-html.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20472068485819dc66a90114-13193463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ddf73e94433f570a0c8c7381f459a60bdc4c9276' => 
    array (
      0 => '/raid/www/blf/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/types/custom-html.tpl',
      1 => 1477391694,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20472068485819dc66a90114-13193463',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'megamenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dc66ab7b48_64076976',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc66ab7b48_64076976')) {function content_5819dc66ab7b48_64076976($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['megamenu']->value['display_title']) {?>
	<span>
		<?php if ($_smarty_tpl->tpl_vars['megamenu']->value['url']!='') {?>
		<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['megamenu']->value['url'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['megamenu']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
		<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['megamenu']->value['icon']!='') {?>
				<i class="fa <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['megamenu']->value['icon'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"></i>
			<?php }?>
			
			<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['megamenu']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

		<?php if ($_smarty_tpl->tpl_vars['megamenu']->value['url']!='') {?>
		</a>
		<?php }?>
	</span>
<?php }?>

<?php echo $_smarty_tpl->tpl_vars['megamenu']->value['content'];?>
<?php }} ?>
