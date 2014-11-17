<?php
/**
 * Obsluga pobierania kategorii i innych informacji z pasazu wp
 *
 * @author  rdiak@sote.pl
 * @version $Id: index.php,v 1.4 2005/01/20 15:00:04 maroslaw Exp $
* @package    pasaz.wp.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->wp_bar["index"]);

include_once("./html/wp_pasaz.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
