<?php
/**
* Wybór katalogu FTP, w któ?ym jest zainstalowany program.
*
* @author  m@sote.pl
* @version $Id: simple_2.html.php,v 2.6 2004/12/20 18:01:14 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/
?>
<?php $theme->desktop_open();?>
1. <a href=system.php><u><?php print $lang->setup_steps[0];?></u></a> 
2. <?php print $lang->setup_steps[1];?> 
3. <b><u><?php print $lang->setup_steps[2];?></u></b>  
4. <?php print $lang->setup_steps[3];?>  
<?php $theme->desktop_close();?>

<B><?php print $lang->setup_ftp_dir;?></B><P>
<?php print $ftp_dir_error;?>

<form action=simple_2.php method=POST name=MyForm>
<table>
<tr>
  <td valign=top>
    <?php $theme->desktop_open();?>
    <img src=./html/_img/<?php print $config_setup['os'].".gif";?>>
    <?php $theme->desktop_close();?>
  </td>
  <td valign=top>

    <?php
    $cftp->connect($form['ftp_host'],$form['ftp_user'],$form['ftp_password']);
    $cftp->print_ftp_dir();
    $cftp->quit();
    ?>
    <p>

  </td>
</tr>
</table>

<div align=right>
<?php
global $buttons;
$buttons->perm=false;
$buttons->button($lang->next,"javascript:document.MyForm.submit();");
$buttons->perm=true;
?>
</div>

</form>
