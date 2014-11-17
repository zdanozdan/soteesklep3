<?php
/**
 * Lista newsów z danej grupy.
 *
 * @author rdiak@sote.pl m@sote.pl
 * @version $Id: index.php,v 2.10 2005/01/20 14:59:57 maroslaw Exp $
 *
 * \@verified 2004-03-19 m@sote.pl
* @package    newsedit
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head();

// lista grup newsow
include_once ("include/menu_top.inc.php");

//include_once ("../include/menu.inc.php");
include_once ("./include/menu.inc.php");
$theme->bar($lang->newsedit_bar);

print "<form action=delete.php method=post name=FormList>";
// funkcja prezentujaca wynik zapytania w glownym oknie strony 
include_once ("include/dbedit_list.inc");
include_once ("./include/newsedit_row.inc.php");

$dbedit = new DBEditList;

if (! empty($__newsedit_group['id'])) {
    $group_id=addslashes($__newsedit_group['id']);
    $where="WHERE id_newsedit_groups=$group_id ";
    $sql="SELECT * FROM newsedit $where OR group1=$group_id OR group2=$group_id OR group3=$group_id ORDER BY ordercol DESC";
} else { 
   $sql="SELECT * FROM newsedit ORDER BY ordercol DESC";
}



$dbedit->top_links="true";
$dbedit->record_class="NewsEditRow";
print "<p>";

include_once ("./include/list_th.inc.php");
$dbedit->start_list_element=newsedit_list_th();

$dbedit->show();
$theme->page_open_foot();
print "</form>";
  
$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
