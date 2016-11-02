{***********
Checkbox
************}

{if $criterions_group.display_type eq 4}
	{if isset($as_search.criterions[$criterions_group.id_criterion_group])}
		<div class="PM_ASCriterionStepEnable">
		{if sizeof($as_search.criterions[$criterions_group.id_criterion_group])}
			<ul id="PM_ASCriterionGroupCheckbox_{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" class="PM_ASCriterionGroupCheckbox">
			{if !$criterions_group.is_multicriteria}<li><input type="radio" value="" id="as4c_{$criterions_group.id_criterion_group|intval}_0" name="as4c[{$criterions_group.id_criterion_group|intval}][]" {if !isset($as_search.selected_criterion[$criterions_group.id_criterion_group])}checked="checked"{/if} class="PM_ASCriterionCheckbox" /> <label for="as4c_{$criterions_group.id_criterion_group|intval}_0" clas="PM_ASLabelCheckbox">{l s='All' mod='pm_advancedsearch4'}</label></li>{/if}
			{foreach from=$as_search.criterions[$criterions_group.id_criterion_group] key=criterion_key item=criterion name=criterions}
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

				<li{if $hide_next_criterion || !$criterion.nb_product} data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" class="{if $hide_next_criterion}PM_ASCriterionHide{/if}{if !$criterion.nb_product}{if $hide_next_criterion} {/if}PM_ASCriterionDisable{/if}"{/if}>
					<input type="{if $criterions_group.is_multicriteria}checkbox{else}radio{/if}" value="{$criterion.id_criterion}" data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" id="as4c_{$criterions_group.id_criterion_group|intval}_{$criterion_key|intval}" name="as4c[{$criterions_group.id_criterion_group|intval}][]" {if $as_criterion_is_selected}checked="checked"{/if} class="PM_ASCriterionCheckbox"{if !$criterion.nb_product} disabled="disabled"{/if} /> 
					<label for="as4c_{$criterions_group.id_criterion_group|intval}_{$criterion_key|intval}" class="PM_ASLabelCheckbox">{$criterion.value|escape:'htmlall':'UTF-8'}{if $as_search.display_nb_result_criterion} ({$criterion.nb_product|escape:'htmlall':'UTF-8'}){/if}</label>
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