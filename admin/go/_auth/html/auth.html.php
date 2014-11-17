<?php 
/**
 *
 * Autoryzacja administartora, wyswietlenie menu wpisywania pinu
 * @author m@sote.pl
 * @version $Id: auth.html.php,v 2.9 2004/12/20 17:57:54 maroslaw Exp $
* @package    auth
 */
?>
<HTML>
<HEAD>
<TITLE><?php print $lang->head_title;?></TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
</HEAD>

<link rel="stylesheet" href="/themes/base/base_theme/_style/style.css">

<BODY BGCOLOR=WHITE>

<?php

// naglowek
print "<table width=300 align=center><tr><td>";
$theme->bar($lang->auth_title);

print "<br>";
$theme->desktop_open(300);
?>

<form action=index.php method=post name=Login>
<table align=center>
<tr>
<td valign=top><?php print $lang->auth_pin;?></td>
<td>
  <input type=password size=20 name=pin>
  <BR>
  <?php print @$license_error;?>
  <?php
  if ($license->days>0) {
      print "<p>";
      if ($license->active_days>0) { 
          print "$lang->auth_license_days<b>$license->active_days</b></nobr><br>";
      }
      print "<nobr>$lang->auth_license_date <b>$license->active_date</b></nobr><BR>";
  }
  ?>
</td>
<td valign=top>
  <?php $buttons->button($lang->auth_log_in,"javascript:document.Login.submit();");?>
</td>
</tr>
</table>
<center>

</center>
<p>
</form>

<?php
$theme->desktop_close();
print "</td></tr></table>";
?>


</BODY>
</HTML>
