<?php
/**
* @version    $Id: register_confirm.html.php,v 1.1 2006/09/27 21:53:22 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
if ((! empty($form_cor['name'])) && (@$form['cor_addr']=="yes")) {
    print "<center><b>".$lang->register_bil_cor_data."</b></center><br />";    
} else {   
    print "<center>\n";
    print "  <table align=\"center\" border=\"0\">\n";
    print "    <tr>\n";
    print "      <td valign=\"top\" align=\"center\">\n";
    print "<br><b>".$lang->register_bil_data_payment."</b><br /><br />";
}
?> 
<table class="block_1" align="center" width="100%">  
  <?php
if (! empty($form['firm'])) {
?>
  <tr> 
    <td align="right"><?php print $lang->form_name['firm'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form['firm'];?></td>
  </tr>
  <?php
} // end if
?>
  <tr> 
    <td align="right"><?php print $lang->form_name['name']." i  ".$lang->form_name['surname'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form['name']." ".$form['surname'];?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['street'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php
      print $form['street']." ".$form['street_n1'];
      if (! empty($form['street_n2'])) {
        print "/".$form['street_n2']; 
      }
      ?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['postcode'].", ".$lang->form_name['city'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form['postcode']." ".$form['city'];?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['country'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $lang->country[$form['country']];?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['phone'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form['phone'];?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['email'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form['email'];?></td>
  </tr>
  <?php
  if (! empty($form['nip'])) {
?>
  <tr> 
    <td align="right"><?php print $lang->form_name['nip'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form['nip'];?></td>
  </tr>
  <?php
      }
?>
  <?php
  if (! empty($form['description'])) {
?>
  <tr> 
    <td align="right"><?php print $lang->form_name['description'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form['description'];?></td>
  </tr>
  <?php
      }
?>
</table>
<?php
print "</td>\n";
// jesli wprowadzono odzielny adres korepsondencyjny, to wyswietl go
if (!empty($form_cor['name']) && ($form['cor_addr']=="no")) {
    print "    <td>&nbsp;&nbsp;&nbsp;</td>\n";
    print "    <td valign=\"top\" align=\"center\">\n";
    print "<b>".$lang->register_cor_address."</b><br /><br />";				
?>
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <?php
if (!empty($form_cor['firm'])) {
?>
  <tr> 
    <td align="right"><?php print $lang->form_name['firm'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form_cor['firm'];?></td>
  </tr>
  <?php
} // end if
?>
  <tr> 
    <td align="right"><?php print $lang->form_name['name']." i  ".$lang->form_name['surname'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form_cor['name']." ".$form_cor['surname'];?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['street'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php
    print $form_cor['street']." ".$form_cor['street_n1'];
    if (! empty($form_cor['street_n2'])) {
      print "/".$form_cor['street_n2']; 
    }
  ?></td>
  </tr>  
  <tr> 
    <td align="right"><?php print $lang->form_name['postcode'].", ".$lang->form_name['city'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form_cor['postcode']." ".$form_cor['city'];?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['country'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $lang->country[$form_cor['country']];?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['phone'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form_cor['phone'];?></td>
  </tr>
  <tr> 
    <td align="right"><?php print $lang->form_name['email'];?>:</td>
    <td>&nbsp;&nbsp;&nbsp;</td>
    <td align="left"><?php print $form_cor['email'];?></td>
  </tr>
</table>
<?php
print "  </td>\n";
}
print "    </tr>\n";
print "  </table>\n";
print ($lang->register_bil_data_payment_change);
print "</center>\n";
print "<br />\n";
?>
<!-- koniec adresu korespondencyjnego-->