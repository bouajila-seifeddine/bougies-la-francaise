<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 10:52:46
         compiled from "/home/bougies-la-francaise/public_html/modules/pressreviews/views/templates/front/pressreviews.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1262426930582d7dee06eb90-25014249%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bd6e492da9d9c2473904c929de043f6ca9da7850' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/pressreviews/views/templates/front/pressreviews.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1262426930582d7dee06eb90-25014249',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cookie' => 0,
    'intro' => 0,
    'reviews' => 0,
    'review' => 0,
    'itemsDisplay' => 0,
    'img_ps_dir' => 0,
    'date_conf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d7dee0c5115_55829319',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d7dee0c5115_55829319')) {function content_582d7dee0c5115_55829319($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/bougies-la-francaise/public_html/tools/smarty/plugins/modifier.date_format.php';
?><?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Press review','mod'=>'pressreviews'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<h1 class="blf-title"><?php echo smartyTranslate(array('s'=>'Press review','mod'=>'pressreviews'),$_smarty_tpl);?>
</h1>
<div id="intro_text">
	<?php echo $_smarty_tpl->tpl_vars['intro']->value[$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>

</div>
<div class="clear"></div>
<?php ob_start();?><?php echo count($_smarty_tpl->tpl_vars['reviews']->value);?>
<?php $_tmp1=ob_get_clean();?><?php if (isset($_smarty_tpl->tpl_vars['reviews']->value)&&$_tmp1>0) {?>
	<ul id="reviews" class="clearfix">
	<?php  $_smarty_tpl->tpl_vars['review'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['review']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['reviews']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['review']->key => $_smarty_tpl->tpl_vars['review']->value) {
$_smarty_tpl->tpl_vars['review']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['review']->key;
?>
		<?php if (isset($_smarty_tpl->tpl_vars['review']->value->type)&&$_smarty_tpl->tpl_vars['review']->value->type=='lightbox') {?>
			<li class="review col-md-3 col-sm-6 col-xs-12">
				<?php if ($_smarty_tpl->tpl_vars['itemsDisplay']->value['PR_ELEMENTS_DISPLAY_title']) {?><p class="title"><?php echo $_smarty_tpl->tpl_vars['review']->value->title[$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>
</p><?php }?>
				<a class="rev_img" href="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
pr/big/<?php echo $_smarty_tpl->tpl_vars['review']->value->id;?>
.jpg" title="<?php echo $_smarty_tpl->tpl_vars['review']->value->big_txt[$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
pr/thumb/<?php echo $_smarty_tpl->tpl_vars['review']->value->id;?>
.jpg" alt="" />
				</a>
				<div class="span_txt">
					<?php echo $_smarty_tpl->tpl_vars['review']->value->thumb_txt[$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>

					<?php if ($_smarty_tpl->tpl_vars['itemsDisplay']->value['PR_ELEMENTS_DISPLAY_date']) {?><p class="date"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['review']->value->creation_date,$_smarty_tpl->tpl_vars['date_conf']->value[$_smarty_tpl->tpl_vars['cookie']->value->id_lang]);?>
</p><?php }?>
				</div>
			</li>
		<?php } elseif (isset($_smarty_tpl->tpl_vars['review']->value->type)&&$_smarty_tpl->tpl_vars['review']->value->type=='link') {?>
			<li class="review col-md-3 col-sm-6 col-xs-12">
				<?php if ($_smarty_tpl->tpl_vars['itemsDisplay']->value['PR_ELEMENTS_DISPLAY_title']) {?><p class="title"><?php echo $_smarty_tpl->tpl_vars['review']->value->title[$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>
</p><?php }?>
				<a class="rev_link" target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['review']->value->link[$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>
" title="<?php echo $_smarty_tpl->tpl_vars['review']->value->title[$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>
">
					<img src="<?php echo $_smarty_tpl->tpl_vars['img_ps_dir']->value;?>
pr/thumb/<?php echo $_smarty_tpl->tpl_vars['review']->value->id;?>
.jpg" alt="" />
				</a>
				<div class="span_txt">
					<?php echo $_smarty_tpl->tpl_vars['review']->value->thumb_txt[$_smarty_tpl->tpl_vars['cookie']->value->id_lang];?>

					<?php if ($_smarty_tpl->tpl_vars['itemsDisplay']->value['PR_ELEMENTS_DISPLAY_date']) {?><p class="date"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['review']->value->creation_date,$_smarty_tpl->tpl_vars['date_conf']->value[$_smarty_tpl->tpl_vars['cookie']->value->id_lang]);?>
</p><?php }?>
				</div>
			</li>
		<?php }?>
	<?php } ?>
	</ul>
	<div class="clear"></div>
	<?php echo $_smarty_tpl->getSubTemplate ("./pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php } else { ?>
	<div class="block-center" id="block-history">
		<p class="warning">
			<?php echo smartyTranslate(array('s'=>'No article','mod'=>'pressreviews'),$_smarty_tpl);?>

		</p>
	</div>
<?php }?>
<div class="clear"></div><?php }} ?>
