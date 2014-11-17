<?php
/**
* Aktualizacja lang'ów w bazie danych na podstwiea danych z plików lang.inc.php.
*
* @author  m@sote.pl
* @version $Id: update2.php,v 1.5 2005/03/14 14:03:36 lechu Exp $
* @package    lang_editor
* \@lang
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");
/* Klasa LangEditor */ 
require_once("./include/lang_editor.inc.php"); 
$lang_editor =& new LangEditor;

$theme->head();
$theme->page_open_head();

$theme->bar($lang->lang_editor_update_title);

$query="DELETE from lang";
$result=$db->Query($query);
if ($result==0) die ($db->Error());

// langi w sklepie
$lang_str = '';
$coma = '';
for($i = 0; $i < count($config->langs_symbols); $i++) {
    if($config->langs_active[$i] == 1) {
        $lang_str .= $coma . $config->langs_symbols[$i];
        $coma = ', ';
    }
}

$lang_editor =& new LangEditor($lang_str, 'htdocs');
$query_tab=$lang_editor->prepareInsertQuery();

foreach ($query_tab as $query) {
    $result=$db->Query($query);
    if ($result==0) die ($db->Error());
} // end foreach

// langi w panelu admina
$lang_editor =& new LangEditor("pl, en, de", 'admin');
$query_tab=$lang_editor->prepareInsertQuery();

foreach ($query_tab as $query) {
    $result=$db->Query($query);
    if ($result==0) die ($db->Error());
} // end foreach

print "<p><center>$lang->lang_editor_update_ok</center><p>\n";

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");

?>
