<?php
/**
* Kasowanie bazy danych
*
* @author rdiak@sote.pl
* @version $Id: index.php,v 1.4 2005/06/15 09:34:04 maroslaw Exp $
* @package    admin_users
* @subpackage importshop
*/
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
require_once ("./include/importshop.inc.php");

// zapisz dane w session_secure, wymagane dla obslugi no_session (dla streaming'u)
require_once ("include/save_auth_session.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->bar($lang->importshop_bar);

$importshop =& new ImportShop;

if(empty($_REQUEST['update'])) {
    $importshop->showForms();
} else {    
    if (! $importshop->action()) {
        $importshop->error_dbconnect="<font color=\"red\">".$lang->importshop_error['error_connectdb']."</font><p />\n";
        $importshop->showForms();
    } else {
        // poprawne po³±czenie z baza
        // ...
    }
}

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
