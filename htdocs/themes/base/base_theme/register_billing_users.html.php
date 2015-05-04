<?php
/**
 * Formularz z danymi klienta do zamowienia, dane bilingowe
 *
 * \@global string $global_register_user_form ["true"|"false"] czy ma sie pojawc okno rejsteracji i logowanie uzytkwonika przy danych billingowych
* @version    $Id: register_billing_users.html.php,v 1.2 2007/12/01 11:00:18 tomasz Exp $
* @package    themes
* @subpackage base_theme
 */

global $sess;
global $global_register_user_form;
?>
<?php
// sprawdz czy czasem nie zostalo wylaczone wyswietlanie tego formularza
//if (@$global_register_user_form!="false") {
//}
?>
<form class="orderform" action="<?php print $this->action;?>" method="post">
  <input type="hidden" name="form[check]" value="true">
<div class="block_1">
  <center>
    <table border="0" cellspacing="0" cellpadding="3" align="center" width="450">
      <tr> 
        <td align="center" colspan="3"><font size="2"><b> 
          <?php print $lang->register_fill_gaps;?>
          </b></font><br />
        </td>
      </tr>
      <tr> 
        <td align="right" valign="bottom"><?php print $lang->form_name['firm'];?>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form[firm]" value="<?php $this->form_val('firm');?>">
          <br />
          <?php $this->form_error('firm');?>
        </td>
      </tr>
      <tr> 
        <td align="right"><b><?php print $lang->form_name['name'].", ".$lang->form_name['surname'];?></b>:</td>
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
        <td align="right"><b> 
          <?php print $lang->form_name['street'].", ".$lang->form_name['street_n1']; ?>
          </b> ( 
          <?php print $lang->form_name['street_n2'];?>):</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="22" name="form[street]" value="<?php $this->form_val('street');?>">&nbsp;<input type="text" size="3" name="form[street_n1]" value="<?php $this->form_val('street_n1');?>">/<input type="text" size="3" name="form[street_n2]" value="<?php $this->form_val('street_n2');?>">&nbsp;<br />
          <?php $this->form_error('street'); ?>
          <?php $this->form_error('street_n1'); ?>
        </td>
      </tr>
      <tr> 
        <td align="right"><b> 
          <?php print $lang->form_name['postcode'].", ".$lang->form_name['city'];?></b>:</td>
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
        <td align="right"><b> 
          <?php print $lang->form_name['country'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
        <?php  
        global $_SESSION;
          $country='';
          if(!empty($_SESSION['global_country_delivery'])) {
        		$country = $_SESSION['global_country_delivery'];
          } 
          if(!empty($this->form['country']))
              $country = $this->form['country'];

              $this->inputCountries("form[country]", $country, 0);

        ?>
          <br />
          <?php $this->form_error('country'); ?>
        </td>
      </tr>
      <tr> 
        <td align="right"><b> 
          <?php print $lang->form_name['phone'];?></b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form[phone]" value="<?php $this->form_val('phone'); ?>">
          <br />
          <?php $this->form_error('phone'); ?>
        </td>
      </tr>
      <tr> 
        <td align="right"><b> 
          <?php print $lang->form_name['email'];?></b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form[email]" value="<?php $this->form_val('email'); ?>">
          <br />
          <?php $this->form_error('email'); ?>
        </td>
      </tr>
      <tr> 
        <td align="right"> 
          <?php print $lang->form_name['nip']." (".$lang->register_nip_desc.")";?>
        </td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form[nip]" value="<?php $this->form_val('nip'); ?>">
        </td>
      </tr>
      <tr> 
        <td valign="top" align="right"> 
          <?php print $lang->form_name['description'] ;?>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <textarea name="form[description]" rows="4" cols="42" wrap="hard"><?php $this->form_val('description'); ?></textarea>
        </td>
      </tr>
      <tr>
      <td valign="top" align="right"><?php print $lang->register_news_desc;?></td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="submit" class="btn btn-primary" value="<?php print $lang->next;?>">
        </td>
      </tr>
    </table>
  </center>
  </div>
</form>
