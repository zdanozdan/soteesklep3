<?php
/**
* Wybór rodzaju p³atno¶ci, prezentacja linków do systemów p³atno¶ci + opis.
*
* @author  m@sote.pl
* @version $Id: order_step_one.html.php,v 1.1 2007/12/01 10:58:25 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

global $polcard_config, $config;
@include_once ("config/auto_config/polcard_config.inc.php");
global $przelewy24_config;
@include_once ("config/auto_config/przelewy24_config.inc.php");
global $ecard_config;
@include_once ("config/auto_config/ecard_config.inc.php");
global $paypal_config;
@include_once ("config/auto_config/paypal_config.inc.php");
global $platnosciPL_config;
@include_once ("config/auto_config/platnoscipl_config.inc.php");
global $cardpay_config;
@include_once ("config/auto_config/cardpay_config.inc.php");
global $allpay_config;
@include_once ("config/auto_config/allpay_config.inc.php");

$pay_method=@unserialize($_SESSION['global_delivery']['pay']);
//print_r($pay_method);

if(empty($pay_method)) {
	$pay_method=$config->pay_method_active;
}
// jezeli koszta dostawy sa rowne zero i koszyk jest w trybie punktowym to jedyna dostepna metoda p³atno¶ci jest zaliczenie pocztowe
global $global_delivery;
if ($global_delivery['cost']=="0.00" && @$_SESSION['global_basket_data']['mode']=="points") {
	$config->pay_method_active['1']="1";
	$pay_method=array("1"=>"");
}

// Post TESTING
// foreach ( $_POST as $key=>$val ) {
//     print "klucz:$key, value:$_POST[$key]\n    ";
//     $v = $_POST[$key];
//     foreach ( $v as $key1=>$va1l ) {
//        print "klucz:$key1, value:$v[$key1]\n    ";
//     }   
// }

$ck = "checked=true";
$style = "style=\"font:normal 13px Tahoma;color:#BB0000\"";
$ajax_pay_number = "";
print "<script>clearSelections();</script>";
if (!empty($_SESSION['ajax_pay_number']))
{
   $ajax_pay_number = $_SESSION['ajax_pay_number'];
}

?> 

<div>
<div class="alert alert-info text-left"><?php print $lang->choose_payment_method; ?>!:</div>
<div id="wp" class="alert alert-error" style="font-size:0px; display:none;">
  <?php print $lang->wrong_payment_method; ?>!
</div>
<div id="wp1" style="font-size:0px; display:none;">
  <?php print $lang->wrong_payment_method_help; ?>
</div>

<center>
  <table class="table table-bordered table-hover table-payment">    
    <tr>
      <td class="payment_head_old" align="center" colspan="3"><b><?php print $lang->payment_method_table_title; ?></b></td>
    </tr>
    <?php
    // czy aktywna p³atno¶æ przelewem z BZWBK24 ? (nie on-line, zwyk³y przelew)
    if($config->pay_method_active['8'] == 1 && array_key_exists("8",@$pay_method))
    {
      if($ajax_pay_number == "8")
	print "<script>changeSelection(\"sel_1\");</script>";
    ?> 
    <tr>
      <td class="payment_itext_old">    
        <input style=\"border-width:0px\" onClick='changeSelection("sel_1");xmlhttpGet("/go/_basket/sess_register.php?req_name=ajax_pay_number&req_value=8","")' <?php if($ajax_pay_number == "8") print $ck; ?> type="radio" name="group_1 value=submit_bzwbk24">
      </td>
     <td class="payment_itext_old" align="center">
         <?php 
           print"<img src=\"";
           $this->img("bzwbk24.gif");
           print "\">";
         ?>
     </td>
     <td id="sel_1" class="payment_itext_old" align="center" <?php if($ajax_pay_number == "8") print $style ?> >
        <?php 
           print "<p id=\"bold\">".$lang->payment_names['bzwbk24']."</p>";
           print $lang->payment_description['bzwbk24'];
        ?><br>
      </td>
    </tr>
    </p>
    <?php
    };
    ?> 
    <?php
    // czy aktywna p³atno¶æ przelewem?
    if($config->pay_method_active['11'] == 1 && array_key_exists("11",@$pay_method))
    {
      if($ajax_pay_number == "11")
	print "<script>changeSelection(\"sel_2\");</script>";
    ?> 
    <tr>
      <td class="payment_itext_old" style="text-align:center;">    
          <input style="border-width:0px" onClick='changeSelection("sel_2"); xmlhttpGet("/go/_basket/sess_register.php?req_name=ajax_pay_number&req_value=11","")' <?php if($ajax_pay_number == "11") print $ck ?> type=radio name=group_1 value=submit_transfer>
      </td>
     <td class="payment_itext_old" align="center">
         <?php 
           print"<img src=\"";
           $this->img("przelew.gif");
           print "\">";
         ?>
     </td>
     <td id="sel_2" class="payment_itext_old" align="center" <?php if($ajax_pay_number == "11") print $style ?> >
        <?php 
             print "<p id=\"bold\">".$lang->payment_names['przelew']."</p>";
             print $lang->payment_description['przelew'];
        ?>
       <br>
      </td>
    </tr>
    <?php
    };
    ?> 
    <?php
    // czy aktywna p³atno¶æ przy odbiorze ( gotówk± w siedzibie firmy )?
    if($config->pay_method_active['81'] == 1 && array_key_exists("81",@$pay_method)) 
    {        
      if($ajax_pay_number == "81")
	print "<script>changeSelection(\"sel_3\");</script>";
    ?> 
    <tr>
     <td class="payment_itext_old" style="text-align:center;"> 
      <input style="border-width:0px" onClick='changeSelection("sel_3"); xmlhttpGet("/go/_basket/sess_register.php?req_name=ajax_pay_number&req_value=81","")' <?php if($ajax_pay_number == "81") print $ck?> type=radio name=group_1 value=submit_cash>
     </td>
     <td class="payment_itext_old" align="center">
         <?php 
           print"<img src=\"";
           $this->img("money.gif");
           print "\">";
         ?>
     </td>
      <td id="sel_3" class="payment_itext_old" align="center" <?php if($ajax_pay_number == "81") print $style ?> > 
        <?php 
            print "<p id=\"bold\">".$lang->payment_names['cash']."</p>";
            print $lang->payment_description['cash'];
        ?>
       </td>
    </tr>     
    <?php
    };
    ?> 
    <?php
    // czy aktywna p³atno¶æ przy odbiorze (za zaliczaniem) ?
    if($config->pay_method_active['1'] == 1 && array_key_exists("1",@$pay_method)) 
    {        
      if($ajax_pay_number == "1")
	print "<script>changeSelection(\"sel_4\");</script>";
    ?> 
    <tr>
     <td class="payment_itext_old" style="text-align:center;"> 
       <input style="border-width:0px" onClick='changeSelection("sel_4");xmlhttpGet("/go/_basket/sess_register.php?req_name=ajax_pay_number&req_value=1","")' <?php if($ajax_pay_number == "1") print $ck ?> type=radio name=group_1 value=submit_post>
     </td>
     <td class="payment_itext_old" align="center">
         <?php 
           print"<img src=\"";
           $this->img("priorytet.gif");
           print "\">";
         ?>
     </td>
      <td id="sel_4" class="payment_itext_old" align="center" <?php if($ajax_pay_number == "1") print $style ?> > 
        <?php 
          print "<p id=\"bold\">" . $lang->payment_names['pobranie'] . "</p>";
          print $lang->payment_description['pobranie'];
         ?>
       </td>
    </tr>     
    <?php
    };
    ?> 
    <?php
      // aktywacja platnosci - system PolCard
      if (@$polcard_config->active=="1" && array_key_exists("3",@$pay_method)) {
          print "<tr>\n";
          print "<td>\n";
          print "<input style=\"border-width:0px\" type=radio name=submit_polcard value='$lang->register_polcard_order'>\n";
          print "</td>\n";
          print "      <td align=\"center\">";
          print $lang->register_polcard_payment;
          if ($polcard_config->status!=1) {
              print "<br />".$lang->pay_method_status_off;
          }
          print "</td>\n";
          print "</tr>\n";
      }
     ?>
     
      <?php
      // aktywacja platnosci - system eCard
      if (@$ecard_config->ecardActive=="1" && array_key_exists("2",@$pay_method)) {
          print "<tr>\n";
          print "<td>\n";
          print "<input style=\"border-width:0px\" type=\"radio\" name=\"submit_ecard\" value=\"$lang->register_ecard_order\">";
          print "</td>\n";
          print "      <td align=\"center\">";
          print $lang->register_ecard_payment;
          if ($ecard_config->ecardStatus!=1) {
              print "<br />".$lang->pay_method_status_off;
          }
          print "</td/>\n";
          print "</tr>\n";
      }
      ?>
      
      <?php
      // aktywacja platnosci - system Przelewy24
      if (@$przelewy24_config->active=="1" && array_key_exists("12",@$pay_method)) 
      {
	if($ajax_pay_number == "12")
	  print "<script>changeSelection(\"sel_5\");</script>";

         print "<tr>\n";
         print "<td class=\"payment_itext_old\" style=\"text-align:center;\">";
         print "<input style=\"border-width:0px\" onClick='changeSelection(\"sel_5\");xmlhttpGet(\"/go/_basket/sess_register.php?req_name=ajax_pay_number&req_value=12\",\"\")'";
	   if($ajax_pay_number == "12") 
	     print $ck;
	 print "type=radio name=group_1 value=submit_przelewy24>";
         print "</td>";
         print "<td class=\"payment_itext_old\" align=\"center\">";
         print"<img src=\"";
         $this->img("przelewy24_logo.gif");
         print "\"></td>";

         print "<td id=\"sel_5\" class=\"payment_itext_old\" align=\"center\"";
	 if($ajax_pay_number == "12") 
	     print $style;
	 print ">";
         print "<p id=\"bold\">" . $lang->payment_names['przelewy24'] . "</p>";
         print $lang->payment_description['przelewy24'];
         if ($przelewy24_config->status!=1) 
         {
            print "<br />".$lang->pay_method_status_off;
         }
      ?>

        </td/>
        </tr>
      <?php } ?>

      <?php
      // aktywacja platnosci - system PayPal
      if (@$paypal_config->payPalActive=="1" && array_key_exists("101",@$pay_method)) {
          print "<tr>\n";
          print "<td>\n";
          print "<input style=\"border-width:0px\" type=\"radio\" name=\"submit_paypal\" value=\"$lang->register_paypal_order\">";
          print "</td>\n";
          print "      <td align=\"center\">";
          print $lang->register_paypal_payment;
          if ($paypal_config->payPalStatus!=1) {
              print "<br />".$lang->pay_method_status_off;
          }
          print "</td/>\n";
          print "</tr>\n";
      }
      ?>
      <?php
      // aktywacja platnosci - system PlatnosciPL
      if (@$platnoscipl_config->active=="1" && array_key_exists("20",@$pay_method)) 
      {
	if($ajax_pay_number == "20")
	  print "<script>changeSelection(\"sel_6\");</script>";

          print "<tr>\n";
          print "<td class=\"payment_itext_old\" style=\"text-align:center;\">";
          print "<input style=\"border-width:0px\" onClick='changeSelection(\"sel_6\");xmlhttpGet(\"/go/_basket/sess_register.php?req_name=ajax_pay_number&req_value=20\",\"\")'";
	  if($ajax_pay_number == "20") 
	    print $ck;
	  print "type=radio name=group_1 value=submit_platnoscipl>";
          print "</td>";
          print "<td class=\"payment_itext_old\" align=\"center\">";
          print"<img src=\"";
          $this->img("visa_master.gif");
          print "\"><br>";
          print"<img src=\"";
          $this->img("platnoscipl_logo.gif");
          print "\"></td>";

          print "<td id=\"sel_6\" class=\"payment_itext_old\" align=\"center\"";
	  if($ajax_pay_number == "20") 
	    print $style;
	  print ">";
          print "<p id=\"bold\">" . $lang->payment_names['platnoscipl'] . "</p>";
          print $lang->payment_description['platnoscipl'];
          if ($platnoscipl_config->status!=1) {
              print "<br />".$lang->pay_method_status_off;
          }
          ?>
          </td/>
          </tr>
      <?php
      }
      ?>
      <?php
      // aktywacja platnosci SMS poprzez Platnosci.PL
      if (@$platnoscipl_config->active=="1" && array_key_exists("20",@$pay_method) && @$platnoscipl_config->sms=="1") {
          print "<tr>\n";
          print "      <td align=\"center\">";
          print $lang->register_platnoscipl_payment;
          if ($platnoscipl_config->status!=1) {
              print "<br />".$lang->pay_method_status_off;
          }
          print "</td/>\n";
          print "<td>\n";
          print "<input type=\"hidden\" name=\"sms\" value=1>"; 
          print "<input type=\"radio\" name=\"submit_platnoscipl\" value=\"$lang->register_platnoscipl_sms\">";
          print "<input type=\"radio\" name=\"group_1\" value=\"submit_platnoscipl\">";
          print "</td>\n";
          print "</tr>\n";
      }
      ?>
      <?php
      // aktywacja platnosci - p³atno¶æ kart±
      if (array_key_exists("110",@$pay_method) && @$cardpay_config->active && $config->ssl) {
          print "<tr>\n";
          print "<td>\n";
          print "<input type=\"radio\" name=\"submit_cardpay\" value=\"$lang->register_cardpay_order\">";
          print "</td>\n";
          print "      <td align=\"center\">";
          print $lang->register_cardpay_payment;
          print "</td/>\n";
          print "</tr>\n";
      }
      ?>
            <?php
      // aktywacja platnosci - system Allpay
      if ((@$allpay_config->allpay_active=='1') && array_key_exists("21",@$pay_method))  {
          print "<tr>\n";
          print "<td>\n";
          print "<input type=\"radio\" name=\"submit_allpay\" value=\"$lang->register_allpay_order\">";
          print "</td>\n";
          print "      <td align=\"center\">";
          print $lang->register_allpay_payment;
          print "</td/>\n";
          print "</tr>\n";
      }
      ?>
    </tr>    
  </table>

<br>

<?php 
       //print "<input id=\"payment\" type=submit value=\"$lang->order_now\";>"; 
?>

</center>
</div>
</p>

<?php
/**
* Wy¶wietl podsumowanie zawarto¶æi koszyka + przycisk potwierdzenia zamówienia.
*
* @author  m@sote.pl
* @version $Id: order_step_one.html.php,v 1.1 2007/12/01 10:58:25 tomasz Exp $
* @package htdocs_theme
* @subpackage basket
*
* @todo zmieniæ wywo³anie basket_amount.html.php
*/
?>

<?php 
/* Wy¶wietl informacje o wearto¶ci zamówienia itp. */
//include_once("basket_amount.html.php");
?>
<p class="pull-right">
<input id="payment2" class="btn btn-warning" type="submit" name="submit_proceed" value='<?php print $lang->second_step; ?>'
<input type="hidden" name="current_step value=2">
</p>
