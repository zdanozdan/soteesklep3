<?php
/**
* Podgl±d opcji zaawansowanych produktu.
*
* @author  m@sote.pl
* @version $Id: edit_xml_options_preview.html.php,v 2.5 2004/12/20 17:58:01 maroslaw Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/
?>
<style type="text/css">
.code {color: brown; text-decoraton: underline; face: helvetica}
</style>

<table width=100%>
<tr>
  <td valign=top width=100%>

    <?php 
    // atrybuty
    // dodaj obsluge pola xml_options
    global $result,$my_xml_options;
    if (! empty($my_xml_options)) {
        include_once ("include/xml_options.inc");
        $my_xml_options->show($result);
    }
    ?>

  </td>
</tr>
</table>
