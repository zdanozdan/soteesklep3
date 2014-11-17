<?php
/**
 * Dodaj usun uzytkownika do newsletter
 *
 * @author  m@sote.pl
 * @version $Id: index.php,v 2.11 2005/01/20 15:00:17 maroslaw Exp $
* @package    newsletter
 */

$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
 * Nag³ówek skryptu.
 */
require_once ("../../../include/head.inc");


// naglowek
$theme->head();
$theme->theme_file("page_open_1_head.html.php");

$theme->bar($lang->newsletter_title);

if (! empty($_REQUEST['email'])) {
    $email=$_REQUEST['email'];
} else $email='';

if (! empty($_REQUEST['newsletter'])) {
    $action=$_REQUEST['newsletter'];
} else $action='';


require_once("./include/newsletter.inc.php");
$newsletter = new Newsletter($email,$action);

$newsletter->action(); 

$theme->theme_file("page_open_1_foot.html.php");
// stopka

$theme->foot();
include_once ("include/foot.inc");
?>
