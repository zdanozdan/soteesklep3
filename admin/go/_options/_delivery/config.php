<?php
/**
 * Konfiguracja modu³u z onet
 *
 * @author  rdiak@sote.pl
 * @version $Id: config.php,v 2.6 2005/04/15 13:13:33 scalak Exp $
* @package    pasaz.onet.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");

/**
 * Nag³ówek skryptu oraz inne potrzebne pliki
 */
require_once("include/gen_user_config.inc.php");
require_once("include/metabase.inc");


// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->delivery_config_bar);
// kraje zapisywane sa w dowch miejscach. W configu oraz w tablicy delivery_country.

$country=array();
$country_db=array();
if(!empty($_REQUEST['item1'])) {
	foreach($_REQUEST['item1'] as $key=>$value) {
		if($key != 'save') {
			$country=$country+array($key=>"1");
			array_push($country_db,array(
										"name_short"=>$key,
										"name_long"=>$lang->country[$key]
										)
					  );
		}	
	}
} 

if( empty($_REQUEST['item1']) && !empty($_REQUEST['item']['save'])) {
	// jesli nie zdefinowano zadnego kraju nie pozwol na to
	print "<font color=red>".$lang->delivery_error_config['nocountry']."</font>";	
	require_once ("./html/delivery_config.html.php");
	exit;
}		

if (! empty($_REQUEST['item']['save'])) {
	$database->sql_delete("delivery_country");
	$database->sql_insert_table("delivery_country",$country_db);
	$ftp->connect();    
    $gen_config->gen(array(
                           "country_select"=>$country,
                           )
                     );
    $ftp->close();
	$config->country_select=$country;
}

require_once ("./html/delivery_config.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
