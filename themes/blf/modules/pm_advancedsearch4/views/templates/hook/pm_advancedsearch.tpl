{if isset($hideAS4Form) && $hideAS4Form == true}<div id="PM_ASFormContainerHidden" style="display: none">{/if}
{foreach from=$as_searchs item=as_search name=as_searchs}
	{assign var='next_id_criterion_group_isset' value='0'}
	{include file=$as_obj->_getTplPath("pm_advancedsearch_header_block.tpl")}
	{if $as_search.remind_selection == 3 OR $as_search.remind_selection == 2}
		{include file=$as_obj->_getTplPath("pm_advancedsearch_selection_block.tpl")}
	{/if}
	<a {if !isset($smarty.get.id_seo) && isset($as_selected_criterion) && is_array($as_selected_criterion) && !sizeof($as_selected_criterion)}style="display: none" {/if}href="javascript:void(0)" class="PM_ASResetSearch">{l s='Back' mod='pm_advancedsearch4'}</a>
	<div class="clear"></div>
	<form action="{$ASSearchUrlForm}" method="GET" id="PM_ASForm_{$as_search.id_search|intval}" class="PM_ASForm">
    <h3>{l s='Refine my selection' mod='pm_advancedsearch4'}</h3>
	{foreach from=$as_search.criterions_groups item=criterions_group name=criterions_groups}
		{if !(isset($as_criteria_group_type_interal_name[$criterions_group.display_type]) && $as_criteria_group_type_interal_name[$criterions_group.display_type] == 'slider' && isset($as_search.criterions[$criterions_group.id_criterion_group]) && isset($as_search.criterions[$criterions_group.id_criterion_group][0]) && ((isset($as_search.criterions[$criterions_group.id_criterion_group][0].cur_min) && isset($as_search.criterions[$criterions_group.id_criterion_group][0].cur_max) && $as_search.criterions[$criterions_group.id_criterion_group][0].cur_min == 0 && $as_search.criterions[$criterions_group.id_criterion_group][0].cur_max == 0) || (isset($as_search.criterions[$criterions_group.id_criterion_group][0].min) && isset($as_search.criterions[$criterions_group.id_criterion_group][0].max) && $as_search.criterions[$criterions_group.id_criterion_group][0].min == 0 && $as_search.criterions[$criterions_group.id_criterion_group][0].max == 0))) && ($criterions_group.visible && $as_search.hide_empty_crit_group && isset($as_search.criterions[$criterions_group.id_criterion_group]) && sizeof($as_search.criterions[$criterions_group.id_criterion_group])) || ($criterions_group.visible && !$as_search.hide_empty_crit_group) || ($criterions_group.visible && $as_search.step_search)}
			{if $criterions_group.hidden eq '1' && !isset($hidden_criteria_group_open)}
				{assign var='hidden_criteria_group_open' value='1'}
				<p class="PM_ASShowCriterionsGroupHidden"><a href="javascript:void(0)">{l s='Advanced search' mod='pm_advancedsearch4'}</a></p>
			{/if}
			<div id="PM_ASCriterionsGroup_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" class="{if isset($as_search.seo_criterion_groups) && is_array($as_search.seo_criterion_groups) && in_array($criterions_group.id_criterion_group,$as_search.seo_criterion_groups)}PM_ASCriterionsSEOGroupDisabled {/if}PM_ASCriterionsGroup{if $criterions_group.hidden} PM_ASCriterionsGroupHidden{/if}"{if isset($as_search.advanced_search_open) && $as_search.advanced_search_open} style="display:block;"{/if}>
				{include file=$as_obj->_getTplPath("pm_advancedsearch_criterions.tpl")}
			</div>
			{if $as_search.step_search && $next_id_criterion_group_isset == '0' && !isset($as_search.criterions[$criterions_group.id_criterion_group])}
				{assign var='next_id_criterion_group_isset' value='1'}
			{/if}
		{/if}
		{*if !$as_search.step_search*}
			{if isset($as_search.selected_criterion[$criterions_group.id_criterion_group])}
				{foreach from=$as_search.selected_criterion[$criterions_group.id_criterion_group] item=selected_id_criterion name=selected_criteria}
					{if !$criterions_group.visible}
						<input type="hidden" name="as4c[{$criterions_group.id_criterion_group|intval}][]" value="{$selected_id_criterion}" />
						<input type="hidden" name="as4c_hidden[{$criterions_group.id_criterion_group|intval}][]" value="{$selected_id_criterion}" />
					{/if}
				{/foreach}
			{/if}
		{*/if*}
	{/foreach}
	{if $as_search.dynamic_criterion && $as_search.search_method === '2'}
	<input type="hidden" name="old_selected_criterion" value="{if isset($as_search.old_selected_criterion)}{$as_search.old_selected_criterion|serialize|base64_encode}{else}{$as_search.selected_criterion|serialize|base64_encode}{/if}" />
	{/if}
	{if $as_search.reset_group|intval}
	<input type="hidden" name="reset_group" value="" />
	{/if}

	<input type="hidden" name="id_search" value="{$as_search.id_search|intval}" />
	<input type="hidden" name="hookName" value="{$hookName}" />
	{if (isset($smarty.request.keep_category_information) && $smarty.request.keep_category_information) || ($as_search.keep_category_information && ((isset($smarty.get.id_category) && $smarty.get.id_category && $page_name eq 'category') || (isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer && $page_name eq 'manufacturer') || (isset($smarty.get.id_supplier) && $smarty.get.id_supplier && $page_name eq 'supplier') || (isset($smarty.get.seo_url) && $smarty.get.seo_url)))}
		<input type="hidden" name="keep_category_information" value="1" />
	{/if}
	{if isset($smarty.get.id_category) || isset($smarty.get.id_category_search)}
		<input type="hidden" name="id_category_search" value="{if isset($smarty.get.id_category)}{$smarty.get.id_category|intval}{else}{$smarty.get.id_category_search|intval}{/if}" />
	{/if}
	{if isset($smarty.get.id_manufacturer) || isset($smarty.get.id_manufacturer_search)}
		<input type="hidden" name="id_manufacturer_search" value="{if isset($smarty.get.id_manufacturer)}{$smarty.get.id_manufacturer|intval}{else}{$smarty.get.id_manufacturer_search|intval}{/if}" />
	{/if}
	{if isset($smarty.get.id_supplier) || isset($smarty.get.id_supplier_search)}
		<input type="hidden" name="id_supplier_search" value="{if isset($smarty.get.id_supplier)}{$smarty.get.id_supplier|intval}{else}{$smarty.get.id_supplier_search|intval}{/if}" />
	{/if}
	{if $as_search.step_search}
	<input type="hidden" name="step_search" value="{$as_search.step_search|intval}" />
	<input type="hidden" name="next_id_criterion_group" value="" />
	{/if}
	{if isset($as_search.base_selection) && $as_search.base_selection}
	<input type="hidden" name="as4_base_selection" value="{$as_search.base_selection|serialize|base64_encode}" />
	{/if}
	<input type="hidden" name="orderby"{if isset($smarty.get.orderby) && $smarty.get.orderby} value="{$smarty.get.orderby}"{else} disabled="disabled"{/if} />
	<input type="hidden" name="orderway"{if isset($smarty.get.orderway) && $smarty.get.orderway} value="{$smarty.get.orderway}"{else} disabled="disabled"{/if} />
	<input type="hidden" name="n"{if isset($smarty.get.n) && $smarty.get.n} value="{$smarty.get.n}"{else} disabled="disabled"{/if} />
	{if $as_search.search_method === '2'}
		<input type="submit" value="{l s='Search' mod='pm_advancedsearch4'}" name="submitAsearch" class="button PM_ASSubmitSearch" />
	{/if}
	
	{if isset($smarty.get.id_seo)}
	<input type="hidden" name="id_seo" value="{$smarty.get.id_seo|intval}" />
	{/if}

	<script type="text/javascript">
	if(typeof(ASParams[{$as_search.id_search|intval}]) == 'undefined') {ldelim}
		ASParams[{$as_search.id_search|intval}] = {ldelim}
			'keep_category_information' : {if (isset($smarty.get.id_category) && $smarty.get.id_category && $page_name eq 'category') || (isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer && $page_name eq 'manufacturer') || (isset($smarty.get.id_supplier) && $smarty.get.id_supplier && $page_name eq 'supplier') || (isset($smarty.get.seo_url) && $smarty.get.seo_url)}{$as_search.keep_category_information|intval}{else}0{/if},
			'search_results_selector'	: '{$as_search.search_results_selector}',
			'insert_in_center_column'	: '{$as_search.insert_in_center_column}',
			'seo_criterion_groups'		: '{if isset($as_search.seo_criterion_groups) && is_array($as_search.seo_criterion_groups)}{","|implode:$as_search.seo_criterion_groups}{/if}',
			'as4_productFilterList'		: '{if isset($as4_productFilterList) && !empty($as4_productFilterList)}{$as4_productFilterList}{/if}',
			'scrollTopActive'			: {if isset($as_search.scrolltop_active) && $as_search.scrolltop_active}true{else}false{/if}
		{rdelim};
	{rdelim}
	{if isset($as_location_name) && $as_location_name}
		var as_location_name = '{$as_location_name|addcslashes:"'"}';
		if(typeof(as_location_name) != 'undefined' && as_location_name) {ldelim}
			$(document).ready(function() {ldelim}
				$('#PM_ASBlock_{$as_search.id_search|intval} .PM_ASResetSearch').html("{l s='Back to' mod='pm_advancedsearch4' js=1} "+as_location_name);
			{rdelim});
		{rdelim}
	{/if}
	{if is_array($as_search.selected_criterion) && sizeof($as_search.selected_criterion) && isset($smarty.request.ajaxMode)}
		$('#PM_ASBlock_{$as_search.id_search|intval} .PM_ASResetSearch').css('display','block');
	{/if}
	
		initSearchBlock({$as_search.id_search|intval},{$as_search.search_method|intval},{$as_search.step_search|intval},{$as_search.dynamic_criterion|intval});
		
	{if $as_search.save_selection && !isset($smarty.request.ajaxMode) && ((isset($smarty.get.id_category) && $smarty.get.id_category && $page_name eq 'category') || (isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer && $page_name eq 'manufacturer') || (isset($smarty.get.id_supplier) && $smarty.get.id_supplier && $page_name eq 'supplier')) && $as_search.save_selection_active && is_array($as_search.selected_criterion) && sizeof($as_search.selected_criterion)}
		changeHash({$as_search.id_search|intval});
		asLaunchHash("ASHash[{$as_search.id_search|intval}]");
	{/if}
	</script>
	<div class="clear"></div>
	</form>
	{include file=$as_obj->_getTplPath("pm_advancedsearch_footer_block.tpl")}
{/foreach}
{if isset($hideAS4Form) && $hideAS4Form == true}{literal}</div><script type="text/javascript">$(document).ready(function() { as4_moveFormContainerForSEOPages(); });</script>{/literal}{/if}