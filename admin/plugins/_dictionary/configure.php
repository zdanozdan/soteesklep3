<?php
/**
* PHP Template:
* Konfiguracja jêzyków
*
* @author krzys@sote.pl
* @version $Id: configure.php,v 2.9 2005/04/15 11:43:33 lechu Exp $
* @package    dictionary
* \@lang
*/

$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

/**
* Obs³uga generowania pliku konfiguracyjnego u¿ytkownika.
*/
require_once("include/gen_user_config.inc.php");

if (! empty($_REQUEST['configure'])) {
    $configure=$_REQUEST['configure'];
}

// naglowek
$theme->head();
$theme->page_open_head();
include_once ("./include/menu.inc.php");

global $config;
// zapisz dane w pliku konfiguracyjnym usera
if (! empty($_REQUEST['update'])) {
    // config
    
    $lang_active=array();
    $currency_lang_default=array();
    $configure["lang_active"]['pl'] = 1;
    $active_count = count(@$configure['lang_active']);

    if(($active_count > 0) && ($active_count <= 5)) {
        for($i = 5; $i < count($config->langs_symbols); $i++) {
            if(!empty($configure["lang_active"][$config->langs_symbols[$i]])) {
                for($j = 1; $j < 5; $j++) {
                    if(empty($configure["lang_active"][$config->langs_symbols[$j]])) {
                        $temp_lang_name = $config->langs_names[$i];
                        $config->langs_names[$i] = $config->langs_names[$j];
                        $config->langs_names[$j] = $temp_lang_name;

                        $temp_lang_symbol = $config->langs_symbols[$i];
                        $config->langs_symbols[$i] = $config->langs_symbols[$j];
                        $config->langs_symbols[$j] = $temp_lang_symbol;
                        $res = $mdbd->select("main_user_id,name_" . $temp_lang_symbol . ",xml_description_" . $temp_lang_symbol . ",xml_short_description_" . $temp_lang_symbol, "main_lang", "1=1", array(), "", "array");
                        // w main w kolumnach L_$j wpisujemy opisy z kolumn $config->langs_symbols[$j]
                        for($k = 0; $k < count($res); $k++) {
                            $uid = $res[$k]['main_user_id'];
                            $query = "UPDATE main SET
                            name_L" . $j . " = '" . addslashes($res[$k]["name_" . $temp_lang_symbol]) . "',
                            xml_description_L" . $j . " = '" . addslashes($res[$k]["xml_description_" . $temp_lang_symbol]) . "',
                            xml_short_description_L" . $j . " = '" . addslashes($res[$k]["xml_short_description_" . $temp_lang_symbol]) . "'
                            WHERE user_id = '$uid'";
//                            echo "<br>[$query]<br>";
    
                            $prepared_query=$db->PrepareQuery($query);
                            if ($prepared_query) {
                                $result1=$db->ExecuteQuery($prepared_query);
                            }
                        }
                        /*
                        $query = "UPDATE main, main_lang SET
                        main.name_L" . $j . " = main_lang.name_" . $temp_lang_symbol . ",
                        main.xml_description_L" . $j . " = main_lang.xml_description_" . $temp_lang_symbol . ",
                        main.xml_short_description_L" . $j . " = main_lang.xml_short_description_" . $temp_lang_symbol . "
                        where main.user_id = main_lang.main_user_id";
                        echo "<br>[$query]<br>";

                        $prepared_query=$db->PrepareQuery($query);
                        if ($prepared_query) {
                            $result1=$db->ExecuteQuery($prepared_query);
                        }
                        */
                    }
                }
            }
        }
    }
    
    $configure['lang_id'] = $configure['lang'];
    $configure['lang'] = $config->langs_symbols[$configure['lang']];

    reset($config->langs_names);
    while (list($l_id, $l_name) = each($config->langs_names)) {
        $la = $config->langs_symbols[$l_id];
        $lang_active[$l_id]=@$configure["lang_active"][$la];
              
        if (empty($configure["lang_active"][$la]))
            $lang_active[$l_id]=0;
        else
            $lang_active[$l_id]=1;

        $currency_lang_default[$la]=@$configure["currency_lang_default_$la"];
     
    }
    
    $ftp->connect();
    if(($active_count > 0) && ($active_count <= 5)) {
        $gen_config->gen(
            array
            (
            "lang"=>$configure['lang'],
            "lang_id"=>$configure['lang_id'],
            "htdocs_lang"=>$configure['lang'],
            "langs_active"=>$lang_active,
            "langs_names"=>$config->langs_names,
            "langs_symbols"=>$config->langs_symbols,
            "currency_lang_default"=>$currency_lang_default,
            )
        );
    }
    else {
        $gen_config->gen(
            array
            (
            "lang"=>$configure['lang'],
            "lang_id"=>$configure['lang_id'],
            "htdocs_lang"=>$configure['lang'],
            "currency_lang_default"=>$currency_lang_default,
            )
        );
    }
    
    $ftp->close();
    $config->lang=$configure['lang'];
    $config->htdocs_lang=$configure['lang'];
    if(($active_count > 0) && ($active_count <= 5)) {
        $config->langs_active=$lang_active;
    }
    $config->currency_lang_default=$currency_lang_default;
    //end config
    if(($active_count < 1) || ($active_count > 5)) {
        $message = $lang->dictionary_invalid_active_lang_count;
    }

    
}


include_once ("./html/configure.html.php");

$theme->page_open_foot();

// stopka
$theme->foot();

include_once ("include/foot.inc");
?>
