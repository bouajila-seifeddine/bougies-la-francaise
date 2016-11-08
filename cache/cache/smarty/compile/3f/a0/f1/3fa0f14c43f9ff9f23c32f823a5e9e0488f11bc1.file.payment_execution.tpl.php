<?php /* Smarty version Smarty-3.1.19, created on 2016-10-20 12:53:22
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/braintree/views/templates/front/payment_execution.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18483445835808a22259a637-17093310%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3fa0f14c43f9ff9f23c32f823a5e9e0488f11bc1' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/braintree/views/templates/front/payment_execution.tpl',
      1 => 1475482552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18483445835808a22259a637-17093310',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'form_type' => 0,
    'link' => 0,
    'total' => 0,
    'exp_dates' => 0,
    'dates' => 0,
    'three_d_secure' => 0,
    'client_token' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5808a2225e7e52_78257609',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5808a2225e7e52_78257609')) {function content_5808a2225e7e52_78257609($_smarty_tpl) {?>

<style type="text/css">
  #cvv{
    width: 50px !important;
  }
  #card_name, #card_number{
    width: 300px !important;
  }
</style>
<h1 class="page-heading"> Order summary </h1>

<?php if ($_smarty_tpl->tpl_vars['form_type']->value!=1) {?>
<form action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('braintree','validation',array(),true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post" class="" id="braintree_cc_submit" style="background: #fbfbfb none repeat scroll 0 0;
    border: 1px solid #d6d4d4;
    line-height: 23px;
    margin: 0 0 30px;
    padding: 14px 18px 13px;">
  <h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'BrainTree Credit Card Payment','mod'=>'braintree'),$_smarty_tpl);?>
</h3>
  <p><?php echo smartyTranslate(array('s'=>'You have chosen to pay by BrainTree.','mod'=>'braintree'),$_smarty_tpl);?>
</p>
  <p><?php echo smartyTranslate(array('s'=>'Here is a short summary of your order:','mod'=>'braintree'),$_smarty_tpl);?>
 </p>
  <ul>
    <li>- <?php echo smartyTranslate(array('s'=>'The total amount of your order is','mod'=>'braintree'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total']->value),$_smarty_tpl);?>
</span> (tax incl.) </li>
  </ul>
  <div class="error_msg"></div>
  <div class="form-group">
    <label for="card_name" class=""><?php echo smartyTranslate(array('s'=>'Card Name','mod'=>'braintree'),$_smarty_tpl);?>
</label>
    <input type="text" class="form-control" id="card_name" placeholder="Card Name" name="card_name">
  </div>
  <div class="form-group">
    <label for="card_number" class=""><?php echo smartyTranslate(array('s'=>'Card Number','mod'=>'braintree'),$_smarty_tpl);?>
</label>
    <input type="text" class="form-control" id="card_number" placeholder="Card Number" name="card_number">
  </div>
  <div class="form-group">
    <label for="inputEmail3" class=""><?php echo smartyTranslate(array('s'=>'Expiration Date','mod'=>'braintree'),$_smarty_tpl);?>
</label>
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
      <?php  $_smarty_tpl->tpl_vars['dates'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['dates']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['exp_dates']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['dates']->key => $_smarty_tpl->tpl_vars['dates']->value) {
$_smarty_tpl->tpl_vars['dates']->_loop = true;
?>
        <option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dates']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dates']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="cvv" class=""><?php echo smartyTranslate(array('s'=>'CVV','mod'=>'braintree'),$_smarty_tpl);?>
</label>
    <input type="text" class="form-control" id="cvv" placeholder="" name="cvv">
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary braintree_submit" value="<?php echo smartyTranslate(array('s'=>'Submit Payment','mod'=>'braintree'),$_smarty_tpl);?>
" name="submit"></input>
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

<?php } else { ?>

<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'BrainTree Credit Card Payment','mod'=>'braintree'),$_smarty_tpl);?>
</h3>
  <p><?php echo smartyTranslate(array('s'=>'You have chosen to pay by BrainTree.','mod'=>'braintree'),$_smarty_tpl);?>
</p>
  <p><?php echo smartyTranslate(array('s'=>'Here is a short summary of your order:','mod'=>'braintree'),$_smarty_tpl);?>
</p>
  <ul>
    <li>- <?php echo smartyTranslate(array('s'=>'The total amount of your order is','mod'=>'braintree'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total']->value),$_smarty_tpl);?>
</span> (tax incl.) </li>
  </ul>
  <div class="error_msg_dropin"></div>
<form action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('braintree','validation',array(),true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post" class="" id="braintree_cc_submit_dropin" style="background: #fbfbfb none repeat scroll 0 0;
    border: 1px solid #d6d4d4;
    line-height: 23px;
    margin: 0 0 30px;
    padding: 14px 18px 13px;">
  <div id="payment-form"></div>
  <?php if ($_smarty_tpl->tpl_vars['three_d_secure']->value==1) {?>
    <input type="hidden" name="payment_method_nonce" value="" class="nonce">
  <?php }?>
  <input type="submit" value="<?php echo smartyTranslate(array('s'=>'Submit Payment','mod'=>'braintree'),$_smarty_tpl);?>
" class="btn btn-primary dropin_submit">
</form>
<script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
  <?php if ($_smarty_tpl->tpl_vars['three_d_secure']->value==1) {?>
    <script>
      var clientToken = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['client_token']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";

      braintree.setup(clientToken, "dropin", {
        container: "payment-form",
        onPaymentMethodReceived: function (obj) {
          // alert(JSON.stringify(obj));
          client.verify3DS({
            amount: <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['total']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
,
            creditCard: obj.nonce
          }, function (error, response) {
            // alert(JSON.stringify(error));
            // alert(JSON.stringify(response));

            var result = JSON.stringify(response.verificationDetails['liabilityShifted']);
            $('.nonce').val(response.nonce);

            if(result == 'true'){
              // $('#braintree_cc_submit_dropin').submit();
            } else {
              $('.error_msg_dropin').html('<div class="alert alert-danger"><?php echo smartyTranslate(array('s'=>"Please select a payment method.",'mod'=>"braintree"),$_smarty_tpl);?>
</div>');
            }
          });
        }
      });

      var client = new braintree.api.Client({
        clientToken: "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['client_token']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"
      });
    </script>
  <?php } else { ?>
    <script>
      var clientToken = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['client_token']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";

      braintree.setup(clientToken, "dropin", {
        container: "payment-form"
      });
    </script>
  <?php }?>
<?php }?><?php }} ?>
