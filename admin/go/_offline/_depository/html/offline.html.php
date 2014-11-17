<?php
/**
* Strona z do rozpocz±cie aktualizacji
*
* @author  rdiak@sote.pl
* @version $Id: offline.html.php,v 1.1 2005/12/22 11:40:59 scalak Exp $
* @package    offline
* @subpackage main
*/
?>


<?php
$onclick="onclick=\"window.open('','window','width=525,height=380,scrollbars=1,menubar=0,status=0,location=0,directories=0,toolbar=0,resizable=0');\"";
?>


<?php $theme->html_file("offline_data2sql_info.html.php");?>

<center>
<form action=offline.php method=post target=window>
<input type=radio name=update_mode value='new'><?php print $lang->offline_load_all; ?>

<?php
$file_lock="$DOCUMENT_ROOT/tmp/offline_lock.php";
if (file_exists($file_lock)) {
    print "<input type=radio name=update_mode value='update'>".$lang->offline_update_action."\n";
    print "<input type=radio name=update_mode value='continue' checked><font color=red><b>".$lang->offline_continue."</b></font>\n";
} else {
    print "<input type=radio name=update_mode value='update' checked>".$lang->offline_update_action."\n";
}
?>

<br><br>

<input type=submit name=submit_offline value="<?php print $lang->offline_submit_data; ?>" <?php print $onclick; ?>>
</form>
</center>
