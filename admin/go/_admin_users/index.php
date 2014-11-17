<?php
/**
* Lista rekordów tabeli admin_users.
* Modyfikacje:<br><br>
*  * Lista rekordów tabeli admin_users.<br>
*  *<br>
*  * @author m@sote.pl<br>
* -<b>* \@template_version Id: index.php,v 1.3 2003/02/06 11:55:15 maroslaw Exp</b><br>
*  * @version $Id: index.php,v 2.5 2005/01/20 14:59:16 maroslaw Exp $<br>
*  
* @author m@sote.pl
* @version $Id: index.php,v 2.5 2005/01/20 14:59:16 maroslaw Exp $
* @package    admin_users
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu
*/
require_once ("../../../include/head.inc");
// end naglowek php

// config
$sql="SELECT * FROM admin_users ORDER BY id";
$bar=$lang->admin_users_list_bar;
require_once ("./include/list_th.inc.php");
$list_th=list_th();
// end

// naglowek
$theme->head();
$theme->page_open_head();

/**
* Wy¶wietl listê rekordów
*/
require_once ("include/list.inc.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
