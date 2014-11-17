<?php
/**
* @version    $Id: register_cor.html.php,v 1.1 2006/09/27 21:53:22 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<form action="<?php print $this->action;?>" method="post">
  <input type="hidden" name="form_cor[check]" value="true">
  <br />
  <center>
    <table border="0" cellspacing="0" cellpadding="0" align="center" width="450">
      <tr> 
        <td align="right"><?php print $lang->form_name['firm'];?>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="30" name="form_cor[firm]" value="<?php $this->form_val('firm');?>">
          <br>
          <?php $this->form_error('firm');?>
        </td>
      </tr>
      <tr> 
        <td align="right"><b> 
          <?php print $lang->form_name['name'].", ".$lang->form_name['surname'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="10" name="form_cor[name]" value="<?php $this->form_val('name');?>">
          <input type="text" size="20" name="form_cor[surname]" value="<?php $this->form_val('surname');?>">
          <br>
          <?php $this->form_error('name');?>
          <?php $this->form_error('surname');?>
        </td>
      </tr>
      <tr> 
        <td align="right"><b> 
          <?php print $lang->form_name['street'].", ".$lang->form_name['street_n1']; ?>
          </b> ( 
          <?php print $lang->form_name['street_n2'];?>
          ):</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="20" name="form_cor[street]" value="<?php $this->form_val('street');?>">
          <input type="text" size="3" name="form_cor[street_n1]" value="<?php $this->form_val('street_n1');?>">
          / 
          <input type="text" size="3" name="form_cor[street_n2]" value="<?php $this->form_val('street_n2');?>">
          <br>
          <?php $this->form_error('street');?>
          <?php $this->form_error('street_n1');?>
        </td>
      </tr>
      <tr> 
        <td align="right"><b> 
          <?php print $lang->form_name['postcode'].", ".$lang->form_name['city'];?>
          </b>:</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="6" name="form_cor[postcode]" value="<?php $this->form_val('postcode'); ?>">
          <input type="text" size="20" name="form_cor[city]" value="<?php $this->form_val('city'); ?>">
          <br>
          <?php $this->form_error('postcode');?>
          <?php $this->form_error('city');?>
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
        $country = $_SESSION['global_country_delivery'];
        $this->inputCountries("form_cor[country]", $country, 1);
        ?>
          <br />
          <?php $this->form_error('country'); ?>
        </td>
      </tr>
      <tr> 
        <td align="right"> 
          <?php print $lang->form_name['phone'];?>
          :</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="20" name="form_cor[phone]" value="<?php $this->form_val('phone'); ?>">
          <br>
          <?php $this->form_error('phone'); ?>
        </td>
      </tr>
      <tr> 
        <td align="right"> 
          <?php print $lang->form_name['email'];?>
          :</td>
        <td>&nbsp;</td>
        <td align="left"> 
          <input type="text" size="20" name="form_cor[email]" value="<?php $this->form_val('email'); ?>">
          <br>
          <?php $this->form_error('email'); ?>
        </td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left">
          <input type="submit" name="Submit" value="<?php echo $lang->next; ?>">
        </td>
      </tr>
    </table>
  </center>
</form>
