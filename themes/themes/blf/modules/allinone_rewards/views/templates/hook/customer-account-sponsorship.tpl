<!-- MODULE allinone_rewards -->
{if $version16}
<li><a href="{$link->getModuleLink('allinone_rewards', 'sponsorship', [], true)}" title="{l s='Sponsorship program' mod='allinone_rewards'}"><i class="icon-group"></i><span>{l s='Sponsorship program' mod='allinone_rewards'}</span></a></li>
{else}
<li>
    <a href="{$link->getModuleLink('allinone_rewards', 'sponsorship', [], true)}" title="{l s='Sponsorship program' mod='allinone_rewards'}">
        <img src="{$img_dir}icon/sponsorship.png" alt="{l s='Sponsorship program' mod='allinone_rewards'}" class="icon" />
        <span>{l s='Sponsorship program' mod='allinone_rewards'}</span>
    </a>
{/if}
<!-- END : MODULE allinone_rewards -->