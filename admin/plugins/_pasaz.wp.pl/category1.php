<?php
/**
 * Obsluga pobierania kategorii i innych informacji z pasazu wp
 *
 * @author  rdiak@sote.pl
 * @version $Id: category1.php,v 1.5 2005/06/08 11:22:40 maroslaw Exp $
* @package    pasaz.wp.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head_stream.inc.php");


// naglowek
$theme->head_window();
$theme->bar($lang->wp_bar['cat']);


print "<br><center>".$lang->wp_get_cat['timeout']."<br></center>";
flush();

require_once("./include/wp_get_cat.inc.php");
$wp_cat=new WpGetCat;
$wp_cat->wp_get_data();

include_once ("./html/wp_close.html.php"); 

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
