<?php
/**
 * Edycja wygladu, wymiana plikow .html.php z tematu
 *
 * @author  m@sote.pl
 * @version $Id: files_php.php,v 1.3 2005/01/20 15:00:11 maroslaw Exp $
* @package    themes
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->bar($lang->themes_titles['files_php']);
print "files_php";

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
