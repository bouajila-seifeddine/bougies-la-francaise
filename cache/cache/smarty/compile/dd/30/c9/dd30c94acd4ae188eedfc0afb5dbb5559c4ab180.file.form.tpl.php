<?php /* Smarty version Smarty-3.1.19, created on 2016-10-12 16:51:51
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blocknewsletter/views/templates/front/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:78850426157fe4e07b1f227-28475817%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd30c94acd4ae188eedfc0afb5dbb5559c4ab180' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blocknewsletter/views/templates/front/form.tpl',
      1 => 1475245161,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78850426157fe4e07b1f227-28475817',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'newsletter_email' => 0,
    'newsletter_lastname' => 0,
    'newsletter_firstname' => 0,
    'days' => 0,
    'day' => 0,
    'newsletter_day' => 0,
    'years' => 0,
    'year' => 0,
    'newsletter_year' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_57fe4e07b5ff96_98401207',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57fe4e07b5ff96_98401207')) {function content_57fe4e07b5ff96_98401207($_smarty_tpl) {?><?php $_smarty_tpl->_capture_stack[0][] = array('path', null, null); ob_start(); ?><?php echo smartyTranslate(array('s'=>'Newsletter','mod'=>'blocknewsletter'),$_smarty_tpl);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<h2 class="blf-title"><?php echo smartyTranslate(array('s'=>'Newsletter','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</h2>
<div class="container">
	<div class="row">
		<div class="newsletter_intro">
			<?php echo smartyTranslate(array('s'=>'Form intro','mod'=>'blocknewsletter'),$_smarty_tpl);?>

		</div>
	</div>
</div>
<div class="blf-form-container">
	<div class="container">
		<div class="row">
			<form action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getModuleLink('blocknewsletter','form'), ENT_QUOTES, 'UTF-8', true);?>
" method="post">
				<input type="hidden" name="action" value="0" />
					
				<div class="form-group">
					<label for="email"><?php echo smartyTranslate(array('s'=>'Email','mod'=>'blocknewsletter'),$_smarty_tpl);?>
 *</label>
					<input class="form-control" id="email" type="email" name="email" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['newsletter_email']->value, ENT_QUOTES, 'UTF-8', true);?>
" required="
					required" aria-required="true" />
				</div>
				<div class="form-group">
					<label for="lastname"><?php echo smartyTranslate(array('s'=>'Lastname','mod'=>'blocknewsletter'),$_smarty_tpl);?>
 *</label>
					<input class="form-control" id="lastname" type="text" name="lastname" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['newsletter_lastname']->value, ENT_QUOTES, 'UTF-8', true);?>
" required="
					required" aria-required="true" />
				</div>
				<div class="form-group">
					<label for="firstname"><?php echo smartyTranslate(array('s'=>'Firstname','mod'=>'blocknewsletter'),$_smarty_tpl);?>
 *</label>
					<input class="form-control" id="firstname" type="text" name="firstname" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['newsletter_firstname']->value, ENT_QUOTES, 'UTF-8', true);?>
" required="
					required" aria-required="true" />
				</div>
				<div class="form-group clearfix">
					<label for="birthday"><?php echo smartyTranslate(array('s'=>'Birthday','mod'=>'blocknewsletter'),$_smarty_tpl);?>
 *</label>
					<div class="date-select">
						<div class="row">							
							<div class="col-sm-4 col-xs-12">
								<select id="days" name="days" class="form-control">
									<option value=""></option>
									<?php  $_smarty_tpl->tpl_vars['day'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['day']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['days']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['day']->key => $_smarty_tpl->tpl_vars['day']->value) {
$_smarty_tpl->tpl_vars['day']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['day']->value;?>
" <?php if (($_smarty_tpl->tpl_vars['newsletter_day']->value==$_smarty_tpl->tpl_vars['day']->value)) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['day']->value;?>
</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-4 col-xs-12">
								<select id="months" name="months" class="form-control">
									<option value=""></option>
									<option value="1"><?php echo smartyTranslate(array('s'=>'January','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="2"><?php echo smartyTranslate(array('s'=>'February','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="3"><?php echo smartyTranslate(array('s'=>'March','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="4"><?php echo smartyTranslate(array('s'=>'April','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="5"><?php echo smartyTranslate(array('s'=>'May','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="6"><?php echo smartyTranslate(array('s'=>'June','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="7"><?php echo smartyTranslate(array('s'=>'July','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="8"><?php echo smartyTranslate(array('s'=>'August','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="9"><?php echo smartyTranslate(array('s'=>'September','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="10"><?php echo smartyTranslate(array('s'=>'October','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="11"><?php echo smartyTranslate(array('s'=>'November','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									<option value="12"><?php echo smartyTranslate(array('s'=>'December','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</option>
									
								</select>
							</div>
							<div class="col-sm-4 col-xs-12">
								<select id="years" name="years" class="form-control">
									<option value=""></option>
									<?php  $_smarty_tpl->tpl_vars['year'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['year']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['years']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['year']->key => $_smarty_tpl->tpl_vars['year']->value) {
$_smarty_tpl->tpl_vars['year']->_loop = true;
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['year']->value;?>
" <?php if (($_smarty_tpl->tpl_vars['newsletter_year']->value==$_smarty_tpl->tpl_vars['year']->value)) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['year']->value;?>
</option>
									<?php } ?>
								</select>
							</div>		
						</div>
					</div>
				</div>
				<div class="submit">
					<button type="submit" class="btn-blf white" name="submitNewsletter"><?php echo smartyTranslate(array('s'=>'subscribe','mod'=>'blocknewsletter'),$_smarty_tpl);?>
</button>
				</div>
			</form>
		</div>
	</div>
</div><?php }} ?>
