<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:44
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blockcms/blockcms.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1215099434581a1298c40b55-96478329%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e1069237d489048379de4e186f6f72dec211abf' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blockcms/blockcms.tpl',
      1 => 1476462650,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1215099434581a1298c40b55-96478329',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'block' => 0,
    'cms_titles' => 0,
    'cms_key' => 0,
    'cms_title' => 0,
    'cms_page' => 0,
    'link' => 0,
    'show_contact' => 0,
    'contact_url' => 0,
    'show_price_drop' => 0,
    'PS_CATALOG_MODE' => 0,
    'show_new_products' => 0,
    'show_best_sales' => 0,
    'display_poweredby' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a1298ceea96_27038952',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a1298ceea96_27038952')) {function content_581a1298ceea96_27038952($_smarty_tpl) {?>

<?php if ($_smarty_tpl->tpl_vars['block']->value==1) {?>
	<!-- Block CMS module -->
	<?php  $_smarty_tpl->tpl_vars['cms_title'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cms_title']->_loop = false;
 $_smarty_tpl->tpl_vars['cms_key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cms_titles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cms_title']->key => $_smarty_tpl->tpl_vars['cms_title']->value) {
$_smarty_tpl->tpl_vars['cms_title']->_loop = true;
 $_smarty_tpl->tpl_vars['cms_key']->value = $_smarty_tpl->tpl_vars['cms_title']->key;
?>
		<section id="informations_block_left_<?php echo $_smarty_tpl->tpl_vars['cms_key']->value;?>
" class="block informations_block_left">
			<p class="title_block">
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_title']->value['category_link'], ENT_QUOTES, 'UTF-8', true);?>
">
					<?php if (!empty($_smarty_tpl->tpl_vars['cms_title']->value['name'])) {?><?php echo $_smarty_tpl->tpl_vars['cms_title']->value['name'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['cms_title']->value['category_name'];?>
<?php }?>
				</a>
			</p>
			<div class="block_content list-block">
				<ul>
					<?php  $_smarty_tpl->tpl_vars['cms_page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cms_page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cms_title']->value['categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cms_page']->key => $_smarty_tpl->tpl_vars['cms_page']->value) {
$_smarty_tpl->tpl_vars['cms_page']->_loop = true;
?>
						<?php if (isset($_smarty_tpl->tpl_vars['cms_page']->value['link'])) {?>
							<li class="bullet">
								<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_page']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_page']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
">
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_page']->value['name'], ENT_QUOTES, 'UTF-8', true);?>

								</a>
							</li>
						<?php }?>
					<?php } ?>
					<?php  $_smarty_tpl->tpl_vars['cms_page'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cms_page']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cms_title']->value['cms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cms_page']->key => $_smarty_tpl->tpl_vars['cms_page']->value) {
$_smarty_tpl->tpl_vars['cms_page']->_loop = true;
?>
						<?php if (isset($_smarty_tpl->tpl_vars['cms_page']->value['link'])) {?>
							<li>
								<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_page']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_page']->value['meta_title'], ENT_QUOTES, 'UTF-8', true);?>
">
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cms_page']->value['meta_title'], ENT_QUOTES, 'UTF-8', true);?>

								</a>
							</li>
						<?php }?>
					<?php } ?>
					<?php if ($_smarty_tpl->tpl_vars['cms_title']->value['display_store']) {?>
						<li>
							<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('stores'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Our stores','mod'=>'blockcms'),$_smarty_tpl);?>
">
								<?php echo smartyTranslate(array('s'=>'Our stores','mod'=>'blockcms'),$_smarty_tpl);?>

							</a>
						</li>
					<?php }?>
				</ul>
			</div>
		</section>
	<?php } ?>
	<!-- /Block CMS module -->
<?php } else { ?>
	<!-- Block CMS module footer -->
	<section class="footer-block-cms col-sm-3" id="block_customer_services">
		<h4><?php echo smartyTranslate(array('s'=>'Customer services','mod'=>'blockcms'),$_smarty_tpl);?>
 <i class="ycon-down-open-big"></i></h4>
		<ul class="toggle-footer">
			<?php if (isset($_smarty_tpl->tpl_vars['show_contact']->value)&&$_smarty_tpl->tpl_vars['show_contact']->value) {?>
				<li class="item">
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink($_smarty_tpl->tpl_vars['contact_url']->value,true), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Contact us','mod'=>'blockcms'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'Contact us','mod'=>'blockcms'),$_smarty_tpl);?>

					</a>
				</li>
			<?php }?>
			<li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(1), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Shipping','mod'=>'blockcms'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Shipping','mod'=>'blockcms'),$_smarty_tpl);?>
</a></li>
			<li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(11), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Satisfied or refunded','mod'=>'blockcms'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Satisfied or refunded','mod'=>'blockcms'),$_smarty_tpl);?>
</a></li>
			<li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(5), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Secure payment','mod'=>'blockcms'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Secure payment','mod'=>'blockcms'),$_smarty_tpl);?>
</a></li>
			<li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(12), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'FAQ','mod'=>'blockcms'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'FAQ','mod'=>'blockcms'),$_smarty_tpl);?>
</a></li>
			<li><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(3), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow" title="<?php echo smartyTranslate(array('s'=>'Terms of sales','mod'=>'blockcms'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Terms of sales','mod'=>'blockcms'),$_smarty_tpl);?>
</a></li>
		</ul>
	</section>

	<section class="footer-block-cms col-sm-3" id="block_categories">
		<h4><?php echo smartyTranslate(array('s'=>'Categories','mod'=>'blockcms'),$_smarty_tpl);?>
 <i class="ycon-down-open-big"></i></h4>
		<ul class="toggle-footer">
			<?php if (isset($_smarty_tpl->tpl_vars['show_price_drop']->value)&&$_smarty_tpl->tpl_vars['show_price_drop']->value&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
				<li class="item">
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('prices-drop'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Specials','mod'=>'blockcms'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'Specials','mod'=>'blockcms'),$_smarty_tpl);?>

					</a>
				</li>
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['show_new_products']->value)&&$_smarty_tpl->tpl_vars['show_new_products']->value) {?>
			<li class="item">
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('new-products'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'New products','mod'=>'blockcms'),$_smarty_tpl);?>
">
					<?php echo smartyTranslate(array('s'=>'New products','mod'=>'blockcms'),$_smarty_tpl);?>

				</a>
			</li>
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['show_best_sales']->value)&&$_smarty_tpl->tpl_vars['show_best_sales']->value&&!$_smarty_tpl->tpl_vars['PS_CATALOG_MODE']->value) {?>
				<li class="item">
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('best-sales'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Top sellers','mod'=>'blockcms'),$_smarty_tpl);?>
">
						<?php echo smartyTranslate(array('s'=>'Top sellers','mod'=>'blockcms'),$_smarty_tpl);?>

					</a>
				</li>
			<?php }?>
		</ul>
	</section>
	
	
	
	
	
	<?php if ($_smarty_tpl->tpl_vars['display_poweredby']->value) {?>
	<section class="bottom-footer col-xs-12">
		<div>
			<?php echo smartyTranslate(array('s'=>'[1] %3$s %2$s - Ecommerce software by %1$s [/1]','mod'=>'blockcms','sprintf'=>array('PrestaShop™',date('Y'),'©'),'tags'=>array('<a class="_blank" href="http://www.prestashop.com">')),$_smarty_tpl);?>

		</div>
	</section>
	<?php }?>
	<!-- /Block CMS module footer -->
<?php }?>
<?php }} ?>
