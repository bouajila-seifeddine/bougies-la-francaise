<?php /* Smarty version Smarty-3.1.19, created on 2016-10-18 15:12:23
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/socolissimo/views/templates/admin/back_office.tpl" */ ?>
<?php /*%%SmartyHeaderCode:197729553158061fb725f150-99701292%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99f462de1c9436a34da678e41f31926c7a0068d8' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/socolissimo/views/templates/admin/back_office.tpl',
      1 => 1475244962,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197729553158061fb725f150-99701292',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'supcostbelg' => 0,
    'taxrate' => 0,
    'moduleDir' => 0,
    'key' => 0,
    'id_user' => 0,
    'dypreparationtime' => 0,
    'validation_url' => 0,
    'return_url' => 0,
    'url_so' => 0,
    'url_so_mobile' => 0,
    'sup_active' => 0,
    'url_sup' => 0,
    'display_type' => 0,
    'carrier_socolissimo' => 0,
    'carrier' => 0,
    'id_socolissimo' => 0,
    'costseller' => 0,
    'carrier_socolissimo_cc' => 0,
    'id_socolissimo_cc' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_58061fb7401760_55650494',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58061fb7401760_55650494')) {function content_58061fb7401760_55650494($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['supcostbelg']->value)) {?><?php $_smarty_tpl->tpl_vars['supcostbelgttc'] = new Smarty_variable($_smarty_tpl->tpl_vars['supcostbelg']->value*(1+($_smarty_tpl->tpl_vars['taxrate']->value/100)), null, 0);?><?php }?>
<div class="warn">  <p><?php echo smartyTranslate(array('s'=>'Warning, usage of this module in opc mobile theme is not recommended in production mode for your website.','mod'=>'socolissimo'),$_smarty_tpl);?>
</p></div>
<form action="<?php echo mb_convert_encoding(htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" method="post" class="form">
    <input type="hidden" value=<?php if (isset($_smarty_tpl->tpl_vars['taxrate']->value)) {?><?php echo $_smarty_tpl->tpl_vars['taxrate']->value;?>
<?php } else { ?>0<?php }?> class="taxrate" name="taxrate" />
    <fieldset><legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['moduleDir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'About Socolissimo Simplicité','mod'=>'socolissimo'),$_smarty_tpl);?>
</legend>
        <?php echo smartyTranslate(array('s'=>'Colissimo Simplicité is a service offered by La Poste, which allows you to offer your customers multiple modes of delivery','mod'=>'socolissimo'),$_smarty_tpl);?>
 :
        <ul>
            <li style="font-weight:bold;"><?php echo smartyTranslate(array('s'=>'Colissimo at home','mod'=>'socolissimo'),$_smarty_tpl);?>
 :</li>
            <ul>
                <li><?php echo smartyTranslate(array('s'=>'With signing','mod'=>'socolissimo'),$_smarty_tpl);?>
</li>
                <li><?php echo smartyTranslate(array('s'=>'Unsigned','mod'=>'socolissimo'),$_smarty_tpl);?>
</li>
            </ul>
            <li style="font-weight:bold;"><?php echo smartyTranslate(array('s'=>'Colissimo at a withdrawal point','mod'=>'socolissimo'),$_smarty_tpl);?>
 :</li>
            <ul>
                <li><?php echo smartyTranslate(array('s'=>'At the post office','mod'=>'socolissimo'),$_smarty_tpl);?>
</li>
                <li><?php echo smartyTranslate(array('s'=>'In a Pickup Station','mod'=>'socolissimo'),$_smarty_tpl);?>
</li>
                <li><?php echo smartyTranslate(array('s'=>'In one of the 18 000 Pickup Relays available in France','mod'=>'socolissimo'),$_smarty_tpl);?>
</li>
            </ul>
        </ul>
    </fieldset>
    <div class="clear">&nbsp;</div>
    <fieldset><legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['moduleDir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Subscribe to Colissimo Simplicité','mod'=>'socolissimo'),$_smarty_tpl);?>
</legend>
        <?php echo smartyTranslate(array('s'=>'To open your Colissimo account, please contact','mod'=>'socolissimo'),$_smarty_tpl);?>
 <b><?php echo smartyTranslate(array('s'=>'La Poste','mod'=>'socolissimo'),$_smarty_tpl);?>
</b> :
        <ul>
            <li><?php echo smartyTranslate(array('s'=>'By phone : Call','mod'=>'socolissimo'),$_smarty_tpl);?>
<b> 3634 </b><?php echo smartyTranslate(array('s'=>'(French phone number)','mod'=>'socolissimo'),$_smarty_tpl);?>
</li>
            <li><a href="https://www.colissimo.entreprise.laposte.fr/contact" target="_blank"><?php echo smartyTranslate(array('s'=>'By message','mod'=>'socolissimo'),$_smarty_tpl);?>
</a></li>
        </ul>
    </fieldset>
    <div class="clear">&nbsp;</div>
    <fieldset><legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['moduleDir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Vendor manual','mod'=>'socolissimo'),$_smarty_tpl);?>
</legend>
            <?php echo smartyTranslate(array('s'=>'Don\'t hesitate to read the','mod'=>'socolissimo'),$_smarty_tpl);?>
 
        <b><a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['moduleDir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/readme_fr.pdf" target="_blank"><?php echo smartyTranslate(array('s'=>'Vendor manual','mod'=>'socolissimo'),$_smarty_tpl);?>
 </a></b> 
        <?php echo smartyTranslate(array('s'=>'to help you to configure the module','mod'=>'socolissimo'),$_smarty_tpl);?>
 

    </fieldset>
    <div class="clear">&nbsp;</div>
    <fieldset><legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['moduleDir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Colissimo Simplicité Settings','mod'=>'socolissimo'),$_smarty_tpl);?>
</legend>
        <label><?php echo smartyTranslate(array('s'=>'Encryption key','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <input type="text" name="key" value="<?php if (isset($_smarty_tpl->tpl_vars['key']->value)) {?><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
<?php }?>" />
            <p><?php echo smartyTranslate(array('s'=>'Available in your','mod'=>'socolissimo'),$_smarty_tpl);?>
&nbsp;
                <a href="https://www.colissimo.entreprise.laposte.fr" target="_blank" ><?php echo smartyTranslate(array('s'=>'Colissimo Box','mod'=>'socolissimo'),$_smarty_tpl);?>
</a></p>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Front Offic Identifier','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <input type="text" name="id_user" value="<?php if (isset($_smarty_tpl->tpl_vars['id_user']->value)) {?><?php echo $_smarty_tpl->tpl_vars['id_user']->value;?>
<?php }?>" />
            <p><?php echo smartyTranslate(array('s'=>'Available in your','mod'=>'socolissimo'),$_smarty_tpl);?>
&nbsp;
                <a href="https://www.colissimo.entreprise.laposte.fr" target="_blank" ><?php echo smartyTranslate(array('s'=>'Colissimo Box','mod'=>'socolissimo'),$_smarty_tpl);?>
</a></p>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Order Preparation time','mod'=>'socolissimo'),$_smarty_tpl);?>
: </label>
        <div class="margin-form">
            <input type="text" size="5" name="dypreparationtime" value="<?php if (isset($_smarty_tpl->tpl_vars['dypreparationtime']->value)) {?><?php echo $_smarty_tpl->tpl_vars['dypreparationtime']->value;?>
<?php } else { ?>0<?php }?>" /><?php echo smartyTranslate(array('s'=>'Day(s)','mod'=>'socolissimo'),$_smarty_tpl);?>

            <p><?php echo smartyTranslate(array('s'=>'Business days from Monday to Friday','mod'=>'socolissimo'),$_smarty_tpl);?>
 <br><span style="color:red">
                    <?php echo smartyTranslate(array('s'=>'Must be the same paramter as in your','mod'=>'socolissimo'),$_smarty_tpl);?>
&nbsp;
                    <a style="color:red" href="https://www.colissimo.entreprise.laposte.fr" target="_blank" ><?php echo smartyTranslate(array('s'=>'Colissimo Box','mod'=>'socolissimo'),$_smarty_tpl);?>
</a></span></p>
        </div>
    </fieldset>
    <div class="clear">&nbsp;</div>
    <fieldset><legend><img src="<?php echo $_smarty_tpl->tpl_vars['moduleDir']->value;?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Return URL','mod'=>'socolissimo'),$_smarty_tpl);?>
</legend>
        <div class="margin-form"> 
            <?php echo smartyTranslate(array('s'=>'Please fill in these two addresses in your','mod'=>'socolissimo'),$_smarty_tpl);?>
&nbsp;
            <a href="https://www.colissimo.entreprise.laposte.fr/" target="_blank"><?php echo smartyTranslate(array('s'=>'Colissimo Box','mod'=>'socolissimo'),$_smarty_tpl);?>
</a>,
            <?php echo smartyTranslate(array('s'=>'in the "Simplicity – Delivery options selection page"','mod'=>'socolissimo'),$_smarty_tpl);?>
 
            <?php echo smartyTranslate(array('s'=>'and in the "Simplicity – Delivery options selection page (mobile version)" configuration pages','mod'=>'socolissimo'),$_smarty_tpl);?>
<br/>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'When the customer has successfully selected the delivery method (Validation)','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <p><?php if (isset($_smarty_tpl->tpl_vars['validation_url']->value)) {?><?php echo $_smarty_tpl->tpl_vars['validation_url']->value;?>
<?php }?></p>
        </div>
        <div class="clear">&nbsp;</div>
        <label><?php echo smartyTranslate(array('s'=>'When the client could not select the delivery method (Failed)','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <p><?php if (isset($_smarty_tpl->tpl_vars['return_url']->value)) {?><?php echo $_smarty_tpl->tpl_vars['return_url']->value;?>
<?php }?></p>
        </div>
    </fieldset>
    <div class="clear">&nbsp;</div>
    <fieldset><legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['moduleDir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Colissimo Simplicité System Settings','mod'=>'socolissimo'),$_smarty_tpl);?>
</legend>
        <div class="margin-form" style="color:red;font-weight:bold;"> 
            <?php echo smartyTranslate(array('s'=>'Be VERY CAREFUL with these settings, any changes may cause the module to malfunction.','mod'=>'socolissimo'),$_smarty_tpl);?>
<br/><br/>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Url So','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <input type="text" size="45" name="url_so" value="<?php if (isset($_smarty_tpl->tpl_vars['url_so']->value)) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['url_so']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>" />
            <p><?php echo smartyTranslate(array('s'=>'Url of back office Colissimo.','mod'=>'socolissimo'),$_smarty_tpl);?>
<br/></p>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Url So Mobile','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <input type="text" size="45" name="url_so_mobile" value="<?php if (isset($_smarty_tpl->tpl_vars['url_so_mobile']->value)) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['url_so_mobile']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>" />
            <p><?php echo smartyTranslate(array('s'=>'Url of back office Colissimo Mobile. Customers with smartphones or ipad will be redirect there. Warning, this url do not allow delivery in belgium','mod'=>'socolissimo'),$_smarty_tpl);?>

                <br/></p>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Supervision','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <input type="radio" name="sup_active" id="active_on" value="1" <?php if (isset($_smarty_tpl->tpl_vars['sup_active']->value)&&$_smarty_tpl->tpl_vars['sup_active']->value) {?>checked="checked" <?php }?>/>
            <label class="t" for="active_on"> <img src="../img/admin/enabled.gif" alt="' . $this->l('Enabled') . '" title="' . $this->l('Enabled') . '" /></label>
            <input type="radio" name="sup_active" id="active_off" value="0" <?php if (isset($_smarty_tpl->tpl_vars['sup_active']->value)&&!$_smarty_tpl->tpl_vars['sup_active']->value) {?>checked="checked"<?php }?>/>
            <label class="t" for="active_off"> <img src="../img/admin/disabled.gif" alt="' . $this->l('Disabled') . '" title="' . $this->l('Disabled') . '" /></label>
            <p><?php echo smartyTranslate(array('s'=>'Enable or disable the check availability  of Colissimo service.','mod'=>'socolissimo'),$_smarty_tpl);?>
</p>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Url Supervision','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <input type="text" size="45" name="url_sup" value="<?php if (isset($_smarty_tpl->tpl_vars['url_sup']->value)) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['url_sup']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>" />
            <p><?php echo smartyTranslate(array('s'=>'The monitor URL is to ensure the availability of the socolissimo service. We strongly recommend that you do not disable it','mod'=>'socolissimo'),$_smarty_tpl);?>
</p>
        </div>
    </fieldset>
    <div class="clear">&nbsp;</div>
    <fieldset><legend><img src="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['moduleDir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Prestashop System Settings','mod'=>'socolissimo'),$_smarty_tpl);?>
</legend>
        <div class="margin-form" style="color:red;font-weight:bold;"> 
            <?php echo smartyTranslate(array('s'=>'Be VERY CAREFUL with these settings, any changes may cause the module to malfunction.','mod'=>'socolissimo'),$_smarty_tpl);?>
<br/><br/>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Display Mode','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <input type="radio" name="display_type" id="classic_on" value="0" <?php if (isset($_smarty_tpl->tpl_vars['display_type']->value)&&!$_smarty_tpl->tpl_vars['display_type']->value) {?> checked="checked" <?php }?>/>
            <label class="t" for="classic_on"> Classic </label>
            <input type="radio" name="display_type" id="fancybox_on" value="1" <?php if (isset($_smarty_tpl->tpl_vars['display_type']->value)&&$_smarty_tpl->tpl_vars['display_type']->value==1) {?> checked="checked" <?php }?>/>
            <label class="t" for="fancybox_on"> Fancybox </label>
            <input type="radio" name="display_type" id="iframe_on" value="2" <?php if (isset($_smarty_tpl->tpl_vars['display_type']->value)&&$_smarty_tpl->tpl_vars['display_type']->value==2) {?> checked="checked"<?php }?>/>
            <label class="t" for="iframe_on"> iFrame </label>
            <p><?php echo smartyTranslate(array('s'=>'Choose your display mode for windows Socolissimo','mod'=>'socolissimo'),$_smarty_tpl);?>
</p>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Home carrier','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <select name="id_socolissimo_allocation">
                <?php  $_smarty_tpl->tpl_vars['carrier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['carrier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['carrier_socolissimo']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['carrier']->key => $_smarty_tpl->tpl_vars['carrier']->value) {
$_smarty_tpl->tpl_vars['carrier']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']==$_smarty_tpl->tpl_vars['id_socolissimo']->value) {?>
                        <option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" selected><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 - <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
                    <?php } else { ?>
                        <option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 - <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
                    <?php }?>
                <?php } ?>
            </select>
            <p><?php echo smartyTranslate(array('s'=>'Carrier used to get "Colissimo at home" cost','mod'=>'socolissimo'),$_smarty_tpl);?>
</p>
        </div>
        <label><?php echo smartyTranslate(array('s'=>'Withdrawal point cost','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <input type="radio" name="costseller" id="sel_on" value="1" <?php if (isset($_smarty_tpl->tpl_vars['costseller']->value)&&$_smarty_tpl->tpl_vars['costseller']->value) {?>checked="checked" <?php }?>'/>
            <label class="t" for="sel_on"> <img src="../img/admin/enabled.gif" alt="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'socolissimo'),$_smarty_tpl);?>
" title="<?php echo smartyTranslate(array('s'=>'Enabled','mod'=>'socolissimo'),$_smarty_tpl);?>
" /></label>
            <input type="radio" name="costseller" id="sel_off" value="0" <?php if (isset($_smarty_tpl->tpl_vars['costseller']->value)&&!$_smarty_tpl->tpl_vars['costseller']->value) {?> checked="checked" <?php }?>/>
            <label class="t" for="sel_off"> <img src="../img/admin/disabled.gif" alt="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'socolissimo'),$_smarty_tpl);?>
'" title="<?php echo smartyTranslate(array('s'=>'Disabled','mod'=>'socolissimo'),$_smarty_tpl);?>
" /></label>
            <p><?php echo smartyTranslate(array('s'=>'This cost override the normal cost for seller delivery.','mod'=>'socolissimo'),$_smarty_tpl);?>
</p>
        </div> 
        <label><?php echo smartyTranslate(array('s'=>'Withdrawal point carrier','mod'=>'socolissimo'),$_smarty_tpl);?>
 : </label>
        <div class="margin-form">
            <select name="id_socolissimocc_allocation">
                <?php  $_smarty_tpl->tpl_vars['carrier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['carrier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['carrier_socolissimo_cc']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['carrier']->key => $_smarty_tpl->tpl_vars['carrier']->value) {
$_smarty_tpl->tpl_vars['carrier']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['carrier']->value['id_carrier']==$_smarty_tpl->tpl_vars['id_socolissimo_cc']->value) {?>
                        <option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
" selected><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 - <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
                    <?php } else { ?>
                        <option value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['id_carrier'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 - <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['carrier']->value['name'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</option>
                    <?php }?>
                <?php } ?>
            </select>
            <p><?php echo smartyTranslate(array('s'=>'Carrier used to get "Colissimo at a withdrawal point" cost','mod'=>'socolissimo'),$_smarty_tpl);?>
</p>
        </div>
    </fieldset>
    <div class="clear">&nbsp;</div>
    <fieldset><legend><img src="<?php echo $_smarty_tpl->tpl_vars['moduleDir']->value;?>
/logo.gif" alt="" /><?php echo smartyTranslate(array('s'=>'Save configuration','mod'=>'socolissimo'),$_smarty_tpl);?>
</legend>
        <div class="margin-form"> 
            <?php echo smartyTranslate(array('s'=>'Don\'t hesitate to read the','mod'=>'socolissimo'),$_smarty_tpl);?>
 
            <b><a href="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['moduleDir']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
/readme_fr.pdf" target="_blank"><?php echo smartyTranslate(array('s'=>'Vendor manual','mod'=>'socolissimo'),$_smarty_tpl);?>
 </a></b> 
            <?php echo smartyTranslate(array('s'=>'to help you to configure the module','mod'=>'socolissimo'),$_smarty_tpl);?>
 
        </div>
        <div class="margin-form">
            <input type="submit" value="<?php echo smartyTranslate(array('s'=>'Save','mod'=>'socolissimo'),$_smarty_tpl);?>
" name="submitSave" class="button" style="margin:10px 0px 0px 25px;" />
        </div>
    </fieldset>
</form>

    <script type="text/javascript">
        $(document).ready(function () {
            $(".supcostbelg").change(function () {
                var ttc = $(".supcostbelg").val() * (1 + ($(".taxrate").val() / 100));
                ttc = Math.round(ttc * 100) / 100;
                $(".costbelgttc").val(ttc);
            });
        });
    </script>
<?php }} ?>
