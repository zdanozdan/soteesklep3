<?php
/**
* Edycja wersji jêzykowych
*
* Domy¶lny skrypt obs³uguj±cy edycjê wersji jêzykowych. Inicjuje obiekt klasy LangEditor,
* za³±cza odpowiednie pliki modu³u i wykonuje jego metody w zale¿no¶ci od obecno¶ci i
* warto¶ci zmiennych przesy³anych z formularza (tablica $_REQUEST).
* @author  lech@sote.pl
* @version $Id: index.php,v 1.21 2005/12/13 12:51:16 lechu Exp $
* @package    lang_editor
* \@lang
* \@encodings
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

include("./include/lang_editor.inc.php"); // Klasa LangEditor
include("lib/ConvertCharset/ConvertCharset.class.php");
$NewEncoding = new ConvertCharset;
global $sess;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

$__part = 'htdocs';

if(!empty($_REQUEST['__part'])) {
    $sess->register('__part', $_REQUEST['__part']);
}

if(!empty($_SESSION['__part']))
    $__part = $_SESSION['__part'];

$report_lang = @$_REQUEST['report_lang'];
if($config->nccp == '0x1388') {
    $lang_str = '';
    $coma = '';
    for($i = 0; $i < count($config->langs_symbols); $i++) {
        if($config->langs_active[$i] == 1) {
            $lang_str .= $coma . $config->langs_symbols[$i];
            $coma = ', ';
        }
    }
    $editor =& new LangEditor($lang_str, $__part);
}
else
    $editor =& new LangEditor($config->base_lang, $__part);

require_once("include/gen_config.inc.php"); // klasa s³u¿±ca do generowania zawarto¶ci pliku lang
$generator =& new GenConfig;


if(@$_REQUEST['lang_editor_post'] == 'update'){ // przes³ano formularz edycji zmiennej
    $editor->updateAll($_REQUEST);
    $theme->head_window();    
    include_once("./html/lang_editor_dlg_confirm.html.php");
    $theme->foot_window();
}
else{
    // naglowek
    $theme->head();
    $theme->page_open_head();
    
    include_once ("plugins/_dictionary/include/menu_top.inc.php");    
    $theme->bar($lang->_lang_editor_title_bar);            // bar

    include_once("./html/lang_editor_searchform.html.php"); // wy¶wietl formularz wyszukiwania zmiennych
    if(@$_REQUEST['lang_editor_action'] == 'search'){ // przes³ano formularz wyszukiwania zmiennych
        $serialized = urlencode(serialize($_REQUEST));
        ?>
        <iframe width="100%" height="300" src="/go/_lang_editor/iframe.php?sess_id=<? echo $sess->id; ?>&serialized=<?php echo $serialized; ?>"></iframe>
        <?php
//        include_once("./include/lang_editor_mainform.php"); // wy¶wietl formularze edycji zmiennych
        $editor->emptyTrash();
    }
    $theme->page_open_foot();
    // stopka
    $theme->foot();
    include_once ("include/foot.inc");
}

global $shop;
if($shop->home == 1){
	// usun zapamietane pliki tymczasowe
	foreach ($__del_files as $id=>$file) {
	    if (file_exists($file))   unlink ($file);
	}
}

?>
