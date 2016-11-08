<?php /* Smarty version Smarty-3.1.19, created on 2016-10-20 11:51:08
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/paypal//views/templates/admin/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13019988555808938cef1b33-86724721%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'af5ba0a3157059733f0b29e26f8d473804b91bf9' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/paypal//views/templates/admin/header.tpl',
      1 => 1475244952,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13019988555808938cef1b33-86724721',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PayPal_WPS' => 0,
    'PayPal_HSS' => 0,
    'PayPal_ECS' => 0,
    'PayPal_PPP' => 0,
    'PayPal_module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5808938cf0b9d6_37212152',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5808938cf0b9d6_37212152')) {function content_5808938cf0b9d6_37212152($_smarty_tpl) {?>

<script type="text/javascript">
	var PayPal_WPS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_WPS']->value);?>
';
	var PayPal_HSS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_HSS']->value);?>
';
	var PayPal_ECS = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_ECS']->value);?>
';
	var PayPal_PPP = '<?php echo intval($_smarty_tpl->tpl_vars['PayPal_PPP']->value);?>
';
</script>

<script type="text/javascript" src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['PayPal_module_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/views/js/back_office.js"></script><?php }} ?>
