<?php
/**
* Skrypt wy¶wietlaj±cy formularz wyszukiwania zaawansowanego + obs³uga formularza.
* 
* @author  m@sote.pl
* @version $Id: adv_search.php,v 2.2 2005/01/20 14:59:39 maroslaw Exp $
* @package    search
*/
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga formularza.
*/
require_once ("HTML/QuickForm.php");

// naglowek
$theme->head();
$theme->page_open_head();

$theme->bar($lang->search_adv_title);
print "<p />\n";

/**
* Wy¶wietl formularz HTML.
*/
include_once ("./html/adv_search.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>