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
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9"{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}><![endif]-->
<html{if isset($language_code) && $language_code} lang="{$language_code|escape:'html':'UTF-8'}"{/if}>
	<head>
	<!-- Google Tag Manager -->
<script>{literal}(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WJ9895');{/literal}</script>
<!-- End Google Tag Manager -->
		<meta charset="utf-8" />
		<title>{$meta_title|escape:'html':'UTF-8'}</title>
		{if isset($meta_description) AND $meta_description}
			<meta name="description" content="{$meta_description|escape:'html':'UTF-8'}" />
		{/if}
		{if isset($meta_keywords) AND $meta_keywords}
			<meta name="keywords" content="{$meta_keywords|escape:'html':'UTF-8'}" />
		{/if}
		<meta name="generator" content="PrestaShop" />
		<meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
		<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />

	{if isset($smarty.get.p) && !empty($smarty.get.p)}
			{assign var="pagenumber" value={l s=' - Page  %1$d' sprintf=$smarty.get.p} }
			{assign var="pagination" value="?p={$smarty.get.p}" }
			{else}
			{assign var="pagenumber" value="" }
			{assign var="pagination" value="" }
		{/if}

		{assign 'pages_array' ['best-sales', 'new-products', 'adresses', '404', 'address', 'authentication', 'my-account', 'contact-form', 'discount', 'guest-tracking', 'index', 'history', 'manufacturer', 'order-opc', 'order-follow' ,'order-carrier' ,'order-payment', 'order-detail', 'order-slip', 'order-return', 'order-confirmation', 'order-address', 'password', 'search', 'prices-drop', 'sitemap', 'store-infos', 'stores', 'supplier-list', 'suppliers']}
		{assign 'noindex_pages_array' ['404', 'address', 'my-account', 'guest-tracking', 'order-opc', 'order-follow' ,'order-carrier' ,'order-payment', 'order-detail', 'order-slip', 'order-confirmation', 'order-address', 'cart', 'search', 'supplier-list', 'supplier', 'suppliers']}

		{if isset($smarty.server.REQUEST_URI)}
			{assign 'noindex_vars' ['noredirect','orderway','orderby','content_only']}
			{foreach from=$noindex_vars item=v}
				{if stristr($smarty.server.REQUEST_URI,$v) }
					{assign var=nobots value=true}
					{break}
				{/if}
			{/foreach}
		{/if}

		{if $page_name == 'product' && isset($product->id)}
			<link rel="canonical" href="{$link->getProductLink($product->id)}" />
		{elseif $page_name == 'manufacturer' && isset($manufacturer->id)}
			<link rel="canonical" href="{$link->getManufacturerLink($manufacturer->id)}{$pagination}" />
		{elseif $page_name == 'supplier' && isset($supplier->id)}
			<link rel="canonical" href="{$link->getSupplierLink($supplier->id)}{$pagination}" />
		{elseif $page_name == 'category' && isset($category->id)}
			<link rel="canonical" href="{$link->getCategoryLink($category->id)}{$pagination}" />
		{elseif in_array($page_name,$pages_array)}
			<link rel="canonical" href="{$link->getPageLink($page_name)}" />
		{elseif $page_name == 'cms' && isset($cms->id)}
			<link rel="canonical" href="{$link->getCmsLink($cms->id)}" />
		{else}

		{assign var=amn value=explode("-",$page_name)}
		{if strpos($page_name,"module-") !== false && count($amn) == 3}
			<link rel="canonical" href="{$link->getModuleLink($amn.1,$amn.2)}{$pagination}" />
		{else}
			<link rel="canonical" href="{$base_dir|replace:'.fr/':'.fr'|replace:'http':'https'}{$request_uri|regex_replace:'/\?(.*)/':''|replace:'index.php':''}{$pagination}" />
			{assign var=nobots value=true}
			{/if}
		{/if}

		{if in_array($page_name,$noindex_pages_array)}
		  {assign var=nobots value=true}
		{/if}

		<link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
		
		<link href="/themes/bougie-la-francaise/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
		
		{if isset($css_files)}
			{foreach from=$css_files key=css_uri item=media}
				{if $css_uri == 'lteIE9'}
					<!--[if lte IE 9]>
					{foreach from=$css_files[$css_uri] key=css_uriie9 item=mediaie9}
					<link rel="stylesheet" href="{$css_uriie9|escape:'html':'UTF-8'}" type="text/css" media="{$mediaie9|escape:'html':'UTF-8'}" />
					{/foreach}
					<![endif]-->
				{else}
					<link rel="stylesheet" href="{$css_uri|escape:'html':'UTF-8'}" type="text/css" media="{$media|escape:'html':'UTF-8'}" />
				{/if}
			{/foreach}
		{/if}
		{if isset($js_defer) && !$js_defer && isset($js_files) && isset($js_def)}
			{$js_def}
			{foreach from=$js_files item=js_uri}
			<script type="text/javascript" src="{$js_uri|escape:'html':'UTF-8'}"></script>
			{/foreach}
		{/if}
		{$HOOK_HEADER}
		<!--[if IE 8]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
	</head>
	<body{if isset($page_name)} id="{$page_name|escape:'html':'UTF-8'}"{/if} class="{if isset($page_name)}{$page_name|escape:'html':'UTF-8'}{/if}{if isset($body_classes) && $body_classes|@count} {implode value=$body_classes separator=' '}{/if}{if $hide_left_column} hide-left-column{else} show-left-column{/if}{if $hide_right_column} hide-right-column{else} show-right-column{/if}{if isset($content_only) && $content_only} content_only{/if} lang_{$lang_iso}">
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WJ9895"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- 
	<input name="tfh" type="hidden" value="{$page_name}"> -->
		{if $GTM_DATAS != ''}

		{if $page_name == "index" || $page_name == "category" || $page_name == "search" || $page_name == "product" || $page_name == "order" || $page_name == "my-account" || $page_name == "order-confirmation" || $page_name == "module-paypal-submit" }
			<script type="text/javascript">
				{literal}
					var USER_ID = {/literal}{if isset($GTM_DATAS.$page_name.USER_ID)}{$GTM_DATAS.$page_name.USER_ID}{else}''{/if}{literal};
					var page_type = {/literal}{if isset($GTM_DATAS.$page_name.page_type)}{$GTM_DATAS.$page_name.page_type}{else}''{/if}{literal};
					var product_ID = {/literal}{if isset($GTM_DATAS.$page_name.product_ID)}{$GTM_DATAS.$page_name.product_ID}{else}''{/if}{literal};
					var product_name = {/literal}{if isset($GTM_DATAS.$page_name.product_name)}{$GTM_DATAS.$page_name.product_name}{else}''{/if}{literal};
					var product_price = {/literal}{if isset($GTM_DATAS.$page_name.product_price)}{$GTM_DATAS.$page_name.product_price}{else}''{/if}{literal};
					var total_value = {/literal}{if isset($GTM_DATAS.$page_name.total_value)}{$GTM_DATAS.$page_name.total_value}{else}''{/if}{literal};
					var step = {/literal}{if isset($GTM_DATAS.$page_name.step)}{$GTM_DATAS.$page_name.step}{else}0{/if}{literal};
				{/literal}
			</script>
		{/if}

		{if $page_name == "order-confirmation" || $page_name == "module-paypal-submit"}
			<script type="text/javascript">
				{literal}
					var USER_ID = {/literal}{if isset($GTM_DATAS.$page_name.USER_ID)}{$GTM_DATAS.$page_name.USER_ID}{else}''{/if}{literal};
					var page_type = {/literal}{if isset($GTM_DATAS.$page_name.page_type)}{$GTM_DATAS.$page_name.page_type}{else}''{/if}{literal};
					var product_ID = {/literal}{if isset($GTM_DATAS.$page_name.product_ID)}{$GTM_DATAS.$page_name.product_ID}{else}''{/if}{literal};
					var product_name = {/literal}{if isset($GTM_DATAS.$page_name.product_name)}{$GTM_DATAS.$page_name.product_name}{else}''{/if}{literal};
					var product_price = {/literal}{if isset($GTM_DATAS.$page_name.product_price)}{$GTM_DATAS.$page_name.product_price}{else}''{/if}{literal};
					var total_value = {/literal}{if isset($GTM_DATAS.$page_name.total_value)}{$GTM_DATAS.$page_name.total_value}{else}''{/if}{literal};
					var event = {/literal}{if isset($GTM_DATAS.$page_name.event)}{$GTM_DATAS.$page_name.event}{else}''{/if}{literal};
					var transactionId = {/literal}{if isset($GTM_DATAS.$page_name.transactionId)}{$GTM_DATAS.$page_name.transactionId}{else}''{/if}{literal};
					var transactionAffiliation = {/literal}{if isset($GTM_DATAS.$page_name.transactionAffiliation)}{$GTM_DATAS.$page_name.transactionAffiliation}{else}''{/if}{literal};
					var transactionTotal = {/literal}{if isset($GTM_DATAS.$page_name.transactionTotal)}{$GTM_DATAS.$page_name.transactionTotal}{else}''{/if}{literal};
					var transactionTax = {/literal}{if isset($GTM_DATAS.$page_name.transactionTax)}{$GTM_DATAS.$page_name.transactionTax}{else}''{/if}{literal};
					var transactionShipping = {/literal}{if isset($GTM_DATAS.$page_name.transactionShipping)}{$GTM_DATAS.$page_name.transactionShipping}{else}''{/if}{literal};
					var transactionProducts = {/literal}{if isset($GTM_DATAS.$page_name.transactionProducts)}{$GTM_DATAS.$page_name.transactionProducts}{else}''{/if}{literal};
				{/literal}
			</script>
		{/if}

	{/if}


	{if !isset($content_only) || !$content_only}
		{if isset($restricted_country_mode) && $restricted_country_mode}
			<div id="restricted-country">
				<p>{l s='You cannot place a new order from your country.'}{if isset($geolocation_country) && $geolocation_country} <span class="bold">{$geolocation_country|escape:'html':'UTF-8'}</span>{/if}</p>
			</div>
		{/if}
		<div id="page">
			<div class="header-container">
				<header id="header">
					{capture name='displayBanner'}{hook h='displayBanner'}{/capture}
					{if $smarty.capture.displayBanner}
						<div class="banner">
							<div class="container">
								<div class="row">
									{$smarty.capture.displayBanner}
								</div>
							</div>
						</div>
					{/if}
					<div class="container">
						<div class="row">
							<div id="top-header">
								<div class="nav">
									<div class="container">
										<div class="row">
											
											<!-- acces pro -->
											<a href="http://www.pro.bougies-la-francaise.com/Authentification.aspx?ReturnUrl=%2fdefault.aspx" rel="nofollow" target="_blank" class="pro-access">
												<i class="ycon-cadenas"></i>
												{l s='Pro access'}
											</a>
											
											<!-- menu infos blf -->
											<ul id="menu-infos-blf">
												<li>
													<span><i class="ycon-blf"></i> {l s='Infos Bougie la Française'}</span>
													{hook h='customBlfMenu'}
												</li>
											</ul>
											{capture name='displayNav'}{hook h='displayNav'}{/capture}
											{if $smarty.capture.displayNav}
												<nav>{$smarty.capture.displayNav}</nav>
											{/if}
										</div>
									</div>
								</div>
							</div>
							<div id="mid-header">
								<a href="http://www.blf-privatelabel.com/" rel="nofollow" target="_blank" class="custom-candle-link">
									<div>
										{l s='Create a'} <b>{l s='candle'}</b>
										<br />{l s='to your'} <b>{l s='brand'}</b>
									</div>
								</a>
								<div id="header_logo">
									<a href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}" title="{$shop_name|escape:'html':'UTF-8'}" rel="nofollow">
										<img class="logo img-responsive" src="{$logo_url}" alt="{$shop_name|escape:'html':'UTF-8'}"{if isset($logo_image_width) && $logo_image_width} width="{$logo_image_width}"{/if}{if isset($logo_image_height) && $logo_image_height} height="{$logo_image_height}"{/if}/>
									</a>
									<p>{l s='Bayberry candles and designer since 1902'}</p>
								</div>
								{hook h='customCartHeader'}
							</div>
						</div>
					</div>
					<div class="header-bottom-pattern"></div>
					<div id="menu-header">
						{if isset($HOOK_TOP)}{$HOOK_TOP}{/if}
					</div>
				</header>
			</div>
			<div class="columns-container">
				<div id="columns">
					{if $page_name !='index' && $page_name !='pagenotfound'}
						{include file="$tpl_dir./breadcrumb.tpl"}
					{/if}
					<div id="slider_row">
						<div class="container">
							<div class="row">
								{capture name='displayTopColumn'}{hook h='displayTopColumn'}{/capture}
								{if $smarty.capture.displayTopColumn}
									<div id="top_column" class="center_column col-xs-12 col-sm-12">{$smarty.capture.displayTopColumn}</div>
								{/if}
							</div>
						</div>
					</div>

					{if $page_name != 'index' 
						&& $page_name != 'contact' 
						&& $page_name != 'module-blocknewsletter-form' 
						&& $page_name != 'authentication'
						&& $page_name != 'address'
						&& $page_name != 'identity'
						&& $page_name != 'module-braintree-payment'
						&&  $smarty.get.id_cms != 6
						&& $smarty.get.id_cms != 7
					}
						<div class="container">
							<div class="row">
					{/if}
							
							{*if isset($left_column_size) && !empty($left_column_size)}
							<div id="left_column" class="column col-xs-12 col-sm-{$left_column_size|intval}">{$HOOK_LEFT_COLUMN}</div>
							{/if*}
							
							{*if isset($left_column_size) && isset($right_column_size)}{assign var='cols' value=(12 - $left_column_size - $right_column_size)}{else}{assign var='cols' value=12}{/if*}
							<div id="center_column" class="center_column col-xs-12 col-sm-12">
	{/if}
