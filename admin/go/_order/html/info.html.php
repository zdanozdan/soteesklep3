<?php
/**
* Strona HTML z informacjami dodatkowymi o transakcji.
*
* @author  m@sote.pl
* @version $Id: info.html.php,v 2.3 2004/12/20 17:58:53 maroslaw Exp $
* @package    order
*/
?>
<?php print $lang->order_names['remote_ip'];?>: <?php print $rec->data['remote_ip'];?><br>

<?php 
if (! empty($rec->data['admin_user'])) {
    print $lang->order_last_modified_by;?>: <?php print $rec->data['admin_user']."<br>";
}
?>

<?php print $lang->order_last_modified_time;?>: <?php print $rec->data['date_update'];?><br>
<br>
