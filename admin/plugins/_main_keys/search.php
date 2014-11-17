<?php
/**
 * Formularz wyszukiwania rekordow tabeli main_keys
 * 
 * @author  m@sote.pl
 * @version $Id: search.php,v 1.3 2005/01/20 14:59:54 maroslaw Exp $
* @package    main_keys
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->main_keys_search_title);

include_once ("./html/search.html.php");

// stopka
$theme->page_open_foot();
$theme->foot();
include_once ("include/foot.inc");
?>
