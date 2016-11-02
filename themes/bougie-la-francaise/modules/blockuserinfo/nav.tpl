<!-- Block user information module NAV  -->
<div class="header_user_info bloc-top-nav">
	{if $is_logged}
		<a class="logout" href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log me out' mod='blockuserinfo'}">
			<i class="icon-power-off"></i>
			{*l s='Sign out' mod='blockuserinfo'*}
		</a>
	{else}
		<a class="login" href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Log in to your customer account' mod='blockuserinfo'}">
			{*l s='Sign in' mod='blockuserinfo'*}
			<i class="ycon-compte"></i>
		</a>
	{/if}
</div>
{if $is_logged}
	<div class="header_user_info bloc-top-nav">
		<a href="{$link->getPageLink('my-account', true)|escape:'html':'UTF-8'}" title="{l s='View my customer account' mod='blockuserinfo'}" class="account" rel="nofollow">
			<span>
				{*$cookie->customer_firstname} {$cookie->customer_lastname*}
				<i class="ycon-compte"></i>
			</span>
		</a>
	</div>
{/if}

<!-- /Block usmodule NAV -->
