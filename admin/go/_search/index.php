<?php
/**
* 
* @author  m@sote.pl
* @version $Id: index.php,v 2.6 2005/06/02 08:45:28 lechu Exp $
*
* @package    search
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

// odczytaj wyszukiwany ciag znakow
if (! empty($_REQUEST['query_words'])) {
    $query_words=my($_REQUEST['query_words']);
} else  $query_words="";


// add magic quotes
$query_words=ereg_replace(";","\;",$query_words);
$query_words=ereg_replace("'","\'",$query_words);


$sql="SELECT * FROM main WHERE 
              lower(category1) like lower('%$query_words%') OR
              lower(category2) like lower('%$query_words%') OR
              lower(category3) like lower('%$query_words%') OR
              lower(category4) like lower('%$query_words%') OR
              lower(category5) like lower('%$query_words%') OR
              lower(producer)  like lower('%$query_words%') OR
              lower(name_L0)      like lower('%$query_words%') OR
              lower(name_L1)      like lower('%$query_words%') OR
              lower(name_L2)      like lower('%$query_words%') OR
              lower(name_L3)      like lower('%$query_words%') OR
              lower(name_L4)      like lower('%$query_words%') OR
              lower(user_id)   like lower('%$query_words%') OR
              lower(xml_description_L0) like lower('%$query_words%') OR
              lower(xml_description_L1) like lower('%$query_words%') OR
              lower(xml_description_L2) like lower('%$query_words%') OR
              lower(xml_description_L3) like lower('%$query_words%') OR
              lower(xml_description_L4) like lower('%$query_words%') 
              ";

if ((! empty($query_words)) && (! ereg("%",$query_words))) {

    // funkcja prezentujaca wynik zapytania w glownym oknie strony 
    include_once ("include/dbedit_list.inc");
    print "<form action=/go/_delete/index.php method=post name=FormList>";

    // wstaw liste sortowania tabeli main
    include_once ("include/order_main.inc.php");

    $dbedit = new DBEditList;
    $dbedit->title="Wynik wyszukiwania dla: <B><U>$query_words</U></B>";
    $dbedit->start_list_element=$theme->list_th();
    $theme->menu_list();
    $dbedit->show();
    print "</form>";
} else {
    print "<p><center>".$lang->search_empty_query."</center>";;
}
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
