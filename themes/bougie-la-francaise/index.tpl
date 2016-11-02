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

{if isset($HOOK_HOME) && $HOOK_HOME|trim}
	<div class="clearfix">{$HOOK_HOME}</div>
{/if}
<div id="home-century" class="home-static-content">
	<div class="century-pattern"></div>
	<div class="century-faded-logo">
		<div class="container">
			<img src="/themes/bougie-la-francaise/image/design/logo-entreprise-familiale-centenaire.png" alt="Entreprise familiale centenaire" />
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="text-intro">
				<div class="century-title">
					<h1 class="dragoniscoming">{l s='Bougies la Française'}</h1>
					<div class="dragoniscoming">{l s='un siècle'}</div>
					<span>{l s='a century of passion'}</span>
				</div>
				<h3>
					{l s='of expertise bayberry'}
					<br />{l s='and perfumer spirit'}
				</h3>
			</div>
			<div class="col-md-4">
				<div class="century-block">
					<a href="{$link->getCMSLink(6, $cms->link_rewrite)|escape:'html':'UTF-8'}" class="century-block-text">
						<h4>{l s='century block 1 title'}</h4>
						<p>{l s='century block 1 text'}</p>
					</a>
					<div class="picture" style="background-image:url(/themes/bougie-la-francaise/image/design/century-01.jpg);">
						<img src="/themes/bougie-la-francaise/image/design/century-01.jpg" alt="" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="century-block">
					<a href="{$link->getCMSLink(7, $cms->link_rewrite)|escape:'html':'UTF-8'}" class="century-block-text">
						<h4>{l s='century block 2 title'}</h4>
						<p>{l s='century block 2 text'}</p>
					</a>
					<div class="picture" style="background-image:url(/themes/bougie-la-francaise/image/design/century-02.jpg);">
						<img src="/themes/bougie-la-francaise/image/design/century-02.jpg" alt="" />
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="century-block">
					<a href="{$link->getCMSLink(8, $cms->link_rewrite)|escape:'html':'UTF-8'}" class="century-block-text">
						<h4>{l s='century block 3 title'}</h4>
						<p>{l s='century block 3 text'}</p>
					</a>
					<div class="picture" style="background-image:url(/themes/bougie-la-francaise/image/design/century-03.jpg);">
						<img src="/themes/bougie-la-francaise/image/design/century-03.jpg" alt="" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="home-collections">
	{hook h='customSliderCollections'}
</div>
<div id="home-parfum" class="home-static-content">
	<div class="container-fluid">
		<h2 class="blf-title">{l s='Our fragant worlds'}</h2>
		<div class="row">
			<div class="col-sm-4">
				
				<a href="{$link->getCategoryLink(43, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block floral">
					<div class="parfum-name">
						<h3>{l s='Floral'}</h3>
					</div>
				</a>
				<a href="{$link->getCategoryLink(88, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block powder">
					<div class="parfum-name">
						<h3>{l s='Powder'}</h3>
					</div>
				</a>
				<a href="{$link->getCategoryLink(46, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block regressive">
					<div class="parfum-name">
						<h3>{l s='Regressive'}</h3>
					</div>
				</a>
			</div>
			
			<div class="col-sm-4">
				<a href="{$link->getCategoryLink(49, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block spicy">
					<div class="parfum-name">
						<h3>{l s='Spicy'}</h3>
					</div>
				</a>
				<a href="{$link->getCategoryLink(44, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block wooded">
					<div class="parfum-name">
						<h3>{l s='Wooded'}</h3>
					</div>
				</a>
				<a href="{$link->getCategoryLink(45, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block oriental">
					<div class="parfum-name">
						<h3>{l s='Oriental'}</h3>
					</div>
				</a>
			</div>
			
			<div class="col-sm-4">
				<a href="{$link->getCategoryLink(42, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block gourmand">
					<div class="parfum-name">
						<h3>{l s='Gourmand'}</h3>
					</div>
				</a>
				<a href="{$link->getCategoryLink(47, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block fruity">
					<div class="parfum-name">
						<h3>{l s='Fruity'}</h3>
					</div>
				</a>
				<a href="{$link->getCategoryLink(48, $category->link_rewrite)|escape:'html':'UTF-8'}" class="parfum-block citrus">
					<div class="parfum-name">
						<h3>{l s='Citrus'}</h3>
					</div>
				</a>
			</div>
			
		</div>
	</div>
</div>
<div class="container" id="tab_content">
	<div class="row">
	{if isset($HOOK_HOME_TAB_CONTENT) && $HOOK_HOME_TAB_CONTENT|trim}
		{if isset($HOOK_HOME_TAB) && $HOOK_HOME_TAB|trim}
			{*<!-- <ul id="home-page-tabs" class="nav nav-tabs clearfix"> -->*}
				{$HOOK_HOME_TAB}
			{*<!-- </ul> -->*}
		{/if}
		<div class="tab-content">{$HOOK_HOME_TAB_CONTENT}</div>
	{/if}
	</div>
</div>
<div id="home-private-label" class="home-static-content">
	<div class="container-fluid">
		<div class="row">
			<div class="etiquette">
				<div class="etiquette-content">
					<h2>{l s='Private label'}</h2>
					<p>
						{l s='A high craftsmanship tradition'}
						<br />{l s='for your bespoke projects...'}
					</p>
					<p><a href="http://www.blf-privatelabel.com" target="_blank">{l s='Discover our services'}</a></p>
				</div>
			</div>
			<div class="col-xs-6 side left"></div>
			<div class="col-xs-6 side right"></div>
		</div>
	</div>
</div>