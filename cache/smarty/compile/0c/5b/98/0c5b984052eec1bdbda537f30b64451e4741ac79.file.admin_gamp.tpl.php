<?php /* Smarty version Smarty-3.1.19, created on 2016-11-15 17:15:12
         compiled from "/home/bougies-la-francaise/public_html/modules/gamp/admin_gamp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:733717956582b34906f2af9-60573808%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c5b984052eec1bdbda537f30b64451e4741ac79' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/gamp/admin_gamp.tpl',
      1 => 1448369234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '733717956582b34906f2af9-60573808',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'growl' => 0,
    'current_index' => 0,
    'ga_account_id' => 0,
    'ga_session_timeout' => 0,
    'ga_userid_enabled' => 0,
    'ga_detail_enabled' => 0,
    'ga_ecommerce_enhanced' => 0,
    'ga_displayfeatures' => 0,
    'ga_merge_www' => 0,
    'ga_exclude_bots' => 0,
    'ga_measurement_prod' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582b3490753121_25312166',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582b3490753121_25312166')) {function content_582b3490753121_25312166($_smarty_tpl) {?><h2><?php echo smartyTranslate(array('s'=>'Google Measurement Analytics Protocol','mod'=>'gamp'),$_smarty_tpl);?>
</h2>
<?php if (isset($_smarty_tpl->tpl_vars['growl']->value)) {?><?php echo $_smarty_tpl->tpl_vars['growl']->value;?>
<?php }?>
<form action="<?php echo $_smarty_tpl->tpl_vars['current_index']->value;?>
" method="post">
	<fieldset>
		<legend><img src="../img/admin/cog.gif" alt="" class="middle" /><?php echo smartyTranslate(array('s'=>'Settings','mod'=>'gamp'),$_smarty_tpl);?>
</legend>
		<label><?php echo smartyTranslate(array('s'=>'GANALYTICS_ID','mod'=>'gamp'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<input type="text" name="ga_account_id" value="<?php echo $_smarty_tpl->tpl_vars['ga_account_id']->value;?>
" />
			<p class="clear"><?php echo smartyTranslate(array('s'=>'Example:','mod'=>'gamp'),$_smarty_tpl);?>
UA-XXXXX-X</p>
		</div>
		<label><?php echo smartyTranslate(array('s'=>'Session timeout','mod'=>'gamp'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<input type="text" name="ga_session_timeout" value="<?php echo $_smarty_tpl->tpl_vars['ga_session_timeout']->value;?>
" />
			<p class="clear"><?php echo smartyTranslate(array('s'=>'Session duration (better match property settings)','mod'=>'gamp'),$_smarty_tpl);?>
</p>
		</div>
		<label><?php echo smartyTranslate(array('s'=>'Activate customer id','mod'=>'gamp'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_userid_enabled" <?php if ($_smarty_tpl->tpl_vars['ga_userid_enabled']->value) {?>checked="checked"<?php }?> />
			<p class="clear"><?php echo smartyTranslate(array('s'=>'track per customer','mod'=>'gamp'),$_smarty_tpl);?>
</p>
		</div>
		<label><?php echo smartyTranslate(array('s'=>'Activate detail on transaction','mod'=>'gamp'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_detail_enabled" <?php if ($_smarty_tpl->tpl_vars['ga_detail_enabled']->value) {?>checked="checked"<?php }?> />
			<p class="clear"><?php echo smartyTranslate(array('s'=>'taxes, shipping, ...','mod'=>'gamp'),$_smarty_tpl);?>
</p>
		</div>
		<label><?php echo smartyTranslate(array('s'=>'Activate enhanced ecommerce','mod'=>'gamp'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_ecommerce_enhanced" <?php if ($_smarty_tpl->tpl_vars['ga_ecommerce_enhanced']->value) {?>checked="checked"<?php }?> />
			<p class="clear"><?php echo smartyTranslate(array('s'=>'List products within the order','mod'=>'gamp'),$_smarty_tpl);?>
</p>
		</div>
		<label><?php echo smartyTranslate(array('s'=>'Activate display features','mod'=>'gamp'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_displayfeatures" <?php if ($_smarty_tpl->tpl_vars['ga_displayfeatures']->value) {?>checked="checked"<?php }?> />
			<p class="clear"><?php echo smartyTranslate(array('s'=>'Activate display features beacon. Warning: discloses UA code','mod'=>'gamp'),$_smarty_tpl);?>
 (<?php echo $_smarty_tpl->tpl_vars['ga_account_id']->value;?>
)</p>
		</div>
                <label><?php echo smartyTranslate(array('s'=>'Merge www with non-www','mod'=>'gamp'),$_smarty_tpl);?>
</label>
                <div class="margin-form">
                    <input type="checkbox" name="ga_merge_www" <?php if ($_smarty_tpl->tpl_vars['ga_merge_www']->value) {?>checked="checked"<?php }?> />
                    <p class="clear"><?php echo smartyTranslate(array('s'=>'Affects referer related to www.tld vs tld traffic'),$_smarty_tpl);?>
</p>
                </div>
                <label><?php echo smartyTranslate(array('s'=>'Exclude known robots traffic','mod'=>'gamp'),$_smarty_tpl);?>
</label>
                <div class="margin-form">
                    <input type="checkbox" name="ga_exclude_bots" <?php if ($_smarty_tpl->tpl_vars['ga_exclude_bots']->value) {?>checked="checked"<?php }?> />
                    <p class="clear"><?php echo smartyTranslate(array('s'=>'Inhibit robots traffic'),$_smarty_tpl);?>
</p>
                </div>
		<label><?php echo smartyTranslate(array('s'=>'Run in production','mod'=>'gamp'),$_smarty_tpl);?>
</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_measurement_prod" <?php if ($_smarty_tpl->tpl_vars['ga_measurement_prod']->value) {?>checked="checked"<?php }?> />
			<p class="clear"><?php echo smartyTranslate(array('s'=>'Run in production','mod'=>'gamp'),$_smarty_tpl);?>
</p>
		</div>
		<center>
			<input type="submit" name="submitGAMP" value="<?php echo smartyTranslate(array('s'=>'Update','mod'=>'gamp'),$_smarty_tpl);?>
" class="button" />
		</center>
	</fieldset>
</form>
<?php }} ?>
