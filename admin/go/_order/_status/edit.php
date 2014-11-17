<?php
/**
* Edycja wybranego statusu transakcji.
*
* @author  m@sote.pl
* @version $Id: edit.php,v 2.7 2005/01/20 14:59:36 maroslaw Exp $
* @package    order
* @subpackage status
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../../include/head.inc");

if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
}

$__edit=true;

// parametr id moze byc przekazany w dodaniu produktu
// tam jest includowany ten plik, po wprowadzeniu nowego rekordu
if (empty($id)) {
    die ("Forbidden: ID");   
}

if (! empty($_REQUEST['order_status'])) {
    $order_status=$_REQUEST['order_status'];
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
$query="SELECT * FROM order_status WHERE id=?";
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
            $rec->data['send_mail']=$db->FetchResult($result,0,"send_mail");
            $rec->data['mail_title']=$db->FetchResult($result,0,"mail_title");
            $rec->data['mail_content']=$db->FetchResult($result,0,"mail_content");
        } else die ("Error: Unknown record ID=$id");        
    } else die ($db->Error());
} else die ($db->Error());

if ($update==false) {
    /**
    * Wy¶wietl formularz edycji statusu transakcji.
    */
    include_once("./html/edit.html.php");
} else {
    // update
    $rec->data=$order_status;
    // sprawdz formularz
    include_once("./include/form_check_functions.inc.php");
    $form_check = new FormCheckFunctions;
    $theme->form_check=&$form_check;

    $form_check->fun['name']="string";
    $form_check->fun['user_id']="null";
    
    $form_check->form=&$_REQUEST['order_status'];
    $form_check->errors=$lang->order_status_edit_form_errors;    
    $form_check->check=true;

    $theme->bar($lang->order_status_edit.": ".$rec->data['name']);

    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        include_once("./include/update_order_status.inc.php");   
        $theme->status_bar($update_info);     
    } 
        
    /**
    * Wy¶wietl formularz edycji statusu transakcji.
    */
    include_once("./html/edit.html.php");
    
}
 
$theme->foot_window();
include_once ("include/foot.inc");
?>
