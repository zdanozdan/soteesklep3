<?php
/**
* @version    $Id: register_confirm_limited.html.php,v 1.1 2006/11/23 17:57:58 tomasz Exp $
* @package    themes
* @subpackage base_theme
*/
?>
   <table align="center" width="100%">
   <tr>
   <td style="text-align:left">
<?php
   if (!empty($form_cor['name']) && ($form['cor_addr']=="yes")) 
   {
      print "<b>".$lang->register_cor_address.",</b><br/>";
      print "<b>".strtolower($lang->register_bil_data_payment).":</b><br /><br />";
   }
   else
   {
      print "<b>".$lang->register_bil_data_payment.":</b><br /><br />";
   }
   print "      </td>\n";
   // jesli wprowadzono odzielny adres korepsondencyjny, to wyswietl go
   if (!empty($form_cor['name']) && ($form['cor_addr']=="no")) 
   {
      print "      <td style=\"text-align:left\" width=\"50%\">\n";
      print "<b>".$lang->register_cor_address.":</b><br /><br />";
      print "</td>";
   }
?>
</tr>
<tr>
<td valign="top">
<table id="invoice" align="center" width="100%">  
  <?php
if (! empty($form['firm'])) {
?>
  <tr style="font-size:15px;"> 
    <td align="left"><?php print $form['firm'];?></td>
  </tr>
  <?php
} // end if
?>
  <tr> 
    <td align="left"><?php print $form['name']." ".$form['surname'];?></td>
  </tr>
  <tr> 
    <td align="left"><?php
      print $form['street']." ".$form['street_n1'];
      if (! empty($form['street_n2'])) {
        print "/".$form['street_n2']; 
      }
      ?></td>
  </tr>
  <tr> 
    <td align="left"><?php print $form['postcode']." ".$form['city'];?></td>
  </tr>
  <tr> 
    <td align="left"><?php print $lang->country[$form['country']];?></td>
  </tr>
  <tr> 
    <td align="left"><?php print $form['phone'];?></td>
  </tr>
  <tr> 
    <td align="left"><?php print $form['email'];?></td>
  </tr>
  <?php
  if (! empty($form['nip'])) {
?>
  <tr> 
    <td align="left"><?php print $form['nip'];?></td>
  </tr>
  <?php
      }
?>
  <?php
  if (! empty($form['description'])) {
?>
  <tr> 
    <td align="left"><?php print $form['description'];?></td>
  </tr>
  <?php
      }
?>
</table>
<?php
print "</td><td valign=\"top\">\n";
// jesli wprowadzono odzielny adres korepsondencyjny, to wyswietl go
if (!empty($form_cor['name']) && ($form['cor_addr']=="no")) {
   //print "    <td>&nbsp;&nbsp;&nbsp;</td>\n";
   // print "    <td>\n";
   // print "<b>".$lang->register_cor_address."</b><br /><br />";				
?>
<table id="invoice" width="100%" height="100%">
  <?php
if (!empty($form_cor['firm'])) {
?>
  <tr> 
    <td align="left"><?php print $form_cor['firm'];?></td>
  </tr>
  <?php
} // end if
?>
  <tr> 
    <td align="left"><?php print $form_cor['name']." ".$form_cor['surname'];?></td>
  </tr>
  <tr> 
    <td align="left"><?php
    print $form_cor['street']." ".$form_cor['street_n1'];
    if (! empty($form_cor['street_n2'])) {
      print "/".$form_cor['street_n2']; 
    }
  ?></td>
  </tr>  
  <tr> 
    <td align="left"><?php print $form_cor['postcode']." ".$form_cor['city'];?></td>
  </tr>
  <tr> 
    <td align="left"><?php print $lang->country[$form_cor['country']];?></td>
  </tr>
  <tr> 
    <td align="left"><?php print $form_cor['phone'];?></td>
  </tr>
  <tr> 
    <td align="left"><?php print $form_cor['email'];?></td>
  </tr>
  </table>
<?php
print "  </td>\n";
}
print "    </tr>\n";
print "  </table>\n";
print "<table width=\"100%\"><tr><td style=\"color:#808080;text-align:left\">";
print ($lang->register_bil_data_payment_change);
print "  </table>\n";
print "<br />\n";
?>
<!-- koniec adresu korespondencyjnego-->
