<?php
/**
* Klasa zawierajaca funkcje zwiazane z ustawieniami jezykowymi
* np. tlumaczenie kategorii na dany jezyk dostepny w sklepie itd.
*
* @author  piotrek@sote.pl m@sote.pl
* @version $Id: lang_functions.inc,v 2.17 2006/06/21 11:02:38 lukasz Exp $
* @package    include
*/

global $dictionary;
global $config;
global $DOCUMENT_ROOT;

// przypisanie odpowiedniego jezyka w zaleznosci od parametru $config->lang
$absolute_path="$DOCUMENT_ROOT/lang/_".$config->lang."/dictionary_config.inc.php";

// includowanie plikow konfiguracyjnych (slownikow) w zaleznosci od danego jezyka
if (file_exists($absolute_path)) {
    /**
    * Odczytaj definicje s³ownika. Odczytaj obiekt $dictionary.
    */
    include_once("$absolute_path");
}

/**
* T³umaczenie wyra¿eñ na podstwie s³ownika.
* @package lang
* @subpackage dictionary
*/
class LangFunctions extends Lang {
    
    /**
    * Wyswietl slowo ze slownika (odpowiedni plik konfiguracyjny) w odpowiednim jezyku odpowiadajace slowu bazowemu (wordbase)
    *
    * @param string $wordbase slowo bazowe
    */
    function f_print($wordbase) {
        global $dictionary;
        $wordbase=trim($wordbase);
        if(! empty($dictionary->words["$wordbase"])) {    // jesli slowo bazowe wystepuje w tablicy wyswietl jezykowy odpowiednik
        print $dictionary->words["$wordbase"];
        } else {
            print $wordbase;    // wyswietl slowo bazowe
        }
        
        return(0);
    } // end f_print
    
    /**
    * Zwroc slowo ze slownika (odpowiedni plik konfiguracyjny) w odpowiednim jezyku odpowiadajace slowu bazowemu (wordbase)
    *
    * @param string $wordbase slowo bazowe
    */
    function f_translate($wordbase) {
        global $dictionary;
        global $config;
        $wordbase=trim($wordbase);
        if (! empty($dictionary)) {
            // jesli slowo bazowe wystepuje w tablicy zwroc jezykowy odpowiednik
            if (! empty($dictionary->words[$wordbase])) {
                return $dictionary->words["$wordbase"];
            } else {
                return $wordbase;
            }
        } else return $wordbase;
        
    } // end f_translate()
    
    /**
    * Uproszczenie wywo³ania funkcji f_translate. Funkcja modyfikuje s³owo przekazane jako parametr (wska¼nik).
    *
    * @access string &$wordbase wyra¿enie, które bêdzie t³umaczone
    * @return string przet³umaczone s³owo
    */
    function translate(&$wordbase) {
    	$wordbase=trim($wordbase);
        $wordbase=LangFunctions::f_translate($wordbase);
        return $wordbase;
    } // end translate()
    
    /**
    * Zwroc slowo ze slownika w odpowiednim jezyku wyrazonym przez parametr $lang2 odpowiadajace slowu $word
    * Przyklad wywolania: $translated_word=f_translate2("pl","en","Drukarki")
    * Pod zmienna $translated_word otrzymamy tlumaczenie angielskie slowa polskiego Drukarki
    *
    * @param string $lang1 jezyk slowa $word
    * @param string $lang2 jezyk na, ktory mam byc przetlumaczone slowo $word
    * @param string $word slowo przeznaczone do tlumaczenia
    */
    function f_translate2($lang1,$lang2,$word) {        
        global $dictionary,$_dictionary;
        global $DOCUMENT_ROOT;
        global $shop;
        
        if ($shop->admin==1) {
            $MAIN_DOCUMENT_ROOT=ereg_replace("\/admin$","",$DOCUMENT_ROOT);
        }
        
        // przypisanie odpowiedniego jezyka w zaleznosci od parametrow $lang1, $lang2
        // na razie domyslnie przyjete jest tylko tlumaczenie z jezyka polskiego
                        
        $absolute_path="$MAIN_DOCUMENT_ROOT/htdocs/lang/_".$lang2."/dictionary_config.inc.php";
                
        //includowanie plikow konfiguracyjnych (slownikow) w zaleznosci od danego jezyka
        if (file_exists($absolute_path)) {
            if (empty($_dictionary[$lang2])) {
                
                // sprawdz czy wczesniej w inenj funckji slownik nie byl juz zaladowany
                // jesli tak, to stworz obiekt odpowiedniej klasy slownika, jesli nie
                // to zalacz plik (w pliku jest generowany obiekt $dictionary)
                $DClass="DictionaryConfig_$lang2";
                if (! class_exists($DClass)) {                   
                    include ($absolute_path);            
                } else $dictionary =& new $DClass;
                
                // zapamietaj slownik w globalnej bazie slownikow
                $_dictionary[$lang2]=$dictionary;
                
            } else {
                // odczytaj wczesniej odczytany slownik
                $dictionary=$_dictionary[$lang2];                
            }
        } else {            
            $dictionary->words=array();
        }
        

        
        // jesli slowo bazowe wystepuje w tablicy zwroc jezykowy odpowiednik
        if(! empty($dictionary->words[$word])) {
            return $dictionary->words[$word];
        } else {
            return $word;    // zwroc slowo bazowe
        }
    } // end f_translate2
    
    
    /**
    * T³umacz nazy produktów zapamiêtane w sesji (nazwy produktów z koszyka)
    * 
    * @param string $name
    * @return string nazwa w jêzyku $config->lang
    */
    function name($name) {
        global $_SESSION,$config;
        if (! empty($_SESSION['products_lang_name'])) {
            $products_lang_name=$_SESSION['products_lang_name'];
            if (! empty($products_lang_name[$name][$config->lang])) return $products_lang_name[$name][$config->lang];
        }
        return $name;
    } // end name()
    
} // end class LangFunctions

/**
* Rozszerzenie klasy, uproszczenie nazwy.
* @package lang
* @subpackage dictionary
*/
class LangF extends LangFunctions{};

$langfunctions =& new LangF;
$langf=&$langfunctions;

?>
