<?php
/**
 * Strona g³ówna modu³u Allegro 
 *
 * @author  krzys@sote.pl
 * @version $Id: index.php,v 1.1 2006/03/16 10:16:40 krzys Exp $
* @package    pasaz.ceneo.pl
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../../include/head.inc");

$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->allegro_bar["index"]);

include_once("./html/allegro_main.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
