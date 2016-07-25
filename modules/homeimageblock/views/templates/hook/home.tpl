
{if !empty($images)}
    <ul id="homeimageblock" style="margin-left: -{$left_margin}px">
        <!-- product attribute to add at cart when click on add button -->
        {foreach from=$images item=image}
            <li class="item" style="margin-left: {$left_margin}px; margin-bottom: {$bottom_margin}px">
                {if $image.url != ""}
                    <a href="{$image.url}" title="{$image.legend}" {if $animate == 1}class="animate"{/if}>
                {/if}
                        <img src="{$image.image}" alt="{$image.legend}" width="{$image.image_width}" height="{$image.image_height}" style="display: block;"/>
                 {if $image.url != ""}
                    </a>
                {/if}    
            </li>
        {/foreach}
    </ul>
    <script type="text/javascript">
        var margin_animation = {$animate_px};
    </script>        
{/if}