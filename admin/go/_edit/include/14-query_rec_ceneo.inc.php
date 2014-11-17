<?php
/**
* Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
*
* @author  m@sote.pl
* @version $Id: query_rec_ceneo.inc.php,v 2.1 2006/01/06 12:58:47 scalak Exp $
*
* \@global object $result           wynik zapytania SQL o wlasciwosci produktu
* \@global string $_REQUEST['lang'] jêzyk, dla którego jest definiowany opis itp.
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ($global_secure_test!=true) {
    die ("Forbidden");
}

require_once ("include/price.inc");
$my_price = new MyPrice;

class RecordData {
    var $data=array();
}

global $rec;
$rec =& new RecordData;

$i=0;
$rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
$rec->data['ceneo_export']=$db->FetchResult($result,$i,"ceneo_export");
$rec->data['ceneo_attrib']=$db->FetchResult($result,$i,"ceneo_attrib");
$rec->data['ceneo_autor']=$db->FetchResult($result,$i,"ceneo_autor");
$rec->data['ceneo_isbn']=$db->FetchResult($result,$i,"ceneo_isbn");
$rec->data['ceneo_page']=$db->FetchResult($result,$i,"ceneo_page");
$rec->data['ceneo_publisher']=$db->FetchResult($result,$i,"ceneo_publisher");
$rec->data['ceneo_producer']=$db->FetchResult($result,$i,"ceneo_producer");
$rec->data['ceneo_size']=$db->FetchResult($result,$i,"ceneo_size");
$rec->data['ceneo_rozstaw']=$db->FetchResult($result,$i,"ceneo_rozstaw");
$rec->data['ceneo_odsadzenie']=$db->FetchResult($result,$i,"ceneo_odsadzenie");
$rec->data['ceneo_rezyser']=$db->FetchResult($result,$i,'ceneo_rezyser');
$rec->data['ceneo_obsada']=$db->FetchResult($result,$i,'ceneo_obsada');
$rec->data['ceneo_nosnik']=$db->FetchResult($result,$i,'ceneo_nosnik');
$rec->data['ceneo_tytul_org']=$db->FetchResult($result,$i,'ceneo_tytul_org');
$rec->data['ceneo_opony_producent']=$db->FetchResult($result,$i,'ceneo_opony_producent');
$rec->data['ceneo_opony_model']=$db->FetchResult($result,$i,'ceneo_opony_model');
$rec->data['ceneo_opony_szerokosc']=$db->FetchResult($result,$i,'ceneo_opony_szerokosc');
$rec->data['ceneo_opony_profil']=$db->FetchResult($result,$i,'ceneo_opony_profil');
$rec->data['ceneo_opony_srednica']=$db->FetchResult($result,$i,'ceneo_opony_srednica');
$rec->data['ceneo_opony_predkosc']=$db->FetchResult($result,$i,'ceneo_opony_predkosc');
$rec->data['ceneo_opony_nosnosc']=$db->FetchResult($result,$i,'ceneo_opony_nosnosc');
$rec->data['ceneo_opony_sezon']=$db->FetchResult($result,$i,'ceneo_opony_sezon');
$rec->data['ceneo_opony_typ']=$db->FetchResult($result,$i,'ceneo_opony_typ');
$rec->data['ceneo_perfumy_producent']=$db->FetchResult($result,$i,'ceneo_perfumy_producent');
$rec->data['ceneo_perfumy_model']=$db->FetchResult($result,$i,'ceneo_perfumy_model');
$rec->data['ceneo_perfumy_rodzaj']=$db->FetchResult($result,$i,'ceneo_perfumy_rodzaj');
$rec->data['ceneo_perfumy_pojemnosc']=$db->FetchResult($result,$i,'ceneo_perfumy_pojemnosc');
?>
