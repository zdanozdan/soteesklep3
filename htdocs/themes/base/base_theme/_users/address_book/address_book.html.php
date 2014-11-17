<?php
/**
* @version    $Id: address_book.html.php,v 1.2 2007/12/01 11:14:13 tomasz Exp $
* @package    users
*/
?>
<br />
<div class="block_1">
<center>
  <table border="0" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td style="text-align:center">&raquo;&nbsp;<a href=/go/_users/address_book1.php><?php print $lang->address_book_add;?>&nbsp;&laquo</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td bgcolor="#dddddd"><img src="<?php $this->img("_img/_mask.gif");?>" width="1" height="1"></td>
    </tr>
				<tr>
				  <td aligh="center">
						  <table border="0" cellspacing="0" cellpadding="0" align="center">   
          <?php $this->address_book->showAddressBook();?>
								</table>
				  </td>
    </tr>
				<tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td style="text-align:center">&raquo;&nbsp;<a href=/go/_users/address_book1.php><?php print $lang->address_book_add;?>&nbsp;&laquo</td>
    </tr>
  </table>
</center>
</div>
