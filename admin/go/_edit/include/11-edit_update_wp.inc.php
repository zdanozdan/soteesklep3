<?php
/**
* Aktualizuj w baze wartosc pola zwi±zane z wpPasa¿
*
* @author  rdiak@sote.pl
* @version $Id: edit_update_wp.inc.php,v 2.9 2006/01/04 13:27:10 scalak Exp $
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


// korzyscie
$wp_advantages='';
if(!empty($item['wp_advantages'])) {
	foreach($item['wp_advantages'] as $key=>$value) {
		$wp_advantages.=$value.",";
	}
	$wp_advantages=ereg_replace(",$","",$wp_advantages);
}

//filtry
$wp_filters='';
if(!empty($item['wp_filters'])) {
	foreach($item['wp_filters'] as $key=>$value) {
		$wp_filters.=$value.",";
	}
	$wp_filters=ereg_replace(",$","",$wp_filters);
}


if($count == 0) {
	$database->sql_insert("main_param",array(
							   "user_id"=>$user_id,
							    "wp_export"=>@$item['wp_export'],
								"wp_status"=>@$item['wp_status'],
							    "wp_dictid"=>@$item['wp_dictid'],
							    "wp_category"=>@$item['wp_category'],
								"wp_producer"=>@$item['wp_producer'],
								"wp_advantages"=>$wp_advantages,
								"wp_filters"=>$wp_filters,
							    "wp_dest"=>@$item['wp_dest'],
							    "wp_fields"=>@$item['wp_fields'],
							    "wp_ptg"=>@$item['wp_ptg'],
							    "wp_ptg_desc"=>@$item['wp_ptg_desc'],
							    "wp_ptg_days"=>@$item['wp_ptg_days'],
							    "wp_ptg_picurl"=>@$item['wp_ptg_picurl'],
							    "wp_valid"=>@$datat[0][1],
							    ));
		                          if($item['wp_same_cat'] == '1' ) {
			                         $cat=$item['wp_same_cat1'];
		                              // pobierz id_category1 danego produktu
			                         $id_category=$database->sql_select("id_category".$cat,"main","id=$id");
			                         if(!empty($id_category)) {
			                            $user_id_array=$database->sql_select_array("user_id","main","id_category".$cat."=".$id_category);
			                            foreach($user_id_array as $value) {
			                                 if($item['wp_same_cat'] == '1' && $item['wp_same_prod'] == '1') {
			                                     $database->sql_update("main_param","user_id=$value",array("wp_category"=>$item['wp_category'],"wp_producer"=>$item['wp_producer'] ));
			                                 } elseif($item['wp_same_cat'] == '1') {
			                                     $database->sql_update("main_param","user_id=$value",array("wp_category"=>$item['wp_category']));
			                                 } else {
			                                     $database->sql_update("main_param","user_id=$value",array("wp_producer"=>$item['wp_producer']));
			                                 }  
			                            }		                                 
                                     }   
		                          }

} else {
	$database->sql_update("main_param","user_id=$user_id",
								array(
							    	"wp_export"=>@$item['wp_export'],
									"wp_status"=>@$item['wp_status'],
							    	"wp_dictid"=>@$item['wp_dictid'],
							    	"wp_category"=>@$item['wp_category'],
									"wp_producer"=>@$item['wp_producer'],
									"wp_advantages"=>$wp_advantages,
									"wp_filters"=>$wp_filters,
							    	"wp_dest"=>@$item['wp_dest'],
							    	"wp_fields"=>@$item['wp_fields'],
							    	"wp_ptg"=>@$item['wp_ptg'],
							    	"wp_ptg_desc"=>@$item['wp_ptg_desc'],
							    	"wp_ptg_days"=>@$item['wp_ptg_days'],
							    	"wp_ptg_picurl"=>@$item['wp_ptg_picurl'],
   								    "wp_valid"=>@$datat[0][1],
							    ));
		                          if($item['wp_same_cat'] == '1' ) {
			                         $cat=$item['wp_same_cat1'];
		                              // pobierz id_category1 danego produktu
			                         $id_category=$database->sql_select("id_category".$cat,"main","id=$id");
			                         if(!empty($id_category)) {
			                            $user_id_array=$database->sql_select_array("user_id","main","id_category".$cat."=".$id_category);
			                            foreach($user_id_array as $value) {
			                                 if($item['wp_same_cat'] == '1' && $item['wp_same_prod'] == '1') {
			                                     $database->sql_update("main_param","user_id=$value",array("wp_category"=>$item['wp_category'],"wp_producer"=>$item['wp_producer'] ));
			                                 } elseif($item['wp_same_cat'] == '1') {
			                                     $database->sql_update("main_param","user_id=$value",array("wp_category"=>$item['wp_category']));
			                                 } else {
			                                     $database->sql_update("main_param","user_id=$value",array("wp_producer"=>$item['wp_producer']));
			                                 }  
			                            }		                                 
                                     }   
		                          }
}
// zaakutalizuj informacje o tym czy produkt jest eksportowany w glownej tablicy produktow
$database->sql_update("main","user_id=$user_id",array("wp_export"=>@$item['wp_export']));
?>
