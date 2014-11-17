<?php
/**
 * Zakoduj haslo w dodatkowym pliku sesji w sessions_secure
 * 
 * @author  m@sote.pl
 * @version $Id: save_auth_session.inc.php,v 2.6 2005/02/01 12:56:57 maroslaw Exp $
 * @package soteesklep
 */

if (@$__secure_test!=true) die ("Bledne wywolanie");
require_once ("include/my_crypt.inc");

$key=$config->salt;
$secure_pin=$my_crypt->endecrypt($key,$__pin,"");

if (! empty($_SESSION['__perm'])) {
    $serial_perm=serialize($_SESSION['__perm']);
} else $serial_perm='';

$php="<?php
\$__crypt_pin='$secure_pin';
\$__perm='$serial_perm';
?>
";

//print $DOCUMENT_ROOT;
// zapisz haslo w pliku
$fd=fopen("$DOCUMENT_ROOT/../sessions_secure/".$sess->id.".php","w+");
fwrite($fd,$php,strlen($php));
fclose($fd);

?>
