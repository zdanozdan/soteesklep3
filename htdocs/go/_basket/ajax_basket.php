<?php
/**
* Ustawianie parametrów sesji za pomoca AJAX.
*
* @author  tomasz@mikran.pl
* @version $Id$
*/

$global_database=true;
require_once ("../../../include/head.inc");

require_once("./include/my_ext_basket.inc.php");
// tworzymy koszyk
$basket=& new My_Ext_Basket();
// wymagane przez temat aby wy¶wietliæ poprawnie liste
$my_basket=&$basket;
$basket->init();
// end nowy koszyk

if (!empty($_REQUEST['action']))
{
   $action = $_REQUEST['action'];
   if ($action == "show_basket")
   {
      if (!empty($_REQUEST['value']))
      {
         $val = $_REQUEST['value'];
         if ($val == "collapse")
            $val = "expand";
         else
            $val = "collapse";
         
         $sess->register("show_basket",$val);
         $basket->updateAjaxBasket("head");
      }
   }
   
   if ($action == "update")
   {
      if (!empty($_REQUEST['row_id']))
      {
         $id=$_REQUEST['row_id'];
         if (isset($_REQUEST['amount']) && is_numeric($_REQUEST['amount']))
         {
            $quantity=intval($_REQUEST['amount']);
            
            if ($quantity>0) 
            {
               $basket->setNum($id,$quantity);
            } 
            else 
            {
               $basket->del_product($id);
            }

            if (!empty($_REQUEST['disable_ajax']))
            {
               $disable_ajax = $_REQUEST['disable_ajax'];
               $sess->register("disable_ajax",$disable_ajax);
            }

            $basket->register();
            $basket->updateAjaxBasket($_REQUEST['type']);            
            $sess->unregister("disable_ajax");
         }
      }
   }
   if ($action == "delete")
   {
      if (!empty($_REQUEST['row_id']))
      {
         $id=$_REQUEST['row_id'];
         $basket->del_product($id);
         $basket->register();
         $basket->updateAjaxBasket($_REQUEST['type']);
      }
   }

   if ($action == "add")
   {      
      if (!empty($_REQUEST['prod_id']))
      {
         $id=$_REQUEST['prod_id'];
         $basket->add_prod($id,1,'','','',true);
         $basket->register();
         $basket->updateAjaxBasket($_REQUEST['type']);
      }
   }

   if ($action == "add_wishlist")
   {      
      if (!empty($_REQUEST['prod_id']))
      {
         $id=$_REQUEST['prod_id'];
         $wishlist=& new My_Ext_Basket('wishlist');
         $wishlist->init();
         $wishlist->add_prod($id,1,'','','',true);
         $wishlist->register();
         $basket->updateAjaxBasket($_REQUEST['type']);
      }
   }

   if ($action == "delivery")
   {
      require_once("./include/delivery.inc.php");
      $delivery_obj->calc();
      $delivery_obj->show_ajax();
   }
}

?>