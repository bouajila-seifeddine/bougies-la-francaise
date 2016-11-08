<?php /* Smarty version Smarty-3.1.19, created on 2016-10-25 16:32:01
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/systempay/views/templates/hook/payment_std.tpl" */ ?>
<?php /*%%SmartyHeaderCode:383129267580f6ce1e9c683-22335464%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a117bc48338af64b3ba61ef043dffc72ca3a195' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/systempay/views/templates/hook/payment_std.tpl',
      1 => 1475245158,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '383129267580f6ce1e9c683-22335464',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'systempay_std_card_data_mode' => 0,
    'systempay_std_title' => 0,
    'link' => 0,
    'systempay_avail_cards' => 0,
    'base_dir_ssl' => 0,
    'first' => 0,
    'card' => 0,
    'year' => 0,
    'back_compat' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_580f6ce20154c7_43914297',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_580f6ce20154c7_43914297')) {function content_580f6ce20154c7_43914297($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/tools/smarty/plugins/modifier.date_format.php';
?>
	<div class="col-sm-6 col-xs-12">
		<div class="payment_module systempay_payment_module">
			<?php if ($_smarty_tpl->tpl_vars['systempay_std_card_data_mode']->value==1) {?>
				<a onclick="javascript: $('#systempay_standard').submit();" title="<?php echo smartyTranslate(array('s'=>'Click here to pay by bank card','mod'=>'systempay'),$_smarty_tpl);?>
">
			<?php } else { ?> 
				<a class="unclickable" title="<?php echo smartyTranslate(array('s'=>'Enter payment information and click «Pay now» button','mod'=>'systempay'),$_smarty_tpl);?>
">
			<?php }?>
				<span>
				
					<i class="ycon-credit-card"></i>
					<?php echo $_smarty_tpl->tpl_vars['systempay_std_title']->value;?>
		
				</span>		
				<form action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('systempay','redirect',array(),true);?>
" method="post" id="systempay_standard" name="systempay_standard" class="systempay_payment_form">
					<input type="hidden" name="systempay_payment_type" value="standard" />
					
					<?php if (($_smarty_tpl->tpl_vars['systempay_std_card_data_mode']->value==2)||($_smarty_tpl->tpl_vars['systempay_std_card_data_mode']->value==3)) {?>
						<br />
					
						<?php ob_start();?><?php echo count($_smarty_tpl->tpl_vars['systempay_avail_cards']->value);?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1==1) {?>
							<input type="hidden" id="systempay_card_type_<?php echo $_smarty_tpl->tpl_vars['systempay_avail_cards']->value[0];?>
" name="systempay_card_type" value="<?php echo $_smarty_tpl->tpl_vars['systempay_avail_cards']->value[0];?>
" style="vertical-align: middle;">
							<label for="systempay_card_type_<?php echo $_smarty_tpl->tpl_vars['systempay_avail_cards']->value[0];?>
"><img style="vertical-align: middle; margin-right:10px; height:20px;" src="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/systempay/views/images/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['systempay_avail_cards']->value[0], 'UTF-8');?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['systempay_avail_cards']->value[0];?>
" title="<?php echo $_smarty_tpl->tpl_vars['systempay_avail_cards']->value[0];?>
" /></label>
						<?php } else { ?>
							<?php $_smarty_tpl->tpl_vars['first'] = new Smarty_variable(true, null, 0);?>
							<?php  $_smarty_tpl->tpl_vars["card"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["card"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['systempay_avail_cards']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["card"]->key => $_smarty_tpl->tpl_vars["card"]->value) {
$_smarty_tpl->tpl_vars["card"]->_loop = true;
?>
								<?php if ($_smarty_tpl->tpl_vars['first']->value==true) {?>
									<input type="radio" id="systempay_card_type_<?php echo $_smarty_tpl->tpl_vars['card']->value;?>
" name="systempay_card_type" value="<?php echo $_smarty_tpl->tpl_vars['card']->value;?>
" style="vertical-align: middle;" checked="checked">
									<?php $_smarty_tpl->tpl_vars['first'] = new Smarty_variable(false, null, 0);?>
								<?php } else { ?>	
									<input type="radio" id="systempay_card_type_<?php echo $_smarty_tpl->tpl_vars['card']->value;?>
" name="systempay_card_type" value="<?php echo $_smarty_tpl->tpl_vars['card']->value;?>
" style="vertical-align: middle;">
								<?php }?>
								<label for="systempay_card_type_<?php echo $_smarty_tpl->tpl_vars['card']->value;?>
"><img style="vertical-align: middle; margin-right:10px; height:20px;" src="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/systempay/views/images/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['card']->value, 'UTF-8');?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['card']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['card']->value;?>
" /></label>
							<?php } ?>
						<?php }?>
				
						<?php if ($_smarty_tpl->tpl_vars['systempay_std_card_data_mode']->value==3) {?>
							<br /><br />
							<label for="systempay_card_number"> <?php echo smartyTranslate(array('s'=>'Card number','mod'=>'systempay'),$_smarty_tpl);?>
</label><br />
							<input type="text" name="systempay_card_number" value="" autocomplete="off" maxlength="19" id="systempay_card_number" size="30" maxlength="16" />
							
							<br /><br />
							<label for="systempay_cvv"> <?php echo smartyTranslate(array('s'=>'CVV','mod'=>'systempay'),$_smarty_tpl);?>
</label><br />
							<input type="text" name="systempay_cvv" value="" autocomplete="off" maxlength="4" id="systempay_cvv" size="5" maxlength="4" />
							
							<br /><br />
							<label for="systempay_expiry_month"><?php echo smartyTranslate(array('s'=>'Expiration date','mod'=>'systempay'),$_smarty_tpl);?>
</label><br />
							<select name="systempay_expiry_month" id="systempay_expiry_month" style="width: 70px;">
								<option value=""><?php echo smartyTranslate(array('s'=>'Month','mod'=>'systempay'),$_smarty_tpl);?>
</option>
								<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['name'] = 'expiry';
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] = (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'] = is_array($_loop=13) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total']);
?>
								<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['expiry']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['expiry']['index'];?>
</option>
								<?php endfor; endif; ?>
							</select>
										
							<select name="systempay_expiry_year" id="systempay_expiry_year" style="width: 70px;">
								<option value=""><?php echo smartyTranslate(array('s'=>'Year','mod'=>'systempay'),$_smarty_tpl);?>
</option>
								<?php $_smarty_tpl->tpl_vars['year'] = new Smarty_variable(smarty_modifier_date_format(time(),"%Y"), null, 0);?>
								<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['name'] = 'expiry';
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] = (int) $_smarty_tpl->tpl_vars['year']->value;
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['year']->value+9) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['expiry']['total']);
?>
								<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['expiry']['index'];?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['expiry']['index'];?>
</option>
								<?php endfor; endif; ?>
							</select>
						<?php }?>
							
						<br /><br />
						<?php if ($_smarty_tpl->tpl_vars['back_compat']->value) {?>
							<input type="submit" name="submit" value="<?php echo smartyTranslate(array('s'=>'Pay now','mod'=>'systempay'),$_smarty_tpl);?>
" class="button" />
						<?php } else { ?>
							<button type="submit" name="submit" class="button btn btn-default standard-checkout button-medium" >
								<span><?php echo smartyTranslate(array('s'=>'Pay now','mod'=>'systempay'),$_smarty_tpl);?>
</span>
							</button>
						<?php }?>
					<?php }?>
				</form>
			</a>
			
			<?php if ($_smarty_tpl->tpl_vars['systempay_std_card_data_mode']->value==3) {?> 
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
			 <?php }?>
		</div>
	</div><?php }} ?>
