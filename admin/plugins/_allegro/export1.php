<?php
/**
 * Strona g³ówna modu³u Allegro 
 *
 * @author  r@sote.pl
 * @version $Id: export1.php,v 1.2 2006/04/12 12:00:28 scalak Exp $
*  @package allegro    
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
 * Nag³ówek skryptu
 */
require_once ("../../../include/head.inc");
require_once ("../../include/allegro.inc.php");
require_once ("include/metabase.inc");

$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->allegro_bar["index"]);

$allegro=new Allegro;

global $database;
if(is_array($_REQUEST['del'])) {
    foreach($_REQUEST['del'] as $key=>$value) {
        if($value=='on') {
            $database->sql_delete("allegro_auctions","id=".$key);
            print $key." - aukcja skasowana"; 
        }
    }
}
foreach($_REQUEST['send'] as $key=>$value) {
    if($value == 'on') {
        $allegro->sendAuctions($key);
    }
}


//$allegro->sendAuctions();

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

