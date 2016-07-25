<!-- MODULE allinone_rewards -->
<div class="{if $version16}col-lg-12{else}clear{/if}" id="admincustomer_sponsorship">
{if $version16}
	<div class="panel">
		<div class="panel-heading">{l s='Sponsorship program' mod='allinone_rewards'}</div>
		{if $msg}{$msg}{/if}
{else}
		<h2>{l s='Sponsorship program' mod='allinone_rewards'}</h2>
		{if $msg}{$msg}<br>{/if}
{/if}
		{if $sponsor}
			{l s='Sponsor' mod='allinone_rewards'} <a href="?tab=AdminCustomers&id_customer={$sponsor->id}&viewcustomer&token={getAdminToken tab='AdminCustomers'}">{$sponsor->firstname} {$sponsor->lastname}</a><br>
		{else}
		<form id='sponsor' method='post'>
			{l s='Choose a sponsor :' mod='allinone_rewards'}&nbsp;
			&nbsp;<input class="button" name="submitSponsor" id="submitSponsor" value="{l s='Save settings' mod='allinone_rewards'}" type="submit" />
			<select name="new_sponsor" style="display: inline; width: auto;">
				<option value="0">{l s='-- No sponsor --' mod='allinone_rewards'}</option>
			{foreach from=$available_sponsors item=new_sponsor}
				<option value='{$new_sponsor['id_customer']}'>{$new_sponsor['firstname']} {$new_sponsor['lastname']} (ID : {$new_sponsor['id_customer']})</option>
			{/foreach}
			</select>
			{if $discount_gc}
				&nbsp;&nbsp;&nbsp;&nbsp;{l s='Generate the welcome voucher ?' mod='allinone_rewards'}&nbsp;<input checked type="checkbox" value="1" name="generate_voucher" style="display: inline; width: auto;">&nbsp;
				<select name="generate_currency" style="display: inline !important; width: auto;">
				{foreach from=$currencies item=currency}
					<option {if $default_currency==$currency['id_currency']}selected{/if} value="{$currency['id_currency']}">{$currency['name']}</option>
				{/foreach}
				</select>
			{/if}
		</form>
		<br>
		{/if}
		{if $friends|@count}
		<table cellspacing='0' cellpadding='0' class='table'>
			<thead>
				<tr style="background-color: #EEEEEE">
					<th colspan='2' style='text-align: center'>{l s='Rewards' mod='allinone_rewards'}</th>
					<th colspan='5' style='text-align: center'>{l s='Sponsored friends (Level 1)' mod='allinone_rewards'}</th>
				</tr>
				<tr style="background-color: #EEEEEE">
					<th style='text-align: center'>{l s='Direct rewards' mod='allinone_rewards'}</th>
					<th style='text-align: center'>{l s='Indirect rewards' mod='allinone_rewards'}</th>
					<th style='text-align: center'>{l s='Pending' mod='allinone_rewards'}</th>
					<th style='text-align: center'>{l s='Registered' mod='allinone_rewards'}</th>
					<th style='text-align: center'>{l s='With orders' mod='allinone_rewards'}</th>
					<th style='text-align: center'>{l s='Orders' mod='allinone_rewards'}</th>
					<th style='text-align: center'>{l s='Total' mod='allinone_rewards'}</th>
				</tr>
			</thead>
			<tr>
				<td align='center'>{displayPrice price=$stats['direct_rewards']}</td>
				<td align='center'>{displayPrice price=$stats['indirect_rewards']}</td>
				<td align='center'>{$stats['nb_pending']}</td>
				<td align='center'>{$stats['nb_registered']}</td>
				<td align='center'>{$stats['nb_buyers']}</td>
				<td align='center'>{$stats['nb_orders']}</td>
				<td align='center'>{displayPrice price=$stats['total_orders']}</td>
			</tr>
		</table>
		<div class='clear' style="margin-top: 20px">&nbsp;</div>
		<table cellspacing='0' cellpadding='0' class='table'>
			<thead>
				<tr style="background-color: #EEEEEE">
					<th style='text-align: center'>{l s='Levels' mod='allinone_rewards'}</th>
					<th>{l s='Channels' mod='allinone_rewards'}</th>
					<th>{l s='Name of the friends' mod='allinone_rewards'}</th>
					<th style='text-align: center'>{l s='Number of orders' mod='allinone_rewards'}</th>
					<th style='text-align: right'>{l s='Total orders' mod='allinone_rewards'}</th>
					<th style='text-align: right'>{l s='Total rewards' mod='allinone_rewards'}</th>
				</tr>
			</thead>
			{foreach from=$friends item=sponsored}
				{assign var="channel" value="{l s='Email invitation' mod='allinone_rewards'}"}
				{if ($sponsored['channel']==2)}
					{assign var="channel" value="{l s='Sponsorship link' mod='allinone_rewards'}"}
				{else if ($sponsored['channel']==3)}
					{assign var="channel" value="{l s='Facebook' mod='allinone_rewards'}"}
				{else if ($sponsored['channel']==4)}
					{assign var="channel" value="{l s='Twitter' mod='allinone_rewards'}"}
				{else if ($sponsored['channel']==5)}
					{assign var="channel" value="{l s='Google +1' mod='allinone_rewards'}"}
				{/if}
			<tr>
				<td align='center'>{$sponsored['level_sponsorship']}</td>
				<td>{$channel}</td>
				<td>{$sponsored['lastname']} {$sponsored['firstname']}</td>
				<td align='center'>{$sponsored['nb_orders']}</td>
				<td align='right'>{displayPrice price=$sponsored['total_orders']}</td>
				<td align='right'>{displayPrice price=$sponsored['total_rewards']}</td>
			</tr>
			{/foreach}
		</table>
		{else}
			{l s='This customer has not sponsored any friends yet.' mod='allinone_rewards'}
		{/if}
{if $version16}
	</div>
{/if}
</div>
<!-- END : MODULE allinone_rewards -->