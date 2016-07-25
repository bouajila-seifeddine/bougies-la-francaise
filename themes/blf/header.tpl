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
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 " lang="{$lang_iso}"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="{$lang_iso}"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="{$lang_iso}"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="{$lang_iso}"> <![endif]-->
<html class="no-js">
	<head>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <meta http-equiv="content-language" content="{$meta_language}" />
        <meta name="robots" content="{if isset($nobots) && $nobots}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width" name="viewport" />
        <link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
        <link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />
        <meta name="p:domain_verify" content="b30617753f7e35bd46d8a8448e7dc412"/>
        <meta name="google-site-verification" content="nHasd9suhMPpbt34KyRbS6WD_qDnvZja5axm4Vdrj98" />
        
        <title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
        {if isset($meta_keywords) AND $meta_keywords}
            <meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
        {/if}
        {if isset($meta_description) AND $meta_description}
            <meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />
        {/if}

        <!-- CSS ***************************************--> 
		{if isset($css_files)}
            {foreach from=$css_files key=css_uri item=media}
            <link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}" />
            {/foreach}
        {/if}
        <!--[if IE 8]>
            <link href="{$css_dir}ie8.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <!--[if IE 7]>
            <link href="{$css_dir}ie7.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        
        <!-- JS ****************************************-->
        <script type="text/javascript">
			var baseDir = '{$content_dir|addslashes}';
			var baseUri = '{$base_uri|addslashes}';
			var static_token = '{$static_token|addslashes}';
			var token = '{$token|addslashes}';
			var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
			var priceDisplayMethod = {$priceDisplay};
			var roundMode = {$roundMode};
		</script>
        
        {if isset($js_files)}
            {foreach from=$js_files item=js_uri}
			{if not $js_uri|strstr:"facebook" and not $js_uri|strstr:"homeslider" and not $js_uri|strstr:"fancybox"}
            <script type="text/javascript" src="{$js_uri}"></script>
			{/if}
            {/foreach}
        {/if}
                
		{$HOOK_HEADER}
	</head>
	
	<body {if isset($page_name)}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if} class="{if isset($page_name)}{$page_name|escape:'htmlall':'UTF-8'}{/if}{if $hide_left_column} hide-left-column{/if}{if $hide_right_column} hide-right-column{/if}{if $content_only} content_only{/if}">
		<!-- End Google Tag Manager -->
		<script>
			var dataLayer = [];
			var data = {literal}{}{/literal};
			var userId = '{$cookie->id_customer}';
			var pageName = '{$page_name}';
			if (userId) data['USER_ID'] = userId;
			
			{if isset($page_name)}
				{if $page_name == 'index'}
					data['page_type'] = 'home';
					dataLayer.push(data);
				{/if}
				{if $page_name == 'category'}
					data['page_type'] = 'category';
					dataLayer.push(data);
				{/if}
				{if ($page_name == 'order' || $page_name == 'order-opc') && isset($token_cart)}
					var skus = [];
					var names = [];
					var sku = '';
					var name = '';
					var total = parseFloat('{$total_price}');
					
					{foreach $products as $p}
						sku = '{$p.id_product|escape:quotes}';
						name = '{$p.name|escape:quotes}';						
						skus.push(sku);
						names.push(name);
					{/foreach}
				
					data['page_type'] = 'cart';
					data['product_ID'] = skus;
					data['product_name'] = names;
					data['total_value'] = total;					
					dataLayer.push(data);
				{/if}				
				
				{if $page_name == 'product' && $product}
					{if !isset($priceDisplayPrecision)}
						{assign var='priceDisplayPrecision' value=2}
					{/if}
					{if !$priceDisplay || $priceDisplay == 2}
						{assign var='productPrice' value=$product->getPrice(true, $smarty.const.NULL, $priceDisplayPrecision)}
						{assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(false, $smarty.const.NULL)}
					{elseif $priceDisplay == 1}
						{assign var='productPrice' value=$product->getPrice(false, $smarty.const.NULL, $priceDisplayPrecision)}
						{assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(true, $smarty.const.NULL)}
					{/if}
					
					var productReference = '{$product->id}' || '{$product->reference|escape:'html':'UTF-8'}';
					var productPrice = {$productPrice|floatval};
					var productName = '{$product->name|escape:'html':'UTF-8'}';
					
					data['page_type'] = 'product';
					data['product_ID'] = productReference;
					data['total_value'] = productPrice;
					data['product_name'] = productName;
					dataLayer.push(data);
				{/if}
				
				{if $page_name == 'order-confirmation' || $page_name == 'module-paypal-submit' }
					var transactionAffiliation = location.hostname;
					var transactionId = '{$order_data->id}';
					var transactionTotal = parseFloat('{$order_data->total_paid}') || 0;
					var transactionTax = parseFloat('{$order_data->total_paid_tax_incl - $order_data->total_paid_tax_excl}') || 0;
					var transactionShipping = parseFloat('{$order_data->total_shipping}') || 0;
					var products = [];
					var skus = [];
					var names = [];
					var sku = '';
					var name = '';
					
					{foreach $products as $p}
						sku = '{$p.product_id}' || '{$p.product_reference|escape:quotes}';
						name = '{$p.product_name|escape:quotes}';
						
						products.push(
							{literal}{{/literal}
								'sku': sku,
								'name': name,
								'category': '{$p.product_category|escape:quotes}',
								'price': parseFloat('{$p.product_price}') || 0,
								'quantity': parseInt('{$p.product_quantity}') || 0
							{literal}}{/literal}
						);
						
						skus.push(sku);
						names.push(name);
					{/foreach}

					{literal}
					(function($) {
						$(document).ready(function() {
							dataLayer.push({
								'event' : 'confirmation',
								'transactionId': transactionId,
								'transactionAffiliation': transactionAffiliation,
								'transactionTotal': transactionTotal,
								'transactionTax': transactionTax,
								'transactionShipping': transactionShipping,
								'transactionProducts': products
							});
							
							data['page_type'] = 'purchase';
							data['product_ID'] = skus;
							data['product_name'] = names;
							data['total_value'] = transactionTotal;
							dataLayer.push(data);		
						});
					})(jQuery);					
					{/literal}
				{/if}
			{/if}		
		</script>
		<!-- End Google Tag Manager -->		
		
		<!-- Google Tag Manager -->
		{literal}
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WJ9895" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>
			(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-WJ9895');
		</script>
		{/literal}
		<!-- End Google Tag Manager -->
        
        {if !$content_only}
            
            {if isset($restricted_country_mode) && $restricted_country_mode}
                <div id="restricted-country">
                    <p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
                </div>
            {/if}
            
            <div id="wrapper"> 

                <!-- Header -->
                <header id="header">
                    <a id="logo" href="{$base_dir}">
                        <img src="{$logo_url}" alt="{$shop_name|escape:'htmlall':'UTF-8'}" {if $logo_image_width}width="{$logo_image_width}"{/if} {if $logo_image_height}height="{$logo_image_height}" {/if}/>
                    </a>

                    {$HOOK_TOP}
                </header>
                
                <div id="container">
                                        
                    <section id="content" class="{if isset($parent_categorie->name)}{$parent_categorie->name|lower}{/if} {if isset($cms->id)}cms-{$cms->id|lower}{/if}">
        {/if}
