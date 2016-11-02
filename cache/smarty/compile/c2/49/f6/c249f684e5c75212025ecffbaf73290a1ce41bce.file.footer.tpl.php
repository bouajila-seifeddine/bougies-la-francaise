<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 13:30:30
         compiled from "/raid/www/blf/modules/spread/views/templates/hook/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6995529405819dc66ece9f0-46270087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c249f684e5c75212025ecffbaf73290a1ce41bce' => 
    array (
      0 => '/raid/www/blf/modules/spread/views/templates/hook/footer.tpl',
      1 => 1466504709,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6995529405819dc66ece9f0-46270087',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'publicKeySb' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_5819dc66ed6960_59264397',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5819dc66ed6960_59264397')) {function content_5819dc66ed6960_59264397($_smarty_tpl) {?><script>
    var spconfig = {
        public_key: "<?php echo $_smarty_tpl->tpl_vars['publicKeySb']->value;?>
",
        debug: false,
        set_cookie: true,
        track_order_enabled: false
    };
    function loadSpreadTracker(){ window.domLoadEventFired=true;var e=document.createElement("script");e.type="text/javascript";e.async=true;e.charset="UTF-8";e.id="spread-tracker";e.src="//static-sb.com/js/sb-tracker.js";document.body.appendChild(e) } if(window.addEventListener) { window.addEventListener("load",loadSpreadTracker,false) } else if(window.attachEvent) { window.attachEvent("onload",loadSpreadTracker) } else { window.onload=loadSpreadTracker }
</script>
<?php }} ?>
