{*
* 2007-2016 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="col-sm-6">
	<!-- Block CMS module -->
		<section id="blf_blockcms_custom_{$cms_key}" class="block blf-cms-custom-footer-1">
			<div class="block_content footer-cms-list">
				<div class="blf-footer-logo"><img src="/themes/bougie-la-francaise/image/design/blf-logo-footer.jpg" alt="Bougie la Française" /></div>
				<ul>
					{foreach from=$cmslinks item=cmslink}
						{if $cmslink.meta_title != ''}
							<li class="item">
								<a href="{$cmslink.link|escape:'html':'UTF-8'}" title="{$cmslink.meta_title|escape:'html':'UTF-8'}">
									{$cmslink.meta_title|escape:'html':'UTF-8'}
								</a>
							</li>
						{/if}
					{/foreach}
					{if isset($display_stores_footer) && $display_stores_footer}
						<li class="item">
							<a href="{$link->getPageLink('stores')|escape:'html':'UTF-8'}" title="{l s='Our stores' mod='blockcms'}">
								{l s='Our stores' mod='blockcms'}
							</a>
						</li>
					{/if}
				</ul>
			</div>
		</section>
	<!-- /Block CMS module -->
</div>