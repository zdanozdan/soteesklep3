<?php
/**
 * Formularz edycji pliku tekstowego
 *
 * @author      m@sote.pl
 * \@modified_by piotrek@sote.pl
 * @version     $Id: edit_text.php,v 2.8 2005/01/20 14:59:40 maroslaw Exp $
* @package    text
 */

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");

if (! empty($_REQUEST['file'])) {
    $file=basename($_REQUEST['file']);
} elseif (($config->devel==1) && (! empty($_REQUEST['filedev']))) {
    $filedev=$_REQUEST['filedev'];
} else die  ("Forbidden");

if (! empty($_REQUEST['update'])) {
    $update=$_REQUEST['update'];
} else $update=false;

// sprawdzaj tylko dla edycji textow, a nie dla edycji plikow devel
if (($config->devel!=1) && (! empty($filedev))) {
    // plik tekstowy
    if (! empty($_REQUEST['file_name'])) {
        $file_name=$_REQUEST['file_name'];
    } else {
        die ("Bledne wywolanie");
    }
    
    if (! empty($_REQUEST['lang_name'])) {
        $lang_name=$_REQUEST['lang_name'];
    } else {
        die ("Bledne wywolanie");
    }
  
    $file_dir="htdocs/themes/_$lang_name/_html_files"; // sciezka od glownego katalogu sklepu, dla ftp
    $file_path="$DOCUMENT_ROOT/../htdocs/themes/_$lang_name/_html_files/$file";
} else {
    // plik devel
    $file_name=$filedev;
    $file_dir=dirname($filedev);
    $file_path=$DOCUMENT_ROOT."/".$file_dir."/lang.inc.php";
}

$theme->head_window();
$theme->bar($lang->edit." $file_name");
print "<BR>";
$theme->desktop_open();

if ($update==true) {
    include_once("./include/update_file.inc.php");
}

$fd=fopen($file_path,"r");
$file_source=fread($fd,filesize($file_path));
fclose($fd);

if (($config->devel!=1) && (! empty($filedev))) {
    // obetnij 1 wiersz $file_source
    $lines=preg_split("/\n/",$file_source,10000);
    reset($lines);$new_file_source="";
    for ($i=0;$i<sizeof($lines);$i++) {
        if ($i==0) $first_line=$lines[0];
        else $new_file_source.=$lines[$i];
    }
    
    // odczytaj tytul z 1 lini jesli istnieje; odczytaj z kodu:   $this->bar("Kontakt lub inny tekst");
    if (ereg("\<\?php",$first_line)) {
        preg_match("/\<\?php (.)this->bar\(\"(.+)\"\);\?\>/",$first_line,$matches);
    } else {
        $new_file_source=$first_line."\n".$new_file_source;
    }
    
    if (! @empty($matches[2])) $title=$matches[2]; 
    else $title="";
} else  $new_file_source=$file_source;

require_once ("./include/parse_php.inc.php");
$parse_php = new SecureParsePHP;
$file_source=$parse_php->clean($new_file_source); // usun znaczniki PHP

include_once ("./html/edit_file.html.php");

$theme->desktop_close();

$theme->foot_window();

include_once ("include/foot.inc");
?>
