<?php
/**
 * PHP Template:
 * Lista rekordow tabeli dictionary
 * 
 * @author m@sote.pl
 * \@template_version Id: index.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp
 * @version $Id: help.php,v 2.3 2005/01/20 14:59:47 maroslaw Exp $
* @package    dictionary
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// naglowek
$theme->head();
$theme->page_open_head();
include("include/menu.inc.php");
$theme->bar($lang->dictionary_help_bar);
include("./html/help.html.php");
   
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");

/*
Dostosowuja ten skrypt do odpowiedniego zadania, nalezy edytowac obszary okreslone jako 
// config
... tu edytujemy
// end
 
*/
?>
