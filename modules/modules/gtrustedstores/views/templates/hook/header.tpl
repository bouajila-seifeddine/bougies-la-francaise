{*
* 2003-2015 Business Tech
*
* @author Business Tech SARL <http://www.businesstech.fr/en/contact-us>
* @copyright  2003-2015 Business Tech SARL
*}

<!-- START: Google Trusted Stores module: Badge -->
	<script type="text/javascript">
		var gts = gts || [];

		gts.push(["id", "{$gts_id|escape:'htmlall':'UTF-8'}"]);
		{if $gts_customize_css == true}
			gts.push(["badge_position", "USER_DEFINED"]);
			gts.push(["badge_container", "GTS_CONTAINER"]);
		{else}
			gts.push(["badge_position", "BOTTOM_RIGHT"]);
		{/if}
		gts.push(["locale", "{$gts_language|escape:'htmlall':'UTF-8'}"]);
		gts.push(["google_base_subaccount_id", "{$gts_gmc_id|escape:'htmlall':'UTF-8'}"]);
		gts.push(["google_base_country", "{$gts_country|escape:'htmlall':'UTF-8'}"]);
		gts.push(["google_base_language", "{$gts_language|escape:'htmlall':'UTF-8'}"]);
		{if $gts_product_id|escape:'htmlall':'UTF-8'}gts.push(["google_base_offer_id", "{$gts_product_id|escape:'htmlall':'UTF-8'}"]);{/if}

		{literal}
		(function() {
	    var gts = document.createElement("script");
	    gts.type = "text/javascript";
	    gts.async = true;
	    gts.src = "https://www.googlecommerce.com/trustedstores/api/js";
	    var s = document.getElementsByTagName("script")[0];
	    s.parentNode.insertBefore(gts, s);
	    })();
		{/literal}
	</script>

	{if $gts_customize_css == true}
		<style>
			{$gts_custom_css|escape:'htmlall':'UTF-8'}
		</style>
	{/if}
<!-- END: Google Trusted Stores module: Badge -->
