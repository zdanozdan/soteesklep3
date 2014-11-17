<?php
/**
* @version    $Id: foot.html.php,v 1.16 2005/05/12 10:02:33 krzys Exp $
* @package    themes
* @subpackage base_theme
*/
?>
<table bgcolor=#ffffff cellspacing=3 cellpadding=3 width=760 border=0 align=center>
<tr>
<td>

<table align=center valign=bottom>
<?php
global $buttons;
global $lang;
global $permf;
/*
print "<tr>";
print "<td>";$buttons->button("Opcja klienta 1","");print "</td>";
print "<td>";$buttons->button("Opcja klienta 2","");print "</td>";
print "<td>";$buttons->button("Opcja klienta 3","");print "</td>";
print "<td>";$buttons->button("Opcja klienta 4","");print "</td>";
print "</tr>";
*/
?>
</table>

</td>
</tr>
</table>


<table width="100%" cellspacing="0" cellpadding="0" border="0" align=center>
<tr>

<!-- start wyszukiwanie: -->
<?php
if ($permf->check("products")){
   ?>
<td width=200>
<form action=/go/_edit/index.php target=window>  
<nobr>
<?php print $lang->foot_search_product;?><input type=text size=4 name=user_id>
<input type=submit value="<?php print $lang->go;?>" onClick="open_window(800,600);">
</nobr>
</form>
</td>
<?php }?>
<?php
if ($permf->check("order")){
   ?>
<td width=200>
<form action=/go/_order/edit.php target=window>
<nobr>
<?php print $lang->foot_search_order;?><input type=text size=4 name=order_id>
<input type=submit value="<?php print $lang->go;?>" onClick="open_window (800,600);">
</nobr>
</form>
</td>
<?php
}


if ($config->nccp=="0x1388"){
?>

<form action="/go/_configure/lang.php" method="GET">
<td>
  <?php print $lang->choose_language;?>
  <?php
  if ($config->admin_lang=="pl") { $selected_pl="selected"; $selected_en='';}
   else { $selected_pl=''; $selected_en="selected";}
  ?>  
  <select name=configure[admin_lang] onChange="this.form.submit();">
    <option <?php print $selected_pl;?> value='pl'>Polski</option>
    <option <?php print $selected_en;?> value='en'>English</option>
  </select> 
  <input type=submit value=' > '>
</td>
</form>
<?php
}
?>

<!-- wybierz wyglad panelu -->
<td align=right>
<?php
if ($config->nccp=="0x1388"){
print $lang->right_choose_layout."&nbsp;";
// wybor wygladu panelu
$this->show_themes()
?>
<?php } ?>
</td>
<!-- end wybierz wyglad panelu -->

<!-- end wyszukiwanie: -->
</tr>
</table>


<table bgcolor=#dc191a cellspacing=0 cellpadding=0 width=100% border=0 align=center>
<tr bgcolor="Black">
  <td bgcolor="black"><img height="2" width="2" src="/themes/_pl/standard/_img/point-black.gif"></td>
  <td bgcolor="black"><img height="2" width="2" src="/themes/_pl/standard/_img/point-black.gif"></td>
  <td bgcolor="black"><img height="2" width="2" src="/themes/_pl/standard/_img/point-black.gif"></td>
  
  
</tr>
<tr>
<td valign=top>
  &nbsp; &nbsp; 
  <a href=http://www.sote.pl target=sote><font color=white>
  <B>Copyright (c) SOTE 1999-<?php print date("Y");?></B> 
  </a>
  Powered by Linux
  </font>
</td>

<td align=right>
<font color=white><?php print ($lang->user_log_on.": ".$_SERVER['REMOTE_USER']);?></font>
</td>
<td align=right>
 <a href=/go/_auth/logout.php><font color=white><b><?php print $lang->logout;?></b></font></a>&nbsp; 
</td>
</tr>
</table>

<?php  $this->desktop_close();?>



</body>
</html>
