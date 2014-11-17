<?php
/**
* Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
* Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
*
* @author  m@sote.pl
* @version $Id: order_record.inc.php,v 2.23 2005/12/07 13:46:56 lukasz Exp $
* @package    order
*/

/**
* Dodaj klasê zawieraj±ca funkcje obliczania sumy kontrolnej.
*/
require_once ("include/order_register.inc");
require_once ("Date/Calc.php");

/**
* Klasa zawieraj±ca funkcjê prezentacji wiersza rekordu transakcji na li¶cie transakcji.
* @package order
* @subpackage order
*/
class OrderRecordRow {
    var $type="long";                          // rodzaj prezentacji rekordu -  pelny lub skocony
    
    /**
    * Odczytaj i wy¶wietl dane transakcji na liscie transakcji
    *
    * @param mixed $result wynik zapytania za bazy danych
    * @param int   $I      wiersz wyniku zapytania SQL
    * @return none
    */
    function record($result,$i) {
        global $db;
        global $theme;
        global $rec;
        global $config;
        
        $rec->data['id']=$db->FetchResult($result,$i,"id");
        $rec->data['order_id']=$db->FetchResult($result,$i,"order_id");
        $rec->data['date_add']=$db->FetchResult($result,$i,"date_add");
        
        $rec->data['amount']=$theme->price($db->FetchResult($result,$i,"amount"));
        $rec->data['delivery_cost']=$db->FetchResult($result,$i,"delivery_cost");
        
        // kwota do zaplaty (wliczony jest koszt dostawy)
        $rec->data['amount_confirm']=$rec->data['amount']+$rec->data['delivery_cost'];
        $rec->data['amount_all']=$rec->data['amount_confirm'];
        
        $rec->data['confirm']=$db->FetchResult($result,$i,"confirm");
        $rec->data['cancel']=$db->FetchResult($result,$i,"cancel");
        $rec->data['id_pay_method']=$db->FetchResult($result,$i,"id_pay_method");
        $rec->data['pay_status']=$db->FetchResult($result,$i,"pay_status");
        $rec->data['id_status']=$db->FetchResult($result,$i,"id_status");
        $rec->data['send_date']=$db->FetchResult($result,$i,"send_date");
        $rec->data['send_number']=$db->FetchResult($result,$i,"send_number");
        $rec->data['id_user']=$db->FetchResult($result,$i,"id_user");
        $rec->data['partner_name']=$db->FetchResult($result,$i,"partner_name");
        $rec->data['recom_id_user']=$db->FetchResult($result,$i,"recom_id_user");
        
        // odczytaj prowizaje dla partnera, jelsi jest 0, to nic nie wyswietlaj
        $rec->data['rake_off_amount']=$db->FetchResult($result,$i,"rake_off_amount");
        if (! $rec->data['rake_off_amount']>0) $rec->data['rake_off_amount']='';
        
        $rec->data['confirm_online']=$db->FetchResult($result,$i,"confirm_online");
        $rec->data['fraud']=$db->FetchResult($result,$i,"fraud");
        $rec->data['delivery_cost']=$db->FetchResult($result,$i,"delivery_cost");
        $rec->data['amount_c']=$db->FetchResult($result,$i,"amount_c");
        
        // sumy kontrolne zapisane w bazie
        $rec->data['checksum']=$db->FetchResult($result,$i,"checksum");
        $rec->data['checksum_online']=$db->FetchResult($result,$i,"checksum_online");
        $rec->data['points']=$db->FetchResult($result,$i,"points");
        
        // suma kontrolna obliczona dla pola confirm
        $my_checksum=OrderRegisterChecksum::checksum($rec->data['order_id'],$rec->data['confirm'],$rec->data['amount']);
        
        // suma kontrolna obliczona dla pola confirm_online
        $amount_online=$theme->price($rec->data['amount']+$rec->data['delivery_cost']);
        $my_checksum_online=OrderRegisterChecksum::checksum($rec->data['order_id'],$rec->data['confirm_online'],$amount_online);
        
        if ((@$rec->data['amount_c']!=($rec->data['amount']+$rec->data['delivery_cost'])) && (@$rec->data['amount_c']>0)) {
            // kwota potwierdzenia sie nie zgadza
            $rec->data['fraud']=10;
        }
        
        if ($rec->data['checksum']!=$my_checksum) {
            // suma kontrolna sie nie zgadza
            $rec->data['fraud']=1;
        }
        
        if ($rec->data['checksum']!=$my_checksum) {
            // suma kontrolna potwierdzenia online sie nie zgadza
            $rec->data['fraud']=2;
        }
        
        // data potwierdzenia trsnsakcji
        $rec->data['pay_status']=$db->FetchResult($result,$i,"pay_status");
        $rec->data['time_alert']=-1;$rec->data['time_alert_past']=0;
        $rec->data['date_confirm']=$db->FetchResult($result,$i,"date_confirm");
        // pokazuj przypomnienie tylko dla transakcji niedokonczonych pay_status!=002
        if ((! empty($rec->data['date_confirm'])) && ($rec->data['date_confirm']!="0000-00-00") && ($rec->data['pay_status']!='002')) {
            
            $year1=date("Y");
            $month1=date("m");
            $day1=date("d");
            
            preg_match("/([0-9]+)-([0-9]+)-([0-9]+)/",$rec->data['date_confirm'],$date2);
            $year2=$date2[1];
            $month2=$date2[2];
            $day2=$date2[3];
            
            // czy $calc_date_confirm >= $rec->date_confirm ?
            // jesli tak to pokaz ostrzezenie, ze konczy sie termin rozliczenia transakcji
            $diff_days=Date_Calc::dateDiff($day1,$month1,$year1,$day2,$month2,$year2);
            
            if ($diff_days<=$config->order_alert_days) {
                $rec->data['time_alert']=$diff_days;
            }
            
            if (Date_Calc::isPastDate($day2,$month2,$year2)) {
                $rec->data['time_alert_past']=1;
                $rec->data['time_alert']=$diff_days;
            }
        }        
        // end
        
        // total_amount
        $rec->data['total_amount']=$theme->price($db->FetchResult($result,$i,"total_amount"));
        
        // main_keys sprzedaz online; wartosc !=0 oznacza, ze w zamowieniu sa produkty przeznaczone do sprzedazy on-line
        $rec->data['main_keys_status']=$db->FetchResult($result,$i,"main_keys_status");
        
        include ("./html/row.html.php");
        
        return(0);
    } // end record_row()
    
} // end class OrderRecordRow
?>
