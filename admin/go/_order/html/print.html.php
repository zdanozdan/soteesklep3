<?php
/**
* Prezentacja transakcji do druku
*
* @author  m@sote.pl lech@sote.pl
* @version $Id: print.html.php,v 2.1 2005/08/11 10:53:35 lechu Exp $
* @package    order
*/

/**
* Dodaj klasê obs³ugi formularzy z PEAR.
*/
require_once ("HTML/Form.php");

if ($rec->data['confirm']==1) {
    $confirm_yes="selected";
    $confirm=$lang->bool["1"];
    $confirm_no="";
} else {
    $confirm="<font color=red>".$lang->bool["0"].":( </font>";
    $confirm_no="selected";
    $confirm_yes="";
}

if ($rec->data['confirm_user']==1) {
    $confirm_user_yes="selected";
    $confirm_user=$lang->bool["1"];
    $confirm_user_no="";
} else {
    $confirm_user="<font color=red>".$lang->bool["0"].":( </font>";
    $confirm_user_no="selected";
    $confirm_user_yes="";
}

if ($rec->data['send_confirm']==1) {
    $send_confirm_yes="selected";
    $send_confirm=$lang->bool["1"];
    $send_confirm_no="";
} else {
    $send_confirm="<font color=red>".$lang->bool["0"].":( </font>";
    $send_confirm_no="selected";
    $send_confirm_yes="";
}

// start potwierdzenie transakcji do rozliczenia:
$checked_pay_status_000='';
$checked_pay_status_001='';
$checked_pay_status_002='';
$checked_pay_status_010='';
$checked_pay_status_052='';
if (! empty($rec->data['pay_status'])) {
    switch ($rec->data['pay_status']) {
        case "000": $checked_pay_status_000="checked";
        break;
        case "001": $checked_pay_status_001="checked";
        break;
        case "002": $checked_pay_status_002="checked";
        break;
        case "010": $checked_pay_status_010="checked";
        break;
        case "052": $checked_pay_status_052="checked";
        break;
    }
} else $checked_pay_status_000="checked";
// end potwierdzenie transakcji do rozliczenia:
?>

<!-- start zamowienie:-->
<?php
print "<br>";
$theme->frame_open($lang->order_title . ": " . $rec->data['order_id'],"100%");

/**
* Tabela/formularz zamówionych produktów
*/
include_once ("./include/order_products.inc.php");
include_once ("./html/order_products.html.php");

// main_keys sprzedaz produktow on-line
if ((in_array("main_keys",$config->plugins)) && ($rec->data['main_keys_status']!=0)) {
    $theme->frame_open($lang->order_main_keys_title,"50%");
    require_once ("include/main_keys.inc.php");
    $main_keys = new MainKeys;
    $main_keys->show($rec->data['order_id']);
    $main_keys->show_errors($rec->data['main_keys_status']);
    $theme->frame_close();
}
// end

$theme->frame_close();
?>
<!-- end zamowienie: -->


<!------------------------------------------------------------------>
<table border=0 width=100%>
<tr>

<!-- start dane klienta: -->
<td valign=top width=50%>
  <?php  
  $theme->frame_open($lang->order_billing);
  reset($rec->data['users']);
  print "<table border=0 cellspacing=\"2\" cellpadding=\"2\">\n";
  foreach ($rec->data['users'] as $key=>$val) {
      print "<tr><td align=\"right\">".$lang->order_form_name[$key].":</td><td>$val</td></tr>\n";
      if ($key=="email") {
          print "<input type=hidden name=order[email] value=\"$val\">\n";   
      }
  }
  print "</table>\n";
  $theme->frame_close();
  ?>

  <?php  
  if (! empty($rec->data['users_cor'])) {
      $theme->frame_open($lang->order_cor);
      
      reset($rec->data['users_cor']);
      print "<table border=0 cellspacing=\"2\" cellpadding=\"2\">\n";
      foreach ($rec->data['users_cor'] as $key=>$val) {
          print "<tr><td align=\"right\">".$lang->order_form_name[$key]."</td><td>$val</td></tr>\n";
      }
      print "</table>\n";
      $theme->frame_close();
  }
  ?> 

  <?php  
  if (! empty($rec->data['user_description'])) {
      $theme->frame_open($lang->order_customer_note);
      echo $rec->data['user_description'];
      $theme->frame_close();
  }
  ?> 

</td>
<!-- end dane klienta: -->
<!------------------------------------------------------------------>
<td valign=top width=50%>

<!-- start dane dodatkowe: -->
<?php $theme->frame_open($lang->order_more_info);?>

<?php
// start fraud: sprawdz odtrzezenie dot. wiarygodnosci transakcji
if (! @empty($rec->data['fraud'])) {
    if ((! $config->pay_fraud[$rec->data['fraud']]) || ($config->pay_fraud[$rec->data['fraud']]<0)) {
        if ($config->pay_fraud[$rec->data['fraud']]<0) {
             #print "<img src=";$theme->img("_img/attention2.png"); print " width=15 height=14> &nbsp; \n";
        } else {
             #print "<img src=";$theme->img("_img/attention.png"); print " width=15 height=14> &nbsp; \n";
        }
        print "<font color=red>";
        #print $lang->pay_fraud[$rec->data['fraud']];
        print "</font>";
    }
}
// end fraud:
?>

<?php
// start time_alert: sprawdz ostrzezenie dot. czasu potwierdzenia transakcji
if (($rec->data['time_alert']>=0) || ($rec->data['time_alert_past'])>0) {
    print "<div align=left>";
    print $lang->order_date_confirm.": <b>".$rec->data['date_confirm']."</b> ";
    print "<img src=/themes/base/base_theme/_img/clock.png width=15 height=15> ";
    if ($rec->data['time_alert']==0) {
        // ostatni dzien do potwierdzenia rozliczenia
        print " <font color=red><b>0!</b></font>";
    } else if ($rec->data['time_alert_past']==1) {
        // czas juz minal
        print "<font color=red><b>-".$rec->data['time_alert']."!</b></font>";
    } else {
        // ilsoc dni do konca terminu
        print $rec->data['time_alert'];
    }
    print "</div>\n";
}
// end time alert:
?>


<table border=0 cellspacing=1 cellpadding=1 width=100%>
<!-- start kwota do zaplaty:-->
<tr>
  <td><?php print $lang->order_amount_all;?></td>
  <td align=left><b><u><?php print $theme->price($rec->data['total_amount'])."</u></b> ".$config->currency;?></td>
</tr>
<!-- end kwota do zaplaty: -->

<!-- start info o promocji: -->
<?php 
if ((in_array("discounts",$config->plugins)) && (! empty($rec->data['promotions_name']))) {
?>
<tr>
  <td><b><font color=green><?php print $lang->order_promotions;?></b></font></td>
  <td>
    <b><font color=green><?php print $rec->data['promotions_name'];?>
    <?php print ", ".$lang->order_discount;?>: <?php print $rec->data['promotions_discount']."%";?>
    </b></font>    
  </td>
</tr>
<?php
}
?>
<!-- end info o promocji: -->

<!-- start kwota rozliczenia :-->
<?php
// zmiana kwoty rozliczenia dla PolCardu(3)
if (($rec->data['id_pay_method']=="3") && ($rec->data['pay_status']!='050')) {
?>
<tr>
  <td><?php print $lang->order_names['amount_confirm'];?></td>
  <td align=left><input type=text name=order[amount_confirm] size=16 value='<?php print $rec->data['amount_confirm'];?>'>
   <?php 
   print $config->currency;
   print "&nbsp; <input type=submit value='".$lang->change."'>\n";
   ?>
  </td>
</tr>
<?php
} // end if ($rec->data['id_pay_method']=="3") ...

// pokaz zatwierdzanie transakcji dla PolCardu(3), Inteligo(4)
if (($rec->data['id_pay_method']=="3") || ($rec->data['id_pay_method']=="4")) {
?>

    <?php
    if (($rec->data['pay_status']=="000") || ($rec->data['pay_status']=="001") || ($rec->data['pay_status']=="010")) {
        // potwierdznie transakcji do rozliczenia
        print "<tr>\n";
        print "<td>$lang->order_set_confirm</td>";
        print "<td>";
        print "<input type=radio name=order[pay_status] value=000 $checked_pay_status_000> ".$lang->bool[0];
        print "<input type=radio name=order[pay_status] value=001 $checked_pay_status_001> ".$lang->bool[1];
        print "<input type=radio name=order[pay_status] value=010 $checked_pay_status_010> ".$lang->order_cancel;
        print "</td>\n";
        print "</tr>\n";
    } elseif ((($rec->data['pay_status']=="002") || ($rec->data['pay_status']=="052")) && ($rec->data['id_pay_method']==3)) {
        // anulowanie transakcji rozliczonej
        print "<tr>\n";
        print "<td>$lang->order_cancel_confirm</td>";
        print "<td>";
        // <input type=checkbox name=order[pay_status] value='$pay_status_value' $checked_pay_status_cancel></td>\n";
        print "<input type=radio name=order[pay_status] value=002 $checked_pay_status_002> ".$lang->bool[0];
        print "<input type=radio name=order[pay_status] value=052 $checked_pay_status_052> ".$lang->bool[1];
        print "</td>\n";
        print "</tr>\n";
    } else {
        // inny status niz w/w
        if (! empty($lang->pay_status[$rec->data['pay_status']])) {
            print "<tr>\n";
            print "<td>$lang->order_pay_status</td>\n";
            print "<td>".$lang->pay_status[$rec->data['pay_status']]."</td>\n";
            print "</tr>\n";
        }
        print "<input type=hidden name=order[pay_status] value='".$rec->data['pay_status']."'>\n";
    }
     ?>
<?php
} // end if ($rec->data['id_pay_method']=="3")
?>
<!-- end kwota rozliczenia: -->


<!-- metoda platnosci dodatkowy status -->
  <tr>
    <td><?php print $lang->order_names['id_pay_method'];?></td>
    <td> 
      <?php 
      #$theme->pay_status($rec->data['pay_status']);
      ?>
      <b><?php print $config->pay_method[$rec->data['id_pay_method']];?></b>
    </td>
 </tr>
<!-- end metoda platnosci -->

  <tr><td><?php print $lang->order_names['date_add']." ".$lang->order_names['time_add'];?></td><td><?php print $rec->data['date_add']." ".$rec->data['time_add'];?></td></tr>
  <tr><td><?php print $lang->order_names['delivery_cost'];?></td><td><b><?php print $rec->data['delivery_cost']." ".$config->currency;?></b></td></tr>
  <tr><td><?php print $lang->order_names['id_delivery'];?></td><td><?php print $rec->data['delivery_name'];?></td></tr>


<!-- start partner -->
  <?php
  /*
  if(! empty($rec->data['partner_name'])) {
  	?>
  <tr>
    <td><?php print $lang->order_names['partner_name'];?></td>
    <td><?php print "<b>".$rec->data['partner_name']."</b>";?></td>
  </tr>
  <tr>
    <td><?php print $lang->order_names['rake_off_amount'];?></td>
    <td><?php print "<b>".$rec->data['rake_off_amount']."</b>";?></td>
  </tr>  
<?php
if($rec->data['confirm_partner'] != -1 AND $rec->data['confirm_partner'] !=3) {
?>  
	<tr>
  	<td><?php print $lang->order_names['confirm_partner'];?></td>
    <td>
       <?php       
       $c0=false;$c1=false;$c2=false;
       switch (@$rec->data['confirm_partner']) {

            case  0: $c0=true; break;
            case  1: $c1=true; break;
            case  2: $c2=true; break;            
            default: $c0=true; break;
       	}       
       	print $lang->order_partner_confirm[0]." ".HTML_Form::displayRadio("order[confirm_partner]",0,$c0);
       	print $lang->order_partner_confirm[1]." ".HTML_Form::displayRadio("order[confirm_partner]",1,$c1);
       	print $lang->order_partner_confirm[2]." ".HTML_Form::displayRadio("order[confirm_partner]",2,$c2);
       }
       ?>
    </td>
  </tr>
  <?php
  }
  */
  ?>
<!-- end partner -->

</tr>
</table>
<?php $theme->frame_close();?>
<!-- end dane dodatkowe:-->

<!-- start status: -->
  <?php $theme->frame_open($lang->order_status);?>
  <table border=0 cellspacing=1 cellpadding=1 width=100%>

  
  <!-- start: status platnosci -->
  <?php 
  global $config;
  ?>
  <!-- end status platnosci: --> 
  
  <tr>
    <td><?php print $lang->order_names['send_confirm'];?></td>
    <td>
       <?php
       if(!empty($rec->data['send_confirm']))
       		echo $lang->yes;
       else
       		echo $lang->no;
       ?>
    </td>
  </tr>
  
  <!-- jezeli paczka zostala wyslana to wyswietl date nadania i numer paczki -->
  <?php if($rec->data['send_confirm']==1){ ?>
  <tr><td><?php print $lang->order_names['send_date']; ?></td>
      <td>
      <?php print @$rec->data['send_date'];?>
      </td>
  </tr>
  <tr><td><?php print $lang->order_names['send_number']; ?></td>
      <td>
      <?php print @$rec->data['send_number'];?>
      </td>
  </tr>
  <?php }?>
  <!-- koniec paczki -->

  <tr><td><?php print $lang->order_names['confirm'];?></td>
  <td>
       <?php
       if(!empty($rec->data['confirm']))
       		echo $lang->yes;
       else
       		echo $lang->no;
       ?>
    </td>
  </tr>

<?php
if ((in_array("confirm_online",$config->plugins)) && ($rec->data['confirm_online']==1)) {
    print "<tr>\n";
    print "    <td>".$lang->order_names['confirm_online']."</td>\n";
    print "    <td>".$lang->bool["1"]."</td>\n";
    print "</tr>\n";
    
}
?>
  <tr>
    <td><?php print $lang->order_names['confirm_user'];?></td>
    <td>
       <?php
       if(!empty($rec->data['confirm_user']))
       		echo $lang->yes;
       else
       		echo $lang->no;
       ?>
    </td>
  </tr>
</table>
<?php $theme->frame_close();?>
<!-- end status: -->

<!-- start opis: -->
<?php $theme->frame_open($lang->order_names['description']);?>
<!-- podglad opisu -->
<table><tr><td><?php print @$rec->data['description'];?></td></tr></table>
<!-- edycja opisu -->
<?php $theme->frame_close();?>
<!-- end opis: -->

<br>

</td>
</tr>
</table>

<!-- end main table -->
</td>
</tr>
</table>
<script>
print();
</script>
