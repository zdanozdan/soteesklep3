<?php
/**
 * Wynik wyszukiwania transakcji wg. kryteriow zadanych przez uzytkownika
 * 
 * @author  m@sote.pl
 * @version $Id: search2.php,v 2.9 2005/01/20 14:59:35 maroslaw Exp $
* @package    order
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
 
// generuj SQL (zmienna $sql) dla zapytania wyszukiwania
// @return string $sql
include_once("./include/order_search.inc.php");

/**
* Wy¶wietl listê transakcji
*/
require_once ("./include/order_list.inc.php");
?>
