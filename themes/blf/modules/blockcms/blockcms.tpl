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

{if $block == 1}
	<!-- Block CMS module -->
	{foreach from=$cms_titles key=cms_key item=cms_title}
		<div id="informations_block_left_{$cms_key}" class="block informations_block_left">
			<p class="title_block"><a href="{$cms_title.category_link|escape:'html'}">{if !empty($cms_title.name)}{$cms_title.name}{else}{$cms_title.category_name}{/if}</a></p>
			<ul class="block_content">
				{foreach from=$cms_title.categories item=cms_page}
					{if isset($cms_page.link)}<li class="bullet"><b style="margin-left:2em;">
					<a href="{$cms_page.link|escape:'html'}">{$cms_page.name|escape:html:'UTF-8'}</a>
					</b></li>{/if}
				{/foreach}
				{foreach from=$cms_title.cms item=cms_page}
					{if isset($cms_page.link)}<li><a href="{$cms_page.link|escape:'html'}">{$cms_page.meta_title|escape:html:'UTF-8'}</a></li>{/if}
				{/foreach}
				{if $cms_title.display_store}<li><a href="{$link->getPageLink('stores')|escape:'html'}">{l s='Our stores' mod='blockcms'}</a></li>{/if}
			</ul>
		</div>
	{/foreach}
	<!-- /Block CMS module -->
{else}
	<!-- MODULE Block footer -->
    <ul class="footer-link">
        <li class="header"><h3>{l s='Information' mod='blockcms'}</h3></li>
        {if !$PS_CATALOG_MODE}<li><a href="{$link->getPageLink('prices-drop')|escape:'html'}">{l s='Specials' mod='blockcms'}</a></li>{/if}
        <li><a href="{$link->getPageLink('new-products')|escape:'html'}">{l s='New products' mod='blockcms'}</a></li>
        {if !$PS_CATALOG_MODE}<li><a href="{$link->getPageLink('best-sales')|escape:'html'}">{l s='Top sellers' mod='blockcms'}</a></li>{/if}
        {if $display_stores_footer}<li><a href="{$link->getPageLink('stores')|escape:'html'}">{l s='Our stores' mod='blockcms'}</a></li>{/if}
        <li><a href="{$link->getPageLink($contact_url, true)|escape:'html'}">{l s='Contact us' mod='blockcms'}</a></li>
        <li><a href="{$link->getPageLink('sitemap')|escape:'html'}">{l s='Sitemap' mod='blockcms'}</a></li>
    </ul>

    {foreach from=$cmslinks key=i item=cmslink name=cms}
        {if !$smarty.foreach.cms.first && ($i|substr:0:1) == 1}
            </ul>
        {/if}
        {if ($i|substr:0:1) == 1}
            <ul class="footer-link">
        {/if}
            {if ($i|substr:0:1) == 1}
                <li class="header"><h3>{$cmslink.meta_title|escape:'htmlall':'UTF-8'}</h3></li>
            {else}
                <li><a href="{$cmslink.link|addslashes|escape:'html'}">{$cmslink.meta_title|escape:'htmlall':'UTF-8'}</a></li>
            {/if}
        {if $smarty.foreach.cms.last}
            </ul>
        {/if}
    {/foreach}
    {$footer_text}
	<!-- /MODULE Block footer -->
{/if}
