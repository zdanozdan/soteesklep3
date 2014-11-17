<?php
/**
* @version    $Id: opt.html.php,v 1.2 2004/12/20 17:58:37 maroslaw Exp $
* @package    opt
*/
?>
<P>

<?php
$onclick="onclick=\"window.open('','window','width=525,height=380,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";

$theme->desktop_open("100%");
print $lang->opt_info;
print "<P>";
print "<B>".$lang->opt_select_action.":</B><P>";
print "<table>";
print "<tr><td>";$buttons->button($lang->opt_buttons['category'],"category.php $onclick target=window");print "</td><td>".$lang->opt_description['category']."</td></tr>";
print "<tr><td>";$buttons->button($lang->opt_buttons['producers'],"producers.php $onclick target=window");print "</td><td>".$lang->opt_description['producers']."</td></tr>";
print "<tr><td>";$buttons->button($lang->opt_buttons['category_producers'],"category_producers.php $onclick target=window");print "</td><td>".$lang->opt_description['category_producers']."</td></tr>";
print "</table>";
$theme->desktop_close();
?>
