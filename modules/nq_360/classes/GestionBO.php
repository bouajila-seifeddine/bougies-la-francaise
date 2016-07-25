<?php
//require_once('PhpConsole.php');
//PhpConsole::start(true, true, dirname(__FILE__));
class GestionBO {
    public static function isPageProductBO() {
        if (isset($_GET["updateproduct"])
                && !empty($_GET["id_product"])
               // && !empty($_GET["tab"])
               // && $_GET["tab"] == "AdminCatalog"
               ) {
            return true;
        }
        return false;
    }
    public static function getIdProduct() {
        if (!empty($_GET["id_product"])) {
            $p = new Product(((int) $_GET["id_product"]));
            if (Validate::isLoadedObject($p)) {
                return (int) $p->id;
            }
        }

        return false;
    }
    
 
}