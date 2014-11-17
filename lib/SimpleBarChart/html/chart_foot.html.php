<?php
/**
* Szablon wygl±du stopki wykresu
*
* @author  lech@sote.pl
* @version $Id: chart_foot.html.php,v 1.3 2005/01/18 11:52:30 lechu Exp $
* @package simplebarchart
*/
    global $lang;
    $sum = array_sum($this->data['series']);
    echo "
        <tr>
            <td colspan=7><img src='" . $images_path . "spacer.gif' height=" . $this->cellpadding . " width=1></td>
        </tr>
        <tr>
            <td colspan=7 align=right>" . $lang->sum . ": <b>$sum</b>&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td colspan=7><img src='" . $images_path . "spacer.gif' height=" . $this->cellpadding . " width=1></td>
        </tr>
        <tr>
            <td colspan=7 align=right><a href='javascript:void(0)' mode='rozstrzel' name='" . md5($this->data['title']) . "' onclick='Stretch(this);'>" . $lang->underline_diff . "</a>&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td colspan=7><img src='" . $images_path . "spacer.gif' height=" . $this->cellpadding . " width=1></td>
        </tr>
        <tr>
            <td height=1 bgcolor=black colspan=7><img src='" . $images_path . "spacer.gif' height=" . $this->border . " width=" . $this->border . "></td>
        </tr>
        </table>
    ";
?>