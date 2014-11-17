<?php
/**
 * Edycja wygladu, konfiguracja opcji zwiazanych z tematami
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.4 2005/01/20 15:00:11 maroslaw Exp $
* @package    themes
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./html/themes.html.php");


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
