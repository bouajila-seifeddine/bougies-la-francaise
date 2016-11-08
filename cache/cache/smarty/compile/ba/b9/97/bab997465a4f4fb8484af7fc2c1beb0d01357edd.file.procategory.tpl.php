<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:44
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/procategory/views/templates/hook/procategory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1480199420581a1298e5aed4-15680120%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bab997465a4f4fb8484af7fc2c1beb0d01357edd' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/procategory/views/templates/hook/procategory.tpl',
      1 => 1477584709,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1480199420581a1298e5aed4-15680120',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'proconfigcategorycolor6' => 0,
    'proconfigcategorycolor9' => 0,
    'proconfigcategorycolor10' => 0,
    'proconfigcategorycolor3' => 0,
    'proconfigcategorycolor1' => 0,
    'proconfigcategorycolor2' => 0,
    'proconfigcategoryradio7' => 0,
    'categories' => 0,
    'category' => 0,
    'link' => 0,
    'proconfigcategoryradio1' => 0,
    'img_cat_dir' => 0,
    'proconfigcategoryradio4' => 0,
    'proconfigcategoryradio6' => 0,
    'proconfigcategoryinput2' => 0,
    'proconfigcategoryinput3' => 0,
    'proconfigcategoryinput1' => 0,
    'proconfigcategoryinput4' => 0,
    'proconfigcategoryinput5' => 0,
    'proconfigcategoryinput6' => 0,
    'proconfigcategoryinput7' => 0,
    'proconfigcategoryinput8' => 0,
    'proconfigcategoryradio16' => 0,
    'proconfigcategoryradio17' => 0,
    'proconfigcategoryradio14' => 0,
    'proconfigcategoryradio15' => 0,
    'proconfigcategoryradio18' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a1298f2f708_07022518',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a1298f2f708_07022518')) {function content_581a1298f2f708_07022518($_smarty_tpl) {?><style>
.owl-theme #owl-example-category .owl-controls .owl-buttons div,
.owl-theme .owl-controls .owl-page span{
	background: <?php echo $_smarty_tpl->tpl_vars['proconfigcategorycolor6']->value;?>
;
}
div.star.star_on:after{
	color: <?php echo $_smarty_tpl->tpl_vars['proconfigcategorycolor9']->value;?>
;
}
.pro-category.block .title_block{
	border: none;
	background: <?php echo $_smarty_tpl->tpl_vars['proconfigcategorycolor10']->value;?>
;
	color: <?php echo $_smarty_tpl->tpl_vars['proconfigcategorycolor3']->value;?>
;
}
.owl-theme #owl-example-category h5{
	color: <?php echo $_smarty_tpl->tpl_vars['proconfigcategorycolor1']->value;?>
;
}
.owl-theme #owl-example-category.owl-carousel .owl-item .wrap-category p{
	color: <?php echo $_smarty_tpl->tpl_vars['proconfigcategorycolor2']->value;?>
;
}
</style>
<div class="clearfix"></div>
<div class="cat_carousel responsive clearfix" >

<div class="pro-category block">
	<?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio7']->value==1) {?> 
		<h2 class="blf-title"><?php echo smartyTranslate(array('s'=>'Our Collections','mod'=>'procategory'),$_smarty_tpl);?>
</h2>
	<?php }?>
    <div class="row">
        <div class="span12">
    		<div class="carousel owl-theme">
    			<ul id="owl-example-category" class="owl-carousel owl-origin">
                    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['category']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['category']->iteration=0;
 $_smarty_tpl->tpl_vars['category']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['category']->key;
 $_smarty_tpl->tpl_vars['category']->iteration++;
 $_smarty_tpl->tpl_vars['category']->index++;
 $_smarty_tpl->tpl_vars['category']->first = $_smarty_tpl->tpl_vars['category']->index === 0;
 $_smarty_tpl->tpl_vars['category']->last = $_smarty_tpl->tpl_vars['category']->iteration === $_smarty_tpl->tpl_vars['category']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['homeCategories']['first'] = $_smarty_tpl->tpl_vars['category']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['homeCategories']['last'] = $_smarty_tpl->tpl_vars['category']->last;
?>
                        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['homeCategories']['last']) {?>
                            <li class="item  ajax_block_product clearfix <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['first']) {?>first_item<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['last']) {?>last_item<?php }?> <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%2) {?>alternate_item<?php } else { ?>item<?php }?>">
                                <div class="wrap-category">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category'],$_smarty_tpl->tpl_vars['category']->value['link_rewrite']);?>
" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
"  class="lnk_img">
                                    <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio1']->value==1) {?> <img alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
" src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['category']->value['id_category'];?>
.jpg"  /><?php }?>
                                    </a>
                                    <div class="box-cat">
                                        <div>
                                            <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio4']->value==1) {?>
                                                <h5><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
</h5>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio6']->value==1) {?>
                                                <div class="category-desc">
                                                    <?php echo $_smarty_tpl->tpl_vars['category']->value['description'];?>

                                                    <a class="collection-products-link" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category'],$_smarty_tpl->tpl_vars['category']->value['link_rewrite']);?>
">
                                                        <?php echo smartyTranslate(array('s'=>'Show products','mod'=>'procategory'),$_smarty_tpl);?>

                                                    </a>
                                                    
                                                </div>
                                                
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php }?>
                    <?php } ?>

                    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['category']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['category']->iteration=0;
 $_smarty_tpl->tpl_vars['category']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['category']->key;
 $_smarty_tpl->tpl_vars['category']->iteration++;
 $_smarty_tpl->tpl_vars['category']->index++;
 $_smarty_tpl->tpl_vars['category']->first = $_smarty_tpl->tpl_vars['category']->index === 0;
 $_smarty_tpl->tpl_vars['category']->last = $_smarty_tpl->tpl_vars['category']->iteration === $_smarty_tpl->tpl_vars['category']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['homeCategories']['first'] = $_smarty_tpl->tpl_vars['category']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['homeCategories']['last'] = $_smarty_tpl->tpl_vars['category']->last;
?>
                         <li class="item  ajax_block_product clearfix <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['first']) {?>first_item<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['last']) {?>last_item<?php }?> <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%2) {?>alternate_item<?php } else { ?>item<?php }?>">
                          	<div class="wrap-category">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category'],$_smarty_tpl->tpl_vars['category']->value['link_rewrite']);?>
" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
"  class="lnk_img">
        						<?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio1']->value==1) {?> <img alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
" src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['category']->value['id_category'];?>
.jpg"  /><?php }?>
        						</a>
        						<div class="box-cat">
        							<div>
        								<?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio4']->value==1) {?>
        									<h5><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
</h5>
        								<?php }?>
        								<?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio6']->value==1) {?>
        									<div class="category-desc">
        										<?php echo $_smarty_tpl->tpl_vars['category']->value['description'];?>

        										<a class="collection-products-link" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category'],$_smarty_tpl->tpl_vars['category']->value['link_rewrite']);?>
">
        											<?php echo smartyTranslate(array('s'=>'Show products','mod'=>'procategory'),$_smarty_tpl);?>

        										</a>
        										
        									</div>
        									
        								<?php }?>
        							</div>
        						</div>
        					</div>
                        </li>
           	        <?php } ?>

                    <?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['category']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['category']->iteration=0;
 $_smarty_tpl->tpl_vars['category']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value) {
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['category']->key;
 $_smarty_tpl->tpl_vars['category']->iteration++;
 $_smarty_tpl->tpl_vars['category']->index++;
 $_smarty_tpl->tpl_vars['category']->first = $_smarty_tpl->tpl_vars['category']->index === 0;
 $_smarty_tpl->tpl_vars['category']->last = $_smarty_tpl->tpl_vars['category']->iteration === $_smarty_tpl->tpl_vars['category']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['homeCategories']['first'] = $_smarty_tpl->tpl_vars['category']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['homeCategories']['last'] = $_smarty_tpl->tpl_vars['category']->last;
?>
                        <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['homeCategories']['first']) {?>
                            <li class="item  ajax_block_product clearfix <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['first']) {?>first_item<?php } elseif ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['last']) {?>last_item<?php }?> <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['products']['index']%2) {?>alternate_item<?php } else { ?>item<?php }?>">
                                <div class="wrap-category">
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category'],$_smarty_tpl->tpl_vars['category']->value['link_rewrite']);?>
" title="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
"  class="lnk_img">
                                    <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio1']->value==1) {?> <img alt="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
" src="<?php echo $_smarty_tpl->tpl_vars['img_cat_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['category']->value['id_category'];?>
.jpg"  /><?php }?>
                                    </a>
                                    <div class="box-cat">
                                        <div>
                                            <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio4']->value==1) {?>
                                                <h5><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_MODIFIER]['truncate'][0][0]->smarty_modifier_truncate($_smarty_tpl->tpl_vars['category']->value['name'],35);?>
</h5>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio6']->value==1) {?>
                                                <div class="category-desc">
                                                    <?php echo $_smarty_tpl->tpl_vars['category']->value['description'];?>

                                                    <a class="collection-products-link" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getcategoryLink($_smarty_tpl->tpl_vars['category']->value['id_category'],$_smarty_tpl->tpl_vars['category']->value['link_rewrite']);?>
">
                                                        <?php echo smartyTranslate(array('s'=>'Show products','mod'=>'procategory'),$_smarty_tpl);?>

                                                    </a>
                                                    
                                                </div>
                                                
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php }?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">		
		
$("#owl-example-category").owlCarousel({

    // Most important owl features
    items : <?php echo $_smarty_tpl->tpl_vars['proconfigcategoryinput2']->value;?>
,
    itemsCustom : false,
    itemsDesktop : [1199,<?php echo $_smarty_tpl->tpl_vars['proconfigcategoryinput3']->value;?>
],
    itemsDesktopSmall : [980,<?php echo $_smarty_tpl->tpl_vars['proconfigcategoryinput1']->value;?>
],
    itemsTablet: [768,<?php echo $_smarty_tpl->tpl_vars['proconfigcategoryinput4']->value;?>
],
    itemsTabletSmall: false,
    itemsMobile : [479,<?php echo $_smarty_tpl->tpl_vars['proconfigcategoryinput5']->value;?>
],
    singleItem : false,
    itemsScaleUp : false,

    //Basic Speeds
    slideSpeed : <?php echo $_smarty_tpl->tpl_vars['proconfigcategoryinput6']->value;?>
,
    paginationSpeed : <?php echo $_smarty_tpl->tpl_vars['proconfigcategoryinput7']->value;?>
,
    rewindSpeed : <?php echo $_smarty_tpl->tpl_vars['proconfigcategoryinput8']->value;?>
,

    //Autoplay
    autoPlay : <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio16']->value==1) {?>true <?php } else { ?>false<?php }?>,
    stopOnHover : <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio17']->value==1) {?>true <?php } else { ?>false<?php }?>,

    // Navigation
    navigation : <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio14']->value==1) {?>true <?php } else { ?>false<?php }?>,
    navigationText : ["",""],
    rewindNav : true,
    scrollPerPage : false,

    //Pagination
    pagination : <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio15']->value==1) {?>true <?php } else { ?>false<?php }?>,
    paginationNumbers: false,

    // Responsive 
    responsive: true,
    responsiveRefreshRate : 200,
    responsiveBaseWidth: window,

    // CSS Styles
    baseClass : "owl-carousel",
    theme : "owl-theme",

    //Lazy load
    lazyLoad : false,
    lazyFollow : false,
    lazyEffect : "fade",

    //Auto height
    autoHeight : false,

    //JSON 
    jsonPath : false, 
    jsonSuccess : false,

    //Mouse Events
    dragBeforeAnimFinish : false,
    mouseDrag : <?php if ($_smarty_tpl->tpl_vars['proconfigcategoryradio18']->value==1) {?>true <?php } else { ?>false<?php }?>,
    touchDrag : true,

    //Transitions
    transitionStyle : true,

    // Other
    addClassActive : false,

    //Callbacks
    beforeUpdate : false,
    afterUpdate : false,
    beforeInit: false, 
    afterInit: false, 
    beforeMove: false, 
    afterMove: false,
    afterAction: false,
    startDragging : false,
    afterLazyLoad : false

})
		
</script><?php }} ?>
