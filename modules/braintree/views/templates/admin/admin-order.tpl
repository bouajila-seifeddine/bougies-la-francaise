{*
* 2007-2015 PrestaShop
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
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div style="background-color: #fff; border: 1px solid #e6e6e6; border-radius: 5px; box-shadow: 0 2px 0 rgba(0, 0, 0, 0.1), 0 0 0 3px #fff inset; margin-bottom: 20px; padding: 20px;">
	<form method="post" action="">
		<h3><i class="icon-credit-card"></i> {l s='Process BrainTree Refund' mod="braintree"}</h3>
		<input type="text" class="form-control" name="amount" value="{$total_paid|escape:'htmlall':'UTF-8'}">
		<input type="hidden" class="form-control" name="id_transaction" value="{$id_transaction|escape:'htmlall':'UTF-8'}">
		<input type="hidden" class="form-control" name="status" value="{$status|escape:'htmlall':'UTF-8'}">
		<input type="hidden" class="form-control" name="id_braintree_transaction" value="{$id_braintree_transaction|escape:'htmlall':'UTF-8'}">
		<input type="submit" name="braintree_refund" value="{l s='Process Refund' mod='braintree'}" class="btn btn-primary">
	</form>
</div>