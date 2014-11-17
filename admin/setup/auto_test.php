<?php
/**
* Przyk³adowy formularz do testów automatycznej instalacji sklepu. Wywo³anie auto.php
*
* @author  m@sote.pl
* @version $Id: auto_test.php,v 2.7 2004/12/20 18:01:11 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    setup
*/
?>
<pre>
<form action=auto.php method=POST>

form[]
dbhost <input value="localhost" size="20" name="form[dbhost]" type="text">
dbname <input value="soteesklep2" size="20" name="form[dbname]" type="text">
admin_dbuser <input value="" size="20" name="form[admin_dbuser]" type="text">
admin_dbpassword <input value="" size="20" name="form[admin_dbpassword]" type="password">
ftp_host <input value="localhost" size="20" name="form[ftp_host]" type="text">
ftp_user <input value="" size="20" name="form[ftp_user]" type="text">
ftp_password<input value="" size="20" name="form[ftp_password]" type="password">

ftp_dir
<input value="" size="20" name="ftp_dir" type="text">            opcjonale (domyslnie /soteesklep2)
 
form[]
license <input value="" size="28" name="form[license]" type="text">
license_who <input value="" size="28" name="form[license_who]" type="text"> opcjonalne
pin <input value="" size="20" name="form[pin]" type="password">
pin2 <input value="" size="20" name="form[pin2]" type="password">
haslo do panelu <input value="" size=20 name="form[auth_password]" type="text">

<input type=submit value="Instaluj">
</form>
</pre>
