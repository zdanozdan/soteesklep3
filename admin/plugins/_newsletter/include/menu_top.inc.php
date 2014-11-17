<?php
/**
* Menu dodatkowe systemu newsletter. Dodatkowe "buttony" na górze z lewej strony.
*

* @author  rdiak@sote.pl
* @version $Id: menu_top.inc.php,v 2.10 2006/03/03 07:53:02 krzys Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
*/

print "\n\n<div align=left>\n";
print "<table>\n";
print "<tr>\n";
print "  <td>";$buttons->button($lang->newsletter_options['users'],"/plugins/_newsletter/_users/index.php");print "  </td>\n";
print "  <td>";$buttons->button($lang->newsletter_options['groups'],"/plugins/_newsletter/_groups/index.php");print "</td>\n";
print "  <td>";$buttons->button($lang->newsletter_options['send'],"/plugins/_newsletter/_users/send.php");print "</td>\n";
print "  <td>";$buttons->button($lang->newsletter_options["config"],"/plugins/_newsletter/_users/config.php"); print "</td>\n";


print "</tr>\n";
print "</table>\n";
print "</div>\n\n";
?>
