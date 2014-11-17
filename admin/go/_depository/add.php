<?php
/**
 * Dodaj rekord do tabeli depository
 * 
 * @author  
 * @template_version Id: add.php,v 2.4 2004/02/12 10:47:48 maroslaw Exp
 * @version $Id: add.php,v 1.2 2006/02/27 10:44:33 lukasz Exp $
 * @package soteesklep
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("./../../../include/head.inc");
// end naglowek php

$theme->head_window();
$theme->bar($lang->depository_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("depository","",array(
                                    "user_id_main"=>"string",
                                    "num"=>"int",
                                    "min_num"=>"int",
                                    "id_deliverer"=>"int",
                                   ),
                $lang->depository_form_errors
                );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
