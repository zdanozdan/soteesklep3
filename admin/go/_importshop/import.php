<?php
/**
 * Import danych z zewnêtrznego programu.
 *
 * @author  m@sote.pl
 * @version $Id: import.php,v 1.4 2005/06/16 09:48:16 maroslaw Exp $
 * @package   importshop
 */

$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../include/head_stream.inc.php");

// naglowek
$theme->head_window();
$theme->bar($lang->importshop_import_title);

// obsluga streamingu -> status bar
require_once ("themes/stream.inc.php");
$stream = new StreamTheme;
$stream->title_500(); // wyswietl pasek z numerami 100,200,300,400,500

require_once ("./include/importshop_main.inc.php");
$dir=dirname(__FILE__);
$class_file=$_REQUEST['item']['type'].".inc.php";
$file_class="$dir/include/class/$class_file";
if (file_exists($file_class)) {
    /**
    * Obs³uga importu ze wskazanego oprogramowania
    */                    
    require_once ("./include/class/$class_file");
    $isoft =& new $__import_class();
    $isoft->goImport();    
    print "<p /><b>$lang->importshop_congratulation</b><p />\n";
    print "<center><form><input type=button onClick=\"window.close();\" value=\"$lang->close\"></form></center>\n";
} else {
    die ("Unknown class ./include/class/$class_file");
}


// stopka
$theme->foot_window();
include_once ("include/foot.inc");
?>
