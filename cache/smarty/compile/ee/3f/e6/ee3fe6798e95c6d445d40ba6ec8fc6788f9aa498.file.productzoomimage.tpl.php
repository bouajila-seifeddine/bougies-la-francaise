<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:55:01
         compiled from "/home/bougies-la-francaise/public_html/modules/productzoomimage/views/templates/hook/productzoomimage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:657930222582d8c85608736-76474072%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee3fe6798e95c6d445d40ba6ec8fc6788f9aa498' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/productzoomimage/views/templates/hook/productzoomimage.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '657930222582d8c85608736-76474072',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'images' => 0,
    'product' => 0,
    'image' => 0,
    'imageIds' => 0,
    'link' => 0,
    'vertical_position' => 0,
    'horizontal_position' => 0,
    'background' => 0,
    'color' => 0,
    'productPrice' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d8c8563a737_18181648',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c8563a737_18181648')) {function content_582d8c8563a737_18181648($_smarty_tpl) {?>
<!--Gallery Fullscreen*********************************-->
<div id="productzoomimage">
    <ul id="gallery-full">
        <?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value) {
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['i']->value = $_smarty_tpl->tpl_vars['image']->key;
?>
            <?php $_smarty_tpl->tpl_vars['imageIds'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['product']->value->id)."-".((string)$_smarty_tpl->tpl_vars['image']->value['id_image']), null, 0);?>
            <li><img data-src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value->link_rewrite,$_smarty_tpl->tpl_vars['imageIds']->value);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['legend']);?>
" /></li>
        <?php } ?>
    </ul>
    
    <ul id="gallery-small" class="<?php echo $_smarty_tpl->tpl_vars['vertical_position']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['horizontal_position']->value;?>
">
        <?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value) {
$_smarty_tpl->tpl_vars['image']->_loop = true;
?>
            <?php $_smarty_tpl->tpl_vars['imageIds'] = new Smarty_variable(((string)$_smarty_tpl->tpl_vars['product']->value->id)."-".((string)$_smarty_tpl->tpl_vars['image']->value['id_image']), null, 0);?>
            <li style="background: <?php echo $_smarty_tpl->tpl_vars['background']->value;?>
;">
                <img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value->link_rewrite,$_smarty_tpl->tpl_vars['imageIds']->value);?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image']->value['legend']);?>
"/>
            </li>
        <?php } ?>
    </ul>

    <div id="gallery-detail" class="<?php echo $_smarty_tpl->tpl_vars['vertical_position']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['horizontal_position']->value;?>
" style="background: <?php echo $_smarty_tpl->tpl_vars['background']->value;?>
;">
        <p style="color: <?php echo $_smarty_tpl->tpl_vars['color']->value;?>
;"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['product']->value->name, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</p>
        <p class="price" style="color: <?php echo $_smarty_tpl->tpl_vars['color']->value;?>
;"><strong><?php echo smartyTranslate(array('s'=>'Price','mod'=>'productzoomimage'),$_smarty_tpl);?>
</strong><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['productPrice']->value),$_smarty_tpl);?>
</p>
        <a href="#" id="gallery-close" title="<?php echo smartyTranslate(array('s'=>'Close','mod'=>'productzoomimage'),$_smarty_tpl);?>
"></a>
    </div>

    <div id="gallery-loader"></div>
</div><?php }} ?>
