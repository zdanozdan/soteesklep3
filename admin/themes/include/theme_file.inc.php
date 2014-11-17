<?php
/**
 * Odczytaj plik z biezacego tematu, tematu glwonego, albo bazowego
 * Ten kawalek kodu nie moze byc wstaiony w funkcje ze wzgledu na wymagany dostep do zmiennych gloabalnych
 * defuniowanych w fukcjach odwolujacych sie do tego pliku
 *
 * @param string $file nazwa odczytywanego pliku
 * @param bool $include_once [true|false] true - plik ladowany jest tylko raz przez include_once
 * @return wyswietlenie pliku z jednego z tamatow
* @version    $Id: theme_file.inc.php,v 1.2 2004/12/20 18:01:27 maroslaw Exp $
* @package    themes
 */

global $lang;
global $time;
global $DOCUMENT_ROOT;
global $buttons;
global $config;

require_once ("include/check_perm.inc.php");     // klasa obslugi uprawnien dostepu do katalogow/modulow

//$time->start($file." ".@$text);

// nie zezwalaj na wywolania plikow z wyzszych katalogow
$file=ereg_replace("\.\.","",$file);

//temat bazowy
$base_theme=$config->admin_base_theme;

// sprawdz czy jest plik w zdefiniowanym temacie (katalog jezykowy) np. themes/_pl/redball/head.html.php
$inode=@fileinode($config->theme_dir."/$file");

if ($inode>0) {
     $include_function($config->admin_theme_dir."/$file");    
} else {

    // sprawdzam czy plik jest w katlogu base tematu zdefiniowanego np. themes/base/redball/head.html.php
    $inode2=@fileinode("$DOCUMENT_ROOT/themes/base/$config->admin_theme/$file");
    if ($inode2>0) {        
        if (! empty($include_once)) include_once("$DOCUMENT_ROOT/themes/base/$config->admin_theme/$file");
        else include("$DOCUMENT_ROOT/themes/base/$config->admin_theme/$file");
                                        
    } else {

        // sprawdzam czy istnieje plik w $base_theme (katalog jezykowy) np. themes/_pl/standard/head.html.php
        $inode3=@fileinode("$DOCUMENT_ROOT/themes/_$config->lang/$base_theme/$file");
        if ($inode3>0) {
            if (! empty($include_once)) include_once("$DOCUMENT_ROOT/themes/_$config->lang/$base_theme/$file");
            else include("$DOCUMENT_ROOT/themes/_$config->lang/$base_theme/$file");
        } else {

            // sprawdzam czy plik istnieje w $base_theme (katalog base) np. themes/standard/head.html.php
            $inode4=@fileinode("$DOCUMENT_ROOT/themes/base/$base_theme/$file");
            if ($inode4>0) {
                if (! empty($include_once)) include_once("$DOCUMENT_ROOT/themes/base/$base_theme/$file");
                else include("$DOCUMENT_ROOT/themes/base/$base_theme/$file");
            } else {
                
                // sprawdzam czy plik istnieje w glownym temacie - base_theme (katalog jezykowy) np. themes/_pl/base_theme/head.html.php
                $inode5=@fileinode("$DOCUMENT_ROOT/themes/_$config->lang/base_theme/$file");
                if ($inode5>0) {
                    if (! empty($include_once)) include_once("$DOCUMENT_ROOT/themes/_$config->lang/base_theme/$file");
                    else include("$DOCUMENT_ROOT/themes/_$config->lang/base_theme/$file");
                } else {
                    
                    //sprawdzam czy plik istnieje w glownym temacie - base_theme (katalog base) np. themes/base/base_theme/head.html.php
                    $inode6=@fileinode("$DOCUMENT_ROOT/themes/base/base_theme/$file");
                    if ($inode6>0) {
                        if (! empty($include_once)) include_once("$DOCUMENT_ROOT/themes/base/base_theme/$file");
                        else include("$DOCUMENT_ROOT/themes/base/base_theme/$file");
                    }
                    
                } //end if 

            } //end if
            
        } //end if

    } // end if

} // end if

//$time->stop($file." ".@$text);

?>
