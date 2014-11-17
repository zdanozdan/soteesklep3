<?php
/**
* Wyswietl plik html z themes/_pl/_html_files
*
* @author  m@sote.pl
* @version $Id: index.php,v 2.11 2006/05/10 10:53:53 lukasz Exp $
* @package    files
*/

$global_database=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/* Nag³ówek skryptu */
include_once ("../../../include/head.inc");

// naglowek
$theme->head();

/**
* Wy¶iwetlanie odpowiedniego pliku HTML
* @package files
*/
class File {
    
    /**
    * Funckja wyswietla zawrtosc pliku okreslonego w parametrze o ile takowy istnieje
    *
    * \@global string $file - plik znajdujacy sie w katalogu themes/_(lang)/(theme_name)/html_file
    * \@global array $_REQUEST
    * \@global object $config - konfiguracja glowna
    * \@global object $theme - obiekt klasy z tematem
    *
    * @return bool true - uda³o siê poprawnie wy¶wietliæ plik, false w p.w.
    */
    function show_file() {
        global $_REQUEST;
        global $config;
        global $theme;
        global $logs;
        global $DOCUMENT_ROOT;
        
        // odczytaj przekazany(e) parametr(y)
        $file="";
        if (! empty($_REQUEST["file"])) {
            $file=$_REQUEST['file'];
        }
        if (eregi("/",$file)) {
            die ("Forbidden: file");
        }
        
        if (! empty($file)) {
            $theme->theme_file("file_start.html.php");
                        
            $file_path="$DOCUMENT_ROOT/themes/_$config->lang/_html_files/$file";
            if (file_exists($file_path)) {
                $fd=fopen($file_path,"r");
                $data=fread($fd,filesize($file_path));
                print $data;
                fclose($fd);
            }
            
            $theme->theme_file("file_end.html.php");
            
            return true;
        }
        
        return false;
    } // end show_file()
} // end class File

// wyswietl HTML w glownym oknie
$theme->page_open("left","show_file","right","","File","","page_open_2");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
