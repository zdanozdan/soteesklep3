<?php
/**
 * Dodaj rekord do tabeli category$deep ($deep -> [1-5])
 * 
 * @author  m@sote.pl
 * \@template_version Id: add.php,v 2.2 2003/06/14 21:59:35 maroslaw Exp
 * @version $Id: add.php,v 1.4 2005/01/20 14:59:21 maroslaw Exp $
* @package    edit_category
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

if (ereg("^[0-9]+$",@$_REQUEST['deep'])) {
    $deep=$_REQUEST['deep'];
} else $deep=1;
$__deep=&$deep;

$theme->head_window();
$theme->bar($lang->edit_category_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("category$__deep","",array("category"=>"category"),
                $lang->edit_category_form_errors
                );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
