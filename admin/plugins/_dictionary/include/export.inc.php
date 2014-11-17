<?php
/**
 * Eksport danych nazw kategorii z tabeli dictionary do pliku config/auto_config/dictionary.inc.php
 *
 * @author  piotrek@sote.pl
 * @version $Id: export.inc.php,v 2.10 2006/01/31 14:02:03 lechu Exp $
* @package    dictionary
* \@lang
 */

if (@$__secure_test!=true) die ("Bledne wywolanie");
global $config;
global $DOCUMENT_ROOT;

// odczytaj bazowe slowo(wordbase) i przetlumaczone(langbase) z tablicy dictionary
// generuj tablice $tab_dictionary_cat zawierajaca wordbase->wordlang dla kazdego jezyka
$tab_dictionary_cat=array();
$tab_languages=array();    
$tab_languages=$config->languages;  //generuj tablice z dostepnymi jezykami

$query="SELECT * FROM dictionary";

$result=$db->Query($query);
if ($result!=0) {
    $num_rows=$db->NumberOfRows($result);
    if ($num_rows>0) {
        $i=0;
        reset($config->langs_symbols);
        while (list($lid, $value) = each($config->langs_symbols)) { //dla kazdego jezyka znajdujacego sie w tabeli $config->langs_symbols
//        foreach($tab_languages as $value) {     //dla kazdego jezyka znajdujacego sie w tabeli $tabl_languages
            $i=0;
            while ($i<$num_rows) {              // kolejne rekordy istniejace w bazie
                $wordbase=$db->Fetchresult($result,$i,"wordbase");
                $clang[$value]=$db->FetchResult($result,$i,$value);
                if ((! empty($wordbase)) && (! empty($clang[$value]))) {
                    $tab_dictionary_cat[$value][$wordbase]=$clang[$value];
                } //end if
                $i++;
            } // end while
        } // end foreach
    } // end if
} else die ($db->Error());

// generuj plik konfiguracyjny PHP - plik slownika z danym jezykiem w zaleznosci od $key_lang
require_once ("include/gen_config.inc.php");
$gen_config = new GenConfig;
$gen_config->auto_ftp=false;    //wylacz automatyczne polaczenie z ftp
global $ftp;

$ftp->connect();  //otworz polaczenie ftp

foreach ($tab_dictionary_cat as $key_lang=>$value) {
    $MY_DOCUMENT_ROOT=ereg_replace("/admin$","",$DOCUMENT_ROOT);         // wycinamy nie potrzebny katalog admin
    
    if (!file_exists("$MY_DOCUMENT_ROOT/htdocs/lang/_$key_lang/lang.inc.php")) {    // sprawdzamy czy istnieje odpowiedni katalog jezykowy
        $ftp->mkdir($config->ftp['ftp_dir'] . "/htdocs/lang/_$key_lang");
    }
    unset($dictionary);
    foreach ($value as $key_wordbase=>$wordlang) {    // przechodzimy cala podtablice dla istniejacego jezyka
        $dictionary[$key_wordbase]=$wordlang;         // zapisujemy do tablicy slowo bazowe wraz z tlumaczeniem    
    } // end foreach
    
    // parametry piku konfiguracyjnego
    $gen_config->config_dir="/htdocs/lang/_".$key_lang;                 // katalog generowanego pliku
    $gen_config->config_file="dictionary_config.inc.php";               // nazwa generowanego pliku 
    $gen_config->classname="DictionaryConfig_".$key_lang;               // nazwa klasy generowanego pliku
    $gen_config->class_object="dictionary";                             // 1) nazwa tworzonego obiektu klasy w/w 
    $gen_config->vars=array("words");                                   // jakie zmienne beda generowane
    $gen_config->config=&$dictionary;                                   // przekaz aktualne wartosci obiektu 1)
    
    // generuj plik konfiguracyjny
    $comm=$gen_config->gen(array("words"=>$dictionary));
    
    // jesli udalo sie wygenrowac plik wyswietl stosowny komunikat
    if ($comm==0) {
        // print "<p><center>$lang->dictionary_export_ok $key_lang</center>";
    }
    //end if
} //end foreach

$__status=$lang->dictionary_export_ok;

$ftp->close(); //zamknij polaczenie ftp

?>
