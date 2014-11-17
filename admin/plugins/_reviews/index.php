<?php
/**
 * PHP Template:
 * Lista rekordow tabeli reviews
 * 
 * @author m@sote.pl
 * \@template_version Id: index.php,v 2.1 2003/03/13 11:28:50 maroslaw Exp
 * @version $Id: index.php,v 1.6 2005/10/20 06:44:45 krzys Exp $
* @package    reviews
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// config
$sql="SELECT * FROM reviews ORDER BY id DESC";
$bar=$lang->reviews_list_bar;
require_once ("./include/list_th.inc.php");
$list_th=list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

require_once ("include/list.inc.php");

   
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
