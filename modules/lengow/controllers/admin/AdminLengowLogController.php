<?php
/**
 * Copyright 2015 Lengow SAS.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 *  @author    Team Connector <team-connector@lengow.com>
 *  @copyright 2015 Lengow SAS
 *  @license   http://www.apache.org/licenses/LICENSE-2.0
 */

require_once _PS_MODULE_DIR_.'lengow'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'lengow.log.class.php';

/**
 * The Lengow Log Admin Controller.
 *
 * @author Team Connector <team-connector@lengow.com>
 * @copyright 2015 Lengow SAS
 */
class AdminLengowLogController extends ModuleAdminController {

	/**
	* Construct the admin selection of products
	*/
	public function __construct()
	{
		$this->context = Context::getContext();
		$this->table = 'lengow_logs_import';
		$this->className = 'LengowLog';
		$this->lang = false;
		$this->explicitSelect = true;
		$this->list_no_link   = true;
		$this->_defaultOrderBy = 'date';
		$this->_defaultOrderWay = 'DESC';
		$this->show_toolbar = false;
		if (_PS_VERSION_ >= '1.6')
			$this->bootstrap = true;

		$this->bulk_actions = array(
			'delete' => array(
				'text' => $this->l('Delete selected'),
				'confirm' => $this->l('Delete selected items ?'),
			)
		);

		$this->fields_list = array(
			'id' => array(
				'title' => $this->l('ID'),
				'width' => 'auto',
				'search' => false,
				'orderby' => false
			),
			'lengow_order_id' => array(
				'title' => $this->l('Lengow Order ID'),
				'align' => 'center',
				'width' => 'auto'
			),
			'message' => array(
				'title' => $this->l('Message'),
				'width' => 'auto',
				'orderby' => false
			),
			'date' => array(
				'title' => $this->l('Date'),
				'width' => 'auto',
				'align' => 'center',
				'type' => 'datetime',
				'orderby' => false
			),
			'is_finished' => array(
				'title' => $this->l('Delete ?'),
				'callback' => 'getDelete',
				'width' => 'auto',
				'align' => 'center',
				'search' => false,
			),
		);

		parent::__construct();
		$this->identifier = 'id';
	}

	/**
	* postProcess handle every checks before saving products information
	*
	* @param mixed $token
	* @return void
	*/
	public function postProcess($token = null)
	{
		if (Tools::getValue('delete') != '')
			LengowLog::deleteLog(Tools::getValue('delete'));
		parent::postProcess($token);
	}

	/**
	* Get delete link for log
	*
	* @return string Link
	*/
	public function getDelete($echo, $row)
	{
		$echo = $echo;
		$token = Tools::getAdminTokenLite('AdminLengowLog', Context::getContext());
		return '<a href="index.php?controller=AdminLengowLog&delete='.$row['id'].'&token='.$token.'"><img src="'._PS_ADMIN_IMG_.'delete.gif" /></a>';
	}

	/**
	* Delete selected logs to Lengow
	*/
	protected function processBulkDelete()
	{
		$logs = Tools::getValue($this->table.'Box');
		if (is_array($logs) && (count($logs)))
		{
			foreach ($logs as $log)
				LengowLog::deleteLog($log);
		}
	}

	public function initToolbar()
	{
		parent::initToolbar();

		unset($this->toolbar_btn['new']);
		$this->context->smarty->assign('toolbar_scroll', 1);
		$this->context->smarty->assign('show_toolbar', 1);
		$this->context->smarty->assign('toolbar_btn', $this->toolbar_btn);
	}

}