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

<!-- Block user information module HEADER -->
<ul id="menu-account" {if $PS_CATALOG_MODE}class="header_user_catalog"{/if}>
    {if !$PS_CATALOG_MODE}
    <li id="shopping_cart">
        <a href="{$link->getPageLink($order_process, true)|escape:'html'}" rel="nofollow">{l s='Cart' mod='blockuserinfo'}
        <span class="ajax_cart_quantity{if $cart_qties == 0} hidden{/if}">{$cart_qties}</span>
        <span class="ajax_cart_product_txt{if $cart_qties != 1} hidden{/if}">{l s='Product' mod='blockuserinfo'}</span>
        <span class="ajax_cart_product_txt_s{if $cart_qties < 2} hidden{/if}">{l s='Products' mod='blockuserinfo'}</span>
        <span class="ajax_cart_total{if $cart_qties == 0} hidden{/if}">
            {if $cart_qties > 0}
                {if $priceDisplay == 1}
                    {assign var='blockuser_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
                    {convertPrice price=$cart->getOrderTotal(false, $blockuser_cart_flag)}
                {else}
                    {assign var='blockuser_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
                    {convertPrice price=$cart->getOrderTotal(true, $blockuser_cart_flag)}
                {/if}
            {/if}
        </span>
        <span class="ajax_cart_no_product{if $cart_qties > 0} hidden{/if}">{l s='(empty)' mod='blockuserinfo'}</span>
        </a>
    </li>
    {/if}
    <li id="user-info">
        {if $logged}
            <a href="{$link->getPageLink('my-account', true)|escape:'html'}" class="account" rel="nofollow"><span>{l s='My account' mod='blockuserinfo'}</span></a>
            <span class="separator">/</span>
            <a href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html'}" class="logout" rel="nofollow">{l s='Log out' mod='blockuserinfo'}</a>
            <span class="separator">/</span>
            <a href="{$link->getModuleLink('favoriteproducts', 'account')|escape:'html':'UTF-8'}">
                {l s='favorite' mod='blockuserinfo'}
            </a>
        {else}
            <a href="{$link->getPageLink('my-account', true)|escape:'html'}" class="login" rel="nofollow">{l s='Login' mod='blockuserinfo'}</a>
        {/if}
            <span class="separator">/</span>
    </li>
</ul>

<a id="link-shop" href="{$link->getPageLink('stores')|escape:'html'}">{l s='Find a shop' mod='blockuserinfo'}</a>

<a id="link-newsletter" href="{$link->getCMSLink(19)|escape:'html'}">{l s='Subscribe to newsletter' mod='blockuserinfo'}</a>

<!-- /Block user information module HEADER -->
