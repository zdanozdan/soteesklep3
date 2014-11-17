<?php
/**
 * Wynik wyszukiwania uzytkwonikow
 *
 * @author  m@sote.pl
 * @version $Id: search2.php,v 2.5 2005/01/20 14:59:43 maroslaw Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// generuj SQL (zmienna $sql) dla zapytania wyszukiwania
include_once("./include/users_search.inc.php");

/**
* Lista klientów zarejestrowanych.
*/
require_once ("./include/users_list.inc.php");
?>
