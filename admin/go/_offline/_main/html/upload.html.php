<?php
/**
* £adowanie pliku z danymi offliowymi
*
* @author  rdiak@sote.pl
* @version $Id: upload.html.php,v 2.3 2004/12/20 17:58:30 maroslaw Exp $
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
