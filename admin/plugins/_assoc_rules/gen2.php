<?php
/**
* Modu³ podpowiadania produktu - generowanie powi±zañ miêdzy zalogowanym u¿ytkownikiem a innymi produktami
* 
* $_REQUEST['cron_mode'] - je¶li ta warto¶æ jest ustawiona, oznacza to wywo³anie z CRONa
* i nie s± wówczas wy¶wietlane jakiekolwiek nag³ówki i inne ozdobniki graficzne, a jedynie
* komunikat 'OK' lub 'ERROR'
* 
* @author lech@sote.pl
* @version $Id: gen2.php,v 1.1 2005/11/03 12:20:26 lechu Exp $
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


require_once ("themes/stream.inc.php");
$stream = new StreamTheme;

if(empty($_REQUEST['cron_mode'])) {
	$theme->head_window();
    $stream->title_500(); // wyswietl pasek z numerami 100,200,300,400,500
}
include_once("./include/get_transactions2.inc.php");

if(empty($_REQUEST['cron_mode'])) {
	echo "<br><br><center>";
	echo $lang->gen2_info_ok . "<br>";
	echo "<br><button onclick='window.close()'>" . $lang->close_button . "</button></center>";
	$theme->foot_window();
}
else {
   echo "OK";
}


/**/

// $assoc_rules->_displayRules();

include_once ("include/foot.inc");
?>