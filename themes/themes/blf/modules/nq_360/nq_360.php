<?php

if (!defined('_PS_VERSION_'))
  exit;
//test here
include(dirname(__FILE__) . "/config/config.php");

class NQ_360 extends NQ_360Module
{

    public function hookDisplayProductButtons($params, $type = "extraLeft", $template = "content-extra-left.tpl")
    {
        global $smarty;
        if (!GestionFo::isPageProduct())
        {
            return;
        }
        if (!$id_product = GestionFo::getIdProduct())
        {
            return;
        }

        $t_img = Scancube360::isGenereted360($id_product);
        if (count($t_img) == 0)
        {
            return;
        }

        $display = Scancube360::getDisplayScanCube($id_product);

        if ($display != $type)
        {
            return;
        }
        $smarty->assign("t_img_360", $t_img);
        return ($this->display(__FILE__, '/' . DIR_NAME_TEMPLATE . '/' . $template));
    }

}