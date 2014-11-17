<?php
/**
* @version    $Id: window.html.php,v 1.2 2005/06/30 12:29:06 lechu Exp $
* @package    ask4price
* \@ask4price
*/

global $lang, $_SESSION;
$ask4price_list = @$_SESSION['ask4price_list'];
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<LINK rel="stylesheet" href="<?php $this->img("_style/style.css");?>" type="text/css">
</HEAD>
<BODY>
<CENTER>
<TABLE width="300" border="0" cellspacing="0" cellpadding="0">
 <TR>
  <TD colspan="100%"><?php $this->bar($lang->ask4price); ?><br /></TD> 
 </TR>
 <?php
 if(count($ask4price_list) > 0) {
 ?>
 <TR> 
  <TD colspan="100%" align=center>
    <table cellspacing="1" cellpadding="3" bgcolor="Black"  style="width: 348px;">
        <tr bgcolor="White">
            <td><b><?php echo $lang->ask4price_order; ?></b></td>
            <td><b><?php echo $lang->ask4price_id; ?></b></td>
            <td><b><?php echo $lang->ask4price_name; ?></b></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
<?php
    $lp = 1;
    reset($ask4price_list);
    while (list($key, $val) = each($ask4price_list)) {
        $id = $val['id'];
        $producer = $val['producer'];
        $name = $val['name'] . " ($producer)";
?>
        <tr bgcolor="White">
            <td><?php echo $lp; ?></td>
            <td><?php echo $id; ?></td>
            <td><?php echo $name; ?></td>
            <td><a href="/plugins/_ask4price/?action=delete&id=<?php echo $id; ?>"><?php echo $lang->ask4price_delete; ?></a></td>
        </tr>
<?php 
        $lp++;
    }
?>
    </table>
    <br>
    <br>
  </TD>
 </TR>
 <form action=/plugins/_ask4price/send.php method=post>
  <TR>
   <td><?php echo $lang->ask4price_name_company; ?>:</td>
   <TD align=center>
    <input type=text size=40 name=ask4price_name_company>
   </TD>
  </TR>
  <TR>
   <td><?php echo $lang->ask4price_email; ?>:</td>
   <TD align=center>
    <input type=text size=40 name=ask4price_email><br /><br />
   </TD>
  </TR>
  <TR>
   <td colspan="2"><?php echo $lang->ask4price_comment; ?>:<br>
    <textarea name=ask4price_comment style="width: 348px;"></textarea>
    <br><br>
   </TD>
  </TR>
 <TR>
  <TD align=right>
   <button type="button" onclick="window.close();"><?php print $lang->ask4price_back;?></button><br /><br />
  </TD>
  <TD align=right>
   <?php
   global $_SESSION;
   if(!empty($_SESSION['ask4price_list'])) {
       ?>
       <button type="submit" onclick="this.form.submit();"><?php print $lang->ask4price_send;?></button><br /><br />
       <?php
   }
   ?>
  </TD>
 </TR> 
  <?php
}
else {
  ?>
<tr>
    <td colspan="100%" align="center">
      <br>
      <?php echo $lang->ask4price_empty_list; ?>
      <br>
      <br>
      <button onclick="window.close()"><?php echo $lang->close; ?></button>
      <br>
      <br>
    </td>
</tr>
  <?php
}
  ?>
 <TR> 
  <TD width="150" bgcolor="#000000"colspan="2"><IMG src="<?php $this->img("_img/mask.gif");?>" width="1" height="1"></TD>
 </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>
