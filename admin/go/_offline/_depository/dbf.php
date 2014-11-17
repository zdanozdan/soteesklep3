<?php
/**
 * Wyswietl formularz do zalaczenia pliku cennika
 *
 * @author  rdiak@sote.pl
 * @version $Id: dbf.php,v 1.1 2005/12/22 11:39:21 scalak Exp $
* @package    offline
* @subpackage main
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("$DOCUMENT_ROOT/../include/head.inc");

/**
* Includowanie kasy od obs³ugi ftp
*/
require_once ("include/ftp.inc.php");

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
include_once("./include/dbf.inc.php");

$theme->bar($lang->offline_update);
$bar=true;


$file=$DOCUMENT_ROOT."/tmp/MAGAZ.DBF";//WARNING !!! CASE SENSITIVE APPLIED !!!!!
print $file;
$dbf = new dbf_class($file);
$num_rec=$dbf->dbf_rec_size;
$field_num=$dbf->dbf_field_size;
$arrRec =  $dbf->dbf_record;
$arrField = $dbf->dbf_field;

for($i=0; $i<$num_rec; $i++){
	for($j=0; $j<$field_num; $j++){
		echo($arrRec[$i][ $arrField[$j] ].' ');
	}
	echo('<br>');
}



$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
