<?php
/**
* Plik odpowiada wywo³aniu g³ównej strony systemu NewsEdit w sklepie.
*
* @author  rp@sote.pl
* @version $Id: index.php,v 1.6 2005/01/20 15:00:27 maroslaw Exp $
*
* \@verified 2004-03-22 m@sote.pl
* @package    newsedit
*/

// informacja o wywolaniu glownej strony
$__start_page=false;
$__page="newsedit";

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
include_once ("../../../include/head.inc");

// naglowek
//$theme->head();

$theme->page_open("left","mainNews","right");

//$theme->foot();
//include_once ("include/foot.inc");
?>
