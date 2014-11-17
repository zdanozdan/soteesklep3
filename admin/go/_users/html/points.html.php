<?php
/**
* Edycja punktow klienta - formularz
*
* @author  krzys@sote.pl
* @version    $Id: points.html.php,v 1.2 2005/11/30 08:55:06 lukasz Exp $
* @package    users
*/
?>

<BR>
<?php $theme->desktop_open();?>
 <table border=0 align=center cellpadding="0" cellpadding="0" width="100%">
 <tr>
	  <td align="center">
	  <?php print $lang->user_points['sentence_amount_1']."&nbsp;&nbsp;<B>".$rec->data['login']."</B> ".$lang->user_points['sentence_amount_2'].
	  "<font color=\"blue\"><B> ".$global_points."</font></B> ".$lang->user_points['sentence_amount_3'].$lang->user_points['sentence_amount_4']."<font color=\"red\"><b>".$global_points_reserved."</b></font> ".$lang->user_points['sentence_amount_5'];?>
	 </td>
 </tr>
 <tr>
	 <td align="left">
	 <BR>
	 <?php print $lang->user_points['modified_points'].":"; ?>
	 </td>
 </tr>
 <tr>
	 <td align="center">
	 <form action=points.php method=post name=pointsForm>
		 <table border="0" cellpadding="0" cellspacing="3">
		 <tr>
			 <td align="center" bgcolor="#ffee5f">
			 	<b><?php print $lang->user_points['action'];?></b>
			 </td>
			 <td align="center" bgcolor="#ffee5f">
			 	<b><?php print $lang->user_points['points'];?></b>
			 </td>
			 <td align="center" bgcolor="#ffee5f">
			 	<b><?php print $lang->user_points['description'];?></b>
			 </td>
		 </tr>
		 <tr>
			 <td>
				 <select name="form[action]">
				 <option value="add"><?php print $lang->user_points['add_admin'];?></option>
				 <option value="decrease"><?php print $lang->user_points['decrease_admin'];?></option>
				 </select>
			 </td>
			 <td><input type="text" name="form[points]"size="4"></td>
			 <td><input type="text" size="30" name="form[description]"></td>
			 <input type="hidden" name="id" value="<?php print $id; ?>">
			 <td><?php  $buttons->button($lang->user_points['do_it'],"javascript:document.pointsForm.submit();");?></td>
		 </tr>
		 </table>
		 </form>
	 </td>
 </tr>
 </table>
<?php 
$theme->desktop_close();
// historia punktow
print "<br>";
$theme->desktop_open();
print $lang->user_points['history'];
 /**
* Funkcja prezentujaca wynik zapytania w g³ownym oknie strony.
*/
include_once ("include/dbedit_list.inc");
// prezentacja historii punktow
$sql="SELECT * FROM users_points_history WHERE id_user_points=$id ORDER BY id DESC";
$dbedit =& new DBEditList;
$dbedit->page_records=20;
$dbedit->page_links=20;
// ustal klase i funkcje generujaca wiersz rekordu
require_once("./include/users_points_record.inc.php");
require_once ("./include/list_points_th.inc.php");
$dbedit->start_list_element=users_points_list_th();
$dbedit->record_class="UsersPointsRecordRow";
$dbedit->record_fun="record";
$dbedit->show();
$theme->desktop_close();
?>