<?php
/**
* Konfiguracja parametrów zwi±zanych z google
*
* @author m@sote.pl
* @version $Id: config.php,v 1.1 2005/08/02 10:37:22 maroslaw Exp $
* @package    google
*/
$global_database=true;$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

/**
* Nag³ówek skryptu.
*/
require_once ("../../../include/head.inc");

/**
* Lista przegl±darek, dla których nie jest wy¶wietlana wersja google
*/
$_DISALLOW_AGENTS=array("Opera","Safari","MSIE","Mozilla");

/**
* Odczytaj konfiguracje google
*/
include_once ("config/auto_config/google_config.inc.php");

// naglowek
$theme->head();
$theme->page_open_head();

include_once ("./include/menu.inc.php");
$theme->bar($lang->google_config_title);

/**
* Konwertuj tablicê postaci array("nazwa1","nazwa2",..) na "nazwa1, nazwa2, ..."
*
* @param tab array
* @return string
*/
function convertArray2Sstring($tab=array()) {
    reset($tab);$o='';
    foreach ($tab as $key=>$val) {
        $o.=$val.", ";
    }
    $o=substr($o,0,strlen($o)-2); // obetnij znaki ", " na koncu
    return $o;
} // end convertArray2Sstring()


/*
* Zamien format z "nazwa1, nazwa2, .." => array("nazwa1","nazwa2", ....)
*
* @param string
* @return array
*/
function convertString2Array($data) {
    $data=trim($data);
    $tab=split(",",$data,100);$o=array();
    foreach ($tab as $key=>$val) {
        $o[]=trim($val);
    }
    return $o;
} // end convertString2Array()

if (! empty($_REQUEST['item'])) {
    $item=$_REQUEST['item'];
    reset($item);$sentences=array();
    foreach ($item as $key=>$val) {
        if (ereg("keywords_",$key)) {
            $tab=split("_",$key,2);
            $id=$tab[1];
            if (ereg("^[0-9]+$",$id)) {
                $sentences[$id]=$val;
            }
        }
    }
} else {
    $item=array();
    $item['http_user_agents']=$google_config->http_user_agents;
    $item['keywords']=$google_config->keywords;

    $item['http_user_agents']=convertArray2Sstring($item['http_user_agents']);
    $item['keywords']=convertArray2Sstring($item['keywords']);

    $item['title']=$google_config->title;
    $item['description']=$google_config->description;

    reset($google_config->sentences);
    foreach ($google_config->sentences  as $id=>$sentence) {
        $item["keywords_$id"]=$sentence;
    }
    $item['logo']=$google_config->logo;
    $item['keyword_plain']=$google_config->keyword_plain;
}

// generuj plik konfiguracyjny z ustawieniami w ./config/config.inc.php
if (! empty($_REQUEST['update'])) {
    
    require_once ("./include/local_gen_config.inc.php");

    $data=convertString2Array($item['http_user_agents']);

    // pomiñ niedozwolone wpisy user_agents
    reset($data);$data2=array();
    foreach ($data as $key=>$val) {
        $_is=false;
        foreach ($_DISALLOW_AGENTS as $id=>$agent_dis) {
            if (ereg($agent_dis,$val)) {
                $_is=true;
            }
        }
        if (! $_is){
            $data2[$key]=$val;
        } else {
            print "<font color=\"red\">$lang->google_user_agent_error: $val <br />\n";
        }
    } // end foreach
    $data=$data2;
    // end

    // ogranicz tekst do 128 znaków, obetnij HTMLe
    require_once ("SDConvertText/class.SDConvertText.php");
    $sdc =& new SDConvertText();
    $item['description']=$sdc->dropHTML($item['description'],'');
    $item['description']=$sdc->shortText($item['description'],128);
    $item['description']=preg_replace("/[\s]+/"," ",$item['description']);

    $data_keywords=convertString2Array($item['keywords']);

    /**
    * Za³±cz pliki
    */
    include_once ("./include/upload_files.inc.php");

    if (! eregi("^[ a-z0-9_]+$",$item['keyword_plain'])) {
        print "<font color=red>$lang->google_error_keyword_plain</font><p />\n";

        $comm=$gen_config->gen(array("http_user_agents"=>$data,"keywords"=>$data_keywords,"sentences"=>$sentences,
        "title"=>$item['title'],"description"=>$item['description'],"logo"=>@$__logo));
    } else {
        $comm=$gen_config->gen(array("http_user_agents"=>$data,"keywords"=>$data_keywords,"sentences"=>$sentences,
        "title"=>$item['title'],"description"=>$item['description'],"logo"=>@$__logo,"keyword_plain"=>$item['keyword_plain']));
    }

    $google_config->http_user_agents=$data;
    $google_config->keywords=$data_keywords;
    $google_config->logo=@$__logo;
    $google_config->keyword_plain=$item['keyword_plain'];
    
    print "<br /><a href=\"index.php\"><b><u>$lang->google_go2gen</u></b></a><br />\n";
    
}
// end

// wyswietl formularz
print "<br />\n".$lang->google_welcome."<p />\n";
include_once ("./html/config.html.php");

$theme->page_open_foot();
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
