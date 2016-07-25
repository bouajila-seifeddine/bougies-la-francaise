<?php

include(dirname(__FILE__) . "/../../../config/config.inc.php");
include(dirname(__FILE__) . "/../../../init.php");
include(dirname(__FILE__) . "/../config/config.php");
define('_PS_ADMIN_DIR_', getcwd());
include(_PS_ADMIN_DIR_.'/../config/config.inc.php');
//if (!empty($_GET["id_360"])  && Context::getContext()->employee->isLoggedBack()  )
$context = Context::getContext();
if (!empty($_GET["id_360"]))
{
    global $smarty  ;
    $id_360 = intval($_GET["id_360"]);
    $t_img = Scancube360::get360($id_360);
    if (count($t_img) == 0)
    {
      die("Erreur, aucun 360");
    }
    $animOptions = Scancube360::getAnimationOptions2($id_360);
    if (is_array($t_img) && count($t_img) > 1)
    {
        list($width, $height) = getimagesize(dirname(__FILE__) . "/../img_360/" . $t_img[1]);
        list($Hdwidth, $Hdheight) = getimagesize(dirname(__FILE__) . "/../img_360/" . "hd-" . $t_img[1]);
        $js = "";

        $img0 = substr($t_img[1], 0, -8);
        $js .= " <script type='text/javascript'>
            $(document).ready(function ()
            {
             $('#scancube_jzspin').jzSpin
             (
             {
             ldImageWidth: {$width},
             ldImageHeight: {$height},
             isZoomable: {$animOptions['zoom']},
             hdImageWidth: {$Hdwidth},
             hdImageHeight: {$Hdheight},
             numberOfImages: {$animOptions['num_images']},
             rotationSpeed : {$animOptions['rotation_speed']},
             autoSpinAfter :{$animOptions['auto_spin']},
             style :{$animOptions['anim_style']},
             magnifierSize :300,
             direction:{$animOptions['rotation_dir']}, //ckw = 0 , antickw = 1 
             ldImageBaseName : " . '"' . __PS_BASE_URI__ . "modules/nq_360/img_360/{$img0}" . '"' . ","
             . "hdImageBaseName :" . '"' . __PS_BASE_URI__ . "modules/nq_360/img_360/hd-{$img0}" . '"' .
                "       }
      ) 
   
} 
)";
        $js.="</script>";
        $_GET["content_only"] = 1;
        $_GET["content_only"] = 1;
    
        $controller = new FrontController();
        if (version_compare(_PS_VERSION_, '1.5', '>'))
        {
           $controller->addJS(__PS_BASE_URI__ . 'modules/nq_360/js/jquery-1.8.2.min.js') ;
           $controller ->addJS(__PS_BASE_URI__ . 'modules/nq_360/js/jzspin1.4.js') ;
           $controller ->addCSS(__PS_BASE_URI__ . 'modules/nq_360/css/scancube-jzspin1.4.css', 'screen') ;
        }
        else // version 14
        { 
          Tools::addCSS(__PS_BASE_URI__ . 'modules/nq_360/css/scancube-jzspin1.4.css', 'screen');
          Tools::addJS(__PS_BASE_URI__ . 'modules/nq_360/js/jzspin1.4.js'); 
        }  
	$controller->displayHeader() ;
        $smarty->assign("js", $js);
        $smarty->display(DIR_TEMPLATE . 'bo-view-360.tpl');
	$controller->displayFooter() ;
     
    } else
    {
        die("Erreur, aucunes images trouvées");
    }
} else
{
    die("Erreur, il manque des paramètres");
}
?>