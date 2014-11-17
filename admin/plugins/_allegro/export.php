<?php
/**
 * Strona g³ówna modu³u Allegro 
 *
 * @author  r@sote.pl
 * @version $Id: export.php,v 1.5 2006/04/12 11:59:30 scalak Exp $
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

$theme->head();
$theme->page_open_head();

print "<form action=export1.php method=post name=FormList>";
include_once ("./include/menu.inc.php");
$theme->bar($lang->allegro_bar["export"]);

// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
include_once ("./include/allegro_row.inc.php");
$dbedit = new DBEditList;
$sql="SELECT * FROM allegro_auctions WHERE allegro_number is NULL OR allegro_number=''";
$dbedit->top_links="false";
$dbedit->record_class="AllegroRow";
print "<p>";

include_once ("./include/list_th.inc.php");
$dbedit->start_list_element=allegro_list_th();

$dbedit->show();
if(!empty($dbedit->records)) {
    print "<center><input type=submit name=submit value=".$lang->allegro_send."></center>";
}    
$theme->page_open_foot();
print "</form>";


$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>

