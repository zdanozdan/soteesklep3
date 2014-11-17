<?php
/**
* Wykonanie aktualizacji wg za³±czonego pakietu.
*
* @author  m@sote.pl
* @version $Id: upgrade.php,v 1.15 2006/08/16 10:21:22 lukasz Exp $
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

print "<p />\n";
require_once ("include/upgrade.inc.php");

if (! empty($_REQUEST['upgrade_pkg'])) {
    $file=$_REQUEST['upgrade_pkg'];
    $file=ereg_replace("\.\.","",$file);
    $file=$DOCUMENT_ROOT."/upgrade/".$file;

    // odczytaj pakiet tar.gz
    $file_tgz=$file.".tar.gz";
    require_once("Packer/packer.php");
    $packer =& new packer($file_tgz);
    $packer->unpack();

    // print "<pre>";
    // print_r($packer->filestruct);
    // print "</pre>";


    print $lang->upgrade_files." (<b>".basename($file)."</b>):<p />";

    $ftp->connect();

    print "<table cellspacing=\"0\" cellpadding=\"0\">\n";
    foreach ($packer->filestruct as $file_tmp_pk=>$file_path_pk) {
        if (! ereg(".spk$",$file_tmp_pk)) {

            // zainstaluj plik
            $file_path_1=$DOCUMENT_ROOT."/tmp/$file_tmp_pk";
            $file_name_1=basename($file_path_pk);$l_file_name=strlen($file_name_1);
            $file_dir=substr($file_path_pk,0,strlen($file_path_pk)-$l_file_name-1);
            $file_dir_1=substr($file_dir,strlen("./soteesklep3/"),strlen($file_dir)-strlen("./soteesklep3/"));

            if (ereg("^./",$file_path_pk)) {
                $file_path_pk_view=substr($file_path_pk,2,strlen($file_path_pk)-2);
            } else $file_path_pk_view=$file_path_pk;


            if ($ftp->put($file_path_1,$config->ftp['ftp_dir']."/".$file_dir_1,$file_name_1)) {

                // print "FTP:local=$file_path_1 ".$config->ftp['ftp_dir']."/".$file_dir_1." $file_name_1 <br />\n";
                // analiza poszczególnych plików
                // mo¿na wy¶wietliæ tu jaki¶ komubnikat itp.
                print "<tr>\n";
                print "<td>";$theme->point("g");print "</td>";


                print "<td>";print "&nbsp;".$file_path_pk_view;print "</td>\n";
                print "</tr>\n";
            } else {
                // nie uda³o siê zainstalowac pliku graficznego
                print "<tr>\n";
                print "<td>";$theme->point("black");print "</td>";

                print "<td>";print "&nbsp;".$file_path_pk_view;print "</td>\n";
                print "</tr>\n";
            }

            unlink("$DOCUMENT_ROOT/tmp/$file_tmp_pk");
        } else {
            $spk_file=$DOCUMENT_ROOT."/tmp/$file_tmp_pk";
        }
    }
    print "</table>\n";
}
// end


if (file_exists($file)) {
    $upgrade =& new DiffUpgrade($file);

    if ($upgrade->doUpgrade()) {
        $upgrade_status=$upgrade->showUpgradeInfo(UPGRADE_INSTALL_AUTO_MODE);

        $ver=$mdbd->select("version","`upgrade`","version=?",array($upgrade->getVersion()=>"text"),"LIMIT 1");
        if (empty($ver)) {


            // sprawd¼, czy dla danej sesji i dla danego pakietu s± jakie¶ po³±czone zmiany
            $mod=$mdbd->select("id","upgrade_files","session_id=? AND pkg_number=?",
            array($sess->id=>"text",$upgrade->getVersion()=>"int"),"LIMIT 1");

            if ($mod>0) {
                // wykryto modyfikacje, zapisz pakiet jako zmieniony
                $modifications='Modified';
            } else {
                $modifications='OK';
            }

            // print "<pre>";print_r($mod);print "</pre>";

            $mdbd->insert("`upgrade`","date_add,version,filename,status","?,?,?,?",
            array
            (
            "1,".date("Y-m-d")=>"text",
            "2,".$upgrade->getVersion()=>"text",
            "3,".basename($file)=>"text",
            "4,".$modifications=>"text",
            ));



            /**
            * Za³aduj modyfikacje bazy SQL (lub nowe tabele itp.)
            */
            $version_upgrade=$upgrade->getVersion();
            $version_pkg=$version_upgrade;
            require_once ("./include/upgrade_database.inc.php");

            /**
            * Za³aduj plik konfiguracyjny pakietu i wykonaj procedury jego obs³ugi. 
            */
            require_once ("./include/upgrade_conf.inc.php");

            /**
            * Dodaj wykoanie skryptu po za³adowaniu patcha ./soteesklep3/exe/$ver.php
            */
            @include_once ("exe/$ver.php");
        
            // usuñ pliki SQL i PHP (exe) oraz pakiet
            $file_sql=$DOCUMENT_ROOT."/../sql/upgrade_".$version_upgrade.".mysql";            
            $file_php=$DOCUMENT_ROOT."/../exe/$version_upgrade.php";
           
            $ftp->connect();             
            
            if (file_exists($file_sql)) {
                // print "<br>file_sql=$file_sql";
                $ftp->delete($config->ftp['ftp_dir']."/sql/","upgrade_".$version_upgrade.".mysql");
            }
            if (file_exists($file_php)) {                                
                //print "<br>file_php=$file_php";                
                $ftp->delete($config->ftp['ftp_dir']."/exe/",$version_upgrade.".php");
            }
            // usuñ plik pakietu spk
            unlink($spk_file);
            // end
            
        } // end if (empty($ver))

        print "<p /><b>$lang->upgrade_done</b><p />\n";

    } // end if ($upgrade->doUpgrade())

} // if file_exists($file))

$ftp->close();

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
