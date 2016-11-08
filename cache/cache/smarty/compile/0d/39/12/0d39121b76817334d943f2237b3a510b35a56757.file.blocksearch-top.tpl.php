<?php /* Smarty version Smarty-3.1.19, created on 2016-11-02 17:21:45
         compiled from "/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blocksearch/blocksearch-top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1638433013581a12991711d9-71426018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d39121b76817334d943f2237b3a510b35a56757' => 
    array (
      0 => '/home/bougies-la-francaise/domains/new.bougies-la-francaise.com/public_html/themes/bougie-la-francaise/modules/blocksearch/blocksearch-top.tpl',
      1 => 1475245119,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1638433013581a12991711d9-71426018',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'search_query' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_581a1299180503_40118978',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_581a1299180503_40118978')) {function content_581a1299180503_40118978($_smarty_tpl) {?>
<!-- Block search module TOP -->
<div id="search_block_nav" class="clearfix bloc-top-nav">
	<div class="searchbox-opener">
		<form id="searchbox" method="get" action="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getPageLink('search',null,null,null,false,null,true), ENT_QUOTES, 'UTF-8', true);?>
" >
			<input type="hidden" name="controller" value="search" />
			<input type="hidden" name="orderby" value="position" />
			<input type="hidden" name="orderway" value="desc" />
			<div class="search-field">
				<input class="search_query form-control" type="text" id="search_query_top" name="search_query" placeholder="<?php echo smartyTranslate(array('s'=>'Search','mod'=>'blocksearch'),$_smarty_tpl);?>
" value="<?php echo stripslashes(mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['search_query']->value, ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8'));?>
" />
			</div>
			<button type="submit" name="submit_search">
				<i class="ycon-right-open-big"></i>
				
			</button>
		</form>
	</div>
	<span class="toggle-search"><i class="ycon-recherche"></i></span>
</div>
<!-- /Block search module TOP --><?php }} ?>
