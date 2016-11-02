<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:30
         compiled from "/raid/www/blf/modules/pm_advancedsearch4/views/templates/hook/pm_advancedsearch_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7426122515819dc662471c0-38875686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '876d9fd822d1427b1521347e8d144cc41794b20d' => 
    array (
      0 => '/raid/www/blf/modules/pm_advancedsearch4/views/templates/hook/pm_advancedsearch_header.tpl',
      1 => 1466504630,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7426122515819dc662471c0-38875686',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ASSearchUrlForm' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dc662ce379_72710669',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc662ce379_72710669')) {function content_5819dc662ce379_72710669($_smarty_tpl) {?><!-- MODULE PM_AdvancedSearch4 || Presta-Module.com -->
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
