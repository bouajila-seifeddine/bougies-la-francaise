{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{if isset($products)}
	<!-- Products list -->
	<ul class="product_list clear">
	{foreach from=$products item=product name=products}
        
        {foreach from=$product.features item=feature}
            {if $feature.name == "Collection"}
                {assign var='collection' value=$feature.value}
            {/if}
        {/foreach}
        
		<li class="ajax_block_product {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if} {if $smarty.foreach.products.index % 2}alternate_item{else}item{/if} clearfix">
			<div class="img_product">
			    <img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'product_list_zoom')|escape:'html'}" alt="{if !empty($product.legend)}{$product.legend|escape:'htmlall':'UTF-8'}{elseif !empty($product.name)}{$product.name|escape:'htmlall':'UTF-8'}{/if}" />
			</div>
			<div class="content_product">
			    {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
                    {if $product.specific_prices.reduction_type == 'percentage'}<span class="reduction">-{$product.specific_prices.reduction*100} %</span>{/if}
                    {if $product.specific_prices.reduction_type == 'amount'}<span class="reduction">-{$product.specific_prices.reduction|string_format:"%.2f"} €</span>{/if}
                {/if}
                
			    <p>{if isset($collection)}{$collection}{/if}</p>
			    {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
                    {if $product.reduction}<h6><strike class="original-price">{convertPrice price=$product.price_without_reduction}</strike></h6>{/if}
                {/if}
                <h4 id="upsale">{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}<a class="big-link" href="{$product.link|escape:'htmlall':'UTF-8'}">{$product.name|truncate:100:'...'|escape:'htmlall':'UTF-8'}</a></h4>
                {if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
                    {if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}<p id="upsale2" class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</p>{/if}
                {/if}
            </div>
			{if isset($product.new) && $product.new == 1}<span class="new">{l s='New'}</span>{/if}
		</li>
	{/foreach}
	</ul>
	<!-- /Products list -->
{/if}

<script>
	var ecomm_pagetype = 'category';
</script>