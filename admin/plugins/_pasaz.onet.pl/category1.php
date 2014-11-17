<?php
/**
 * Pobieranie kategorii z onet pasaz
 *
 * @author  rdiak@sote.pl
 * @version $Id: category1.php,v 1.5 2005/06/08 11:22:40 maroslaw Exp $
* @package    pasaz.onet.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../include/head_stream.inc.php");

$theme->head_window();
$theme->bar($lang->onet_bar['cat']);


print "<br><center>".$lang->onet_get_cat['timeout']."<br></center>";
flush();

require_once("./include/onet_get_cat.inc.php");
$onet_cat=new OnetGetCat;
$onet_cat->onet_get_tree();

include_once ("./html/onet_close.html.php"); 

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
