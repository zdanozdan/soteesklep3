<?php
/**
* Lista rekordow tabeli help_content
* 
* @author  lech@sote.pl
* @version $Id: edit_lang.php,v 1.1 2005/03/14 13:00:33 lechu Exp $
* @package    dictionary
* \@lang
*/

// naglowek php
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
// end naglowek php
global $config,$lang,$config_flags;
include_once ("htdocs/themes/base/base_theme/_flags/config_flags.inc.php");
$current_flag = "<i>" . $lang->dictionary_new_lang_no_file . "</i>";


global $config_flags;

// naglowek
$theme->head_window();
$theme->bar($lang->dictionary_lang_add_bar);

if(empty($_REQUEST['update'])) {
    include_once("./html/edit_lang.html.php");
}

else {
    $message = '';
    if($_REQUEST['action'] == 'add') {
        include_once("./include/add_lang.inc.php");
    }
    if($_REQUEST['action'] == 'edit') {
        include_once("./include/edit_lang.inc.php");
    }
    if ($message == '') {
        echo "
        <script>
        window.opener.location.href='/plugins/_dictionary/configure.php';
        window.close();
        </script>
        ";
    }
    else {
        echo "$message<br>";
        include_once("./html/edit_lang.html.php");
    }
    
}

// stopka
$theme->foot_window();

include_once ("include/foot.inc");
?>