<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:28:21
         compiled from "/raid/www/blf/modules/addcartpopup/views/templates/hook/addcartpopup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7164991735819dbe5524670-19155545%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '71445a0f5cba4f089086b3047f849437618e16a8' => 
    array (
      0 => '/raid/www/blf/modules/addcartpopup/views/templates/hook/addcartpopup.tpl',
      1 => 1476365414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7164991735819dbe5524670-19155545',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'animate' => 0,
    'background_color' => 0,
    'font_color' => 0,
    'message_font_color' => 0,
    'basket_background_color' => 0,
    'basket_font_color' => 0,
    'basket_hover_color' => 0,
    'continue_background_color' => 0,
    'continue_font_color' => 0,
    'continue_hover_color' => 0,
    'product' => 0,
    'image' => 0,
    'link' => 0,
    'productPrice' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dbe5586da8_35854836',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dbe5586da8_35854836')) {function content_5819dbe5586da8_35854836($_smarty_tpl) {?>
<script type="text/javascript">
    var animate = <?php echo $_smarty_tpl->tpl_vars['animate']->value;?>
; 
</script>

<style>
    #popup-cart #popup-cart-inner {
        background-color: <?php echo $_smarty_tpl->tpl_vars['background_color']->value;?>
; 
        color: <?php echo $_smarty_tpl->tpl_vars['font_color']->value;?>
;
    }
    
    #popup-cart #result {
        color: <?php echo $_smarty_tpl->tpl_vars['message_font_color']->value;?>
;
    }
    
    #popup-cart #order {
        background-color: <?php echo $_smarty_tpl->tpl_vars['basket_background_color']->value;?>
;
        color: <?php echo $_smarty_tpl->tpl_vars['basket_font_color']->value;?>

    }
    
    #popup-cart #order:hover {
        background-color: <?php echo $_smarty_tpl->tpl_vars['basket_hover_color']->value;?>
;
    }
    
    #popup-cart #continu {
        background-color: <?php echo $_smarty_tpl->tpl_vars['continue_background_color']->value;?>
;
        color: <?php echo $_smarty_tpl->tpl_vars['continue_font_color']->value;?>

    }
    
    #popup-cart #continu:hover {
        background-color: <?php echo $_smarty_tpl->tpl_vars['continue_hover_color']->value;?>
;
    }
</style>

<div id="popup-cart">
    <div id="popup-cart-inner">
        <p id="result"><?php echo smartyTranslate(array('s'=>'You have just added this item to your cart','mod'=>'addcartpopup'),$_smarty_tpl);?>
</p>
        <img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['product']->value->link_rewrite,$_smarty_tpl->tpl_vars['image']->value['id_image']);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value->name;?>
" />
        <div id="link">
            <a id="order" href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink(((string)$_smarty_tpl->tpl_vars['order_process']->value),true), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo smartyTranslate(array('s'=>'Complete your order','mod'=>'addcartpopup'),$_smarty_tpl);?>
</a>
            <a id="continu" href=""><?php echo smartyTranslate(array('s'=>'Continue shopping','mod'=>'addcartpopup'),$_smarty_tpl);?>
</a>
        </div>
        <p><?php echo $_smarty_tpl->tpl_vars['product']->value->name;?>
</p>
        <p id="price"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['productPrice']->value),$_smarty_tpl);?>
</p>
    </div>
</div><?php }} ?>
