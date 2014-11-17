<?php
/**
 * PHP Template:
 * Usun rekordy z tabeli ask4price
 * 
 * @author m@sote.pl lech@sote.pl
 * @version $Id: delete.php,v 1.2 2005/06/29 09:48:23 lechu Exp $
* @package    ask4price
* @ask4price
 */

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

reset($_REQUEST['del']);

while (list($key, $val) = each($_REQUEST['del'])) {
    $mdbd->delete("ask4price", "request_id=?", array($key => "int"));
}

// naglowek
$theme->head();
$theme->page_open_head();


include_once ("./include/menu.inc.php");
$theme->bar($lang->ask4price_bar);
print "<p>";
echo $lang->ask4price_records_deleted;
// usun zaznaczone rekordy
/*
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("ask4price","request_id");
*/
//# zapisz wartosci tablicy w pliku configuracyjnym 
// include_once ("./include/user_config.inc.php"); 

$theme->page_open_foot();

$theme->foot();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
