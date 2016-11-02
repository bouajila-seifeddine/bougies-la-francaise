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
	<div class="col-sm-6 col-xs-12">
		<div class="payment_module systempay_payment_module">
			{if $systempay_std_card_data_mode == 1}
				<a onclick="javascript: $('#systempay_standard').submit();" title="{l s='Click here to pay by bank card' mod='systempay'}">
			{else} 
				<a class="unclickable" title="{l s='Enter payment information and click «Pay now» button' mod='systempay'}">
			{/if}
				<span>
				{*<!--
					<img class="logo" src="{$base_dir_ssl}modules/systempay/views/images/BannerLogo1.png" alt="Systempay"/>
				-->*}
					<i class="ycon-credit-card"></i>
					{$systempay_std_title}		
				</span>		
				<form action="{$link->getModuleLink('systempay', 'redirect', array(), true)}" method="post" id="systempay_standard" name="systempay_standard" class="systempay_payment_form">
					<input type="hidden" name="systempay_payment_type" value="standard" />
					
					{if ($systempay_std_card_data_mode == 2) OR ($systempay_std_card_data_mode == 3) }
						<br />
					
						{if {$systempay_avail_cards|@count} == 1}
							<input type="hidden" id="systempay_card_type_{$systempay_avail_cards.0}" name="systempay_card_type" value="{$systempay_avail_cards.0}" style="vertical-align: middle;">
							<label for="systempay_card_type_{$systempay_avail_cards.0}"><img style="vertical-align: middle; margin-right:10px; height:20px;" src="{$base_dir_ssl}modules/systempay/views/images/{$systempay_avail_cards.0|lower}.png" alt="{$systempay_avail_cards.0}" title="{$systempay_avail_cards.0}" /></label>
						{else}
							{assign var=first value=true}
							{foreach from=$systempay_avail_cards item="card"}
								{if $first == true}
									<input type="radio" id="systempay_card_type_{$card}" name="systempay_card_type" value="{$card}" style="vertical-align: middle;" checked="checked">
									{assign var=first value=false}
								{else}	
									<input type="radio" id="systempay_card_type_{$card}" name="systempay_card_type" value="{$card}" style="vertical-align: middle;">
								{/if}
								<label for="systempay_card_type_{$card}"><img style="vertical-align: middle; margin-right:10px; height:20px;" src="{$base_dir_ssl}modules/systempay/views/images/{$card|lower}.png" alt="{$card}" title="{$card}" /></label>
							{/foreach}
						{/if}
				
						{if $systempay_std_card_data_mode == 3}
							<br /><br />
							<label for="systempay_card_number"> {l s='Card number' mod='systempay'}</label><br />
							<input type="text" name="systempay_card_number" value="" autocomplete="off" maxlength="19" id="systempay_card_number" size="30" maxlength="16" />
							
							<br /><br />
							<label for="systempay_cvv"> {l s='CVV' mod='systempay'}</label><br />
							<input type="text" name="systempay_cvv" value="" autocomplete="off" maxlength="4" id="systempay_cvv" size="5" maxlength="4" />
							
							<br /><br />
							<label for="systempay_expiry_month">{l s='Expiration date' mod='systempay'}</label><br />
							<select name="systempay_expiry_month" id="systempay_expiry_month" style="width: 70px;">
								<option value="">{l s='Month' mod='systempay'}</option>
								{section name=expiry start=1 loop=13 step=1}
								<option value="{$smarty.section.expiry.index}">{$smarty.section.expiry.index}</option>
								{/section}
							</select>
										
							<select name="systempay_expiry_year" id="systempay_expiry_year" style="width: 70px;">
								<option value="">{l s='Year' mod='systempay'}</option>
								{assign var=year value=$smarty.now|date_format:"%Y"}
								{section name=expiry start=$year loop=$year+9 step=1}
								<option value="{$smarty.section.expiry.index}">{$smarty.section.expiry.index}</option>
								{/section}
							</select>
						{/if}
							
						<br /><br />
						{if $back_compat}
							<input type="submit" name="submit" value="{l s='Pay now' mod='systempay'}" class="button" />
						{else}
							<button type="submit" name="submit" class="button btn btn-default standard-checkout button-medium" >
								<span>{l s='Pay now' mod='systempay'}</span>
							</button>
						{/if}
					{/if}
				</form>
			</a>
			
			{if $systempay_std_card_data_mode == 3} {literal}
				<script type="text/javascript">
					$(document).ready(function() {
						$('#systempay_standard').bind('submit', function() {
							$('#systempay_standard input, #systempay_standard select').each(function() {
								$(this).removeClass('invalid');
							});
							
							var cardNumber = $('#systempay_card_number').val();
							if(cardNumber.length <= 0 || !(/^\d{13,19}$/.test(cardNumber))){
								$('#systempay_card_number').addClass('invalid');
							}
								
							var cvv = $('#systempay_cvv').val();
							if(cvv.length <= 0 || !(/^\d{3,4}$/.test(cvv))) {
								$('#systempay_cvv').addClass('invalid');
							}	
								
							var currentTime  = new Date();
							var currentMonth = currentTime.getMonth() + 1;
							var currentYear  = currentTime.getFullYear();
							
							var expiryYear = $('select[name="systempay_expiry_year"] option:selected').val();
							if(expiryYear.length <= 0 || !(/^\d{4}$/.test(expiryYear)) || expiryYear < currentYear) {
								$('#systempay_expiry_year').addClass('invalid');
							}
								
							var expiryMonth = $('select[name="systempay_expiry_month"] option:selected').val();
							if(expiryMonth.length <= 0 || !(/^\d{1,2}$/.test(expiryMonth)) || (expiryYear == currentYear && expiryMonth < currentMonth)) {
								$('#systempay_expiry_month').addClass('invalid');
							}
								
							return ($('#systempay_standard').find('.invalid').length > 0) ? false : true;
						});
					});
				</script>
			{/literal} {/if}
		</div>
	</div>