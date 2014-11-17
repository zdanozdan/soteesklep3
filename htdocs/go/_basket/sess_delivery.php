<?php
/**
* Ustawianie parametrów delivery za pomoca AJAX.
*
* @author  tomasz@mikran.pl
* @version $Id: sess_delivery.php,v 1.1 2008/08/11 17:37:50 tomasz Exp $
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

/**
* Klasa funckji: oblicz koszty dostawy, wy¶wietl listê dostawców itp.
*/
require_once("./include/delivery.inc.php");

global $sess;
global $delivery_obj;
global $theme;
if (!empty($_REQUEST['delivery_id']))
{
   $sess->unregister('ajax_pay_number');
   $tab = $delivery_obj->get_delivery_data_by_id($_REQUEST['delivery_id']);
   if (!empty($tab))
   {
      //print_r($tab);
      $sess->register('global_delivery',$tab);
      //$theme->show_order_step_one($theme->price($this->amount),
      //                            $theme->price($this->order_amount),
      //                           $delivery_obj->delivery_name,
      //                           $delivery_obj->delivery_cost);

      $theme->show_order_step_one($theme->price($basket->amount),
                                  $theme->price($basket->order_amount),
                                 $delivery_obj->delivery_name,
                                 $delivery_obj->delivery_cost);
   }
}   
?>