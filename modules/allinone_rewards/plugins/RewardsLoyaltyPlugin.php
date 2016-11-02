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

if (!defined('_PS_VERSION_'))
	exit;

require_once(_PS_MODULE_DIR_.'/allinone_rewards/plugins/RewardsGenericPlugin.php');

class RewardsLoyaltyPlugin extends RewardsGenericPlugin
{
	public $name = 'loyalty';

	public function install()
	{
		// hooks
		if (!$this->registerHook('displayRightColumnProduct') || !$this->registerHook('displayShoppingCartFooter')
		|| !$this->registerHook('actionValidateOrder') || !$this->registerHook('actionOrderStatusUpdate')
		|| !$this->registerHook('actionProductCancel') || !$this->registerHook('actionOrderReturn')
		|| !$this->registerHook('displayAdminOrder'))
			return false;

		$groups_config = '';
		$groups = Group::getGroups((int)(Configuration::get('PS_LANG_DEFAULT')));
		foreach ($groups AS $group)
			$groups_config .= (int)$group['id_group'].',';
		$groups_config = rtrim($groups_config, ',');

		$category_config = '';
		$categories = Category::getSimpleCategories((int)(Configuration::get('PS_LANG_DEFAULT')));
		foreach ($categories AS $category)
			$category_config .= (int)$category['id_category'].',';
		$category_config = rtrim($category_config, ',');

		if (!Configuration::updateValue('RLOYALTY_POINT_VALUE', 0.50)
		|| !Configuration::updateValue('RLOYALTY_POINT_RATE', 10)
		|| !Configuration::updateValue('RLOYALTY_DISCOUNTED_ALLOWED', 1)
		|| !Configuration::updateValue('RLOYALTY_ACTIVE', 0)
		|| !Configuration::updateValue('RLOYALTY_MAIL_VALIDATION', 1)
		|| !Configuration::updateValue('RLOYALTY_MAIL_CANCELPROD', 1)
		|| !Configuration::updateValue('RLOYALTY_GROUPS', $groups_config)
		|| !Configuration::updateValue('RLOYALTY_CATEGORIES', $category_config))
			return false;

		return true;
	}

	public function uninstall()
	{
		Db::getInstance()->Execute('
			DELETE FROM `'._DB_PREFIX_.'configuration_lang`
			WHERE `id_configuration` IN (SELECT `id_configuration` from `'._DB_PREFIX_.'configuration` WHERE `name` like \'RLOYALTY_%\')');

		Db::getInstance()->Execute('
			DELETE FROM `'._DB_PREFIX_.'configuration`
			WHERE `name` like \'RLOYALTY_%\'');

		return true;
	}

	public function isActive() {
		return Configuration::get('RLOYALTY_ACTIVE');
	}

	public function getTitle() {
		return $this->l('Loyalty program');
	}

	public function getDetails($reward, $admin) {
		if ($admin)
			return $this->l('Order');
		else
			return $this->l('Order #') . sprintf('%06d', $reward['id_order']);
	}

	public function postProcess()
	{
		if (Tools::isSubmit('submitLoyalty')) {
			$this->_postValidation();
			if (!sizeof($this->_errors)) {
				Configuration::updateValue('RLOYALTY_ACTIVE', (int)Tools::getValue('loyalty_active'));
				Configuration::updateValue('RLOYALTY_POINT_VALUE', (float)Tools::getValue('point_value'));
				Configuration::updateValue('RLOYALTY_POINT_RATE', (float)Tools::getValue('point_rate'));
				Configuration::updateValue('RLOYALTY_DISCOUNTED_ALLOWED', (int)Tools::getValue('rloyalty_discounted_allowed'));
				Configuration::updateValue('RLOYALTY_GROUPS', implode(",", Tools::getValue('rloyalty_groups')));
				Configuration::updateValue('RLOYALTY_CATEGORIES', implode(",", Tools::getValue('rloyalty_categories')));
				$this->instance->confirmation = $this->instance->displayConfirmation($this->l('Settings updated.'));
			} else
				$this->instance->errors = $this->instance->displayError(implode('<br />', $this->_errors));
		} else if (Tools::isSubmit('submitLoyaltyNotifications')) {
			Configuration::updateValue('RLOYALTY_MAIL_VALIDATION', (int)Tools::getValue('mail_validation'));
			Configuration::updateValue('RLOYALTY_MAIL_CANCELPROD', (int)Tools::getValue('mail_cancel_product'));
			$this->instance->confirmation = $this->instance->displayConfirmation($this->l('Settings updated.'));
		}
	}

	private function _postValidation()
	{
		$this->_errors = array();
		if (!is_array(Tools::getValue('rloyalty_groups')))
			$this->_errors[] = $this->l('Please select at least 1 customer group allowed to get loyalty rewards');
		if (!is_numeric(Tools::getValue('point_rate')) || Tools::getValue('point_rate') <= 0)
			$this->_errors[] = $this->l('The ratio is required/invalid.');
		if (!is_numeric(Tools::getValue('point_value')) || Tools::getValue('point_value') <= 0)
			$this->_errors[] = $this->l('The value is required/invalid.');
		if (!is_array(Tools::getValue('rloyalty_categories')) || !sizeof(Tools::getValue('rloyalty_categories')))
			$this->_errors[] = $this->l('You must choose at least one category of products');
	}

	public function getContent()
	{
		$this->postProcess();

		$currency = new Currency((int)Configuration::get('PS_CURRENCY_DEFAULT'));
		$groups = Group::getGroups((int)$this->context->language->id);
		$allowed_groups = explode(',', Configuration::get('RLOYALTY_GROUPS'));
		$categories = $this->instance->getCategories();

		$html = '
		<div class="tabs" style="display: none">
			<ul>
				<li><a href="#tabs-'.$this->name.'-1">'.$this->l('Settings').'</a></li>
				<li><a href="#tabs-'.$this->name.'-2">'.$this->l('Notifications').'</a></li>
			</ul>
			<div id="tabs-'.$this->name.'-1">
				<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
					<input type="hidden" name="plugin" id="plugin" value="' . $this->name . '" />
					<fieldset>
						<legend>'.$this->l('General settings').'</legend>
						<label>'.$this->l('Activate loyalty program').'</label>
						<div class="margin-form">
							<label class="t" for="loyalty_active_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="loyalty_active_on" name="loyalty_active" value="1" '.(Tools::getValue('loyalty_active', Configuration::get('RLOYALTY_ACTIVE')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="loyalty_active_on">' . $this->l('Yes') . '</label>
							<label class="t" for="loyalty_active_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="loyalty_active_off" name="loyalty_active" value="0" '.(Tools::getValue('loyalty_active', Configuration::get('RLOYALTY_ACTIVE')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="loyalty_active_off">' . $this->l('No') . '</label>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Customers groups allowed to get loyalty rewards').'</label>
						<div class="margin-form">
							<select name="rloyalty_groups[]" multiple="multiple" class="multiselect">';
		foreach($groups as $group) {
			$html .= '<option '.(is_array($allowed_groups) && in_array($group['id_group'], $allowed_groups) ? 'selected':'').' value="'.$group['id_group'].'"> '.$group['name'].'</option>';
		}
		$html .= '
							</select>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('For every').'</label>
						<div class="margin-form">
							<input type="text" size="3" id="point_rate" name="point_rate" value="'.Tools::getValue('point_rate', (float)Configuration::get('RLOYALTY_POINT_RATE')).'" /> <label class="t">'.$currency->sign.' '.$this->l('spent on the shop').'</label>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Customer gets').'</label>
						<div class="margin-form">
							<input type="text" size="3" name="point_value" id="point_value" value="'.Tools::getValue('point_value', (float)Configuration::get('RLOYALTY_POINT_VALUE')).'" /> <label class="t">'.$currency->sign.'</label>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Give rewards on discounted products').' </label>
						<div class="margin-form">
							<label class="t" for="rloyalty_discounted_allowed_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
							<input type="radio" id="rloyalty_discounted_allowed_on" name="rloyalty_discounted_allowed" value="1" '.(Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED') ? 'checked="checked" ' : '').'/> <label class="t" for="rloyalty_discounted_allowed_on">' . $this->l('Yes') . '</label>
							<label class="t" for="rloyalty_discounted_allowed_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
							<input type="radio" id="rloyalty_discounted_allowed_off" name="rloyalty_discounted_allowed" value="0" '.(!Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED') ? 'checked="checked" ' : '').'/> <label class="t" for="rloyalty_discounted_allowed_off">' . $this->l('No') . '</label>
						</div>
						<div class="clear"></div>
						<label>'.$this->l('Categories of products allowing to get loyalty rewards').'</label>
						<div class="margin-form">
							<table cellspacing="0" cellpadding="0" class="table">
								<tr>
									<th><input type="checkbox" name="checkme" class="noborder" onclick="checkDelBoxes(this.form, \'rloyalty_categories[]\', this.checked)" /></th>
									<th>'.$this->l('ID').'</th>
									<th style="width: 400px">'.$this->l('Name').'</th>
								</tr>';
		$index =  isset($_POST['rloyalty_categories']) ? $_POST['rloyalty_categories'] : explode(',', Configuration::get('RLOYALTY_CATEGORIES'));
		$current = current(current($categories));
		$html .= $this->instance->recurseCategoryForInclude('rloyalty_categories', $index, $categories, $current, $current['infos']['id_category']);
		$html .= '
							</table>
						</div>
					</fieldset>
					<div class="clear center"><input type="submit" name="submitLoyalty" id="submitLoyalty" value="'.$this->l('Save settings').'" class="button" /></div>
				</form>
			</div>
			<div id="tabs-'.$this->name.'-2">
				<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
				<input type="hidden" name="plugin" id="plugin" value="' . $this->name . '" />
				<input type="hidden" name="tabs-'.$this->name.'" value="tabs-'.$this->name.'-2" />
				<fieldset>
					<legend>'.$this->l('Notifications').'</legend>
					<label>'.$this->l('Send a mail to the customer on reward validation/cancellation').'</label>
					<div class="margin-form">
						<label class="t" for="mail_validation_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
						<input type="radio" id="mail_validation_on" name="mail_validation" value="1" '.(Tools::getValue('mail_validation', Configuration::get('RLOYALTY_MAIL_VALIDATION')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="mail_validation_on">' . $this->l('Yes') . '</label>
						<label class="t" for="mail_validation_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
						<input type="radio" id="mail_validation_off" name="mail_validation" value="0" '.(Tools::getValue('mail_validation', Configuration::get('RLOYALTY_MAIL_VALIDATION')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="mail_validation_off">' . $this->l('No') . '</label>
					</div>
					<div class="clear"></div>
					<label>'.$this->l('Send a mail to the customer on reward modification (product canceled)').'</label>
					<div class="margin-form">
						<label class="t" for="mail_cancel_product_on"><img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Yes').'" /></label>
						<input type="radio" id="mail_cancel_product_on" name="mail_cancel_product" value="1" '.(Tools::getValue('mail_cancel_product', Configuration::get('RLOYALTY_MAIL_CANCELPROD')) == 1 ? 'checked="checked"' : '').' /> <label class="t" for="mail_cancel_product_on">' . $this->l('Yes') . '</label>
						<label class="t" for="mail_cancel_product_off" style="margin-left: 10px"><img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('No').'" /></label>
						<input type="radio" id="mail_cancel_product_off" name="mail_cancel_product" value="0" '.(Tools::getValue('mail_cancel_product', Configuration::get('RLOYALTY_MAIL_CANCELPROD')) == 0 ? 'checked="checked"' : '').' /> <label class="t" for="mail_cancel_product_off">' . $this->l('No') . '</label>
					</div>
				</fieldset>
				<div class="clear center"><input class="button" name="submitLoyaltyNotifications" id="submitLoyaltyNotifications" value="'.$this->l('Save settings').'" type="submit" /></div>
				</form>
			</div>
		</div>';

		return $html;
	}

	// check if customer is in a group which is allowed to get loyalty rewards
	// if bCheckDefault is true, then return true if the default group is checked (to know if we display the rewards for people not logged in)
	private function _isCustomerAllowed($customer, $bCheckDefault=false) {
		$allowed_groups = explode(',', Configuration::get('RLOYALTY_GROUPS'));
		if (Validate::isLoadedObject($customer)) {
			$customer_groups = $customer->getGroups();
			return sizeof(array_intersect($allowed_groups, $customer_groups)) > 0;
		} else if ($bCheckDefault && in_array(1, $allowed_groups)) {
			return true;
		}
	}

	// convert the string into an array of object(array) which have id_category as key
	private function _getAllowedCategories() {
		$allowed_categories = array();
		$categories = explode(',', Configuration::get('RLOYALTY_CATEGORIES'));
		foreach($categories as $category) {
			$allowed_categories[] = array('id_category' => $category);
		}
		return $allowed_categories;
	}

	// check if the product is in a category which is allowed to give loyalty rewards
	private function _isProductAllowed($id_product) {
		return Product::idIsOnCategoryId($id_product, $this->_getAllowedCategories());
	}

	// Return the reward calculated from a price in a specific currency, and converted in the 2nd currency
	protected function getNbCreditsByPrice($price, $idCurrencyFrom, $idCurrencyTo = NULL, $extraParams = array())
	{
		if (!isset($idCurrencyTo))
			$idCurrencyTo = $idCurrencyFrom;

		if (Configuration::get('PS_CURRENCY_DEFAULT') != $idCurrencyFrom)
		{
			// converti de la devise du client vers la devise par défaut
			$price = Tools::convertPrice($price, Currency::getCurrency($idCurrencyFrom), false);
		}
		/* Prevent division by zero */
		$credits = 0;
		if ($pointRate = (float)(Configuration::get('RLOYALTY_POINT_RATE')))
			$credits = floor(number_format($price, 2, '.', '') / $pointRate);

		return round(Tools::convertPrice($credits * (float) Configuration::get('RLOYALTY_POINT_VALUE'), Currency::getCurrency($idCurrencyTo)), 2);
	}

	// Hook called on product page
	// TODO : manage the actual id_product_attribute selected on the product page instead of using the most expensive
	public function hookDisplayRightColumnProduct($params)
	{
		$product = new Product((int)Tools::getValue('id_product'));
		if ($this->_isCustomerAllowed($this->context->customer, true) && Validate::isLoadedObject($product) && $this->_isProductAllowed($product->id))
		{
			if (Validate::isLoadedObject($params['cart']))
			{
				$creditsBefore = (float)($this->getNbCreditsByPrice(RewardsModel::getCartPriceForReward($params['cart'], Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED'), $this->_getAllowedCategories()), $this->context->currency->id));
				$creditsAfter = (float)($this->getNbCreditsByPrice(RewardsModel::getCartPriceForReward($params['cart'], Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED'), $this->_getAllowedCategories(), $product), $this->context->currency->id));
				$credits = (float)($creditsAfter - $creditsBefore);
			}
			else
			{
				if (!(int)(Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED')) && RewardsModel::isDiscountedProduct($product->id))
				{
					$credits = 0;
					$this->context->smarty->assign('no_pts_discounted', 1);
				}
				else
					$credits = (float)($this->getNbCreditsByPrice(RewardsModel::getCartPriceForReward(null, Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED'), $this->_getAllowedCategories(), $product), $this->context->currency->id));

				$creditsAfter = $credits;
				$creditsBefore = 0;
			}
			$this->context->smarty->assign(array(
				'credits' => (float)$credits,
				'total_credits' => (float)$creditsAfter,
				'credits_in_cart' => (float)$creditsBefore,
				'minimum' => round(Tools::convertPrice((float) Configuration::get('RLOYALTY_POINT_RATE'), $this->context->currency), 2)
			));

			return $this->instance->display($this->instance->path, 'product.tpl');
		}
		return false;
	}

	public function hookDisplayShoppingCartFooter($params)
	{
		if ($this->_isCustomerAllowed($this->context->customer, true))
		{
			if (Validate::isLoadedObject($params['cart']))
			{
				$credits = $this->getNbCreditsByPrice(RewardsModel::getCartPriceForReward($params['cart'], Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED'), $this->_getAllowedCategories()), $this->context->currency->id);
				$this->context->smarty->assign(array(
					 'credits' => (float)$credits,
					 'guest_checkout' => (int)Configuration::get('PS_GUEST_CHECKOUT_ENABLED')
				));
			}
			else
				$this->context->smarty->assign(array('credits' => 0));
			return $this->instance->display($this->instance->path, 'shopping-cart.tpl');
		}
		return false;
	}

	public function hookActionValidateOrder($params)
	{
		if (!Validate::isLoadedObject($params['customer']) || !Validate::isLoadedObject($params['order']))
			die(Tools::displayError('Missing parameters'));

		if ($this->_isCustomerAllowed(new Customer((int)$params['customer']->id)))
		{
			$reward = new RewardsModel();
			$reward->id_customer = (int)$params['customer']->id;
			$reward->id_order = (int)$params['order']->id;
			$reward->credits = $this->getNbCreditsByPrice(RewardsModel::getOrderPriceForReward($params['order'], Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED'), $this->_getAllowedCategories()), $params['order']->id_currency, Configuration::get('PS_CURRENCY_DEFAULT'));
			$reward->plugin = $this->name;
			if (!Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED') && (float)$reward->credits == 0) {
				$reward->id_reward_state = RewardsStateModel::getDiscountedId();
				$reward->save();
			} else if ((float)$reward->credits > 0) {
				$reward->id_reward_state = RewardsStateModel::getDefaultId();
				$reward->save();
			}
			return true;
		}
		return false;
	}

	public function hookActionOrderStatusUpdate($params)
	{
		if (!Validate::isLoadedObject($orderState = $params['newOrderStatus']) || !Validate::isLoadedObject($order = new Order((int)$params['id_order'])) || !Validate::isLoadedObject($customer = new Customer((int)$order->id_customer)))
			die(Tools::displayError('Missing parameters'));

		$this->instance->instanceDefaultStates();

		// if state become validated or cancelled
		if ($orderState->id != $order->getCurrentState() && (in_array($orderState->id, $this->instance->rewardStateValidation->getValues()) || in_array($orderState->id, $this->instance->rewardStateCancel->getValues())))
		{
			// check if a reward has been granted for this order
			if (!Validate::isLoadedObject($reward = new RewardsModel(RewardsModel::getByOrderId($order->id))))
				return false;
			// if no reward on discount, and state = DiscountId, do nothing
			if (!Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED') && $reward->id_reward_state == RewardsStateModel::getDiscountedId())
				return true;

			if ($reward->id_reward_state != RewardsStateModel::getConvertId()) {
				// if not already converted, then cancel or validate the reward
				if (in_array($orderState->id, $this->instance->rewardStateValidation->getValues())) {
					// if reward is locked during return period
					if (Configuration::get('REWARDS_WAIT_RETURN_PERIOD') && Configuration::get('PS_ORDER_RETURN') && (int)Configuration::get('PS_ORDER_RETURN_NB_DAYS') > 0) {
						$reward->id_reward_state = RewardsStateModel::getReturnPeriodId();
						$template = 'loyalty-return-period';
						$subject = $this->l('Reward validation', (int)$order->id_lang);
					} else {
						$reward->id_reward_state = RewardsStateModel::getValidationId();
						$template = 'loyalty-validation';
						$subject = $this->l('Reward validation', (int)$order->id_lang);
					}
				} else {
					$reward->id_reward_state = RewardsStateModel::getCancelId();
					$template = 'loyalty-cancellation';
					$subject = $this->l('Reward cancellation', (int)$order->id_lang);
				}
				$reward->save();

				// send notification
				if (Configuration::get('RLOYALTY_MAIL_VALIDATION')) {
					$data = array(
						'{customer_firstname}' => $customer->firstname,
						'{customer_lastname}' => $customer->lastname,
						'{order}' => sprintf('%06d', $order->id),
						'{link_rewards}' => $this->context->link->getModuleLink('allinone_rewards', 'rewards', array(), true),
						'{customer_reward}' => Tools::displayPrice(round(Tools::convertPrice((float)$reward->credits, Currency::getCurrency((int)$order->id_currency)), 2), (int)$order->id_currency));
					if ($reward->id_reward_state = RewardsStateModel::getReturnPeriodId()) {
						$data['{reward_unlock_date}'] = Tools::displayDate($reward->getUnlockDate(), null, true);
					}
					$this->instance->sendMail((int)$order->id_lang, $template, $subject, $data, $customer->email, $customer->firstname.' '.$customer->lastname);
				}
			}
		}
		return true;
	}

	// Hook called in tab AdminOrders when a product is cancelled
	public function hookActionProductCancel($params)
	{
		if (!Validate::isLoadedObject($order = $params['order'])
		|| !Validate::isLoadedObject($customer = new Customer((int)$order->id_customer))
		|| !Validate::isLoadedObject($reward = new RewardsModel((int)(RewardsModel::getByOrderId((int)($order->id)))))
		|| $reward->id_reward_state == RewardsStateModel::getConvertId())
			return false;

		$oldCredits = $reward->credits;
		$reward->credits = $this->getNbCreditsByPrice(RewardsModel::getOrderPriceForReward($order, Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED'), $this->_getAllowedCategories()), $order->id_currency, Configuration::get('PS_CURRENCY_DEFAULT'));
		// test if there was an update, because product return doesn't change the cart price
		if ((float)$oldCredits != (float)$reward->credits) {
			if (!Configuration::get('RLOYALTY_DISCOUNTED_ALLOWED') && (float)$reward->credits == 0)
				$reward->id_reward_state = RewardsStateModel::getDiscountedId();
			else if ((float)$reward->credits == 0)
				$reward->id_reward_state = RewardsStateModel::getCancelId();
			$reward->save();
			// TODO : historize changes

			// send notifications
			if (Configuration::get('RLOYALTY_MAIL_CANCELPROD')) {
				$data = array(
					'{customer_firstname}' => $customer->firstname,
					'{customer_lastname}' => $customer->lastname,
					'{order}' => sprintf('%06d', $order->id),
					'{old_customer_reward}' => Tools::displayPrice(round(Tools::convertPrice((float)$oldCredits, Currency::getCurrency((int)$order->id_currency)), 2), (int)$order->id_currency),
					'{new_customer_reward}' => Tools::displayPrice(round(Tools::convertPrice((float)$reward->credits, Currency::getCurrency((int)$order->id_currency)), 2), (int)$order->id_currency));
				$this->instance->sendMail((int)$order->id_lang, 'loyalty-cancel-product', $this->l('Reward modification', (int)$order->id_lang), $data, $customer->email, $customer->firstname.' '.$customer->lastname);
			}
		}
		return true;
	}

	// Hook called in tab AdminOrder
	public function hookDisplayAdminOrder($params)
	{
		if (Validate::isLoadedObject($reward = new RewardsModel(RewardsModel::getByOrderId($params['id_order'])))) {
			$rewardsStateModel = new RewardsStateModel($reward->id_reward_state);

			$smarty_values = array(
				'reward' => $reward,
				'reward_state' => $rewardsStateModel->name[$this->context->language->id],
				'version16' => version_compare(_PS_VERSION_, '1.6', '>=')
			);
			$this->context->smarty->assign($smarty_values);
			return $this->instance->display($this->instance->path, 'adminorders.tpl');
		}
	}
}