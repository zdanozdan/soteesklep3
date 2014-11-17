<?php
/**
* Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
*
* @author  m@sote.pl
* @version $Id: query_rec.inc.php,v 2.28 2006/01/23 14:49:44 scalak Exp $
*
* \@global object $result           wynik zapytania SQL o wlasciwosci produktu
* \@global string $_REQUEST['lang'] jêzyk, dla którego jest definiowany opis itp.
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
* \@lang
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

global $rec, $mdbd;
$rec =& new RecordData;

$i=0;
$rec->data['id']=$db->FetchResult($result,$i,"id");
$rec->data['user_id']=$db->FetchResult($result,$i,"user_id");
$rec->data['xml_description']=$db->FetchResult($result,$i,"xml_description_L0");
$rec->data['xml_short_description']=$db->FetchResult($result,$i,"xml_short_description_L0");
$rec->data['xml_options']=$db->FetchResult($result,$i,"xml_options");
$rec->data['main_page']=$db->FetchResult($result,$i,"main_page");
$rec->data['promotion']=$db->FetchResult($result,$i,"promotion");
$rec->data['newcol']=$db->FetchResult($result,$i,"newcol");
$rec->data['bestseller']=$db->FetchResult($result,$i,"bestseller");
$rec->data['producer']=$db->FetchResult($result,$i,"producer");
$rec->data['category1']=$db->FetchResult($result,$i,"category1");
$rec->data['category2']=$db->FetchResult($result,$i,"category2");
$rec->data['category3']=$db->FetchResult($result,$i,"category3");
$rec->data['category4']=$db->FetchResult($result,$i,"category4");
$rec->data['category5']=$db->FetchResult($result,$i,"category5");
$rec->data['id_category1']=$db->FetchResult($result,$i,"id_category1");
$rec->data['id_category2']=$db->FetchResult($result,$i,"id_category2");
$rec->data['id_category3']=$db->FetchResult($result,$i,"id_category3");
$rec->data['id_category4']=$db->FetchResult($result,$i,"id_category4");
$rec->data['id_category5']=$db->FetchResult($result,$i,"id_category5");
$rec->data['xml_options2']=$db->FetchResult($result,$i,"xml_options");

$rec->data['price_brutto']=$db->FetchResult($result,$i,"price_brutto");


// 2005-03-31 m@sote.pl poprawka wy¶wietlania ceny brutto zdefiniowanej w innej walucie

$rec->data['price_currency']=$db->FetchResult($result,$i,"price_currency");
if (empty($rec->data['price_brutto'])) {    
    $rec->data['price_brutto']=$my_price->price($result,$i,0,$rec->data['price_currency']);
}
// end

$rec->data['vat']=$db->FetchResult($result,$i,"vat");
$rec->data['price_brutto_detal']=$theme->price($db->FetchResult($result,$i,"price_brutto_detal"));
$rec->data['price_brutto_2']=$db->FetchResult($result,$i,"price_brutto_2");

if (@$edit_config->netto==1) {
    $rec->data['price_2']=$theme->price($my_price->brutto2netto($rec->data['price_brutto_2'],$rec->data['vat'],false));
} else $rec->data['price_2']=$rec->data['price_brutto_2'];

$rec->data['photo']=$db->FetchResult($result,$i,"photo");

// start pdf & flash:
$rec->data['pdf']=$db->FetchResult($result,$i,"pdf");
$rec->data['flash']=$db->FetchResult($result,$i,"flash");
$rec->data['flash_html']=$db->FetchResult($result,$i,"flash_html");
$rec->data['doc']=$db->FetchResult($result,$i,"doc");
// end pdf & flash:

$rec->data['id_available']=$db->FetchResult($result,$i,"id_available");
$rec->data['accessories']=$db->FetchResult($result,$i,"accessories");
$rec->data['hidden_price']=$db->FetchResult($result,$i,"hidden_price");
$rec->data['id_currency']=$db->FetchResult($result,$i,"id_currency");
$rec->data['price_currency']=$db->FetchResult($result,$i,"price_currency");
$rec->data['discount']=$db->FetchResult($result,$i,"discount");
$rec->data['max_discount']=$db->FetchResult($result,$i,"max_discount");

//onet pasaz
$rec->data['onet_export']=$db->FetchResult($result,$i,"onet_export");
$rec->data['onet_category']=$db->FetchResult($result,$i,"onet_category");
$rec->data['onet_status']=$db->FetchResult($result,$i,"onet_status");
$rec->data['onet_image_export']=$db->FetchResult($result,$i,"onet_image_export");
$rec->data['onet_image_desc']=$db->FetchResult($result,$i,"onet_image_desc");
$rec->data['onet_image_title']=$db->FetchResult($result,$i,"onet_image_title");
$rec->data['onet_attrib']=$db->FetchResult($result,$i,"onet_attrib");

$rec->data['onet_op']=$db->FetchResult($result,$i,"onet_op");
$rec->data['onet_author']=$db->FetchResult($result,$i,"onet_author");
$rec->data['onet_edition']=$db->FetchResult($result,$i,"onet_edition");
// end onet pasaz
if (@$edit_config->netto!=1) {
    $rec->data['price_currency']=$my_price->netto2brutto($rec->data['price_currency'],$rec->data['vat'],false);
}
$rec->data['price_currency']=$rec->data['price_currency'];


$rec->data['discount']=$db->FetchResult($result,$i,"discount");
$rec->data['max_discount']=$db->FetchResult($result,$i,"max_discount");

// info. o zablokowaniu aktualizacji opisu
$rec->data['desc_lock']=$db->FetchResult($result,$i,"desc_lock");

$rec->data['active']=$db->FetchResult($result,$i,"active");
$rec->data['ask4price']=$db->FetchResult($result,$i,"ask4price");
$rec->data['status_vat']=$db->FetchResult($result,$i,"status_vat");
$rec->data['weight']=$db->FetchResult($result,$i,"weight");
$rec->data['link_name']=$db->FetchResult($result,$i,"link_name");
$rec->data['link_url']=$db->FetchResult($result,$i,"link_url");
$rec->data['points']=$db->FetchResult($result,$i,"points");
$rec->data['points_value']=$db->FetchResult($result,$i,"points_value");
$rec->data['sms']=$db->FetchResult($result,$i,"sms");

// jesli wartosc w xml_options nie jest kodem XML to wartosc odczytana w bazie wyswietl
// w skroconym polu <input ...> odpowiadajacym za xml_options.
// W przeciwnym wypadku wartosc elementu xml_options jest pusta, a kod xml_options z XML jest
// przekazywany przez zmienna xml_options2.
// Ale jesli uzytkownik  w kolejnym kroku wprowadzi jakas wartosc do tego pola, to wartosc
// ta nadpisze wartosc z bazy nawet, jesli w bazie zdefinicowany jest KOD XML dla tego pola
if (! empty($rec->data['xml_options'])) {
    // dodaj obsluge pola xml_options
    global $my_xml_options;
    include_once ("include/xml_options.inc");    
    
    // sprawdz czy przy danym typie opcji jest dostepna edycja uproszczona (typ: input w formularzu)
    if ($my_xml_options->checkSimpleEdit()) {
        $rec->data['xml_options']=$db->FetchResult($result,$i,"xml_options");  
    } else {
        $rec->data['xml_options2']=$db->FetchResult($result,$i,"xml_options");  
        $rec->data['xml_options']='';
    }    
} else $rec->data['xml_options']='';

// odczytaj odpowiednie werje jêzykowe nazwy i opisu
$lang_id=0;
if ((empty($_REQUEST['lang_id'])) && (! empty($_REQUEST['item']['lang_id']))) $_REQUEST['lang_id']=$_REQUEST['item']['lang_id'];
if (! empty($_REQUEST['lang_id'])) {
    $rec->data['lang_id']=$_REQUEST['lang_id'];
    $lang_id=$rec->data['lang_id'];
} else $rec->data['lang_id']=0;

if ($rec->data['lang_id']==0) $lang_id=0;

$rec->data['name']=$db->FetchResult($result,$i,'name_L' . $lang_id);
$rec->data['xml_description']=$db->FetchResult($result,$i,'xml_description_L' . $lang_id);
$rec->data['xml_short_description']=$db->FetchResult($result,$i,'xml_short_description_L' . $lang_id);
// end

// main_keys_online sprzedaz online
$rec->data['main_keys_online']=$db->FetchResult($result,$i,"main_keys_online");
// end


// magazyn
$rec->data['depository_num'] = '';
$rec->data['deliverer_id'] = 0;
$res_depository = $mdbd->select("num,id_deliverer", "depository", "user_id_main=?", array($rec->data['user_id'] => 'text'), '', 'array');
if (!empty($res_depository)) {
    $rec->data['depository_num'] = $res_depository[0]['num'];
    $rec->data['deliverer_id'] = $res_depository[0]['id_deliverer'];
}
// end
?>