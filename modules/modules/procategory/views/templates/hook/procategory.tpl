<style>
.owl-theme #owl-example-category .owl-controls .owl-buttons div,
.owl-theme .owl-controls .owl-page span{
	background: {$proconfigcategorycolor6};
}
div.star.star_on:after{
	color: {$proconfigcategorycolor9};
}
.pro-category.block .title_block{
	border: none;
	background: {$proconfigcategorycolor10};
	color: {$proconfigcategorycolor3};
}
.owl-theme #owl-example-category h5{
	color: {$proconfigcategorycolor1};
}
.owl-theme #owl-example-category.owl-carousel .owl-item .wrap-category p{
	color: {$proconfigcategorycolor2};
}
</style>
<div class="clearfix"></div>
<div class="cat_carousel responsive clearfix" >

<div class="pro-category block">
   {if $proconfigcategoryradio7 ==1 } <p class="title_block">{l s ='Our Category' mod='procategory'}</p>{/if}
<div class="row">
<div class="span12">
		<div class="carousel owl-theme">
			<ul id="owl-example-category" class="owl-carousel owl-origin">
                 {foreach from=$categories item=category name=homeCategories}
                 <li class="item  ajax_block_product clearfix {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if} {if $smarty.foreach.products.index % 2}alternate_item{else}item{/if}">
                  		<div class="wrap-category">
                        <a href="{$link->getcategoryLink($category.id_category, $category.link_rewrite)}" title="{$category.name|truncate:35}"  class="lnk_img">
       		{if $proconfigcategoryradio1 ==1 } <img alt="{$category.name|truncate:35}" src="{$img_cat_dir}{$category.id_category}.jpg"  />{/if}
  
            <div class="box-cat">
            {if $proconfigcategoryradio4 ==1 }
                <h5>{$category.name|truncate:35}</h5>
                {/if}
                {if $proconfigcategoryradio6 ==1 }
                <p class="category-desc">{$category.description|truncate:100}</p>
                {/if}
            </div>
                  </a>
            </div>
                </li>
       	 {/foreach}
		</ul>
	</div>
    </div>
    </div>
</div>
<script type="text/javascript">		
		{literal}
$("#owl-example-category").owlCarousel({

    // Most important owl features
    items : {/literal}{$proconfigcategoryinput2}{literal},
    itemsCustom : false,
    itemsDesktop : [1199,{/literal}{$proconfigcategoryinput3}{literal}],
    itemsDesktopSmall : [980,{/literal}{$proconfigcategoryinput1}{literal}],
    itemsTablet: [768,{/literal}{$proconfigcategoryinput4}{literal}],
    itemsTabletSmall: false,
    itemsMobile : [479,{/literal}{$proconfigcategoryinput5}{literal}],
    singleItem : false,
    itemsScaleUp : false,

    //Basic Speeds
    slideSpeed : {/literal}{$proconfigcategoryinput6}{literal},
    paginationSpeed : {/literal}{$proconfigcategoryinput7}{literal},
    rewindSpeed : {/literal}{$proconfigcategoryinput8}{literal},

    //Autoplay
    autoPlay : {/literal}{if $proconfigcategoryradio16 ==1 }true {else}false{/if}{literal},
    stopOnHover : {/literal}{if $proconfigcategoryradio17 ==1 }true {else}false{/if}{literal},

    // Navigation
    navigation : {/literal}{if $proconfigcategoryradio14 ==1 }true {else}false{/if}{literal},
    navigationText : ["prev","next"],
    rewindNav : true,
    scrollPerPage : true,

    //Pagination
    pagination : {/literal}{if $proconfigcategoryradio15 ==1 }true {else}false{/if}{literal},
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
    mouseDrag : {/literal}{if $proconfigcategoryradio18 ==1 }true {else}false{/if}{literal},
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
		{/literal}
</script>