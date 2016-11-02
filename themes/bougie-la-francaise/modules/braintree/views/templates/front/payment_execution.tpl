{*
* 2007-2015 PrestaShop
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

<style type="text/css">
  #cvv{
    width: 50px !important;
  }
  #card_name, #card_number{
    width: 300px !important;
  }

</style>
{*}<!--
	<h1 class="page-heading">{l s='Order summary' mod='braintree'}</h1>
-->{*}	
<div class="blf-form-container">
	<div class="container">
		<div class="row">

			{if $form_type != 1}
			<form action="{$link->getModuleLink('braintree', 'validation', [], true)|escape:'htmlall':'UTF-8'}" method="post" class="" id="braintree_cc_submit">
				<h3 class="page-subheading">{l s='BrainTree Credit Card Payment' mod='braintree'}</h3>
				<div class="info-title">
					<p>{l s='You have chosen to pay by BrainTree.' mod='braintree'}</p>
					<p>{l s='Here is a short summary of your order:' mod='braintree'} </p>
					<p>
						{l s='The total amount of your order is' mod='braintree'} <b>{displayPrice price=$total}</b> {l s='(tax incl.)' mod='braintree'}
					</p>
				</div>
				<div class="error_msg"></div>
				<div class="form-group">
					<label for="card_name" class="">{l s='Card Name' mod='braintree'}</label>
					<input type="text" class="form-control" id="card_name" placeholder="Card Name" name="card_name">
				</div>
				<div class="form-group">
					<label for="card_number" class="">{l s='Card Number' mod='braintree'}</label>
					<input type="text" class="form-control" id="card_number" placeholder="Card Number" name="card_number">
				</div>
				<div class="form-group exp-date clearfix">
					<label for="inputEmail3" class="">{l s='Expiration Date' mod='braintree'}</label>
					<div class="row">
						<div class="col-xs-6">
							<select name="expiration_month" class="form-control">
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>
								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</div>
						<div class="col-xs-6">
							<select name="expiration_year" class="form-control">
								{foreach from=$exp_dates item=dates}
								<option value="{$dates|escape:'htmlall':'UTF-8'}">{$dates|escape:'htmlall':'UTF-8'}</option>
								{/foreach}
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="cvv" class="">{l s='CVV' mod='braintree'}</label>
					<input type="text" class="form-control" id="cvv" placeholder="" name="cvv">
				</div>
				<div class="form-group">
					<button class="btn-blf white braintree_submit">
						<span>{l s='Submit Payment' mod='braintree'}</span>
					</button>
					{* old *}
					{* 
						<input type="submit" class="btn btn-primary braintree_submit" value="{l s='Submit Payment' mod='braintree'}" name="submit"></input>
					*}
				</div>
			</form>

			<script type="text/javascript">
			  $(function(){
				$('#braintree_cc_submit').submit(function(){
				  $('.alert').remove();
				  $('.braintree_submit').val('Processing Payment...');

				  var data = $(this).serialize();

				  var query = $.ajax({
					type: 'POST',
					url: baseDir + 'index.php?fc=module&module=braintree&controller=validation',
					data: data,
					dataType: 'json',
					success: function(data) {
					  if(data.errorMsg){
						$(data.msg).appendTo('.error_msg');
						$('.braintree_submit').val('Submit Payment');
					  } else {
						window.location = data.msg;
					  }
					}
				  });

				  return false;
				});
			  });
			</script>

			{else}

			<h3 class="page-subheading">{l s='BrainTree Credit Card Payment' mod='braintree'}</h3>
			  <p>{l s='You have chosen to pay by BrainTree.' mod='braintree'}</p>
			  <p>{l s='Here is a short summary of your order:' mod='braintree'}</p>
			  <p class="info-title">
					{l s='The total amount of your order is' mod='braintree'} <span class="bold">{displayPrice price=$total}</span> {l s='(tax incl.)' mod='braintree'}
			  </p>
			  <div class="error_msg_dropin"></div>
			<form action="{$link->getModuleLink('braintree', 'validation', [], true)|escape:'htmlall':'UTF-8'}" method="post" class="" id="braintree_cc_submit_dropin">
			  <div id="payment-form"></div>
			  {if $three_d_secure == 1}
				<input type="hidden" name="payment_method_nonce" value="" class="nonce">
			  {/if}
			  <input type="submit" value="{l s='Submit Payment' mod='braintree'}" class="btn btn-primary dropin_submit">
			</form>
			<script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
			  {if $three_d_secure == 1}
				<script>
				  var clientToken = "{$client_token|escape:'htmlall':'UTF-8'}";

				  braintree.setup(clientToken, "dropin", {
					container: "payment-form",
					onPaymentMethodReceived: function (obj) {
					  // alert(JSON.stringify(obj));
					  client.verify3DS({
						amount: {$total|escape:'htmlall':'UTF-8'},
						creditCard: obj.nonce
					  }, function (error, response) {
						// alert(JSON.stringify(error));
						// alert(JSON.stringify(response));

						var result = JSON.stringify(response.verificationDetails['liabilityShifted']);
						$('.nonce').val(response.nonce);

						if(result == 'true'){
						  // $('#braintree_cc_submit_dropin').submit();
						} else {
						  $('.error_msg_dropin').html('<div class="alert alert-danger">{l s="Please select a payment method." mod="braintree"}</div>');
						}
					  });
					}
				  });

				  var client = new braintree.api.Client({
					clientToken: "{$client_token|escape:'htmlall':'UTF-8'}"
				  });
				</script>
			  {else}
				<script>
				  var clientToken = "{$client_token|escape:'htmlall':'UTF-8'}";

				  braintree.setup(clientToken, "dropin", {
					container: "payment-form"
				  });
				</script>
			  {/if}
			{/if}
			
		</div>
	</div>
</div>