<?php
/**
 * Dodaj rekord do tabeli deliverers
 * 
 * @author  lech@sote.pl
 * @template_version Id: add.php,v 2.4 2004/02/12 10:47:48 maroslaw Exp
 * @version $Id: add.php,v 1.2 2006/03/30 10:34:18 lechu Exp $
 * @package soteesklep
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

$theme->head_window();
$theme->bar($lang->deliverers_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("deliverers","",array("name"=>"string",
                                   "email"=>"string"),
                $lang->deliverers_form_errors
                );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
