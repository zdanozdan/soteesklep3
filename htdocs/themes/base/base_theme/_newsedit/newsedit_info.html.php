<?php
/**
* @version    $Id: newsedit_info.html.php,v 1.2 2006/11/11 17:08:40 tomasz Exp $
* @package    newsedit
*/
global $theme;$config;
$theme->bar(my(@$rec->data['subject']));
?>
<br />
<div align="left"><?php $theme->back();?></div>
<br />
<div id="block_1">
<center>
  <table align="center" width="95%">
    <tr> 
      <td width="60%" valign="top" align="left">
        <b><?php print @$rec->data['subject'];?></b><br />
		<font style="font-size: 10px;">(<?php print @$rec->data['date_add'];?>)</font>
		<p><?php 
		@include_once ("news.html");
		print @$rec->data['description'];
		?></p>
      </td>
      <td width="40%" valign="top">
      <?php
      global $DOCUMENT_ROOT;
      for ($i=1;$i<=8;$i++) {
          $id=$rec->data['id'];
          if (! empty($rec->data["photo$i"])) {
              $photo=$rec->data["photo$i"];
              if (file_exists("$DOCUMENT_ROOT/plugins/_newsedit/news/$id/$photo")) {
                  print "<img src=/plugins/_newsedit/news/$id/$photo border=$theme->img_border><p>";
              }
          }
      } // end for
      ?>
      </td>
    </tr>
  </table>
</center>
</div>
