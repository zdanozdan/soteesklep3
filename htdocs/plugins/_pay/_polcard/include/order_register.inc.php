<?php
/**
* Aktualizuj dane tranakcji po potwierdzneiu on-line w systemie PolCard ADV
*
* @author  m@sote.pl
* @version $Id: order_register.inc.php,v 1.5 2004/12/20 18:02:10 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

if (@$__secure_test!=true) die ("Forbidden");

/**
* Dodaj klasê obs³ugi order_register - generowanie sumy kontrolnej transakcji.
*/
require_once ("include/order_register.inc");                // funkcja obliczania sumy kontrolnej

/**
* Klasa zawieraj±ca funkcjê aktualizacji transakcji dla p³atno¶ci realizowanej poprzez PolCard.
* @package polcard
* @subpackage htdocs_adv
*/
class OrderRegisterLocalFn {
    
    /**
    * Aktualizuj status transakcji potwierdzenia online (oraz sume kontrolna)
    *
    * @param  string $order_id id transakcji
    * @param  int    $auth     1 - poprawna autoryzacja, 0 - transakcja nie zautoryzowana
    * @param  string $fraud    ocena ryzyka
    * @param  float  $amount   kwota przekazana do rozliczenia
    * @return bool   true - trabnsakcja zaktualizowana, false - nie udalo sie zaktualizowac transakcji
    */
    function update_confirm($order_id,$auth,$fraud=0,$amount=0) {
        global $config,$db;
        global $theme;
        
        if ($auth==1) $auth=1; else $auth=0;
        if (! ereg("^[0-9]+$",$order_id)) return false;
        
        // zmien format amount
        $amount=number_format(($amount/100),2,".","");
        
        // suma kontrolna
        $checksum=OrderRegisterChecksum::checksum($order_id,$auth,$amount);
        
        $query="UPDATE order_register SET confirm_online=?,fraud=?,checksum_online=?,amount_c=?,pay_status=?,date_add=? WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);
        
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$auth);
            $db->QuerySetText(   $prepared_query,2,(300+$fraud));  // 300 wyznacza przestrzen indeksow tablicy $lang->pay_fraud
            $db->QuerySetText(   $prepared_query,3,$checksum);
            $db->QuerySetFloat(  $prepared_query,4,$amount);
            if ($auth==1) {
                $db->QuerySettext(   $prepared_query,5,'000');     // platnosc do zatwierdzenia
            } else {
                $db->QuerySettext(   $prepared_query,5,'050');     // platnosc odrzucona
            }
            $date_add=date("Y-m-d");
            $db->QuerySetText(   $prepared_query,6,$date_add);     // zmien date dodania transakcji, na date autoryzacji
            $db->QuerySetInteger($prepared_query,7,$order_id);
            
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // OK - dane o transakcji zostaly zapisane w bazie
                return true;
            } else die ($db->Error());
        } else die ($db->Error());
        return false;
    } // end update_confirm()
    
} // end class OrderRegisterLocalFn
?>
