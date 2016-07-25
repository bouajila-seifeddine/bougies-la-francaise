{*
 * Systempay payment module 1.2f (revision 61545)
 *
 * Compatible with V2 payment platform. Developped for Prestashop 1.5.0.x.
 * Support contact: supportvad@lyra-network.com.
 * 
 * Copyright (C) 2014 Lyra Network (http://www.lyra-network.com/) and contributors
 * 
 * 
 * NOTICE OF LICENSE
 *
 * This source file is licensed under the Open Software License version 3.0
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
*}

<div class="payment_module systempay_payment_module">
	<a onclick="javascript: $('#systempay_oney').submit();" title="{l s='Click here to pay with FacilyPay Oney' mod='systempay'}">
		<img class="logo" src="{$base_dir_ssl}modules/systempay/views/images/BannerLogo3.png" alt="Systempay"/>{$systempay_oney_title}
		
		<form action="{$link->getModuleLink('systempay', 'redirect', array(), true)}" method="POST" name="systempay_oney" id="systempay_oney" class="systempay_payment_form">
			<input type="hidden" name="systempay_payment_type" value="oney" />
		</form>
	</a>
</div>