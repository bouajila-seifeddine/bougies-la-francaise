<?php
include(dirname(__FILE__) . "/../../../config/config.inc.php");
include(dirname(__FILE__) . "/../../../init.php");
include(dirname(__FILE__) . "/../config/config.php");

 $zresult->Error   = false ;
 $zresult->Message = "" ;
 if  ((empty($_FILES )|| empty($_POST['id_product'])) )/////wwwwwwwwwww
 {
    $zresult->Error = true ;
    $zresult ->Message = "No file , no product ID " ;
    echo json_encode($zresult) ;
    exit;   
 }
   
    
 $tempFile = $_FILES['Filedata']['tmp_name'];
 $fileParts = pathinfo($_FILES['Filedata']['name']);
 $extension = $fileParts['extension'];
 if (isset($_FILES['Filedata']["error"]) && $_FILES['Filedata']["error"] == 1) 
 {
      $zresult->Error = true ;
      $zresult ->Message = "File Error " ;
      echo json_encode($zresult) ;
      exit;
 }
     if ($extension != "zip") 
     {
      $zresult->Error    = true ;
      $zresult ->Message = "Zip file required " ;
      echo json_encode($zresult) ;
      exit; 
	 
     }
    
  
     $message = "";
     if(!file_exists(DIR_ARCHIVES))
     {
      $zresult->Error    = true ;
      $zresult ->Message = "Archives directory not found " ;
      echo json_encode($zresult) ;
      exit; 
     }
     if(!file_exists(DIR_IMG_360))
     {
      $zresult->Error    = true ;
      $zresult ->Message = "Images 360 directory not found " ;
      echo json_encode($zresult) ;
      exit; 
     }
     
     
     
     $debut = slug($_FILES['Filedata']['name']) . date("d-m-Y_H-i-s");
     $file_name_zip = $debut . ".zip";
     move_uploaded_file($tempFile, DIR_ARCHIVES . $file_name_zip);
     $file_zip_url = DIR_ARCHIVES . $file_name_zip;
     if (!file_exists($file_zip_url))
     {
      $zresult->Error    = true ;
      $zresult ->Message = "file not found in the archives directory " ;
      echo json_encode($zresult) ;
      exit;  
	 
     }  
     $zip_controller = new PclZip($file_zip_url);
     $file_retour = $zip_controller->extract(PCLZIP_OPT_PATH, DIR_ARCHIVES);
     $t_file = array();
     $file_json = "";
     foreach ($file_retour as $t_info_file) 
     {
         if ($t_info_file['status'] == "ok" || $t_info_file['status'] == "newer_exist") 
         {
          if(strpos($t_info_file['filename'], ".jpg") !== FALSE)               
          {
            $t_file[] = $t_info_file['filename'];
          }
          else 
          {
          if (strpos($t_info_file['filename'], ".json") !== FALSE) 
           {
            $file_json = $t_info_file['filename'];
           }
          }
       }
     }

  if($file_json=="")
  {
      $zresult->Error    = true ;
      $zresult ->Message = "Json file not found " ;
      echo json_encode($zresult) ;
      exit;   
  }
  $t_setting = json_decode(file_get_contents($file_json));
  unlink($file_json);
  $date_now = date("Y-m-d H:i:s");
  //if(!empty($t_setting->numImages) && $t_setting->numImages == count($t_file)){
  $zoom = 0;
  if ((string) $t_setting->isZoomable == "true" || $t_setting->isZoomable) 
  {
   $zoom = 1;
  }
  $t_select = Db::getInstance()->getRow("SELECT count(*) as count FROM ". _DB_PREFIX_ . "360_generate WHERE id_product = " . (int) $_POST["id_product"]);
  $name_360 = "360 n" . ($t_select["count"] + 1);
  $query = 'INSERT INTO ' . _DB_PREFIX_ . '360_generate (name, date_add, active, id_product, display, zoom, rotation_speed,num_images,anim_style) VALUES ("'
                          . $name_360 . '", "'
                          . $date_now . '", 0, '
                          . (int) $_POST["id_product"] . ', "onglet", '
                          . intval($zoom) . ','
                          . $t_setting->rotationSpeed
                          .','.$t_setting->numImages.','
                          .$t_setting->style.')';
                
 $res = Db::getInstance()->Execute($query);
 if (!$res)
 {
  $zresult->Error    = true ;
  $zresult ->Message ="mysql error ". mysql_error();
  echo json_encode($zresult) ;
  exit;    
 }
                   
 $id_360 =Db::getInstance()->Insert_ID();
 $prefixe = time() . "-";
 foreach ($t_file as $key => $file)
 {
                    // skip ld images of the zip file
  if(strpos($file, $t_setting->hdImageBaseName)== FALSE)
                    {
                     unlink($file) ;
                     break ;
                    }
   $fileParts = pathinfo($file);
   $name_img = $fileParts["basename"];
   $extension = $fileParts["extension"];
   if ($zoom == 1)
   {
    $name_img_zoom = "hd-" . $prefixe . $name_img;
    $name_img = $prefixe . $name_img;
    if(!copy($file, DIR_IMG_360 . $name_img_zoom))
    {
      unlink($file);
      $zresult->Error    = true ;
      $zresult ->Message ="Unable to copy files";
      echo json_encode($zresult) ;
      exit; 
     }
     unlink($file);
     $res = imageResizeCust(DIR_IMG_360 . $name_img_zoom, DIR_IMG_360 . $name_img, $t_setting->ldImageWidth, $t_setting->ldImageHeight, 'jpg', 255, 255, 255);
     if (!$res)
     {
        $zresult->Error    = true ;
        $zresult ->Message ="Was unable to resize !";
        echo json_encode($zresult) ;
        exit;     
     }
    }
   else 
   {
    $name_img = $prefixe . $name_img;
    imageResizeCust($file, DIR_IMG_360 . $name_img, $t_setting->ldImageWidth, $t_setting->ldImageHeight, 'jpg', 255, 255, 255);
    unlink($file);
   }

   Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ .
                            '360_file (file_url, type, id_product, date_add) VALUES ("'
                            .$name_img
                            . '", "' . $extension
                            . '", ' . (int) $_POST['id_product']
                            . ', "' . $date_now . '")');
                    
                                  
  $id_file = Db::getInstance()->Insert_ID();
                    
  Db::getInstance()->Execute('INSERT INTO ' . _DB_PREFIX_ .
                            '360_link_file (id_360, id_file, position, date_add) VALUES ('
                            . intval($id_360) . ', '
                            . intval($id_file)
                            . ', ' . $key . ', "'
                            . $date_now
                            . '")');
 }
              
 echo json_encode($zresult) ;     
           
           
         

function slug($phrase, $maxLength = 10000) 
{
    $result = strtolower($phrase);
    $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
    $result = trim(preg_replace("/[\s-]+/", " ", $result));
    $result = trim(substr($result, 0, $maxLength));
    $result = preg_replace("/\s/", "-", $result);
    return $result;
}

?>
