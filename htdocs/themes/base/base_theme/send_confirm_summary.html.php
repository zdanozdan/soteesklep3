<?php
/**
* @version    $Id: send_confirm_summary.html.php,v 1.3 2007/12/01 11:03:15 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

//Post TESTING
// foreach ( $_POST as $key=>$val ) {
//     print "klucz:$key, value:$_POST[$key]\n    ";
//     $v = $_POST[$key];
//     foreach ( $v as $key1=>$va1l ) {
//        print "klucz:$key1, value:$v[$key1]\n    ";
//     }   
// }
?>

<?php if($_SESSION['global_country_delivery'] != 'PL'): ?>
    <div class="alert alert-warning">
	<?php print $lang->delivery_eksport ?>
    </div>
<?php else: ?>

<br>
<center>
<table width="70%">
<tr>
  <td width="50%"  valign="top" style="font-size:12px;text-align:left">
    <?php 
   if (isset($_POST['group_1']))
   {
       $payment = $_POST['group_1'];
   }
   else
   {
      if (isset($_SESSION['payment'])) 
         $payment = $_SESSION['payment'];
      else
         print $lang->cash_post_payment_info;
   }
   if ($payment == "submit_cash")
      print $lang->cash_payment_info;
   if ($payment == "submit_post")
      print $lang->post_payment_info;
   if ($payment == "submit_transfer")
      print $lang->cash_post_payment_info;
   ?>
<br><br>
</td></tr>
<tr>
  <td>
    <table class="block_1" width="100%">
       <tr>
       <td>
       <?php 
       if ($payment == "submit_transfer") { 
          print $lang->payment_transfer_name.":";
       }
       ?>
       </td>
       <td>
       <?php 
          if ($payment == "submit_transfer") { 
             print $lang->mikran_sc;
          }
       ?>
       </td>
       </tr>
       <tr>
       <td>
       <?php 
       if ($payment == "submit_transfer") { 
          print $lang->payment_transfer_account_no.":";
       }
       ?>
       </td>
       <td>
       <?php 
       if ($payment == "submit_transfer") { 
          print $lang->mikran_account_number;
       }
       ?>
       </td>
       </tr>
 

       <tr>
       <td>
       <?php 
       print $lang->payment_transfer_amount.":";
       ?>
       </td>
       <td>
       <?php
          global $totalAmount;
          print "<span style=font-size:larger>";
          printf($totalAmount);
        ?>
       </td>
       </tr>
       <tr>
       <td>
       <?php 
       print $lang->payment_transfer_due.":";
       ?>
       </td>
       <td>
       <?php
          global $order_id;
          print $lang->payment_transfer_due_title.": ";
          print $order_id;
       ?>
       </td>
       </tr>
     </table>
  </td>
</tr>
</table>
</center> 
<?php endif; ?>
<?php print $lang->register_send_confirm_ok; ?>
</center>


