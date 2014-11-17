<?php
/**
* Dodaj nowego newsa.
*
* @author  rdiak@sote.pl m@sote.pl
* @version $Id: add.php,v 2.6 2005/01/20 14:59:56 maroslaw Exp $
*
* \@verified 2004-03-19 m@sote.pl
* @package    newsedit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");

if (! empty($_POST['newsedit'])) {
    $newsedit=$_POST['newsedit'];
}

// zmien/ustaw grupe
include_once ("plugins/_newsedit/include/change_group.inc.php");

// naglowek
$theme->head_window();
$theme->bar($lang->newsedit_add_bar);

if (! empty($_POST['update'])) {
    $update=true;
} else {
    $update=false;
}
$action="add.php";
if ($update==false) {
    // wywolanie wyswietlenia wlasciwosci
    include_once("./html/newsedit_edit.html.php");
} else {
    // insert
    
    // sprawdz formularz
    include_once("include/form_check.inc");
    $form_check = new FormCheck;
    $theme->form_check=&$form_check;
    
    $form_check->fun['subject']="string";
    $form_check->form=&$_POST['newsedit'];
    $form_check->errors=$lang->newsedit_edit_form_errors;
    $form_check->check=true;
    
    $rec->data=$newsedit;
    if ($form_check->form_test()) {
        // poprawnie wypelniony formularz
        
        // przekaz parametry z formularza do tablicy $rec->data
        $rec->data=&$newsedit;
        // przenies dane photo do obiektu $rec, gdyz dane z typow "file" nie sa przekazywane w standardowej tablicy $_POST
        // i trzeba je odczytac z odpowiednich pol z $_FILES
        require_once ("./include/photo2rec.inc.php");
        
        include_once("./include/insert_newsedit.inc.php");
        if (! empty($global_id)) {
            $ftp->connect();
            // wstaw zdjecia, jesli zostaly zalaczone
            require_once ("./include/photo_upload.inc.php");
            // wstaw plik index.php wywolujacy news do utowrzonego katalogu newsa
            require_once ("./include/copy_index.inc.php");
            // wstaw tresc newsa w postaci pliku html, jesli plik zostal zalaczony
            require_once ("./include/html_upload.inc.php");
            $ftp->close();
        }
        $theme->status_bar($insert_info);
        $action="edit.php";
        // wyswietl formularz z poprawnymi danymi
        include_once("./html/newsedit_edit.html.php");
        exit;
    } else {
        // wyswietl formularz z poprawnymi danymi
        include_once("./html/newsedit_edit.html.php");
    }
    
}
$theme->foot_window();

include_once ("include/foot.inc");
?>
