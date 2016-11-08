<?php /* Smarty version Smarty-3.1.19, created on 2016-10-28 10:55:27
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/socolissimo/views/templates/front/redirect.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18330259175813127fdabbf7-07165337%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd93ad88e008ca2b85f2e454f10d53ec08f815ffc' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/socolissimo/views/templates/front/redirect.tpl',
      1 => 1477386487,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18330259175813127fdabbf7-07165337',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'socolissimo_url' => 0,
    'inputs' => 0,
    'key' => 0,
    'val' => 0,
    'logo' => 0,
    'loader' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5813127fdc7225_36635316',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5813127fdc7225_36635316')) {function content_5813127fdc7225_36635316($_smarty_tpl) {?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=iso-8859-1" />
	</head>
	<body onload="document.getElementById('socoForm').submit();">
		<div style="width:320px;margin:0 auto;text-align:center;">
			<form id="socoForm" name="form" action="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['socolissimo_url']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="POST">

				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['inputs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
					<input type="hidden" name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['key']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['val']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
				<?php } ?>
				<img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['logo']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" />
				<p><?php echo smartyTranslate(array('s'=>'You will be redirect to socolissimo in few moment. If it is not the case, please click button.','mod'=>'socolissimo'),$_smarty_tpl);?>
</p>
				<p><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['loader']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" /></p>
				<input type="submit" value="Envoyer" />
			</form>
		</div>
	</body>
</html>
<?php }} ?>
