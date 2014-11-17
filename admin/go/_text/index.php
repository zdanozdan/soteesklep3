<?php
/**
 * Wyswietlanie plikow z katalogu _html_files w zaleznosci od wybranego jezyka
 *
 * @author m@sote.pl
 * \@modified_by piotrek@sote.pl
 * @version $Id: index.php,v 2.10 2005/01/20 14:59:40 maroslaw Exp $
 * Zmiana tekstow w sklepie. Zarzadzanie plikami html - uwzglednienie dodatkowych jezykow
* @package    text
 */


$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("include/ftp.inc.php");
include_once ("include/forms.inc.php");
$forms = new Forms;

// naglowek
$theme->head();
$theme->page_open_head();

include("./html/lang_file.html.php");    // wyswietlaj pliki z html_files w zaleznosci od wybranego jezyka

include_once ("./include/menu.inc.php"); // menu 
$theme->bar($lang->text_bar);            // bar 

$theme->choose_lang("index.php");        // wybor jezyka

require_once ("./include/edit_text.inc.php");
$etext = new EditText;
$etext->files($files,$my_lang);

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
