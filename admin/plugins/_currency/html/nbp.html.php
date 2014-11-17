<?php
/**
* Szablon wyswietlenia kursow walut
*
* @author  krzys@sote.pl
* @version $Id: nbp.html.php,v 2.3 2004/12/20 17:59:31 maroslaw Exp $
* @package    currency
*/
?>
<center><?php  print $lang->currency_nbp['welcome_text'].date("d/m/y");?>.</center><br><br>

<table border=0 cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td widht=170 >
      <b><center><?php print $lang->currency_nbp['country']; ?> </center></b>
    </td>
    <td valign="middle">
      <b><center><?php print $lang->currency_nbp['currency_name']; ?></center></b>
    </td>
    <td valign="middle">
      <b><center><?php print $lang->currency_nbp ['currency_code']; ?></center></b>
    </td>
    <td valign="middle">
      <b><center><?php print $lang->currency_nbp ['exchange']; ?></center></b>
    </td>
  </tr>
  <tr>
    <td><hr /></td>
    <td><hr /></td>
    <td><hr /></td>
    <td><hr /></td>
  </tr>
  <?php
  for ($i=0;$i<22;$i++)
  {
      // wyciaganie kursow tylko w przeliczeniu do 1 pln
      if (($Kursy[$i]->przelicznik)==1){
          //zamiana , na .
          $kurs_sredni_kropka = str_replace(",", ".",$Kursy[$i]->kurs_sredni);
          
          print ("<tr><td><img src=/themes/base/base_theme/_img/flags/".$i.".png width=57 height=30 border=1><br></td>");
          print ("<td width=170><center>".$Kursy[$i]->nazwa_waluty."</center></td>");
          print ("<td width=40><center>".$Kursy[$i]->kod_waluty."</center></td>");
          print ("<td width=100><center>".$kurs_sredni_kropka."</center></td></tr>");
          print ("<tr><td><hr /></td><td><hr /></td><td><hr /></td><td><hr /></td></tr>");
          
      }
  }
  ?>
</table>
