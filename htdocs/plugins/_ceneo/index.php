<?php
/**
 * Export produktów do ceneo pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: export1.php,v 1.1 2006/01/06 13:05:04 scalak Exp $
* @package    pasaz.ceneo.pl
 */

$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

//$theme->head_window();
//$theme->bar($lang->ceneo_bar['export']);

//print "<br><center>".$lang->ceneo_load_offer['timeout']."<br></center>";
//flush();

require_once("./include/ceneo_load_offer.inc.php");
$ceneo_offer=new ceneoLoadOffer;
$ceneo_offer->load_offer();

//include_once ("./html/ceneo_close.html.php");   

// stopka
//$theme->foot_window();
//include_once ("include/foot.inc");
?>
