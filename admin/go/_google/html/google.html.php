<?php
/**
* Strona HTML z opcja wywo³ania generowania stron statycznych
*
* @author  m@sote.pl
* @version $Id: google.html.php,v 1.1 2005/08/02 10:37:22 maroslaw Exp $
* @package google
*/

print $lang->google_info_gen;
print "<center>";
$google->formStatProductPages();
print "</center>";

print "<p />\n";
print $lang->google_add;
?>
