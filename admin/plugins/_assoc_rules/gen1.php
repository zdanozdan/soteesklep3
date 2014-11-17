<?php
/**
* Modu³ podpowiadania produktu - generowanie powi±zañ miêdzy prezentowanym produktem a innymi produktami
* 
* $_REQUEST['cron_mode'] - je¶li ta warto¶æ jest ustawiona, oznacza to wywo³anie z CRONa
* i nie s± wówczas wy¶wietlane jakiekolwiek nag³ówki i inne ozdobniki graficzne, a jedynie
* komunikat 'OK' lub 'ERROR'
* 
* @author lech@sote.pl
* @version $Id: gen1.php,v 1.1 2005/11/03 12:20:26 lechu Exp $
* @package    assoc_rules
*/

// naglowek php
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head_stream.inc.php");
// end naglowek php

include_once("lib/AssocRules/include/assoc_rules.inc");

global $transactions_path;


$transactions_path = $DOCUMENT_ROOT . "/tmp/transactions_for_ranking.txt";
require_once ("themes/stream.inc.php");
$stream = new StreamTheme;

if(empty($_REQUEST['cron_mode'])) {
   $theme->head_window();
   $stream->title_500(); // wyswietl pasek z numerami 100,200,300,400,500
}

include_once("./include/get_transactions.inc.php");
$assoc_rules = new AssocRules($transactions_path);
$assoc_rules->generateRules();


if (count($assoc_rules->Rules) > 0) {
	include_once("./include/ranking2db.inc.php");
	if(empty($_REQUEST['cron_mode'])) {
    	echo "<br><br><center>";
		echo $lang->gen1_info_ok . "<br>";
	}
	else {
	    echo "OK";
	}
}
else {
    if(empty($_REQUEST['cron_mode'])) {
    	echo "<br><br><center>";
		echo $lang->gen1_info_error_weak . "<br>";
    }
	else {
	    echo "OK";
	}
}
if(empty($_REQUEST['cron_mode'])) {
	echo "<br><button onclick='window.close()'>" . $lang->close_button . "</button></center>";
	$theme->foot_window();
}




/**/

// $assoc_rules->_displayRules();
include_once ("include/foot.inc");
?>