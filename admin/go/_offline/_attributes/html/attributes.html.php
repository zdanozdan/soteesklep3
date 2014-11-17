<?php
/**
* @version    $Id: attributes.html.php,v 1.2 2004/12/20 17:58:21 maroslaw Exp $
* @package    offline
* @subpackage attributes
*/
?>
<form action=index.php method=post enctype="multipart/form-data">

<?php $theme->html_file("attrib_upload_info.html.php");?>

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
