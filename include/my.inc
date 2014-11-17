<?php
/**
 * Odczytaj zmienna, jesli nie m awartosci to zwroc "".
 * funkcja pozwala na unikniecie odczytywania pustych zmiennych, przez co
 * nie sa wysylane warningi PHP
 *
 * @param unknown $var zmienna
 * @param string $type okreslenie czy zmeinna jest liczbowa czy nie
 * @return wartosc $var 0 lub ""
* @version    $Id: my.inc,v 2.2 2004/12/20 18:02:54 maroslaw Exp $
* @package    include
 */
 function my($var,$type="") {
     if (! empty($var)) return $var;
     if ($type=="NUM") return 0;
     return "";
 }
?>
