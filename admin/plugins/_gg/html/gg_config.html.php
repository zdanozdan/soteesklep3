<form action="index.php" method="post">
<input type="hidden" name="update" value="true">
<table width="400" align="center">
  <tr>
    <td><?php print $lang->gg_title_form;?></td>    
  </tr>
  <tr>
    <td><textarea name="gg" cols=40 rows=10><?php print $gg_data;?></textarea></td>
  </tr>
  <tr><td><input type="submit" value="<?php print $lang->update;?>"></td></tr>
</table>
</form>