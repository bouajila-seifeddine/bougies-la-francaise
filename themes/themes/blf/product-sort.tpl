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

{if isset($orderby) AND isset($orderway)}

{* On 1.5 the var request is setted on the front controller. The next lines assure the retrocompatibility with some modules *}
{if !isset($request)}
	<!-- Sort products -->
	{if isset($smarty.get.id_category) && $smarty.get.id_category}
		{assign var='request' value=$link->getPaginationLink('category', $category, false, true)}
	{elseif isset($smarty.get.id_manufacturer) && $smarty.get.id_manufacturer}
		{assign var='request' value=$link->getPaginationLink('manufacturer', $manufacturer, false, true)}
	{elseif isset($smarty.get.id_supplier) && $smarty.get.id_supplier}
		{assign var='request' value=$link->getPaginationLink('supplier', $supplier, false, true)}
	{else}
		{assign var='request' value=$link->getPaginationLink(false, false, false, true)}
	{/if}
{/if}

{if isset($smarty.get.id_category_search)}
    {assign var='requestSort' value=$link->getCategoryLink($smarty.get.id_category_search)}
{else if isset($smarty.get.id_category)}
    {assign var='requestSort' value=$link->getCategoryLink($smarty.get.id_category)}
{else if strpos($request, "search_query") != false}
    {assign var='requestSort' value=$request}
{else}
    {assign var='requestSort' value=$request}
{/if}

{if strpos($requestSort, "?")==false}
    {assign var='operator' value='?'}
{else}
    {assign var='operator' value='&'}
{/if}

<ul class="productsSortForm">
    <li{if $orderby eq 'date_add' AND $orderway eq 'desc'} class="active"{/if}><a href="{$requestSort|escape:'htmlall':'UTF-8'}{$operator}orderby=date_add&orderway=desc">{l s='News'}</a></li>
    <li{if $orderby eq 'price' AND $orderway eq 'asc'} class="active"{/if}><a href="{$requestSort|escape:'htmlall':'UTF-8'}{$operator}orderby=price&orderway=asc">{l s='Decreasing prices'}</a></li>
    <li{if $orderby eq 'price' AND $orderway eq 'desc'} class="active"{/if}><a href="{$requestSort|escape:'htmlall':'UTF-8'}{$operator}orderby=price&orderway=desc">{l s='Increasing prices'}</a></li>
</ul>
<!-- /Sort products -->
{/if}
