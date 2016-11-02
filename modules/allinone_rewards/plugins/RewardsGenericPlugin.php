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

abstract class RewardsGenericPlugin
{
	protected $module;
	protected $instance;
	protected $context;

	function __construct($module)
	{
		$this->instance = $module;
		$this->context = Context::getContext();
	}

	public function checkWarning() {
	}

	protected function registerHook($hookName)
	{
		return $this->instance->registerHook($hookName);
	}

	public function l($string, $lang_id=null)
	{
		return $this->instance->l2($string, $lang_id, strtolower(get_class($this)));
	}

	abstract public function install();
	abstract public function uninstall();
	abstract public function postProcess();
	abstract public function isActive();
	abstract public function getContent();
	abstract public function getTitle();
	abstract public function getDetails($reward, $admin);
}