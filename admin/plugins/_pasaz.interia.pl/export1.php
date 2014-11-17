<?php
/**
 * Export produktów do interia pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: export1.php,v 1.2 2005/06/08 11:22:40 maroslaw Exp $
* @package    pasaz.interia.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../include/head_stream.inc.php");

$theme->head_window();
$theme->bar($lang->interia_bar['export']);

print "<br><center>".$lang->interia_load_offer['timeout']."<br></center>";
flush();

require_once("./include/interia_load_offer.inc.php");
$interia_offer=new interiaLoadOffer;
$interia_offer->LoadOffer();

include_once ("./html/interia_close.html.php");   

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
