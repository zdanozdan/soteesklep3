<?php
/**
 * Usun rekordy z tabeli partners
 * 
 * @author  pmalinski@sote.pl
 * @version $Id: delete.php,v 1.5 2006/01/20 10:42:04 lechu Exp $
* @package    partners
 */

// naglowek php
$global_database=true; $global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->partners_bar);
print "<p>";

// usun zaznaczone rekordy
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("partners","id");
if (! empty($_REQUEST['del'])) {
    foreach ($_REQUEST['del'] as $id=>$val) {
        if (! empty($val)) {
            $mdbd->delete("users", "id_partner=?", array($id => "int"));
        }
    }
}

$theme->page_open_foot();
$theme->foot();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
