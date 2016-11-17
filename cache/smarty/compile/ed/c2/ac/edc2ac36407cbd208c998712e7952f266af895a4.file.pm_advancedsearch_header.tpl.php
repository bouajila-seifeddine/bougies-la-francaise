<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:55:18
         compiled from "/home/bougies-la-francaise/public_html/modules/pm_advancedsearch4/views/templates/hook/pm_advancedsearch_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2028858527582d8c96ba01a9-09526908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edc2ac36407cbd208c998712e7952f266af895a4' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/pm_advancedsearch4/views/templates/hook/pm_advancedsearch_header.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2028858527582d8c96ba01a9-09526908',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ASSearchUrlForm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d8c96bbb242_73718068',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d8c96bbb242_73718068')) {function content_582d8c96bbb242_73718068($_smarty_tpl) {?><!-- MODULE PM_AdvancedSearch4 || Presta-Module.com -->
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
