{if ($rewards|@count)}
<!-- MODULE allinone_rewards -->
	<div class="{if $version16}col-lg-7{else}clear{/if}" id="adminorders_sponsorship">
	{if $version16}
		<div class="panel">
			<div class="panel-heading">{l s='Sponsorship rewards for this order' mod='allinone_rewards'}</div>
	{else}
			<br>
			<fieldset>
				<legend>{l s='Sponsorship rewards for this order' mod='allinone_rewards'}</legend>
	{/if}

				<table style="width: 100%">
					<tr style="font-weight: bold">
						<td>{l s='Level' mod='allinone_rewards'}</td>
						<td>{l s='Name' mod='allinone_rewards'}</td>
						<td>{l s='Reward' mod='allinone_rewards'}</td>
						<td>{l s='Status' mod='allinone_rewards'}</td>
					</tr>
	{foreach from=$rewards item=reward}
					<tr>
						<td>{$reward['level_sponsorship']}</td>
						<td>{$reward['firstname']} {$reward['lastname']}</td>
						<td>{displayPrice price=$reward['credits']}</td>
						<td>{$reward['state']}</td>
					</tr>
	{/foreach}
				</table>
{if $version16}
		</div>
{else}
			</fieldset>
{/if}
	</div>
<!-- END : MODULE allinone_rewards -->
{/if}