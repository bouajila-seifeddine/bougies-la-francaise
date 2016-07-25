{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Block Newsletter module-->
<div class="newsletter">
    <h3>{l s='Newsletter subscription' mod='blocknewsletter'}</h3>
    <p class="subscribe">{l s='Subscribe to our newsletter to receive news from Bougie la française' mod='blocknewsletter'}</p>
    {if isset($msg) && $msg}
        <p class="{if $nw_error}warning_inline{else}success_inline{/if}">{$msg}</p>
    {/if}
    <form action="#" method="post">
        <input class="inputNew" id="newsletter-input" type="text" name="email" size="18" value="{if isset($value) && $value}{$value}{else}{l s='your e-mail' mod='blocknewsletter'}{/if}" />
        <input type="submit" value="{l s='Send' mod='blocknewsletter'}" class="button_mini" name="submitNewsletter" />
        <input type="hidden" name="action" value="0" />
    </form>
</div>
<!-- /Block Newsletter module-->

<script type="text/javascript">
    var placeholder = "{l s='your e-mail' mod='blocknewsletter' js=1}";
        $(document).ready(function() {ldelim}
            $('#newsletter-input').on({ldelim}
                focus: function() {ldelim}
                    if ($(this).val() == placeholder) {ldelim}
                        $(this).val('');
                    {rdelim}
                {rdelim},
                blur: function() {ldelim}
                    if ($(this).val() == '') {ldelim}
                        $(this).val(placeholder);
                    {rdelim}
                {rdelim}
            {rdelim});

            {if isset($msg)}
                $('#columns').before('<div class="clearfix"></div><p class="{if $nw_error}warning{else}success{/if}">{l s="Newsletter:" js=1 mod="blocknewsletter"} {$msg}</p>');
            {/if}
        });
</script>
