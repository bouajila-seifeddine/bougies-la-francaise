{***********
Slider
************}

{if $criterions_group.display_type eq 5}
	{if isset($as_search.criterions[$criterions_group.id_criterion_group])}
		<div class="PM_ASCriterionStepEnable">
		{if sizeof($as_search.criterions[$criterions_group.id_criterion_group])}
			{foreach from=$as_search.criterions[$criterions_group.id_criterion_group] item=criterion name=criterions}
				{if (isset($criterion.cur_min) && isset($criterion.cur_max) && $criterion.cur_min == 0 && $criterion.cur_max == 0) || (isset($criterion.min) && isset($criterion.max) && $criterion.min == 0 && $criterion.max == 0)}
					<p class="PM_ASCriterionNoChoice">{l s='No choice available on this group' mod='pm_advancedsearch4'}</p>
					<input type="hidden" name="as4c[{$criterions_group.id_criterion_group|intval}][]" id="PM_ASInputCritRange{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" value="{if isset($criterion.cur_min)}{$criterion.cur_min|floatval}-{$criterion.cur_max|floatval}{/if}" />
				{else}
					<div class="PM_ASCritRange" data-id-criterion-group="{$criterions_group.id_criterion_group|intval}" id="PM_ASCritRange{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}"></div>
					<span class="PM_ASCritRangeValue" id="PM_ASCritRangeValue{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}">
						{if isset($criterion.cur_min) && $criterion.cur_min != $criterion.cur_max}
							{$criterion.cur_min|floatval} - {if isset($criterions_group.left_range_sign)}{$criterions_group.left_range_sign|escape:'htmlall':'UTF-8'}{/if}{$criterion.cur_max|floatval}{if isset($criterions_group.right_range_sign)}{$criterions_group.right_range_sign|escape:'htmlall':'UTF-8'}{/if}
						{else}
							{$criterion.min|floatval} - {if isset($criterions_group.left_range_sign)}{$criterions_group.left_range_sign|escape:'htmlall':'UTF-8'}{/if}{$criterion.max|floatval}{if isset($criterions_group.right_range_sign)}{$criterions_group.right_range_sign|escape:'htmlall':'UTF-8'}{/if}
						{/if}
					</span>
					<input type="hidden" name="as4c[{$criterions_group.id_criterion_group|intval}][]" id="PM_ASInputCritRange{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" value="{if isset($criterion.cur_min)}{$criterion.cur_min|floatval}-{$criterion.cur_max|floatval}{/if}" />
					<script type="text/javascript">
							$jqPm( "#PM_ASCritRange{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" ).slider({ldelim}
								range: true,
								min: {$criterion.min|floatval},
								max: {$criterion.max|floatval},
								step: {$criterion.step|floatval},
								values: [ {if isset($criterion.cur_min) && $criterion.cur_min != $criterion.cur_max}{$criterion.cur_min|floatval}, {$criterion.cur_max|floatval}{else}{$criterion.min|floatval}, {$criterion.max|floatval}{/if} ],
								slide: function( event, ui ) {ldelim}
									$jqPm( "#PM_ASCritRangeValue{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" ).html( "" + Math.round(ui.values[ 0 ]*100)/100 + " - " + "{if isset($criterions_group.left_range_sign)}{$criterions_group.left_range_sign|escape:'htmlall':'UTF-8'}{/if}" + Math.round(ui.values[ 1 ]*100)/100 + "{if isset($criterions_group.right_range_sign)}{$criterions_group.right_range_sign|escape:'htmlall':'UTF-8'}{/if}" );
									$jqPm( "#PM_ASInputCritRange{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}" ).val( "" + Math.round(ui.values[ 0 ]*100)/100 + "-" + Math.round(ui.values[ 1 ]*100)/100 );
								{rdelim},
								stop: function(event, ui) {ldelim}
									{if $as_search.step_search}
										nextStep({$as_search.id_search|intval},$('#PM_ASInputCritRange{$as_search.id_search|intval}_{$criterions_group.id_criterion_group|intval}'),null,{$as_search.search_method|intval});
									{else}
										{if $as_search.search_method|intval === 1}
											$jqPm('#PM_ASForm_{$as_search.id_search|intval}').ajaxSubmit(as4_getASFormOptions({$as_search.id_search|intval}));
										{/if}
										{if $as_search.search_method|intval === 2 && $as_search.dynamic_criterion}
											$jqPm('#PM_ASForm_{$as_search.id_search|intval}').ajaxSubmit(as4_getASFormDynamicCriterionOptions({$as_search.id_search|intval}));
										{/if}
									{/if}
									setTimeout( function() {ldelim}
										changeHash({$as_search.id_search|intval});
									{rdelim},500);
								{rdelim}
							{rdelim});
					</script>
				{/if}
			{/foreach}
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