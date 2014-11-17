<?php
/**
 * Lista rekordow tabeli main_keys
 * 
 * @author  m@sote.pl
 * \@template_version Id: index.php,v 2.2 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: index.php,v 1.5 2005/01/20 14:59:53 maroslaw Exp $
* @package    main_keys
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

// config
$sql="SELECT * FROM main_keys ORDER BY order_id DESC";
$bar=$lang->main_keys_list_bar;
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
