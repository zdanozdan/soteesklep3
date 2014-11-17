<?php
/**
* Prezentacja produktow w wierszu.
* 
* @version    $Id: newsedit_row.html.php,v 1.1 2005/08/08 14:21:44 maroslaw Exp $
* @package    themes
* @subpackage google
*/
global $__news_row, $theme;


print "<tr><td>\n";
$this->newsSubject();print "<br>";
$this->newsShortDescription();
print "<p /><br />\n";
print "</td></tr>\n";
?>

