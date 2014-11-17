<?php
/**
 * Lista newsow
 *
 * @author rdiak@sote.pl
 * @modify m@sote.pl
 *
 * $Id: index.php,v 2.5 2005/01/20 14:59:44 maroslaw Exp $
* @version    $Id: index.php,v 2.5 2005/01/20 14:59:44 maroslaw Exp $
* @package    admin_plugins
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->plugins);

include_once ("./html/main.html.php");

// stopka
$theme->page_open_foot();
$theme->foot();

include_once ("include/foot.inc");
?>
