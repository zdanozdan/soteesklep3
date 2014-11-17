<?php
/**
 * PHP Template:
 * Wyswietlanie plikow z katalogu _html_files w zaleznosci od wybranego jezyka
 *
 * @author      piotrek@sote.pl 
 * \@modified_by m@sote.pl
 *              2003/08/03 - zmiana wywolanie listy rozwijanej z wyborem jezyka, usuniecie generowania $my_data              
 *                           tablica zostala zastapiona przez $config->languages_names i $config->languages
 *
 * @version $Id: lang_file.html.php,v 2.4 2004/12/20 17:59:07 maroslaw Exp $
* @package    text
 */

global $config;

$language=$config->lang;

// sprawdzenie czy istnieje zmienna $_REQUEST['item']['lang'] rowniez gdy = 0 !
if(ereg("[0-9]$",@$_REQUEST['item']['lang'])) {
    $check=1;
} else $check=0;

$data=$config->languages;              // tablica dostepnych jezykow z pliku config
$files=array();                        // deklaracja tablicy z plikami
$MY_DOCUMENT_ROOT=ereg_replace("/admin$","",$DOCUMENT_ROOT);   

#// przypisanie do tablicy my_data tylko takich jezykow, ktore maja rowniez swoje pliki w  html_files
#$i=0;
#foreach($data as $key=>$value) {
#    $file_check = "$MY_DOCUMENT_ROOT/htdocs/themes/_$value/_html_files/.info.php";
#    if (file_exists($file_check)) {
#        $my_data[$i++]=$value;
#    }
#}
#
#// przyporzadkowanie odpowiedniego jezyka : jesli nie ma requesta to bierzemy jezyk z configa
#// w przeciwnym wypadku ten wybrany z select'a
#if((! empty($_REQUEST['item']['lang'])) || ($check==1)) {
#    $id_lang=$_REQUEST['item']['lang'];
#} else {
#    foreach($my_data as $key=>$value) {
#        if($language==$value) {
#            $id_lang=$key;
#        }
#    }
#}

// przypisanie nazwy jezyka
#$my_lang=$my_data[$id_lang];

global $_REQUEST;
if (! empty($_REQUEST['item']['lang'])) {
    $my_lang=$_REQUEST['item']['lang'];
    if (! in_array($my_lang,$config->languages)) {
        $my_lang=$config->base_lang;
    }
} else $my_lang=$config->lang;

$html_dir="$MY_DOCUMENT_ROOT/htdocs/themes/_$my_lang/_html_files/";
if (! file_exists($html_dir)) {
    // zaloz katalogi i pliki jezykowe
    $__lang=$my_lang;
    include_once ("./include/new_lang_files.inc.php");    
}
$d = dir($html_dir);   // katalog w ktorym znajduja sie pliki html

// odczytanie listy plikow z odpowiedniego katalogu
while (false !== ($entry = $d->read())) {
    if (($entry!=".") && ($entry!="..")) {
        array_push($files,$entry);
    }
}

// przypisanie do odpowiedniego pliku odpowiedniej nazwy
$info_dir="$MY_DOCUMENT_ROOT/htdocs/themes/_$my_lang/_html_files/.info.php";
include("$info_dir");  // includowanie zewnetrznego piku z przetlumaczona nazwa pliku dla danego jezyka 

$my_files=array();   

// tworzenie nowej tablicy, ktora bedzie miala taka strukture np. Strona glowna=>main_page.html
foreach ($files as $key=>$value) {
    foreach ($__html_files_names as $key1=>$value1) {
        if($value==$key1) {
            $my_files[$value1]=$key1;
        }
    }
}

$files=$my_files;    
$d->close();

?>
