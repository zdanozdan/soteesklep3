<?php
/**
 * Wyswietl formularz do zalaczenia pliku cennika
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.3 2005/01/20 14:59:55 maroslaw Exp $
* @package    main_keys
* @subpackage offline
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
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
