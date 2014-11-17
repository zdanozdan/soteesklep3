<?php
/**
* Edycja newsa.
*
* @author rdiak@sote.pl m@sote.pl
* @version $Id: edit.php,v 2.8 2005/01/20 14:59:56 maroslaw Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");

$__edit=true;

// zmien/ustaw grupe
include_once ("plugins/_newsedit/include/change_group.inc.php");

// odczytaj id rekordu
if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
} elseif (! empty($_POST['id'])) {
    $id=$_POST['id'];
} elseif (! empty($_GET['id'])) {
    $id=$_GET['id'];
}

$id=addslashes($id);

if (! empty($id)) {
    $global_id=$id;
}

// parametr id moze byc przekazany w dodaniu produktu
// tam jest includowany ten plik, po wprowadzeniu nowego rekordu
if (empty($id)) {
    die ("Forbidden");
}

if (! empty($_POST['newsedit'])) {
    $newsedit=$_POST['newsedit'];
}


// usuwanie zdjêæ
if (@$_REQUEST['action']=="delete_photo")
include_once("./include/delete_photo.inc.php");


// naglowek
$theme->head_window();

if (! empty($_POST['update'])) {
    $update=true;
} else {
    $update=false;
}

$action="edit.php";

// odczytaj tresc newsa z bazy
$query="SELECT * FROM newsedit WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            require_once ("./include/select.inc.php");
        } else {
            $theme->back();
            die ("Brak rekordu o id=$id");
        }
    } else die ($db->Error());
} else die ($db->Error());

if ($update==false) {
    // wywolanie wyswietlenia wlasciwosci
    $theme->bar($lang->newsedit_menu['edit']);
    include_once("./html/newsedit_edit.html.php");
} else {
    // update
    $rec->data=$newsedit;
    // przenies dane photo do obiektu $rec, gdyz dane z typow "file" nie sa przekazywane w standardowej tablicy $_POST
    // i trzeba je odczytac z odpowiednich pol z $_FILES
    require_once ("./include/photo2rec.inc.php");
    
    // sprawdz formularz
    include_once("include/form_check.inc");
    $form_check = new FormCheck;
    $theme->form_check=&$form_check;
    
    $form_check->fun['subject']="string";
    
    $form_check->form=&$_POST['newsedit'];
    $form_check->errors=$lang->newsedit_edit_form_errors;
    $form_check->check=true;
    
    $theme->bar($lang->newsedit_menu['edit']);
    
    // start zalacz zdjecia i tresc newsa
    $global_id=$id;
    if (! empty($global_id)) {
        $ftp->connect();
        // wstaw zdjecia, jesli zostaly zalaczone
        require_once ("./include/photo_upload.inc.php");
        // wstaw tresc newsa w postaci pliku html, jesli plik zostal zalaczony
        require_once ("./include/html_upload.inc.php");
        $ftp->close();
    }
    // end
    
    // sprawdzenie poprawnosci wypelnienia formularza
    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        include_once("./include/update_newsedit.inc.php");
        $theme->status_bar($update_info);
    }
    
    // wyswietl formularz z poprawnymi danymi
    include_once("./html/newsedit_edit.html.php");
    
}

$theme->foot_window();

include_once ("include/foot.inc");
?>
