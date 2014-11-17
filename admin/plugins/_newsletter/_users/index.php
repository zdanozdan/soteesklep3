<?php
/**
* Lista adresów e-mail w systemie newsletter, wszystkie adresy z bazy newsletter'a
*
* @author  rdiak@sote.pl
* @version $Id: index.php,v 2.9 2005/01/20 15:00:00 maroslaw Exp $
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

// config
$sql="SELECT * FROM newsletter ORDER BY id DESC";
$bar=$lang->bar_title['newsletter'];
include_once ("./include/list_th.inc.php");
$list_th=newsletter_list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

require_once ("include/list.inc.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
