<?php
/**
 * Export produktów do onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: export1.php,v 1.4 2005/06/08 11:22:40 maroslaw Exp $
* @package    pasaz.onet.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../include/head_stream.inc.php");

$theme->head_window();
$theme->bar($lang->onet_bar['export']);

print "<br><center>".$lang->onet_load_offer['timeout']."<br></center>";
flush();

require_once("./include/onet_load_offer.inc.php");
$onet_offer=new OnetLoadOffer;
$onet_offer->load_offer();

include_once ("./html/onet_close.html.php");   

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
