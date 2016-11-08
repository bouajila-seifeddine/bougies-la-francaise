<?php /* Smarty version Smarty-3.1.19, created on 2016-11-08 12:40:57
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/types/custom-html.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11504687735821b9c93a1103-72322744%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49059bd9c081f40a37d1cc2c7af569e6a10c4732' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/types/custom-html.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11504687735821b9c93a1103-72322744',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'megamenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5821b9c93bb631_34530783',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5821b9c93bb631_34530783')) {function content_5821b9c93bb631_34530783($_smarty_tpl) {?>
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
