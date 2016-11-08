<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:44
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/types/mega-categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:909163716581a12987c9ac0-67682480%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b3c8cd574278ba6aaf419651e1255083def8e91' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/types/mega-categories.tpl',
      1 => 1477392648,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '909163716581a12987c9ac0-67682480',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'megamenu' => 0,
    'cat' => 0,
    'link' => 0,
    'cat_child' => 0,
    'cat_child_lvl_2' => 0,
    'cat_child_lvl_3' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a1298845e16_73478877',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a1298845e16_73478877')) {function content_581a1298845e16_73478877($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['megamenu']->value['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
<div class="col-md-12">
	<?php if ($_smarty_tpl->tpl_vars['megamenu']->value['display_title']==1) {?>
	<span class="ph-mega-categories-cat-title cat_<?php echo intval($_smarty_tpl->tpl_vars['cat']->value['id_category']);?>
">
		<a href="<?php if ($_smarty_tpl->tpl_vars['cat']->value['id_category']>2) {?><?php echo $_smarty_tpl->tpl_vars['link']->value->getCategoryLink(intval($_smarty_tpl->tpl_vars['cat']->value['id_category']),mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat']->value['link_rewrite'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
<?php } else { ?>#<?php }?>" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
			<span><p><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p></span>
		</a>
	</span>
	<?php }?>

	<?php if (isset($_smarty_tpl->tpl_vars['cat']->value['children'])) {?>
		<ul class="ph-mega-categories-list-lvl-1">
			<?php  $_smarty_tpl->tpl_vars['cat_child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_child']->key => $_smarty_tpl->tpl_vars['cat_child']->value) {
$_smarty_tpl->tpl_vars['cat_child']->_loop = true;
?>
			
			<li class="cat_<?php echo intval($_smarty_tpl->tpl_vars['cat_child']->value['id_category']);?>
 <?php if (isset($_GET['id_category'])&&$_GET['id_category']==intval($_smarty_tpl->tpl_vars['cat_child']->value['id_category'])) {?>active<?php }?>">
				<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCategoryLink(intval($_smarty_tpl->tpl_vars['cat_child']->value['id_category']),mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat_child']->value['link_rewrite'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat_child']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
					<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat_child']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

				</a>

				
				<?php if (isset($_smarty_tpl->tpl_vars['cat_child']->value['children'])) {?>
					<ul class="ph-mega-categories-list-lvl-2 dropdown megamenu-dropdown">
						<?php  $_smarty_tpl->tpl_vars['cat_child_lvl_2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_child_lvl_2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_child']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_child_lvl_2']->key => $_smarty_tpl->tpl_vars['cat_child_lvl_2']->value) {
$_smarty_tpl->tpl_vars['cat_child_lvl_2']->_loop = true;
?>
							<li class="cat_<?php echo intval($_smarty_tpl->tpl_vars['cat_child_lvl_2']->value['id_category']);?>
 <?php if (isset($_GET['id_category'])&&$_GET['id_category']==intval($_smarty_tpl->tpl_vars['cat_child_lvl_2']->value['id_category'])) {?>active<?php }?>">

								<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCategoryLink(intval($_smarty_tpl->tpl_vars['cat_child_lvl_2']->value['id_category']),mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat_child_lvl_2']->value['link_rewrite'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
">
									<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat_child_lvl_2']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

								</a>

								
								<?php if (isset($_smarty_tpl->tpl_vars['cat_child_lvl_2']->value['children'])) {?>
									<ul class="ph-mega-categories-list-lvl-3 dropdown megamenu-dropdown">
										<?php  $_smarty_tpl->tpl_vars['cat_child_lvl_3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_child_lvl_3']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_child_lvl_2']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_child_lvl_3']->key => $_smarty_tpl->tpl_vars['cat_child_lvl_3']->value) {
$_smarty_tpl->tpl_vars['cat_child_lvl_3']->_loop = true;
?>
											<li class="cat_<?php echo intval($_smarty_tpl->tpl_vars['cat_child_lvl_3']->value['id_category']);?>
 <?php if (isset($_GET['id_category'])&&$_GET['id_category']==intval($_smarty_tpl->tpl_vars['cat_child_lvl_3']->value['id_category'])) {?>active<?php }?>">
												<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCategoryLink(intval($_smarty_tpl->tpl_vars['cat_child_lvl_3']->value['id_category']),mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat_child_lvl_3']->value['link_rewrite'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
">
													<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['cat_child_lvl_3']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

												</a>
											</li>
										<?php } ?>
									</ul>
								<?php }?>
								
							</li>
						<?php } ?>
					</ul>
				<?php }?>
			</li>
			<?php } ?>
		</ul>
	<?php }?>
</div><!-- .col-md-12 -->
<?php } ?>
<?php }} ?>
