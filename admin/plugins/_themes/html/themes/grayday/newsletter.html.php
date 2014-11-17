<?php
/**
* @version    $Id: newsletter.html.php,v 1.2 2004/12/20 18:01:06 maroslaw Exp $
* @package    themes
*/
global $config, $prefix;
print "<table align=\"center\" width=\"163\" bgcolor=\"#D7D7D9\" align=center>";
print "  <tr>";
print "    <td  width=100%>";
$this->file("newsletter_window.html","");
print "<form action=\"/go/_newsletter/index.php\">";
print "  <table border=0 cellspacing=0 cellpadding=0 width=100%>\n";
print "    <tr>\n";
print "      <td><input type=\"text\" name=\"email\" style=\"width: 133px; margin-top: 2px; margin-right: 3px;\"></td>\n";
print "      <td><input src=\""; $this->img($prefix . $config->theme_config['layout_buttons']['newsletter_plus']); echo "\" type=\"image\" name=\"newsletter\" border=0 style='border-width: 0px; margin-left: 2px; margin-top: 2px; margin-bottom: 1px;' value=\" $lang->symbol_add \"></td>\n";
print "    </tr>\n";
print "		</table>\n";
print "</form>\n";
print "    </td>";
print "  </tr>";
print "</table>";
?>
