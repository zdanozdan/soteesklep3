<!-- order_step_two.html.php -->
<?php
/**
 * Formularz z danymi klienta do zamowienia, dane bilingowe
 *
 * \@global string $global_register_user_form ["true"|"false"] czy ma sie pojawc okno rejsteracji i logowanie uzytkwonika przy danych billingowych
* @version    $Id: order_step_two.html.php,v 1.1 2007/12/01 10:58:46 tomasz Exp $
* @package    themes
* @subpackage base_theme
 */

global $sess;
global $global_register_user_form;
//print "<pre>";
//if(empty($_SESSION['form_cor']['name'])){
//print "Adres OK";
//}
//print "</pre>";

//print "SESS:" .$_SESSION['corr_addr'];
//print "SESS:" .$_SESSION['form_cor']['name'];

/* if ((empty($_POST['corr_addr']) and empty($_SESSION['corr_addr'])) and empty($_SESSION['form_cor']['name'])) { */
/*     $corr_addr_yes="checked"; */
/*     $corr_addr_no=""; */
/* } else { */
/*     $corr_addr_no="checked"; */
/*     $corr_addr_yes=""; */
/* } */

if (empty($_POST['corr_addr']) and empty($_SESSION['corr_addr']))
{
    $corr_addr_yes="checked";
    $corr_addr_no="";
} else {
    $corr_addr_no="checked";
    $corr_addr_yes="";
}
?>


<?php
// sprawdz czy czasem nie zostalo wylaczone wyswietlanie tego formularza
//if (@$global_register_user_form!="false") {
//}
?>
<center>
<table width="770" cellspacing="0" cellpadding="0" border="0" align="center">
  <tr> 
    <td width="770" valign="top" align="center">
<?php $this->bar($lang->bar_title['register_billing']); ?>
<div class="block_1">
<table width="100%">
<tr>
<td valign="top"><br><?php $this->order_login_form();?></td>
<td>
<form action="<?php print $this->action;?>" method="post">
  <input type="hidden" name="form[check]" value="true">
  <center>
    <a name="forms"></a>
    <table border="0" cellspacing="0" cellpadding="3" align="center" width="450">
<!--
      <tr> 
        <td  style="text-align:left;font-size:12px;color:#696969" colspan="3"> 
          <?php print $lang->koszyk_dane;?>
         <br />
        </td>        
      </tr>
-->
      <tr>
       <td  style="text-align:center;font-size:14px;color:red" colspan="3"> 
          <?php print $lang->koszyk_faktura;?>
         <br />
        </td>
       </tr>
      <tr><td>&nbsp</tr>
      <tr> 
        <td style="text-align: right;" valign="bottom"> 
          <?php print $lang->form_name['firm'];?>
          :</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form[firm]" value="<?php $this->form_val('firm');?>">
          <br />
          <?php $this->form_error('firm');?>
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"><b> 
          <?php print $lang->form_name['name'].", ".$lang->form_name['surname'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="10" name="form[name]" value="<?php $this->form_val('name');?>">
          &nbsp; 
          <input type="text" size="19" name="form[surname]" value="<?php $this->form_val('surname');?>">
          <br />
          <?php $this->form_error('name'); ?>
          <?php $this->form_error('surname'); ?>
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"><b> 
          <?php print $lang->form_name['street'].", ".$lang->form_name['street_n1']; ?>
          </b> ( 
          <?php print $lang->form_name['street_n2'];?>
          ):</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="22" name="form[street]" value="<?php $this->form_val('street');?>">
          &nbsp; 
          <input type="text" size="3" name="form[street_n1]" value="<?php $this->form_val('street_n1');?>">
          / 
          <input type="text" size="3" name="form[street_n2]" value="<?php $this->form_val('street_n2');?>">
          &nbsp; <br />
          <?php $this->form_error('street'); ?>
          <?php $this->form_error('street_n1'); ?>
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"><b> 
          <?php print $lang->form_name['postcode'].", ".$lang->form_name['city'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="10" name="form[postcode]" value="<?php $this->form_val('postcode'); ?>">
          <input type="text" size="19" name="form[city]" value="<?php $this->form_val('city'); ?>">
          <br />
          <?php $this->form_error('postcode'); ?>
          <?php $this->form_error('city'); ?>
        </td>
      </tr>      
      <tr> 
        <td style="text-align: right;"><b> 
          <?php print $lang->form_name['phone'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form[phone]" value="<?php $this->form_val('phone'); ?>">
          <br />
          <?php $this->form_error('phone'); ?>
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"><b> 
          <?php print $lang->form_name['email'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form[email]" value="<?php $this->form_val('email'); ?>">
          <br />
          <?php $this->form_error('email'); ?>
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"> 
          <?php print $lang->form_name['nip']." (".$lang->register_nip_desc.")";?>
        </td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form[nip]" value="<?php $this->form_val('nip'); ?>"><br>                
        </td>
      </tr>
      <tr> 
        <td valign="top" style="text-align: right;"><?php print $lang->form_name['description'] ;?>
          :</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <textarea name="form[description]" rows="4" cols="42" wrap="hard"><?php $this->form_val('description'); ?></textarea>
        </td>
      </tr>
      <tr>
      <td valign="top" style="text-align: right;"><?php print $lang->register_news_desc;?></td>
      <td>&nbsp;</td>
      <td><input class="border0" type="radio" name="form[news]" value="yes" checked>
          <?php print $lang->yes;?>
          <input class="border0" type="radio" name="form[news]" value="no">
          <?php print $lang->no;?></td>
      </tr>
      <tr>
      <td colspan=3 style="padding-top:5px;padding-bottom:5px;"><img src="<?php $this->img('_img/mask.gif');?>"></td>
      </tr>
<tr> 
        <td  style="text-align:center;font-size:14px;color:red" colspan="3"> 
          <?php print $lang->koszyk_dane_delivery;?>
         </td><br />
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;" valign="top"> 
          <?php print $lang->register_cor_desc;?>
        </td>
        <td>&nbsp;</td>
        <td align="left" valign="top"> 
          <input class="border0" type="radio" onclick="this.form.action='/koszyk-dane/action=delivery_change&value=yes#forms';this.form.submit()" name="form[cor_addr]" value="yes" <?php print $corr_addr_yes; ?>>
          <?php print $lang->yes;?>
          <input class="border0" type="radio" onclick="this.form.action='/koszyk-dane/action=delivery_change&value=no#forms';this.form.submit()" name="form[cor_addr]" value="no" <?php print $corr_addr_no; ?>>
          <?php print $lang->no;?>
        </td>
      </tr>
      <tr> 
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

      <?php 
           if ($corr_addr_no == "checked") 
           {
              if (!empty($_SESSION['form_cor']))
              {
                 $form_cor = $_SESSION['form_cor'];
              }
      ?>
      <input type="hidden" name="form_cor[check]" value="true">
      <tr> 
<!--
        <td  style="text-align:left;font-size:12px;color:#696969" colspan="3"> 
          <?php print $lang->koszyk_dane_delivery;?>
         </td><br />
        </td>
-->
      </tr>
      <tr> 
        <td style="text-align: right;" valign="bottom"> 
          <?php print $lang->form_name['firm'];?>
          :</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form_cor[firm]" value="<?php print $form_cor['firm'];?>">
          <br />
          <?php $this->form_cor_error('firm');?>
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"><b> 
          <?php print $lang->form_name['name'].", ".$lang->form_name['surname'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="10" name="form_cor[name]" value="<?php print $form_cor['name'];?>">
          &nbsp; 
          <input type="text" size="19" name="form_cor[surname]" value="<?php print $form_cor['surname'];?>">
          <br />
          <?php $this->form_cor_error('name'); ?>
          <?php $this->form_cor_error('surname'); ?>
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"><b> 
          <?php print $lang->form_name['street'].", ".$lang->form_name['street_n1']; ?>
          </b> ( 
          <?php print $lang->form_name['street_n2'];?>
          ):</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="22" name="form_cor[street]" value="<?php print $form_cor['street'];?>">
          &nbsp; 
          <input type="text" size="3" name="form_cor[street_n1]" value="<?php print $form_cor['street_n1'];?>">
          / 
          <input type="text" size="3" name="form_cor[street_n2]" value="<?php print $form_cor['street_n2'];?>">
          &nbsp; <br />
          <?php $this->form_cor_error('street'); ?>
          <?php $this->form_cor_error('street_n1'); ?>
        </td>
      </tr>
      <tr> 
        <td style="text-align: right;"><b> 
          <?php print $lang->form_name['postcode'].", ".$lang->form_name['city'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="10" name="form_cor[postcode]" value="<?php print $form_cor['postcode']; ?>">
          <input type="text" size="19" name="form_cor[city]" value="<?php print $form_cor['city']; ?>">
          <br />
          <?php $this->form_cor_error('postcode'); ?>
          <?php $this->form_cor_error('city'); ?>
        </td>
      </tr>    

          <?php } ?>

    </table>
  </center>
</td>
</tr>
</table>
</div>
<center>
<?php
if (!empty($_POST['group_1']))
{
   $s_val = $_POST['group_1'];
}
else
{
   $p_num = $_SESSION['ajax_pay_number'];
   $s_val = $lang->pay_method_submit_name[$p_num];
}
?>
   <input type="hidden" name=payment value=<?php print $s_val ?> >
   <br>
   <table width="100%" class="payment">
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
    <span style="font-size:12px">
<?php
         print "<br>";
         print $lang->order_disclaimer['3'];
         print "<a href=/go/_files/?file=terms.html> ". $lang->order_disclaimer['5'] . "</a>";
?>
</form>
</center>
</div>
</p>


    </td>
  </tr>
</table>
</center>
