<?php
/**
 * Edytuj rekord z tabeli partners
 * 
 * @author  pmalinski@sote.pl
 * @version $Id: edit.php,v 1.7 2006/01/20 10:42:04 lechu Exp $
* @package    partners
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

// zapamiatej informacje ze dokonujemy edycji rekordu
$__edit=true;

$theme->head_window();
$theme->bar($lang->partners_update_bar);

require_once("include/mod_table.inc.php");
$id_partner = $_REQUEST['id'];
if (empty($id_partner))
    die("Invalid ID");
$mod_table = new ModTable;
$mod_table->update("partners","",array("name"=>"string",
                                       "partner_id"=>"string",
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