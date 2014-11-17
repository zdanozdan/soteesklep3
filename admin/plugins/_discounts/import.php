<?
/**
 * Aktualizacja kategorii
 *
 * Wywolanie funkcji db2array i array2discounts z klasy Main2discounts
 * odpwoedzialnych za "przeniesienie kategorii" z tabeli main do tabeli discounts 
 *
 * @author piotrek@sote.pl
 * \@template_version Id: index.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: import.php,v 2.4 2005/01/20 14:59:49 maroslaw Exp $
* @package    discounts
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php


require_once ("./include/main2discounts.inc.php");
$m2d = new Main2discounts;

$m2d->db2array();
$m2d->array2discounts();

// naglowek
$bar=$lang->discounts_catgen_bar;
$theme->head();
$theme->page_open_head();
include("include/menu.inc.php");

$theme->bar($lang->discounts_catgen_bar);

print "<BR>$lang->discounts_catgen_ok";

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
