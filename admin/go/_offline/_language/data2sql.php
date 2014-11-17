<?php
/**
 * Odczytaj zalaczony cennik 
 *
 * @author  rdiak@sote.pl
 * @version $Id: data2sql.php,v 1.1 2005/04/21 07:12:06 scalak Exp $
* @package    offline
* @subpackage main
 */

$global_database=true;
$global_secure_test=true;
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}

/**
* Nag³ówek skryptu
*/
require_once ("../../../../include/head.inc");

// najpierw dokonujemy zmian, potem wyswietlamy wyglad, z juz zaktualizowanymi danymi
// naglowek
$theme->head();
$theme->page_open_head();

include_once("./include/menu.inc.php");

// zapisz dane w session_secure, wymagane dla obslugi no_session (dla streaming'u)
require_once ("include/save_auth_session.inc.php");

// bar = true juz wyswietlono bar
if (empty($bar)) {
    $theme->bar($lang->offline_update_now);
}

$file_data="$DOCUMENT_ROOT/tmp/$config->offline_filename";

if (file_exists($file_data)) {

    if(filesize ($file_data) > 0 ) { 
        require_once ("./html/offline.html.php");
    } else {
        $theme->theme_file("_offline/offline_size.html.php"); 
    }
} else {
    $theme->theme_file("_offline/offline_not_file.html.php"); 
}

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
