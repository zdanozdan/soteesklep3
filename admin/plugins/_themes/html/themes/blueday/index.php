<?php
/**
* @version    $Id: index.php,v 1.5 2005/03/14 14:09:25 lechu Exp $
* @package    themes
* \@lang
*/
include_once("./html/themes/config/config.inc.php");
$theme->bar("$lang->buttons_edit_theme $thm");
$margins = 23;
$margins_right = 24;
$border_width = @$_REQUEST['border_width'];
if($border_width == ''){
    $border_width = 1;
    $checked = '';
}
else
    $checked = 'checked';
    $design_mode = "
    alt='$lang->themes_clik2change'
    title='$lang->themes_clik2change'
    border=$border_width
    class=design_mode
    onmouseover='event.cancelBubble=true; this.style.borderStyle=\"solid\"; window.status=\"$lang->themes_clik2change\";'
    onmouseout='this.style.borderStyle=\"dashed\"; window.status=\"\";'
    onclick='elementClick(this, event);'
    ";

echo "
<style>
.design_mode
{
    border-style: dashed;
    border-width: " . $border_width . "px;
    border-color: black;
    cursor: pointer;
}
</style>

<script>
    function elementClick(sender, event){
        event.cancelBubble = true;
        window.open('action_edit.php?popup=1&thm=$thm&element_id=' + sender.id + '&' + sender.id + '=1', 'window', 'width=400, height=300, scrollbars=1');
    }
</script>

$lang->themes_edit_text<br><br>
<table width=100% >
    <tr>
        <td width=50% align=left>
          <form name=frm1 action='action_edit.php?thm=" . $_REQUEST['thm'] . "' method='POST'>
            $lang->themese_hide_frames
            <input type='checkbox' name=border_width value='0' $checked onclick='frm1.submit()'>
          </form>
        </td>
        <td width=50% align=right>";
$buttons->button($lang->themes_update_changes, "'javascript:window.open(\"action_edit.php?popup=1&update_theme=1&thm=$thm\", \"window\", \"width=300, height=150, scrollbars=1\");void(0);'");
echo "
        </td>
    <tr>
</table>
";
echo "
    <table width=100% height=100% cellspacing=0 cellpadding=0 bgcolor=" . $tc['colors']['body_background'] . " border=0 style='color: " . $tc['colors']['base_font'] . "'>
        <tr>
            <td colspan=11 width=100%>";
include_once("./html/themes/" . $_REQUEST['thm'] . "/head.html.php");
echo"
                        <tr>
                             <TD align=left bgcolor=" . $tc['colors']['color_1'] . ">&nbsp;
                             </TD>
                             <TD align=left bgcolor='" . $tc['colors']['input_border'] . "'><img width='1' height='1'></TD>
                             <TD align=left >&nbsp;
                             </TD>
                            <td align=center valign=top>
                                <table>
                                    <tr>
                                        <td>
";
                
                include_once("./html/themes/" . $_REQUEST['thm'] . "/box1.html.php");
                echo "
                                        </td>
                                        <td>
                                            &nbsp;
                                        </td>
                                        <td>
                ";
                
                include_once("./html/themes/" . $_REQUEST['thm'] . "/box2.html.php");
                
                echo"
                                        </td>
                                    </tr>
                                </table>
                            </td>
                             <TD align=left  >&nbsp;
                             </TD>
                             <TD align=left bgcolor='" . $tc['colors']['input_border'] . "'><img width='1' height='1'></TD>
                             <TD align=left width=175 bgcolor=" . $tc['colors']['color_1'] . ">&nbsp;
                             </TD>
                        </tr>
                    </table>
                </td>
        <tr>
            <td align=center valign=top colspan=11>";
include_once("./html/themes/" . $_REQUEST['thm'] . "/foot.html.php");
echo"
            </td>
        </tr>
    </table>";
?>
