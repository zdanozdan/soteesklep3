<?php
/**
* Instalacja i konfiguracje elementow zwiazanych z instalacja sklepu na serwerach HOME.PL
*
* @author  m@sote.pl
* @version $Id: home.pl.inc.php,v 2.4 2004/12/20 18:01:16 maroslaw Exp $
* @package    setup
*/

print $lang->setup_homepl_info;

// wstaw odpowiednie pliki dostosowane do serwera home.pl
// htdocs/.htaccess
// htdocs/themes/.htaccess
// admin/themes/.htaccess
$ftp->connect("no");
$ftp->delete($config->ftp['ftp_dir']."/htdocs",       ".htaccess");

/*
 * @deprecated 3.0
$ftp->put("$DOCUMENT_ROOT/../config/providers/home.pl/htdocs.htaccess",$config->ftp['ftp_dir']."/htdocs",       ".htaccess");
$ftp->put("$DOCUMENT_ROOT/../config/providers/home.pl/themes.htaccess",$config->ftp['ftp_dir']."/htdocs/themes",".htaccess");
$ftp->put("$DOCUMENT_ROOT/../config/providers/home.pl/themes.htaccess",$config->ftp['ftp_dir']."/admin/themes", ".htaccess");
*/

// lib/.htaccess         -> ten plikm usun
$ftp->delete($config->ftp['ftp_dir']."/lib",          ".htaccess");

// zainstaluj w glwonym katalogu konta plik php.ini
$ftp->put("$DOCUMENT_ROOT/../config/providers/home.pl/php.ini",$config->ftp['ftp_dir']."/../","php.ini");

// zainstaluj odpowiedni plik .htaccess w panelu
$ftp->put("$DOCUMENT_ROOT/../config/providers/home.pl/admin.htaccess",$config->ftp['ftp_dir']."/admin",".htaccess");

$ftp->close();
?>
