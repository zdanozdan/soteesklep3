<?php
/**
* @version    $Id: add.php,v 2.8 2005/11/25 11:49:27 lechu Exp $
* @package    options
* @subpackage available
*/
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
// $Id: add.php,v 2.8 2005/11/25 11:49:27 lechu Exp $

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

if (! empty($_REQUEST['available'])) {
    $available=$_REQUEST['available'];
}

// naglowek
$theme->head_window();

$theme->bar($lang->available_add_bar);

if (! empty($_REQUEST['update'])) {
    $update=true;
} else {
    $update=false;
}
$action="add.php";
if ($update==false) {
    // wywolanie wyswietlenia wlasciwosci
    require_once ("include/metabase.inc");
    $max_id=$database->sql_select("max(user_id)","available","");
    $new_id=$max_id+1;
    $rec->data['user_id']=$new_id;
    include_once("./html/available_edit.html.php");
} else {
    // insert
    
    // sprawdz formularz
    include_once("include/form_check.inc");
    $form_check = new FormCheck;
    $theme->form_check=&$form_check;
    
    $form_check->fun['name']="string";
    $form_check->fun['user_id']="int";
    
    
    $form_check->form=&$_REQUEST['available'];
    $form_check->errors=$lang->available_edit_form_errors;
    $form_check->check=true;
    
    $rec->data=$available;
    
    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        include_once("./include/insert_available.inc.php");
        $theme->status_bar($insert_info);
        $action="edit.php";
        // wyswietl formularz z poprawnymi danymi
        include_once("./html/available_edit.html.php");
        exit;
    } else {
        // wyswietl formularz z poprawnymi danymi
        include_once("./html/available_edit.html.php");
    }
    
    
    // odczytaj dostepnosc i zapisz w pliku user_config.inc.php
    require_once ("include/ftp.inc.php");
    $ftp->connect();
    require_once ("./include/available.inc.php");
    require_once ("include/gen_user_config.inc.php");
    $gen_config->gen(array("available"=>$global_available));
    $ftp->close();
}

$theme->foot_window();

include_once ("include/foot.inc");
?>
