<?php
/**
* Lista adresów e-mail w danej grupie
*
* @author  rdiak@sote.pl
* @version $Id: list.php,v 2.5 2005/01/20 15:00:00 maroslaw Exp $
*
* verified m@sote.pl 2004-03-09
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

if (! empty($_REQUEST['group'])) {
    $group=$_REQUEST['group'];
    $group=addslashes($group);
} else {
    $group='';
}

// config
$sql="SELECT * FROM newsletter WHERE groups like '%:".$group.":%' ORDER BY id";
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
