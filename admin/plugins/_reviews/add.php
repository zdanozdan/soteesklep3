<?php
/**
 * PHP Template:
 * Dodaj rekord do tabeli reviews
 * 
 * @author m@sote.pl
 * \@template_version Id: add.php,v 2.1 2003/03/13 11:28:47 maroslaw Exp
 * @version $Id: add.php,v 1.5 2005/01/20 15:00:08 maroslaw Exp $
* @package    reviews
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");

$theme->head_window();
$theme->bar($lang->reviews_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("reviews","",array("user_id"=>"user_id"),
                $lang->reviews_form_errors
                );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
