<?php
/**
* Edycja opcji zaawansowanych. Wywo³anie ramek.
*
* @author  m@sote.pl
* @version $Id: edit_xml_options_frame.html.php,v 2.4 2004/12/20 17:58:00 maroslaw Exp $
*
* \@verified 2004-03-15 m@sote.pl
* @package    edit
*/

global $sess;
global $lang;
global $buttons;
?>

<html>
<head>
<title><?php print $lang->edit_edit['options_adv_edit'];?></title>
<link rel="stylesheet" href="/themes/base/base_theme/_style/style.css">
</head>

<body>

<?php $buttons->button($lang->back,"/go/_edit/index.php?id=$id");?>

<table border="1" width=100%>
<tr>
  <td>
    <iframe src="edit_xml_options.php?id=<?php print $id."&".$sess->param."=".$sess->id;?>" name=edit width="100%" height="520" scrolling=yes frameborder="1">
<?php print $lang->edit_noframes;?>
    </iframe>
  </td>
  <td>
    <iframe src="edit_xml_options_preview.php?id=<?php print $id."&".$sess->param."=".$sess->id;?>" name=preview width="100%" height="520" scrolling=yes frameborder="1">
<?php print $lang->edit_noframes;?>
    </iframe>
  </td>
</tr>
</table>

</body>
</html>
