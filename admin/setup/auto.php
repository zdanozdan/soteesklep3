<?php
/**
* Automatyczna instalacja sklepu na podstwie danych przes³anych w POST
* 
* @author  m@sote.pl
* @version $Id: auto.php,v 2.8 2004/12/20 18:01:11 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/

if (! empty($_POST['form'])) {
    
    // podstaw dane do POST i sesji
    $form=&$_POST['form'];   
    if (empty($form['license_who'])) {
        $form['license_who']="DEMO";
    }
    if (empty($_POST['ftp_dir'])) {
        $_POST['ftp_dir']="/soteesklep3";
    }
    $_SESSION['config_setup']['type']="simple";
    $_SESSION['config_setup']['os']="linux";
    $_POST['config_setup']=$_SESSION['config_setup'];
    $_SESSION['form']=&$form;    
    
    // instaluj sklep
    require_once ("simple_3.php");
} else {
    die ("Forbidden: Unknown form");   
}

/* Przyklad formularza wywo³ujacego inmstalujacjê sklepu
 * przyklad jest w pliku auto_test.php
 
<pre>
<form action=http://admin.soteesklep2/setup/auto.php method=POST>

form[]
dbhost <input value="localhost" size="20" name="form[dbhost]" type="text">
dbname <input value="soteesklep2" size="20" name="form[dbname]" type="text">
admin_dbuser <input value="" size="20" name="form[admin_dbuser]" type="text">
admin_dbpassword <input value="" size="20" name="form[admin_dbpassword]" type="password">
ftp_host <input value="localhost" size="20" name="form[ftp_host]" type="text">
ftp_user <input value="" size="20" name="form[ftp_user]" type="text">
ftp_password<input value="" size="20" name="form[ftp_password]" type="password">

ftp_dir
<input value="" size="20" name="ftp_dir" type="text">            <!-- opcjonalne, domyslnie /soteesklep2 -->
 
form[]
license <input value="" size="28" name="form[license]" type="text">
license_who <input value="" size="28" name="form[license_who]" type="text">  <!-- opcjonalne-->
pin <input value="" size="20" name="form[pin]" type="password">
pin2 <input value="" size="20" name="form[pin2]" type="password">
<input type=submit value="Instaluj">
</form>
</pre>
*/
?>
