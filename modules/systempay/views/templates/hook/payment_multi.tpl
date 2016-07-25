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

<div class="payment_module systempay_payment_module">
	<a class="unclickable" title="{l s='Select payment option and click «Pay now» button' mod='systempay'}">
		<img class="logo" src="{$base_dir_ssl}modules/systempay/views/images/BannerLogo2.png" alt="Systempay"/>{$systempay_multi_title}
		
		<form action="{$link->getModuleLink('systempay', 'redirect', array(), true)}" method="post" name="systempay_multi" class="systempay_payment_form" >
			<input type="hidden" name="systempay_payment_type" value="multi" />
			<br />
			
			{if {$systempay_multi_options|@count} == 1}
				{foreach from=$systempay_multi_options key="key" item="option"}
			   		<input type="hidden" id="systempay_opt_{$key}" name="systempay_opt" value="{$key}" style="vertical-align: middle;" />
			      	<label for="systempay_opt_{$key}">{$option.label}</label>
			      	<br />
		 		{/foreach}	 
			{else}
				{assign var=first value=true}
				{foreach from=$systempay_multi_options key="key" item="option"}
					{if $first == true}
						{assign var=checked value='checked="checked"'}
						{assign var=first value=false}
				    {else}
				    	{assign var=checked value=''}
				    {/if}
				    
					<input type="radio" id="systempay_opt_{$key}" name="systempay_opt" value="{$key}" style="vertical-align: middle;" {$checked} />
				    <label for="systempay_opt_{$key}">{$option.label}</label>
				    <br />
		   		{/foreach}
			{/if}
		 		
			<br />
			{if $back_compat}
				<input type="submit" name="submit" value="{l s='Pay now' mod='systempay'}" class="button" />
			{else}
				<button type="submit" name="submit" class="button btn btn-default standard-checkout button-medium" >
					<span>{l s='Pay now' mod='systempay'}</span>
				</button>
			{/if}
		</form>
	</a>
</div>