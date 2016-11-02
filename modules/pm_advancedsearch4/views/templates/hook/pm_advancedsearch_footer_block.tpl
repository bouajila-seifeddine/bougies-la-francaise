{if $hookName eq 'leftColumn' || $hookName eq 'rightColumn'}
		</div>
	</div>
{if !isset($smarty.request.ajaxMode)}
</div>
{/if}
{else}
		</div>
	</div>
{if !isset($smarty.request.ajaxMode)}
</div>
{/if}
{if $hookName eq 'top'}
	<div>
{/if}
{if $hookName eq 'home' && !isset($smarty.request.ajaxMode)}
	<div class="clear"></div>
	<div id="as_home_content_results">
	</div>
{/if}
{/if}