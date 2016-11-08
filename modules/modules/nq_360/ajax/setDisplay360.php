<?php
include(dirname(__FILE__)."/../../../config/config.inc.php");
include(dirname(__FILE__)."/../../../init.php");
include(dirname(__FILE__)."/../config/config.php");
if(!empty($_POST["id_360"]) && isset($_POST["display"]))
{
  $date_now = date("Y-m-d H:i:s");
  Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'360_generate SET display = "'.$_POST["display"].'" WHERE id_360 = '.(int)$_POST["id_360"]);
  echo json_encode("sucess") ;
}
else
{
  echo json_encode("Error") ;
}



?>