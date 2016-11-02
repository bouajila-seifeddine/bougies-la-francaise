{***********
Image
************}

{if $criterions_group.display_type eq 2}
	{if isset($as_search.criterions[$criterions_group.id_criterion_group])}
		<div class="PM_ASCriterionStepEnable">
		{if sizeof($as_search.criterions[$criterions_group.id_criterion_group])}
			<ul id="PM_ASCriterionGroupImage_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterionGroupImage">
			{foreach from=$as_search.criterions[$criterions_group.id_criterion_group] item=criterion name=criterions}
				{if isset($as_search.selected_criterion[$criterions_group.id_criterion_group]) && $criterion.id_criterion|in_array:$as_search.selected_criterion[$criterions_group.id_criterion_group]}
						{assign var='as_criterion_is_selected' value='1'}
					{else}
						{assign var='as_criterion_is_selected' value='0'}
				{/if}
				{if $criterion_can_hide AND $criterions_group.max_display > 0 AND ($smarty.foreach.criterions.index+1) > $criterions_group.max_display}
						{assign var='hide_next_criterion' value='1'}
					{else}
						{assign var='hide_next_criterion' value='0'}
				{/if}
				<li{if $hide_next_criterion || !$criterion.nb_product} class="{if $hide_next_criterion}PM_ASCriterionHide{/if}{if !$criterion.nb_product}{if $hide_next_criterion} {/if}PM_ASCriterionDisable{/if}"{/if}>
					<a href="javascript:void(0);" data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterionLink {if $as_criterion_is_selected}PM_ASCriterionLinkSelected{/if}{if !$criterions_group.is_multicriteria} PM_ASNotMulticriteria{/if}">
						<img src="{$as_path}search_files/criterions/{$criterion.icon|escape:'htmlall':'UTF-8'}" alt="{$criterion.value|escape:'htmlall':'UTF-8'}{if $as_search.display_nb_result_criterion} ({$criterion.nb_product|escape:'htmlall':'UTF-8'}){/if}" title="{$criterion.value|escape:'htmlall':'UTF-8'} {if $as_search.display_nb_result_criterion}({$criterion.nb_product|escape:'htmlall':'UTF-8'}){/if}" />
					</a>
					<input name="as4c[{$criterions_group.id_criterion_group|intval}][]" type="hidden" value="{$criterion.id_criterion}" {if !$as_criterion_is_selected}disabled="disabled"{/if} />
				</li>
			{/foreach}
			</ul>
			{if $hide_next_criterion}
			<p class="PM_ASCriterionHideToogle{if $as_search.show_hide_crit_method == 2}Click{/if}{if $as_search.show_hide_crit_method == 1}Hover{/if} PM_ASCriterionHideToogle_{$as_search.id_search|intval}"><a href="javascript:void(0);" class="PM_ASCriterionHideToogleLink" ><span class="PM_ASShow">{l s='Show all' mod='pm_advancedsearch4'}</span>{if $as_search.show_hide_crit_method == 2}<span class="PM_ASHide">{l s='Hide' mod='pm_advancedsearch4'}</span>{/if}</a></p>
			{/if}
		{else}
			<p class="PM_ASCriterionNoChoice">{l s='No choice available on this group' mod='pm_advancedsearch4'}</p>
		{/if}
		</div>
	{/if}
	{if $as_search.step_search}
		<div data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterionStepDisable" {if isset($as_search.criterions[$criterions_group.id_criterion_group])} style="display:none;"{/if}>
			<p>{l s='Select above criteria' mod='pm_advancedsearch4'}</p>
		</div>
	{/if}
{/if}