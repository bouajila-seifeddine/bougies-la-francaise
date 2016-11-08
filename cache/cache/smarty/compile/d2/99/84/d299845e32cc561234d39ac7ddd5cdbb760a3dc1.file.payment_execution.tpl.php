<?php /* Smarty version Smarty-3.1.19, created on 2016-10-28 10:55:44
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/braintree/views/templates/front/payment_execution.tpl" */ ?>
<?php /*%%SmartyHeaderCode:174271151958131290a58010-98999760%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd299845e32cc561234d39ac7ddd5cdbb760a3dc1' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/braintree/views/templates/front/payment_execution.tpl',
      1 => 1476972127,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '174271151958131290a58010-98999760',
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
  'unifunc' => 'content_58131290aa7054_85964573',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58131290aa7054_85964573')) {function content_58131290aa7054_85964573($_smarty_tpl) {?>

<style type="text/css">
  #cvv{
    width: 50px !important;
  }
  #card_name, #card_number{
    width: 300px !important;
  }

</style>
	
<div class="blf-form-container">
	<div class="container">
		<div class="row">

			<?php if ($_smarty_tpl->tpl_vars['form_type']->value!=1) {?>
			<form action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('braintree','validation',array(),true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post" class="" id="braintree_cc_submit">
				<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'BrainTree Credit Card Payment','mod'=>'braintree'),$_smarty_tpl);?>
</h3>
				<div class="info-title">
					<p><?php echo smartyTranslate(array('s'=>'You have chosen to pay by BrainTree.','mod'=>'braintree'),$_smarty_tpl);?>
</p>
					<p><?php echo smartyTranslate(array('s'=>'Here is a short summary of your order:','mod'=>'braintree'),$_smarty_tpl);?>
 </p>
					<p>
						<?php echo smartyTranslate(array('s'=>'The total amount of your order is','mod'=>'braintree'),$_smarty_tpl);?>
 <b><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total']->value),$_smarty_tpl);?>
</b> <?php echo smartyTranslate(array('s'=>'(tax incl.)','mod'=>'braintree'),$_smarty_tpl);?>

					</p>
				</div>
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
				<div class="form-group exp-date clearfix">
					<label for="inputEmail3" class=""><?php echo smartyTranslate(array('s'=>'Expiration Date','mod'=>'braintree'),$_smarty_tpl);?>
</label>
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
					</div>
				</div>
				<div class="form-group">
					<label for="cvv" class=""><?php echo smartyTranslate(array('s'=>'CVV','mod'=>'braintree'),$_smarty_tpl);?>
</label>
					<input type="text" class="form-control" id="cvv" placeholder="" name="cvv">
				</div>
				<div class="form-group">
					<button class="btn-blf white braintree_submit">
						<span><?php echo smartyTranslate(array('s'=>'Submit Payment','mod'=>'braintree'),$_smarty_tpl);?>
</span>
					</button>
					
					
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
			  <p class="info-title">
					<?php echo smartyTranslate(array('s'=>'The total amount of your order is','mod'=>'braintree'),$_smarty_tpl);?>
 <span class="bold"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total']->value),$_smarty_tpl);?>
</span> <?php echo smartyTranslate(array('s'=>'(tax incl.)','mod'=>'braintree'),$_smarty_tpl);?>

			  </p>
			  <div class="error_msg_dropin"></div>
			<form action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('braintree','validation',array(),true), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post" class="" id="braintree_cc_submit_dropin">
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
			<?php }?>
			
		</div>
	</div>
</div><?php }} ?>
