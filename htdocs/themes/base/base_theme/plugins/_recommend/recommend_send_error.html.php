<?php
/**
* @version    $Id: recommend_send_error.html.php,v 1.3 2004/12/20 18:02:38 maroslaw Exp $
* @package    recommend
*/
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<LINK rel="stylesheet" href="<?php $this->img("_style/style.css");?>" type="text/css">
</HEAD>
<BODY>
<?php
if (! empty($_REQUEST['shop'])) {
    $bar_name=$lang->recommend_s;
} else {
    $bar_name=$lang->recommend_p;
}
?>
<CENTER>
<TABLE width="300" border="0" cellspacing="0" cellpadding="0">
 <TR>
  <TD><?php $this->bar($bar_name); ?><br /></TD>
 </TR>
 <TR>
  <TD align=center><br /><br />
  <?php print $lang->recommend_send_error; ?>.<br />
  <?php print $lang->recommend_send_error_sorry; ?>.<br /><br /> 
  </TD>
 </TR>
 <TR>
  <TD width="150" bgcolor="#000000"><IMG src="<?php $this->img("_img/mask.gif");?>" width="1" height="1"></TD>
 </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>
