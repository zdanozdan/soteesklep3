<?php
/**
* Dodaj nowy status transakcji.
*
* @author  m@sote.pl
* @version $Id: add.php,v 2.5 2005/01/20 14:59:36 maroslaw Exp $
* @package    order
* @subpackage status
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu
*/
require_once ("../../../../include/head.inc");

if (! empty($_REQUEST['order_status'])) {
    $order_status=$_REQUEST['order_status'];
}

// naglowek
$theme->head_window();

$theme->bar($lang->order_status_add_bar);

if (! empty($_REQUEST['update'])) {
    $update=true;
} else {
    $update=false;
}

$action="add.php";
if ($update==false) {
    /**
    * Wy¶wietl formularz edycji statusu transakcji.
    */
    include_once("./html/edit.html.php");
} else {
    // insert
    
    // sprawdz formularz
    include_once("./include/form_check_functions.inc.php");
    $form_check = new FormCheckFunctions;
    $theme->form_check=&$form_check;
    
    $form_check->fun['name']="string";
    $form_check->fun['user_id']="user_id";
    
    
    $form_check->form=&$_REQUEST['order_status'];
    $form_check->errors=$lang->order_status_edit_form_errors;
    $form_check->check=true;
    
    $rec->data=$order_status;
    
    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        include_once("./include/insert_order_status.inc.php");
        $theme->status_bar($insert_info);
        $action="edit.php";
        
        /**
        * Wy¶wietl formularz edycji statusu transakcji.
        */
        include_once("./html/edit.html.php");
        exit;
    } else {
        
        /**
        * Wy¶wietl formularz edycji statusu transakcji.
        */
        include_once("./html/edit.html.php");
    }
    
}

$theme->foot_window();
include_once ("include/foot.inc");
?>
