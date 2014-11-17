<?php
/**
 * Lista rekordow tabeli partners
 * 
 * @author  pmalinski@sote.pl
 * @version $Id: index.php,v 1.4 2005/01/20 15:00:02 maroslaw Exp $
* @package    partners
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// config
$sql="SELECT * FROM partners ORDER BY id";
$bar=$lang->partners_list_bar;
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
