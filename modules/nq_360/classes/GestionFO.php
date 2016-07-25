<?php 
class GestionFO{
	public static function isPageProduct()
        {
	 if( !empty($_GET["id_product"]))
         {
	   return true;
         }
	  return false;
	}
	public static function getIdProduct()
        {
	  if(!empty($_GET["id_product"]))
          {
	     $p = new Product(((int)$_GET["id_product"]));
	     if(Validate::isLoadedObject($p))
             {
	      return (int)$p->id;
	     }
          }
	    return false;
	}
}