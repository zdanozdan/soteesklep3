<?php
/**
 * Aktualizuj rabaty dla producenta
 *
 * @author      m@sote.pl
 * @version     $Id: update_producer.inc.php,v 2.3 2004/12/20 17:59:48 maroslaw Exp $
* @package    discounts
 */

global $db;
global $lang;

if (@$this->secure_test!=true) die ("Forbidden");

global $discounts;
require_once ("./include/discounts.inc.php");
$discounts = new Discounts;

// zwroc 0 jesli ciag jest pusty, w p.w. zwroc to samo co na wejsciu
if (! function_exists("set0double")) {
    function set0double($val) {
        if (empty($val)) return 0;
        $val=ereg_replace(",",".",$val);
        $val=number_format($val,2,".","");
        return $val;
    } // end set0double_group()
}

// jesli wybrano rabat dla producenta, to nadaj wszystkim kategoriom danego producenta ten sam rabat dla producenta
if ((! empty($this->data['discount_producer'])) || (@$this->data['discount_producer']==0)) {
    // odczytaj ID producenta
    $id_producer='';
    $query="SELECT id_producer FROM discounts WHERE id=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$this->id);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                $id_producer=$db->FetchResult($result,0,"id_producer");
            }
        } else die ($db->Error());
    } else die ($db->Error());
    
    
    // aktualizuj rabaty dla producenta
    if (! empty($id_producer)) {
        // odczytaj biezacy rabat
        $query="SELECT discount_producer FROM discounts WHERE id_producer=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$id_producer);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $current_producer_discount=$db->FetchResult($result,0,"discount_producer");
                } else $current_producer_discount=0;
            } else die ($db->Error());
        } else die ($db->Error());
        
        $query="UPDATE discounts SET discount_producer=? WHERE id_producer=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            
            // zakoduj grupe i rabat
            $discount_producer=$discounts->encode_discount($current_producer_discount,set0double(@$this->data['discount_producer']));  
            
            if (@$this->data['discount_producer']=="") {
                $discount_producer=$current_producer_discount;
            }
            
            $db->QuerySetText($prepared_query,1,$discount_producer);
            $db->QuerySetInteger($prepared_query,2,$id_producer);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // aktualizacja OK
            } else die ($db->Error());
        } else die ($db->Error());
    }
} // end if (! empty($this->data['discount_producer']))


// aktualizuj rabaty dla kategorii i producenta
if ((! empty($this->data['discount'])) || (@$this->data['discount']==0)) {
    // odczytaj biezacy rabat
    $query="SELECT discount FROM discounts WHERE id=? LIMIT 1";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$this->id);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                $current_discount=$db->FetchResult($result,0,"discount");   
            } 
        } else die ($db->Error());
    } else die ($db->Error()); 
    
    // aktualizuj rabat
    $query="UPDATE discounts SET discount=? WHERE id=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $encoded_discount=$discounts->encode_discount(my(@$current_discount),set0double(@$this->data['discount']));        
        
        if (@$this->data['discount']=="") {
            $encoded_discount=$current_discount;
        }
        
        $db->QuerySetText($prepared_query,1,$encoded_discount);
        $db->QuerySetText($prepared_query,2,$this->id);
        
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            $update_info=$lang->discounts_edit_update_ok;
        } else die ($db->Error());
    } else die ($db->Error());
} // end (! empty($this->data['discounts']))

?>
