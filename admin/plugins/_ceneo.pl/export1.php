<?php
/**
 * Export produktów do ceneo pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: export1.php,v 1.2 2006/08/16 10:41:41 lukasz Exp $
* @package    pasaz.ceneo.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
global $config;
/**
 * Nag³ówek skryptu
 */
require_once ("../../include/head_stream.inc.php");

$theme->head_window();
$theme->bar($lang->ceneo_bar['export']);

print "<br><center>".$lang->ceneo_load_offer['timeout']."<br>";
print "</center>";
flush();

require_once("./include/ceneo_load_offer.inc.php");
$ceneo_offer=new ceneoLoadOffer;
$ceneo_offer->load_offer();

print "<br><center>".$lang->ceneo_load_offer['file']."<br><a target='_blank' href='http://".$config->www."/ceneo.xml'>http://".$config->www."/ceneo.xml</a></center>";
include_once ("./html/ceneo_close.html.php");   

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
