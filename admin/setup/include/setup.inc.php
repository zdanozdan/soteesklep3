<?php
/**
 * Ustaw odpowiednie sciezki w admin/.htaccess oraz dodaj plik z haslami config/etc/passwd.www
 * Domyslnie wstaw login i haslo dostepu te same co admina do bazy danych
 *   
 * \@global string $__salt losowy kod kodowania - sol
 * 
 * @author  m@sote.pl
 * @version $Id: setup.inc.php,v 2.11 2005/10/27 07:24:57 lukasz Exp $
 *
 * \@verified 2004-03-16 m@sote.pl
* @package    setup
 */
 
// polacz sie z kontem FTP
require_once ("include/ftp.inc.php");
global $ftp;
$ftp = new FTP;
$ftp->ftp_user=$form['ftp_user'];
$ftp->ftp_password=$form['ftp_password'];
$ftp->ftp_host=$form['ftp_host'];
$ftp->ftp_dir=$ftp_dir;
$ftp->connect("no");


// utworz plik z loginem i haslem dostepu do Auth Basic .htaccess
require_once("include/htaccess.inc.php");
$htaccess = new htaccess;
if (! empty($_REQUEST['form']['auth_password'])) {
    $htaccess->gen_passwd($form['admin_dbuser'],$form['auth_password'],"passwd.www");
} else {
    $htaccess->gen_passwd($form['admin_dbuser'],$form['admin_dbpassword'],"passwd.www");
}
$tmp_file="$DOCUMENT_ROOT/setup/tmp/passwd.www";
$ftp->put($tmp_file,$ftp->ftp_dir."/config/etc","passwd.www");
unlink ($tmp_file);

// instaluj standraowy plik .htaccess dla Apache, ale poza instalacja na HOME.PL, gdyz tam jest serwer WWW IdeaWebServer,
// ktory obsluguje inny format plikow .htaccess
if (@$_SESSION['config_setup']['host']!="home.pl") {
    // skopiuj plik i zmien sciezke w admin/.htaccess.dist -> .htaccess
    $htfile="$DOCUMENT_ROOT/.htaccess.dist";
    $fd=fopen($htfile,"r");
    $htaccess=fread($fd,filesize($htfile));
    fclose($fd);
    // zmien sciezke
    $BASE_DOCUMENT_ROOT=preg_replace("/\/admin$/","",$DOCUMENT_ROOT);
    $htaccess=ereg_replace("_DOCUMENT_ROOT_",$BASE_DOCUMENT_ROOT,$htaccess);
    // zapisz zmiany w tymczasowym pliku
    $tmp_file="$DOCUMENT_ROOT/setup/tmp/htaccess.tmp";
    $fd=fopen($tmp_file,"w+");
    fwrite($fd,$htaccess,strlen($htaccess));
    fclose($fd);
    // wstaw nowy plik .htaccess do admina    
    $ftp->put($tmp_file,$ftp->ftp_dir."/admin",".htaccess");         
} else {
    // tu mo¿na wstawiæ opcje dostêpne tylko dla home.pl
}

// zmien nawe katalogu zawierajacego sesje
$sess_dir="$DOCUMENT_ROOT/../sessions/$__salt";
if (! is_dir($sess_dir)) {
    $sess_dir="12345678901234567890123456789012";
} else {
    $sess_dir=$config->salt;
}
$ftp->rename($ftp->ftp_dir."/sessions/",$sess_dir,$__salt);
// end

// usuñ zbêdne pliki tymczasowe
@unlink ("$DOCUMENT_ROOT/setup/tmp/htaccess.tmp");

// zamknij polaczenie FTP
$ftp->close();
?>
