{if isset($no_follow) AND $no_follow}
    {assign var='no_follow_text' value='rel="nofollow"'}
{else}
    {assign var='no_follow_text' value=''}
{/if}
{if isset($p) AND $p}

    {*{assign var='requestPage' value=$link->getPaginationLink($link->getPageLink('module-pressreviews-default'), false, false, false, true, false)}*}
    {assign var='requestPage' value=$link->getPageLink('module-pressreviews-default')}
    {assign var='requestNb' value=$link->getPaginationLink(false, false, true, false, false, true)}

    <!-- Pagination -->
    <div id="pagination" class="pagination">
    {if $start!=$end}
        <ul class="pagination">
        {if $p != 1}
            {assign var='p_previous' value=$p-1}
            <li id="pagination_previous"><a {$no_follow_text} rel="{$p_previous}" class="pagination_page_number" href="{$link->goPage($requestPage, $p_previous)}">&laquo;&nbsp;{l s='Previous' mod='pressreviews'}</a></li>
        {else}
            <li id="pagination_previous" class="disabled"><span>&laquo;&nbsp;{l s='Previous' mod='pressreviews'}</span></li>
        {/if}
        {if $start>3}
            <li><a {$no_follow_text} rel="1" class="pagination_page_number" href="{$link->goPage($requestPage, 1)}">1</a></li>
            <li class="truncate">...</li>
        {/if}
        {section name=pagination start=$start loop=$end+1 step=1}
            {if $p == $smarty.section.pagination.index}
                <li class="current"><span>{$p|escape:'htmlall':'UTF-8'}</span></li>
            {else}
                <li><a {$no_follow_text} rel="{$smarty.section.pagination.index}" class="pagination_page_number" href="{$link->goPage($requestPage, $smarty.section.pagination.index)}">{$smarty.section.pagination.index|escape:'htmlall':'UTF-8'}</a></li>
            {/if}
        {/section}
        {if $pages_nb>$end+2}
            <li class="truncate">...</li>
            <li><a rel="{$pages_nb}" class="pagination_page_number" href="{$link->goPage($requestPage, $pages_nb)}">{$pages_nb|intval}</a></li>
        {/if}
        {if $pages_nb > 1 AND $p != $pages_nb}
            {assign var='p_next' value=$p+1}
            <li id="pagination_next"><a class="pagination_page_number" {$no_follow_text} rel="{$p_next}" href="{$link->goPage($requestPage, $p_next)}">{l s='Next' mod='pressreviews'}&nbsp;&raquo;</a></li>
        {else}
            <li id="pagination_next" class="disabled"><span>{l s='Next' mod='pressreviews'}&nbsp;&raquo;</span></li>
        {/if}
        </ul>
    {/if}
    </div>

    <!-- /Pagination -->

{/if}