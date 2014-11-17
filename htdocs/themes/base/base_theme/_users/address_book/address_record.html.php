<?php
/**
* @version    $Id: address_record.html.php,v 1.11 2005/01/18 13:48:11 lechu Exp $
* @package    users
*/
?>
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td align="center" bgcolor="#f6f6f6">
      <?php print "&nbsp;-<b>".$this->record['no']."</b>-&nbsp;";?>
    </td>
  </tr>
  <tr> 
    <td> 
      <table border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td align="right" valign="top">&nbsp;</td>
          <td>&nbsp;</td>
          <td align="left" valign="top" width="200">
            <?php if(!empty($this->record['firm'])) print $this->record['firm']."<br />";?><b><?php print $this->record['name'];?>&nbsp;<?php print $this->record['surname'];?></b><br />
            <?php print $this->record['street'];?>&nbsp;<?php print $this->record['street_n1'];?><?php if(!empty($this->record['street_n2'])) print "/".$this->record['street_n2'];?><br />
            <?php print $this->record['postcode'];?>&nbsp;<?php print $this->record['city'];?><br />
            <?php if(!empty($this->record['country'])) print $this->record['country']."<br />";?>            
            <?php if(!empty($this->record['phone'])) print $this->record['phone']."<br />";?>
            <?php if(!empty($this->record['email'])) print $this->record['email']."<br />";?>
            <?php print @$this->record['separator'];?>
          </td>
          <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td align="left" valign="top"><a href="address_book6.php?id=<?php print $this->record['id'];?>">&laquo;&nbsp;<?php echo $lang->users_paste; ?></a>&nbsp;&nbsp;<br>
            <a href="address_book3.php?id=<?php print $this->record['id'];?>">&laquo;&nbsp;<?php echo $lang->users_edit; ?></a>&nbsp;&nbsp;<br>
            <br>
            <a href="address_book.php?del=<?php print $this->record['id'];?>" class="red">&laquo;&nbsp;<?php echo $lang->users_delete; ?></a>&nbsp;&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td bgcolor="#f6f6f6">&nbsp;</td>
  </tr>
  <tr> 
    <td bgcolor="#dddddd"><img src="<?php $this->img("_img/_mask.gif");?>" width="1" height="1"></td>
  </tr>
</table>
