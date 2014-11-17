<?php
/**
* Obliczanie sumy kontrolnej transakcji.
*
* @author  m@sote.pl
* @version $Id: checksum.inc,v 1.3 2004/12/20 18:02:59 maroslaw Exp $
* @package    include
*/

global $__secure_test;
if ($__secure_test!=true) die ("Forbidden");

class OrderChecksum {
    
    /**
    * Suma kontrolna potwierdzenia autoryzacji.
    * Zabezpieczenie przed niepowo³anym dostêpem do bazy i modyfikacj± np. statusu p³atno¶ci.
    *
    * @param int    $order_id id transakcji
    * @param int    $auth     kod autoryzacji 1 - platnosc potwierdzona, 0 - platnosc niepotwierdzona
    * @param float  $amount   kwota transakcji
    * @param string $pin      pin opcjonalnie wykorzystywany do danych zmienianych tylko z poziomu panelu administracyjnego
    *
    * \@global string $config->salt  "sól" u¿ywana do kodowania
    *
    * @return string suma kontrolna, false - dane sie nie zgadzaja, z³y format
    */
    function checksum($order_id,$auth,$amount=0,$pin='') {
        if (! ereg("^[0-9]+$",$order_id)) return false;
        if (($auth!=0) and ($auth!=1)) return false;        
        $amount=number_format($amount,2,".","");        
        global $config;
        return md5($order_id.$auth.$amount.$pin.$config->salt);
    } // end checksum()
    
} // end class OrderChecksum
?>
