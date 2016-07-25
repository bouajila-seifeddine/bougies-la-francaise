<?php


class Contact extends ContactCore
{

	/**
	  * Return available contacts
	  *
	  * @param integer $id_lang Language ID
	  * @param Context
	  * @return array Contacts
	  */
	public static function getContacts($id_lang)
	{
		$shop_ids = Shop::getContextListShopID();
		$sql = 'SELECT *
				FROM `'._DB_PREFIX_.'contact` c
				'.Shop::addSqlAssociation('contact', 'c', false).'
				LEFT JOIN `'._DB_PREFIX_.'contact_lang` cl ON (c.`id_contact` = cl.`id_contact`)
				WHERE cl.`id_lang` = '.(int)$id_lang.'
				AND contact_shop.`id_shop` IN ('.implode(', ', array_map('intval', $shop_ids)).')
				ORDER BY c.`position` ASC';

		return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
	}
}

