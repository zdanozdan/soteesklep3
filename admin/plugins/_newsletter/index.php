<?php
/**
 * Newsletter, lista opcji do wyboru. Domy¶lnie klient nie jest przekierowywany do tego 
 * pliku, ale mo¿liwe jest jego wywo³anie poprzez zmiane adresu URL w przegl±darce.
 *
 * @author  rdiak@sote.pl
 * @version $Id: index.php,v 2.9 2005/01/20 14:59:58 maroslaw Exp $
 *
 * verified 2004-03-09 m@sote.pl
* @package    newsletter
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Naglowek skryptu.
*/
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

// zapisz dane w session_secure, wymagane dla obslugi no_session (dla streaming'u)
require_once ("include/save_auth_session.inc.php");

print "<form action=delete.php method=post name=FormList>";
include_once ("./include/menu.inc.php");

$theme->bar($lang->newsletter);
$theme->theme_file("newsletter.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
