	<form action="{$ASSearchUrlForm}" method="GET" class="PM_ASSelections PM_ASSelectionsResults">
	{if (is_array($as_searchs[0].selected_criterion) AND sizeof($as_searchs[0].selected_criterion)) OR isset($as_searchs[0].price_range_selected)}
		<p><b>{l s='Your selection' mod='pm_advancedsearch4'}</b></p>
		<ul>
			{if isset($as_searchs[0].price_range_selected)}
				<li>&nbsp;&nbsp;<b>{l s='Price' mod='pm_advancedsearch4'}</b> : <a href="javascript:void(0)" class="PM_ASSelectionsRemoveLink">{$as_searchs[0].price_range_selected[0]} {$currency->sign}</a><input type="hidden" name="as_price_range" value="{$as_searchs[0].price_range_selected[1]}" /></li>
			{/if}
			{if is_array($as_searchs[0].selected_criterion) AND sizeof($as_searchs[0].selected_criterion) && isset($as_searchs[0].criterions_groups_selected) && is_array($as_searchs[0].criterions_groups_selected)}
				{foreach from=$as_searchs[0].criterions_groups_selected item=criterions_group name=criterions_groups}
					{assign var='crit_name_is_display' value='0'}
					{foreach from=$as_searchs[0].criterions_selected[$criterions_group.id_criterion_group] key=criterion_key item=criterion name=criterions}
						{if isset($criterion.id_criterion) AND $criterions_group.visible AND $criterion.id_criterion|in_array:$as_searchs[0].selected_criterion[$criterions_group.id_criterion_group]}
							<li>{if !$crit_name_is_display}&nbsp;&nbsp;<b>{$criterions_group.name|escape:'htmlall':'UTF-8'}</b> : {assign var='crit_name_is_display' value='1'}{else}, {/if} <a href="javascript:void(0)" class="PM_ASSelectionsRemoveLink">{if isset($criterion.single_value) && $criterion.single_value}{$criterion.single_value|escape:'htmlall':'UTF-8'}{else}{$criterion.value|escape:'htmlall':'UTF-8'}{/if}</a><input type="hidden" name="as4c[{$criterions_group.id_criterion_group|intval}][]" value="{$criterion.id_criterion}" /></li>
						{/if}
					{/foreach}
				{/foreach}
			{/if}
		</ul>
		{if is_array($as_searchs[0].selected_criterion) AND sizeof($as_searchs[0].selected_criterion) && isset($as_searchs[0].criterions_groups_selected) && is_array($as_searchs[0].criterions_groups_selected)}
			{foreach from=$as_searchs[0].criterions_groups_selected item=criterions_group name=criterions_groups}
				{foreach from=$as_searchs[0].criterions_selected[$criterions_group.id_criterion_group] key=criterion_key item=criterion name=criterions}
					{if isset($criterion.id_criterion) AND !$criterions_group.visible AND $criterion.id_criterion|in_array:$as_searchs[0].selected_criterion[$criterions_group.id_criterion_group]}
						<input type="hidden" name="as4c[{$criterions_group.id_criterion_group|intval}][]" value="{$criterion.id_criterion}" />
					{/if}
				{/foreach}
			{/foreach}
		{/if}
		<input type="hidden" name="id_search" value="{$as_searchs[0].id_search|intval}" />
		<input type="hidden" name="hookName" value="{$hookName}" />
		{if (isset($smarty.request.keep_category_information) && $smarty.request.keep_category_information) || ($as_searchs[0].keep_category_information && ((isset($smarty.get.id_category) && $smarty.get.id_category && $page_name eq 'category') || (isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer && $page_name eq 'manufacturer') || (isset($smarty.get.id_supplier) && $smarty.get.id_supplier && $page_name eq 'supplier') || (isset($smarty.get.seo_url) && $smarty.get.seo_url)))}
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
		{if $as_searchs[0].step_search}
		<input type="hidden" name="step_search" value="{$as_searchs[0].step_search|intval}" />
	{/if}
	{/if}
	</form>
	<script type="text/javascript">if(!$jqPm('.PM_ASSelectionsResults ul li').length)$jqPm('.PM_ASSelectionsResults').hide();</script>