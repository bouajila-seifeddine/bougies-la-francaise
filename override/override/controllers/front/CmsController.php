<?php

class CmsController extends CmsControllerCore
{

	/**
	 * Assign template vars related to page content
	 * @see FrontController::initContent()
	 */
	public function initContent()
	{
        if ($this->assignCase == 1)
		{
			$this->context->smarty->assign(array(
                'parent_categorie' => new CMSCategory($this->cms->id_cms_category, $this->context->language->id)
			));
		}
        
		parent::initContent();
	}
}
