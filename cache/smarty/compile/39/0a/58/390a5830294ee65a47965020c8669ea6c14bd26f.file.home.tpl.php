<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:24:37
         compiled from "/raid/www/blf/themes/bougie-la-francaise/modules/homeimageblock/views/templates/hook/home.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12023074535819db050a0163-54392150%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '390a5830294ee65a47965020c8669ea6c14bd26f' => 
    array (
      0 => '/raid/www/blf/themes/bougie-la-francaise/modules/homeimageblock/views/templates/hook/home.tpl',
      1 => 1472823523,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12023074535819db050a0163-54392150',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'images' => 0,
    'image_block_backgroud' => 0,
    'left_margin' => 0,
    'bottom_margin' => 0,
    'image' => 0,
    'animate' => 0,
    'animate_px' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819db05123ad8_18402387',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819db05123ad8_18402387')) {function content_5819db05123ad8_18402387($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/raid/www/blf/tools/smarty/plugins/modifier.escape.php';
?>
<?php if (!empty($_smarty_tpl->tpl_vars['images']->value)) {?>
<div id="homeimageblock-bg" style="background-color:<?php echo $_smarty_tpl->tpl_vars['image_block_backgroud']->value;?>
;">
	<div class="container">
		<div class="row">
			<div id="container-homeimageblock" style="margin-left: -<?php echo (smarty_modifier_escape($_smarty_tpl->tpl_vars['left_margin']->value, 'intval'))/2;?>
px">
				<ul id="homeimageblock" class="masonry">
					<!-- product attribute to add at cart when click on add button -->
					<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value) {
$_smarty_tpl->tpl_vars['image']->_loop = true;
?>
						<li class="item" style="margin-left: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['left_margin']->value, ENT_QUOTES, 'UTF-8', true);?>
px; margin-bottom: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['bottom_margin']->value, ENT_QUOTES, 'UTF-8', true);?>
px; width:<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['image_width'], ENT_QUOTES, 'UTF-8', true);?>
px; height: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['image_height'], ENT_QUOTES, 'UTF-8', true);?>
px">
							<?php if (htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['url'], ENT_QUOTES, 'UTF-8', true)!='') {?>
								<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['url'], ENT_QUOTES, 'UTF-8', true);?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
" <?php if (htmlspecialchars($_smarty_tpl->tpl_vars['animate']->value, ENT_QUOTES, 'UTF-8', true)==1) {?>class="animate"<?php }?>>
							<?php }?>
									<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['image'], ENT_QUOTES, 'UTF-8', true);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['legend'], ENT_QUOTES, 'UTF-8', true);?>
" width="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['image_width'], ENT_QUOTES, 'UTF-8', true);?>
" height="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['image_height'], ENT_QUOTES, 'UTF-8', true);?>
" style="display: block;"/>
							 <?php if (htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['url'], ENT_QUOTES, 'UTF-8', true)!='') {?>
								</a>
							<?php }?>    
						</li>
					<?php } ?>
				</ul>
				<script type="text/javascript">
					var margin_animation = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['animate_px']->value, ENT_QUOTES, 'UTF-8', true);?>
;
				</script>   
			</div>
		</div>
    </div>
</div>
<?php }?><?php }} ?>
