<?php
/**
* G³ówna strone edycji produktu
*
* @author  m@sote.pl
* @version $Id: index.php,v 2.18 2005/01/20 14:59:21 maroslaw Exp $
*
* \@global bool $__edit zapamiêtanie informacji o tym, ¿e edytujemy produkt
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/

$global_database=true;
$global_secure_test=true;
global $DOCUMENT_ROOT, $shop;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}

$__edit=true;

require_once ("../../../include/head.inc");
require_once ("include/currency.inc.php");
require_once ("include/image.inc.php");
require_once ("./include/select_category.inc.php");
require_once ("./include/functions.inc.php");
require_once ("./config/config.inc.php");
require_once ("include/metabase.inc");

$form_elements->type="edit"; // nie pokazuj zaznaczonych elementow select

// inicju ID
$__id=&$id;
if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
} elseif (! empty($_REQUEST['user_id'])) {
    $user_id=$_REQUEST['user_id'];
    $id=$database->sql_select("id","main","user_id=$user_id");
}

$theme->head_window();

if (empty($id)) {
    print "<center>";
    print $lang->edit_errors['unknown_product'];
    $theme->close();
    print "</center>";
    $theme->foot_window();       
    exit;
}

if (! empty($_REQUEST['update'])) {
    $update=true;
} else {
    $update=false;
}



// menu
include_once ("./include/menu.inc.php");
$theme->bar($lang->edit_edit_title);

// aktualizuj dane produktu
$update_info="";
if ($update==true) {
    
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
    
    $form_check->fun['user_id']="null";
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
    
    // sprawdz czy wywolano sprawdzanie danych, czy tylko wyswietlenie formularza
    if (! empty($_REQUEST['update'])) {
        $form_check->check=true;
    }
    
    if ($form_check->check=="true") {
        if ($form_check->form_test()) {
            
            // poprawnie wprowadzone dane, aktualizuj tylko przy edycji
            if (@$__add!=true) {
                require_once ("./include/edit_update_photo.inc.php"); // aktualizuj zdjecia, zalacz zdjecia htdocs/photo
                require_once ("./include/edit_update.inc.php");       // aktualizuj dane produktu
                require_once ("./include/edit_upload_desc.inc.php");  // zalacz plik opisu htdocs/products
            }
            
            $error=$debug->get_errors();
            if (empty($error)) {
                $update_info=str_repeat("<img src=/themes/base/base_theme/_img/b.gif width=5 height=5>",date("s"))." [".date("Y-M-d h:G:s")."] &nbsp; &nbsp; ".$lang->edit_update_ok;
            } else {
                $update_info=$error;
            }
        } else {
            // wyswietl formularz z komunikatami o bledach
            // wstaw dane z formularza do obiektu $rec
            // require_once("./include/request_rec.inc.php");
            $action="index.php";
            require_once("./html/edit_page.html.php");
            
            $theme->foot_window();
            include_once ("include/foot.inc");
            exit;
        }
    } // end if
}


// zapytaj sie o wlasciwosci(atrybuty) produktu
$query="SELECT * FROM main WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            require_once("include/query_rec.inc.php");            
            $theme->status_bar($update_info);
            // $buttons->menu_buttons(array("$lang->edit_add_similar"=>"add.php"));
            $action="index.php";
            require_once("html/edit_page.html.php");
        } else {
            die ($lang->edit_errors['unknown_product']);
        }
    } else die ($db->Error());
} else {
    die ($db->Error());
}


if(@$_REQUEST['tree'] == '1') {
    include_once("include/category_tree.inc.php");
}


$theme->foot_window();
include_once ("include/foot.inc");
?>
