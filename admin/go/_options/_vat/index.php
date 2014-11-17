<?php
/**
 * PHP Template:
 * Lista rekordow tabeli vat
 * 
 * @author m@sote.pl
 * \@template_version Id: index.php,v 2.1 2003/03/13 11:28:50 maroslaw Exp
 * @version $Id: index.php,v 1.3 2005/01/20 14:59:33 maroslaw Exp $
* @package    options
* @subpackage vat
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

// config
$sql="SELECT * FROM vat ORDER BY id";
$bar=$lang->vat_list_bar;
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
