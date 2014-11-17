<?php
/**
 * PHP base project
 * 
 * Przykladowa konstrukcja schematu projektu opartego na PHP&PEAR
 * 
* @version    $Id: index.php,v 1.3 2007/05/14 11:59:50 tomasz Exp $
* @package    category
 */
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");
// dostepnosc towaru (funkcja wyswietlajaca nformacje o dosteonosci)
require_once ("include/available.inc");

// klasa do encodingu urla
include_once ("include/encodeurl.inc");

// google
$id_uri=$google->getLastURI();
if (! empty($id_uri)) {
    $_REQUEST['idc']=$id_uri;    
}
// end

// odczytaj id wybranych kategorii i podkategorii
$idc="";
if (! empty($_REQUEST['idc'])) {
    $idc=$_REQUEST['idc'];
} 
$cidc="";
if (! empty($_REQUEST['cidc'])) {
    $idc=$_REQUEST['cidc'];
}  
if ((empty($idc)) && (! empty($cidc))) {
    $idc=$cidc;
}

//zapamietaj numer strony jesli podany w wywolaniu
$page = 0;
if (! empty($_REQUEST['page'])) {
    $page=$_REQUEST['page'];
}  

//Sprawdzamy czy nazwa linka jest zgodna z biezaca nazwa kategorii
$cat_name = "";
// Nastepnie sprawdzamy czy jest wywo³anie wewnêtrzne

if (ereg("([0-9]+)$",$idc, $match))
{
   $expl = explode("_",$idc);
   $cat_id = $match[1];
   
   $results=count($expl);
   if (strcmp($expl[0],"id") == 0)
   {
      $results = $results - 1;
   }
   
   $q=$db->PrepareQuery("SELECT category$results FROM category$results WHERE id=?");
   $db->QuerySetText($q,1,"$cat_id");
   $retval=$db->ExecuteQuery($q);
   
   if ($retval!=0) 
   {
      $rows=$db->NumberOfRows($retval);
      if ($rows == 1) 
      {
         // produkt odczytany poprawnie
         $cat_name=$db->fetchResult($retval,0,"category$results");
         
         $enc = new EncodeUrl;
         $cat_name = $enc->encode_url_category($cat_name);
      }
   }
}

$idc_name = "";
if (! empty($_REQUEST['idc'])) {
   $idc_name="idc";
} 
else
{
   $idc_name="cidc";
}

   
// Najpierw sprawdzamy czy jest to stary format zapytania
// tzn. /go/_category/
if (ereg("^/go/_category/$",$_SERVER['SCRIPT_URL']))
{
   if (!ereg("producer_id", $_SERVER['REQUEST_URI']) &&
       !ereg("record_row", $_SERVER['REQUEST_URI']) && 
       !ereg("order", $_SERVER['REQUEST_URI']) )
    //   !ereg("page", $_SERVER['REQUEST_URI']) )
   {
        //$url_cat="/$idc_name/$idc/$cat_name";

        if(preg_match('/page=([2-9]+)/',$_SERVER['REQUEST_URI'],$matches))
	{
		$url_cat="/$idc_name/$idc/$cat_name/page/$matches[1]";
	}
	else
	{
      		$url_cat="/$idc_name/$idc/$cat_name";
	}
      
      Header( "HTTP/1.1 301 Moved Permanently" );
      Header( "Location: $url_cat" );
   }
}
else
{
   // Sprawdzamy czy podana nazwa kategorii jest prawidlowa
   // jesli nie jest robimy redirecta do prawidlowej nazwy
   if ($page > 1 && preg_match("/\/$cat_name\/page\/$page$/",$_SERVER['SCRIPT_URL']) == false)
   {
	$url_cat="/$idc_name/$idc/$cat_name/page/$page";
        Header( "HTTP/1.1 301 Moved Permanently" );
        Header( "Location: $url_cat" );
   }
   if (($page == 0 || $page == 1) && preg_match("/\/$cat_name$/",$_SERVER['SCRIPT_URL']) == false)
   {
      $url_cat="/$idc_name/$idc/$cat_name";
      Header( "HTTP/1.1 301 Moved Permanently" );
      Header( "Location: $url_cat" );
   }
}

// usun znaki " z wywolanie np. z wywolania idc="id_18" wygeneruj id_18
// znaki " w parametrach sa wymagane przez Treeview
$idc=ereg_replace("\"","",$idc);

// odczytaj id filtru producenta
if (! empty($_REQUEST['producer_filter'])) {
   $producer_id=$_REQUEST['producer_filter'];
   $__producer_filter;
} elseif (! empty($_SESSION['__producer_filter'])) {
   $producer_id=$_SESSION['__producer_filter'];
} else $producer_id='';


// odczytaj id producenta
if (! empty($_REQUEST['producer_id'])) {
    $producer_id=$_REQUEST['producer_id'];
}
if (! ereg("^[0-9]+$",$producer_id)) {
    $producer_id='';
}

// zapamietaj parametr przekazany jako GET
$__get_idc=$idc;

// sprawdz czy wybrano koncowa kategorie (element menu), czy element bedacy submenu
$sub_menu_prefix=substr($idc,0,2);
if ($sub_menu_prefix=="id") {
    $sub_menu=true;    
    $idc=substr($idc,3,strlen($idc)-3);
} else {
    $sub_menu=false;
}

// rozdziel elementy (id) kategorii
$tab_idc=split("_",$idc,5);
$size_tab_idc=sizeof($tab_idc);

// generuj tablice array("1"=>"2","2"=>"3",...)
// id_category1=2 id_category2=3, ...
$category_tab=array();
for ($i=0; $i<$size_tab_idc; $i++) {
    $ic=$i+1;
    $category_tab[$ic]=$tab_idc[$i];
}

include_once ("./include/category_path.inc.php");      // sciezka kategorii
if (in_array("producer_list",$config->plugins)) {
    include_once ("./include/producers.inc.php");      // lista producentow w danej kategorii
}
// wybor sortowania
if (in_array("order_by_list",$config->plugins)) {
    require_once ("include/order_by_list.inc");
}

// generuj zapytanie SQL na podstawie przekazanych kategorii
require_once ("include/gen_sql.inc.php");
$sql = $category_sql->query($category_tab,$producer_id,$idc);

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
$dbedit = new DBEditList;
$dbedit->title="$global_category_path";

// naglowek
$cat_lang = $lang->cols['category'];
$mik = $lang->mikran_shop;
$config->google['title'] = "$mik - $cat_lang: $global_category_path";
if($page > 0) $config->google['title'] .= ", wyniki ze strony: $page";
$config->google['description'] = "$cat_lang: $global_category_path";
if($page > 0) $config->google['description'] .= ". Wyniki ze strony $page";
$config->google['keywords'] = "$global_category_path";
$theme->head();

$theme->page_open_object("show",$dbedit,"page_open");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
