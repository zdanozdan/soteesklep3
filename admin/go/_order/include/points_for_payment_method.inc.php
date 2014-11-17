<?php
/**
* Aktualizuj dane transakcji
*
* @author  tomasz@mikran.pl
* @version $Id$
* @package    order
*/

/**
* Nalicza dodatkowe punkty w zale¿no¶ci od wybranej metody p³ato¶ci
  HARDCODED !!
  20% od zamówienia przelewem, bzwbk24
  10% od zamówenia za pobraniem
*/


// Ekstra punkty dla zarejestrowanego uzywkownika kupujacego za metode p³atno¶ci
if ($id_user>0 && $config_points->for_product>0 && $before_confirm!=$confirm)
{
   $extra_payment_points=0;
   $payment_method_name="";
   // punkty naliczne na sume zamówienia
   if ((! empty($amount)) && ($amount>0))
   {
      $id_pay_method=@$_REQUEST['order']['id_pay_method'];
     
      //przelew bzwbk24.pl (id=8)
      if ($id_pay_method=='8')
      {
         $extra_payment_points=intval(round($amount*0.2));
         $payment_method_name="Za p³atno¶æ z BZWBK24.pl";
      }

      //przelew(id=11)
      if ($id_pay_method=='11')
      {
         $extra_payment_points=intval(round($amount*0.2));
         $payment_method_name="Za p³atno¶æ przelewem";
      }

      //platnosc za pobraniem
      if ($id_pay_method=='1')
      {
         $extra_payment_points=intval(round($amount*0.1));
         $payment_method_name="Za p³atno¶æ za pobraniem";
      }
   }
//    print " Discount: ".$_SESSION['__user_discount']."<br>";
//    print " Amount: ".$amount."<br>";
//    print " extra points 1: ".$extra_payment_points."<br>";
 
   if ($extra_payment_points>0)
   {
      // odczytaj obecna liczbe punktow
      $query="SELECT points FROM users_points WHERE id_user=?";
      $prepared_query=$db->PrepareQuery($query);
      if ($prepared_query) {
         $db->QuerySetInteger($prepared_query,1,$id_user);
         $result=$db->ExecuteQuery($prepared_query);
         if ($result!=0) 
         {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) 
            {
               $current_points=$db->FetchResult($result,0,"points");
            }
         } else die ($db->Error());
      } else die ($db->Error());

    //   print " current points: ".$current_points."<br>";
//       print " pay method: ".$id_pay_method."<br>";
//       print " extra points: ".$extra_payment_points."<br>";
//       print " method name: ".$payment_method_name."<br>";

      require_once ("include/points.inc");
      $add_extra_points=new Points();
      // zmien punkty, sprawdz czy uzytkwonik anulowal czy potwierdzil platnosc
      if ($confirm==1) 
      {
         // oblicznie punktow (dodawanie)
         $new_points_value=$current_points+$extra_payment_points;
         // dodanie historii punktow
         $add_extra_points->add_history($id_user,$extra_payment_points,"add",$payment_method_name,$order_id);
         // weryfikacja punktow (dodawanie)
         $add_extra_points->add_points($id_user,$new_points_value);
      }
      else
      {
         //obliczanie punktow (odejmowanie)
         $new_points_value=$current_points-$extra_payment_points;
         if ($new_points_value<0) $new_points_value=0;
         // dodanie historii
         $add_extra_points->add_history($id_user,$extra_payment_points,"decrease","Anulowano(".$payment_method_name.")",$order_id);
         // weryfikacja punktow (odejmowanie)
         $add_extra_points->add_points($id_user,$new_points_value);
      }
   }
}
?>