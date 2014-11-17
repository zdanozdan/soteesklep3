<?php
/**
* @version    $Id: upload.html.php,v 1.2 2004/12/20 17:58:33 maroslaw Exp $
* @package    offline
* @subpackage main_keys
*/
?>
<form action=index.php method=post enctype="multipart/form-data">

<br>
<?php print $lang->offline_upload_info; ?>
<br><br>
<table align=center>
<tr>
  <td>
    <input type=file name=datafile size=10>
  </td>
  <td>
    <input type=submit value="<?php print $lang->submit_upload_file;?>">
  </td>
</tr>
</table>

</form>
