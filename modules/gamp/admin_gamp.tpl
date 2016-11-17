<h2>{l s='Google Measurement Analytics Protocol' mod='gamp'}</h2>
{if isset($growl)}{$growl}{/if}
<form action="{$current_index}" method="post">
	<fieldset>
		<legend><img src="../img/admin/cog.gif" alt="" class="middle" />{l s='Settings' mod='gamp'}</legend>
		<label>{l s='GANALYTICS_ID' mod='gamp'}</label>
		<div class="margin-form">
			<input type="text" name="ga_account_id" value="{$ga_account_id}" />
			<p class="clear">{l s='Example:' mod='gamp'}UA-XXXXX-X</p>
		</div>
		<label>{l s='Session timeout' mod='gamp'}</label>
		<div class="margin-form">
			<input type="text" name="ga_session_timeout" value="{$ga_session_timeout}" />
			<p class="clear">{l s='Session duration (better match property settings)' mod='gamp'}</p>
		</div>
		<label>{l s='Activate customer id' mod='gamp'}</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_userid_enabled" {if $ga_userid_enabled}checked="checked"{/if} />
			<p class="clear">{l s='track per customer' mod='gamp'}</p>
		</div>
		<label>{l s='Activate detail on transaction' mod='gamp'}</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_detail_enabled" {if $ga_detail_enabled}checked="checked"{/if} />
			<p class="clear">{l s='taxes, shipping, ...' mod='gamp'}</p>
		</div>
		<label>{l s='Activate enhanced ecommerce' mod='gamp'}</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_ecommerce_enhanced" {if $ga_ecommerce_enhanced}checked="checked"{/if} />
			<p class="clear">{l s='List products within the order' mod='gamp'}</p>
		</div>
		<label>{l s='Activate display features' mod='gamp'}</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_displayfeatures" {if $ga_displayfeatures}checked="checked"{/if} />
			<p class="clear">{l s='Activate display features beacon. Warning: discloses UA code' mod='gamp'} ({$ga_account_id})</p>
		</div>
                <label>{l s='Merge www with non-www' mod='gamp'}</label>
                <div class="margin-form">
                    <input type="checkbox" name="ga_merge_www" {if $ga_merge_www}checked="checked"{/if} />
                    <p class="clear">{l s='Affects referer related to www.tld vs tld traffic'}</p>
                </div>
                <label>{l s='Exclude known robots traffic' mod='gamp'}</label>
                <div class="margin-form">
                    <input type="checkbox" name="ga_exclude_bots" {if $ga_exclude_bots}checked="checked"{/if} />
                    <p class="clear">{l s='Inhibit robots traffic'}</p>
                </div>
		<label>{l s='Run in production' mod='gamp'}</label>
		<div class="margin-form">
			<input type="checkbox" name="ga_measurement_prod" {if $ga_measurement_prod}checked="checked"{/if} />
			<p class="clear">{l s='Run in production' mod='gamp'}</p>
		</div>
		<center>
			<input type="submit" name="submitGAMP" value="{l s='Update' mod='gamp'}" class="button" />
		</center>
	</fieldset>
</form>
