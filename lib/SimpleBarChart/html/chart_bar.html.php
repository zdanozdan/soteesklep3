<?php
/**
* Szablon wygl±du pojedynczego s³upka wykresu 
*
* @author  lech@sote.pl
* @version $Id: chart_bar.html.php,v 1.1 2004/05/25 11:03:44 lechu Exp $
* @package simplebarchart
*/
        echo "
        <tr>
            <td><img src='" . $images_path . "spacer.gif' width=" . $this->cellpadding . " height=1></td>
            <td class=chart_name nowrap>
                $data_row
            </td>
            <td><img src='" . $images_path . "spacer.gif' width=" . $this->cellpadding . " height=1></td>
            <td rowspan=2 width=" . $this->width . " style='background-image: url(" . $images_path . "scale_" . $scale . ".gif); background-repeat: repeat; background-position-y: center;'>
                <img src='" . $images_path . "spacer.gif' height=1 width=" . $this->width . "><br>
                <table width=$value cellspacing=0 cellpadding=0 >
                    <tr>
                        <td><div><img src='$bar_unit_image' name=bar_" . md5($this->data['title']) . " height=10 width=$value><input type=hidden id=width1 name=width1 value=$value><input type=hidden id=width2 name=width2 value=$value2></div></td>
                    </tr>
                </table></td>
            <td><img src='" . $images_path . "spacer.gif' width=" . $this->cellpadding . " height=1></td>
            <td class=chart_value nowrap align=right>$value_str</td>
            <td><img src='" . $images_path . "spacer.gif' width=" . $this->cellpadding . " height=1></td>
        </tr>
        <tr>
            <td colspan=3><img src='" . $images_path . "spacer.gif' height=" . $this->cellpadding . " width=1></td>
            <td colspan=3><img src='" . $images_path . "spacer.gif' height=" . $this->cellpadding . " width=1></td>
        </tr>
        ";
?>