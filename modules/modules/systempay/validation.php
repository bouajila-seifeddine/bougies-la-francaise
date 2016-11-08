<?php 
/**
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
*/

/**
 * Instant payment notification file. Wait for Systempay payment confirmation, then validate order.
 */

require_once dirname(dirname(dirname(__FILE__))) . '/config/config.inc.php';
require_once dirname(dirname(dirname(__FILE__))) . '/init.php';

require_once(dirname(__FILE__) . '/systempay.php');

if (($cartId = Tools::getValue('vads_order_id')) && ($hash = Tools::getValue('vads_hash'))) {
	// Module main class
	$module = new Systempay();

	$module->logger->logInfo("Server call process starts for cart #$cartId.");
	
	$cart = new Cart($cartId);
	
	// Cart errors
	if (!Validate::isLoadedObject($cart)) {
		$module->logger->logError("Cart #$cartId not found in database.");
		die('<span style="display:none">KO-' . Tools::getValue('vads_trans_id') . "=Impossible de retrouver la commande\n</span>");
	} elseif($cart->nbProducts() <= 0) {
		$module->logger->logError("Cart #$cartId was emptied before redirection.");
		die('<span style="display:none">KO-' . Tools::getValue('vads_trans_id') . "=Le panier a été vidé avant la redirection\n</span>");
	}
	
	// Reload shop context
	if(Shop::isFeatureActive()) {
		Shop::setContext(Shop::CONTEXT_SHOP, (int)$cart->id_shop);
	}
	
	// Reload language context
	Context::getContext()->language = new Language((int)$cart->id_lang);
	
	/** @var SystempayResponse $systempayResponse */
	$systempayResponse = new SystempayResponse(
			$_POST,
			Configuration::get('SYSTEMPAY_MODE'),
			Configuration::get('SYSTEMPAY_KEY_TEST'),
			Configuration::get('SYSTEMPAY_KEY_PROD')
	);
	
	// Check the authenticity of the request
	if (!$systempayResponse->isAuthentified()) {
		$module->logger->logError("Cart #$cartId : authentication error !");
		die($systempayResponse->getOutputForGateway('auth_fail'));
	}
	
	// Search order in db
	$orderId = Order::getOrderByCartId($cart->id);

	if ($orderId == false) {
		// order has not been processed yet
		
		if ($systempayResponse->isAcceptedPayment()) {
			$newState = $module->isOneyPendingPayment($systempayResponse) /* Oney payments */ ? 
						Configuration::get('SYSTEMPAY_OS_ONEY_PENDING') : 
						Configuration::get('PS_OS_PAYMENT');
			
			$module->logger->logInfo("Payment accepted for cart #$cartId. New order status is $newState.");
			
			$order = $module->saveOrder($cart, $newState, $systempayResponse);
			
			// response to server
			die ($systempayResponse->getOutputForGateway('payment_ok'));
		} else {
			// payment KO
			$module->logger->logInfo("Payment failed for cart #$cartId.");
			
			if(Configuration::get('SYSTEMPAY_FAILURE_MANAGEMENT') == Systempay::ON_FAILURE_SAVE || $module->isOney($systempayResponse)) {
				// save on failure option is selected or oney payment
				$newState = $systempayResponse->isCancelledPayment() ? Configuration::get('PS_OS_CANCELED') : Configuration::get('PS_OS_ERROR');
				
				$msg = $module->isOney($systempayResponse) ? 'FacilyPay Oney payment' : 'Save on failure option is selected';
				
				$module->logger->logInfo("$msg : save failed order for cart #$cartId. New order status is $newState.");
				$order = $module->saveOrder($cart, $newState, $systempayResponse);
			} 
			die($systempayResponse->getOutputForGateway('payment_ko'));
		}
	} else {
		// order already registered
		$module->logger->logInfo("Order already registered for cart #$cartId.");
		
		$order = new Order((int)$orderId);
		$oldState = $order->getCurrentState();
		
		switch ($oldState) {
			case Configuration::get('PS_OS_ERROR'):
			case Configuration::get('PS_OS_CANCELED'):
			
				$module->logger->logInfo("Save on failure option is selected or FacilyPay Oney payment. Order for cart #$cartId is in a failed status.");
			
				if($systempayResponse->isAcceptedPayment()) {
					// order saved with failed status while payment is successful
					$module->logger->logWarning("Payment success received from platform while order is in a failed status for cart #$cartId.");
					$msg = 'payment_ko_on_order_ok';
				} else {
					// just display a failure confirmation message
					$module->logger->logInfo("Payment failure confirmed for cart #$cartId.");
					$msg = 'payment_ko_already_done';
				}
			
				die($systempayResponse->getOutputForGateway($msg));
				break;
				
			case Configuration::get('SYSTEMPAY_OS_ONEY_PENDING'):
			case (($oldState == Configuration::get('PS_OS_OUTOFSTOCK')) && $module->isOney($systempayResponse)):
				
				$module->logger->logInfo("Order for cart #$cartId is saved but waiting FacilyPay Oney confirmation. Update order status according to payment result.");
			
				if ($systempayResponse->isPendingPayment()) {
					$module->logger->logInfo("No changes for cart #$cartId status, payment remain pending confirmation.");
					$msg = 'payment_ok_already_done';
				} elseif ($systempayResponse->isAcceptedPayment()) {
					$newState = $oldState == Configuration::get('SYSTEMPAY_OS_ONEY_PENDING') ? Configuration::get('PS_OS_PAYMENT') : Configuration::get('SYSTEMPAY_OS_PAYMENT_OUTOFSTOCK');
					$module->setOrderState($order, $newState, $systempayResponse);
					$msg = 'payment_ok';
				} else {
					// order is pending, payment failed : update order status
					$newState = $systempayResponse->isCancelledPayment() ? Configuration::get('PS_OS_CANCELED') : Configuration::get('PS_OS_ERROR');
					$module->setOrderState($order, $newState, $systempayResponse);
					$msg = 'payment_ko';
				}
			
				die($systempayResponse->getOutputForGateway($msg));
				break;
			
			case Configuration::get('PS_OS_PAYMENT'):
			case Configuration::get('SYSTEMPAY_OS_PAYMENT_OUTOFSTOCK'):
			case (($oldState == Configuration::get('PS_OS_OUTOFSTOCK')) && !$module->isOney($systempayResponse)):

				if($systempayResponse->isAcceptedPayment()) {
					// just display a confirmation message
					$module->logger->logInfo("Payment success confirmed for cart #$cartId.");
					$msg = 'payment_ok_already_done';
				} else {
					// order saved with success status while payment failed
					$module->logger->logWarning("Payment failure received from platform while order is in a success status for cart #$cartId.");
					$msg = 'payment_ko_on_order_ok';
				}
				
				die($systempayResponse->getOutputForGateway($msg));
				break;
				
			default:
				$module->logger->logInfo("Unknown order status for cart #$cartId. Managed by merchant.");
				
				die($systempayResponse->getOutputForGateway('ok', 'Statut de commande inconnu'));
				break;
		}
	}
}