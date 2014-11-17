<?php
/**
 * Wyswietl formularz do zalaczenia pliku cennika
 *
 * @author  m@sote.pl
 * @version $Id: upload.php,v 1.5 2005/01/20 15:00:30 maroslaw Exp $
* @package    pay
* @subpackage inteligo
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
require_once ("./include/files.inc.php");

$inteligo = &new InteligoFile();
// zrob cos z plikiem
$inteligo->InteligoAction();

include_once ("include/foot.inc");
?>
