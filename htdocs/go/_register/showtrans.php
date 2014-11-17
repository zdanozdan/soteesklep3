<?php
/**
 * Skrypt odpowiedzialny za wyswietlanie informacji o transakcji klienta -
 * klient dostaje w mailu potwierdzajacym link , po kliknieciu ktorego
 * oglada swoja transakcje (id_transakcji)  
 * @param int $trans - zmienna numer transakcji odczytywana z linku klienta 
 * @param int $code - kod identyfikacyjny klienta 
 * 
 * @author  piotrek@sote.pl
 * @version $Id: showtrans.php,v 2.4 2005/01/20 15:00:19 maroslaw Exp $
* @package    register
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");
require_once ("./include/currency.inc.php");
require_once ("include/my_crypt.inc");
require_once ("./include/order_func.inc.php");

//naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

//sprawdzanie czy istnieje zmienna $trans i $code
if ((! empty($_GET['trans']))&&(! empty($_GET['code']))) {
    $id_trans=$_GET['trans'];
    $code=$_GET['code'];
} else {
    // informacja, ze cos nie tak z linkiem 
    $theme->theme_file('_register/trans_error.html.php');
    $theme->page_open_foot("page_open_1_foot");
    $theme->foot();
    
    // wychodzimy z programu
    exit();
}

//sprawdzenie czy zmienna trans jest typu integer
if (ereg("[0-9]",$id_trans)) {
} else { 
     $theme->theme_file('_register/trans_error.html.php');
     $theme->page_open_foot("page_open_1_foot");
     $theme->foot();
     exit();
}

//sprawdzenie czy klient moze wyswietlic swoja transakcje
//suma kontrolna klienta
$client_sign=$code;
//suma kontrolna serwera
$server_sign=md5($id_trans.$config->salt);

if ($client_sign!=$server_sign) {
    //wyswietlenie komunikatu - bledny numer transakcji
    $theme->theme_file('_register/trans_error.html.php');
    $theme->page_open_foot("page_open_1_foot");
    $theme->foot();
    exit();
}

//sprawdzamy czy podany numer transakcji istnieje w bazie
$query="SELECT order_id FROM order_register WHERE order_id=?";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id_trans);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        //sprawdzenie ile istnieje rekordow
        $num_rows=$db->NumberOfRows($result);
        //jesli nie dostaniemy rekordu
        if ($num_rows==0) {
            // wyswietl informacje: nie ma takiej transakcji w bazie danych
            $theme->theme_file('_register/trans_error1.html.php');
            $theme->page_open_foot("page_open_1_foot");
            $theme->foot();
            exit();
        }
        
    } else die ($db->Error());
} else die ($db->Error());


// odczytaj dane transakcji o identyfikatorze $id_trans
$query="SELECT * FROM order_register WHERE order_id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id_trans);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            // odczytaj wlasciwosci transakcji
            require_once("./include/query_rec.inc.php");            
        } else die ("Bledne wywolanie");        
    } else die ($db->Error());
} else die ($db->Error());

// odkoduj zakodowane dane
$my_crypt = new MyCrypt;

$rec->data['xml_description']=$my_crypt->endecrypt("",$rec->data['crypt_xml_description'],"de");

require_once("./include/xml2html.inc.php");
$xml2html = new OrderXML2HTML;

$rec->data['html_xml_description']=$xml2html->xml_description($rec->data['xml_description']);

// odczytaj nazwe dostawcy
$query="SELECT id,name FROM delivery WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$rec->data['id_delivery']);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $rec->data['delivery_name']=$db->FetchResult($result,0,"name");
        } else $rec->data['delivery_name']="-";
    } else die ($db->Error());
} else die ($db->Error());
    

//naglowek Moje transakcje
$theme->bar($lang->bar_title["trans_products"]." ".$rec->data['order_id']);
print "<BR>";
$theme->trans_product($rec);
$theme->page_open_foot("page_open_1_foot");
$theme->foot();

include_once ("include/foot.inc");

?>
