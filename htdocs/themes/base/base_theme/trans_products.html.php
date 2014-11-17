<?php
/**
* Podgl±d transakcji w sklepie
*
* @$Id: trans_products.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @author m@sote.pl lech@sote.pl
* @version    $Id: trans_products.html.php,v 1.1 2006/09/27 21:53:26 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/

global $theme,$rec,$config, $shop, $_SESSION;
include_once("include/lang_functions.inc");
if (($rec->data['confirm']==1) || ($rec->data['confirm_online'])) {
    $confirm_yes="selected";
    $confirm=$lang->bool["1"];
    $confirm_no="";
} else {
    $confirm="<font color=red>".$lang->bool["0"]." </font>";
    $confirm_no="selected";
    $confirm_yes="";
}

if ($rec->data['confirm_user']==1) {
    $confirm_user_yes="selected";
    $confirm_user=$lang->bool["1"];
    $confirm_user_no="";
} else {
    $confirm_user="<font color=red>".$lang->bool["0"]." </font>";
    $confirm_user_no="selected";
    $confirm_user_yes="";
}

if ($rec->data['send_confirm']==1) {
    $send_confirm_yes="selected";
    $send_confirm=$lang->bool["1"];
    $send_confirm_no="";
} else {
    $send_confirm="<font color=red>".$lang->bool["0"]." </font>";
    $send_confirm_no="selected";
    $send_confirm_yes="";
}


// laczna suma do zaplaty
$total_amount=$rec->data['total_amount']+$rec->data['delivery_cost'];
?>

<center>
  <table align="center" border="0" cellspacing="2" cellpadding="2">
    <tr> 
      <td valign="top" colspan="2"> 
        <?php
        global $id;
        show_products($id);
        ?>
      </td>
    </tr>
    <tr> 
      <td><br />
        <table align="center" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td>
              <?php print $lang->order_names['id_delivery'];?>
            </td>
            <td><?php print langF::translate($rec->data['delivery_name']);?></td>
          </tr>
          <tr> 
            <td><?php print $lang->order_names['delivery_cost'];?></td>
            <td><?php print $shop->currency->price($rec->data['delivery_cost'])." ".$shop->currency->currency;?></td>
          </tr>
          <tr> 
            <td><b><?php print $lang->order_names['amount'];?></b></td>
            <td><b><?php print $shop->currency->price($total_amount)." ".$shop->currency->currency;?></b></td>
          </tr>
          <?php if ($rec->data['points']==1) { ?>
          <tr> 
            <td><b><?php print $lang->basket_points_cost;?></b></td>
            <td><b><?php print $rec->data['points_value'];?></b></td>
          </tr>
          <?php } ?>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><?php print $lang->order_names['id_pay_method'];?></td>
            <td><?php print langF::translate($config->pay_method[$rec->data['id_pay_method']]);?></td>
          </tr>
          <tr> 
            <td><?php print $lang->order_names['date_add'];?></td>
            <td><?php print $rec->data['date_add'];?></td>
          </tr>
          <tr> 
            <td><?php print $lang->order_names['confirm_user'];?></td>
            <td><?php print $confirm_user;?></td>
          </tr>
          <tr> 
            <td><?php //print $lang->order_names['confirm'];?></td>
            <td><?php //print $confirm;?></td>
          </tr>
          <tr> 
            <td><?php print $lang->order_names['status'];?></td>
            <td><?php 
            	$tmp=show_status($rec->data['id_status']);
            	print langF::translate($tmp);
            	?></td>
          </tr>
      
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <!-- start przesylka -->
          <tr> 
            <td><?php print $lang->order_names['send_confirm'];?></td>
            <td><?php print $send_confirm;?></td>
          </tr><?php if($rec->data['send_confirm']==1) { ?>
          <tr> 
            <td><?php print $lang->order_names['send_date'];?></td>
            <td><?php print $rec->data['send_date'];?></td>
          </tr>
          <tr> 
            <td><?php print $lang->order_names['send_number'];?></td>
            <td><?php print $rec->data['send_number'];?></td>
          </tr>
          <?php }?>
           
          <!-- stop przesylka -->
    <?php
    if(empty($_SESSION['id_partner'])) {
    ?>	
          <tr>
            <td></td>
            <td>
            <a href="javascript:window.open('/go/_contact/contact.php?subject=<?php print $lang->plugins_transuser_ask4trans.$rec->data['order_id'];?>', 'window', 'toolbar=0, status=0, resizable=1, scrollbars=1, width=450, height=350'); void(0);" onMouseOver="window.status=' '; return true;"><?php print $lang->plugins_transuser_ask4;?></a>
            </td>
          </tr>
    <?php
    }
    ?>        </table>
      </td>
      <?php if (!empty($rec->data['info_for_client'])) {?>
      <td valign="top"><table border=0 cellpadding="0" cellspacing="0">
      <tr>
      <td style="padding-bottom:10px;padding-top:15px;""><b><?php print $lang->info_for_client;?></b>:</td>
      </tr>
      <tr>
      <td style="border-style:solid; border-width:1px;padding:5px;"><?php print $rec->data['info_for_client'];?></td>
      </tr>
      </table>
      </td>
      <?php } ?>
    </tr>
  </table>
</center>
