<?php
/*
 * @module    All-in-one Rewards
 * @copyright  Copyright (c) 2012 Yann BONNAILLIE (http://www.prestaplugins.com)
 * @author     Yann BONNAILLIE
 * @license    Commercial license
 * Support by mail  : contact@prestaplugins.com
 * Support on forum : Patanock
 * Support on Skype : Patanock13
 */

class Allinone_rewardsRewardsModuleFrontController extends ModuleFrontController
{
	public function init()
	{
		if (!$this->context->customer->isLogged())
			Tools::redirect('index.php?controller=authentication');
		parent::init();
	}

	public function initContent()
	{
		parent::initContent();

		// récupère le nombre de crédits convertibles
		$totals = RewardsModel::getAllTotalsByCustomer((int)$this->context->customer->id);
		$totalGlobal = isset($totals['total']) ? (float)$totals['total'] : 0;
		$totalConverted = isset($totals[RewardsStateModel::getConvertId()]) ? (float)$totals[RewardsStateModel::getConvertId()] : 0;
		$totalAvailable = isset($totals[RewardsStateModel::getValidationId()]) ? (float)$totals[RewardsStateModel::getValidationId()] : 0;
		$totalPending = (isset($totals[RewardsStateModel::getDefaultId()]) ? (float)$totals[RewardsStateModel::getDefaultId()] : 0) + (isset($totals[RewardsStateModel::getReturnPeriodId()]) ? $totals[RewardsStateModel::getReturnPeriodId()] : 0);
		$totalWaitingPayment = isset($totals[RewardsStateModel::getWaitingPaymentId()]) ? (float)$totals[RewardsStateModel::getWaitingPaymentId()] : 0;
		$totalPaid = isset($totals[RewardsStateModel::getPaidId()]) ? (float)$totals[RewardsStateModel::getPaidId()] : 0;
		$totalForPaymentDefaultCurrency = round($totalAvailable * Configuration::get('REWARDS_PAYMENT_RATIO') / 100, 2);

		$currency = Currency::getCurrency((int)$this->context->currency->id);
		$totalAvailableUserCurrency = Tools::convertPrice($totalAvailable, $currency);
		$voucherMininum = (float)Configuration::get('REWARDS_VOUCHER_MIN_VALUE_'.(int)$this->context->currency->id) > 0 ? (float)Configuration::get('REWARDS_VOUCHER_MIN_VALUE_'.(int)$this->context->currency->id) : 0;
		$paymentMininum = (float)Configuration::get('REWARDS_PAYMENT_MIN_VALUE_'.(int)$this->context->currency->id) > 0 ? (float)Configuration::get('REWARDS_PAYMENT_MIN_VALUE_'.(int)$this->context->currency->id) : 0;

		$voucherAllowed = Configuration::get('REWARDS_VOUCHER') && RewardsModel::isCustomerAllowed((int)$this->context->customer->id, Configuration::get('REWARDS_VOUCHER_GROUPS'));
		$paymentAllowed = Configuration::get('REWARDS_PAYMENT') && RewardsModel::isCustomerAllowed((int)$this->context->customer->id, Configuration::get('REWARDS_PAYMENT_GROUPS'));

		/* transform credits into voucher if needed */
		if ($voucherAllowed && Tools::getValue('transform-credits') == 'true' && $totalAvailableUserCurrency >= $voucherMininum)
		{
			RewardsModel::createDiscount($totalAvailable);
			//Tools::redirect($this->context->link->getModuleLink('allinone_rewards', 'rewards', array(), true));
			Tools::redirect($this->context->link->getPageLink('discount', true));
		}

		if ($paymentAllowed && Tools::isSubmit('submitPayment') && $totalAvailableUserCurrency >= $paymentMininum && $totalForPaymentDefaultCurrency > 0) {
			if (Tools::getValue('payment_details') && (!Configuration::get('REWARDS_PAYMENT_INVOICE') || (isset($_FILES['payment_invoice']['name']) && !empty($_FILES['payment_invoice']['tmp_name'])))) {
				if (RewardsPaymentModel::askForPayment($totalForPaymentDefaultCurrency, Tools::getValue('payment_details'), $_FILES['payment_invoice']))
					Tools::redirect($this->context->link->getModuleLink('allinone_rewards', 'rewards', array(), true));
				else
					$this->context->smarty->assign('payment_error', 2);
			} else
				$this->context->smarty->assign('payment_error', 1);
		}

		$link = $this->context->link->getModuleLink('allinone_rewards', 'rewards', array(), true);
		$rewards = RewardsModel::getAllByIdCustomer((int)$this->context->customer->id);
		$displayrewards = RewardsModel::getAllByIdCustomer((int)$this->context->customer->id, false, false, true, ((int)(Tools::getValue('n')) > 0 ? (int)(Tools::getValue('n')) : 10), ((int)(Tools::getValue('p')) > 0 ? (int)(Tools::getValue('p')) : 1), $this->context->currency->id);

		$this->context->smarty->assign(array(
			'return_days' => (Configuration::get('REWARDS_WAIT_RETURN_PERIOD') && Configuration::get('PS_ORDER_RETURN') && (int)Configuration::get('PS_ORDER_RETURN_NB_DAYS') > 0) ? (int)Configuration::get('PS_ORDER_RETURN_NB_DAYS') : 0,
			'rewards' => $rewards,
			'displayrewards' => $displayrewards,
			'pagination_link' => $link . (strpos($link, '?') !== false ? '&' : '?'),
			'totalGlobal' => round(Tools::convertPrice($totalGlobal, $currency), 2),
			'totalConverted' => round(Tools::convertPrice($totalConverted, $currency), 2),
			'totalAvailable' => round(Tools::convertPrice($totalAvailable, $currency), 2),
			'totalPending' => round(Tools::convertPrice($totalPending, $currency), 2),
			'totalWaitingPayment' => round(Tools::convertPrice($totalWaitingPayment, $currency), 2),
			'totalPaid' => round(Tools::convertPrice($totalPaid, $currency), 2),
			'totalForPaymentDefaultCurrency' => $totalForPaymentDefaultCurrency,
			'payment_currency' => Configuration::get('PS_CURRENCY_DEFAULT'),
			'voucher_min' => $voucherAllowed ? $voucherMininum : 0,
			'voucher_allowed' => $voucherAllowed,
			'voucher_button_allowed' => $voucherAllowed && $totalAvailableUserCurrency >= $voucherMininum && $totalAvailableUserCurrency > 0,
			'payment_min' => $paymentAllowed ? $paymentMininum : 0,
			'payment_allowed' => $paymentAllowed,
			'payment_button_allowed' => $paymentAllowed && $totalAvailableUserCurrency >= $paymentMininum && $totalForPaymentDefaultCurrency > 0,
			'payment_txt' => Configuration::get('REWARDS_PAYMENT_TXT', (int)$this->context->language->id),
			'general_txt' => Configuration::get('REWARDS_GENERAL_TXT', (int)$this->context->language->id),
			'payment_invoice' => (int)Configuration::get('REWARDS_PAYMENT_INVOICE'),
			'page' => ((int)(Tools::getValue('p')) > 0 ? (int)(Tools::getValue('p')) : 1),
			'nbpagination' => ((int)(Tools::getValue('n') > 0) ? (int)(Tools::getValue('n')) : 10),
			'nArray' => array(10, 20, 50),
			'max_page' => floor(sizeof($rewards) / ((int)(Tools::getValue('n') > 0) ? (int)(Tools::getValue('n')) : 10)),
			'version16' => version_compare(_PS_VERSION_, '1.6', '>=')
		));
		$this->setTemplate('rewards.tpl');
	}
}