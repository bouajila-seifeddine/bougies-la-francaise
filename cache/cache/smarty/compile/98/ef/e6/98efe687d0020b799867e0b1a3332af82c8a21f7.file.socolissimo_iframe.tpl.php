<?php /* Smarty version Smarty-3.1.19, created on 2016-10-28 10:55:21
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/socolissimo/views/templates/front/socolissimo_iframe.tpl" */ ?>
<?php /*%%SmartyHeaderCode:188922074581312795e67e9-19304130%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '98efe687d0020b799867e0b1a3332af82c8a21f7' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/socolissimo/views/templates/front/socolissimo_iframe.tpl',
      1 => 1477386487,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188922074581312795e67e9-19304130',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'already_select_delivery' => 0,
    'link_socolissimo' => 0,
    'id_carrier' => 0,
    'token' => 0,
    'initialCost_label' => 0,
    'initialCost' => 0,
    'taxMention' => 0,
    'content_dir' => 0,
    'rewrite_active' => 0,
    'inputs' => 0,
    'name' => 0,
    'input' => 0,
    'id_carrier_seller' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5813127961e3c9_58628590',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5813127961e3c9_58628590')) {function content_5813127961e3c9_58628590($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/tools/smarty/plugins/modifier.escape.php';
?>

<iframe id="soFr" xml:lang="fr" width="100%" height="800" style="border:none;display:none;"src=""></iframe>
<input id="hidden_cgv" type="hidden" value="<?php echo smartyTranslate(array('s'=>'Please accept the terms of service before the next step.','mod'=>'socolissimo'),$_smarty_tpl);?>
" />
<script type="text/javascript">
	var opc = false;
</script>

<?php if (isset($_smarty_tpl->tpl_vars['already_select_delivery']->value)&&$_smarty_tpl->tpl_vars['already_select_delivery']->value) {?>
    <script type="text/javascript">
		var already_select_delivery = true;
    </script>
<?php } else { ?>
    <script type="text/javascript">
		var already_select_delivery = false;
    </script>
<?php }?>
<script type="text/javascript">
	var link_socolissimo = "<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link_socolissimo']->value, 'UTF-8');?>
";
	var soInputs = new Object();
	var soCarrierId = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_carrier']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var soToken = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['token']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var initialCost_label = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['initialCost_label']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var initialCost = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['initialCost']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
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

    

		$(document).ready(function ()
		{
			$('.delivery_option').each(function ( ) {
				if ($(this).children('.delivery_option_radio').val() == '<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_carrier_seller']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
,') {
					$(this).remove();
				}
			});
			$('#id_carrier<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_carrier_seller']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
').parent().parent().remove();

			
			$('input.delivery_option_radio').each(function ()
				{
					if ($(this).val() == soCarrierId + ',') {
						$(this).next().children().children().find('div.delivery_option_price').html(initialCost_label + '<br/>' + initialCost + taxMention);
						// 1.6 themes
						if ($(this).next().children('div.delivery_option_price').length == 0)
							$(this).parents('tr').children('td.delivery_option_price').find('div.delivery_option_price').html(initialCost_label + '<br/>' + initialCost + taxMention);
					}
				});
			

			$("#form").submit(function () {
				if (($('#id_carrier' + soCarrierId).is(':checked')) || ($('.delivery_option_radio:checked').val() == soCarrierId + ','))
				{
					if (acceptCGV(($('#hidden_cgv').val()))) {

						$('div.delivery_options_address h3').css('display', 'none');
						$('div.delivery_options').css('display', 'none');

						// common zone
						$('h3.condition_title').css('display', 'none');
						$('p.checkbox').css('display', 'none');
						$('h3.carrier_title').css('display', 'none');
						$('h3.gift_title').css('display', 'none');
						$('#gift_div').css('display', 'none');
						$('p.cart_navigation').css('display', 'none');
						$('#soFr').css('display', 'block');
						$('#soFr').attr('src', link_socolissimo + serialiseInput(soInputs));
					}
					return false;
				}
				return true;
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
<?php }} ?>
