<?php /* Smarty version Smarty-3.1.19, created on 2016-11-16 17:01:31
         compiled from "/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/adminorders-sponsorship.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1603205203582c82db04f8b0-66054355%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a22de3ebcc164c6b5fe527e423baca4e2df26d8' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/adminorders-sponsorship.tpl',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1603205203582c82db04f8b0-66054355',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rewards' => 0,
    'version16' => 0,
    'reward' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582c82db06d049_69083260',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582c82db06d049_69083260')) {function content_582c82db06d049_69083260($_smarty_tpl) {?><?php if ((count($_smarty_tpl->tpl_vars['rewards']->value))) {?>
<!-- MODULE allinone_rewards -->
	<div class="<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>col-lg-7<?php } else { ?>clear<?php }?>" id="adminorders_sponsorship">
	<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
		<div class="panel">
			<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Sponsorship rewards for this order','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
	<?php } else { ?>
			<br>
			<fieldset>
				<legend><?php echo smartyTranslate(array('s'=>'Sponsorship rewards for this order','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</legend>
	<?php }?>

				<table style="width: 100%">
					<tr style="font-weight: bold">
						<td><?php echo smartyTranslate(array('s'=>'Level','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
						<td><?php echo smartyTranslate(array('s'=>'Name','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
						<td><?php echo smartyTranslate(array('s'=>'Reward','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
						<td><?php echo smartyTranslate(array('s'=>'Status','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</td>
					</tr>
	<?php  $_smarty_tpl->tpl_vars['reward'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['reward']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rewards']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['reward']->key => $_smarty_tpl->tpl_vars['reward']->value) {
$_smarty_tpl->tpl_vars['reward']->_loop = true;
?>
					<tr>
						<td><?php echo $_smarty_tpl->tpl_vars['reward']->value['level_sponsorship'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['reward']->value['firstname'];?>
 <?php echo $_smarty_tpl->tpl_vars['reward']->value['lastname'];?>
</td>
						<td><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['reward']->value['credits']),$_smarty_tpl);?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['reward']->value['state'];?>
</td>
					</tr>
	<?php } ?>
				</table>
<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
		</div>
<?php } else { ?>
			</fieldset>
<?php }?>
	</div>
<!-- END : MODULE allinone_rewards -->
<?php }?><?php }} ?>
