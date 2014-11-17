<?php
/**
* @version    $Id: menu_top.inc.php,v 2.3 2004/12/20 17:59:37 maroslaw Exp $
* @package    dictionary
*/
print "<table><tr>\n";
print "<td>"; $buttons->button($lang->icons['dictionary'],"/plugins/_dictionary/index.php"); print "</td>\n";
print "<td>"; $buttons->button($lang->icons['language_versions'],"/go/_lang_editor/index.php"); print "</td>\n";
print "<td>"; $buttons->button($lang->icons['configure'],"/plugins/_dictionary/configure.php"); print "</td>\n";
print "</tr></table>\n";
?>
