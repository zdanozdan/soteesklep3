<?php
/**
* Usuñ zaznaczone na li¶cie adresy e-mail.
*
* @author rdiak@sote.pl m@sote.pl
* @version $Id: delete.php,v 2.6 2005/01/20 15:00:00 maroslaw Exp $
*
* verified 2004-03-09 m@sote.pl
* @package    newsletter
* @subpackage users
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->newsletter_delete_bar);
print "<p>";

require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("newsletter","id");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
