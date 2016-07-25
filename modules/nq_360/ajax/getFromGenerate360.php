<?php 
include(dirname(__FILE__)."/../../../config/config.inc.php");
include(dirname(__FILE__)."/../../../init.php");
include(dirname(__FILE__)."/../config/config.php");
if(!empty($_POST['id_product']) && !empty($_POST['page']))
{
	$t_file = Db::getInstance()->ExecuteS('
		SELECT * 
		FROM '._DB_PREFIX_.'360_generate
		WHERE id_product = '.(int)$_POST['id_product'].'
		ORDER BY date_add DESC
		LIMIT '.(NOMBRE_PER_PAGE_360_FILE * ($_POST['page']-1)).', '.NOMBRE_PER_PAGE_360_GENERATE.'	

	');
	echo json_encode($t_file);
}
 else
{
    echo json_decode("error")  ;   
}

?>