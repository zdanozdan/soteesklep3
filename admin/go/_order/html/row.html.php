<?php
/**
* Prezentacja wiersza transkacji na li¶cie transakcji.
*
* @author  m@sote.pl
* @version $Id: row.html.php,v 2.12 2005/12/14 08:13:27 lechu Exp $
* @package    order
*/

global $lang;
global $database;
global $config,$theme;

if ($rec->data['confirm']==1) {
    $confirm=$lang->bool["1"];
} else $confirm="<font color=red>".$lang->bool["0"]."</font>";

if ($rec->data['cancel'] == 1) {
    $confirm = $lang->order_names['cancel'];
}
if ($rec->data['confirm_online']==1) {
    $confirm_online=$lang->bool["1"];
} else $confirm_online="-";

$order_id=$rec->data['order_id'];

$id_status=$rec->data['id_status'];
if (! empty($config->order_status[$id_status])) {
    $status=$config->order_status[$id_status];
} else $status="---";

if (strlen($status)>16) {
    $status=substr($status,0,10)."...".substr($status,strlen($status)-5,5);
}

global $__no_head, $_print_mode;
?>

<tr>
 <td>
 <?php
 if (!$_print_mode){
 ?>
   <a href=/go/_order/edit.php?order_id=<?php print $order_id;?> onclick="open_window(760,680)" target=window><u><?php print $rec->data['order_id'];?></u></a>
 <?php
}
else {
	print $rec->data['order_id'];
}
 ?>

 </td>
 <?php
 if (!$_print_mode){
 ?>
 <td>
   <a href=/go/_order/edit.php?order_id=<?php print $order_id;?> onclick="open_window(760,680)" target=window><u>
   <?php print $lang->change_img;?></u></a>
 </td>  
 <?php
}
 ?>
 <td><?php print $rec->data['date_add'];?></td>
 <td align=right>
   <?php 
   if ($rec->data['total_amount']>0) {
       print $rec->data['total_amount'];
   } else print $rec->data['amount'];
   ?>
 </td>
 <td align=center><?php print $status;?></td>
 <td align=center><?php print $confirm;?></td>

<?php
// wstaw informacje o planosci on-line i kwocie przekazanej do centrum autoryzacyjnego
if (in_array("confirm_online",$config->plugins)) {
    print "<td align=center>\n";
    print $confirm_online;
    print "</td>\n";
} // end if
?>

  <!-- start pay_method & status -->
  <td align=left>

  <?php 
  
  #$theme->pay_status($rec->data['pay_status']);
  print "&nbsp;";
  
  $pay_method=@$config->pay_method[$rec->data['id_pay_method']];
  if (($config->lang!=$config->base_lang) && (! empty($rec->data['id_pay_method']))) {
      print LangFunctions::f_translate($pay_method);
  } else {
      print $pay_method;
  }  
  ?>

  </td>
  <!-- end pay_method & status -->
 <?php
 if (!$_print_mode){
 ?>
	  <td align=center><input type=checkbox name=del[<?php print $rec->data['id'];?>]><?php print $lang->go2trash;?></td>
	  <?php  
	  // sprawdz odtrzezenie dot. wiarygodnosci transakcji
	  if (! @empty($rec->data['fraud'])) {
	      if ((! $config->pay_fraud[$rec->data['fraud']]) || ($config->pay_fraud[$rec->data['fraud']]<0)) {
	          print "<td>";
	          if ($config->pay_fraud[$rec->data['fraud']]<0) {
	              // print "<img src=";$theme->img("_img/attention2.png"); print " width=15 height=14> &nbsp; \n";
	          } else {
	              // print "<img src=";$theme->img("_img/attention.png"); print " width=15 height=14> &nbsp; \n";
	          }
	          print "</td>\n";
	      }
	  }
 }
  
  // sprzedaz on-line sprawdzenie dodatkowego statusu
  if (in_array("main_keys",$config->plugins)) {
      // zabraklo kodow przy sprzedazy on-line
      if ($rec->data['main_keys_status']=="050") {
          print "<td><img src=";$theme->img("_img/attention.png"); print " width=15 height=14></td>\n";
      }
  }
  
  // start time_alert: sprawdz ostrzezenie dot. czasu potwierdzenia transakcji
  if ((@$rec->data['time_alert']>=0) || (@$rec->data['time_alert_past'])>0) {
      #print "<td><img src=/themes/base/base_theme/_img/clock.png width=15 height=15> ";
      if (@$rec->data['time_alert']==0) {
          // ostatni dzien do potwierdzenia rozliczenia
          #print " <font color=red><b>0!</b></font>";
      } else if (@$rec->data['time_alert_past']==1) {
          // czas juz minal
          #print "<font color=red><b>-".$rec->data['time_alert']."!</b></font>";
      } else {
          // ilsoc dni do konca terminu
          #print @$rec->data['time_alert'];
      }
      print "</td>\n";
  }
  // end time alert:
?>
<td>
<?php
	if ($rec->data['points']) {
		print "<img src=\"";
		$theme->img('_img/points.gif');
		print "\" alt=P>";
	}
?>
</td>
</tr>
<?php
$rows=7;
if (in_array("confirm_online",$config->plugins)) $rows++;

if (!$_print_mode)
	$theme->lastRow($rows, "orders_print");
?>
