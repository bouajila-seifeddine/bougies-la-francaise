
{if count($categories) > 1}
    <div id="category-filter">
        <h3>{l s='Refine my selection' mod='filtercategory'}</h3>
        <p class="minus">{$current_category->name}</p>
        <div class="outer-category">
            <ul>
                {foreach from=$categories item=category}
                    <li><a href="{$category.link|escape:'htmlall':'UTF-8'}" {if isset($current_category) && $category.id_category == $current_category->id_category}class="selected"{/if} title="{$category.description|strip_tags|trim|escape:'htmlall':'UTF-8'}">{$category.name|escape:'htmlall':'UTF-8'}</a></li>
                {/foreach}
            </ul>
        </div>
    </div>
{/if}