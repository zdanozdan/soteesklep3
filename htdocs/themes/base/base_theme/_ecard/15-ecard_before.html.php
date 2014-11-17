<?php
/**
* @version    $Id: ecard_before.html.php,v 2.4 2005/11/30 10:50:04 scalak Exp $
* @package    ecard
*/
?>
<center>
<p>

<div align=left><?php $this->button("Powrót do strony g³ównej","/","300");?></div>
<br />

<table align=center width=400>
<tr>
<td width=70%>
P³atno¶æ kart± p³atnicz± za po¶rednictwem bezpiecznego systemu <a href=http://www.ecard.pl target=ecard><u>eCard</u></a>.
<br />
Akceptowane karty: VISA, MasterCard
<p>


<p>
</td>
<td width=30%>
  
  <table align=center>
  <tr>
  <td width=50%>
     <img src=/themes/base/base_theme/_ecard/_img/ecard.gif>
  </td>
  <td>
     <img src=/themes/base/base_theme/_ecard/_img/ecard-euro_mc.gif> <p>
     <img src=/themes/base/base_theme/_ecard/_img/ecard-visa.gif>
     
  </td>
  </tr>
  </table>
  
</td>
</tr>
</table>

<?php 
global $ecard;
if (! empty($ecard)) {
    print $ecard->form();
}
?>
<p>
</center>
