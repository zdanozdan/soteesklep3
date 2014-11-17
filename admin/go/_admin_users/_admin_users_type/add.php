<?php
/**
 * Dodaj rekord do tabeli admin_users_type.
 * 
 * @author m@sote.pl
 * @version $Id: add.php,v 2.5 2005/01/20 14:59:16 maroslaw Exp $
* @package    admin_users
* @subpackage admin_users_type
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu 
*/
require_once ("../../../../include/head.inc");

/**
* Konfiguracja uprawnieñ.
*/
require_once ("config/auto_config/perm_config.inc.php");

//# dodaj obsluge ftp, wymagane przy uploadowaniu plikow i generowaniu pliku konfiguracyjnego
// require_once ("include/ftp.inc.php");

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");

$theme->head_window();
$theme->bar($lang->admin_users_type_add_bar);

require_once("include/mod_table.inc.php");
$mod_table = new ModTable;

// definiuj pola, ktore maja byc wypelnione oraz komuniakty o bledach przypisane do tych pol
$mod_table->add("admin_users_type","",array("type"=>"string",
                                   "p_all"=>"string"),
                $lang->admin_users_type_form_errors
                );

//# zapisz wartosci tablicy w pliku configuracyjnym
// include_once ("./include/user_config.inc.php");

$theme->foot_window();

// stopka php
include_once ("include/foot.inc");
// end stopka php
?>
