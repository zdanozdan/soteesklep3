<?php
/**
* Dodanie nowego produktu
*
* @author  m@sote.pl
* @version $Id: add.php,v 2.12 2005/01/20 14:59:19 maroslaw Exp $
*
* \@global bool $__add zapamiêtanie informacji o tym, ¿e produkt jest dodawany
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/currency.inc.php");
require_once ("include/image.inc.php");
require_once ("./include/select_category.inc.php");
require_once ("./include/functions.inc.php");
require_once ("./config/config.inc.php");
require_once ("include/metabase.inc");
require_once ("include/id.inc.php");

// zapamietaj informacja, ze produkt jest dodawany
$__add=true;

$theme->head_window();

if (! empty($_REQUEST['update'])) {
    $update=true;
} else {
    $update=false;
}

if ($update==false) {
    $theme->bar($lang->edit_record_add_title);
    $action="add.php";
    $default_user_id=$id->new_main_user_id();
    require_once("./html/edit_page.html.php");
} else {
    // obsluga sprawdzania formularzy
    require_once("./include/my_form_check.inc.php");
    
    $form_check = new MyFormCheck;
    $theme->form_check=&$form_check;
    
    // odczytaj wartosci wszystkich kategorii, dane ta sa potrzebne do porawnego sprawdzenia
    // danych kategorii w formularzu
    $form_check->category[1]=$_REQUEST['item']['category1'];
    $form_check->category[2]=$_REQUEST['item']['category2'];
    $form_check->category[3]=$_REQUEST['item']['category3'];
    $form_check->category[4]=$_REQUEST['item']['category4'];
    $form_check->category[5]=$_REQUEST['item']['category5'];
    
    $form_check->fun['user_id']="user_id";
    $form_check->fun['name']="string";
    $form_check->fun['price_brutto']="null";
    $form_check->fun['price_currency']="null";
    $form_check->fun['category1']="category1";
    $form_check->fun['category2']="category2";
    $form_check->fun['category3']="category3";
    $form_check->fun['category4']="category4";
    $form_check->fun['category5']="category5";
    
    $form_check->form=$_REQUEST['item'];
    $form_check->errors=$lang->edit_add_form_errors;
    
    // sprawdz czy wywolano sprawdzanie danych, czy tylko wyswietlenie formularza
    if (! empty($_REQUEST['update'])) {
        $form_check->check=true;
    }
    
    if ($form_check->check=="true") {
        if ($form_check->form_test()) {
            // poprawnie wprowadzone dane
            // sprwadz nccp
            require_once("./include/add_nccp.inc.php");
            
            // dodaj rekord, odczytaj $id dodanego rekordu
            include_once ("./include/edit_insert.inc.php");
            
            require_once ("./include/edit_update_photo.inc.php"); // aktualizuj zdjecia, zalacz zdjecia htdocs/photo
            
            // do wywolania przekazywana jest zmienna $id
            include_once("./index.php");
            exit;
            
        } else {
            $theme->bar($lang->record_add);
            // wyswietl formularz z komunikatami o bledach
            $action="add.php";
            // wstaw dane z formularza do obiektu $rec
            //include_once("./include/request_rec.inc.php");
            $rec->data=$_REQUEST['item'];
            require_once("./html/edit_page.html.php");
        }
    }
    
}

$theme->foot_window();
include_once ("include/foot.inc");
?>
