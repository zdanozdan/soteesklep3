<?php
/**
 * Generuj klucze kodowania
 *
 * \@global string $__pin        PIN
 * 
 * return
 * \@global string $__key        klucz kodowania danych
 * \@global string $__secure_key indywidualny klucz kodowania danych zwiazany z PIN
 * 
 * @author  m@sote.pl
 * @version $id$
* @package    admin_include
 */
global $config;
global $__key,$__secure_key,$__pin;

$__key=$config->salt;
$__secure_key=md5($config->salt.$__pin);
?>
