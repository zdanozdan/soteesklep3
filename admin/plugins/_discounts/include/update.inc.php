<?php
/**
 * PHP Template:
 * Aktualizuj dane w tabeli discounts
 * 
 * @author      piotrek@sote.pl
 * \@modified_by m@sote.pl
 * \@verified_by m@sote.pl v 1.2
 * \@template_version Id: update.inc.php,v 1.3 2003/02/06 11:55:16 maroslaw Exp
 * @version     $Id: update.inc.php,v 2.9 2004/12/20 17:59:48 maroslaw Exp $
* @package    discounts
 */

global $db;
global $lang;

if (@$this->secure_test!=true) die ("Bledne wywolanie");

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

// odczytaj biezacy rabat
$query="SELECT discount,discount_cat,discount_producer FROM discounts WHERE id=? LIMIT 1";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$this->id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $current_discount=$db->FetchResult($result,0,"discount");   
            $current_discount_cat=$db->FetchResult($result,0,"discount_cat");   
            $current_producer_discount=$db->FetchResult($result,0,"discount_producer");            
        } else $current_producer_discount=0;
    } else die ($db->Error());
} else die ($db->Error());

// config
$query="UPDATE discounts SET discount=?, discount_cat=?, discount_producer=? WHERE id=?";
// end

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    
    // config   
    $encoded_discount=$discounts->encode_discount(my(@$current_discount),set0double(@$this->data['discount']));
    $encoded_discount_cat=$discounts->encode_discount(my(@$current_discount_cat),set0double(@$this->data['discount_cat']));    
    $encoded_discount_producer=$discounts->encode_discount(my(@$current_producer_discount),set0double(@$this->data['discount_producer']));
    
    // sprawdz czy zostaly przekazane nowe rabaty kategorii, producenta, kategorii i producenta; jesli ktoregos nie 
    // ma przekazanego (bo nie ma tych rabatow w formularzu) to do bazy wpisz to co bylo
    if (@$this->data['discount']=="") {
        $encoded_discount=$current_discount;
    }
    
    if (@$this->data['discount_cat']=="") {
        $encoded_discount_cat=$current_discount_cat;
    }
    
    if (@$this->data['discount_producer']=="") {
        $encoded_discount_producer=$current_producer_discount;
    }
    
    $db->QuerySetText($prepared_query,1,$encoded_discount);
    $db->QuerySetText($prepared_query,2,$encoded_discount_cat);
    $db->QuerySetText($prepared_query,3,$encoded_discount_producer);
    $db->QuerySetText($prepared_query,4,$this->id);
    // end
    
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->discounts_edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

?>
