<?php
/**
* Edycja parametrów produktu wymaganych do exportu do pasaz.ceneo.pl
*
* @author  rdiak@sote.pl
* @version $Id: edit_ceneo.php,v 2.1 2006/01/06 12:58:46 scalak Exp $
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
include_once ("config/auto_config/ceneo_config.inc.php");

$form_elements->type="edit"; // nie pokazuj zaznaczonych elementow select
// inicju ID
$__id=&$id;
if (! empty($_REQUEST['id'])) {
	$id=$_REQUEST['id'];
	$user_id=$database->sql_select("user_id","main","id=$id");
	$_REQUEST['user_id']=$user_id;
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
	
	//$form_check->fun['ceneo_export']="int";
	//$form_check->fun['ceneo_status']="int";
	
	$form_check->form=$_REQUEST['item'];
	$form_check->errors=$lang->ceneo_form_errors;
	
	// sprawdz czy wywolano sprawdzanie danych, czy tylko wyswietlenie formularza
	if (! empty($_REQUEST['update'])) {
		$form_check->check=true;
	}
	
	if ($form_check->check=="true") {
		if ($form_check->form_test()) {
			// poprawnie ceneorowadzone dane, aktualizuj tylko przy edycji
			if (@$__add!=true) {
				require_once ("./include/edit_update_ceneo.inc.php"); // aktualizuj parametrow ceneo, zalacz zdjecia htdocs/photo
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
			$action="edit_ceneo.php";
			require_once("./html/edit_ceneo.html.php");
			
			$theme->foot_window();
			include_once ("include/foot.inc");
			exit;
		}
	}
}

// zapytaj sie o wlasciwosci(atrybuty) produktu
$query="SELECT * FROM main_param WHERE user_id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$user_id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            require_once("include/query_rec_ceneo.inc.php");
            $theme->status_bar($update_info);
            $action="edit_ceneo.php";
            require_once("html/edit_ceneo.html.php");
        } else {
            $theme->status_bar($update_info);
            $action="edit_ceneo.php";
            require_once("html/edit_ceneo.html.php");
        }
    } else die ($db->Error());
} else {
    die ($db->Error());    
}

$theme->foot_window();
include_once ("include/foot.inc");
?>
