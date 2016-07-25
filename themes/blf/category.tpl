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

{include file="$tpl_dir./breadcrumb.tpl"}
{include file="$tpl_dir./errors.tpl"}

{if isset($category)}
	{if $category->id AND $category->active}
						
		{if $scenes || $category->description || $category->id_image}
		    
		    <div id="header_category">
    		        
                <div class="cat_desc">
                    <h1>
                        {strip}
                            {$category->name|escape:'htmlall':'UTF-8'}
                            {if isset($categoryNameComplement)}
                                {$categoryNameComplement|escape:'htmlall':'UTF-8'}
                            {/if}
                        {/strip}
                    </h1>
                    {if $category->description}{$category->description}{/if}
                </div>
                
    			{if $scenes}
    				<!-- Scenes -->
    				{include file="$tpl_dir./scenes.tpl" scenes=$scenes}
    			{else}
    				<!-- Category image -->
    				{if $category->id_image}
    				<div class="cat_img">
    					<img src="{$link->getCatImageLink($category->link_rewrite, $category->id_image, 'category_default')|escape:'html'}" alt="{$category->name|escape:'htmlall':'UTF-8'}" id="categoryImage" width="{$categorySize.width}" height="{$categorySize.height}" />
    				</div>
    				{/if}
    			{/if}
			
			</div>

		{/if}
		
		<aside id="left-column">
            {$HOOK_LEFT_COLUMN}
        </aside>
        
        <article id="category_content">
        
    		{if $products}
    			<div class="content_sortPagiBar">
    			    {include file="./product-sort.tpl"}
    				{include file="$tpl_dir./pagination.tpl"}
    			</div>
    			
                {include file="./product-list.tpl" products=$products}
    			
    			{include file="./pagination.tpl" paginationId='bottom'}
            {else}
                <a href="{$link->getCMSLink(19)|escape:'html'}"><img src="{$base_dir}themes/blf/img/no-product.jpg" alt="" /></a>
    		{/if}
    		
		</article>
		
	{elseif $category->id}
		<p class="warning">{l s='This category is currently unavailable.'}</p>
	{/if}
{/if}