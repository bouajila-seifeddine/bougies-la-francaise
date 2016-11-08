<?php /* Smarty version Smarty-3.1.19, created on 2016-11-08 12:40:56
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12903267325821b9c82325e6-40158160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c3ba356e3ed34f996487ff81eed5b8986873fea6' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/footer.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12903267325821b9c82325e6-40158160',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'right_column_size' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'page_name' => 0,
    'HOOK_FOOTER' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5821b9c82649b8_75909025',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5821b9c82649b8_75909025')) {function content_5821b9c82649b8_75909025($_smarty_tpl) {?>
<?php if (!isset($_smarty_tpl->tpl_vars['content_only']->value)||!$_smarty_tpl->tpl_vars['content_only']->value) {?>
							</div><!-- #center_column -->
							<?php if (isset($_smarty_tpl->tpl_vars['right_column_size']->value)&&!empty($_smarty_tpl->tpl_vars['right_column_size']->value)) {?>
								<div id="right_column" class="col-xs-12 col-sm-<?php echo intval($_smarty_tpl->tpl_vars['right_column_size']->value);?>
 column"><?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>
</div>
							<?php }?>
						
					<?php if ($_smarty_tpl->tpl_vars['page_name']->value!='index') {?>
						</div><!-- .row -->
					</div><!-- .container -->
					<?php }?>
					
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			<?php if ($_smarty_tpl->tpl_vars['page_name']->value=='cms') {?>
				<div class="footer-collections">
					<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'customSliderCollections'),$_smarty_tpl);?>

				</div>
			<?php }?>
			<?php if (isset($_smarty_tpl->tpl_vars['HOOK_FOOTER']->value)) {?>
				<!-- Footer -->
				<div class="footer-container">
					<footer id="footer">
						<div id="footer-find-store" class="footer-static-content">
							<div class="container">
								<div class="row">
									<p class="blf-title"><i class="ycon-boutiques"></i> <span><?php echo smartyTranslate(array('s'=>'Find a store'),$_smarty_tpl);?>
</span></p>
									<p><?php echo smartyTranslate(array('s'=>'The stores nearest to you'),$_smarty_tpl);?>
</p>
									<a class="link-btn" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('stores'), ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo smartyTranslate(array('s'=>'Our stores'),$_smarty_tpl);?>
">
										<?php echo smartyTranslate(array('s'=>'Search stores'),$_smarty_tpl);?>

									</a>
								</div>
							</div>
						</div>
						
						<!-- Content module footer -->
						
						<div class="footer-stages">
							<div class="footer-stage-1">
								<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'customFooterStage1'),$_smarty_tpl);?>

							</div>
							<div class="footer-stage-2">
								<div class="container">
									<div class="row">
										<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'customFooterStage2'),$_smarty_tpl);?>

										<div class="col-sm-3 col-xs-6">
											<div class="footer-block private-label-block">
												<a href="http://www.blf-privatelabel.com/">
													<h4>Private label</h4>
													<?php echo smartyTranslate(array('s'=>'Create a'),$_smarty_tpl);?>
 <strong><?php echo smartyTranslate(array('s'=>'candle'),$_smarty_tpl);?>
</strong>
													<br /><?php echo smartyTranslate(array('s'=>'to your'),$_smarty_tpl);?>
 <strong><?php echo smartyTranslate(array('s'=>'brand'),$_smarty_tpl);?>
</strong>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="footer-stage-3">
								<div class="container">
									<div class="row">
										<?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

									</div>
									<div class="row">
										<div class="footer-credits clearfix">
											<div class="footer-payments-methods col-sm-6 col-xs-12">
												<?php echo smartyTranslate(array('s'=>'Payment methods'),$_smarty_tpl);?>
 <img src="/themes/bougie-la-francaise/image/design/footer-payments.jpg" alt="VISA, Mastercard, CB, Paypal" />
											</div>
											<div class="blf-credits col-sm-6 col-xs-12">
												© Bougies la Française - 2016 | <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(2), ENT_QUOTES, 'UTF-8', true);?>
" rel="nofollow"><?php echo smartyTranslate(array('s'=>'Legal Notice'),$_smarty_tpl);?>
</a> | <?php echo smartyTranslate(array('s'=>'Website created by'),$_smarty_tpl);?>
 <a href="http://www.yateo.com" target="_blank">yateo.com</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</footer>
				</div><!-- #footer -->
			<?php }?>
		</div><!-- #page -->
		
<?php }?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./global.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</body>
</html><?php }} ?>
