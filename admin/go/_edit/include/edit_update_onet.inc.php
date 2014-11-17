<?php
/**
* Aktualizuj w baze wartosc pola zwi±zane z OnetPasa¿
*
* @author  rdiak@sote.pl
* @version $Id: edit_update_onet.inc.php,v 2.9 2005/08/09 09:11:03 uid1003 Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

if ($global_secure_test!=true) {
	die ("Forbidden");
}

require_once("include/metabase.inc");

// odczytaj dane z formularza
if (! empty($_REQUEST['item'])) {
	$item=&$_REQUEST['item'];
} else {
	die ("Forbidden: Unknown item");
}

$query="UPDATE main SET
			onet_export=?,  onet_category=?, onet_status=?, onet_image_export=?, 
			onet_image_desc=?, onet_image_title=?, onet_attrib=?
		WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
	$db->QuerySetText($prepared_query,1,@$item['onet_export']);
	$db->QuerySetText($prepared_query,2,@$item['onet_category']);
	$db->QuerySetText($prepared_query,3,@$item['onet_status']);
	$db->QuerySetText($prepared_query,4,@$item['onet_image_export']);
	$db->QuerySetText($prepared_query,5,@$item['onet_image_desc']);
	$db->QuerySetText($prepared_query,6,@$item['onet_image_title']);
	$db->QuerySetText($prepared_query,7,@$item['onet_attrib']);
//	$db->QuerySetText($prepared_query,8,@$item['onet_op']);
//	$db->QuerySetText($prepared_query,8,@$item['onet_author']);
//	$db->QuerySetText($prepared_query,9,@$item['onet_edition']);
	$db->QuerySetText($prepared_query,8,@$id);
	$result=$db->ExecuteQuery($prepared_query);
	if ($result==0) {
		die ($db->Error());
	}
	// pobierze podstawowa kategorie produktu
	if(! empty ($item['onet_same_cat'])) {
		// jesli znacznik zostal ustawiony 
		if($item['onet_same_cat'] == '1' ) {
			// pobierz id_category1 danego produktu
			$id_category=$database->sql_select("id_category1","main","id=$id");
			// aktualizuj pole onet_category wszystkich produktów ktore maja taka sama kategorie jak produkt bazowy  
			$database->sql_update("main","id_category1=$id_category",array("onet_category"=>$item['onet_category']));
		}
	}	
} else {
	die ($db->Error());
}

?>
