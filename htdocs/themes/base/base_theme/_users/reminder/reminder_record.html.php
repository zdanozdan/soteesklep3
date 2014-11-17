<?php
/**
* @version    $Id: reminder_record.html.php,v 1.3 2004/12/20 18:02:34 maroslaw Exp $
* @package    users
*/
?>
<tr>
    <td align="right" class="<?php print $this->reminder_row;?>"><?php print $this->record['remind_day'];?>&nbsp;</td>
    <td align="left" class="<?php print $this->reminder_row;?>"><?php print $this->record['remind_month']?></td>
    <td align="left" class="<?php print $this->reminder_row;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="left" class="<?php print $this->reminder_row;?>"><?php print $this->record['remind_occasion']?>&nbsp;</td>
    <td align="left" class="<?php print $this->reminder_row;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="left" class="<?php print $this->reminder_row;?>"><?php print $this->record['remind_event']?>&nbsp;</td>
    <td align="left" class="<?php print $this->reminder_row;?>">&nbsp;&nbsp;&nbsp;</td>
    <td align="left" class="<?php print $this->reminder_row;?>"><a href="/go/_users/reminder3.php?id=<?php print $this->record['id']?>">&laquo;&nbsp;Edytuj</a>&nbsp;</td>
    <td align="left" class="<?php print $this->reminder_row;?>"><a href="/go/_users/reminder.php?del=<?php print $this->record['id']?>" class="red">&laquo;&nbsp;Usuñ</a>&nbsp;</td>
  </tr>
