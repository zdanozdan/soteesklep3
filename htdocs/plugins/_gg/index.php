<?php
/**
* Edycja wersji jêzykowych
*
* Skrypt obs³uguj±cy aktualizacjê numerów gg
* @author  lech@sote.pl
* @version $Id: index.php,v 1.2 2005/06/06 14:05:17 maroslaw Exp $
* @package    gg
* \@lang
* \@encoding
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga po³±czeñ HTTP.
*/
require_once ("HTTP/Request.php");

/**
* Klasa obs³ugi odczytywania i zapisywania statusów
*/
require_once ("./include/gg.inc.php"); 

$gg =& new GG;

$gg->update();
print "<gg>GG Updated</gg>";

include_once ("include/foot.inc");

?>