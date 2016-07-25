{if $hookName eq 'leftColumn' || $hookName eq 'rightColumn'}
{if !isset($smarty.request.ajaxMode)}
<div id="PM_ASBlockOutput_{$as_search.id_search|intval}" class="PM_ASBlockOutput PM_ASBlockOutputVertical">
{/if}
	<div id="PM_ASBlock_{$as_search.id_search|intval}" class="block">
		{if $as_search.title}<h4>{$as_search.title|escape:'htmlall':'UTF-8'}</h4>{/if}
		<div class="block_content">
		{if $as_search.display_nb_result_on_blc} <p class="PM_ASBlockNbProduct"><small class="PM_ASBlockNbProductValue">({$as_search.total_products|intval} {if $as_search.total_products > 1}{l s='products' mod='pm_advancedsearch4'}{else}{l s='product' mod='pm_advancedsearch4'}{/if})</small></p>{/if}
{else}
{if !isset($ajaxMode) && $hookName eq 'top'}
</div>
<div class="clear"></div>
{/if}
{if !isset($smarty.request.ajaxMode)}
<div id="PM_ASBlockOutput_{$as_search.id_search|intval}" class="PM_ASBlockOutput PM_ASBlockOutputHorizontal">
{/if}
	<div id="PM_ASBlock_{$as_search.id_search|intval}">
		{if $as_search.title}<h4 class="PM_ASearchTitle">{$as_search.title|escape:'htmlall':'UTF-8'}{if $as_search.display_nb_result_on_blc} <small class="PM_ASBlockNbProductValue">({$as_search.total_products|intval} {if $as_search.total_products > 1}{l s='products' mod='pm_advancedsearch4'}{else}{l s='product' mod='pm_advancedsearch4'}{/if})</small>{/if}</h4>{/if}
		<div class="block_content">
{/if}