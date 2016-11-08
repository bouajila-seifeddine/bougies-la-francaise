<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:44
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/types/custom-html.tpl" */ ?>
<?php /*%%SmartyHeaderCode:168964542581a1298879058-86558351%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c39512a556bbe7570f5e90fa46058107381cb453' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/types/custom-html.tpl',
      1 => 1477391209,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '168964542581a1298879058-86558351',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'megamenu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a12988961f7_52054932',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a12988961f7_52054932')) {function content_581a12988961f7_52054932($_smarty_tpl) {?>
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
