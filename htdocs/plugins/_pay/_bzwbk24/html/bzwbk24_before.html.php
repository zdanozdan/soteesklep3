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
         global $shop;
         $shop->currency(); 
         print "<span style=font-size:larger>";
         printf("%.2f",$shop->basket->totalAmount());
         print " ".$shop->currency->currency; 
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

<?php 
//drukowanie polecenia przelewu TBD
       //$theme->print_page("/plugins/_pay/_bzwbk24/html/bzwbk24_before.html.php"); 
?> 

<!-- strona index.php przechwyci tego posta wysle maile i podziekuje za zakupy, jednoczesnie otworzy sie strona bzwbk24 -->
<form action="/plugins/_pay/_bzwbk24/index.php" method="post">
<button class="payment" name=submit_transfer_bzwbk24 type=submit value='WBK' title="http://www.centrum24.pl/bzwbk24_pl.html" onClick="window.open('http://www.centrum24.pl/bzwbk24_pl.html');">
<?php print ($lang->payment_buttons['bzwbk24']); ?>
</button>
</form>
