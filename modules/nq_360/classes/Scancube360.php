<?php
class Scancube360{

public static function isGenereted360($id_product)
{
$t_file = Db::getInstance()->ExecuteS('
			SELECT * 
			FROM '._DB_PREFIX_.'360_generate
			WHERE id_product = '.(int)$id_product.' AND active = 1
			ORDER BY date_add DESC
			LIMIT 1
		');
            //    die($t_file) ;
		$temp_img = array();
		foreach($t_file as $f){
			$t_file_link = Db::getInstance()->ExecuteS('
				SELECT * 
				FROM '._DB_PREFIX_.'360_link_file
				INNER JOIN '._DB_PREFIX_.'360_file  USING(id_file)
				WHERE id_360 = '.(int)$f['id_360'].'
				ORDER BY position ASC
			');
			if(count($t_file_link ) > 1){
				$all_generated = true;
				foreach($t_file_link as $l){
					$temp_img[]  = 	$l["file_url"];
				}
			}else{
				return $t_file_link[0]["file_url"];
			}
			
			if($all_generated){
				return $temp_img; 
			}
		}
		return array();
	}

public static function get360($id_360)
       {
	$t_file_link = Db::getInstance()->ExecuteS('
				SELECT * 
				FROM '._DB_PREFIX_.'360_link_file
				INNER JOIN '._DB_PREFIX_.'360_file  USING(id_file)
				WHERE id_360 = '.(int)$id_360.'
				ORDER BY position ASC
			');
  			if(count($t_file_link ) > 1)
                        {
			   $all_generated = true;
			   foreach($t_file_link as $l)
                           {
			     $temp_img[]  = $l["file_url"];
		           }
			}
                        else
                        {
			  return $t_file_link[0]["file_url"];
			}
			if($all_generated)
                        {
			 return $temp_img; 
			}
		return array();
	}
        
public static function getDisplayScanCube($id_product)
        {
	$t_file = Db::getInstance()->getRow('
			SELECT display 
			FROM '._DB_PREFIX_.'360_generate
			WHERE id_product = '.(int)$id_product.' AND active = 1
			ORDER BY date_add DESC
		');
		if(!empty($t_file)){
			return $t_file["display"];
		}
		return false;
	}
public static function getAnimationOptions($id_product) 
{
 	$t_file = Db::getInstance()->getRow('
			SELECT zoom,rotation_dir,rotation_speed,anim_style,auto_spin,num_images
			FROM '._DB_PREFIX_.'360_generate
			WHERE id_product = '.(int)$id_product.' AND active = 1
			ORDER BY date_add DESC
		');
		if(!empty($t_file)){
			return $t_file ;
	
	
         }
 }
	
public static function getAnimationOptions2($id_360) 
{
 	$t_file = Db::getInstance()->getRow('
			SELECT zoom,rotation_dir,rotation_speed,anim_style,auto_spin,num_images
			FROM '._DB_PREFIX_.'360_generate
			WHERE id_360 = '.(int)$id_360.' AND active = 1
			ORDER BY date_add DESC
		');
		if(!empty($t_file)){
			return $t_file ;
	
	
         }
 }
 
 
 
public static function getId360($id_product){
		$t_file = Db::getInstance()->getRow('
			SELECT id_360 
			FROM '._DB_PREFIX_.'360_generate
			WHERE id_product = '.(int)$id_product.' AND active = 1
			ORDER BY date_add DESC
		');
		if(!empty($t_file)){
			return $t_file["id_360"];
		}
		return false;
	}
	
public static function getZoomActive($id_product)
        {
		$t_file = Db::getInstance()->getRow('
			SELECT zoom 
			FROM '._DB_PREFIX_.'360_generate
			WHERE id_product = '.(int)$id_product.' AND active = 1
			ORDER BY date_add DESC
		');
		
		if(!empty($t_file)){
			return $t_file["zoom"];
		}
		
		return 0;
	}
	
	public static function getZoomActiveby360($id_360)
        {
		$t_file = Db::getInstance()->getRow('
			SELECT zoom 
			FROM '._DB_PREFIX_.'360_generate
			WHERE id_360 = '.(int)$id_360.' 
		');
		if(!empty($t_file))
                {
		  return $t_file["zoom"];
		}
		
		return 0;
	}
	
	
}