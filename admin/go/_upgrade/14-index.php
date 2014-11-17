<?php
/**
* Upgrade pakietu. Automatyczna aktualizacja programu.
* Strona z formularzem za³±czenia pakietu upgrade oraz odczytanie za³±czonego pliku.
*
* @author m@sote.pl
* @version $Id: index.php,v 1.22 2006/01/10 12:38:56 maroslaw Exp $
* @package    upgrade
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php

/**
* Dodaj obs³ugê sprawdzania wersji bazy danych i sklepu
*/
require_once ("./include/check_version.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();
print "<script>";
include_once ("./html/script.js");
print "</script>";

include_once ("./include/menu.inc.php");
$theme->bar($lang->upgrade_title);

print "<p />\n";

$file_md5="$DOCUMENT_ROOT/../sum.md5";
if (! file_exists($file_md5)) {

    print "<p />$lang->upgrade_nomd5_info <p /> <a href=download_md5.php><u>$lang->upgrade_md5_install</u></a>\n";

    $theme->page_open_foot();
    $theme->foot();
    include_once ("include/foot.inc");
    exit;
}

if (empty($_FILES['upgrade_pkg']['name'])) {

    
    // formularsz html do zaladowania pakietow
    include_once ("./html/upgrade.html.php");

    $upgrade_data=$mdbd->select("id,date_add,name,description,version,filename,status","`upgrade`",1,array(),"ORDER BY id DESC LIMIT 10","ARRAY");

    if (! empty($upgrade_data)) {
        print $lang->upgrade_prev."<p />\n";
        print "<ul>\n";
        foreach ($upgrade_data as $num=>$dat) {
            // print "<pre>";print_r($dat);print "</pre>";
            print "<li>".$dat['date_add']." ".sprintf("%05d",$dat['version'])." ".$dat['name']." ".$dat['description']." ";
            if (! empty($dat['filename'])) {
                print " (".$dat['filename'].") ";
            }

            if ($dat['status']=="Modified") {
                print "<font color=\"red\">$lang->upgrade_modified</font>\n";
            }
            print "</li>\n";
        }
        print "</ul>\n";
    }

} else {

    $file_name=$_FILES['upgrade_pkg']['name'];
    if (! ereg("\.spk\.tar\.gz$",$file_name)) {
        print "<font color=\"red\">$lang->upgrade_error_ext</font>\n";

        // formularsz html do zaladowania pakietow
        include_once ("./html/upgrade.html.php");
    } else {
        require_once ("include/ftp.inc.php");
        $ftp->connect();
        $file_tmp=$_FILES['upgrade_pkg']['tmp_name'];

        print "<p />\n".$lang->upgrade_files_simulation."<p .>\n";
        
        /**
         * Zapamietaj w admin/upgrade pakiet. Rozpakuj upgrade_XXX.spk.gz         
         */
        // zapisz pakiet tar.gz w ./admin/upgrade
        if ($ftp->put($file_tmp,$config->ftp['ftp_dir']."/admin/upgrade/",$file_name)) {
            require_once("Packer/packer.php");
            $packer =& new packer($file_tmp);
            $packer->unpack();

            // print "<pre>";
            // print_r ($packer->filestruct);
            // print "</pre>";

            print "<table cellspacing=\"0\" cellpadding=\"0\">\n";
            foreach ($packer->filestruct as $file_tmp_pk=>$file_path_pk) {
                // analiza poszczególnych plików
                // mo¿na wy¶wietliæ tu jaki¶ komubnikat itp.   
                print "<tr>\n";             
                print "<td>";$theme->point("g");print "</td>";
                
                if (ereg("^./",$file_path_pk)) {
                    $file_path_pk_view=substr($file_path_pk,2,strlen($file_path_pk)-2);
                } else $file_path_pk_view=$file_path_pk;
                
                print "<td>";print "&nbsp;".$file_path_pk_view;print "</td>\n";
                // skasuj pliki z testu instalacji
                if (! ereg(".spk$",$file_tmp_pk)) {         
                    unlink("$DOCUMENT_ROOT/tmp/$file_tmp_pk");
                }
                print "</tr>\n";
            }
            print "</table>\n";
            
            // na koñcu listy jest plik upgrade_XXX.spk i zmienna $file_tmp zawiera ¶eciêzke do tego pliku
            $file_tmp=$DOCUMENT_ROOT."/tmp/".$file_tmp_pk;
            // obetnij .tar.gz
            $file_name=substr($file_name,0,strlen($file_name)-7);
            
            print "<p />\n";
        } else {
            die ($lang->upgrade_error_save_pkg);
        }
        // end

        if ($ftp->put($file_tmp,$config->ftp['ftp_dir']."/admin/upgrade/",$file_name)) {

            print $lang->upgrade_file_uploaded." <b>$file_name</b><p />\n";

            $upgrade_file=$DOCUMENT_ROOT."/upgrade/$file_name";
            require_once ("./include/upgrade.inc.php");
            $upgrade =& new DiffUpgrade($upgrade_file);
            //print "<p />\n".$lang->upgrade_files_list."<p />\n";
            //$upgrade->showListFiles();            
            $result_test=$upgrade->doUpgrade(UPGRADE_SIMULATION);
            $upgrade->showUpgradeInfo();

            // print "<pre>";print_r($upgrade);print "</pre>";

            if ($result_test!=-1) {

                print "<form action=upgrade.php>\n";
                print "<input type=hidden name=upgrade_pkg value=\"$file_name\">\n";
                if ($upgrade->upgrade_status==0) {
                    print "<p />\n";
                    print "<input type=submit value=\"$lang->upgrade_update\">\n";
                } else {
                    if ($result_test>-1) {
                        print "<p /><font color=\"red\">$lang->upgrade_update_not_allowed</font><p />\n";
                        print "<input type=checkbox name=upgrade_hard_install value=1 onclick='ToggleTextarea(this);'><i>$lang->upgrade_hard_install</i>\n";

                        print "
            <div id='d_textarea' name='d_textarea' style='display: none;'>
                <textarea cols=80 rows=8>$lang->upgrade_terms</textarea><br>
                <input type=checkbox name=drugi_checkbox value=1 onclick='ToggleSubmit(this);'>$lang->upgrade_accept
                <br>
            </div>
            <div id='d_submit' name='d_submit' style='display: none;'>
                <input type=submit value='$lang->upgrade_update'>
            </div>
            ";
                    } else {
                        // nie mo¿na aktualizowaæ pakietu, wyst±pi³y konflikty
                    }

                }
                print "</form>";
                print "<p />\n";
                $upgrade->legend();

            } // end if ($result_test!=-1)
        } // end if (ftp_put(...)
        else {
            // nie uda³o siê za³±czyæ aktualizacji
        }

        $ftp->close();
    }

    // tmp: debug info
    // $upgrade->showReportUpgradeDB();
}


// usuñ pliki konfiguracyjne pakietu instalacyjnego
require_once ("include/ftp.inc.php");
$ftp->connect();

if (file_exists($DOCUMENT_ROOT."/../000-upgrade_config.php")) {
    $ftp->delete($config->ftp['ftp_dir'],"000-upgrade_config.php");
}
if (file_exists($DOCUMENT_ROOT."/../-1-000-upgrade_config.php")) {
    $ftp->delete($config->ftp['ftp_dir'],"-1-000-upgrade_config.php");
}
$ftp->close();

// dodaj menu upgrade'ow z wersji 2.5->3.0
include_once ("./include/upgrade_menu_25.inc.php");

$theme->page_open_foot();

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
