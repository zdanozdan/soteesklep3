<?php
/**
 * Informacja szczegolowa o produkcie
 * 
 * @author m@sote.pl
 * \@modified_by piotrek@sote.pl
 * @version $Id: print.php,v 2.1 2005/08/08 14:21:42 maroslaw Exp $ 
* @package    info
 */
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/image.inc");
require_once ("include/description.inc");
require_once ("themes/include/buttons.inc.php");


// dostepnosc towaru (funkcja wyswietlajaca nformacje o dosteonosci)
require_once ("include/available.inc");

// google
$id_uri=$google->getLastURI();
if (! empty($id_uri)) {
    $_REQUEST['id']=$id_uri;
}
// end

// inicjuj obsluge Walut
$shop->currency();

// sprawdz czy przeslano numer user_id produktu
if (! empty($_REQUEST['user_id'])) {
    $user_id=$_REQUEST['user_id'];
} else $user_id='';

// odczytaj numer id produktu
$id="";
if (!empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
}

// sprawdz poprawnosc numery ID
if ((! ereg("^[0-9]+$",$id)) && (empty($user_id))) {
    die ("Niepoprawny numer ID");
}

if (!empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item="0";

// sprawdz poprawnosc parametru item
if (! ereg("^[0-4]$",$item)) {
    die ("Forbidden");
}

if (empty($user_id)) {
    $query = "SELECT * FROM main WHERE id=? AND active='1'";
} else {
    $query = "SELECT * FROM main WHERE user_id=? AND active='1'";  
}

$prepared_query=$db->PrepareQuery($query);
if (empty($user_id)) {
    $db->QuerySetText($prepared_query,1,"$id");
} else {
    $db->QuerySetText($prepared_query,1,"$user_id");    
}
$result=$db->ExecuteQuery($prepared_query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) {
        // produkt odczytany poprawnie
    } else {
        $theme->go2main();
        exit;	
    }
} else die ($db->Error());

// odczytaj parametry zapytania $rec->data['name'] itp.
$secure_test=true;
include_once("./include/query_rec.inc.php");

// dodaj obsluge pola xml_options
include_once ("include/xml_options.inc");

// naglowek

$config->theme="print";
$config->theme_dir();
$theme->head();

$theme->page_open("","record_info","right","","","","page_open_2");

// stopka
//$theme->foot();
include_once ("include/foot.inc");
?>
