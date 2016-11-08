<?php  ///zzzzzz
include(dirname(__FILE__)."/../../../config/config.inc.php");
include(dirname(__FILE__)."/../../../init.php");
include(dirname(__FILE__)."/../config/config.php");
if(!empty($_POST["id_360"]) && isset($_POST["active"]) && isset($_POST["id_product"]))
{
 $date_now = date("Y-m-d H:i:s");
 Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'360_generate SET active = 0 WHERE id_product = '.intval($_POST["id_product"]));
 Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'360_generate SET active = '.(int)$_POST["active"].' WHERE id_360 = '.(int)$_POST["id_360"]);
 echo json_encode("sucess") ;
}
else
{
 echo json_encode("Error") ;
}
?>