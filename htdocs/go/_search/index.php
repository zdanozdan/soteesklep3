<?php
/**
* Wyszukaj produkty
*
* @param string GET $search_query_words szukany ciag znakow
*
* @author m@sote.pl
* @version $Id: index.php,v 2.8 2005/03/15 10:47:23 lechu Exp $
* @package    search
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$lang_id = $config->lang_id;

// odczytaj wyszukiwany ciag znakow
if (! empty($_REQUEST['search_query_words'])) {
    $query_words=my($_REQUEST['search_query_words']);
} else  $query_words="";


// add magic quotes
$query_words=ereg_replace(";","\;",$query_words);
$query_words=ereg_replace("'","\'",$query_words);
$query_words=ereg_replace("\*","",$query_words);

if ($config->lang!=$config->base_lang) {
    $prefix_lang=$config->lang."_";
} else $prefix_lang='';

// start: zapytanie FULLTEXT SEARCH dla MySQL
// wymagana opcja rowznowazna z "ALTER TABLE main ADD FULLTEXT (xml_description, xml_short_description);"
$sql="SELECT *,MATCH (xml_description_L$lang_id,xml_short_description_L$lang_id) AGAINST ('$query_words') AS SCORE FROM main
      WHERE MATCH (xml_description_L$lang_id,xml_short_description_L$lang_id) AGAINST ('$query_words')";
$__order_main="SCORE";
$__order_main_score=true; // informacja ze w wynikach jest kolumna SCORE z dopasowaniem wynikow
// end:


// funkcja prezentujaca wynik zapytania w glownym oknie strony
include_once ("include/dbedit_list.inc");

$dbedit = new DBEditList;
$dbedit->title=$lang->bar_title['search'].": $query_words";
$dbedit->empty_list_message="";                                // nie wyswietlaj komunikatu o braku wynikow z zapyatnia SQL

// funkcja prezentujaca wynik zapytania w glownym oknie strony
include_once ("include/dbedit_list.inc");

// jesli nie ma wynikow to wywolaj skrypt
$__new_search_action="full_search.php";
$theme->page_open_object("show",$dbedit,"page_open");

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
