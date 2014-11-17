<?php
/**
 * Wyszukaj produkty, pelne wyszukiwanie wg wyrazenia
 *
 * @param string GET $search_query_words szukany ciag znakow
 * 
 * @author m@sote.pl
 * \@modified_by p@sote.pl (szukaj w nazwie dla kazdego ze slow wyrazenia)
 * @version $Id: full_search.php,v 2.8 2006/05/10 11:05:33 lukasz Exp $
* @package    search
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();

// odczytaj wyszukiwany ciag znakow
if (! empty($_REQUEST['search_query_words'])) {
    $query_words=my($_REQUEST['search_query_words']);
} else  $query_words="";

$lang_id = $config->lang_id;

// add magic quotes
$query_words=ereg_replace(";","\;",$query_words);
$query_words=ereg_replace("'","\'",$query_words);
$query_words=ereg_replace("\*","", $query_words);
$query_words=ereg_replace("%","",  $query_words);
$query_words=htmlentities($query_words);
if ((strlen($query_words)<2) || empty($query_words)) {
    $sql="SELECT id FROM main WHERE 1=2";
} else {
    if ($config->lang!=$config->base_lang) {
        $prefix_lang=$config->lang."_";   
    } else $prefix_lang='';
    
    $sql="SELECT * FROM main WHERE 
              lower(category1) like lower('%$query_words%') OR
              lower(category2) like lower('%$query_words%') OR
              lower(category3) like lower('%$query_words%') OR
              lower(category4) like lower('%$query_words%') OR
              lower(category5) like lower('%$query_words%') OR
              lower(producer)  like lower('%$query_words%') OR
              lower(name_L$lang_id)      like lower('%$query_words%') OR
              lower(user_id)   like lower('%$query_words%') OR
              lower(xml_description_L$lang_id) like lower('%$query_words%') OR";
}

// jezeli wpisano wiecej niz jedno slowo szukaj dla kazdego z nich w nazwie poduktu
$words=split(" ",$query_words);
$count=count($words);

if ($count>1) {
    foreach ($words as $value) {
	$sql.=" lower(name_L$lang_id) like lower('%$value%') AND ";
    }
    
    $sql=ereg_replace("AND $","",$sql);	    
} else {
    $sql=ereg_replace("OR$","",$sql);	    
}

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");

$dbedit = new DBEditList;
$dbedit->title=$lang->bar_title['search'].": $query_words";
$dbedit->empty_list_message=$lang->search_empty_list2;   

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");

// jesli nie ma wynikow to wywolaj skrypt
$__new_search_action="index.php";
$theme->page_open_object("show",$dbedit,"page_open");

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
