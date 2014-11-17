<?php
/**
 * Obsluga pobierania kategorii i innych informacji z pasazu interia
 *
 * @author  rdiak@sote.pl
 * @version $Id: index.php,v 1.1 2005/03/29 15:15:54 scalak Exp $
* @package    pasaz.interia.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->interia_bar["index"]);

include_once("./html/interia_pasaz.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
