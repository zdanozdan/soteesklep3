<?php
/**
 * Wyswietl formularz do zalaczenia pliku cennika
 *
 * @author  rdiak@sote.pl
 * @version $Id: index.php,v 2.10 2005/02/16 14:51:25 scalak Exp $
* @package    offline
* @subpackage main
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../../../include/head.inc");

/**
* Includowanie kasy od obs³ugi ftp
*/
require_once ("include/ftp.inc.php");

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");
$theme->bar($lang->offline_update);
$bar=true;

if (! empty($_FILES['datafile']['name'])) {
    $file=$_FILES['datafile'];
    $datafile=$file['name'];
    $datafile_tmp=$file['tmp_name'];
	$ftp->connect();
    $ftp->put($datafile_tmp,"$config->ftp_dir/admin/tmp",$config->offline_filename);
    $ftp->close();
    
    include_once ("data2sql.php");
} else {
    require_once ("./html/upload.html.php");
}
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
