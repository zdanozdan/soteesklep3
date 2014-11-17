<?php
/**
* G³ówna strona modu³u obs³ugimodulu google.
*
* @author m@sote.pl
* @version $Id: index.php,v 1.1 2005/08/02 10:37:22 maroslaw Exp $
* @package    google
*/
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga Google.
*/
require_once ("./include/google.inc.php");

// zapisz dane w session_secure, wymagane dla obslugi no_session (dla streaming'u)
require_once ("include/save_auth_session.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->google_title);

$google =& new Google();
include_once ("./html/google.html.php");

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
