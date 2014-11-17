<?php
/**
 * Obsluga pobierania kategorii i innych informacji z pasazu interia
 *
 * @author  rdiak@sote.pl
 * @version $Id: category1.php,v 1.3 2005/12/23 14:37:21 scalak Exp $
* @package    pasaz.interia.pl
 */

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head_stream.inc.php");


// naglowek
$theme->head_window();
$theme->bar($lang->interia_bar['cat']);


print "<br><center>".$lang->interia_get_cat['timeout']."<br></center>";
flush();

require_once("./include/interia_get_cat.inc.php");
$interia_cat=new InteriaGetCat;
$interia_cat->interia_get_tree();

//$interia_cat->_interia_select_category();

include_once ("./html/interia_close.html.php"); 

// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
