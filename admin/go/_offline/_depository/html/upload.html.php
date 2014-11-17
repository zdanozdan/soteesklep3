<?php
/**
* £adowanie pliku z danymi offliowymi
*
* @author  rdiak@sote.pl
* @version $Id: upload.html.php,v 1.1 2005/12/22 11:40:59 scalak Exp $
* @package    offline
* @subpackage main
*/
?>

<form action=index.php method=post enctype="multipart/form-data">

<?php $theme->html_file("offline_upload_info.html.php");?>

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
