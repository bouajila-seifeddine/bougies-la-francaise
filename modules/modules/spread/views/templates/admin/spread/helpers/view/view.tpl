{if $case == 1}

    <div id="SpreadAdminHeader"></div>
    <div id="SpreadAdminContent">
        <div class="legend">
            <h5>{l s='You have to set your API key in the configuration of the plugin' mod='spreadbutton'}</h5>
        </div>
    </div>

{elseif $case =='3'}
    {if isset($apiError)}
        <h3>{$apiError}</h3>
    {/if}

    {if isset($showIframe)}
        <div style='margin:5px 0'>
            <iframe style="min-height:1500px;border:none;"  frameborder="0" width='100%' src='http://social-sb.com/boi?token={$tokenSbt}'></iframe>
        </div>
    {/if}

{elseif $case =='4'}
    {if $getError=='unknow user'}
        <div id="SpreadAdminHeader"></div>
        <div id="SpreadAdminContent">
            <div class="legend">
                <h5>{l s='User unknown. Please update your API keys or contact support@spreadfamily.com'}</h5>
            </div>
        </div>
    {/if}
{else}
    <div id="SpreadAdminHeader"></div>
    <div id="SpreadAdminContent">
        <div class="legend">
            <h5>{l s='An error occurred. Please contact support@spreadfamily.com'}</h5>
        </div>
    </div>
{/if}