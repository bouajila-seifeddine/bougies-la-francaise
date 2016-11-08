<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:05:39
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/pm_advancedsearch4/views/templates/hook/pm_advancedsearch_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:932165603581a0ed37d8d46-99420870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eacf28af5af8b4f880a5d8e3718627eab6693201' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/pm_advancedsearch4/views/templates/hook/pm_advancedsearch_header.tpl',
      1 => 1475244953,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '932165603581a0ed37d8d46-99420870',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ASSearchUrlForm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a0ed37f5123_30487528',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a0ed37f5123_30487528')) {function content_581a0ed37f5123_30487528($_smarty_tpl) {?><!-- MODULE PM_AdvancedSearch4 || Presta-Module.com -->
<script type="text/javascript">
var ASPath = '<?php echo @constant('__PS_BASE_URI__');?>
modules/pm_advancedsearch4/';
var ASSearchUrl = '<?php echo $_smarty_tpl->tpl_vars['ASSearchUrlForm']->value;?>
';
var ASParams = {};
var ASHash = {};
var ASPSVersion = '<?php echo @constant('_PS_VERSION_');?>
';
$(document).ready(function() { asInitAsHashChange(); });
</script>
<!-- MODULE PM_AdvancedSearch4 || Presta-Module.com --><?php }} ?>
