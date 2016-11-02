
<!--Gallery Fullscreen*********************************-->
<div id="productzoomimage">
    <ul id="gallery-full">
        {foreach from=$images item=image name=thumbnails key=i}
            {assign var=imageIds value="`$product->id`-`$image.id_image`"}
            <li><img data-src="{$link->getImageLink($product->link_rewrite, $imageIds)}" alt="{$image.legend|htmlspecialchars}" /></li>
        {/foreach}
    </ul>
    
    <ul id="gallery-small" class="{$vertical_position} {$horizontal_position}">
        {foreach from=$images item=image name=thumbnails}
            {assign var=imageIds value="`$product->id`-`$image.id_image`"}
            <li style="background: {$background};">
                <img src="{$link->getImageLink($product->link_rewrite, $imageIds)}" alt="{$image.legend|htmlspecialchars}"/>
            </li>
        {/foreach}
    </ul>

    <div id="gallery-detail" class="{$vertical_position} {$horizontal_position}" style="background: {$background};">
        <p style="color: {$color};">{$product->name|escape:'htmlall':'UTF-8'}</p>
        <p class="price" style="color: {$color};"><strong>{l s='Price' mod='productzoomimage'}</strong>{convertPrice price=$productPrice}</p>
        <a href="#" id="gallery-close" title="{l s='Close' mod='productzoomimage'}"></a>
    </div>

    <div id="gallery-loader"></div>
</div>