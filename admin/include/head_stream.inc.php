<?php
/**
* Naglowek skryptu z obsluga przesylania strumieniowego, z emulacja obslugi sesji. W skrypcie w ktorym chcemy wykorzystac
* streaming danych, nalezy zaincudowac zamiast include/head.inc niniejszy plik
*
* @author  m@sote.pl
* @version $Id: head_stream.inc.php,v 2.11 2005/07/19 08:11:47 scalak Exp $
* @package    admin_include
*/

flush();
$global_database=true;
$global_secure_test=true;$__secure_test=true;
$__no_session=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];

// start netart:
// start netart:
if($DOCUMENT_ROOT!='/') {
    if (! ereg("soteesklep",$DOCUMENT_ROOT)) {
        $DOCUMENT_ROOT=substr(__FILE__,0,strlen(__FILE__)-34);
        if (ereg("admin",$_SERVER['HTTP_HOST'])) $DOCUMENT_ROOT.="/admin"; else $DOCUMENT_ROOT.="/htdocs";
    }
}
// end

// ustaw sciezki przeszukwian require i include
$_LIBS="$DOCUMENT_ROOT/htdocs/base:$DOCUMENT_ROOT/..:$DOCUMENT_ROOT:$DOCUMENT_ROOT/../lib:$DOCUMENT_ROOT/../lib/PEAR:$DOCUMENT_ROOT/base:$DOCUMENT_ROOT/base/lib::$DOCUMENT_ROOT/base/lib/PEAR:$DOCUMENT_ROOT/htdocs/base/lib:$DOCUMENT_ROOT/htdocs/base/lib/PEAR:";
ini_set("include_path","$_LIBS:.");

require_once ("include/no_session.inc");

// odczytaj dane z dodatkowego pliku sesji

include_once ("sessions_secure/".$sess->id.".php");
require_once ("include/objects.inc");
// odczytaj klucz kodowania z konfiguracji
require_once ("config/config.inc.php");

// odkoduj haslo
if (! empty($__crypt_pin)) {
    require_once ("include/my_crypt.inc");
    $key=$config->salt;
    $__pin=$my_crypt->endecrypt($key,$__crypt_pin,"de");
    $_SESSION['__pin']=$__pin;
    $_SESSION['__perm']=unserialize($__perm);
} else die ("Forbidden: Unknown PIN");

// odczytaj uprawnienia, gdyz uprawnienia nie beda dostepne w sesji
require("go/_auth/include/get_perm.inc.php");

// inicjuj biblioteki, obsluge bazy itp.
require_once ("$DOCUMENT_ROOT/../include/head.inc");

// odczytaj klase definicji jezykowych
if (@empty($lang)) {
    class Lang {}; $lang =& new Lang;
    class Error{}; $error =& new Error;
}

if ($config->base_lang!=$config->lang) {
    require_once ("lang/_$config->base_lang/lang.inc.php");
}
@include_once("lang/_$config->lang/lang.inc.php");   // obiekt $lang
@include_once("lang/_$config->lang/error.inc.php");  // obiekt $error


if (($config->base_lang!=$config->lang) && (empty($__start_page))) {
    // odczytaj definicje lokalne glownego jezyka, na wypadek, gdyby w $config->lang brakowalo pewnych definicji
    // z pominieciem wywolania dla glownej strony
    @include_once ("./lang/_$config->base_lang/lang.inc.php"); // dodatkowe definicje obiektu $lang
}

// jesli istnieja loaklne definicje jezykowe to je odczytaj
@include_once ("./lang/_$config->base_lang/lang.inc.php"); // dodatkowe definicje obiektu $lang dla base lang
@include_once ("./lang/_$config->lang/lang.inc.php");      // dodatkowe definicje obiektu $lang

?>