<?php
/**
 * PHP Template:
 * Lista rekordow tabeli scores - oceny
 * 
 * @author m@sote.pl
 * @version $Id: index.php,v 1.3 2005/01/20 15:00:09 maroslaw Exp $
* @package    reviews
* @subpackage scores
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../../include/head.inc");
// end naglowek php

// config
$sql="SELECT * FROM scores ORDER BY id";
$bar=$lang->scores_list_bar;
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

?>
