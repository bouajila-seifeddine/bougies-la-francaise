
{capture name=path}
	<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}">
		{l s='My account' mod='favoriteproducts'}</a>
		<span class="navigation-pipe">{$navigationPipe}</span>{l s='My favorite products.' mod='favoriteproducts'}
{/capture}

{include file="$tpl_dir./breadcrumb.tpl"}

<div id="favoriteproducts_block_account">
	<h2>{l s='My favorite products.' mod='favoriteproducts'}</h2>
	
    {if $favoriteProducts}
        <ul class="product_list clear">
            {foreach from=$favoriteProducts item=favoriteProduct}
                <li class="ajax_block_product {if $smarty.foreach.favoriteProduct.first}first_item{elseif $smarty.foreach.favoriteProduct.last}last_item{/if} {if $smarty.foreach.favoriteProduct.index % 2}alternate_item{else}item{/if} clearfix">
                    <div class="img_product">
                        <img src="{$link->getImageLink($favoriteProduct.link_rewrite, $favoriteProduct.id_image, 'product_list_zoom')|escape:'html'}" />
                    </div>
                    <div class="content_product">
                        <h3><a class="big-link" href="{$link->getProductLink($favoriteProduct.id_product, null, null, null, null, $favoriteProduct.id_shop)|escape:'html':'UTF-8'}">{$favoriteProduct.name|escape:'html':'UTF-8'}</a></h3>
                    </div>
                    <div class="remove">
                        <img rel="ajax_id_favoriteproduct_{$favoriteProduct.id_product}" src="{$img_dir}icon/delete-cart.png" alt="" class="icon" />
                    </div>
                </li>
            {/foreach} 
        </ul>
	{else}
		<p class="warning">{l s='No favorite products have been determined just yet. ' mod='favoriteproducts'}</p>
	{/if}
</div>