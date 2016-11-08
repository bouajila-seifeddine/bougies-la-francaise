
{if !empty($images)}
<div id="homeimageblock-bg" style="background-color:{$image_block_backgroud};">
	<div class="container">
		<div class="row">
			<div id="container-homeimageblock" style="margin-left: -{($left_margin|escape:'intval')/2}px">
				<ul id="homeimageblock" class="masonry">
					<!-- product attribute to add at cart when click on add button -->
					{foreach from=$images item=image}
						<li class="item" style="margin-left: {$left_margin|escape:'html'}px; margin-bottom: {$bottom_margin|escape:'html'}px; width:{$image.image_width|escape:'html'}px; height: {$image.image_height|escape:'html'}px">
							{if $image.url|escape:'html' != ""}
								<a href="{$image.url|escape:'html'}" title="{$image.legend|escape:'html'}" {if $animate|escape:'html' == 1}class="animate"{/if}>
							{/if}
									<img src="{$image.image|escape:'html'}" alt="{$image.legend|escape:'html'}" width="{$image.image_width|escape:'html'}" height="{$image.image_height|escape:'html'}" style="display: block;"/>
							 {if $image.url|escape:'html' != ""}
								</a>
							{/if}    
						</li>
					{/foreach}
				</ul>
				<script type="text/javascript">
					var margin_animation = {$animate_px|escape:'html'};
				</script>   
			</div>
		</div>
    </div>
</div>
{/if}