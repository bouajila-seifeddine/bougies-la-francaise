<div class="asShareLeft">
	<!-- AddThis Button BEGIN -->
			<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
				<a class="addthis_button_google" addthis:url="{$ASShareUrl}" addthis:title="{$ASSearchTitle}" addthis:template="{ldelim}{ldelim}title{rdelim}{rdelim}: found here: {ldelim}{ldelim}url{rdelim}{rdelim}"></a>
    			<a class="addthis_button_facebook" addthis:url="{$ASShareUrl} " addthis:title="{$ASSearchTitle}" addthis:template="{ldelim}{ldelim}title{rdelim}{rdelim}: found here: {ldelim}{ldelim}url{rdelim}{rdelim}"></a>
    			<a class="addthis_button_twitter" addthis:url="{$ASShareUrl} " addthis:title="{$ASSearchTitle}" addthis:template="{ldelim}{ldelim}title{rdelim}{rdelim}: found here: {ldelim}{ldelim}url{rdelim}{rdelim}"></a>
				<a class="addthis_button_email" addthis:url="{$ASShareUrl}" addthis:title="{$ASSearchTitle}" addthis:template="{ldelim}{ldelim}title{rdelim}{rdelim}: found here: {ldelim}{ldelim}url{rdelim}{rdelim}"></a>
				<a class="addthis_counter addthis_bubble_style" addthis:url="{$ASShareUrl}" addthis:title="{$ASSearchTitle}" addthis:template="{ldelim}{ldelim}title{rdelim}{rdelim}: found here: {ldelim}{ldelim}url{rdelim}{rdelim}"></a>
			</div>
			<script type="text/javascript">
				var addthis_config = {ldelim}
                     data_track_linkback: false,
                     data_track_clickback:false
                {rdelim}
				if (window.addthis) {ldelim}
					window.addthis.ost = 0;
					window.addthis.ready();
					
					{rdelim}
				 $.getScript('http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e7b3cd65f4a9c5f&domready=1', function() {ldelim}
				 	addthis.init();
		            addthis.toolbox(".addthis_toolbox");	
		            addthis.counter(".addthis_counter");
		          {rdelim});
				
			</script>
	<!-- AddThis Button END -->
</div>
<div class="asShareRight">
	<b>{l s='Or on your Blog or Website:' mod='pm_advancedsearch4'}</b><br />
	<input type="text" value="{$ASShareUrl}" id="asShareUrl" />
</div>
<div class="clear"></div>