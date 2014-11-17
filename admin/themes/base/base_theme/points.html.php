<?php
/**
* @version    $Id: points.html.php,v 1.2 2004/12/20 18:01:23 maroslaw Exp $
* @package    themes
* @subpackage base_theme
*/
if (! empty($config->order_points)) {
    $global_points=$config->order_points;
} else $global_points=0;
?>

<p>

<form action=points.php method=post>
<input type=hidden name=update value=true>

<table align=center>
<tr>
<td><?php print $lang->points['title_edit']." ".$config->currency;?></td>
<td>
    <input type=text size=8 name=form[points] value='<?php print $global_points;?>'>
</td>
</tr>
<tr>
 <td></td><td><input type=submit value='<?php print $lang->edit_submit;?>'></td>
</tr>
</table>

</form>
