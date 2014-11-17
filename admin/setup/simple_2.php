<?php
/**
 * Wybierz katalog FTP, w ktorym zainstalowany jest sklep
 * 
 * @author  m@sote.pl
 * @version $Id: simple_2.php,v 2.9 2005/01/20 15:00:14 maroslaw Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    setup
 */

$global_database=false;
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}
require_once ("../../include/head.inc");
require_once ("./include/read_ftp.inc.php");

$cftp = new FTPClient;

if (! empty($_POST['form'])) {
    $form=$_POST['form'];    
    $form['license']=trim($form['license']);
    // zapisz w sesji dane z formularza
    $sess->register("form",$form);
} elseif (! empty($_SESSION['form'])) {
    $form=$_SESSION['form'];
} else die ("Forbidden: Unknown form");

if (! empty($_SESSION['config_setup'])) {
    $config_setup=$_SESSION['config_setup'];
}

// naglowek
include_once ("themes/base/base_theme/head_setup.html.php");

if (! empty($_POST['ftp_dir2'])) $_POST['ftp_dir']=$_POST['ftp_dir2'];

// sprawdz czy wybrany katalog, jest katalogiem sklepu
$ftp_dir_error='';
if (! empty($_POST['ftp_dir'])) {
    $ftp_dir=$_POST['ftp_dir'];
    $cftp->connect($form['ftp_host'],$form['ftp_user'],$form['ftp_password']);
    if ($cftp->is_soteesklep($ftp_dir)) {
        $cftp->quit();        
        include_once ("./simple_3.php");       
        exit;
    } else {
        $ftp_dir_error="<font color=red>$lang->setup_ftp_dir_error: <b>$ftp_dir</b></font><br>\n";
    }
    $cftp->quit();
} else {
    // jest to pierwsze wywolanie skryptu, pokaz liste katalogow, zmienna ftp_dir nie jest ustawiona
}

include_once ("./html/simple_2.html.php");

include_once ("themes/base/base_theme/foot_setup.html.php");
print "</form>";
// stopka
include_once ("include/foot.inc");
?>
