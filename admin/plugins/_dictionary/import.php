<?php
/**
 * Import kategorii z tabeli main do dictionary
 * Wywolanie funkcji db2array i array2dictionary z klasy Main2dictionary
 * odpowiedzialnych za "przeniesienie kategorii" z tabeli main do tabeli dictionary 
 *
 * @author piotrek@sote.pl
 * @version $Id: import.php,v 2.5 2005/01/20 14:59:47 maroslaw Exp $
* @package    dictionary
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

require_once ("./include/main2dictionary.inc.php");

$m2dictionary = new Main2dictionary; //definicja klasy
$m2dictionary->db2array();
$m2dictionary->array2dictionary();

// naglowek
$bar=$lang->dictionary_catgen_bar;
$theme->head();
$theme->page_open_head();

$__status=$lang->dictionary_catgen_ok;

// pokaz liste produktow
include_once ("./index.php");
exit;

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
