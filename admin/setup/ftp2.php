<?php
/**
 * Aktualizacja hasla FTP, zweryfikuj dane i zapisz w pliku konfiguracyjnym
 *
 * @author  m@sote.pl
 * @version $Id: ftp2.php,v 2.4 2005/01/20 15:00:13 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    setup
 */
$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../include/head.inc");

if (! empty($_REQUEST['password'])) {
    $password=$_REQUEST['password'];
    if (! empty($_SESSION['__pin'])) {
        $pin=$_SESSION['__pin'];   
    } else die ("Forbidden: Unknown PIN");
} else {
    include ("ftp.php");
    exit;   
}

// naglowek
$theme->head();
$theme->page_open_head();

$theme->bar($lang->setup_ftp_change);

// generuj nowa tablice konfiguracyjna FTP, pdomien haslo
require_once ("include/my_crypt.inc");
$secure_key=md5($config->salt.$pin);
$my_crypt = new MyCrypt;
$config->ftp['ftp_password']=$my_crypt->endecrypt($secure_key,$password);

// obsluga generowania pliku konfiguracyjnego uzytkwonika
require_once("include/gen_user_config.inc.php");
$gen_config->ftp_password=$password;
$gen_config->gen(array("ftp"=>$config->ftp));

print "<p>\n";
include_once ("./html/ftp2.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
