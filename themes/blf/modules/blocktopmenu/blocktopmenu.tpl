<ul id="menu-category">
	{foreach from=$blockCategTree.children item=child name=blockCategTree}
		{if $smarty.foreach.blockCategTree.last}
			{include file="$branche_tpl_path" node=$child last='true'}
		{else}
			{include file="$branche_tpl_path" node=$child}
		{/if}
	{/foreach}

	{if $MENU != ''}
		<li id="blf-menu">
			<a href="#">{l s="Bougies la française" mod="blocktopmenu"}</a>
			<ul>{$MENU}</ul>
		</li>
	{/if}
</ul>