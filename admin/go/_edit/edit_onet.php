<?php
/**
* Edycja parametrów produktu wymaganych do exportu do pasaz.onet.pl
*
* @author  rdiak@sote.pl
* @version $Id: edit_onet.php,v 2.3 2005/01/20 14:59:19 maroslaw Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/

$global_database=true;
$global_secure_test=true;
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
	$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}

require_once ("../../../include/head.inc");
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

if (empty($id)) die ("Forbidden: Unknown ID");

if (! empty($_REQUEST['update'])) {
	$update=true;
} else {
	$update=false;
}

$theme->head_window();
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
	
	//$form_check->fun['onet_export']="int";
	//$form_check->fun['onet_status']="int";
	
	$form_check->form=$_REQUEST['item'];
	$form_check->errors=$lang->onet_form_errors;
	
	// sprawdz czy wywolano sprawdzanie danych, czy tylko wyswietlenie formularza
	if (! empty($_REQUEST['update'])) {
		$form_check->check=true;
	}
	
	if ($form_check->check=="true") {
		if ($form_check->form_test()) {
			// poprawnie wprowadzone dane, aktualizuj tylko przy edycji
			if (@$__add!=true) {
				require_once ("./include/edit_update_onet.inc.php"); // aktualizuj parametrow onet, zalacz zdjecia htdocs/photo
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
			$action="edit_onet.php";
			require_once("./html/edit_onet.html.php");
			
			$theme->foot_window();
			include_once ("include/foot.inc");
			exit;
		}
	}
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
            $action="edit_onet.php";
            require_once("html/edit_onet.html.php");
        } else {
            die ($lang->edit_errors['unknown_product']);
        }
    } else die ($db->Error());
} else {
    die ($db->Error());    
}

$theme->foot_window();
include_once ("include/foot.inc");
?>
