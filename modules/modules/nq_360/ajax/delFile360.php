<?php 
include(dirname(__FILE__)."/../../../config/config.inc.php");
include(dirname(__FILE__)."/../../../init.php");
include(dirname(__FILE__)."/../config/config.php");
if(!empty($_POST['t_id_file'])){
	foreach($_POST['t_id_file'] as &$id_file){
		$id_file = (int)$id_file;
	}
	Db::getInstance()->Execute('
		DELETE
		FROM '._DB_PREFIX_.'360_generate 
		WHERE id_360 IN ('.implode(",", $_POST['t_id_file']).')
	');
	Db::getInstance()->Execute('
		DELETE
		FROM '._DB_PREFIX_.'360_link_file 
		WHERE id_360 IN ('.implode(",", $_POST['t_id_file']).')
	');
        
         echo json_encode("sucess") ;
}

?>