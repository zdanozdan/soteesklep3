<?php
/**
* Szablon wygl±du nag³ówka wykresu.
*
* @author  lech@sote.pl
* @version $Id: chart_head.html.php,v 1.1 2004/05/25 11:03:44 lechu Exp $
* @package simplebarchart
*/
        include_once(SBC_DOCUMENT_ROOT . SBC_PATH . "html/chart_script.js");
        echo "
        <table width=" . $this->width . " border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td width=0 height=0 bgcolor=black rowspan=$rowspan><img src='" . $images_path . "spacer.gif' height=" . $this->border . " width=" . $this->border . "></td>
            <td height=0 bgcolor=black colspan=7><img src='" . $images_path . "spacer.gif' height=" . $this->border . " width=" . $this->border . "></td>
            <td width=0 height=0 bgcolor=black rowspan=$rowspan><img src='" . $images_path . "spacer.gif' height=" . $this->border . " width=" . $this->border . "></td>
        </tr>
        <tr>
            <td colspan=7><img src='" . $images_path . "spacer.gif' height=" . $this->cellpadding . " width=1></td>
        </tr>
        <tr>
            <td colspan=7 width=100% style='text-align: center'>" . $this->data['title'] . "</td>
        </tr>
        <tr>
            <td colspan=7><img src='" . $images_path . "spacer.gif' height=" . $this->cellpadding . " width=1></td>
        </tr>
        ";
?>