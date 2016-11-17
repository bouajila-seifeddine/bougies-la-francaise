<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 10:59:47
         compiled from "/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/admincustomer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1536005383582d7f93db3982-17607336%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae4aac5c4cccc09b4bccfff4e3c0d91f65e95802' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/admincustomer.tpl',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1536005383582d7f93db3982-17607336',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'version16' => 0,
    'msg' => 0,
    'totals' => 0,
    'rewards_account' => 0,
    'new_reward_value' => 0,
    'sign' => 0,
    'new_reward_state' => 0,
    'rewardStateDefault' => 0,
    'rewardStateValidation' => 0,
    'rewardStateCancel' => 0,
    'new_reward_reason' => 0,
    'rewards' => 0,
    'reward' => 0,
    'states_for_update' => 0,
    'bUpdate' => 0,
    'rewardStateReturnPeriod' => 0,
    'payment_authorized' => 0,
    'payments' => 0,
    'payment' => 0,
    'module_template_dir' => 0,
    'customer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d7f93ee4ea8_49254547',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d7f93ee4ea8_49254547')) {function content_582d7f93ee4ea8_49254547($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<div class="<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>col-lg-12<?php } else { ?>clear<?php }?>" id="admincustomer">
<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
	<div class="panel">
		<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Rewards account','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
		<?php if ($_smarty_tpl->tpl_vars['msg']->value) {?><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
<?php }?>
<?php } else { ?>
		<h2><?php echo smartyTranslate(array('s'=>'Rewards account','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</h2>
		<?php if ($_smarty_tpl->tpl_vars['msg']->value) {?><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
<br><?php }?>
<?php }?>
<?php if ((float)$_smarty_tpl->tpl_vars['totals']->value['total']>0) {?>
	<?php if ((float)$_smarty_tpl->tpl_vars['totals']->value[RewardsStateModel::getValidationId()]>0) {?>
		<form id="rewards_reminder" method="post">
			<input class="button" name="submitRewardReminder" type="submit" value="<?php echo smartyTranslate(array('s'=>'Send an email with account balance :','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['totals']->value[RewardsStateModel::getValidationId()]),$_smarty_tpl);?>
" /> <?php if ($_smarty_tpl->tpl_vars['rewards_account']->value->date_last_remind&&$_smarty_tpl->tpl_vars['rewards_account']->value->date_last_remind!='0000-00-00 00:00:00') {?> (<?php echo smartyTranslate(array('s'=>'last email :','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['rewards_account']->value->date_last_remind,'full'=>1),$_smarty_tpl);?>
)<?php }?>
		</form><br>
	<?php }?>
		<table cellspacing="0" cellpadding="0" class="table">
			<thead>
				<tr style="background-color: #EEEEEE">
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Total rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Already converted','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Paid','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Available','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Awaiting validation','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Awaiting payment','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
			<tr>
				<td class="center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['totals']->value['total']),$_smarty_tpl);?>
</td>
				<td class="center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['totals']->value[RewardsStateModel::getConvertId()]),$_smarty_tpl);?>
</td>
				<td class="center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['totals']->value[RewardsStateModel::getPaidId()]),$_smarty_tpl);?>
</td>
				<td class="center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['totals']->value[RewardsStateModel::getValidationId()]),$_smarty_tpl);?>
</td>
				<td class="center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['totals']->value[RewardsStateModel::getDefaultId()]+$_smarty_tpl->tpl_vars['totals']->value[RewardsStateModel::getReturnPeriodId()]),$_smarty_tpl);?>
</td>
				<td class="center"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['totals']->value[RewardsStateModel::getWaitingPaymentId()]),$_smarty_tpl);?>
</td>
			</tr>
		</table>
<?php } else { ?>
	<?php echo smartyTranslate(array('s'=>'This customer has no reward','mod'=>'allinone_rewards'),$_smarty_tpl);?>

<?php }?>
<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
	</div>
	<form id="rewards_history" method="post">
	<div class="panel">
		<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Add a new reward','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
<?php } else { ?>
		<form id="rewards_history" method="post">
		<h3><?php echo smartyTranslate(array('s'=>'Add a new reward','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</h3>
<?php }?>
		<?php echo smartyTranslate(array('s'=>'Value','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <input name="new_reward_value" type="text" size="6" value="<?php echo $_smarty_tpl->tpl_vars['new_reward_value']->value;?>
" style="text-align: right; display: inline; width: auto"/> <?php echo $_smarty_tpl->tpl_vars['sign']->value;?>
&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo smartyTranslate(array('s'=>'Status','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <select name="new_reward_state" style="display: inline; width: auto">
			<option <?php if ($_smarty_tpl->tpl_vars['new_reward_state']->value==RewardsStateModel::getDefaultId()) {?>selected<?php }?> value="<?php echo RewardsStateModel::getDefaultId();?>
"><?php echo $_smarty_tpl->tpl_vars['rewardStateDefault']->value;?>
</option>
			<option <?php if ($_smarty_tpl->tpl_vars['new_reward_state']->value==RewardsStateModel::getValidationId()) {?>selected<?php }?> value="<?php echo RewardsStateModel::getValidationId();?>
"><?php echo $_smarty_tpl->tpl_vars['rewardStateValidation']->value;?>
</option>
			<option <?php if ($_smarty_tpl->tpl_vars['new_reward_state']->value==RewardsStateModel::getCancelId()) {?>selected<?php }?> value="<?php echo RewardsStateModel::getCancelId();?>
"><?php echo $_smarty_tpl->tpl_vars['rewardStateCancel']->value;?>
</option>
		</select>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo smartyTranslate(array('s'=>'Reason','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <input name="new_reward_reason" type="text" size="40" maxlength="80" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['new_reward_reason']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" style="display: inline; width: auto"/>
		<input class="button" name="submitNewReward" type="submit" value="<?php echo smartyTranslate(array('s'=>'Save settings','mod'=>'allinone_rewards'),$_smarty_tpl);?>
"/>
<?php if ((float)$_smarty_tpl->tpl_vars['totals']->value['total']>0) {?>
	<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
	</div>
	<div class="panel">
		<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Rewards history','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
	<?php } else { ?>
		<h3><?php echo smartyTranslate(array('s'=>'Rewards history','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</h3>
	<?php }?>
		<input type="hidden" id="id_reward_to_update" name="id_reward_to_update" />
		<table cellspacing="0" cellpadding="0" class="table">
			<thead>
				<tr style="background-color: #EEEEEE">
					<th><?php echo smartyTranslate(array('s'=>'Event','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Date','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Total (without shipping)','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Reward','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Status','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Action','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
	<?php  $_smarty_tpl->tpl_vars['reward'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reward']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rewards']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['reward']->key => $_smarty_tpl->tpl_vars['reward']->value) {
$_smarty_tpl->tpl_vars['reward']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']++;
?>
		<?php ob_start();?><?php echo in_array($_smarty_tpl->tpl_vars['reward']->value['id_reward_state'],$_smarty_tpl->tpl_vars['states_for_update']->value);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["bUpdate"] = new Smarty_variable($_tmp1, null, 0);?>
			<tr class="<?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['iteration']%2)==0) {?>alt_row<?php }?>">
				<td><?php if (($_smarty_tpl->tpl_vars['bUpdate']->value&&$_smarty_tpl->tpl_vars['reward']->value['plugin']=="free")) {?><input name="reward_reason_<?php echo $_smarty_tpl->tpl_vars['reward']->value['id_reward'];?>
" type="text" size="30" maxlength="80" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['reward']->value['detail'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" /><?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['reward']->value['detail'];?>
<?php if ((int)$_smarty_tpl->tpl_vars['reward']->value['id_order']>0) {?> - <a href="?tab=AdminOrders&id_order=<?php echo $_smarty_tpl->tpl_vars['reward']->value['id_order'];?>
&vieworder&token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminOrders'),$_smarty_tpl);?>
" style="display: inline; width: auto"><?php echo smartyTranslate(array('s'=>'#','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php echo sprintf('%06d',$_smarty_tpl->tpl_vars['reward']->value['id_order']);?>
</a><?php }?><?php }?></td>
				<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['reward']->value['date'],'full'=>1),$_smarty_tpl);?>
</td>
				<td align="right"><?php if ((int)$_smarty_tpl->tpl_vars['reward']->value['id_order']>0) {?><?php echo Tools::displayPrice(round(Tools::convertPrice($_smarty_tpl->tpl_vars['reward']->value['total_without_shipping'],Currency::getCurrency($_smarty_tpl->tpl_vars['reward']->value['id_currency']),false),2),(int)Configuration::get('PS_CURRENCY_DEFAULT'));?>
<?php } else { ?>-<?php }?></td>
				<td align="right"><?php if ($_smarty_tpl->tpl_vars['bUpdate']->value) {?><input name="reward_value_<?php echo $_smarty_tpl->tpl_vars['reward']->value['id_reward'];?>
" type="text" size="6" value="<?php echo (float)$_smarty_tpl->tpl_vars['reward']->value['credits'];?>
" style="text-align: right; display: inline; width: auto"/> <?php echo $_smarty_tpl->tpl_vars['sign']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['reward']->value['credits']),$_smarty_tpl);?>
<?php }?></td>
				<td><?php if ($_smarty_tpl->tpl_vars['bUpdate']->value) {?>
					<select name="reward_state_<?php echo $_smarty_tpl->tpl_vars['reward']->value['id_reward'];?>
" style="display: inline; width: auto">
						<option <?php if ($_smarty_tpl->tpl_vars['reward']->value['id_reward_state']==RewardsStateModel::getDefaultId()) {?>selected<?php }?> value="<?php echo RewardsStateModel::getDefaultId();?>
"><?php echo $_smarty_tpl->tpl_vars['rewardStateDefault']->value;?>
</option>
						<option <?php if ($_smarty_tpl->tpl_vars['reward']->value['id_reward_state']==RewardsStateModel::getValidationId()) {?>selected<?php }?> value="<?php echo RewardsStateModel::getValidationId();?>
"><?php echo $_smarty_tpl->tpl_vars['rewardStateValidation']->value;?>
</option>
						<option <?php if ($_smarty_tpl->tpl_vars['reward']->value['id_reward_state']==RewardsStateModel::getCancelId()) {?>selected<?php }?> value="<?php echo RewardsStateModel::getCancelId();?>
"><?php echo $_smarty_tpl->tpl_vars['rewardStateCancel']->value;?>
</option>
						<?php if (($_smarty_tpl->tpl_vars['reward']->value['id_reward_state']==RewardsStateModel::getReturnPeriodId()||((int)$_smarty_tpl->tpl_vars['reward']->value['id_order']>0&&Configuration::get('REWARDS_WAIT_RETURN_PERIOD')&&Configuration::get('PS_ORDER_RETURN')&&(int)Configuration::get('PS_ORDER_RETURN_NB_DAYS')>0))) {?>
						<option <?php if ($_smarty_tpl->tpl_vars['reward']->value['id_reward_state']==RewardsStateModel::getReturnPeriodId()) {?>selected<?php }?> value="<?php echo RewardsStateModel::getReturnPeriodId();?>
"><?php echo $_smarty_tpl->tpl_vars['rewardStateReturnPeriod']->value;?>
 <?php echo smartyTranslate(array('s'=>'(Return period)','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</option>
						<?php }?>
					</select>
					<?php } else { ?>
					<?php echo $_smarty_tpl->tpl_vars['reward']->value['state'];?>

					<?php }?>
				</td>
				<td><?php if ($_smarty_tpl->tpl_vars['bUpdate']->value) {?><input class="button" name="submitRewardUpdate" type="submit" value="<?php echo smartyTranslate(array('s'=>'Save settings','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" onClick="$('#id_reward_to_update').val(<?php echo $_smarty_tpl->tpl_vars['reward']->value['id_reward'];?>
)"><?php }?></td>
			</tr>
	<?php } ?>
		</table>

	<?php if ($_smarty_tpl->tpl_vars['payment_authorized']->value) {?>
		<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
	</div>
	<div class="panel">
		<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Payments history','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
		<?php } else { ?>
		<h3><?php echo smartyTranslate(array('s'=>'Payments history','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</h3>
		<?php }?>
		<?php if ((count($_smarty_tpl->tpl_vars['payments']->value))) {?>
		<table cellspacing="0" cellpadding="0" class="table">
			<thead>
				<tr style="background-color: #EEEEEE">
					<th><?php echo smartyTranslate(array('s'=>'Request date','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Payment date','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style="text-align: right"><?php echo smartyTranslate(array('s'=>'Value','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Details','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Invoice','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Action','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
			<?php  $_smarty_tpl->tpl_vars['payment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['payments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['payment']->key => $_smarty_tpl->tpl_vars['payment']->value) {
$_smarty_tpl->tpl_vars['payment']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']++;
?>
			<tr class="<?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['iteration']%2)==0) {?>alt_row<?php }?>">
				<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['payment']->value['date_add'],'full'=>1),$_smarty_tpl);?>
</td>
				<td><?php if ($_smarty_tpl->tpl_vars['payment']->value['paid']) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['payment']->value['date_upd'],'full'=>1),$_smarty_tpl);?>
<?php } else { ?>-<?php }?></td>
				<td style="text-align: right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['payment']->value['credits']),$_smarty_tpl);?>
</td>
				<td><?php echo nl2br($_smarty_tpl->tpl_vars['payment']->value['detail']);?>
</td>
				<td class="center"><?php if ($_smarty_tpl->tpl_vars['payment']->value['invoice']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
uploads/<?php echo $_smarty_tpl->tpl_vars['payment']->value['invoice'];?>
" download="Invoice.pdf"><?php echo smartyTranslate(array('s'=>'View','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a><?php } else { ?>-<?php }?></td>
				<td class="center"><?php if (!$_smarty_tpl->tpl_vars['payment']->value['paid']) {?><a href="index.php?tab=AdminCustomers&id_customer=<?php echo $_smarty_tpl->tpl_vars['customer']->value->id;?>
&viewcustomer&token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCustomers'),$_smarty_tpl);?>
&accept_payment=<?php echo $_smarty_tpl->tpl_vars['payment']->value['id_payment'];?>
"><?php echo smartyTranslate(array('s'=>'Mark as paid','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a><?php } else { ?>-<?php }?></td>
			</tr>
			<?php } ?>
		</table>
		<?php } else { ?>
			<?php echo smartyTranslate(array('s'=>'No payment request found','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php }?>
	<?php }?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
	</div>
<?php }?>
	</form>
</div>
<!-- END : MODULE allinone_rewards --><?php }} ?>
