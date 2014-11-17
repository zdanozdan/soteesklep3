<?php
/**
 * Edycja numerów GG.
 * 
 * @author  m@sote.pl
 * @version $Id: index.php,v 1.2 2005/12/13 09:38:27 maroslaw Exp $
 * @package gg
 */

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

/**
* Dodaj obs³ugê FTP
*/
require_once ("include/ftp.inc.php");

define ("GG_MAX_USERS",1000);
define ("GG_MAX_SIZEGG",16);

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->gg_title);
print "<br />\n";

if (! @$_REQUEST['update']) {
    $file_gg=$DOCUMENT_ROOT."/../htdocs/plugins/_gg/config/numbers.txt";
    if (filesize($file_gg)>0) {
        if ($fd=fopen($file_gg,"r")) {
            $gg_data=fread($fd,filesize($file_gg));
            fclose($fd);
        }
    } else $gg_data='';

    // formularz html
    include_once ("./html/gg_config.html.php");

} else {
    $gg=addslashes($_REQUEST['gg']);
    $gg=trim($gg);

    // sprawdz poprawnosc numerow GG
    $dat=split("\n",$gg,GG_MAX_USERS);$gg2='';
    reset($dat);
    foreach ($dat as $key=>$gg_1) {

        $gg_1=trim($gg_1);
        if (ereg("^[0-9]+$",$gg_1)) {
            if (strlen($gg_1)<GG_MAX_SIZEGG) {
                $gg2.=$gg_1."\n";
            }
        }
    }

    $gg=$gg2;

    $file_tmp=$DOCUMENT_ROOT."/tmp/gg.txt";
    if ($fd=fopen($file_tmp,"w+")) {
        fwrite($fd,$gg,strlen($gg));
        fclose($fd);

        $ftp->connect();
        $ftp->put($file_tmp,$config->ftp['ftp_dir']."/htdocs/plugins/_gg/config","numbers.txt");
        $ftp->close();

        print $lang->gg_updated;

    } else die ("Error: I can't open the file $file_tmp");
}

$theme->page_open_foot();
// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
