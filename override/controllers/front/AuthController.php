<?php

class AuthController extends AuthControllerCore
{
	/**
	 * Process submit on an account
	 */
	protected function processSubmitAccount()
	{
        if (Tools::getValue('passwd') != Tools::getValue('passwd_confirm'))  
            $this->errors[] = Tools::displayError('your password and confirm password input do not match');
        
        parent::processSubmitAccount();
	}
}
