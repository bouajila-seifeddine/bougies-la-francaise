<!-- MODULE allinone_rewards -->
<script type="text/javascript">
//<![CDATA[
	var url_allinone_facebook="{$link->getModuleLink('allinone_rewards', 'facebook', [], true)}";
//]]>
</script>
<div id="rewards_facebookconfirm">
	{$facebook_confirm_txt}
	{if $facebook_code}
	<center>{l s='Code :' mod='allinone_rewards'} <span id="rewards_facebookcode"></span></center>
	{/if}
</div>
<!-- END : MODULE allinone_rewards -->