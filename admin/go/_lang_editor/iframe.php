<?php
/**
* Edycja wersji jêzykowych
*
* Domy¶lny skrypt obs³uguj±cy edycjê wersji jêzykowych. Inicjuje obiekt klasy LangEditor,
* za³±cza odpowiednie pliki modu³u i wykonuje jego metody w zale¿no¶ci od obecno¶ci i
* warto¶ci zmiennych przesy³anych z formularza (tablica $_REQUEST).
* @author  lech@sote.pl
* @version $Id: iframe.php,v 1.3 2005/12/23 15:34:36 lechu Exp $
* @package    lang_editor
* \@lang
* \@encoding
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
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

$__part = 'htdocs';

$_REQUEST = unserialize(urldecode($_REQUEST['serialized']));

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
    $editor =& new LangEditor($lang_str, $__part, '', $report_lang);
}
else
    $editor =& new LangEditor($config->base_lang, $__part, '', $report_lang);

require_once("include/gen_config.inc.php"); // klasa s³u¿±ca do generowania zawarto¶ci pliku lang
$generator =& new GenConfig;

$variable_count = 1;
$translate_txt = '';
function showArrayRecursive($array, $text_so_far) {
    global $variable_count, $translate_txt;
    if(!is_array($array)) {
        $r = $variable_count . ". " . $text_so_far . ' : ' . $array . "\n";
        $translate_txt .= '   ' . $variable_count . ". " . $array . "\n";
        $variable_count++;
        return $r;
    }
    else {
        $res = '';
        while (list($key, $val) = each($array)) {
            $res .= showArrayRecursive($val, $text_so_far . "[$key]");
        }
        return $res;
    }
}

if(@$_REQUEST['lang_editor_post'] == 'update'){ // przes³ano formularz edycji zmiennej
    $editor->updateAll($_REQUEST);
    $theme->head_window();    
    include_once("./html/lang_editor_dlg_confirm.html.php");
    $theme->foot_window();
}
else{
    // naglowek
    header('Content-Type: text/html; charset=utf-8');
    $theme->head_window_utf8();    
    
    if(@$_REQUEST['lang_editor_action'] == 'search'){ // przes³ano formularz wyszukiwania zmiennych
        include_once("./include/lang_editor_mainform.php"); // wy¶wietl formularze edycji zmiennych
//        $editor->emptyTrash();
    }
    
    if(!empty($editor->report)) {
        reset($editor->report);
        $report_txt = '';
        
        while (list($lf_path, $lf_variables) = each($editor->report)) {
            $report_txt .= $lf_path . "\n";
            while (list($variable, $value) = each($lf_variables)) {
                if(!is_array($value)) {
                    $report_txt .= '   ' . $variable_count . ". " . $variable . ' : ' . $value . "\n";
                    $translate_txt .= '   ' . $variable_count . ". " . $value . "\n";
                    $variable_count++;
                }
                else {
                    $report_txt .= showArrayRecursive($value, '   ' . $variable);
                }
                $report_txt .= "\n";
            }
            $report_txt .= "\n\n";
        }
        $filepath = $DOCUMENT_ROOT . "/tmp/" . $report_lang . "_report_for_developer.txt";
        $fp = fopen($filepath, 'w');
        fwrite($fp, $report_txt);
        fclose($fp);

        $filepath = $DOCUMENT_ROOT . "/tmp/" . $report_lang . "_report_to_traslate.txt";
        $fp = fopen($filepath, 'w');
        fwrite($fp, $translate_txt);
        fclose($fp);
        echo "<br><a href='../../tmp/" . $report_lang . "_report_for_developer.txt' target='_blank'>RAPORT DLA DEVELOPERA</a><br>";
        echo "<br><a href='../../tmp/" . $report_lang . "_report_to_traslate.txt' target='_blank'>RAPORT DLA T£UMACZA</a>";
        
    }
    $theme->foot_window();
    include_once ("include/foot.inc");
}
?>
