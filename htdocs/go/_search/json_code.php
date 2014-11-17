<?php
/**
 * Wyszukaj produkty, wedlug ID
* @package    search
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

$lang_id = $config->lang_id;

if (empty($_REQUEST['id'])) 
{
echo json_encode(array('Error'=>array('code'=>'500','desc'=>'Parameter "id" is required in request')));
die();
}

$query_words = $_REQUEST['id'];

if(preg_match('/^([0-9]+)$/',$query_words,$r) or preg_match('/^mik[_-]([0-9]+)$/',$query_words,$r) or preg_match('/^mik([0-9]+)$/',$query_words,$r))
{
    /**
     * Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
     * Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
     */ 
    class RecordRowJson {
        function record($result,$i) {
            global $db;
            global $json;
            $json['code'] = '200';
            $json['id'] = $db->FetchResult($result,$i,"id");
            $json['active'] = $db->FetchResult($result,$i,"active");
            $json['user_id'] = $db->FetchResult($result,$i,"user_id");
            $json['photo_id'] = $db->FetchResult($result,$i,"photo");
            $json['photo_id'] = $db->FetchResult($result,$i,"photo");
            $json['photo_path'] =  "http://www.sklep.mikran.pl/photo/";
            $json['last_updated'] = $db->FetchResult($result,$i,"date_update");
	    $json['name'] = mb_convert_encoding ( $db->FetchResult($result,$i,"name_L0") , 'UTF-8','ISO-8859-2');
            $json['producer'] = $db->FetchResult($result,$i,"producer");
            $json['cat1'] = $db->FetchResult($result,$i,"category1");
            $json['cat2'] = $db->FetchResult($result,$i,"category2");
            $json['cat3'] = $db->FetchResult($result,$i,"category3");
            $json['cat4'] = $db->FetchResult($result,$i,"category4");
            $json['cat5'] = $db->FetchResult($result,$i,"category5");
            $json['brutto'] = $db->FetchResult($result,$i,"price_brutto");
	    $json['discount'] = $db->FetchResult($result,$i,"discount");
            $json['vat'] = $db->FetchResult($result,$i,"vat");

            //calculate discount now
            $json['brutto'] = sprintf("%.2f",$json['brutto'] - $json['brutto']*($json['discount']/100));
            //$json['brutto'] = "2.00";

 	    $dbedit_num = new DBEdit;
    	    $dbedit_num->record_class = 'RecordRowJsonNum';
    	    $dbedit_num->empty_list_message = "";

    	    $dbedit_num->record_list(sprintf("SELECT * FROM depository where user_id_main='%s'",$json['user_id']));
            return;
       }
    }

    class RecordRowJsonNum {
	function record($result,$i) {
            global $db;
            global $json;
            $json['num'] = $db->FetchResult($result,$i,"num");
	    return;
	}
    }

    $dbedit = new DBEdit;
    $dbedit->record_class = 'RecordRowJson';
    $dbedit->empty_list_message = "";

    $dbedit->record_list(sprintf("SELECT * FROM main where main.id = %d",$r[1]));
}
else
{
echo json_encode(array('Error'=>array('code'=>'500','desc'=>'ID parameter must be numeric or with mik_ prefix')));
die();
}

if(count($json))
{
  echo json_encode(array('Success'=>$json));
}
else
{
  $json = array('Error'=>array('code'=>'404','desc'=>'Element with id not found'));
  echo json_encode($json);
}
?>
