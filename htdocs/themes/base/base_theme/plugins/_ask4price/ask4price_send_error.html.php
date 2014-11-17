<?php
/**
* @version    $Id: ask4price_send_error.html.php,v 1.1 2005/06/29 08:43:38 lechu Exp $
* @package    ask4price
* \@ask4price
*/

global $lang, $_SESSION;
$ask4price_list = $_SESSION['ask4price_list'];
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
 <TR>
  <TD align=center><br /><br />
  <?php print $lang->ask4price_send_error; ?>.<br />
  <?php print $lang->ask4price_send_error_sorry; ?>.<br /><br /> 
  </TD>
 </TR>
  <TR>
  <TD align=right colspan="100%">
   <?php $this->back();?><br /><br />
  </TD>
 </TR>

 <TR>
  <TD width="150" bgcolor="#000000"><IMG src="<?php $this->img("_img/mask.gif");?>" width="1" height="1"></TD>
 </TR>
</TABLE>
</CENTER>
</BODY>
</HTML>
