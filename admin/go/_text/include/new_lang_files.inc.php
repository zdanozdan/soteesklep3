<?php
/**
 * Zaloz nowe katalogi i pliki zwiazane z konfiguarcja jezykowa tekstow
 *
 * \@global string $__lang jezyk dla ktorego zakladami katalogi i pliki
 *
 * @author  m@sote.pl
 * @version $Id: new_lang_files.inc.php,v 2.2 2004/12/20 17:59:08 maroslaw Exp $
* @package    text
 */

if (@$__secure_test!=true) die ("Forbidden");

require_once ("include/ftp.inc.php");

if (empty($__lang)) die ("Forbidden: empty \$__lang");

$ftp->connect();

// zaloz katalogi, gdzie beda przechowywane pliki z tekstami dla danej wersji jezykowej
$ftp->mkdir($config->ftp['ftp_dir']."/htdocs/themes/_$__lang");
$ftp->mkdir($config->ftp['ftp_dir']."/htdocs/themes/_$__lang/_html_files");

// zaloz plik z opisem plikow
$ftp->put("$DOCUMENT_ROOT/../htdocs/themes/_$config->base_lang/_html_files/.info.php",$config->ftp['ftp_dir']."/htdocs/themes/_$__lang/_html_files",".info.php");

// start instaluj pliki html:
$html_dir="$MY_DOCUMENT_ROOT/htdocs/themes/_$config->base_lang/_html_files/";
$d = dir($html_dir);   // katalog w ktorym znajduja sie pliki html

// odczytanie listy plikow z odpowiedniego katalogu
$inst_files=array();
while (false !== ($entry = $d->read())) {
    if (ereg("(.)*.html$",$entry)) {
        $ftp->put("$DOCUMENT_ROOT/../htdocs/themes/_$config->base_lang/_html_files/$entry",$config->ftp['ftp_dir']."/htdocs/themes/_$__lang/_html_files",$entry);
    }
}

$d->close();
// end instaluj pliki html:

$ftp->close();

?>
