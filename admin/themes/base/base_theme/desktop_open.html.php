<?php
/**
* @version    $Id: desktop_open.html.php,v 1.3 2004/12/20 18:01:19 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
if (! empty($align)) {
    print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=$width align=$align>\n";
} else {
    print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=$width>\n";
}
print "  <TR>\n";
print "    <TD valign=top><IMG src=";$this->img("_img/_buttons/c1.png"); print " width=7 height=7></TD>\n";
print "    <TD background="; $this->img("_img/_buttons/c8.png"); print "></TD>\n";
print "    <TD valign=top><IMG src="; $this->img("_img/_buttons/c6.png"); print " width=7 height=7></TD>\n";
print "  </TR>\n";
print "  <TR>\n";
print "    <TD background="; $this->img("_img/_buttons/c2.png"); print " width=7 height=2></TD>\n";
print "    <TD>";
?>
