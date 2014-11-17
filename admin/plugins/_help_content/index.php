<?php
/**
 * Lista rekordow tabeli help_content
 * 
 * @author  lech@sote.pl
 * \@template_version Id: index.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: index.php,v 1.3 2005/01/20 14:59:53 maroslaw Exp $
* @package    help_content
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// config
$sql="SELECT * FROM help_content ORDER BY id";
$bar=$lang->help_content_list_bar;
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
