<?php
/**
* Edycja wersji jêzykowych - pozyskanie poszukiwanych zmiennych
*
* Skrypt pozyskuje poszukiwane zmienne przygotowuje formularz ich edycji
*
* @author  lech@sote.pl
* @version $Id: lang_editor_mainform.php,v 1.10 2004/12/20 17:58:17 maroslaw Exp $
* @package    lang_editor
*/
$query = $editor->preparePathSearchQuery($_REQUEST); // przygotuj zapytanie do bazy
$paths = $editor->retreivePathsFromDB($query); // pobierz ¶cie¿ki do w³a¶ciwych plików z bazy

// print_r($paths);

/**
* Nag³ówek formularza.
*/
include("./html/lang_editor_mainform_begin.html.php"); // nag³ówek formularza
for($i = 0; $i < count($paths); $i++){ // dla ka¿dej lokalizacji
    for($j = 0; $j < count($editor->fileArray); $j++){ // dla ka¿dej pozycji w tablicy fileArray
/*
        echo "
        <br>[" .$paths[$i]. "]<br>
            [" . strstr($editor->fileArray[$j]['location'][$config->base_lang], '/./htdocs/') . "]<br>";
*/
        if(ereg("^" . $paths[$i], strstr($editor->fileArray[$j]['location'][$config->base_lang], '/./' . $editor->part . '/'))) { // je¶li ¶cie¿ka z tablicy fileArray zgadza siê ze ¶cie¿k± z bazy
            $editor->currentVars = array(); // wyczy¶æ tablicê zmiennych
            for($l = 0; $l < count($editor->languages); $l++){
                $editor->readLangFileToCurrentVars($j, $editor->languages[$l]); //wpisz do CurrentVars zmienne ze zweryfikowanej lokalizacji dla wszystkich lokalizacji
                
            }
/**
* Przetwarzanie zmiennych.
*/
            include("./include/lang_editor_mainform_varset.php"); // zweryfikuj i wy¶wietl zmienne
        }
    }
}

/**
* Stopka formularza.
*/
include("./html/lang_editor_mainform_end.html.php"); // stopka formularza

?>
