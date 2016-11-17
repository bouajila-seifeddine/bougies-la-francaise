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
  #postal_code{
    width: 100px !important;
  }
  #card_name, #card_number{
    width: 300px !important;
  }
</style>
<h1 class="page-heading"> Order summary </h1>

{if $form_type != 1}
<form action="{$link->getModuleLink('braintree', 'validation', [], true)|escape:'htmlall':'UTF-8'}" method="post" class="" id="braintree_cc_submit" style="background: #fbfbfb none repeat scroll 0 0;
    border: 1px solid #d6d4d4;
    line-height: 23px;
    margin: 0 0 30px;
    padding: 14px 18px 13px;">
  <h3 class="page-subheading">{l s='BrainTree Credit Card Payment' mod='braintree'}</h3>
  <p>{l s='You have chosen to pay by BrainTree.' mod='braintree'}</p>
  <p>{l s='Here is a short summary of your order:' mod='braintree'} </p>
  <ul>
    <li>- {l s='The total amount of your order is' mod='braintree'} <span class="bold">{displayPrice price=$total}</span> (tax incl.) </li>
  </ul>
  <div class="error_msg"></div>
  {if $cardholdername}
  <div class="form-group">
    <label for="card_name" class="">{$bt_card_name}</label>
    <input type="text" class="form-control" id="card_name" placeholder="{$bt_card_name_holder}" name="card_name">
  </div>
  {/if}
  <div class="form-group">
    <label for="card_number" class="">{$bt_card_number}</label>
    <input type="text" class="form-control" id="card_number" placeholder="{$bt_card_number_holder}" name="card_number">
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="">{$bt_expiration_date}</label>
    <br>
    <select name="expiration_month">
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
    <select name="expiration_year">
      {foreach from=$exp_dates item=dates}
        <option value="{$dates|escape:'htmlall':'UTF-8'}">{$dates|escape:'htmlall':'UTF-8'}</option>
      {/foreach}
    </select>
  </div>
  <div class="form-group">
    <label for="cvv" class="">{$bt_cvv}</label>
    <input type="text" class="form-control" id="cvv" placeholder="" name="cvv">
  </div>
  {if $postal_code}
  <div class="form-group">
    <label for="postal_code" class="">{$bt_postal_code}</label>
    <input type="text" class="form-control" id="postal_code" placeholder="" name="postal_code">
  </div>
  {/if}
  <div class="form-group">
    <input type="submit" class="btn btn-primary braintree_submit" value="{$bt_submit_button}" name="submit"></input>
  </div>
</form>

<script type="text/javascript">
  $(function(){
    $('#braintree_cc_submit').submit(function(){
      $('.alert').remove();
      $('.braintree_submit').val('{$bt_submit_processing}');

      var data = $(this).serialize();

      var query = $.ajax({
        type: 'POST',
        url: baseDir + 'index.php?fc=module&module=braintree&controller=validation',
        data: data,
        dataType: 'json',
        success: function(data) {
          if(data.errorMsg){
            $(data.msg).appendTo('.error_msg');
            $('.braintree_submit').val('{$bt_submit_button}');
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
  <ul>
    <li>- {l s='The total amount of your order is' mod='braintree'} <span class="bold">{displayPrice price=$total}</span> (tax incl.) </li>
  </ul>
<form action="{$link->getModuleLink('braintree', 'validation', [], true)|escape:'htmlall':'UTF-8'}" method="post" class="" id="braintree_cc_submit_dropin" style="background: #fbfbfb none repeat scroll 0 0;
    border: 1px solid #d6d4d4;
    line-height: 23px;
    margin: 0 0 30px;
    padding: 14px 18px 13px;">
  <div class="error_msg"></div>
  <div id="payment-form"></div>
  <input type="hidden" name="payment_method_nonce" value="" class="nonce">
  <input type="submit" value="{$bt_submit_button}" class="btn btn-primary dropin_submit">
</form>
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
              $('#braintree_cc_submit_dropin').submit();
            } else {
              $('.error_msg_dropin').html("<div class='alert alert-danger'>{$bt_select_payment_method}</div>");
            }
          });
        },
        onError: function (obj) {
          // nothing to do
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
        container: "payment-form",
        onPaymentMethodReceived: function(obj) {
          $('#braintree_cc_submit_dropin .alert').remove();
          $('.dropin_submit').val('{$bt_submit_processing}');

          $('.nonce').val(obj.nonce);
          var data = $('#braintree_cc_submit_dropin').serialize();

          var query = $.ajax({
            type: 'POST',
            url: baseDir + 'index.php?fc=module&module=braintree&controller=validation',
            data: data,
            dataType: 'json',
            success: function(data) {
              if(data.errorMsg){
                $('.dropin_submit').val('{$bt_submit_button}');
                $(data.msg).appendTo('.error_msg');
              } else {
                window.location = data.msg;
              }
            }
          });
          return false;
        },
        onError: function (obj) {
          // nothing to do
        }
      });
    </script>
  {/if}
{/if}