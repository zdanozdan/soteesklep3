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
// $Id: add.php,v 2.6 2005/02/10 12:12:29 scalak Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

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
$action="add.php";
if ($update==false) {
    // wywolanie wyswietlenia wlasciwosci
    include_once("./html/delivery_edit.html.php");
} else {
    // insert

    // sprawdz formularz
    include_once("include/form_check.inc");
    $form_check = new FormCheck;
    $theme->form_check=&$form_check;

    $form_check->fun['name']="string";
    $form_check->fun['price_brutto']="price";
    $form_check->fun['vat']="vat";
    $form_check->fun['free_from']="price";
    $form_check->fun['order_by']="int";
    
    $form_check->form=&$_REQUEST['delivery'];
    $form_check->errors=$lang->delivery_edit_form_errors;    
    $form_check->check=true;

    $rec->data=$delivery;
    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        include_once("./include/insert_delivery.inc.php");   
        $theme->status_bar($insert_info);     
        $action="edit.php";
        // wyswietl formularz z poprawnymi danymi        
        include_once("./html/delivery_edit.html.php");
        exit;
    } else {    
        // wyswietl formularz z poprawnymi danymi
        include_once("./html/delivery_edit.html.php");
    }
    
}
 
$theme->foot_window();

include_once ("include/foot.inc");
?>
