<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:17
         compiled from "/raid/www/blf/modules/socolissimo/views/templates/front/socolissimo_fancybox.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10513051355819dc59e21901-41623725%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c404d556cf64879aa451eeae29016173aea19053' => 
    array (
      0 => '/raid/www/blf/modules/socolissimo/views/templates/front/socolissimo_fancybox.tpl',
      1 => 1466506583,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10513051355819dc59e21901-41623725',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'opc' => 0,
    'already_select_delivery' => 0,
    'link_socolissimo' => 0,
    'SOBWD_C' => 0,
    'id_carrier' => 0,
    'id_carrier_seller' => 0,
    'token' => 0,
    'initialCost_label' => 0,
    'initialCost' => 0,
    'taxMention' => 0,
    'content_dir' => 0,
    'rewrite_active' => 0,
    'inputs' => 0,
    'name' => 0,
    'input' => 0,
    'select_label' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dc59e71d41_77130550',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc59e71d41_77130550')) {function content_5819dc59e71d41_77130550($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/raid/www/blf/tools/smarty/plugins/modifier.escape.php';
?>

<style type="text/css">
	.soBackward_compat_tab { text-align: center; }
	.soBackward_compat_tab a { margin: 10px; }
</style>

<a href="#" style="display:none" class="fancybox fancybox.iframe" id="soLink"></a>
<?php if (isset($_smarty_tpl->tpl_vars['opc']->value)&&$_smarty_tpl->tpl_vars['opc']->value) {?>
	<script type="text/javascript">
		var opc = true;
	</script>
<?php } else { ?>
	<script type="text/javascript">
		var opc = false;
	</script>
<?php }?>
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
	var soBwdCompat = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['SOBWD_C']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var soCarrierId = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_carrier']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
";
	var soSellerId = "<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['id_carrier_seller']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
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
	soInputs.<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
 = "<?php echo addslashes(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['input']->value));?>
";
	<?php } ?>

	
		$('#soLink').fancybox({
			'width': 590,
			'height': 810,
			'autoScale': true,
			'centerOnScroll': true,
			'autoDimensions': false,
			'transitionIn': 'none',
			'transitionOut': 'none',
			'hideOnOverlayClick': false,
			'hideOnContentClick': false,
			'showCloseButton': true,
			'showIframeLoading': true,
			'enableEscapeButton': true,
			'type': 'iframe',
			onStart: function () {
				if (soBwdCompat)
					$('#soLink').attr('href', link_socolissimo + serialiseInput(soInputs));
				else
					$('#soLink').attr('href', baseDir + 'modules/socolissimo/redirect.php' + serialiseInput(soInputs));
			},
			onClosed: function () {
				$.ajax({
					type: 'GET',
					url: baseDir + '/modules/socolissimo/ajax.php',
					async: false,
					cache: false,
					dataType: "json",
					data: "token=" + soToken,
					success: function (jsonData) {
						if (jsonData && jsonData.answer && typeof jsonData.answer != undefined && !opc) {
							if (jsonData.answer)
								$('#form').submit();
							else if (jsonData.msg.length)
								alert(jsonData.msg);
						}
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						alert('TECHNICAL ERROR\nDetails:\nError thrown: ' + XMLHttpRequest + '\n' + 'Text status: ' + textStatus);
					}
				});
			}
		});

		$(document).ready(function ()
		{
			var interval;
			$('#soLink').attr('href', baseDir + 'modules/socolissimo/redirect.php' + serialiseInput(soInputs));
			// 1.4 way
			if (!soBwdCompat)
			{
				$($('#carrierTable input#id_carrier' + soCarrierId).parent().parent()).find('.carrier_price .price').html(initialCost_label + '<br/>' + initialCost);
				$($('#carrierTable input#id_carrier' + soCarrierId).parent().parent()).find('.carrier_price').css('white-space', 'nowrap');
				$('input[name=id_carrier]').change(function () {
					so_click();
				});
				so_click();
			}
			// 1.5 way
			else {
				$('input.delivery_option_radio').each(function ()
				{
					if ($(this).val() == soCarrierId + ',') {
						$(this).next().children().children().find('div.delivery_option_price').html(initialCost_label + '<br/>' + initialCost + taxMention);
						// 1.6 themes
						if ($(this).next().children('div.delivery_option_price').length == 0)
							$(this).parents('tr').children('td.delivery_option_price').find('div.delivery_option_price').html(initialCost_label + '<br/>' + initialCost + taxMention);
					}
				});
				if (soCarrierId)
					so_click();
			}
			$('.delivery_option').each(function ( ) {
				if ($(this).children('.delivery_option_radio').val() == '<?php echo $_smarty_tpl->tpl_vars['id_carrier_seller']->value;?>
,') {
					$(this).remove();
				}
			});
			$('#id_carrier<?php echo $_smarty_tpl->tpl_vars['id_carrier_seller']->value;?>
').parent().parent().remove();

		});


		function so_click()
		{
			if (opc) {
				if (!already_select_delivery || !$('#edit_socolissimo').length)
					modifyCarrierLine();
			}
			else if ((!soBwdCompat && $('#id_carrier' + soCarrierId).is(':not(:checked)')) ||
					(soBwdCompat && soCarrierId == 0)) {
				$('[name=processCarrier]').unbind('click').live('click', function () {
					return true;
				});
			} else {
				$('[name=processCarrier]').unbind('click').live('click', function () {
					if (($('#id_carrier' + soCarrierId).is(':checked')) || ($('.delivery_option_radio:checked').val() == soCarrierId + ','))
					{
						if (acceptCGV()) {
							if (soBwdCompat)
								$('#soLink').attr('href', link_socolissimo + serialiseInput(soInputs));
							else
								$('#soLink').attr('href', baseDir + 'modules/socolissimo/redirect.php' + serialiseInput(soInputs));
							$("#soLink").trigger("click");
						}
						return false;
					}
					return true;
				});
			}
		}

		function modifyCarrierLine()
		{
			if (soBwdCompat)
				var carrier = $('input.delivery_option_radio:checked');

			else {
				var carrier = $('input[name=id_carrier]:checked');
				var container = '#id_carrier' + soCarrierId;
			}

			if ((carrier.val() == soCarrierId) || (carrier.val() == soCarrierId + ',')) {
				if (soBwdCompat) {
					carrier.next().children().children().find('div.delivery_option_delay').append('<div><a class="exclusive_large" id="button_socolissimo" href="#" onclick="redirect();return;" ><?php echo $_smarty_tpl->tpl_vars['select_label']->value;?>
</a></div>');
					// 1.6 theme
					carrier.parent().parent().parent().parent().find('td.delivery_option_price').before('<td><div><a class="exclusive_large" id="button_socolissimo" href="#" onclick="redirect();return;" style="text-align:center;" ><?php echo $_smarty_tpl->tpl_vars['select_label']->value;?>
</a></div></td>');
				}
				else
					$(container).parent().siblings('.carrier_infos').append('<a class="exclusive_large" id="button_socolissimo" href="#" onclick="redirect();return;" ><?php echo $_smarty_tpl->tpl_vars['select_label']->value;?>
</a>');
			} else {
				$('#button_socolissimo').remove();
			}
			if (already_select_delivery)
			{
				$(container).css('display', 'block');
				$(container).css('margin', 'auto');
				$(container).css('margin-top', '5px');
			} else
			if (soBwdCompat)
				$(container).css('display', 'none');
		}

		function redirect()
		{
			if (soBwdCompat)
				$('#soLink').attr('href', link_socolissimo + serialiseInput(soInputs));
			else
				$('#soLink').attr('href', baseDir + 'modules/socolissimo/redirect.php' + serialiseInput(soInputs));
			$("#soLink").trigger("click");
			return false;
		}

		function serialiseInput(inputs)
		{
			if (soBwdCompat && !rewriteActive)
				var str = '&first_call=1&';
			else
				var str = '?first_call=1&';
		
			for (var cle in inputs)
				str += cle + '=' + inputs[cle] + '&';
			return (str + 'gift=' + $('#gift').attr('checked') + '&gift_message=' + $('#gift_message').attr('value'));
		}

	
</script>
<?php }} ?>
