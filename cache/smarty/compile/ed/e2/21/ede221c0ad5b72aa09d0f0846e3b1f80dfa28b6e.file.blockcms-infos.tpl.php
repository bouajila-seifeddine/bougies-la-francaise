<?php /* Smarty version Smarty-3.1.19, created on 2016-11-08 12:40:56
         compiled from "/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockcms/blockcms-infos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10276945375821b9c826f6d7-79242646%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ede221c0ad5b72aa09d0f0846e3b1f80dfa28b6e' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/themes/bougie-la-francaise/modules/blockcms/blockcms-infos.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10276945375821b9c826f6d7-79242646',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cms_key' => 0,
    'cmslinks' => 0,
    'cmslink' => 0,
    'display_stores_footer' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5821b9c828c1e5_62980994',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5821b9c828c1e5_62980994')) {function content_5821b9c828c1e5_62980994($_smarty_tpl) {?>

<div class="col-sm-6">
	<!-- Block CMS module -->
		<section id="blf_blockcms_custom_<?php echo $_smarty_tpl->tpl_vars['cms_key']->value;?>
" class="block blf-cms-custom-footer-1">
			<div class="block_content footer-cms-list">
				<div class="blf-footer-logo"><img src="/themes/bougie-la-francaise/image/design/blf-logo-footer.jpg" alt="Bougie la Française" /></div>
				<ul>
					<?php  $_smarty_tpl->tpl_vars['cmslink'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cmslink']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cmslinks']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cmslink']->key => $_smarty_tpl->tpl_vars['cmslink']->value) {
$_smarty_tpl->tpl_vars['cmslink']->_loop = true;
?>
						<?php if ($_smarty_tpl->tpl_vars['cmslink']->value['meta_title']!='') {?>
							<li class="item">
								<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cmslink']->value['link'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cmslink']->value['meta_title'], ENT_QUOTES, 'UTF-8', true);?>
">
									<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cmslink']->value['meta_title'], ENT_QUOTES, 'UTF-8', true);?>

								</a>
							</li>
						<?php }?>
					<?php } ?>
					<?php if (isset($_smarty_tpl->tpl_vars['display_stores_footer']->value)&&$_smarty_tpl->tpl_vars['display_stores_footer']->value) {?>
						<li class="item">
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
	<!-- /Block CMS module -->
</div><?php }} ?>
