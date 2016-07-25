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

{capture name=path}{l s='My account'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h1>{l s='My account'}</h1>
{if isset($account_created)}
	<p class="success">
		{l s='Your account has been created.'}
	</p>
{/if}
<p class="title_block">{l s='Welcome to your account. Here you can manage al of your personal information and orders. '}</p>
<ul class="myaccount_lnk_list">
	{if $has_customer_an_address}
	<li><a href="{$link->getPageLink('address', true)|escape:'html'}"><img src="{$img_dir}icon/addrbook.png" alt="{l s='Add my first address'}" class="icon" /><span>{l s='Add my first address'}</span></a></li>
	{/if}
	<li><a href="{$link->getPageLink('history', true)|escape:'html'}"><img src="{$img_dir}icon/order.png" alt="{l s='Orders'}" class="icon" /><span>{l s='Order history and details '}</span></a></li>
	{if $returnAllowed}
		<li><a href="{$link->getPageLink('order-follow', true)|escape:'html'}"><img src="{$img_dir}icon/return.png" alt="{l s='Merchandise returns'}" class="icon" /><span>{l s='My merchandise returns'}</span></a></li>
	{/if}
	<li><a href="{$link->getPageLink('order-slip', true)|escape:'html'}"><img src="{$img_dir}icon/slip.png" alt="{l s='Credit slips'}" class="icon" /><span>{l s='My credit slips'}</span></a></li>
	<li><a href="{$link->getPageLink('addresses', true)|escape:'html'}"><img src="{$img_dir}icon/addrbook.png" alt="{l s='Addresses'}" class="icon" /><span>{l s='My addresses'}</span></a></li>
	<li><a href="{$link->getPageLink('identity', true)|escape:'html'}"><img src="{$img_dir}icon/userinfo.png" alt="{l s='Information'}" class="icon" /><span>{l s='My personal information'}</span></a></li>
	{if $voucherAllowed}
		<li><a href="{$link->getPageLink('discount', true)|escape:'html'}"><img src="{$img_dir}icon/voucher.png" alt="{l s='Vouchers'}" class="icon" /><span>{l s='My vouchers'}</span></a></li>
	{/if}
	{$HOOK_CUSTOMER_ACCOUNT}
</ul>
