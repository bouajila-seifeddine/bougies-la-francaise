<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:05:39
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/front/sponsorship.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1940418354581a0ed3ea8827-53289254%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '543c8ffde7be726515c1a0ae2053c119751e1715' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/front/sponsorship.tpl',
      1 => 1475244922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1940418354581a0ed3ea8827-53289254',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'popup' => 0,
    'getcontact' => 0,
    'navigationPipe' => 0,
    'version16' => 0,
    'error' => 0,
    'mails_exists' => 0,
    'mail' => 0,
    'invitation_sent' => 0,
    'sms_sent' => 0,
    'nbInvitation' => 0,
    'revive_sent' => 0,
    'nbRevive' => 0,
    'activeTab' => 0,
    'reward_allowed_s' => 0,
    'text' => 0,
    'afterSubmit' => 0,
    'canSendInvitations' => 0,
    'link_sponsorship_fb' => 0,
    'rewards_path' => 0,
    'link_sponsorship_twitter' => 0,
    'link_sponsorship_google' => 0,
    'open_inviter_providers' => 0,
    'provider' => 0,
    'details' => 0,
    'base_dir_ssl' => 0,
    'link_sponsorship' => 0,
    'email' => 0,
    'code' => 0,
    'sms' => 0,
    'nbFriends' => 0,
    'sback' => 0,
    'orderQuantityS' => 0,
    'pendingFriends' => 0,
    'pendingFriend' => 0,
    'subscribeFriends' => 0,
    'subscribeFriend' => 0,
    'statistics' => 0,
    'multilevel' => 0,
    'indiceFriends' => 0,
    'indiceOrders' => 0,
    'indiceRewards' => 0,
    'sponsored' => 0,
    'indiceDirect' => 0,
    'indiceIndirect' => 0,
    'valueDirect' => 0,
    'valueIndirect' => 0,
    'open_inviter_contacts' => 0,
    'name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a0ed433ae40_37871807',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a0ed433ae40_37871807')) {function content_581a0ed433ae40_37871807($_smarty_tpl) {?><script type="text/javascript">
//<![CDATA[
	var msg = "<?php echo smartyTranslate(array('s'=>'You must agree to the terms of service before continuing.','mod'=>'allinone_rewards'),$_smarty_tpl);?>
";
	var url_allinone_sponsorship="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
";
//]]>
</script>

<?php $_smarty_tpl->tpl_vars["sback"] = new Smarty_variable("0", null, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['popup']->value)) {?>
	<?php $_smarty_tpl->tpl_vars["sback"] = new Smarty_variable("1", null, 0);?>
<?php }?>

<?php if (!isset($_smarty_tpl->tpl_vars['getcontact']->value)) {?>
<div id="rewards_sponsorship" class="rewards">
	<?php if (!isset($_smarty_tpl->tpl_vars['popup']->value)) {?>
		<?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPageLink('my-account',true);?>
"><?php echo smartyTranslate(array('s'=>'My account','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a><span class="navigation-pipe"><?php echo $_smarty_tpl->tpl_vars['navigationPipe']->value;?>
</span><?php echo smartyTranslate(array('s'=>'Sponsorship program','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

		<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
	<h1 class="page-heading"><?php echo smartyTranslate(array('s'=>'Sponsorship program','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</h1>
		<?php } else { ?>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./breadcrumb.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


	<h2><?php echo smartyTranslate(array('s'=>'Sponsorship program','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</h2>
		<?php }?>
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['error']->value) {?>
	<p class="error">
		<?php if ($_smarty_tpl->tpl_vars['error']->value=='email invalid') {?>
			<?php echo smartyTranslate(array('s'=>'At least one email address is invalid!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='name invalid') {?>
			<?php echo smartyTranslate(array('s'=>'At least one first name or last name is invalid!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='email exists') {?>
			<?php echo smartyTranslate(array('s'=>'Someone with this email address has already been sponsored','mod'=>'allinone_rewards'),$_smarty_tpl);?>
: <?php  $_smarty_tpl->tpl_vars['mail'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mail']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mails_exists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mail']->key => $_smarty_tpl->tpl_vars['mail']->value) {
$_smarty_tpl->tpl_vars['mail']->_loop = true;
?><?php echo $_smarty_tpl->tpl_vars['mail']->value;?>
 <?php } ?><br>
		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='no revive checked') {?>
			<?php echo smartyTranslate(array('s'=>'Please mark at least one checkbox','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='bad phone') {?>
			<?php echo smartyTranslate(array('s'=>'The mobile phone is invalid','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='sms already sent') {?>
			<?php echo smartyTranslate(array('s'=>'This mobile phone has already been invited during last 10 days, please retry later.','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='sms impossible') {?>
			<?php echo smartyTranslate(array('s'=>'An error occured, the SMS has not been sent','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php }?>
	</p>
	<?php }?>

	<?php if (($_smarty_tpl->tpl_vars['invitation_sent']->value||$_smarty_tpl->tpl_vars['sms_sent']->value)&&isset($_smarty_tpl->tpl_vars['popup']->value)) {?>
	<p class="success popup">
		<?php if ($_smarty_tpl->tpl_vars['sms_sent']->value) {?>
		<?php echo smartyTranslate(array('s'=>'A SMS has been sent to your friend!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['nbInvitation']->value>1) {?>
		<?php echo smartyTranslate(array('s'=>'Emails have been sent to your friends!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } else { ?>
		<?php echo smartyTranslate(array('s'=>'An email has been sent to your friend!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php }?>
	</p>
	<?php } else { ?>
		<?php if ($_smarty_tpl->tpl_vars['invitation_sent']->value||$_smarty_tpl->tpl_vars['sms_sent']->value) {?>
	<p class="success">
			<?php if ($_smarty_tpl->tpl_vars['sms_sent']->value) {?>
		<?php echo smartyTranslate(array('s'=>'A SMS has been sent to your friend!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			<?php } elseif ($_smarty_tpl->tpl_vars['nbInvitation']->value>1) {?>
		<?php echo smartyTranslate(array('s'=>'Emails have been sent to your friends!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			<?php } else { ?>
		<?php echo smartyTranslate(array('s'=>'An email has been sent to your friend!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			<?php }?>
	</p>
		<?php }?>

		<?php if (!isset($_smarty_tpl->tpl_vars['popup']->value)&&$_smarty_tpl->tpl_vars['revive_sent']->value) {?>
	<p class="success">
			<?php if ($_smarty_tpl->tpl_vars['nbRevive']->value>1) {?>
		<?php echo smartyTranslate(array('s'=>'Reminder emails have been sent to your friends!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			<?php } else { ?>
		<?php echo smartyTranslate(array('s'=>'A reminder email has been sent to your friend!','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			<?php }?>
	</p>
		<?php }?>

		<?php if (!isset($_smarty_tpl->tpl_vars['popup']->value)) {?>
	<ul class="idTabs">
		<li><a href="#idTab1" <?php if ($_smarty_tpl->tpl_vars['activeTab']->value=='sponsor') {?>class="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Sponsor my friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a></li>
		<li><a href="#idTab2" <?php if ($_smarty_tpl->tpl_vars['activeTab']->value=='pending') {?>class="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Pending friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a></li>
		<li><a href="#idTab3" <?php if ($_smarty_tpl->tpl_vars['activeTab']->value=='subscribed') {?>class="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Friends I sponsored','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a></li>
			<?php if ($_smarty_tpl->tpl_vars['reward_allowed_s']->value) {?>
		<li><a href="#idTab4" <?php if ($_smarty_tpl->tpl_vars['activeTab']->value=='statistics') {?>class="selected"<?php }?>><?php echo smartyTranslate(array('s'=>'Statistics','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a></li>
			<?php }?>
	</ul>
	<div class="sheets">
		<div id="idTab1" class="sponsorshipBlock">
		<?php } else { ?>
		<div class="sponsorshipBlock sponsorshipPopup">
		<?php }?>

		<?php if (isset($_smarty_tpl->tpl_vars['text']->value)) {?>
			<div id="sponsorship_text" <?php if (isset($_smarty_tpl->tpl_vars['popup']->value)&&$_smarty_tpl->tpl_vars['afterSubmit']->value) {?>style="display: none"<?php }?>>
				<?php echo $_smarty_tpl->tpl_vars['text']->value;?>

			<?php if (isset($_smarty_tpl->tpl_vars['popup']->value)) {?>
				<div align="center">
					<input id="invite" type="button" class="button" value="<?php echo smartyTranslate(array('s'=>'Invite my friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" />
					<input id="noinvite" type="button" class="button" value="<?php echo smartyTranslate(array('s'=>'No, thanks','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" />
				</div>
			<?php }?>
			</div>
		<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['canSendInvitations']->value||isset($_smarty_tpl->tpl_vars['popup']->value)) {?>
			<div id="sponsorship_form"  <?php if (isset($_smarty_tpl->tpl_vars['popup']->value)&&!$_smarty_tpl->tpl_vars['afterSubmit']->value) {?>style="display: none"<?php }?>>
				<div>
				<?php echo smartyTranslate(array('s'=>'Sponsorship is quick and easy. You can invite your friends in different ways :','mod'=>'allinone_rewards'),$_smarty_tpl);?>

				<ul>
					<li><?php echo smartyTranslate(array('s'=>'Propose your sponsorship on the social networks, by clicking the following links','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<br>
						&nbsp;<a href="http://www.facebook.com/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['link_sponsorship_fb']->value;?>
" target="_blank" title="<?php echo smartyTranslate(array('s'=>'Facebook','mod'=>'allinone_rewards'),$_smarty_tpl);?>
"><img src='<?php echo $_smarty_tpl->tpl_vars['rewards_path']->value;?>
images/facebook.png' height='20'></a>
						&nbsp;<a href="http://twitter.com/share?url=<?php echo $_smarty_tpl->tpl_vars['link_sponsorship_twitter']->value;?>
" target="_blank" title="<?php echo smartyTranslate(array('s'=>'Twitter','mod'=>'allinone_rewards'),$_smarty_tpl);?>
"><img src='<?php echo $_smarty_tpl->tpl_vars['rewards_path']->value;?>
images/twitter.png' height='20'></a>
						&nbsp;<a href="https://plus.google.com/share?url=<?php echo $_smarty_tpl->tpl_vars['link_sponsorship_google']->value;?>
" target="_blank" title="<?php echo smartyTranslate(array('s'=>'Google+','mod'=>'allinone_rewards'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['rewards_path']->value;?>
images/google.png"></a>
					</li>
			<?php if ($_smarty_tpl->tpl_vars['open_inviter_providers']->value&&count($_smarty_tpl->tpl_vars['open_inviter_providers']->value)) {?>
					<li><?php echo smartyTranslate(array('s'=>'Invite your friends from your contacts\' lists','mod'=>'allinone_rewards'),$_smarty_tpl);?>
&nbsp;
						<form id="open_inviter_form" style="display: inline">
							<select id='provider' name='provider'>
								<option value=''></option>
				<?php  $_smarty_tpl->tpl_vars['details'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['details']->_loop = false;
 $_smarty_tpl->tpl_vars['provider'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['open_inviter_providers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['details']->key => $_smarty_tpl->tpl_vars['details']->value) {
$_smarty_tpl->tpl_vars['details']->_loop = true;
 $_smarty_tpl->tpl_vars['provider']->value = $_smarty_tpl->tpl_vars['details']->key;
?>
								<option value='<?php echo $_smarty_tpl->tpl_vars['provider']->value;?>
'><?php echo $_smarty_tpl->tpl_vars['details']->value['name'];?>
</option>
				<?php } ?>
							</select>
							<br/><?php echo smartyTranslate(array('s'=>'Be assured your login information will not be registered or used for other purposes','mod'=>'allinone_rewards'),$_smarty_tpl);?>

							<div>
								<span><?php echo smartyTranslate(array('s'=>'Email','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</span><input type="text" name="login" size="30" value="<?php if (isset($_POST['login'])) {?><?php echo $_POST['login'];?>
<?php }?>" /><br style="clear: both"/>
								<span><?php echo smartyTranslate(array('s'=>'Password','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</span><input type="password" name="password" size="30" value="<?php if (isset($_POST['password'])) {?><?php echo $_POST['password'];?>
<?php }?>" /><br style="clear: both"/>
								<span>&nbsp;</span><input type="submit" id="submitOpenInviter" name="submitOpenInviter" value="<?php echo smartyTranslate(array('s'=>'View list','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" />
							</div>
						</form>
						<div id="open_inviter_contacts">
							<center><img src="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/allinone_rewards/images/loadingAnimation.gif"></center>
						</div>
					</li>
			<?php }?>
					<li><?php echo smartyTranslate(array('s'=>'Give this sponsorship link to your friends, or post it on internet (forums, blog...)','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<br><?php echo $_smarty_tpl->tpl_vars['link_sponsorship']->value;?>
</li>
					<li><?php echo smartyTranslate(array('s'=>'Give them your mail','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <b><?php echo $_smarty_tpl->tpl_vars['email']->value;?>
</b> <?php echo smartyTranslate(array('s'=>'or your sponsor code','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <b><?php echo $_smarty_tpl->tpl_vars['code']->value;?>
</b> <?php echo smartyTranslate(array('s'=>'to enter in the registration form.','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</li>
			<?php if ($_smarty_tpl->tpl_vars['sms']->value) {?>
					<li>
						<form id="sms_form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
" style="display: inline"><?php echo smartyTranslate(array('s'=>'Enter their mobile phone (international format) and send them a SMS','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <input id="phone" name="phone" maxlength="16" type="text" placeholder="<?php echo smartyTranslate(array('s'=>'e.g. +33612345678','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" />
							<input type="image" src="<?php echo $_smarty_tpl->tpl_vars['base_dir_ssl']->value;?>
modules/allinone_rewards/images/sendsms.gif" id="submitSponsorSMS" name="submitSponsorSMS" alt="<?php echo smartyTranslate(array('s'=>'Send SMS','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" title="<?php echo smartyTranslate(array('s'=>'Send SMS','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" align="absmiddle" />
						</form>
					</li>
			<?php }?>
					<li><?php echo smartyTranslate(array('s'=>'Fill in the following form and they will receive an mail.','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</li>
				</ul>
				</div>
				<div>
					<form id="list_contacts_form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
">
						<table class="std">
						<thead>
							<tr>
								<th class="first_item">&nbsp;</th>
								<th class="item"><?php echo smartyTranslate(array('s'=>'Last name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
								<th class="item"><?php echo smartyTranslate(array('s'=>'First name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
								<th class="last_item"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
							</tr>
						</thead>
						<tbody>
							<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['friends'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['name'] = 'friends';
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start'] = (int) 0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['nbFriends']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['friends']['total']);
?>
							<tr class="alternate_item">
								<td class="align_right"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['friends']['iteration'];?>
</td>
								<td><input type="text" class="text" name="friendsLastName[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['friends']['index'];?>
]" size="20" value="<?php if (isset($_POST['friendsLastName'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['friends']['index']])) {?><?php echo $_POST['friendsLastName'][$_smarty_tpl->getVariable('smarty')->value['section']['friends']['index']];?>
<?php }?>" /></td>
								<td><input type="text" class="text" name="friendsFirstName[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['friends']['index'];?>
]" size="20" value="<?php if (isset($_POST['friendsFirstName'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['friends']['index']])) {?><?php echo $_POST['friendsFirstName'][$_smarty_tpl->getVariable('smarty')->value['section']['friends']['index']];?>
<?php }?>" /></td>
								<td><input type="text" class="text" name="friendsEmail[<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['friends']['index'];?>
]" size="20" value="<?php if (isset($_POST['friendsEmail'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['section']['friends']['index']])) {?><?php echo $_POST['friendsEmail'][$_smarty_tpl->getVariable('smarty')->value['section']['friends']['index']];?>
<?php }?>" /></td>
							</tr>
							<?php endfor; endif; ?>
						</tbody>
						</table>
						<p class="bold">
							<?php echo smartyTranslate(array('s'=>'Important: Your friends\' email addresses will only be used in the sponsorship program. They will never be used for other purposes.','mod'=>'allinone_rewards'),$_smarty_tpl);?>

						</p>
						<p class="checkbox">
							<input class="cgv" type="checkbox" name="conditionsValided" id="conditionsValided" value="1" <?php if (isset($_POST['conditionsValided'])&&$_POST['conditionsValided']==1) {?>checked="checked"<?php }?> />&nbsp;
							<label for="conditionsValided"><?php echo smartyTranslate(array('s'=>'I agree to the terms of service and adhere to them unconditionally.','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</label>
							<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','rules',array('sback'=>$_smarty_tpl->tpl_vars['sback']->value),true);?>
" class="fancybox rules" title="<?php echo smartyTranslate(array('s'=>'Conditions of the sponsorship program','mod'=>'allinone_rewards'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Read conditions','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a>
						</p>
						<p>
							<?php echo smartyTranslate(array('s'=>'Preview','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','email',array('sback'=>$_smarty_tpl->tpl_vars['sback']->value),true);?>
" class="fancybox mail" title="<?php echo smartyTranslate(array('s'=>'Invitation email','mod'=>'allinone_rewards'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'the default email','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a> <?php echo smartyTranslate(array('s'=>'that will be sent to your friends.','mod'=>'allinone_rewards'),$_smarty_tpl);?>

						</p>
						<p class="submit" align="center">
							<input type="submit" id="submitSponsorFriends" name="submitSponsorFriends" class="button_large" value="<?php echo smartyTranslate(array('s'=>'Send invitations','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" />
						</p>
					</form>
				</div>
			</div>
		<?php } else { ?>
			<div>
				<?php echo smartyTranslate(array('s'=>'To become a sponsor, you need to have completed at least','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['orderQuantityS']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['orderQuantityS']->value>1) {?><?php echo smartyTranslate(array('s'=>'orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php } else { ?><?php echo smartyTranslate(array('s'=>'order','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php }?>.
			</div>
		<?php }?>
		</div>

		<?php if (!isset($_smarty_tpl->tpl_vars['popup']->value)) {?>
		<div id="idTab2" class="sponsorshipBlock">
			<?php if ($_smarty_tpl->tpl_vars['pendingFriends']->value&&count($_smarty_tpl->tpl_vars['pendingFriends']->value)>0) {?>
			<div>
				<?php echo smartyTranslate(array('s'=>'These friends have not yet registered on this website since you sponsored them, but you can try again! To do so, mark the checkboxes of the friend(s) you want to remind, then click on the button "Remind my friends".','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			</div>
			<div>
				<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
" class="std">
					<table class="std">
					<thead>
						<tr>
							<th class="first_item">&nbsp;</th>
							<th class="item"><?php echo smartyTranslate(array('s'=>'Last name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
							<th class="item"><?php echo smartyTranslate(array('s'=>'First name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
							<th class="item"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
							<th class="last_item"><?php echo smartyTranslate(array('s'=>'Last invitation','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						</tr>
					</thead>
					<tbody>
					<?php  $_smarty_tpl->tpl_vars['pendingFriend'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pendingFriend']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pendingFriends']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['pendingFriend']->key => $_smarty_tpl->tpl_vars['pendingFriend']->value) {
$_smarty_tpl->tpl_vars['pendingFriend']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']++;
?>
						<tr class="<?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['iteration']%2)==0) {?>item<?php } else { ?>alternate_item<?php }?>">
							<td>
								<input type="checkbox" name="friendChecked[<?php echo $_smarty_tpl->tpl_vars['pendingFriend']->value['id_sponsorship'];?>
]" id="friendChecked[<?php echo $_smarty_tpl->tpl_vars['pendingFriend']->value['id_sponsorship'];?>
]" value="1" />
							</td>
							<td><?php echo $_smarty_tpl->tpl_vars['pendingFriend']->value['lastname'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['pendingFriend']->value['firstname'];?>
</td>
							<td><?php echo $_smarty_tpl->tpl_vars['pendingFriend']->value['email'];?>
</td>
							<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['pendingFriend']->value['date_upd'],'full'=>0),$_smarty_tpl);?>
</td>
						</tr>
					<?php } ?>
					</tbody>
					</table>
					<p class="submit" align="center">
						<input type="submit" value="<?php echo smartyTranslate(array('s'=>'Remind my friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" name="revive" id="revive" class="button_large" />
					</p>
				</form>
			</div>
			<?php } else { ?>
			<div>
				<?php echo smartyTranslate(array('s'=>'You have not sponsored any friends.','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			</div>
			<?php }?>
		</div>

		<div id="idTab3" class="sponsorshipBlock">
			<?php if ($_smarty_tpl->tpl_vars['subscribeFriends']->value&&count($_smarty_tpl->tpl_vars['subscribeFriends']->value)>0) {?>
			<div>
				<?php echo smartyTranslate(array('s'=>'Here are sponsored friends who have accepted your invitation:','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			</div>
			<div>
				<table class="std">
				<thead>
					<tr>
						<th class="first_item">&nbsp;</th>
						<th class="item"><?php echo smartyTranslate(array('s'=>'Last name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item"><?php echo smartyTranslate(array('s'=>'First name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item"><?php echo smartyTranslate(array('s'=>'Channel','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="last_item"><?php echo smartyTranslate(array('s'=>'Inscription date','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					</tr>
				</thead>
				<tbody>
					<?php  $_smarty_tpl->tpl_vars['subscribeFriend'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['subscribeFriend']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['subscribeFriends']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['subscribeFriend']->key => $_smarty_tpl->tpl_vars['subscribeFriend']->value) {
$_smarty_tpl->tpl_vars['subscribeFriend']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']++;
?>
					<tr class="<?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['iteration']%2)==0) {?>item<?php } else { ?>alternate_item<?php }?>">
						<td><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['iteration'];?>
.</td>
						<td><?php echo $_smarty_tpl->tpl_vars['subscribeFriend']->value['lastname'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['subscribeFriend']->value['firstname'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['subscribeFriend']->value['email'];?>
</td>
						<td><?php if ($_smarty_tpl->tpl_vars['subscribeFriend']->value['channel']==1) {?><?php echo smartyTranslate(array('s'=>'Email invitation','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php } elseif ($_smarty_tpl->tpl_vars['subscribeFriend']->value['channel']==2) {?><?php echo smartyTranslate(array('s'=>'Sponsorship link','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php } elseif ($_smarty_tpl->tpl_vars['subscribeFriend']->value['channel']==3) {?><?php echo smartyTranslate(array('s'=>'Facebook','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php } elseif ($_smarty_tpl->tpl_vars['subscribeFriend']->value['channel']==4) {?><?php echo smartyTranslate(array('s'=>'Twitter','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php } elseif ($_smarty_tpl->tpl_vars['subscribeFriend']->value['channel']==5) {?><?php echo smartyTranslate(array('s'=>'Google +1','mod'=>'allinone_rewards'),$_smarty_tpl);?>
<?php }?></td>
						<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['dateFormat'][0][0]->dateFormat(array('date'=>$_smarty_tpl->tpl_vars['subscribeFriend']->value['date_upd'],'full'=>0),$_smarty_tpl);?>
</td>
					</tr>
					<?php } ?>
				</tbody>
				</table>
			</div>
			<?php } else { ?>
			<div>
				<?php echo smartyTranslate(array('s'=>'No sponsored friends have accepted your invitation yet.','mod'=>'allinone_rewards'),$_smarty_tpl);?>

			</div>
			<?php }?>
		</div>
			<?php if ($_smarty_tpl->tpl_vars['reward_allowed_s']->value) {?>
		<div id="idTab4" class="sponsorshipBlock">
			<div class="title"><?php echo smartyTranslate(array('s'=>'Details by registration channel','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
			<div>
				<table class="std">
					<thead>
						<tr>
							<th colspan="2" class="first_item left"><?php echo smartyTranslate(array('s'=>'Channels','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
							<th class="item center"><?php echo smartyTranslate(array('s'=>'Friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
							<th class="item center"><?php echo smartyTranslate(array('s'=>'Orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
							<th class="item center"><?php echo smartyTranslate(array('s'=>'Rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="left" rowspan="5"><?php echo smartyTranslate(array('s'=>'My direct friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
							<td class="left"><?php echo smartyTranslate(array('s'=>'Email invitation','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['direct_nb1']);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel1']);?>
</td>
							<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards1']),$_smarty_tpl);?>
</td>
						</tr>
						<tr>
							<td class="left"><?php echo smartyTranslate(array('s'=>'Sponsorship link','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['direct_nb2']);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel2']);?>
</td>
							<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards2']),$_smarty_tpl);?>
</td>
						</tr>
						<tr>
							<td class="left"><?php echo smartyTranslate(array('s'=>'Facebook','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['direct_nb3']);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel3']);?>
</td>
							<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards3']),$_smarty_tpl);?>
</td>
						</tr>
						<tr>
							<td class="left"><?php echo smartyTranslate(array('s'=>'Twitter','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['direct_nb4']);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel4']);?>
</td>
							<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards4']),$_smarty_tpl);?>
</td>
						</tr>
						<tr>
							<td class="left"><?php echo smartyTranslate(array('s'=>'Google +1','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['direct_nb5']);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel5']);?>
</td>
							<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards5']),$_smarty_tpl);?>
</td>
						</tr>
				<?php if ($_smarty_tpl->tpl_vars['multilevel']->value) {?>
						<tr>
							<td class="left" colspan="2"><?php echo smartyTranslate(array('s'=>'Indirect friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['indirect_nb']);?>
</td>
							<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['indirect_nb_orders']);?>
</td>
							<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['indirect_rewards']),$_smarty_tpl);?>
</td>
						</tr>
				<?php }?>
						<tr class="total">
							<td class="left" colspan="2"><?php echo smartyTranslate(array('s'=>'Total','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
							<td class="center"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['direct_nb1']+$_smarty_tpl->tpl_vars['statistics']->value['direct_nb2']+$_smarty_tpl->tpl_vars['statistics']->value['direct_nb3']+$_smarty_tpl->tpl_vars['statistics']->value['direct_nb4']+$_smarty_tpl->tpl_vars['statistics']->value['direct_nb5']+intval($_smarty_tpl->tpl_vars['statistics']->value['indirect_nb']);?>
</td>
							<td class="center"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel1']+$_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel2']+$_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel3']+$_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel4']+$_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel5']+intval($_smarty_tpl->tpl_vars['statistics']->value['indirect_nb_orders']);?>
</td>
							<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards1']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards2']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards3']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards4']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards5']+$_smarty_tpl->tpl_vars['statistics']->value['indirect_rewards']),$_smarty_tpl);?>
</td>
						</tr>
					</tbody>
				</table>
			</div>

				<?php if ($_smarty_tpl->tpl_vars['multilevel']->value&&$_smarty_tpl->tpl_vars['statistics']->value['sponsored1']) {?>
			<div class="title"><?php echo smartyTranslate(array('s'=>'Details by sponsorship level','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
			<table class="std">
				<thead>
					<tr>
						<th class="first_item left"><?php echo smartyTranslate(array('s'=>'Level','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					</tr>
				</thead>
				<tbody>
					<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['levels'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['name'] = 'levels';
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start'] = (int) 0;
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['statistics']->value['maxlevel']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['levels']['total']);
?>
						<?php $_smarty_tpl->tpl_vars["indiceFriends"] = new Smarty_variable("nb".((string)$_smarty_tpl->getVariable('smarty')->value['section']['levels']['iteration']), null, 0);?>
						<?php $_smarty_tpl->tpl_vars["indiceOrders"] = new Smarty_variable("nb_orders".((string)$_smarty_tpl->getVariable('smarty')->value['section']['levels']['iteration']), null, 0);?>
						<?php $_smarty_tpl->tpl_vars["indiceRewards"] = new Smarty_variable("rewards".((string)$_smarty_tpl->getVariable('smarty')->value['section']['levels']['iteration']), null, 0);?>
					<tr>
						<td class="left"><?php echo smartyTranslate(array('s'=>'Level','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->getVariable('smarty')->value['section']['levels']['iteration'];?>
</td>
						<td class="center"><?php if (isset($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceFriends']->value])) {?><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceFriends']->value]);?>
<?php } else { ?>0<?php }?></td>
						<td class="center"><?php if (isset($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceOrders']->value])) {?><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceOrders']->value]);?>
<?php } else { ?>0<?php }?></td>
						<td class="right"><?php if (isset($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceRewards']->value])) {?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceRewards']->value]),$_smarty_tpl);?>
<?php } else { ?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>0),$_smarty_tpl);?>
<?php }?></td>
					</tr>
					<?php endfor; endif; ?>
					<tr class="total">
						<td class="left"><?php echo smartyTranslate(array('s'=>'Total','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
						<td class="center"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['direct_nb1']+$_smarty_tpl->tpl_vars['statistics']->value['direct_nb2']+$_smarty_tpl->tpl_vars['statistics']->value['direct_nb3']+$_smarty_tpl->tpl_vars['statistics']->value['direct_nb4']+$_smarty_tpl->tpl_vars['statistics']->value['direct_nb5']+intval($_smarty_tpl->tpl_vars['statistics']->value['indirect_nb']);?>
</td>
						<td class="center"><?php echo $_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel1']+$_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel2']+$_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel3']+$_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel4']+$_smarty_tpl->tpl_vars['statistics']->value['nb_orders_channel5']+intval($_smarty_tpl->tpl_vars['statistics']->value['indirect_nb_orders']);?>
</td>
						<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards1']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards2']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards3']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards4']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards5']+$_smarty_tpl->tpl_vars['statistics']->value['indirect_rewards']),$_smarty_tpl);?>
</td>
					</tr>
				</tbody>
			</table>
				<?php }?>

				<?php if ($_smarty_tpl->tpl_vars['statistics']->value['sponsored1']) {?>
			<div class="title"><?php echo smartyTranslate(array('s'=>'Details for my direct friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
			<table class="std">
				<thead>
					<tr>
						<th class="first_item left"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<?php if ($_smarty_tpl->tpl_vars['multilevel']->value) {?>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Friends','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Friends\' orders','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Rewards','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
						<th class="item center"><?php echo smartyTranslate(array('s'=>'Total','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
					<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php  $_smarty_tpl->tpl_vars['sponsored'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sponsored']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['statistics']->value['sponsored1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['sponsored']->key => $_smarty_tpl->tpl_vars['sponsored']->value) {
$_smarty_tpl->tpl_vars['sponsored']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']++;
?>
						<?php $_smarty_tpl->tpl_vars["indiceDirect"] = new Smarty_variable("direct_customer".((string)$_smarty_tpl->tpl_vars['sponsored']->value['id_customer']), null, 0);?>
						<?php $_smarty_tpl->tpl_vars["indiceIndirect"] = new Smarty_variable("indirect_customer".((string)$_smarty_tpl->tpl_vars['sponsored']->value['id_customer']), null, 0);?>
						<?php if (isset($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceDirect']->value])) {?>
							<?php $_smarty_tpl->tpl_vars["valueDirect"] = new Smarty_variable($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceDirect']->value], null, 0);?>
						<?php } else { ?>
							<?php $_smarty_tpl->tpl_vars["valueDirect"] = new Smarty_variable(0, null, 0);?>
						<?php }?>
						<?php if (isset($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceIndirect']->value])) {?>
							<?php $_smarty_tpl->tpl_vars["valueIndirect"] = new Smarty_variable($_smarty_tpl->tpl_vars['statistics']->value[$_smarty_tpl->tpl_vars['indiceIndirect']->value], null, 0);?>
						<?php } else { ?>
							<?php $_smarty_tpl->tpl_vars["valueIndirect"] = new Smarty_variable(0, null, 0);?>
						<?php }?>
					<tr>
						<td class="left"><?php echo $_smarty_tpl->tpl_vars['sponsored']->value['lastname'];?>
 <?php echo $_smarty_tpl->tpl_vars['sponsored']->value['firstname'];?>
</td>
						<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['sponsored']->value['direct_orders']);?>
</td>
						<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['sponsored']->value['direct']),$_smarty_tpl);?>
</td>
						<?php if ($_smarty_tpl->tpl_vars['multilevel']->value) {?>
						<td class="center"><?php echo $_smarty_tpl->tpl_vars['valueDirect']->value+intval($_smarty_tpl->tpl_vars['valueIndirect']->value);?>
</td>
						<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['sponsored']->value['indirect_orders']);?>
</td>
						<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['sponsored']->value['indirect']),$_smarty_tpl);?>
</td>
						<td class="total right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['sponsored']->value['direct']+$_smarty_tpl->tpl_vars['sponsored']->value['indirect']),$_smarty_tpl);?>
</td>
						<?php }?>
					</tr>
					<?php } ?>
					<tr class="total">
						<td class="left"><?php echo smartyTranslate(array('s'=>'Total','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
						<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['total_direct_orders']);?>
</td>
						<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['total_direct_rewards']),$_smarty_tpl);?>
</td>
						<?php if ($_smarty_tpl->tpl_vars['multilevel']->value) {?>
						<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['indirect_nb']);?>
</td>
						<td class="center"><?php echo intval($_smarty_tpl->tpl_vars['statistics']->value['total_indirect_orders']);?>
</td>
						<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['total_indirect_rewards']),$_smarty_tpl);?>
</td>
						<td class="right"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['convertPrice'][0][0]->convertPrice(array('price'=>$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards1']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards2']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards3']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards4']+$_smarty_tpl->tpl_vars['statistics']->value['direct_rewards5']+$_smarty_tpl->tpl_vars['statistics']->value['indirect_rewards']),$_smarty_tpl);?>
</td>
						<?php }?>
					</tr>
				</tbody>
			</table>
				<?php }?>
		</div>
	</div>
			<?php }?>
		<?php }?>
	<?php }?>
</div>
<?php } else { ?>
	<?php if ($_smarty_tpl->tpl_vars['error']->value) {?>
<p class="error">
		<?php if ($_smarty_tpl->tpl_vars['error']->value=='login failed') {?>
			<?php echo smartyTranslate(array('s'=>'Login failed. Please check the email and password you have provided','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='email is missing') {?>
			<?php echo smartyTranslate(array('s'=>'Please enter your email to connect to your contacts list','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='password is missing') {?>
			<?php echo smartyTranslate(array('s'=>'Please enter your password to connect to your contacts list','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } elseif ($_smarty_tpl->tpl_vars['error']->value=='unable to get contacts') {?>
			<?php echo smartyTranslate(array('s'=>'Sorry, we were unable to get your contacts list','mod'=>'allinone_rewards'),$_smarty_tpl);?>

		<?php } else { ?>
			<?php echo smartyTranslate(array('s'=>'Error :','mod'=>'allinone_rewards'),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

		<?php }?>
</p>
	<?php } else { ?>
<form id="open_inviter_contacts_form" method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
">
<div>
	<table class="std">
		<thead>
			<tr>
				<th class="first_item"><input type="checkbox" id="checkall" /></th>
				<th class="item"><?php echo smartyTranslate(array('s'=>'Name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
				<th class="last_item"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
		<tbody>
		<?php  $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['name']->_loop = false;
 $_smarty_tpl->tpl_vars['email'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['open_inviter_contacts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['name']->key => $_smarty_tpl->tpl_vars['name']->value) {
$_smarty_tpl->tpl_vars['name']->_loop = true;
 $_smarty_tpl->tpl_vars['email']->value = $_smarty_tpl->tpl_vars['name']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['myLoop']['index']++;
?>
			<tr class="<?php if (($_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['iteration']%2)==0) {?>item<?php } else { ?>alternate_item<?php }?>">
				<td><input <?php if (isset($_POST['friendsEmail'][$_smarty_tpl->getVariable('smarty',null,true,false)->value['foreach']['myLoop']['index']])) {?>checked<?php }?> type="checkbox" name="friendsEmail[<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['myLoop']['index'];?>
]" value="<?php echo $_smarty_tpl->tpl_vars['email']->value;?>
" /></td>
				<td><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['email']->value;?>
</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<div>
	<input class="cgv" type="checkbox" name="conditionsValided" id="conditionsValided" value="1"  />&nbsp;
	<label for="conditionsValided"><?php echo smartyTranslate(array('s'=>'I agree to the terms of service and adhere to them unconditionally.','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</label>
	<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','rules',array('sback'=>$_smarty_tpl->tpl_vars['sback']->value),true);?>
" class="fancybox rules" title="<?php echo smartyTranslate(array('s'=>'Conditions of the sponsorship program','mod'=>'allinone_rewards'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Read conditions','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</a>
</div>
<div class="submit" align="center">
	<input type="submit" id="submitOpenInviter2" name="submitOpenInviter2" class="button_large" value="<?php echo smartyTranslate(array('s'=>'Send invitations','mod'=>'allinone_rewards'),$_smarty_tpl);?>
" />
</div>
</form>
	<?php }?>
<?php }?><?php }} ?>
