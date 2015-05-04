<script>
<?php $this->theme_file("_common/javascript/style_changer.js");?>
   var selectedRadio = null;

   function onFormSubmit(f) {
      if (selectedRadio == null) {
         setStyleById("wp","font","normal 17px Tahoma");
         setStyleById("wp","color","#FF0000");
         setStyleById("wp","visibility","visible");
         setStyleById("wp1","font","normal 12px Tahoma");
         setStyleById("wp1","color","#808080");
         setStyleById("wp1","visibility","visible");
         return false;
      }
      return true;
   }

   function clearSelections() {
      for(var x = 1; x < 7; x++) {
         var s = "sel_" + x;
         setStyleById(s,"color","#004080");
         setStyleById(s,"font","normal 11px Tahoma");
         s=s+"1";
         setStyleById(s,"color","#004080");
         setStyleById(s,"font","normal 11px Tahoma");
      }
   }

   function changeSelection(row) {
      clearSelections();
      selectedRadio = row;
      setStyleById(row,"font","normal 13px Tahoma");
      setStyleById(row+"1","font","normal 13px Tahoma");
      setStyleById(row,"color","#BB0000");
      setStyleById(row+"1","color","#BB0000");
   }
</script>

<?php
/**
* Wybór rodzaju p³atno¶ci, prezentacja linków do systemów p³atno¶ci + opis.
*
* @author  m@sote.pl
* @version $Id: register_pay_method.html.php,v 1.3 2006/11/23 17:57:58 tomasz Exp $
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
?> 

<p>
<div>
<table width="100%" style="text-align:left;">
<tr><td id="bold">
<?php print $lang->choose_payment_method; ?>:
</td></tr>
<td id="wp" style="font-size:0px; visibility:hidden;">
<?php print $lang->wrong_payment_method; ?>!
</td></tr>
<td id="wp1" style="font-size:0px; visibility:hidden;">
<?php print $lang->wrong_payment_method_help; ?>
</td></tr>
</table>
<center>
 <form action="register3.php" method="post" onSubmit='return onFormSubmit(this)'>
   <input type="hidden" name=current_step value=3>
  <table class="payment" align="center" width="100%">    
    <tr>
      <td class="payment_head" align="center" colspan="3"><b><?php print $lang->payment_method_table_title; ?></b></td>
      <td class="payment_head" align="center">    
        <b><?php print $lang->payment_extra_points; ?>&nbsp<sup>1</sup></b>
      </td>
    </tr>
    <?php
    // czy aktywna p³atno¶æ przelewem z BZWBK24 ? (nie on-line, zwyk³y przelew)
    if($config->pay_method_active['8'] == 1 && array_key_exists("8",@$pay_method)){
    ?> 
    <tr>
      <td class="payment_itext" style="text-align:center;">    
        <input id="payment" onClick='changeSelection("sel_1")' type=radio name=group_1 value=submit_bzwbk24>
      </td>
     <td class="payment_itext" align="center">
         <?php 
           print"<img src=\"";
           $this->img("bzwbk24.gif");
           print "\">";
         ?>
     </td>
     <td id="sel_1" class="payment_itext" align="center">
        <?php 
           print "<p id=\"bold\">".$lang->payment_names['bzwbk24']."</p>";
           print $lang->payment_description['bzwbk24'];
        ?><br>
      </td>
      <td class="payment_points">
       <table border="0">                                                        
        <tr><td id="sel_11" class="payment_points">
           <?php 
              print $lang->payment_points['bzwbk24'];
              print "<span id=\"bold\">" . $lang->payment_20percent . "</span>";
            ?></td></tr>
        <tr><td class="payment_points_value" nowrap>
           <?php
              global $shop, $global_basket_amount;
              print ($shop->currency->price($global_basket_amount));
              print " ".$shop->currency->currency." = ";
              printf ("%d",$shop->currency->price(round($global_basket_amount*0.2)));
           ?>
         pkt.
         </td></tr>
       </table>                                                        
      </td>
    </tr>
    </p>
    <?php
    };
    ?> 
    <?php
    // czy aktywna p³atno¶æ przelewem?
    if($config->pay_method_active['11'] == 1 && array_key_exists("11",@$pay_method)){
    ?> 
    <tr>
      <td class="payment_itext" style="text-align:center;">    
          <input id="payment" onClick='changeSelection("sel_2")' type=radio name=group_1 value=submit_transfer>
      </td>
     <td class="payment_itext" align="center">
         <?php 
           print"<img src=\"";
           $this->img("przelew.gif");
           print "\">";
         ?>
     </td>
     <td id="sel_2" class="payment_itext" align="center">
        <?php 
             print "<p id=\"bold\">".$lang->payment_names['przelew']."</p>";
             print $lang->payment_description['przelew'];
        ?>
       <br>
      </td>
      <td class="payment_points" align="center">    
       <table>                                                        
        <tr><td id="sel_21" class="payment_points">
        <?php 
           print $lang->payment_points['przelew']; 
           print "<span id=\"bold\">" . $lang->payment_10percent . "</span>";
         ?>
       </td></tr>
        <tr><td class="payment_points_value">
           <?php
              global $shop, $global_basket_amount;
              print ($shop->currency->price($global_basket_amount));
              print " ".$shop->currency->currency." = ";
              printf ("%d",$shop->currency->price(round($global_basket_amount*0.2)));
           ?>
         pkt.
         </td></tr>
       </table>                                                        
      </td>
    </tr>
    <?php
    };
    ?> 
    <?php
    // czy aktywna p³atno¶æ przy odbiorze ( gotówk± w siedzibie firmy )?
    if($config->pay_method_active['81'] == 1 && array_key_exists("81",@$pay_method)) {        
    ?> 
    <tr>
     <td class="payment_itext" style="text-align:center;"> 
      <input id="payment" onClick='changeSelection("sel_3")' type=radio name=group_1 value=submit_cash>
     </td>
     <td class="payment_itext" align="center">
         <?php 
           print"<img src=\"";
           $this->img("money.gif");
           print "\">";
         ?>
     </td>
      <td id="sel_3" class="payment_itext" align="center"> 
        <?php 
            print "<p id=\"bold\">".$lang->payment_names['cash']."</p>";
            print $lang->payment_description['cash'];
        ?>
       </td>
      <td id="sel_31" class="payment_itext" style="text-align:center;">  
           <?php print $lang->payment_points['cash']; ?>
      </td>
    </tr>     
    <?php
    };
    ?> 
    <?php
    // czy aktywna p³atno¶æ przy odbiorze (za zaliczaniem) ?
       if($config->pay_method_active['1'] == 1 && array_key_exists("1",@$pay_method)) {        
    ?> 
    <tr>
     <td class="payment_itext" style="text-align:center;"> 
       <input id="payment" onClick='changeSelection("sel_4")' type=radio name=group_1 value=submit_post>
     </td>
     <td class="payment_itext" align="center">
         <?php 
           print"<img src=\"";
           $this->img("priorytet.gif");
           print "\">";
         ?>
     </td>
      <td id="sel_4" class="payment_itext" align="center"> 
        <?php 
          print "<p id=\"bold\">" . $lang->payment_names['pobranie'] . "</p>";
          print $lang->payment_description['pobranie'];
         ?>
       </td>

      <td class="payment_points" align="center">    
       <table>                                                        
        <tr><td id="sel_41" class="payment_points">
         <?php 
             print $lang->payment_points['pobranie']; 
             print "<span id=\"bold\">" . $lang->payment_10percent . "</span>";
         ?>
        </td></tr>
        <tr><td class="payment_points_value">
           <?php
              global $shop, $global_basket_amount;
              print ($shop->currency->price($global_basket_amount));
              print " ".$shop->currency->currency." = ";
              printf ("%d",$shop->currency->price(round($global_basket_amount*0.1)));
           ?>
         pkt.
         </td></tr>
       </table>                                                        
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
          print "<input type=radio name=submit_polcard value='$lang->register_polcard_order'>\n";
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
          print "<input type=\"radio\" name=\"submit_ecard\" value=\"$lang->register_ecard_order\">";
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
         print "<tr>\n";
         print "<td class=\"payment_itext\" style=\"text-align:center;\">";
         print "<input id=\"payment\" onClick='changeSelection(\"sel_5\")' type=radio name=group_1 value=submit_przelewy24>";
         print "</td>";
         print "<td class=\"payment_itext\" align=\"center\">";
         print"<img src=\"";
         $this->img("przelewy24_logo.gif");
         print "\"></td>";

         print "<td id=\"sel_5\" class=\"payment_itext\" align=\"center\">";
         print "<p id=\"bold\">" . $lang->payment_names['przelewy24'] . "</p>";
         print $lang->payment_description['przelewy24'];
         if ($przelewy24_config->status!=1) 
         {
            print "<br />".$lang->pay_method_status_off;
         }
      ?>

        </td/>
        <td id="sel_51" class="payment_itext" style="text-align:center;"><?php print $lang->payment_points['przelewy24'];?></td>
        </tr>
      <?php } ?>

      <?php
      // aktywacja platnosci - system PayPal
      if (@$paypal_config->payPalActive=="1" && array_key_exists("101",@$pay_method)) {
          print "<tr>\n";
          print "<td>\n";
          print "<input type=\"radio\" name=\"submit_paypal\" value=\"$lang->register_paypal_order\">";
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
      if (@$platnoscipl_config->active=="1" && array_key_exists("20",@$pay_method)) {
          print "<tr>\n";
          print "<td class=\"payment_itext\" style=\"text-align:center;\">";
          print "<input id=\"payment\" onClick='changeSelection(\"sel_6\")' type=radio name=group_1 value=submit_platnoscipl>";
          print "</td>";
          print "<td class=\"payment_itext\" align=\"center\">";
          print"<img src=\"";
          $this->img("visa_master.gif");
          print "\"><br>";
          print"<img src=\"";
          $this->img("platnoscipl_logo.gif");
          print "\"></td>";

          print "<td id=\"sel_6\" class=\"payment_itext\" align=\"center\">";
          print "<p id=\"bold\">" . $lang->payment_names['platnoscipl'] . "</p>";
          print $lang->payment_description['platnoscipl'];
          if ($platnoscipl_config->status!=1) {
              print "<br />".$lang->pay_method_status_off;
          }
          ?>
          </td/>
          <td id="sel_61" class="payment_itext" style="text-align:center;"><?php print $lang->payment_points['platnoscipl']; ?></td>
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
<table class="payment">
<tr><td class="payment_head" align="center"><?php print $lang->order_now; ?></td></tr>
<tr><td class="payment_itext">
<span style="font-size:12px">
<?php print $lang->order_disclaimer['0']; ?>
<span id="bold">
<?php print $lang->order_disclaimer['1']; ?>
</span>
<?php print $lang->order_disclaimer['2']; ?>
</span>
</td></tr>
<td class="payment_itext" style="text-align:center"> 
<?php print "<input id=\"payment\" type=submit value=\"$lang->order_now\";>"; ?>
</td></tr></table>

</form>
</center>
</div>
<br><br>
<table style="text-align:justify">
<tr><td>
<ol>
</li>
<li>
   <?php print $lang->payment_extra_points_info; ?><a href="/go/_files/?file=discount.html">... Zbieraj punkty w mikran.pl !</a>
</li>
</ol>
</li>
</td></tr>
</table>
</p>
