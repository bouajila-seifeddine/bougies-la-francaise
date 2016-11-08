{*
 * Systempay payment module 1.2f (revision 61545)
 *
 * Compatible with V2 payment platform. Developped for Prestashop 1.5.0.x.
 * Support contact: supportvad@lyra-network.com.
 * 
 * Copyright (C) 2014 Lyra Network (http://www.lyra-network.com/) and contributors
 * 
 * 
 * NOTICE OF LICENSE
 *
 * This source file is licensed under the Open Software License version 3.0
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
*}

{capture name=path}Systempay{/capture}
{if $back_compat}
	{include file="$tpl_dir./breadcrumb.tpl"}
{/if}

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if isset($systempay_empty_cart) && $systempay_empty_cart}
	<p class="warning">{l s='Your shopping cart is empty.' mod='systempay'}</p>
{else}
	
	<form action="{$systempay_url}" method="post" id="systempay_form" name="systempay_form"> 
	    {foreach from=$systempay_params key='key' item='value'}
			<input type="hidden" name="{$key}" value="{$value}" />
		{/foreach}
        
        {if isset($systempay_params) && $systempay_params.vads_action_mode == 'SILENT'}
            <h3>{l s='Payment processing' mod='systempay'}</h3>
        {else}
            <h3>{l s='Redirection to payment gateway' mod='systempay'}</h3>
        {/if}

		<p>
			{if $systempay_params.vads_action_mode == 'SILENT'}
				{l s='Please wait a moment. Your order payment is now processing.' mod='systempay'}
			{else}
				{l s='Please wait, you will be redirected to the payment platform.' mod='systempay'}
			{/if}
        </p>
        
        <p>
			{l s='If nothing happens in 10 seconds, please click the button below.' mod='systempay'} 
		</p>
	
	{if $back_compat}
		<p class="cart_navigation">
			<input type="submit" name="submitPayment" value="{l s='Pay' mod='systempay'}" class="exclusive" />
		</p>
	{else}
		<p class="cart_navigation clearfix">
			<button type="submit" name="submitPayment" class="button btn btn-default standard-checkout button-medium" >
				<span>{l s='Pay' mod='systempay'}</span>
			</button>
		</p>
	{/if}
	</form>
	
	<script type="text/javascript">
		{literal}
			$(function() {
				setTimeout(function() {
					$('#systempay_form').submit();
				}, 1000);
			});
		{/literal}
	</script>
{/if}