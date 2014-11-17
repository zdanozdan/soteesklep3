<?php
/** 
 * Copyright (c) 1999-2004 SOTE www.sote.pl                             
 *
 * SOTEeSKLEP - program do prowadzenia sklepu internetowego. 
 * Program objety jest licencja SOTE.                                           
 *
 * Niniejszy plik odpowiada wywolaniu glownej strony sklepu.            
 *
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 2.24 2006/04/07 09:39:43 scalak Exp $
 * @package    default
 */

if (! empty($_REQUEST['id']) && ! empty($_REQUEST['recom_code']) && ! empty($_REQUEST['recom_product']) && ! empty($_REQUEST['recom_user']) && ! empty($_REQUEST['recom_t']) ) {
	
	header ("Location: http://".$HTTP_SERVER_VARS['HTTP_HOST']."/go/_info/?user_id=".$_REQUEST['id']."&recom_code=".$_REQUEST['recom_code']."&recom_product=".$_REQUEST['recom_product']."&recom_user=".$_REQUEST['recom_user']."&recom_t=".$_REQUEST['recom_t']);
}
// przekierowanie na info o produkcie (jesli przekazano w glownym wywolaniu parametr 'id')
elseif (! empty($_REQUEST['id'])) {
    header ("Location: http://".$HTTP_SERVER_VARS['HTTP_HOST']."/go/_info/?user_id=".$_REQUEST['id']."&partner_id=".$_REQUEST['partner_id']."&code=".$_REQUEST['code']);
}


// generuj Last-Modified na wczoraj w formacie Last-Modified: Tue, 15 Nov 1994 12:45:26 GMT
//header ("Last-Modified: ".date("D, d M Y h:i:m",(time())-(3600*24))." GMT");

// informacja o wywolaniu glownej strony
$__start_page=true;

$global_database=true;
$global_secure_test=true;
//$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

include_once ("../include/head.inc");

// naglowek
$theme->head();

// zapytanie o produkty, ktore maja sie znalzc na 1 stronie
global $config;
$q_unavailable = '';
if ($config->depository['show_unavailable'] != 1) {
    $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
}

$sql = "SELECT * FROM main WHERE main_page='1' $q_unavailable";


// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
$dbedit = new DBEditList;
$dbedit->top_links="false";     // nie pokazuj linkow do podstron
$dbedit->top_dbedit_show=false; // nie pokazuj dodatkwoych likow w nalowku listy

// wywolaj funkcje przed wyswietleniem glownej zawartosci "main" (po tytule)
$theme->before_main_obj=&$theme;
$theme->before_main_func="main_html";

// funkcja wywolana po zaladowaniu rekordow ze strony glownej "main" (po liscie rekordow)
$theme->after_main_obj=&$theme;
$theme->after_main_func="mainBottom";
// wykonaj procedure wyswietlania strony glownej "main"
$theme->page_open_object("show",$dbedit,"page_open");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
