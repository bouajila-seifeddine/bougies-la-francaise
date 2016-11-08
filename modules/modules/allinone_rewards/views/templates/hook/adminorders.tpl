<!-- MODULE allinone_rewards -->
	<div class="{if $version16}col-lg-5{else}clear{/if}" id="adminorders">
{if $version16}
		<div class="panel">
			<div class="panel-heading">{l s='Loyalty reward for this order' mod='allinone_rewards'}</div>
{else}
			<br>
			<fieldset>
				<legend>{l s='Loyalty reward for this order' mod='allinone_rewards'}</legend>
{/if}
				<div style="width: 50%; float: left"><span style="font-weight: bold">{l s='Reward :' mod='allinone_rewards'}</span> {displayPrice price=$reward->credits}</div>
				<div style="width: 50%; float: left"><span style="font-weight: bold">{l s='Status :' mod='allinone_rewards'}</span> {$reward_state}</div>
{if $version16}
		</div>
{else}
			</fieldset>
{/if}
	</div>
<!-- END : MODULE allinone_rewards -->