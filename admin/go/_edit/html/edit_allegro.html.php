<?php
/**
* Edycja opcji zwi±zanych z allegro.pl
*
* @author  krzys@sote.pl
* @version $Id: edit_allegro.html.php,v 2.6 2006/06/28 08:57:06 lukasz Exp $
*
* @package    edit
*/
?>

<?php 
global $action;
global $DOCUMENT_ROOT;

include_once("include/allegro.inc.php");
$allegro=new Allegro;
$id=@$_REQUEST['id'];
print "<br><center>";        

$theme->desktop_open();

if (@$rec->data['allegro_auction_type']=="2") {
    $allegro_auction_type2="checked";
} else  {
    $allegro_auction_type1="checked";
}

if (@$rec->data['allegro_delivery_shipment']=="1") $check_allegro_delivery_shipment="checked"; else $check_allegro_delivery_shipment="";
if (@$rec->data['allegro_delivery_priority_shipment']=="2") $check_allegro_delivery_priority_shipment="checked"; else $check_allegro_delivery_priority_shipment="";
if (@$rec->data['allegro_delivery_courier']=="4") $check_allegro_delivery_courier="checked"; else $check_allegro_delivery_courier="";
if (@$rec->data['allegro_delivery_personal_acceptance']=="8") $check_allegro_delivery_personal_acceptance="checked"; else $check_allegro_delivery_personal_acceptance="";
if (@$rec->data['allegro_delivery_other']=="16") $check_allegro_delivery_other="checked"; else $check_allegro_delivery_other="";
if (@$rec->data['allegro_delivery_abroad']=="32") $check_allegro_delivery_abroad="checked"; else $check_allegro_delivery_abroad="";

if (@$rec->data['allegro_pay_wire_transfer']=="1") $check_allegro_pay_wire_transfer="checked"; else $check_allegro_pay_wire_transfer="";
if (@$rec->data['allegro_pay_collect_on_delivery']=="2") $check_allegro_pay_collect_on_delivery="checked"; else $check_allegro_pay_collect_on_delivery="";
//if (@$rec->data['allegro_pay_on_line_pay']=="4") $check_allegro_pay_on_line_pay="checked"; else $check_allegro_pay_on_line_pay="";
if (@$rec->data['allegro_pay_payu_accept_escrow']=="8") $check_allegro_pay_payu_accept_escrow="checked"; else $check_allegro_pay_payu_accept_escrow="";
if (@$rec->data['allegro_pay']=="1") $check_allegro_pay="checked"; else $check_allegro_pay="";

if (@$rec->data['allegro_miniature']=="2") $check_allegro_miniature="checked"; else $check_allegro_miniature="";
if (@$rec->data['allegro_bold']=="1") $check_allegro_bold="checked"; else $check_allegro_bold="";
if (@$rec->data['allegro_light']=="4") $check_allegro_light="checked"; else $check_allegro_light="";
if (@$rec->data['allegro_favouritism']=="8") $check_allegro_favouritism="checked"; else $check_allegro_favouritism="";
if (@$rec->data['allegro_category_site']=="16") $check_allegro_category_site="checked"; else $check_allegro_category_site="";
if (@$rec->data['allegro_home_page']=="32") $check_allegro_home_page="checked"; else $check_allegro_home_page="";



?>
<form action=<?php print @$action;?> method=post name=editForm  enctype=multipart/form-data>
<input type=hidden name=user_id value='<?php print @$_REQUEST['user_id'];?>'>
<input type=hidden name=update value=true>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td width="60" valign="top">

<table border=0 align="center" cellpadding="3" cellspacing="9">
<tr>
  <td align="left" bgcolor="#d0f9f9" colspan="2"><b><nobr><?php print $lang->edit_allegro['allegro_auction_type']; ?>:</nobr></b></td>
</tr>
<tr>  
<td colspan="2">
  <input type=radio name=item[allegro_auction_type] value="1" <?php print @$allegro_auction_type1; ?>><?php print $lang->edit_allegro['allegro_auction_type_auction'];?><Br>
  <input type=radio name=item[allegro_auction_type] value="2" <?php print @$allegro_auction_type2; ?>><?php print $lang->edit_allegro['allegro_auction_type_buy_now'];?>
  </td>
</tr>
<tr>
  <td width="30%" align="right"><b><?php print $lang->edit_allegro['allegro_product_name']; ?>:</b></td>
  <?php
  //odczytaj nazwe produktu
  if(empty($rec->data['allegro_product_name'])) {
      $name=$database->sql_select("name_L0","main","user_id=".$user_id);
  } else {
    $name=$rec->data['allegro_product_name'];
  }
  ?>
  <td><input type="text" name="item[allegro_product_name]" size="30" value="<?php print $name; ?>"></td>
</tr>
<tr>
  <td width="20%" align="left" colspan="2" bgcolor="#dcddf9"><b><?php print $lang->edit_allegro['allegro_product_description']; ?>:</b></td>
</tr>
<tr>
  <?php
  //odczytaj nazwe produktu
  if(empty($rec->data['allegro_product_description'])) {
      $desc=$database->sql_select("xml_description_L0","main","user_id=".$user_id);
  } else {
      $desc=$rec->data['allegro_product_description'];
  }
  ?>
<td colspan="2"><textarea cols="50" rows="20" name="item[allegro_product_description]"><?php print $desc; ?></textarea></td>
</tr>
<tr>
  <?php
  //odczytaj nazwe produktu
  if(empty($rec->data['allegro_photo'])) {
      $photo=$database->sql_select("photo","main","user_id=".$user_id);
  } else {
      $photo=@$rec->data['allegro_photo'];
  }
 ?>
    <td width="20%" align="right"><b><?php print $lang->edit_allegro['allegro_photo']; ?>:</b></td>
  <td>
  <input type="text" name="item[allegro_photo]" size="30" value="<?php print $photo; ?>">
  </td>
</tr>
<tr>
  <td width="20%" align="right"><b><?php print $lang->edit_allegro['allegro_miniature']; ?>:</b></td>
  <td><input type="checkbox" name=item[allegro_miniature] value="2" <?php print $check_allegro_miniature; ?>></td>
</tr>
</table>


</td>
<td align="left" valign="top">


<table border=0 align="left" cellpadding="4">
<tr>
<td>
<table border=0 align="left" cellpadding="4">
<tr>
<td colspan="4" bgcolor="#e2f9a7"><b><?php print $lang->edit_allegro['allegro_prices_duration']; ?>:</b></td>
</tr>
<?php
//ustawianie cen
//$price_brutto=$database->sql_select("price_brutto","main","user_id=".$user_id);
/*if(empty($rec->data['allegro_price_start'])) {
    $allegro_price_start=$price_brutto;
} else {
    $allegro_price_start=$rec->data['allegro_price_start'];
}*/
$allegro_price_start=@$rec->data['allegro_price_start'];
$allegro_price_buy_now=@$rec->data['allegro_price_buy_now'];
$allegro_price_min=@$rec->data['allegro_price_min'];
$allegro_stock=@$rec->data['allegro_stock'];

?>


<tr>
<td width="20%" align="right"><b><?php print $lang->edit_allegro['allegro_price_start']; ?>:</b></td>
  <td><input type="text" name="item[allegro_price_start]" size="10" value="<?php print $allegro_price_start;?>"> 
  <?php print $lang->edit_allegro['allegro_currency']; ?></td>
  <td width="20%" align="right"><b><?php print $lang->edit_allegro['allegro_price_buy_now']; ?>:</b></td>
  <td><input type="text" name="item[allegro_price_buy_now]" size="10" value="<?php print $allegro_price_buy_now;?>"> <?php print $lang->edit_allegro['allegro_currency']; ?></td>
</tr>
<tr>
  <td width="20%" align="right"><b><?php print $lang->edit_allegro['allegro_price_min']; ?>:</b></td>
  <td><input type="text" name="item[allegro_price_min]" size="10" value="<?php print $allegro_price_min;?>"> <?php print $lang->edit_allegro['allegro_currency']; ?></td></td>
  <td width="20%" align="right"><b><?php print $lang->edit_allegro['allegro_stock']; ?>:</b></td>
  <td><input type="text" name="item[allegro_stock]" size="3" value="<?php print $allegro_stock;?>"></td>
</tr>
<tr>
  <td width="20%" align="right"><b><nobr><?php print $lang->edit_allegro['allegro_how_long']; ?></nobr>:</b></td>
  <td>
  <select name="item[allegro_how_long]">
  <?php
    foreach($allegro_config->allegro_time as $key=>$value) {
        if($rec->data['allegro_how_long'] == $key) {
            print "<option value=\"".$key."\" selected>".$value."</option>";
        } else {
            print "<option value=\"".$key."\">".$value."</option>";
        }    
    }
  ?>
  </select> 
  <?php print $lang->edit_allegro['allegro_days']; ?></td>
</tr>
</table>
</td>
</tr>
  
<tr>
  <td colspan="2"><table border="0" cellpadding="3" cellspacing="3" width="100%">
  		<tr>
  			<td colspan="2" bgcolor="#fdffc9"><b><?php print $lang->edit_allegro['allegro_delivery']; ?>:</b></td>
  		</tr>
  		<tr>
  			<td width="100"><nobr><?php print $lang->edit_allegro['allegro_delivery_who_pay']; ?></nobr></td>
  			<td>
            <select name="item[allegro_delivery_who_pay]">
 			<?PHP
  			foreach($allegro_config->allegro_trans as $key=>$value) {
                if($rec->data['allegro_delivery_who_pay'] == $key) {
                    print "<option value=\"".$key."\" selected>".$value."</option>";
                } else {
                    print "<option value=\"".$key."\">".$value."</option>";
                }    
  			}
  			?>
            </select> 
            </td>
            </tr>
  		<tr>
  		<td colspan="2">
  		<input type="checkbox" name=item[allegro_delivery_shipment]  value="1" <?php print $check_allegro_delivery_shipment; ?>><?php print $lang->edit_allegro['allegro_delivery_shipment'];?><br>
  		<input type="checkbox" name=item[allegro_delivery_priority_shipment]  value="2" <?php print $check_allegro_delivery_priority_shipment; ?>><?php print $lang->edit_allegro['allegro_delivery_priority_shipment'];?><br>
  		<input type="checkbox" name=item[allegro_delivery_courier]  value="4" <?php print $check_allegro_delivery_courier; ?>><?php print $lang->edit_allegro['allegro_delivery_courier'];?><br>
  		<input type="checkbox" name=item[allegro_delivery_personal_acceptance]  value="8" <?php print $check_allegro_delivery_personal_acceptance; ?>><?php print $lang->edit_allegro['allegro_delivery_personal_acceptance'];?><br>
  		<input type="checkbox" name=item[allegro_delivery_other]  value="16" <?php print $check_allegro_delivery_other; ?>><?php print $lang->edit_allegro['allegro_delivery_other'];?>
  		<input type="text" name=item[allegro_delivery_other_text] size="50" value="<?php print @$rec->data['allegro_delivery_other_text']?>"><br>
  		<input type="checkbox" name=item[allegro_delivery_abroad]  value="32" <?php print $check_allegro_delivery_abroad; ?>><?php print $lang->edit_allegro['allegro_delivery_abroad'];?><br>
  		</td>
  		</tr>
  		</table>
    </td>
</tr>
<tr>
  <td colspan="2"><table border="0" cellpadding="3" cellspacing="3" width="100%">
  		<tr>
  			<td colspan="2" bgcolor="#f9eabe"><b><?php print $lang->edit_allegro['allegro_pay']; ?>:</b></td>
  		</tr>
  		<tr>
  		<td colspan="2">
  		
  		<input type="checkbox" name=item[allegro_pay_wire_transfer] value="1" <?php print $check_allegro_pay_wire_transfer; ?>>
  		<?php print $lang->edit_allegro['allegro_pay_wire_transfer'];print "&nbsp;&nbsp;&nbsp;&nbsp;".$lang->edit_allegro['allegro_pay_price'];?>: 
  		<input type="text" name=item[allegro_pay_wire_transfer_price] size="10" value="<?php print @$rec->data['allegro_pay_wire_transfer_price']?>">
  		 <?php print $lang->edit_allegro['allegro_currency']; ?><br>
  		
  		<input type="checkbox" name=item[allegro_pay_collect_on_delivery]  value="2" <?php print $check_allegro_pay_collect_on_delivery; ?>><?php print $lang->edit_allegro['allegro_pay_collect_on_delivery'];
  		print "&nbsp;&nbsp;&nbsp;&nbsp;".$lang->edit_allegro['allegro_pay_price'];?>: 
  		<input type="text" name=item[allegro_pay_collect_on_delivery_price] size="10" value="<?php print @$rec->data['allegro_pay_collect_on_delivery_price']?>">
  		 <?php print $lang->edit_allegro['allegro_currency']; ?><br>
  		
  		<!--<input type="checkbox" name=item[allegro_pay_on_line_pay]  value="4" <?php // print $check_allegro_pay_on_line_pay; ?>><?php // print $lang->edit_allegro['allegro_pay_on_line_pay'];?><br>-->
  		<input type="checkbox" name=item[allegro_pay_payu_accept_escrow] value="8" <?php print $check_allegro_pay_payu_accept_escrow; ?> ><?php print $lang->edit_allegro['allegro_pay_payu_accept_escrow'];?><br>
  		</td>
  		</tr>
  		</table>
    </td>
</tr>

<tr>
<td><table border=0 cellpadding="3" cellspacing="3" width="100%">
<tr>
<td colspan="6" bgcolor="#f9dcdc"><b><?php print $lang->edit_allegro['allegro_additional_options']; ?>:</b></td>
</tr>
<tr>
 <td width="20%" align="right"><b><nobr><?php print $lang->edit_allegro['allegro_bold']; ?>:</nobr></b></td>
  <td><input type="checkbox" name=item[allegro_bold]  value="1" <?php print $check_allegro_bold; ?>></td>
  <td width="20%" align="right"><b><?php print $lang->edit_allegro['allegro_light']; ?>:</b></td>
  <td><input type="checkbox" name=item[allegro_light]  value="4" <?php print $check_allegro_light; ?>></td>
  <td width="20%" align="right"><b><?php print $lang->edit_allegro['allegro_favouritism']; ?>:</b></td>
  <td><input type="checkbox" name=item[allegro_favouritism] value="8" <?php print $check_allegro_favouritism; ?>></td>
</tr>
<tr>
  <td align="right"><b><?php print $lang->edit_allegro['allegro_category_site']; ?>:</b></td>
  <td><input type="checkbox" name=item[allegro_category_site] value="16" <?php print $check_allegro_category_site; ?>></td>
  <td align="right"><b><?php print $lang->edit_allegro['allegro_home_page']; ?>:</b></td>
  <td><input type="checkbox" name=item[allegro_home_page] value="32" <?php print $check_allegro_home_page; ?>></td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td colspan="2" align="left">
<table><tr>
<td width="10%" align="left"><b><?php print $lang->edit_allegro['allegro_category']; ?>:</b></td>
  <td><?php 
  print $allegro->buildTree(@$rec->data['allegro_category']); ?></td>
</tr>
</table>
</td>
</tr>

<tr>
<td colspan="2" align="center">&nbsp;</td>
</tr>

<tr>
<td colspan="2" align="center"><?php $buttons->button($lang->edit_edit_submit,"javascript:document.editForm.submit();");?></td>
</tr>

</table>
<?php
$theme->desktop_close();
?>
<!-- pasaz.ceneo.pl -->
