<?php
/**
 * Dodaj produkt do transakcji.
 *
 * @author m@sote.pl
 * @version $Id: product_add.php,v 2.3 2005/01/20 14:59:35 maroslaw Exp $
* @package    order
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

// naglowek
$theme->head_window();

print "ADD";

$theme->foot_window();
// stopka
include_once ("include/foot.inc");
?>
