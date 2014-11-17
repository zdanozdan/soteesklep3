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
 * @version $Id: google.php,v 1.1 2007/04/16 15:56:27 tomasz Exp $
 * @package    default
 */


// przekierowanie na info o produkcie (jesli przekazano w glownym wywolaniu parametr 'id')
if (! empty($_REQUEST['id'])) {
    header ("Location: http://".$HTTP_SERVER_VARS['HTTP_HOST']."/go/_info/?user_id=".$_REQUEST['id']."&partner_id=".$_REQUEST['partner_id']."&code=".$_REQUEST['code']);
}

// generuj Last-Modified na wczoraj w formacie Last-Modified: Tue, 15 Nov 1994 12:45:26 GMT
header ("Last-Modified: ".date("D, d M Y h:i:m",(time())-(3600*24))." GMT");

// informacja o wywolaniu glownej strony
$__start_page=true;

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../include/head.inc");

$config->theme="google";
$config->theme_dir();

// naglowek
//$theme->head();

// zapytanie o produkty, ktore maja sie znalzc na 1 stronie
//$sql = "SELECT * FROM main WHERE main_page='1'";

$sql = "SELECT * FROM main where active = '1'";
$result=$db->Query($sql);
if ($result==0) {
    $db->Error();
}


// funkcja prezentujaca wynik zapytania w glownym oknie strony
include_once ("include/sitemap_list.inc");
$sitemap = new DBSiteMapList;
//$dbedit->title=$lang->bar_title['Mapa strony'];
//$sitemap->title='Mapa strony';

// wywolaj funkcje przed wyswietleniem glownej zawartosci "main" (po tytule)
$theme->before_main_obj=&$theme;
$theme->before_main_func="main_html";

// funkcja wywolana po zaladowaniu rekordow ze strony glownej "main" (po liscie rekordow)
$theme->after_main_obj=&$theme;
$theme->after_main_func="mainBottom";


$theme->page_open_object("show",$sitemap,"page_open_sitemap");


// stopka
//$theme->foot();
//include_once ("include/foot.inc");
?>
