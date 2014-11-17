<?php
/**
 * Zaktulizuj plik tekstowy wprowadzny przez uzytkownika lub plik devel
 * 
 * \@global string $filedev nazwa pliku devel - nazwa uzywana do identyfikacja jaka opcja edycji jest wywolana user/devel
 *
 * @author  m@sote.pl
 * @version $Id: update_file.inc.php,v 2.6 2004/12/20 17:59:08 maroslaw Exp $
* @package    text
 */

if (! @empty($_REQUEST['file_source'])) {
    $file_source=$_REQUEST['file_source'];
} else $file_source=" ";

if (! @empty($_REQUEST['title'])) {
    $title=$_REQUEST['title'];
} else $title="";

// sprawdzaj tylko dla edycji textow, a nie dla edycji plikow devel
if (($config->devel!=1) && (! empty($filedev))) {
    require_once ("./include/parse_php.inc.php");
    $parse_php = new SecureParsePHP;
    $file_source=$parse_php->clean($file_source); // usun znaczniki PH

    // jesli jest podany tytul do dodaj kod PHP wyswietlajacy "bar" z tytulem
    if (! empty($title)) {
        $title_file_source="<?php \$this->bar(\"".$title."\")?>\n".$file_source;
    } else $title_file_source=$file_source;
} else {
    $title_file_source="<?php\n$file_source\n?>";
    $file=basename($filedev);
    $file_dir="admin/".dirname($filedev);
}

// zapisz do tmp plik 
$tmp_file="$DOCUMENT_ROOT/tmp/$file";
$fd=fopen($tmp_file,"w+");
fwrite($fd,$title_file_source,strlen($title_file_source));
fclose($fd);

// nadaj prawa plikowi tymczasowemu 666
chmod ($tmp_file, 0666);

$ftp->connect();
$ftp_dir=$config->ftp_dir."/".$file_dir;
if (($ftp->put($tmp_file,$ftp_dir,$file))==0){
    print $lang->file_ok;
} else print $lang->file_error; 

$ftp->close();

// usun plik tymczasowy
unlink($tmp_file);
?>
