<?php
/**
* Autoryzacja administartora, 2 poziom autoryzacji - PIN
* Sprawdzenie terminu waznosci licencji
*
* /@session string $pin PIN
*
* @author m@sote.pl
* @version $Id: index.php,v 2.14 2005/05/09 10:26:20 maroslaw Exp $
* @package    auth
*/

$global_database=false;

$__secure_test=true;$__start_page=true;
/** okreslenie sciezki */
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
/** Naglowek skryptu */
require ("../../../include/head.inc");          // nie wsatwiac require_once !
/** Licencja */
require_once ("include/license.inc.php");

// nie wymagaj PIN jesli jest to DEMO na WWW, PIN dla demo jest staly: 12345678
if ($config->demo=="yes") {
    $_POST['pin']='12345678';
}

$license =& new License;

if (! empty($_POST['pin'])) {
    
    // jesli w po numerze PIN jest slowo " devel", to w³±cz sklep w tryb devel
    if (ereg(" devel$",trim($_POST['pin']))) {
        $__devel=$_SERVER['REMOTE_ADDR'];
        $sess->register("__devel",$__devel);
        $_POST['pin']=ereg_replace(" devel","",trim($_POST['pin']));
        //print "DEVEL";        
    } else {
        $sess->unregister("__devel");  
    }
    $__pin=$_POST['pin'];
    $md5_pin=md5($__pin);
    //print $md5_pin;
    //print $config->md5_pin;
    
    if ((! empty($md5_pin)) && ($md5_pin==$config->md5_pin) && ($license->check_date()) && ($license->check($config->license['nr']))) {
        $sess->register("__pin",$__pin);
        // sprawdz czy jest dostep do bazy danych
        $global_database=true;
        require ("include/head.inc");
        include_once ("include/check_db.inc.php");
        
        require_once ("./include/get_perm.inc.php");
        require_once ("./include/multi_shop.inc.php");
        include_once ("../../index.php");                // wywolaj glowna strone
        $license=$config->license;
        $sess->register("license",$license);
        exit;
    } else {
        if (! $license->check($config->license['nr'])) {
            die ($error->show("license_deny"));
        } else $license_error="<center><font color=red>$error->wrong_pin</font></center>\n";
    }
}

if (! $license->check_date()) {
    $license_error="<center><font color=red>$lang->auth_license_timeout</font></center>";
}

// okno logowania
include_once ("./html/auth.html.php");

include_once ("include/foot.inc");
?>