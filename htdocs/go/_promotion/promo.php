<?php
/**
* Wyswietl plik html z themes/_pl/_html_files
*
* @author  m@sote.pl
* @version $Id: index.php,v 2.11 2006/05/10 10:53:53 lukasz Exp $
* @package    files
*/

$global_database=true;
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
/* Nag³ówek skryptu */
include_once ("../../../include/head.inc");

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

	$theme->theme_file("file_start.html.php");
                        
	$dir="$DOCUMENT_ROOT/photo/_promo/_$config->lang/";
	$html_dir="/photo/_promo/_$config->lang/";

	$dir_contents = scandir($dir);

	print "<table>";
	foreach ($dir_contents as $file) {
	  $file_type = strtolower(end(explode('.', $file)));
	  if ($file_type == 'png' or $file_type == 'jpg') {
	    $path_parts = pathinfo($file);
	    print "<tr><td>";
	    if (file_exists($dir.$path_parts['filename'].'.pdf')) {
	      print "<a href='".$html_dir.$path_parts['filename'].'.pdf'."'><img src=".$html_dir.$file."></img></a>";
	    }
	    else {
	      print "<img src=".$html_dir.$file."></img>";
	    }
	    print "</td></tr>";
	    print "<tr><td><hr></td></tr>";
	  }
	}
	print "</table>";
	$theme->theme_file("file_end.html.php");
            
	return true;
    } // end show_file()
} // end class File

// wyswietl HTML w glownym oknie
$theme->page_open("left","show_file","right","","File","","page_open");

// stopka
//$theme->foot();
//include_once ("include/foot.inc");
?>
