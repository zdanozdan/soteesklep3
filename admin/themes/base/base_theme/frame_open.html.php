<?php
/**
* @version    $Id: frame_open.html.php,v 1.2 2004/12/20 18:01:20 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
if (! empty($align)) {
    print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=$width align=$align>\n";
} else {
    print "<TABLE border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=$width align=$align>\n";
}
print "  <TR>\n";
print "  <td nowrap=\"nowrap\" valign=\"top\">";
print "  <fieldset >";
print "  <legend>$title</legend>";
?>
