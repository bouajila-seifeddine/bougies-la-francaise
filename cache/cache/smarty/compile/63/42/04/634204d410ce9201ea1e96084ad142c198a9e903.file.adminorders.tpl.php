<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 10:49:49
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/adminorders.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18339841815819b6bdc897d7-15939079%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '634204d410ce9201ea1e96084ad142c198a9e903' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/allinone_rewards/views/templates/hook/adminorders.tpl',
      1 => 1475244922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18339841815819b6bdc897d7-15939079',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'version16' => 0,
    'reward' => 0,
    'reward_state' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819b6bdcabeb8_55984007',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819b6bdcabeb8_55984007')) {function content_5819b6bdcabeb8_55984007($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
	<div class="<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>col-lg-5<?php } else { ?>clear<?php }?>" id="adminorders">
<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
		<div class="panel">
			<div class="panel-heading"><?php echo smartyTranslate(array('s'=>'Loyalty reward for this order','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</div>
<?php } else { ?>
			<br>
			<fieldset>
				<legend><?php echo smartyTranslate(array('s'=>'Loyalty reward for this order','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</legend>
<?php }?>
				<div style="width: 50%; float: left"><span style="font-weight: bold"><?php echo smartyTranslate(array('s'=>'Reward :','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</span> <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['displayPrice'][0][0]->displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['reward']->value->credits),$_smarty_tpl);?>
</div>
				<div style="width: 50%; float: left"><span style="font-weight: bold"><?php echo smartyTranslate(array('s'=>'Status :','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</span> <?php echo $_smarty_tpl->tpl_vars['reward_state']->value;?>
</div>
<?php if ($_smarty_tpl->tpl_vars['version16']->value) {?>
		</div>
<?php } else { ?>
			</fieldset>
<?php }?>
	</div>
<!-- END : MODULE allinone_rewards --><?php }} ?>
