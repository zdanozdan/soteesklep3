<?php
/**
* Formularz do wprowadzania danych FTP, bazy danych, licencji, pin.
*
* @author  m@sote.pl
* @version $id$
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/
?>
<?php $theme->desktop_open();?>
1. <a href=system.php><u><?php print $lang->setup_steps[0];?></u></a>
2. <b><u><?php print $lang->setup_steps[1];?></u></b>
3. <?php print $lang->setup_steps[2];?> 
4. <?php print $lang->setup_steps[3];?> 
<?php $theme->desktop_close();?>


<form action=simple_1.php method=post name=MyForm>
<input type=hidden name=form[check] value=true>

<br>

<center>
<?php $theme->desktop_open(640);?>

<table align=center>
<tr>
  <td valign=top>
    <img src=./html/_img/<?php print $config_setup['os'].".gif";?>>
  </td>
  <td valign=top>
 
    <b><?php print $lang->setup_form_mysql['title'];?></b>
    <table align=center border=0>
    <tr>
      <td>
        <?php print $lang->setup_form_mysql['dbhost'];?></td><td><input type=text name=form[dbhost] size=20 value="<?php $theme->form_val('dbhost');?>"><br>
        <?php $theme->form_error('dbhost'); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php print $lang->setup_form_mysql['dbname'];?></td><td><input type=text name=form[dbname] size=20 value="<?php $theme->form_val('dbname');?>"><br>
        <?php $theme->form_error('dbname'); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php print $lang->setup_form_mysql['dbuser'];?></td><td><input type=text name=form[admin_dbuser] size=20 value="<?php $theme->form_val('admin_dbuser');?>"><br>
        <?php $theme->form_error('admin_dbuser'); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php print $lang->setup_form_mysql['dbpass'];?></td><td><input type=password name=form[admin_dbpassword] size=20 value="<?php $theme->form_val('admin_dbpassword');?>"><br>
        <?php $theme->form_error('admin_dbpassword'); ?>
      </td>
    </tr> 
    </table>

  </td>
  <td valign=top>
    <center><b><?php print $lang->setup_form_ftp['title'];?></b></center>
    <table align=center border=0>
    <tr>
      <td>
        <?php print $lang->setup_form_ftp['ftp_host'];?></td><td><input type=text name=form[ftp_host] size=20 value="<?php $theme->form_val('ftp_host');?>"><br>
        <?php $theme->form_error('ftp_host'); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php print $lang->setup_form_ftp['ftp_user'];?></td><td><input type=text name=form[ftp_user] size=20 value="<?php $theme->form_val('ftp_user');?>"><br>
        <?php $theme->form_error('ftp_user'); ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php print $lang->setup_form_ftp['ftp_password'];?></td><td><input type=password name=form[ftp_password] size=20 value="<?php $theme->form_val('ftp_password');?>"><br> 
       <?php $theme->form_error('ftp_password'); ?>
      </td>
    </tr>
    </table>
   
  </td>
</tr>
</table>
<?php $theme->desktop_close();?>
</center>

<p>

<center>
<?php $theme->desktop_open("640");?>

<center><b><?php print $lang->setup_pin_title;?></b></center>
<table align=center border=0>
<tr>
  <td valign=top align=right>
    <?php print $lang->setup_license_nr;?></td><td valign=top><input type=text name=form[license] size=28 value="<?php $theme->form_val('license');?>"><br>
    <?php $theme->form_error('license'); ?>
  </td>
</tr>
<tr>
  <td valign=top align=right>
    <?php print $lang->setup_license_who;?></td><td valign=top><input type=text name=form[license_who] size=28 value="<?php $theme->form_val('license_who');?>"><br>
    <?php $theme->form_error('license_who'); ?>
  </td>
</tr>
<tr>
  <td valign=top align=right>
    <?php print $lang->setup_pin;?></td><td><input type=password name=form[pin] size=20 value="<?php $theme->form_val('pin');?>"><nobr> </nobr><font color=#1223fe><?php print $lang->setup_pin_info;?></font><br>
<?php $theme->form_error('pin'); ?>
  </td>
</tr>
<tr>
  <td valign=top align=right>
    <?php print $lang->setup_pin2;?></td><td><input type=password name=form[pin2] size=20 value="<?php $theme->form_val('pin2');?>"><br>
    <?php $theme->form_error('pin2'); ?>
  </td>
</tr>
</table>

<?php $theme->desktop_close();?>
</center>

<div align=right>
<?php
global $buttons;
$buttons->perm=false;
$buttons->button($lang->next,"javascript:document.MyForm.submit();");
$buttons->perm=true;
?>
</div>

</form>
