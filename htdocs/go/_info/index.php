<?php
/**
 * Informacja szczegolowa o produkcie
 * 
 * @author m@sote.pl
 * \@modified_by piotrek@sote.pl
 * @version $Id: index.php,v 1.2 2007/05/14 12:00:33 tomasz Exp $ 
* @package    info
 */

$global_database=true;
//$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/image.inc");
require_once ("include/description.inc");
require_once ("themes/include/buttons.inc.php");

// dostepnosc towaru (funkcja wyswietlajaca nformacje o dosteonosci)
require_once ("include/available.inc");

// klasa do encodingu urla
include_once ("include/encodeurl.inc");

// google
$id_uri=$google->getLastURI();
if (! empty($id_uri)) {
    $_REQUEST['id']=$id_uri;
}
// end

// inicjuj obsluge Walut
$shop->currency();

$path = $_SERVER['REQUEST_URI'];

// Najpierw sprawdzamy czy jest to stary format zapytania
// tzn. /go/_info/?id=([0-9]+)
if (ereg("^/go/_info/$",$path))
{
   // sprawdz czy przeslano numer user_id produktu
   // dla mikran.pl robimy 301 redirect dla user_id 
   // �eby zapobiec double content
   $id_regs = "";
   if (! empty($_REQUEST['user_id'])) 
   {
      $user_id=$_REQUEST['user_id'];
      if (ereg("^GT([0-9]+)$",$user_id, $match)) 
      {
         $id_regs = $match[1];
      }
   }

   if (!empty($_REQUEST['id'])) 
   {
      $new_id=$_REQUEST['id'];
      if (ereg("^([0-9]+)$",$new_id, $match))
      {
         $id_regs = $match[1];
      }
   }

   if (strlen($id_regs) > 0)
   {
     $lid = $config->lang_id;

      $q=$db->PrepareQuery("SELECT name_L$lid, id FROM main WHERE id=?");
      $db->QuerySetText($q,1,"$id_regs");
      $retval=$db->ExecuteQuery($q);
      
      if ($retval!=0) 
      {
         $rows=$db->NumberOfRows($retval);
         if ($rows == 1) 
         {
            // produkt odczytany poprawnie
            $name_L0=$db->fetchResult($retval,0,"name_L$lid");

            $enc = new EncodeUrl;
            $rewrite_name = $enc->encode_url_category($name_L0);
            $new_url = '/'.$config->lang."/id".$id_regs."/$rewrite_name";

            Header( "HTTP/1.1 301 Moved Permanently" );
            Header( "Location: $new_url" );
         } 
      } 
      else die ($db->Error());         
   }
}

// odczytaj numer id produktu
$id="";
if (!empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
}

// sprawdz poprawnosc numery ID
// jesli ID nie jest poprawny do robimy 301 na strone glowna
if ((! ereg("^[0-9]+$",$id)) && (empty($user_id))) {
   Header( "HTTP/1.1 301 Moved Permanently" );
   Header( "Location: /" );
   //    die ("Niepoprawny numer ID");
}


if (!empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
} else $item="0";

// sprawdz poprawnosc parametru item
// jesli nie jest poprawny do 301 na strone powiazanego produktu
if (! ereg("^[0-4]$",$item)) {
   if (ereg("^([0-9]+)$",$id, $regs)) 
   {
      $url = "/go/_info/?id=".$regs[1];
      Header( "HTTP/1.1 301 Moved Permanently" );
      Header( "Location: $url" );
   }
   //die ("Forbidden");
}

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//Wiosenna promocja do gazetki
//usunac produkt 9428 z poziomu webowej przegladarki sklepu
//Produkt zosta� dodany do GT, przerzucony do sklepu i usuni�ty z GT
//dlatego taki hack jest potrzebny
//jak si� promocja sko�czy to to usun��
//if($id == '9428')
//{ 
//  $url = "/go/_info/?id=9464";
//  Header( "HTTP/1.1 301 Moved Permanently" );
//  Header( "Location: $url" );
//}

///////////////////////////////////////////////////////////////////////////////

$q_unavailable = '';
if ($config->depository['show_unavailable'] != 1) {
    $q_unavailable = " AND id_available <> " . $config->depository['available_type_to_hide'];
}

if (empty($user_id)) {
    $query = "SELECT * FROM main WHERE id=? AND active='1' $q_unavailable";
} else {
    $query = "SELECT * FROM main WHERE user_id=? AND active='1' $q_unavailable";  
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
       Header( "HTTP/1.1 301 Moved Permanently" );
       Header( "Location: /" );
    }
} else die ($db->Error());

// odczytaj parametry zapytania $rec->data['name'] itp.
$secure_test=true;
include_once("./include/query_rec.inc.php");

// Sprawdzamy czy podana nazwa towaru jest prawidlowa
// jesli nie jest robimy redirecta do prawidlowej nazwy
$urlcheck = new EncodeUrl;
$encoded = $urlcheck->encode_url_category($rec->data['name']);
//print $rec->data['name'];
$regex = "/id[0-9]+/".$encoded."$";

if (ereg($regex,$path) == false)
{
  $new_url = '/'.$config->lang."/id".$rec->data['id']."/$encoded";
  Header( "HTTP/1.1 301 Moved Permanently" );
  Header( "Location: $new_url" );
}

//Sprawdzamy czy lang pasuje. 
//Jesli config->lang = en/de/es itd to przekierowujemy do /en/ czyli prependujemy nazwe langa
$regex = "^/([a-z]{1,2})/id[0-9]+/";
if (ereg($regex,$path,$regs))
  {
    $url_lang = $regs[1];
    if ($config->lang_active[$url_lang])
      {
	if($config->lang != $url_lang)
	  {
	    $_SESSION["global_lang"] = $url_lang;	
	    $_SESSION["global_lang_id"] = array_search($url_lang, $config->langs_symbols);
	    $config->lang=$url_lang;
	    $config->lang_id=array_search($url_lang, $config->langs_symbols);

	    $new_url = "/".$url_lang."/id".$rec->data['id']."/$encoded";	    
	    Header( "HTTP/1.1 301 Moved Permanently" );
	    Header( "Location: $new_url" );
	  }
      }
  }
else
  {
    $new_url = "/".$config->lang."/id".$rec->data['id']."/$encoded";
    //Header( "HTTP/1.1 301 Moved Permanently" );
    Header( "Location: $new_url" );
  }

// dodaj obsluge pola xml_options
include_once ("include/xml_options.inc");

// dodaj obsluge punktow
include_once ("./include/points.inc.php");

// naglowek
//$theme->head();

$theme->page_open("left","record_info","right","","","","page_open");

// stopka
//$theme->foot();
include_once ("include/foot.inc");
?>
