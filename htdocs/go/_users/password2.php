<?php
/**
 * Wyswietlenie strony po zmianie hasla klienta
 *
 * @author  m@sote.pl
 * @version $Id: password2.php,v 2.3 2005/01/20 15:00:23 maroslaw Exp $
* @package    users
 */

$global_database=false;
$global_secure_test=true; 
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// sprawdz, czy klient jest zalogowany, jesli nie to wyswietl formularz logowania
if (empty($_SESSION['global_id_user'])) {
    include_once ("./index.php");
    exit;
}


$theme->page_open_foot("page_open_1_foot");
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
