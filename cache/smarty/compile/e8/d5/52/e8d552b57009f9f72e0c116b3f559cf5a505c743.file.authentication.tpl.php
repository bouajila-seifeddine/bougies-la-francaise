<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 11:43:56
         compiled from "/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/authentication.tpl" */ ?>
<?php /*%%SmartyHeaderCode:278329303582d89ec42a0b3-84965838%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8d552b57009f9f72e0c116b3f559cf5a505c743' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/allinone_rewards/views/templates/hook/authentication.tpl',
      1 => 1478101074,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '278329303582d89ec42a0b3-84965838',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'module_template_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d89ec44e269_41384094',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d89ec44e269_41384094')) {function content_582d89ec44e269_41384094($_smarty_tpl) {?><!-- MODULE allinone_rewards -->
<fieldset class="account_creation">
	<h3 class="page-subheading"><?php echo smartyTranslate(array('s'=>'Sponsorship program','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</h3>
	<p class="text form-group">
<?php if (!isset($_POST['sponsorship_invisible'])) {?>
		<label for="sponsorship"><?php echo smartyTranslate(array('s'=>'Code or E-mail address of your sponsor','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</label>
		<input type="text" size="52" maxlength="128" class="form-control text" id="sponsorship" name="sponsorship" value="<?php if (isset($_POST['sponsorship'])) {?><?php echo mb_convert_encoding(htmlspecialchars($_POST['sponsorship'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>" />
		<script type="text/javascript">
			/* cant be done in sponsorship.js, because that tpl is loaded in ajax (use live jquery function ?)*/
			// this variable is necesary because on 1.5.2 it crashs if directly in the code
			var error_sponsor = "<?php echo smartyTranslate(array('s'=>'This sponsor does not exist','mod'=>'allinone_rewards','js'=>1),$_smarty_tpl);?>
";
			$(document).ready(function(){
				$('#sponsorship').focus(function(){
					$('#sponsorship').removeClass('sponsorship_nok');
					$('#sponsorship_result').remove();
				});
				$('#sponsorship').blur(function(event){
					if (jQuery.trim($('#sponsorship').val()) != '') {
						$.ajax({
							type	: "POST",
							async	: false,
							cache	: false,
							url		: '<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('allinone_rewards','sponsorship',array(),true);?>
',
							dataType: 'json',
							data 	: "popup=1&checksponsor=1&sponsorship="+$('#sponsorship').val()+"&customer_email="+$('#email').val(),
							success: function(obj)	{
								if (obj && obj.result == 1) {
									$('#sponsorship').after('&nbsp;<img id="sponsorship_result" src="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
images/valid.png" align="absmiddle" class="icon" />');
								} else {
									$('#sponsorship').addClass('sponsorship_nok');
									$('#sponsorship').after('&nbsp;<img id="sponsorship_result" src="<?php echo $_smarty_tpl->tpl_vars['module_template_dir']->value;?>
images/invalid.png" title="'+error_sponsor+'" align="absmiddle" class="icon" />');
									event.stopPropagation();
								}
							}
						});
					}
				});
			});
		</script>
<?php } else { ?>
		<label style="width: 100%; text-align: center"><?php echo smartyTranslate(array('s'=>'You have been sponsored','mod'=>'allinone_rewards'),$_smarty_tpl);?>
</label>
<?php }?>
	</p>
</fieldset>
<!-- END : MODULE allinone_rewards --><?php }} ?>
