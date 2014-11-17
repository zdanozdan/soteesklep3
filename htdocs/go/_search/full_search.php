<?php
/**
 * Wyszukaj produkty, pelne wyszukiwanie wg wyrazenia
 *
 * @param string GET $search_query_words szukany ciag znakow
 * 
 * @author m@sote.pl
 * \@modified_by p@sote.pl (szukaj w nazwie dla kazdego ze slow wyrazenia)
 * @version $Id: full_search.php,v 2.9 2006/06/05 11:15:45 lukasz Exp $
* @package    search
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();

$query_words="";

// odczytaj wyszukiwany ciag znakow
if (! empty($_REQUEST['search_query_words'])) {
    $query_words=my($_REQUEST['search_query_words']);
}

if (! empty($_REQUEST['search_item_id'])) {
    $query_words=my($_REQUEST['search_item_id']);
}

$lang_id = $config->lang_id;

// add magic quotes
$query_words=ereg_replace(";","\;",$query_words);
$query_words=ereg_replace("'","\'",$query_words);
$query_words=ereg_replace("\*","", $query_words);
$query_words=ereg_replace("%","",  $query_words);
$query_words=htmlspecialchars($query_words);
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

$mikran_codes=array();
$mikran_id_match = false;
if(preg_match('/^([0-9]+)$/',$query_words,$r) or preg_match('/^mik[_-]([0-9]+)$/',$query_words,$r) or preg_match('/^mik([0-9]+)$/',$query_words,$r))
{
  if (strlen($r[1]) <= 5)
    {
      $mikran_id_match = true;
      /**
       * Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
       * Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
       */ 
      class RecordRowMikran {
        function record($result,$i) {
	  global $db;
	  global $mikran_codes;
	  $mikran_codes[]=$db->FetchResult($result,$i,"gid");
	  return;
	}
      }

      $dbedit = new DBEdit;
      $dbedit->record_class = 'RecordRowMikran';
      $dbedit->empty_list_message = "";
      $dbedit->record_list(sprintf("SELECT * FROM mikran_codes where id=%d",$r[1]));
      $codes_sql = '';
      foreach($mikran_codes as $code)
	{
	  $codes_sql.=','.$code;
	}
 
      $sql = sprintf("select * from main where id in(%d%s)", $r[1],$codes_sql);
    }
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

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");

// jesli nie ma wynikow to wywolaj skrypt
$__new_search_action="index.php";
$theme->page_open_object("show",$dbedit,"page_open");

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
