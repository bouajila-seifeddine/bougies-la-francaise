<?php 
include(dirname(__FILE__)."/../../../config/config.inc.php");
include(dirname(__FILE__)."/../../../init.php");
include(dirname(__FILE__)."/../config/config.php");
if(!empty($_POST['id_product'])){
	$t_file = Db::getInstance()->ExecuteS('
		SELECT * 
		FROM '._DB_PREFIX_.'360_generate 
		WHERE id_product = '.(int)$_POST['id_product'].'
	');
echo json_encode(array(
		"nbr_file" => count($t_file),
		"nbr_page_max" => ceil(count($t_file)/NOMBRE_PER_PAGE_360_GENERATE)
	));



}

?>