<?php
/**
 * Export produktów do wp pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: export1.php,v 1.3 2005/06/08 11:22:41 maroslaw Exp $
* @package    pasaz.wp.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../include/head_stream.inc.php");

$theme->head_window();
$theme->bar($lang->wp_bar['export']);

print "<br><center>".$lang->wp_load_offer['timeout']."<br></center>";
flush();

require_once("./include/wp_load_offer.inc.php");
$wp_offer=new WpLoadOffer;
$wp_offer->LoadOffer();

include_once ("./html/wp_close.html.php");   

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
