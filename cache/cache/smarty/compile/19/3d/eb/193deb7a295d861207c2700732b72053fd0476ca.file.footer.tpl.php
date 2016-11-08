<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:44
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/spread/views/templates/hook/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:325542994581a1298d7bdd8-58263850%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '193deb7a295d861207c2700732b72053fd0476ca' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/modules/spread/views/templates/hook/footer.tpl',
      1 => 1475244963,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '325542994581a1298d7bdd8-58263850',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'publicKeySb' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a1298d80be4_60888004',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a1298d80be4_60888004')) {function content_581a1298d80be4_60888004($_smarty_tpl) {?><script>
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
