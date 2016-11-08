<!-- MODULE allinone_rewards -->
{if $version16}
<li><a href="{$link->getModuleLink('allinone_rewards', 'rewards', [], true)}" title="{l s='My rewards account' mod='allinone_rewards'}"><i class="icon-usd"></i><span>{l s='My rewards account' mod='allinone_rewards'}</span></a></li>
{else}
<li>
    <a href="{$link->getModuleLink('allinone_rewards', 'rewards', [], true)}" title="{l s='My rewards account' mod='allinone_rewards'}">
        <img src="{$img_dir}icon/voucher.png" alt="{l s='My rewards account' mod='allinone_rewards'}" class="icon" />
        <span>{l s='My rewards account' mod='allinone_rewards'}</span>
    </a> 
{/if}
<!-- END : MODULE allinone_rewards -->