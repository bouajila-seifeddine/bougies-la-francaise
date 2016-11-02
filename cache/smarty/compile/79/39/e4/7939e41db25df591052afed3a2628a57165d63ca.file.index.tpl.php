<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:24:37
         compiled from "/raid/www/blf/themes/bougie-la-francaise/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9711052725819db05b321f4-73206267%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7939e41db25df591052afed3a2628a57165d63ca' => 
    array (
      0 => '/raid/www/blf/themes/bougie-la-francaise/index.tpl',
      1 => 1476355360,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9711052725819db05b321f4-73206267',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_HOME' => 0,
    'cms' => 0,
    'link' => 0,
    'category' => 0,
    'HOOK_HOME_TAB_CONTENT' => 0,
    'HOOK_HOME_TAB' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819db05c00b22_74778191',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819db05c00b22_74778191')) {function content_5819db05c00b22_74778191($_smarty_tpl) {?>

<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME']->value)) {?>
	<div class="clearfix"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>
</div>
<?php }?>
<div id="home-century" class="home-static-content">
	<div class="century-pattern"></div>
	<div class="century-faded-logo">
		<div class="container">
			<img src="/themes/bougie-la-francaise/image/design/logo-entreprise-familiale-centenaire.png" alt="Entreprise familiale centenaire" />
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="text-intro">
				<div class="century-title">
					<h1 class="dragoniscoming"><?php echo smartyTranslate(array('s'=>'Bougies la Française'),$_smarty_tpl);?>
</h1>
					<div class="dragoniscoming"><?php echo smartyTranslate(array('s'=>'un siècle'),$_smarty_tpl);?>
</div>
					<span><?php echo smartyTranslate(array('s'=>'a century of passion'),$_smarty_tpl);?>
</span>
				</div>
				<h3>
					<?php echo smartyTranslate(array('s'=>'of expertise bayberry'),$_smarty_tpl);?>

					<br /><?php echo smartyTranslate(array('s'=>'and perfumer spirit'),$_smarty_tpl);?>

				</h3>
			</div>
			<div class="col-md-4">
				<div class="century-block">
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(6,$_smarty_tpl->tpl_vars['cms']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="century-block-text">
						<h4><?php echo smartyTranslate(array('s'=>'century block 1 title'),$_smarty_tpl);?>
</h4>
						<p><?php echo smartyTranslate(array('s'=>'century block 1 text'),$_smarty_tpl);?>
</p>
					</a>
					<div class="picture" style="background-image:url(/themes/bougie-la-francaise/image/design/century-01.jpg);">
						<img src="/themes/bougie-la-francaise/image/design/century-01.jpg" alt="" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="century-block">
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(7,$_smarty_tpl->tpl_vars['cms']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="century-block-text">
						<h4><?php echo smartyTranslate(array('s'=>'century block 2 title'),$_smarty_tpl);?>
</h4>
						<p><?php echo smartyTranslate(array('s'=>'century block 2 text'),$_smarty_tpl);?>
</p>
					</a>
					<div class="picture" style="background-image:url(/themes/bougie-la-francaise/image/design/century-02.jpg);">
						<img src="/themes/bougie-la-francaise/image/design/century-02.jpg" alt="" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="century-block">
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCMSLink(8,$_smarty_tpl->tpl_vars['cms']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="century-block-text">
						<h4><?php echo smartyTranslate(array('s'=>'century block 3 title'),$_smarty_tpl);?>
</h4>
						<p><?php echo smartyTranslate(array('s'=>'century block 3 text'),$_smarty_tpl);?>
</p>
					</a>
					<div class="picture" style="background-image:url(/themes/bougie-la-francaise/image/design/century-03.jpg);">
						<img src="/themes/bougie-la-francaise/image/design/century-03.jpg" alt="" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="home-collections">
	<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0][0]->smartyHook(array('h'=>'customSliderCollections'),$_smarty_tpl);?>

</div>
<div id="home-parfum" class="home-static-content">
	<div class="container-fluid">
		<h2 class="blf-title"><?php echo smartyTranslate(array('s'=>'Our fragant worlds'),$_smarty_tpl);?>
</h2>
		<div class="row">
			<div class="col-sm-4">
				
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(43,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block floral">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Floral'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(88,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block powder">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Powder'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(46,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block regressive">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Regressive'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
			</div>
			
			<div class="col-sm-4">
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(49,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block spicy">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Spicy'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(44,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block wooded">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Wooded'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(45,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block oriental">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Oriental'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
			</div>
			
			<div class="col-sm-4">
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(42,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block gourmand">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Gourmand'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(47,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block fruity">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Fruity'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getCategoryLink(48,$_smarty_tpl->tpl_vars['category']->value->link_rewrite), ENT_QUOTES, 'UTF-8', true);?>
" class="parfum-block citrus">
					<div class="parfum-name">
						<h3><?php echo smartyTranslate(array('s'=>'Citrus'),$_smarty_tpl);?>
</h3>
					</div>
				</a>
			</div>
			
		</div>
	</div>
</div>
<div class="container" id="tab_content">
	<div class="row">
	<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value)) {?>
		<?php if (isset($_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value)&&trim($_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value)) {?>
			
				<?php echo $_smarty_tpl->tpl_vars['HOOK_HOME_TAB']->value;?>

			
		<?php }?>
		<div class="tab-content"><?php echo $_smarty_tpl->tpl_vars['HOOK_HOME_TAB_CONTENT']->value;?>
</div>
	<?php }?>
	</div>
</div>
<div id="home-private-label" class="home-static-content">
	<div class="container-fluid">
		<div class="row">
			<div class="etiquette">
				<div class="etiquette-content">
					<h2><?php echo smartyTranslate(array('s'=>'Private label'),$_smarty_tpl);?>
</h2>
					<p>
						<?php echo smartyTranslate(array('s'=>'A high craftsmanship tradition'),$_smarty_tpl);?>

						<br /><?php echo smartyTranslate(array('s'=>'for your bespoke projects...'),$_smarty_tpl);?>

					</p>
					<p><a href="http://www.blf-privatelabel.com" target="_blank"><?php echo smartyTranslate(array('s'=>'Discover our services'),$_smarty_tpl);?>
</a></p>
				</div>
			</div>
			<div class="col-xs-6 side left"></div>
			<div class="col-xs-6 side right"></div>
		</div>
	</div>
</div><?php }} ?>
