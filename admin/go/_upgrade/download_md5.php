<?php
/**
* ¦ci±gnij ze strony sote.pl, i zainstaluj, plik sum kontrolnych sum.md5 w sklepie.
*
* @author  m@sote.pl
* @version $Id: download_md5.php,v 1.4 2005/01/20 14:59:41 maroslaw Exp $
* @package    upgrade
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php


// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->upgrade_title);

// odczytaj wersje
$file_version="$DOCUMENT_ROOT/../VERSION";
$fd=fopen($file_version,"r");
$version=trim(fread($fd,filesize($file_version)));
fclose($fd);

$remote_file="$version.md5";

/**
* Obs³uga po³±czeñ HTTP
*/
require_once ("HTTP/Client.php");
$http =& new HTTP_Client();
$http->get("http://www.sote.pl/upgrades/sum.md5/$remote_file");
$sum=$http->_responses[0]['body']; // zawarto¶c pliku sum kontrolnych

$tmp_file="$DOCUMENT_ROOT/tmp/sum.md5";
$fd=fopen($tmp_file,"w+");
fwrite($fd,$sum,strlen($sum));
fclose($fd);

/**
* Obs³uga po³±czenia FTP
*/
require_once ("include/ftp.inc.php");
$ftp->connect();
$ftp->put($tmp_file,$config->ftp['ftp_dir'],"sum.md5");
$ftp->close();

print "<p />".$lang->upgrade_md5_installed."<p /><a href=index.php><u>$lang->upgrade_md5_continue</u></a>\n";

/**
* Dodaj uaktualnienie dot. upgrade'u 00005
*/
require_once ("./include/upgrade_00005.inc.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");


?>
