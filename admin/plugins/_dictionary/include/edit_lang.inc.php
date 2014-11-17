<?php
/**
* \@lang
* \@encoding
*/
$message = '';
$new_lang_name = trim($_REQUEST['lang_name']);
$new_lang_encoding = trim($_REQUEST['lang_encoding']);

if(!isset($_REQUEST['lang_id']) || ($_REQUEST['lang_id'] < 0) || ($_REQUEST['lang_id'] >= count($config->langs_symbols))) {
    $message = "<span style='color: red;'>" . $lang->dictionary_lang_id_invalid. '</span><br>';
}
else {
    $lang_id = trim(@$_REQUEST['lang_id']);
    
    
    if($message == '') {
        if(!preg_match("/^[a-zA-Z]+$/", $new_lang_name)) {
            $message .= "<span style='color: red;'>" . $lang->dictionary_lang_name_invalid . '</span><br>';
        }
    }
    
    
    if($message == '') {
        for($i = 0; $i < count($config->langs_symbols); $i++) {
            if(($new_lang_name == $config->langs_names[$i]) && ($i != $lang_id)) {
                $message .= "<span style='color: red;'>" . $lang->dictionary_lang_name_exists . '</span><br>';
            }
        }
    }
    
    if($message == '') {
        global $config_flags;
        include_once ("htdocs/themes/base/base_theme/_flags/config_flags.inc.php");
        require_once("include/gen_user_config.inc.php");
        $gen_config->auto_ftp=false;
        global $ftp;
        $ftp->connect();
        $config->langs_names[$lang_id] = $new_lang_name;
        $config->langs_encoding[$lang_id] = $new_lang_encoding;
        $gen_config->gen(array(
            "langs_names"=>$config->langs_names,
            "langs_encoding"=>$config->langs_encoding,
            ));
        
        if(is_uploaded_file(@$_FILES['lang_flag']['tmp_name'])) {
            move_uploaded_file($_FILES['lang_flag']['tmp_name'], $DOCUMENT_ROOT . '/tmp/' . $_FILES['lang_flag']['name']);
            $dir_source = $DOCUMENT_ROOT . '/tmp/' . $_FILES['lang_flag']['name'];
            $dir_target = $config->ftp['ftp_dir'] . "/htdocs/themes/base/base_theme/_flags";
            $ftp->put($dir_source, $dir_target, $_FILES['lang_flag']['name']);
            $config_flags->files[$config->langs_symbols[$lang_id]] = $_FILES['lang_flag']['name'];

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
    }
}
?>