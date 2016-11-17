<?php /* Smarty version Smarty-3.1.19, created on 2016-11-17 10:52:46
         compiled from "/home/bougies-la-francaise/public_html/modules/pressreviews/views/templates/front/pagination.tpl" */ ?>
<?php /*%%SmartyHeaderCode:242734014582d7dee122823-30791122%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff5121f01ef87a52c3c8721e28dfb10ecd295f22' => 
    array (
      0 => '/home/bougies-la-francaise/public_html/modules/pressreviews/views/templates/front/pagination.tpl',
      1 => 1478101075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '242734014582d7dee122823-30791122',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'no_follow' => 0,
    'p' => 0,
    'link' => 0,
    'start' => 0,
    'end' => 0,
    'no_follow_text' => 0,
    'p_previous' => 0,
    'requestPage' => 0,
    'pages_nb' => 0,
    'p_next' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_582d7dee1e61c7_98774184',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d7dee1e61c7_98774184')) {function content_582d7dee1e61c7_98774184($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['no_follow']->value)&&$_smarty_tpl->tpl_vars['no_follow']->value) {?>
    <?php $_smarty_tpl->tpl_vars['no_follow_text'] = new Smarty_variable('rel="nofollow"', null, 0);?>
<?php } else { ?>
    <?php $_smarty_tpl->tpl_vars['no_follow_text'] = new Smarty_variable('', null, 0);?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['p']->value)&&$_smarty_tpl->tpl_vars['p']->value) {?>

    
    <?php $_smarty_tpl->tpl_vars['requestPage'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPageLink('module-pressreviews-default'), null, 0);?>
    <?php $_smarty_tpl->tpl_vars['requestNb'] = new Smarty_variable($_smarty_tpl->tpl_vars['link']->value->getPaginationLink(false,false,true,false,false,true), null, 0);?>

    <!-- Pagination -->
    <div id="pagination" class="pagination">
    <?php if ($_smarty_tpl->tpl_vars['start']->value!=$_smarty_tpl->tpl_vars['end']->value) {?>
        <ul class="pagination">
        <?php if ($_smarty_tpl->tpl_vars['p']->value!=1) {?>
            <?php $_smarty_tpl->tpl_vars['p_previous'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value-1, null, 0);?>
            <li id="pagination_previous"><a <?php echo $_smarty_tpl->tpl_vars['no_follow_text']->value;?>
 rel="<?php echo $_smarty_tpl->tpl_vars['p_previous']->value;?>
" class="pagination_page_number" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['requestPage']->value,$_smarty_tpl->tpl_vars['p_previous']->value);?>
"><i class="icon-chevron-left"></i></a></li>
        <?php } else { ?>
            <li id="pagination_previous" class="disabled"><span><i class="icon-chevron-left"></i></span></li>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['start']->value>3) {?>
            <li><a <?php echo $_smarty_tpl->tpl_vars['no_follow_text']->value;?>
 rel="1" class="pagination_page_number" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['requestPage']->value,1);?>
">1</a></li>
        <?php }?>
        <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['name'] = 'pagination';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = (int) $_smarty_tpl->tpl_vars['start']->value;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['end']->value+1) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total']);
?>
            <?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']) {?>
                <li class="current"><span><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['p']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</span></li>
            <?php } else { ?>
                <li><a <?php echo $_smarty_tpl->tpl_vars['no_follow_text']->value;?>
 rel="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
" class="pagination_page_number" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['requestPage']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</a></li>
            <?php }?>
        <?php endfor; endif; ?>
        <?php if ($_smarty_tpl->tpl_vars['pages_nb']->value>$_smarty_tpl->tpl_vars['end']->value+2) {?>
            <li><a rel="<?php echo $_smarty_tpl->tpl_vars['pages_nb']->value;?>
" class="pagination_page_number" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['requestPage']->value,$_smarty_tpl->tpl_vars['pages_nb']->value);?>
"><?php echo intval($_smarty_tpl->tpl_vars['pages_nb']->value);?>
</a></li>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['pages_nb']->value>1&&$_smarty_tpl->tpl_vars['p']->value!=$_smarty_tpl->tpl_vars['pages_nb']->value) {?>
            <?php $_smarty_tpl->tpl_vars['p_next'] = new Smarty_variable($_smarty_tpl->tpl_vars['p']->value+1, null, 0);?>
            <li id="pagination_next"><a class="pagination_page_number" <?php echo $_smarty_tpl->tpl_vars['no_follow_text']->value;?>
 rel="<?php echo $_smarty_tpl->tpl_vars['p_next']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['requestPage']->value,$_smarty_tpl->tpl_vars['p_next']->value);?>
"><i class="icon-chevron-right"></i></a></li>
        <?php } else { ?>
            <li id="pagination_next" class="disabled"><span><i class="icon-chevron-right"></i></span></li>
        <?php }?>
        </ul>
    <?php }?>
    </div>

    <!-- /Pagination -->

<?php }?><?php }} ?>
