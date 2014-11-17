<?php
/**
 * Wywolaj strone z edycja stron tekstowych HTML lub edycje plikow devel np. langow; dla $config->devel=1
 *
 * @author  m@sote.pl
 * @version $Id: edit.php,v 2.6 2005/01/20 14:59:39 maroslaw Exp $
* @package    text
 */

$global_database=false;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// przypisanie oryginalnej nazwy pliku
if (! empty($_REQUEST['file'])) {
    $file=$_REQUEST['file'];
} elseif (($config->devel==1) && (! empty($_REQUEST['filedev']))) {
    $filedev=$_REQUEST['filedev'];
} else die  ("Bledne wywolanie");

// sprawdzaj tylko dla edycji textow, a nie dla edycji plikow devel
if (($config->devel!=1) && (! empty($filedev))) {
    // przypisanie tlumaczenia nazwy pliku
    if (! empty($_REQUEST['file_name'])) {
        $file_name=$_REQUEST['file_name'];
    } else die  ("Bledne wywolanie");
    
    // przypisanie nazwy jezyka
    if (! empty($_REQUEST['lang_name'])) {
        $lang_name=$_REQUEST['lang_name'];
    } else die  ("Bledne wywolanie");
}

include_once("html/edit_frame.html.php");

include_once ("include/foot.inc");
?>
