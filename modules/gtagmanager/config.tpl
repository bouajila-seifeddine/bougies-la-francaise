<form method="post" action="">
	<fieldset>
        <legend>
			<img class="middle" alt="" src="../img/admin/cog.gif">
			{l s='Tracking settings' mod='gtagmanager'}
		</legend>
		<label>{l s='Enable tracking' mod='gtagmanager'}</label>
        <div class="margin-form">
			<label style="float:none;padding: 0">
				<input
					type="checkbox"
					value="on"
					name="GTAGMANAGER_ON"
					class="tracking-method"
					{if $GTAGMANAGER_ON}checked="checked"{/if}
					/>
			</label>
        </div>
		<label>{l s='Google Tag Manager tracking code' mod='gtagmanager'}</label>
        <div class="margin-form">
			<label style="float:none;padding: 0">
				<textarea name="GTAGMANAGER_TRACKING_CODE" cols="90" rows="10">{if !empty($GTAGMANAGER_TRACKING_CODE)}{$GTAGMANAGER_TRACKING_CODE}{/if}</textarea>
			</label>
			<p><a href="#" id="show-instruction">{l s='How to get your Google Tag Manager tracking code?' mod='gtagmanager'}</a></p>
        </div>
		<div id="instruction" style="display: none;">
			<p>
				{l s='Go to https://www.google.com/tagmanager/web/#provision/AccountStep/, log in with your Google Account and follow the steps.' mod='gtagmanager'}
			</p>
			<p>
				<img src="{$module_dir}img/ss1.jpg" />
			</p>
		</div>
	</fieldset>
	<p>
		<input type="submit" class="button" value="{l s='Update' mod='gtagmanager'}" name="submitUpdate">
	</p>
</form>
	{literal}
	<script type="text/javascript">
		jQuery('#show-instruction').click(function(e){
			e.preventDefault();
			jQuery('#instruction').slideToggle();
		});
	</script>
	{/literal}
<style type="text/css">
{literal}
#sutu_ad{width:640px;border-color:#C0B882;border-style:solid;border-width:2px;margin:35px auto auto;}
#sutu_ad p{line-height:18px;margin-left:20px;}
#sutu_ad a{color:#2561DB;}
#sutu_ad a:hover{color:#000;}
#logobig{padding-bottom:10px;padding-top:10px;text-align:center;}
{/literal}
</style>
<div id="sutu_ad">
	<p>{l s='Ce module a été développé par ' mod='gtagmanager'}<a href="http://www.sutunam.com/" title="Sutunam.com" target="_blank"><strong>Sutunam</strong></a>{l s=', agence web spécialisée E-commerce (Prestashop, Magento)' mod='gtagmanager'}<br/>
		{l s='Contactez-nous par téléphone +33(0) 4 825 331 75 ou par ' mod='gtagmanager'}<a href="mailto:contact@sutunam.com" title="Adresse mail">email.</a><br/>
		{l s='Suivez-nous sur notre compte Twitter : ' mod='gtagmanager'}<a href="https://twitter.com/#!/sutunam" target="_blank">@Sutunam</a></p>
	<div id="logobig"><a href="http://www.sutunam.com/" title="Sutunam.com" target="_blank"><img src="{$module_dir}img/logo2.jpg"></img></a></div>
</div>