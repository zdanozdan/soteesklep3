<?php
/**
* Opcje dostêpne dla administratora sklepu - super user.
*
* @author m@sote.pl
* @version $Id: index.php,v 1.5 2005/01/20 14:59:16 maroslaw Exp $
* @package    admin
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
* Nag³ówek skryptu 
*/
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->admin_title);

include_once ("./html/admin.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
