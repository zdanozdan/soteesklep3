<?php
/**
 * Edycja opcji zaawansowanych oroduktu. Wywo³anie strony ³aduj±cej ramki.
 *
 * @author  m@sote.pl
 * @version $Id: edit_xml_options_frame.php,v 2.4 2005/01/20 14:59:20 maroslaw Exp $
 *
 * \@verified 2004-03-15 m@sote.pl
* @package    edit
 */
$global_database=false;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");


if (! empty($_REQUEST['id'])) {
    $id=$_REQUEST['id'];    
} else die ("Forbidden: Unknown ID");

include_once("./html/edit_xml_options_frame.html.php");

include_once ("include/foot.inc");
?>
