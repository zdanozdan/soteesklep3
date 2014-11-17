<?php
/**
* Wy¶wietl licencje w ramce.
*
* @author  m@sote.pl
* @version $Id: setup_frame.html.php,v 2.6 2005/04/12 11:10:40 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/
?>
<center><?php print $lang->setup_license;?></center>
<table border="0" width=720 align=center cellspacing=0>
<tr>
  <td>
    <iframe src="<?php print $config->url_prefix;?>/setup/html/<?php print $config->lang;?>_license.html.php" name=license width="720" height="300" scrolling=yes frameborder="1">
    <?php print $lang->setup_errors['no_frame'];?>
	</iframe>
  </td>
</tr>
</table>

<center>
<form action=system.php name=myform>
<?php
global $buttons;
$buttons->perm=false;
$buttons->button($lang->setup_license_accept,"javascript:document.myform.submit();");
$buttons->perm=true;
?>
</form>
</center>
