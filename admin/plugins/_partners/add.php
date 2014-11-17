<?php
/**
 * Dodaj rekord do tabeli partners
 * 
 * @author  pmalinski@sote.pl
 * @version $Id: add.php,v 1.6 2006/01/20 10:42:04 lechu Exp $
* @package    partners
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;


$theme->head_window();
$theme->bar($lang->partners_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("partners","",array("name"=>"string",
                                    "partner_id"=>"partner_id",
                                    "email"=>"email",
                                    "rake_off"=>"percentage",
                                    "login"=>"login",
                                    "password"=>"password",
                                    ),
                $lang->partners_form_errors
                );

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>