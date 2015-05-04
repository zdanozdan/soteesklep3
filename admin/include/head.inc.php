<?php
/**
 * Dodatkowy naglowek skryptow, wywolywany dla admina: sprawdzenie uprawnien itp.
 *
 * \@global array $__perm tablica z prawami zalogowanego usera array("all","modules","newsedit",...)
 *
 * @author  m@sote.pl
 * @version $Id: head.inc.php,v 2.26 2005/04/27 15:55:39 maroslaw Exp $
* @package    admin_include
 */

// odczytaj uprawnienia wymagane do wywoalania danej czesci programu, sprawdz czy uzytkownik
// ma prawa do dostepu do danej funkcji


// zaladuj dodatkowe biblioteki, skrypty, itp.
require_once ("include/check_perm.inc.php");
@include_once(".perm.php"); // $__perm_require
if (! empty($__perm_require)) {
    if (! $permf->check($__perm_require)) die ($error->show("access_deny"));
}

// sprawd¼, czy u¿ytkownik nie zmieni³ licencji w trakscie sesji
if ((! empty($_SESSION['license'])) && ($_SESSION['license']!=$config->license)) {
    die ($error->show("license_deny"));        
}

// odczytaj dodatkowa konfiguracje dot. admina
require_once ("$DOCUMENT_ROOT/config/config.inc.php");

// zaladuj TIPSY
@include_once (".tips.php");

// zaladuj slownik
if ($config->lang!=$config->base_lang) {
    @include_once ("$DOCUMENT_ROOT/../htdocs/lang/_$config->lang/dictionary_config.inc.php");
}

// odczytaj lokalna klase funkcji bedacych rozszezeniem klasy ThemePlugins bedaca rozszezeniem klasy ThemeAdmin
@include_once("./themes/theme.inc.php");

// zmien temat w konfiguracji, nadpisz domyslna nazwe tamatu z $config->theme
if (! empty($_SESSION['global_theme'])) {
    $config->admin_theme=$_SESSION['global_theme'];
    // uaktualnij sicezke do tematu w obiekcie $config - $config->theme_dir
    $config->theme_dir();
}

// ustaw katalog tamatow (glowne ustawienie jest w config/config.inc.php - ale tam jest przypisany domyslnie temat $config->theme)
$config->theme_dir=$DOCUMENT_ROOT."/themes/_".$config->lang."/".$config->admin_theme;


// w³±cz tryb devel
if ((! empty($_SESSION['__devel'])) && ($_SESSION['__devel']==$_SERVER['REMOTE_ADDR'])) {
    error_reporting(E_ALL);
    $__devel=1;    
}

// celowy brak domkniêcia sekcji php
