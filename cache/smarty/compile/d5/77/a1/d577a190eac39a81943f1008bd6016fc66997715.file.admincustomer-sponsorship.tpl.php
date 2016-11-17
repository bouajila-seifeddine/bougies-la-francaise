<?php /* Smarty version Smarty-3.1.19, created on 2016-11-16 16:50:11
         compiled from "/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/admincustomer-sponsorship.tpl" */ ?>
<?php /*%%SmartyHeaderCode:362933222582c80338e98e6-10288930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd577a190eac39a81943f1008bd6016fc66997715' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/admincustomer-sponsorship.tpl',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '362933222582c80338e98e6-10288930',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'version16' => 0,
    'msg' => 0,
    'sponsor' => 0,
    'available_sponsors' => 0,
    'new_sponsor' => 0,
    'discount_gc' => 0,
    'currencies' => 0,
    'default_currency' => 0,
    'currency' => 0,
    'friends' => 0,
    'stats' => 0,
    'sponsored' => 0,
    'channel' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582c8033980a93_67802132',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582c8033980a93_67802132')) {function content_582c8033980a93_67802132($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<div class="<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>col-lg-12<?php } else { ?>clear<?php }?>" id="admincustomer_sponsorship">
<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
	<div class="panel">
		<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Sponsorship program','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
		<?php if ($_smarty_tpl->tpl_vars['msg']->value) {?><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
<?php }?>
<?php } else { ?>
		<h2><?php echo smartyTranslate(array('s'=>'Sponsorship program','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</h2>
		<?php if ($_smarty_tpl->tpl_vars['msg']->value) {?><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
<br><?php }?>
<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['sponsor']->value) {?>
			<?php echo smartyTranslate(array('s'=>'Sponsor','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <a href="?tab=AdminCustomers&id_customer=<?php echo $_smarty_tpl->tpl_vars['sponsor']->value->id;?>
&viewcustomer&token=<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['getAdminToken'][0][0]->getAdminTokenLiteSmarty(array('tab'=>'AdminCustomers'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['sponsor']->value->firstname;?>
 <?php echo $_smarty_tpl->tpl_vars['sponsor']->value->lastname;?>
</a><br>
		<?php } else { ?>
		<form id='sponsor' method='post'>
			<?php echo smartyTranslate(array('s'=>'Choose a sponsor :','mod'=>'allinone_rewards'),$_smarty_tpl);?>
&nbsp;
			&nbsp;<input class="button" name="submitSponsor" id="submitSponsor" value="<?php echo smartyTranslate(array('s'=>'Save settings','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" type="submit" />
			<select name="new_sponsor" style="display: inline; width: auto;">
				<option value="0"><?php echo smartyTranslate(array('s'=>'-- No sponsor --','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</option>
			<?php  $_smarty_tpl->tpl_vars['new_sponsor'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['new_sponsor']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['available_sponsors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['new_sponsor']->key => $_smarty_tpl->tpl_vars['new_sponsor']->value) {
$_smarty_tpl->tpl_vars['new_sponsor']->_loop = true;
?>
				<option value='<?php echo $_smarty_tpl->tpl_vars['new_sponsor']->value['id_customer'];?>
'><?php echo $_smarty_tpl->tpl_vars['new_sponsor']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['new_sponsor']->value['lastname'];?>
 (ID : <?php echo $_smarty_tpl->tpl_vars['new_sponsor']->value['id_customer'];?>
)</option>
			<?php } ?>
			</select>
			<?php if ($_smarty_tpl->tpl_vars['discount_gc']->value) {?>
				&nbsp;&nbsp;&nbsp;&nbsp;<?php echo smartyTranslate(array('s'=>'Generate the welcome voucher ?','mod'=>'allinone_rewards'),$_smarty_tpl);?>
&nbsp;<input checked type="checkbox" value="1" name="generate_voucher" style="display: inline; width: auto;">&nbsp;
				<select name="generate_currency" style="display: inline !important; width: auto;">
				<?php  $_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['currency']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->key => $_smarty_tpl->tpl_vars['currency']->value) {
$_smarty_tpl->tpl_vars['currency']->_loop = true;
?>
					<option <?php if ($_smarty_tpl->tpl_vars['default_currency']->value==$_smarty_tpl->tpl_vars['currency']->value['id_currency']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['currency']->value['id_currency'];?>
"><?php echo $_smarty_tpl->tpl_vars['currency']->value['name'];?>
</option>
				<?php } ?>
				</select>
			<?php }?>
		</form>
		<br>
		<?php }?>
		<?php if (count($_smarty_tpl->tpl_vars['friends']->value)) {?>
		<table cellspacing='0' cellpadding='0' class='table'>
			<thead>
				<tr style="background-color: #EEEEEE">
					<th colspan='2' style='text-align: center'><?php echo smartyTranslate(array('s'=>'Rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th colspan='5' style='text-align: center'><?php echo smartyTranslate(array('s'=>'Sponsored friends (Level 1)','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
				</tr>
				<tr style="background-color: #EEEEEE">
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Direct rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Indirect rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Pending','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Registered','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'With orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Total','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
			<tr>
				<td align='center'><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['stats']->value['direct_rewards']),$_smarty_tpl);?>
</td>
				<td align='center'><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['stats']->value['indirect_rewards']),$_smarty_tpl);?>
</td>
				<td align='center'><?php echo $_smarty_tpl->tpl_vars['stats']->value['nb_pending'];?>
</td>
				<td align='center'><?php echo $_smarty_tpl->tpl_vars['stats']->value['nb_registered'];?>
</td>
				<td align='center'><?php echo $_smarty_tpl->tpl_vars['stats']->value['nb_buyers'];?>
</td>
				<td align='center'><?php echo $_smarty_tpl->tpl_vars['stats']->value['nb_orders'];?>
</td>
				<td align='center'><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['stats']->value['total_orders']),$_smarty_tpl);?>
</td>
			</tr>
		</table>
		<div class='clear' style="margin-top: 20px">&nbsp;</div>
		<table cellspacing='0' cellpadding='0' class='table'>
			<thead>
				<tr style="background-color: #EEEEEE">
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Levels','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Channels','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th><?php echo smartyTranslate(array('s'=>'Name of the friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: center'><?php echo smartyTranslate(array('s'=>'Number of orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: right'><?php echo smartyTranslate(array('s'=>'Total orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<th style='text-align: right'><?php echo smartyTranslate(array('s'=>'Total rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
				</tr>
			</thead>
			<?php  $_smarty_tpl->tpl_vars['sponsored'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sponsored']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['friends']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sponsored']->key => $_smarty_tpl->tpl_vars['sponsored']->value) {
$_smarty_tpl->tpl_vars['sponsored']->_loop = true;
?>
				<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Email invitation','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["channel"] = new Smarty_variable($_tmp2, null, 0);?>
				<?php if (($_smarty_tpl->tpl_vars['sponsored']->value['channel']==2)) {?>
					<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Sponsorship link','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php $_tmp3=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["channel"] = new Smarty_variable($_tmp3, null, 0);?>
				<?php } elseif (($_smarty_tpl->tpl_vars['sponsored']->value['channel']==3)) {?>
					<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Facebook','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php $_tmp4=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["channel"] = new Smarty_variable($_tmp4, null, 0);?>
				<?php } elseif (($_smarty_tpl->tpl_vars['sponsored']->value['channel']==4)) {?>
					<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Twitter','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php $_tmp5=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["channel"] = new Smarty_variable($_tmp5, null, 0);?>
				<?php } elseif (($_smarty_tpl->tpl_vars['sponsored']->value['channel']==5)) {?>
					<?php ob_start();?><?php echo smartyTranslate(array('s'=>'Google +1','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php $_tmp6=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["channel"] = new Smarty_variable($_tmp6, null, 0);?>
				<?php }?>
			<tr>
				<td align='center'><?php echo $_smarty_tpl->tpl_vars['sponsored']->value['level_sponsorship'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['channel']->value;?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['sponsored']->value['lastname'];?>
 <?php echo $_smarty_tpl->tpl_vars['sponsored']->value['firstname'];?>
</td>
				<td align='center'><?php echo $_smarty_tpl->tpl_vars['sponsored']->value['nb_orders'];?>
</td>
				<td align='right'><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['sponsored']->value['total_orders']),$_smarty_tpl);?>
</td>
				<td align='right'><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['sponsored']->value['total_rewards']),$_smarty_tpl);?>
</td>
			</tr>
			<?php } ?>
		</table>
		<?php } else { ?>
			<?php echo smartyTranslate(array('s'=>'This customer has not sponsored any friends yet.','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php }?>
<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
	</div>
<?php }?>
</div>
<!-- END : MODULE allinone_rewards --><?php }} ?>
