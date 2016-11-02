<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:28:12
         compiled from "/raid/www/blf/themes/bougie-la-francaise/category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3029635555819dbdca490d5-92014482%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26745a1fc237eb2bf3407e2563c77f494b998288' => 
    array (
      0 => '/raid/www/blf/themes/bougie-la-francaise/category.tpl',
      1 => 1477385903,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3029635555819dbdca490d5-92014482',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'category' => 0,
    'scenes' => 0,
    'description_short' => 0,
    'link' => 0,
    'categoryNameComplement' => 0,
    'products' => 0,
    'HOOK_LEFT_COLUMN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dbdcae98c8_90380333',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dbdcae98c8_90380333')) {function content_5819dbdcae98c8_90380333($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php if (isset($_smarty_tpl->tpl_vars['category']->value)) {?>
	<?php if ($_smarty_tpl->tpl_vars['category']->value->id&&$_smarty_tpl->tpl_vars['category']->value->active) {?>
    	<?php if ($_smarty_tpl->tpl_vars['scenes']->value||$_smarty_tpl->tpl_vars['category']->value->description||$_smarty_tpl->tpl_vars['category']->value->id_image) {?>
			<div class="content_scene_cat clearfix">
            	 <?php if ($_smarty_tpl->tpl_vars['scenes']->value) {?>
                 	<div class="content_scene">
					   <!-- Scenes -->
                        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./scenes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('scenes'=>$_smarty_tpl->tpl_vars['scenes']->value), 0);?>

						<?php if ($_smarty_tpl->tpl_vars['category']->value->description) {?>
                            <div class="cat_desc rte">
                            <?php if (Tools::strlen($_smarty_tpl->tpl_vars['category']->value->description)>350) {?>
                                <div id="category_description_short"><?php echo $_smarty_tpl->tpl_vars['description_short']->value;?>
</div>
                                <div id="category_description_full" class="unvisible"><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value->id_category,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="lnk_more"><?php echo smartyTranslate(array('s'=>'More'),$_smarty_tpl);?>
</a>
                            <?php } else { ?>
								<div><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
                            <?php }?>
                            </div>
                        <?php }?>
                    </div>
				<?php } else { ?>
                    <!-- Category image -->
                    <div class="container">
						<div class="row">
							<div class="col-sm-6 desc-col">
								<div class="cat_desc">
									<div class="cat_title">
										<span class="category-name">
											<h1>
											<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value->name, ENT_QUOTES, 'UTF-8', true);?>
<?php if (isset($_smarty_tpl->tpl_vars['categoryNameComplement']->value)) {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['categoryNameComplement']->value, ENT_QUOTES, 'UTF-8', true);?>
<?php }?>
											</h1>
										</span>
									</div>
									<div class="cat_text">
										
											<div class="rte"><?php echo $_smarty_tpl->tpl_vars['category']->value->description;?>
</div>
										
									</div>
								</div>
							</div>
							<div class="col-sm-6 cat-scene-bg" <?php if ($_smarty_tpl->tpl_vars['category']->value->id_image) {?> style="background:url(<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCatImageLink($_smarty_tpl->tpl_vars['category']->value->link_rewrite,$_smarty_tpl->tpl_vars['category']->value->id_image), ENT_QUOTES, 'UTF-8', true);?>
) right center no-repeat; background-size:cover; "<?php }?>>
								
							</div>
						</div>
					</div>
					
                  <?php }?>
            </div>
		<?php }?>
		<!-- Subcategories -->
		
		
		<?php if ($_smarty_tpl->tpl_vars['products']->value) {?>
			<div id="category-left-column" class="col-md-3 col-sm-4">
				<?php echo $_smarty_tpl->tpl_vars['HOOK_LEFT_COLUMN']->value;?>

			</div>
			<div class="col-md-9 col-sm-8">
				<div class="content_sortPagiBar clearfix">
					<div class="sortPagiBar clearfix">
						<?php echo $_smarty_tpl->getSubTemplate ("./product-count.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./product-compare.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</div>
					<div class="top-pagination-content clearfix sort-container">
						<?php echo $_smarty_tpl->getSubTemplate ("./nbr-product-page.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./product-sort.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</div>
				</div>
				<?php echo $_smarty_tpl->getSubTemplate ("./product-list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('products'=>$_smarty_tpl->tpl_vars['products']->value), 0);?>

				<div class="content_sortPagiBar">
					<div class="bottom-pagination-content sort-container clearfix">
						
						<?php echo $_smarty_tpl->getSubTemplate ("./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('paginationId'=>'bottom'), 0);?>

					</div>
				</div>
			</div>
		<?php }?>
	<?php } elseif ($_smarty_tpl->tpl_vars['category']->value->id) {?>
		<p class="alert alert-warning"><?php echo smartyTranslate(array('s'=>'This category is currently unavailable.'),$_smarty_tpl);?>
</p>
	<?php }?>
<?php }?>
<?php }} ?>
