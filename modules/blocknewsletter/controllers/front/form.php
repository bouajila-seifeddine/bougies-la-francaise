<?php

class BlocknewsletterFormModuleFrontController extends ModuleFrontController
{
	private $message = '';

	/**
	 * @see FrontController::postProcess()
	 */
	public function postProcess()
	{
		$this->message = $this->module->confirmEmail(Tools::getValue('token'));
	}

	/**
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
		parent::initContent();

        $this->context->smarty->assign(array(
        		'newsletter_email' => Tools::getIsset('email') ? Tools::getValue('email') : '',
        		'newsletter_lastname' => Tools::getIsset('lastname') ? Tools::getValue('lastname') : '',
        		'newsletter_firstname' => Tools::getIsset('firstname') ? Tools::getValue('firstname') : '',
        		'newsletter_day' => Tools::getIsset('day') ? Tools::getValue('day') : '',
        		'newsletter_month' => Tools::getIsset('month') ? Tools::getValue('month') : '',
        		'newsletter_year' => Tools::getIsset('year') ? Tools::getValue('year') : '',
        		'years' => Tools::dateYears(),
        		'months' => Tools::dateMonths(),
        		'days' => Tools::dateDays(),
        	)
        );

		$this->setTemplate('form.tpl');
	}
}
