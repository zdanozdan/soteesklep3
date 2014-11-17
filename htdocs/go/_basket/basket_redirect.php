<?
$global_database=true;
require_once ("../../../include/head.inc");

require_once("./include/my_ext_basket.inc.php");
// tworzymy koszyk
$basket=& new My_Ext_Basket();
// wymagane przez temat aby wy¶wietliæ poprawnie liste
$basket->init();
// end nowy koszyk

$options=@$_POST['options'];
$basket_cat=@$_POST['basket_cat'];
$ext_basket=@$_POST['basket'];

if (!empty($_POST['basket_action']))
{
   $action = $_POST['basket_action'];
   if ($action == "add")
   {      
      if (!empty($_POST['id']) && is_numeric($_POST['id']))
      {
         $id=$_POST['id'];
         $amount = $_POST['amount'];
         if ($basket->check_options($id,@$num,$options,$basket_cat,$ext_basket) == true)
         {
            $location = "Location:/go/_info/options_only.php?id=" . $id;            
            header($location);
         }
         else
         {
            if ($_POST['destination'] == "wishlist" || $_REQUEST['destination'] == "wishlist")
            {
               $basket=& new My_Ext_Basket('wishlist');
               $basket->init();
            }

            if (is_numeric($amount))
            {
               $basket->add_prod($id,$amount,$options,$basket_cat,$ext_basket,true);
               //$basket->add_prod($id,$amount,'','','',true);
            }
            else
            {
               $basket->add_prod($id,$amount,$options,$basket_cat,$ext_basket,true);
               //$basket->add_prod($id,1,'','','',true);
            }
            $basket->register();
            //go back to where it needs to be, post variables are cleared
            //global $$HTTP_SERVER_VARS;
            //$http_referer = $HTTP_SERVER_VARS['HTTP_REFERER'];
	    $http_referer = $_SERVER['HTTP_REFERER'];
            $removed_options=str_replace("options_only.php","",$http_referer);
            $location = "Location:".$removed_options;
            header($location);
         }
      }
   }
}
?>