<br>
<center>
<table width="70%">
<tr>
  <td width="50%"  valign="top">
    <?php print $lang->bzwbk24_info;?><br><br>
</tr>
<tr>
  <td>
    <table class="block_1" width="100%">
       <tr>
       <td>
       <?php 
       print $lang->bzwbk24_transfer_name.":";
       ?>
       </td>
       <td>
       <?php 
       print $lang->mikran_sc;
       ?>
       </td>
       </tr>
       <tr>
       <td>
       <?php 
       print $lang->bzwbk24_account_no.":";
       ?>
       </td>
       <td>
       <?php 
       print $lang->mikran_account_number;
       ?>
       </td>
       </tr>
       <tr>
       <td>
       <?php 
       print $lang->bzwbk24_amount.":";
       ?>
       </td>
       <td>
       <?php
         global $bzwbkAmount;
         print "<span style=font-size:larger>";
         print$bzwbkAmount;
       ?>
       </td>
       </tr>
       <tr>
       <td>
       <?php 
       print $lang->bzwbk24_due.":";
       ?>
       </td>
       <td>
       <?php
         print $lang->bzwbk24_due_title.": ";
         print $order_id;
       ?>
       </td>
       </tr>
     </table>
  </td>
</tr>
</table>
</center>
