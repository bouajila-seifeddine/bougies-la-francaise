<?php
/*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

abstract class Db extends DbCore
{
	/**
	 * getRow return an associative array containing the first row of the query
	 * This function automatically add "limit 1" to the query
	 *
	 * @param mixed $sql the select query (without "LIMIT 1")
	 * @param bool $use_cache find it in cache first
	 * @return array associative array of (field=>value)
	 */
	public function getRow($sql, $use_cache = true)
	{
		if ($sql instanceof DbQuery)
			$sql = $sql->build();

		$sql = rtrim($sql, ';').' LIMIT 1';
		$this->result = false;
		$this->last_query = $sql;
		if ($use_cache && $this->is_cache_enabled && ($result = Cache::getInstance()->get(md5($sql))))
		{
			$this->last_cached = true;
			return $result;
		}
		$this->result = $this->query($sql);
		if (!$this->result)
			return false;
		$this->last_cached = false;
		$result = $this->nextRow($this->result);
		if (is_null($result))
			$result = false;
		if ($use_cache && $this->is_cache_enabled)
			Cache::getInstance()->setQuery($sql, $result);
		return $result;
	}
}
