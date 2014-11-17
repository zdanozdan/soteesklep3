<?php
// +----------------------------------------------------------------------+
// | SOTEeSKLEP version 2                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1999-2002 SOTE www.sote.pl                             |
// +----------------------------------------------------------------------+
// | Zarzadzanie kosztami dostawy                                         |
// +----------------------------------------------------------------------+
// | authors:     Marek Jakubowicz <m@sote.pl> (base system)              |
// +----------------------------------------------------------------------+
//
// $Id: edit.php,v 2.6 2005/04/15 13:05:58 scalak Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
}

// parametr id moze byc przekazany w dodaniu produktu
// tam jest includowany ten plik, po wprowadzeniu nowego rekordu
if (empty($id)) {
    die ("Bledne wywolanie");   
}

if (! empty($_REQUEST['delivery'])) {
    $delivery=$_REQUEST['delivery'];
}

// naglowek
$theme->head_window();

if (! empty($_REQUEST['update'])) {
    $update=true;
} else {
    $update=false;
}

$action="edit.php";

// odczytaj atrybuty dostawcy z bazy
$query="SELECT * FROM delivery WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $rec->data['id']=$db->FetchResult($result,0,"id");
            $rec->data['name']=$db->FetchResult($result,0,"name");
            $rec->data['order_by']=$db->FetchResult($result,0,"order_by");
            $rec->data['price_brutto']=$db->FetchResult($result,0,"price_brutto");
            $rec->data['vat']=$db->FetchResult($result,0,"vat");
            $rec->data['free_from']=$db->FetchResult($result,0,"free_from");
            $rec->data['delivery_info']=$db->FetchResult($result,0,"delivery_info");
            $rec->data['delivery_zone']=$db->FetchResult($result,0,"delivery_zone");
            $rec->data['delivery_pay']=$db->FetchResult($result,0,"delivery_pay");
        } else die ("Brak rekordu o id=$id");        
    } else die ($db->Error());
} else die ($db->Error());

if ($update==false) {
    // wywolanie wyswietlenia wlasciwosci
    include_once("./html/delivery_edit.html.php");
} else {
    // update
    $tmp=$rec->data['delivery_zone'];
    $rec->data=$delivery;
    $rec->data['delivery_zone']=$tmp;// sprawdz formularz
    include_once("include/form_check.inc");
    $form_check = new FormCheck;
    $theme->form_check=&$form_check;

    $form_check->fun['name']="string";
    $form_check->fun['price_brutto']="price";
    $form_check->fun['vat']="vat";
    $form_check->fun['free_from']="price";
    
    $form_check->form=&$_REQUEST['delivery'];
    $form_check->errors=$lang->delivery_edit_form_errors;    
    $form_check->check=true;

    $theme->bar($lang->delivery_edit.": ".$rec->data['name']);

    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        include_once("./include/update_delivery.inc.php");   
        $theme->status_bar($update_info);     
    } 

    
    // wyswietl formularz z poprawnymi danymi
    include_once("./html/delivery_edit.html.php");
    
}
 
$theme->foot_window();

include_once ("include/foot.inc");
?>
