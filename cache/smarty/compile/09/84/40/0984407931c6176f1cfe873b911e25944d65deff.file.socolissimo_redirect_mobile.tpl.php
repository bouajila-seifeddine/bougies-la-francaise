<?php /* Smarty version Smarty-3.1.19, created on 2016-11-16 23:36:08
         compiled from "/home/bougies-la-francaise/public_html/modules/socolissimo/views/templates/front/socolissimo_redirect_mobile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:628077167582cdf58420f40-12543521%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0984407931c6176f1cfe873b911e25944d65deff' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/socolissimo/views/templates/front/socolissimo_redirect_mobile.tpl',
      1 => 1478104348,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '628077167582cdf58420f40-12543521',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link_socolissimo_mobile' => 0,
    'initialCost_label' => 0,
    'initialCost' => 0,
    'id_carrier' => 0,
    'taxMention' => 0,
    'content_dir' => 0,
    'rewrite_active' => 0,
    'inputs' => 0,
    'name' => 0,
    'input' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582cdf58478ab1_26814911',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582cdf58478ab1_26814911')) {function content_582cdf58478ab1_26814911($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/home/bougies-la-francaise/public_html/tools/smarty/plugins/modifier.escape.php';
?>
<script type="text/javascript">
	var link_socolissimo = "<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link_socolissimo_mobile']->value, 'UTF-8');?>
";
	var soInputs = new Object();
	var initialCost_label = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['initialCost_label']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var initialCost = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['initialCost']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var soCarrierId = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_carrier']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var taxMention = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['taxMention']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var baseDir = '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['content_dir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';
	var rewriteActive = '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['rewrite_active']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
';

	<?php  $_smarty_tpl->tpl_vars['input'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['input']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['inputs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['input']->key => $_smarty_tpl->tpl_vars['input']->value) {
$_smarty_tpl->tpl_vars['input']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['input']->key;
?>
	soInputs.<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 = "<?php echo addslashes(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['input']->value));?>
";
	<?php } ?>
	

		$(document).ready(function () {
			
				$('input.delivery_option_radio').each(function () {
					if ($(this).val() == soCarrierId + ',') {
						$(this).next().children().children().find('div.delivery_option_price').html(initialCost_label + '<br/>' + initialCost + taxMention);
						// 1.6 themes
						if ($(this).next().children('div.delivery_option_price').length == 0)
							$(this).parents('tr').children('td.delivery_option_price').find('div.delivery_option_price').html(initialCost_label + '<br/>' + initialCost + taxMention);
					}
				});
			
			$("#form").submit(function () {
				
					if ($("input[name*='delivery_option[']:checked").val().replace(",", "") == soCarrierId)
						$('#form').attr('action', link_socolissimo + serialiseInput(soInputs));
				
			});
		});

		function serialiseInput(inputs) {
			if (!rewriteActive)
				var str = '&first_call=1&';
			else
				var str = '?first_call=1&';
			for (var cle in inputs)
				str += cle + '=' + inputs[cle] + '&';
			return (str + 'gift=' + $('#gift').attr('checked') + '&gift_message=' + $('#gift_message').attr('value'));
			
		}
	
</script>

<?php  $_smarty_tpl->tpl_vars['input'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['input']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['inputs']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['input']->key => $_smarty_tpl->tpl_vars['input']->value) {
$_smarty_tpl->tpl_vars['input']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['input']->key;
?>
	<input type="hidden" name="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['name']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" value="<?php echo mb_convert_encoding(htmlspecialchars(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['input']->value), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"/>
<?php } ?><?php }} ?>
