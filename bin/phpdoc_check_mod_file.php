<?php
/**
* Sprawd¼ plik czy zawiera odpowiednie wpisy dot. PHPDOC i CVS
*
* @author  m@sote.pl
* @version $Id: phpdoc_check_mod_file.php,v 1.4 2005/02/21 12:06:47 maroslaw Exp $
* @package bin
*/

error_reporting(1);

if (! empty($_SERVER["argv"][1])) {
    $file=$_SERVER["argv"][1];
} else {
    die ("Unknown file. Try ./phpdoc_check_mod_file.php ./path/file.php");
}

$dir_name=dirname($file);
$file_name=basename($file);

if (file_exists($file)) {
    $fd=fopen($file,"r");
    $data=fread($fd,filesize($file));
    fclose($fd);
} else {
    die ("File not found: $file\n");
}

$pkg_config=array(
"^./admin/include"=>"admin_include",
"^./admin/plugins"=>"admin_plugins",
"^./include"=>"include",
"^./htdocs/themes"=>"themes",
"^./admin/themes"=>"themes",
"^./admin/setup"=>"setup",
);


$add='';$package='default';$subpackage='';
// sprawdz czy jest wpis pacakge
#if ((! ereg("\@package",$data)) || (ereg("package[\s]+soteesklep",$data))) {
// rozpoznaj package na podstawie dir_name

// sprawd¼ czy plik zawiera katalog postaci _nazwa
// je¶li tak, to pierwszy taki katalog w ¶cie¿ce oznacza @package, a ostatni @subpackage
$tab=split("/",$dir_name);
if (sizeof($tab)>0) {
    $pkg_lock=false;
    if (ereg("\/_",$dir_name)) {
        foreach($tab as $subdir) {
            if ((ereg("^_",$subdir)) && ($pkg_lock==false)) {
                $package=preg_replace("/^_/","",$subdir);
                $pkg_lock=true;
            } elseif (ereg("^_",$subdir)) {
                $subpackage=preg_replace("/^_/","",$subdir);
            }
        }
    } else {
        // nie ma katalogu _nazwa w ¶cie¿ce; sprawd¼ czy wyso³ano plik z tematu
        if (ereg("\/themes\/base",$dir_name)) {
            // oczytaj 1podkatalog po base
            reset($tab);$prev_dir='';
            foreach ($tab as $subdir) {
                if ($prev_dir=="base") {
                    $package="themes";
                    $subpackage=$subdir;
                }
                $prev_dir=$subdir;
            }
        } else {
            reset($pkg_config);
            foreach ($pkg_config as $ereg=>$package_name) {
                if (ereg($ereg,$dir_name)) {
                    $package=$package_name;
                }
            }
        }
    }
} else {
    // je¶li nie, to nazwa pakietu jest nazw± katalogu
    $package=basename($dir_name);
}

// tutaj mamy rozpoznany pakiet i sub-pakiet i przystepujemy do podmiany wartosci w zawartosci pliku
// zawarto¶æ pliku jest w $data

/**
* Klasa obs³uguj±ca modyfikacje nag³ówka pliku.
*/
require_once ("../lib/ST/ModFiles.php");

$mod_files =& new ST_ModFiles($data);
$mod_files->setHeadComment(array("package"=>$package,"subpackage"=>$subpackage));
$mod_files->replace(array(' \@session'=>' \\@session',
                          ' \@verified'=>' \\@verified',
                          ' \@global'=>' \\@global',
                          ' \@template_version'=>' \\@template_version',                           
                          ' \@depend'=>' \\@depend',
                          ' \@modified_by'=>' \\@modified_by',
                          )
                    );
$mod_files->show();

?>
