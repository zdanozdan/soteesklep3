<?php
/**
* @version    $Id: edit.php,v 2.6 2005/11/22 13:26:43 lechu Exp $
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
// $Id: edit.php,v 2.6 2005/11/22 13:26:43 lechu Exp $

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

if (! empty($_REQUEST['available'])) {
    $available=$_REQUEST['available'];
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
$query="SELECT * FROM available WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $rec->data['id']=$db->FetchResult($result,0,"id");
            $rec->data['name']=$db->FetchResult($result,0,"name");
            $rec->data['user_id']=$db->FetchResult($result,0,"user_id");
            $rec->data['num_from']=$db->FetchResult($result,0,"num_from");
            $rec->data['num_to']=$db->FetchResult($result,0,"num_to");
        } else die ("Brak rekordu o id=$id");
    } else die ($db->Error());
} else die ($db->Error());

if ($update==false) {
    // wywolanie wyswietlenia wlasciwosci
    include_once("./html/available_edit.html.php");
} else {
    // update
    $rec->data=$available;
    // sprawdz formularz
    include_once("include/form_check.inc");
    $form_check = new FormCheck;
    $theme->form_check=&$form_check;
    
    $form_check->fun['name']="string";
    $form_check->fun['user_id']="int";
    $form_check->fun['num_from']="string0";
    $form_check->fun['num_to']="string0";
    
    $form_check->form=&$_REQUEST['available'];
    $form_check->errors=$lang->available_edit_form_errors;
    $form_check->check=true;
    
    $theme->bar($lang->available_edit.": ".$rec->data['name']);
    
    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        include_once("./include/update_available.inc.php");
        $theme->status_bar($update_info);
    }
    
    
    // wyswietl formularz z poprawnymi danymi
    include_once("./html/available_edit.html.php");
    
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
