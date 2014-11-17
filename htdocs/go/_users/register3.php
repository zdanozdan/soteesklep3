<?php
/**
 * Aktualizuj dane zarejestrowanego uzytkownika                        
 *
 * @param int $global_id_user
 * \@session int $global_id_user
 * \@session bool $global_lock_register
 *
 * @author m@sote.pl
 * @version $Id: register3.php,v 2.14 2005/01/20 15:00:24 maroslaw Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true;
global $DOCUMENT_ROOT;
if (empty($DOCUMENT_ROOT)) {
    $DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
}
require_once ("../../../include/head.inc");
require_once ("include/upper_lower_name.inc");

// poprawka aktualizacji danych 2003.02.06, problem polegal na braku aktualizacji danych kiedy nie byla wybrana
// edycje adresu korepondencyjnego
// jesli sa dane w _POST, to odczytaj te dane jako glowne, i dopiero w przeciwnym razie odczytaj dane z sesji
if (! empty($_POST['form'])) {
    $form=$_POST['form'];
} elseif (! empty($_SESSION['form'])) {
    $form=$_SESSION['form'];
}

if (empty($form)) $form=array();

if (! empty($_POST['form_cor'])) {
    $form_cor=$_POST['form_cor'];
} elseif (! empty($_SESSION['form_cor'])) {
    $form_cor=$_SESSION['form_cor'];
}

if (empty($form_cor)) $form_cor=array();
// end 2003.02.06

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");
include_once("include/menu.inc.php");

require_once ("include/my_crypt.inc");
if (empty($crypt)) $crypt =& new MyCrypt;

// @todo suma kontrolna na razie nie jest liczona
include_once ("./include/checksum.inc.php");
$checksum = '';

// zamien tekst na male litery + pierwsza litera ma byc wielka
$name=upper_lower_name(@$form['name']);
$surname=upper_lower_name(@$form['surname']);

// zamien na male litery
$email=strtolower(@$form['email']);

$crypt_firm=$crypt->endecrypt('',@$form['firm'],"");
$crypt_name=$crypt->endecrypt('',@$name,"");
$crypt_surname=$crypt->endecrypt('',@$surname,"");
$crypt_street=$crypt->endecrypt('',@$form['street'],"");
$crypt_street_n1=$crypt->endecrypt('',@$form['street_n1'],"");
$crypt_street_n2=$crypt->endecrypt('',@$form['street_n2'],"");
$crypt_postcode=$crypt->endecrypt('',@$form['postcode'],"");
$crypt_city=$crypt->endecrypt('',@$form['city'],"");
$crypt_nip=$crypt->endecrypt('',@$form['nip'],"");
$crypt_phone=$crypt->endecrypt('',@$form['phone'],"");
$crypt_email=$crypt->endecrypt('',@$email,'');
$crypt_country=$crypt->endecrypt('',@$form['country']);
$crypt_user_description=$crypt->endecrypt('',@$form['description']);

$date_update=date('Y-m-d');
$last_ip=$_SERVER['REMOTE_ADDR'];

if (! empty($_SESSION['global_id_user'])) {
    $global_id_user=$_SESSION['global_id_user'];
} else  {
    $theme->go2main();
    exit;
}

/**
* Aktualizuj dane w bazie.
*/
require_once ("./include/update.inc.php");
if ($__update_result==true) {
    $global_lock_register=true;
    $sess->register("global_lock_register",$global_lock_register);
    /**
    * Uda³o sie zaktualizowaæ dane u¿ytkownika.
    */
    include_once("./include/update_ok.inc.php");
}

$theme->page_open_foot("page_open_1_foot");

// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
