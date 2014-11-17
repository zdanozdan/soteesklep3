<?php
/**
 * Lista walut
 *
 * @author m@sote.pl
 * @version $Id: index.php,v 1.4 2005/01/20 14:59:32 maroslaw Exp $
 * @package currency 
 */

$global_database=true;
$global_secure_test=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require_once ("../../../../../include/head.inc");

// config
$sql="SELECT * FROM delivery_zone ORDER BY id";
$bar=$lang->delivery_zone_bar;

include_once ("./include/list_th.inc.php");
$list_th=delivery_zone_list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

require_once ("include/list.inc.php");
//$data=$mdbd->select("id,name,delivery_zone","delivery");
//$data=$mdbd->select("id,country","delivery_zone");  
//foreach($data as $key=>$value) {
//	$data[$key]['delivery_zone']=unserialize($data[$key]['delivery_zone']);
//}
//$data=$mdbd->select("id,name,delivery_zone","delivery");
//print "<pre>";
//print_r($data);
//print "</pre>";


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");

?>
