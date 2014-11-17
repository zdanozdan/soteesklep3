<?php
/**
 * Menu sklepu w dodatkowym oknie nawigacyjnym
 * 
 * @author m@sote.pl
 * @version $Id: menu.php,v 2.3 2005/01/20 14:59:16 maroslaw Exp $
* @package    default
 */

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../include/head.inc");
// end naglowek php

// naglowek
$theme->head_window();

$theme->theme_file("menu.html.php");

$theme->foot_window();
// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
