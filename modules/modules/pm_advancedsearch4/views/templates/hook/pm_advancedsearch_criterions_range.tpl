{***********
Slider
************}

{if $criterions_group.display_type eq 5}
	{if isset($as_search.criterions[$criterions_group.id_criterion_group])}
		<div class="PM_ASCriterionStepEnable">
		{if sizeof($as_search.criterions[$criterions_group.id_criterion_group])}
			{if $criterions_group.criterion_group_type eq 'price'}
				{foreach from=$as_search.criterions[$criterions_group.id_criterion_group] item=criterion name=criterions}
					<input data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" type="hidden" name="as_price_range" id="PM_ASInputPriceRange{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" value="{if isset($criterion.cur_min_price)}{$criterion.cur_min_price|intval} - {$criterion.cur_max_price|intval}{/if}" />
				{/foreach}
			{else}
				{foreach from=$as_search.criterions[$criterions_group.id_criterion_group] item=criterion name=criterions}
					<input data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" type="hidden" name="as4c[{$criterions_group.id_criterion_group|intval}][]" id="PM_ASInputCritRange{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" value="{if isset($criterion.cur_min)}{$criterion.cur_min|intval} - {$criterion.cur_max|intval}{/if}" />
				{/foreach}
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