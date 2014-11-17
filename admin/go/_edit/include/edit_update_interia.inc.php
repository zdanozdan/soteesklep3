<?php
/**
* Aktualizuj w baze wartosc pola zwi±zane z interiaPasa¿
*
* @author  rdiak@sote.pl
* @version $Id: edit_update_interia.inc.php,v 2.1 2005/03/29 15:17:35 scalak Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

if ($global_secure_test!=true) {
	die ("Forbidden");
}

require_once("include/metabase.inc");
global $database;
global $mdbd;

$m_date=& new DateManage;
$m_date->count=1;
$m_date->lang='pl';
$datat=$m_date->saveToDb();
//print_r($datat);

// pobieramy z tablicy main user_id produktu 
$user_id=$mdbd->select("user_id","main","id=?",array($id=>"int"));

// sprawdzamy czy rekord juz istnieje w bazie
$count=$mdbd->select("count(*)","main_param","user_id=?",array($user_id=>"string"));

// odczytaj dane z formularza
if (! empty($_REQUEST['item'])) {
	$item=&$_REQUEST['item'];
} else {
	die ("Forbidden: Unknown item");
}

if($count == 0) {
	$database->sql_insert("main_param",array(
							    "user_id"=>$user_id,
							    "interia_export"=>@$item['interia_export'],
								"interia_status"=>@$item['interia_status'],
							    "interia_category"=>@$item['interia_category'],
							    ));

} else {
	$database->sql_update("main_param","user_id=$user_id",
								array(
							    	"interia_export"=>@$item['interia_export'],
									"interia_status"=>@$item['interia_status'],
							    	"interia_category"=>@$item['interia_category'],
							    ));
}
// zaakutalizuj informacje o tym czy produkt jest eksportowany w glownej tablicy produktow
$database->sql_update("main","user_id=$user_id",array("interia_export"=>@$item['interia_export']));
?>
