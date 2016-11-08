<?php /* Smarty version Smarty-3.1.19, created on 2016-11-08 12:40:57
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/ph_megamenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2640821475821b9c9241696-75487163%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6588abb077ebf9e97dd8684fbbf9b6a0e236624d' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/ph_megamenu/views/templates/hook/ph_megamenu.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2640821475821b9c9241696-75487163',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menu' => 0,
    'tab' => 0,
    'base_dir' => 0,
    'megamenu' => 0,
    'dropdown' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5821b9c92f6e51_94170275',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5821b9c92f6e51_94170275')) {function content_5821b9c92f6e51_94170275($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['menu']->value) {?>
<div class="ph_megamenu_mobile_toggle container">
	<a href="#" class="show_megamenu"><i class="fa fa-bars"></i><?php echo smartyTranslate(array('s'=>'Show menu','mod'=>'ph_megamenu'),$_smarty_tpl);?>
</a>
	<a href="#" class="hide_megamenu"><i class="fa fa-times"></i><?php echo smartyTranslate(array('s'=>'Hide menu','mod'=>'ph_megamenu'),$_smarty_tpl);?>
</a>
</div>
<div id="ph_megamenu_wrapper" class="clearBoth container">
	<nav role="navigation">
		<ul id="ph_megamenu" class="ph_megamenu">
			<?php  $_smarty_tpl->tpl_vars['tab'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tab']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tab']->key => $_smarty_tpl->tpl_vars['tab']->value) {
$_smarty_tpl->tpl_vars['tab']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['tab']->key;
?>
				<li class="menu_link_<?php echo intval($_smarty_tpl->tpl_vars['tab']->value['id_prestahome_megamenu']);?>
<?php if ($_smarty_tpl->tpl_vars['tab']->value['class']!='') {?> <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['class'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['tab']->value['align']==1) {?> align-right<?php }?><?php if ($_smarty_tpl->tpl_vars['tab']->value['icon']!='') {?> with-icon<?php }?> <?php if ($_smarty_tpl->tpl_vars['tab']->value['type']==1) {?>has-submenu<?php }?> <?php if ($_smarty_tpl->tpl_vars['tab']->value['url']==$_smarty_tpl->tpl_vars['base_dir']->value) {?>active<?php }?><?php if ($_smarty_tpl->tpl_vars['tab']->value['hide_on_mobile']) {?> ph-hidden-mobile<?php }?><?php if ($_smarty_tpl->tpl_vars['tab']->value['hide_on_desktop']) {?> ph-hidden-desktop<?php }?>">
					<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['url'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" title="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" <?php if ($_smarty_tpl->tpl_vars['tab']->value['new_window']) {?>target="_blank"<?php }?>>
						<?php if ($_smarty_tpl->tpl_vars['tab']->value['icon']!='') {?>
							<i class="fa <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['icon'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"></i>
						<?php }?>
						
						<span class="<?php if (!$_smarty_tpl->tpl_vars['tab']->value['display_title']) {?>hide<?php }?>"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>

						<?php if ($_smarty_tpl->tpl_vars['tab']->value['label_text']) {?>
							<span class="label" style="color:<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['label_bg'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
;background:<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['label_bg'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
;">
								<span style="color: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['label_color'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
;"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['tab']->value['label_text'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span>
							</span>
						<?php }?>
					</a>
					
					<?php if ($_smarty_tpl->tpl_vars['tab']->value['type']==1) {?>
					<div class="mega-menu clear clearfix <?php if (Configuration::get('PH_MM_USE_SLIDE_EFFECT')) {?>with-effect<?php }?>" style="width: auto; <?php if ($_smarty_tpl->tpl_vars['tab']->value['align']==0) {?>left: 0;<?php } else { ?>right: 0;<?php }?>">
						<div class="">
							<?php if ($_smarty_tpl->tpl_vars['tab']->value['content_before']!='') {?>
								<div class="container-fluid menu-content-before">
									<?php echo $_smarty_tpl->tpl_vars['tab']->value['content_before'];?>

								</div><!-- .menu-content-before -->
							<?php }?>

							<?php if (isset($_smarty_tpl->tpl_vars['tab']->value['childrens'])&&sizeof($_smarty_tpl->tpl_vars['tab']->value['childrens'])) {?>
								<?php  $_smarty_tpl->tpl_vars['megamenu'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['megamenu']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tab']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['megamenu']->key => $_smarty_tpl->tpl_vars['megamenu']->value) {
$_smarty_tpl->tpl_vars['megamenu']->_loop = true;
?>
									<div class="ph-type-<?php echo intval($_smarty_tpl->tpl_vars['megamenu']->value['type']);?>
 <?php if ($_smarty_tpl->tpl_vars['megamenu']->value['type']!=6) {?>ph-col ph-col-<?php echo intval($_smarty_tpl->tpl_vars['megamenu']->value['columns']);?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['megamenu']->value['new_row']) {?> ph-new-row<?php }?><?php if ($_smarty_tpl->tpl_vars['megamenu']->value['hide_on_mobile']) {?> ph-hidden-mobile<?php }?><?php if ($_smarty_tpl->tpl_vars['megamenu']->value['hide_on_desktop']) {?> ph-hidden-desktop<?php }?><?php if ($_smarty_tpl->tpl_vars['megamenu']->value['class']!='') {?> <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['megamenu']->value['class'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>">
										
										<?php if ($_smarty_tpl->tpl_vars['megamenu']->value['type']==4) {?>
											<?php echo $_smarty_tpl->getSubTemplate ("./types/mega-categories.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

										<?php }?>

										
										<?php if ($_smarty_tpl->tpl_vars['megamenu']->value['type']==5) {?>
											<?php echo $_smarty_tpl->getSubTemplate ("./types/custom-html.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

										<?php }?>

										
										<?php if ($_smarty_tpl->tpl_vars['megamenu']->value['type']==6) {?>
											<?php echo $_smarty_tpl->getSubTemplate ("./types/mega-products.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

										<?php }?>
									</div><!-- .ph-type-<?php echo intval($_smarty_tpl->tpl_vars['megamenu']->value['type']);?>
.ph-col.ph-col-<?php echo intval($_smarty_tpl->tpl_vars['megamenu']->value['columns']);?>
 -->
								<?php } ?>
							<?php }?>

							<?php if ($_smarty_tpl->tpl_vars['tab']->value['content_after']!='') {?>
								<div class="container-fluid menu-content-after">
									<?php echo $_smarty_tpl->tpl_vars['tab']->value['content_after'];?>

								</div><!-- .menu-content-after -->
							<?php }?>
						</div><!-- . -->
					</div><!-- .mega-menu -->
					<?php }?>

					
					<?php if ($_smarty_tpl->tpl_vars['tab']->value['type']==0&&isset($_smarty_tpl->tpl_vars['tab']->value['childrens'])&&sizeof($_smarty_tpl->tpl_vars['tab']->value['childrens'])) {?>
						<ul class="dropdown">
							<?php  $_smarty_tpl->tpl_vars['dropdown'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dropdown']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tab']->value['childrens']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dropdown']->key => $_smarty_tpl->tpl_vars['dropdown']->value) {
$_smarty_tpl->tpl_vars['dropdown']->_loop = true;
?>
							<li class="menu_link_dropdown_<?php echo intval($_smarty_tpl->tpl_vars['dropdown']->value['id_prestahome_megamenu']);?>
 <?php if ($_smarty_tpl->tpl_vars['dropdown']->value['class']!='') {?> <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dropdown']->value['class'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['dropdown']->value['icon']!='') {?> with-icon<?php }?>">
								<a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dropdown']->value['url'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
">
									<?php if ($_smarty_tpl->tpl_vars['dropdown']->value['icon']!='') {?>
										<i class="fa <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dropdown']->value['icon'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"></i>
									<?php }?>

									<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dropdown']->value['title'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

								</a>
							</li>
							<?php } ?>
						</ul>
					<?php }?>

					
					<?php if ($_smarty_tpl->tpl_vars['tab']->value['type']==2&&isset($_smarty_tpl->tpl_vars['tab']->value['dropdown'])&&sizeof($_smarty_tpl->tpl_vars['tab']->value['dropdown'])) {?>
						<?php echo $_smarty_tpl->getSubTemplate ("./types/dropdown-categories.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					<?php }?>

				</li>
			<?php } ?>
		</ul>
	</nav>
</div><!-- #ph_megamenu -->
<script>
$(function() {
	$('.ph_megamenu').ph_megamenu();
	if(typeof $.fn.fitVids !== 'undefined') {
		$('.ph_megamenu').fitVids();
	}
});
</script>
<?php }?>
<?php }} ?>
