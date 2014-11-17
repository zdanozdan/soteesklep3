<?php
/**
* Edycja cen objetosci
*
* @author rdiak@sote.pl
* @version $Id: volume_price.php,v 1.6 2006/03/08 14:44:14 lechu Exp $
* @package zone
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu 
*/
require_once ("../../../../../include/head.inc");
require_once ("include/metabase.inc");

$theme->head_window();
$theme->bar($lang->delivery_zone_price);

if (! empty($_REQUEST['update'])) {
    $update=true;
} else {
    $update=false;
}

if ($update==false) {
    // jesli otwieramy formatke po raz pierwszy
	include("./html/volume_price.html.php");
} else {
	//print "tu";
	// sprawdz czy wpisano cyfry, przecinek lub kropke
	$temp=array();
	foreach($_REQUEST['item'] as $key=>$value) {
		if(!empty($value)) {
			if (! ereg("^[0-9\.,]+$",$value)) {
				$temp=$temp+array($key=>$value);
				print "<font color=red>".$lang->delivery_zone_error_data."</font>";
				// jesli nie to pokaz formatke
				include("./html/volume_price.html.php");
				exit;
			} else {
				$temp=$temp+array($key=>$value);
			}
		} 		
	}
	//print "<pre>";
	//print_r($temp);
	//print "<pre>";
	// sprawdz czy podano strefe oraz dostawce
	if (! ereg("^[0-9]+$",$_REQUEST['id_zone']) || ! ereg("^[0-9]+$",$_REQUEST['id_delivery'])) {
    	die ("Bledne wywolanie");   
	}
	//print "zone::".$_REQUEST['id_zone'];
	//print "delivery::".$_REQUEST['id_delivery'];
	global $database;
	global $mdbd;
	$str=serialize($temp);
	// sprawdz czy wpis juz istanieje w bazie danych
	$count=$database->sql_select("count(*)","delivery_price","id_zone=".$_REQUEST['id_zone']," AND id_delivery=".$_REQUEST['id_delivery']);
	if($count > 0) {
		print $lang->delivery_zone_voume_price['update'];
		// jesli istnieje to aktualizujemy rekord
		$database->sql_update1("delivery_price","id_zone=".$_REQUEST['id_zone'], array(
													"price"=>$str
													),"AND id_delivery=".$_REQUEST['id_delivery']			
							 );						 	
	} else {	
		print $lang->delivery_zone_voume_price['insert'];
		// jesli nie istnieje to go dodajemy do bazy
		$database->sql_insert("delivery_price", array(
								"id_zone"=>$_REQUEST['id_zone'],
								"id_delivery"=>$_REQUEST['id_delivery'],
								"price"=>$str
	    						    )
							);						
	} 
	include("./html/volume_price.html.php");
}

$theme->foot_window();

include_once ("include/foot.inc");
?>
