<?php
/**
* Formularz do wprowadzenia tre¶ci wysy³anego newslettera.
*
* @author  rdiak@sote.pl
* @version $Id: send.php,v 2.7 2005/01/20 15:00:01 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
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

// zapisz dane w session_secure, wymagane dla obslugi no_session (dla streaming'u)
require_once ("include/save_auth_session.inc.php");

$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->newsletter_send);

include_once ("./html/newsletter_form.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
