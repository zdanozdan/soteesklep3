<?php
/**
 * Lista rekordow tabeli deliverers
 * 
 * @author  lech@sote.pl
 * @template_version Id: index.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: index.php,v 1.2 2006/03/30 10:34:18 lechu Exp $
 * @package soteesklep
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// config
$sql="SELECT * FROM deliverers ORDER BY id";
$bar=$lang->deliverers_list_bar;
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
