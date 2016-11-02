{***********
Select Type
************}
{if $criterions_group.display_type eq 1}
	{if isset($as_search.criterions[$criterions_group.id_criterion_group])}
		<div class="PM_ASCriterionStepEnable">
		{if sizeof($as_search.criterions[$criterions_group.id_criterion_group])}
			<select data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" name="as4c[{$criterions_group.id_criterion_group|intval}][]" id="PM_ASCriterionGroupSelect_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterionGroupSelect">
			<option value="">{l s='All' mod='pm_advancedsearch4'}</option>
			{foreach from=$as_search.criterions[$criterions_group.id_criterion_group] item=criterion name=criterions}
					{if isset($as_search.selected_criterion[$criterions_group.id_criterion_group]) && $criterion.id_criterion|in_array:$as_search.selected_criterion[$criterions_group.id_criterion_group]}
							{assign var='as_criterion_is_selected' value='1'}
						{else}
							{assign var='as_criterion_is_selected' value='0'}
					{/if}
					<option value="{$criterion.id_criterion}" {if $as_criterion_is_selected}selected="selected"{/if}{if !$criterion.nb_product} class="PM_ASCriterionDisable" disabled="disabled"{/if}>{$criterion.value|escape:'htmlall':'UTF-8'}{if $as_search.display_nb_result_criterion} ({$criterion.nb_product|escape:'htmlall':'UTF-8'}){/if}</option>
			{/foreach}
			</select>
		{else}
			<p class="PM_ASCriterionNoChoice">{l s='No choice available on this group' mod='pm_advancedsearch4'}</p>
		{/if}
		</div>
	{/if}
	{if $as_search.step_search}
		<div class="PM_ASCriterionStepDisable" {if isset($as_search.criterions[$criterions_group.id_criterion_group])} style="display:none;"{/if}>
			<select data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" disabled="disabled" name="as4c[{$criterions_group.id_criterion_group|intval}][]" id="PM_ASCriterionGroupSelect_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterionGroupSelect">
				<option value="">{l s='Select above criteria' mod='pm_advancedsearch4'}</option>
			</select>
		</div>
	{/if}
{/if}