	<form action="{$ASSearchUrlForm}" method="GET" class="PM_ASSelectionsBlock PM_ASSelections">
	<div class="PM_ASSelectionsInner">
	{if (((is_array($as_search.selected_criterion) AND sizeof($as_search.selected_criterion)) OR isset($as_search.price_range_selected)) && !isset($smarty.get.with_product)) || (isset($smarty.get.with_product) && isset($as_search.old_selected_criterion) && is_array($as_search.old_selected_criterion) AND sizeof($as_search.old_selected_criterion))}
		{if (is_array($as_search.selected_criterion) AND sizeof($as_search.selected_criterion) && !isset($smarty.get.with_product))}
			{assign var='current_selection' value=$as_search.selected_criterion}
		{else}
			{if isset($as_search.old_selected_criterion)}
				{assign var='current_selection' value=$as_search.old_selected_criterion}
			{else}
				{assign var='current_selection' value=array()}
			{/if}
		{/if}
		{if $hookName eq 'leftColumn' || $hookName eq 'rightColumn'}
		<div class="PM_ASSelectionsDropDown" id="PM_ASSelectionsDropDown_{$as_search.id_search|intval}">
		<a href="javascript:void(0)" class="PM_ASSelectionsDropDownShowLink"><b>{l s='Your selection' mod='pm_advancedsearch4'}</b></a>
		<div class="PM_ASSelectionsDropDownMenu">
		{/if}
		<ul>
			{foreach from=$as_search.criterions_groups_selected item=criterions_group name=criterions_groups}
				{if isset($as_search.criterions[$criterions_group.id_criterion_group]) && $criterions_group.visible && isset($current_selection[$criterions_group.id_criterion_group]) && is_array($current_selection[$criterions_group.id_criterion_group]) && sizeof($current_selection[$criterions_group.id_criterion_group])}
					{assign var='crit_name_is_display' value='0'}
					<li>
					{foreach from=$as_search.criterions_selected[$criterions_group.id_criterion_group] key=criterion_key item=criterion name=criterions}
						{if (isset($criterion.id_criterion) AND isset($as_search.selected_criterion[$criterions_group.id_criterion_group]) AND is_array($as_search.selected_criterion[$criterions_group.id_criterion_group]) AND $criterion.id_criterion|in_array:$as_search.selected_criterion[$criterions_group.id_criterion_group]) || isset($criterion.min)}
							{if !$crit_name_is_display}&nbsp;&nbsp;<b>{$criterions_group.name|escape:'htmlall':'UTF-8'}</b> : {if $hookName eq 'leftColumn' || $hookName eq 'rightColumn'}<br />{/if}{assign var='crit_name_is_display' value='1'}{else}, {/if} <a href="javascript:void(0)" class="PM_ASSelectionsRemoveLink">{if isset($criterion.min) && isset($criterion.max)}{$criterion.min|floatval} {$criterion.max|floatval}{else}{if isset($criterion.single_value) && $criterion.single_value}{$criterion.single_value|escape:'htmlall':'UTF-8'}{else}{$criterion.value|escape:'htmlall':'UTF-8'}{/if}{/if}</a><input type="hidden" name="as4c[{$criterions_group.id_criterion_group|intval}][]" value="{$criterion.id_criterion}" />
						{/if}
					{/foreach}
					</li>
				{/if}
			{/foreach}
		</ul>
		{*Critères invisible*}
		{foreach from=$as_search.criterions_groups_selected item=criterions_group name=criterions_groups}
			{if isset($as_search.criterions[$criterions_group.id_criterion_group]) && !$criterions_group.visible && isset($current_selection[$criterions_group.id_criterion_group]) && is_array($current_selection[$criterions_group.id_criterion_group]) && sizeof($current_selection[$criterions_group.id_criterion_group])}
				{assign var='crit_name_is_display' value='0'}
				{foreach from=$as_search.criterions_selected[$criterions_group.id_criterion_group] key=criterion_key item=criterion name=criterions}
					{if (isset($criterion.id_criterion) AND isset($as_search.selected_criterion[$criterions_group.id_criterion_group]) AND is_array($as_search.selected_criterion[$criterions_group.id_criterion_group]) AND $criterion.id_criterion|in_array:$as_search.selected_criterion[$criterions_group.id_criterion_group]) || isset($criterion.min)}
						<input type="hidden" name="as4c[{$criterions_group.id_criterion_group|intval}][]" value="{$criterion.id_criterion}" />
					{/if}
				{/foreach}
			{/if}
		{/foreach}
		{if $hookName eq 'leftColumn' || $hookName eq 'rightColumn'}
		</div>
		</div>
		<script type="text/javascript">if(!$jqPm('#PM_ASSelectionsDropDown_{$as_search.id_search|intval} div ul li').length)$jqPm('#PM_ASSelectionsDropDown_{$as_search.id_search|intval}').hide();</script>
		{/if}
		<input type="hidden" name="id_search" value="{$as_search.id_search|intval}" />
		<input type="hidden" name="hookName" value="{$hookName}" />
		{if (isset($smarty.request.keep_category_information) && $smarty.request.keep_category_information) || ($as_search.keep_category_information && ((isset($smarty.get.id_category) && $smarty.get.id_category && $page_name eq 'category') || (isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer && $page_name eq 'manufacturer') || (isset($smarty.get.id_supplier) && $smarty.get.id_supplier && $page_name eq 'supplier')) || (isset($smarty.get.seo_url) && $smarty.get.seo_url))}
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
	{/if}
	{/if}

	</div>
	</form>