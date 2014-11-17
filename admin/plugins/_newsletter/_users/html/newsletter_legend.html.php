<?php
/**
* Legenda systemu wysy³ania newslettera.
*
* @author  rdiak@sote.pl
* @version $Id: newsletter_legend.html.php,v 2.6 2004/12/20 18:00:18 maroslaw Exp $
*
* verified 2004-03-10 m@sote.pl
* @package    newsletter
* @subpackage users
*/

?>
<?php global $lang;?>
<table>
<tr>
  <td>
    <img src='/themes/base/base_theme/_img/line_blue.png'  width=10 height=10>
  </td>
  <td><?php print $lang->newsletter_sent_ok;?></td>
</tr>

<tr>
  <td>
    <img src='/themes/base/base_theme/_img/line_green.png' width=10 height=10>
  </td>
<td><?php print $lang->newsletter_sent_error1;?></td>
</tr>

<tr>
  <td>
    <img src='/themes/base/base_theme/_img/line_red.png' width=10 height=10>
  </td>
  <td><?php print $lang->newsletter_sent_error2;?></td>
</tr>
</table>
