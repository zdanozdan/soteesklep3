<?php
/**
 * Dokumentacja g³ówna sklepu. Wyswietlenie linków do dokumentacji.
 *
 * @author m@sote.pl
 * @version $Id: help.html.php,v 1.7 2005/12/13 10:16:25 krzys Exp $
* @package    help
 */
 ?>
<p />
<?php print $lang->help_info;?>
<p />

<table>
<tr>
  <td>
    <a href="/go/_help/doc/enduser_pl.pdf"><?php print $lang->help_cols['enduser']." ".@$lang->help_cols['pdf'];?></a>
  </td>
 </tr>

</table>
<p>
 <?php print $lang->help_doc;?>
</p>


<b><?php print $lang->help_service_title;?></b><br />
<?php print $lang->help_service;?>
