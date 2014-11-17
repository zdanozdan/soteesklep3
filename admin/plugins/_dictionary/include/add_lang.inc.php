<?php
/**
* \@lang
* \@encoding
*/
$message = '';
$new_lang_symbol = trim($_REQUEST['lang_symbol']);
$new_lang_name = trim($_REQUEST['lang_name']);
$new_lang_encoding = trim($_REQUEST['lang_encoding']);


if($message == '') {
    if(!preg_match("/^[a-zA-Z]+$/", $new_lang_name)) {
        $message .= "<span style='color: red;'>" . $lang->dictionary_lang_name_invalid . '</span><br>';
    }
}

if($message == '') {
    if((!preg_match("/^[a-z]+$/", $new_lang_symbol)) || (strlen($new_lang_symbol) != 2)) {
        $message .= "<span style='color: red;'>" . $lang->dictionary_lang_symbol_invalid . '</span><br>';
    }
}

if($message == '') {
    for($i = 0; $i < count($config->langs_symbols); $i++) {
        if($new_lang_name == $config->langs_names[$i]) {
            $message .= "<span style='color: red;'>" . $lang->dictionary_lang_name_exists . '</span><br>';
        }
        if($new_lang_symbol == $config->langs_symbols[$i]) {
            $message .= "<span style='color: red;'>" . $lang->dictionary_lang_symbol_exists . '</span><br>';
        }
    }
}

if($message == '') {
    $config->langs_symbols[] = $new_lang_symbol;
    $config->langs_names[] = $new_lang_name;
    $config->langs_active[] = 0;
    $config->langs_encoding[] = $new_lang_encoding;
    global $config_flags;
    include_once("htdocs/themes/base/base_theme/_flags/config_flags.inc.php");
    require_once("include/gen_user_config.inc.php");
    $gen_config->auto_ftp=false;
    global $ftp;
    $ftp->connect();
    $gen_config->gen(array(
                           "langs_symbols"=>$config->langs_symbols,
                           "langs_names"=>$config->langs_names,
                           "langs_active"=>$config->langs_active,
                           "langs_encoding"=>$config->langs_encoding,
                           )
                     );
    
    if(is_uploaded_file(@$_FILES['lang_flag']['tmp_name'])) {
        move_uploaded_file($_FILES['lang_flag']['tmp_name'], $DOCUMENT_ROOT . '/tmp/' . $_FILES['lang_flag']['name']);
        $dir_source = $DOCUMENT_ROOT . '/tmp/' . $_FILES['lang_flag']['name'];
        $dir_target = $config->ftp['ftp_dir'] . "/htdocs/themes/base/base_theme/_flags";
        $ftp->put($dir_source, $dir_target, $_FILES['lang_flag']['name']);
        $config_flags->files[$new_lang_symbol] = $_FILES['lang_flag']['name'];

        $gen_config->config_dir = "/htdocs/themes/base/base_theme/_flags";
        $gen_config->config_file="config_flags.inc.php";               // nazwa generowanego pliku 
        $gen_config->classname="ConfigFlags";               // nazwa klasy generowanego pliku
        $gen_config->class_object="config_flags";                             // 1) nazwa tworzonego obiektu klasy w/w 
        $gen_config->vars=array("files");                                   // jakie zmienne beda generowane
        $gen_config->config=&$config_flags->files;                                   // przekaz aktualne wartosci obiektu 1)
        
        // generuj plik konfiguracyjny
        $comm=$gen_config->gen(array("files"=>$config_flags->files));
    }
    $ftp->close();
    $query = "ALTER TABLE main_lang
                ADD name_" . $new_lang_symbol . " VARCHAR( 255 ) ,
                ADD xml_description_" . $new_lang_symbol . " TEXT,
                ADD xml_short_description_" . $new_lang_symbol . " TEXT;";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $result1=$db->ExecuteQuery($prepared_query);
    }
    
    $query = "ALTER TABLE lang
                ADD md5_" . $new_lang_symbol . " VARCHAR( 35 ) ,
                ADD " . $new_lang_symbol . " TEXT;";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $result2=$db->ExecuteQuery($prepared_query);
    }

    $query = "ALTER TABLE dictionary
                ADD " . $new_lang_symbol . "  VARCHAR( 254 );";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $result3=$db->ExecuteQuery($prepared_query);
    }
}

?>