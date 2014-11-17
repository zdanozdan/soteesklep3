<?php
/**
* Formularz edycji kolorów
* @version    $Id: edit_colors.html.php,v 1.4 2004/12/20 18:00:57 maroslaw Exp $
* @package    themes
*/
echo "
$lang->themes_color_text<br>

<table width=100%>
    <tr>
        <td width=100% align=right>";
$buttons->button($lang->themes_update_changes, "'javascript:window.open(\"action_edit.php?popup=1&update_theme=1&thm=$thm\", \"window\", \"width=300, height=150, scrollbars=1\");void(0);'");
echo "
        </td>
    <tr>
</table>
";

echo "
<table>
";
while(list($key, $val) = each($config->theme_config['colors'])) {
    echo "
    <form action=action_edit_colors.php method=post>
        <input type=hidden name=thm value='$thm'>
        <input type=hidden name=color_name value='$key'>
        <input type=hidden name=color_update value=1>
        <tr>
            <td>" . $lang->color_names[$key] . ":</td>
            <td><input type=text name=color_value value='$val' style='width: 60px; font-family: courier'></td>
            <td bgcolor=$val>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td><input type=submit value=$lang->themes_approve></td>
        </tr>
    </form>
    ";
}
echo "
</table>
";
?>
