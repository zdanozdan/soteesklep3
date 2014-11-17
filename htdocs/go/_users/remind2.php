<?php
/**
 * Wyslij nowe haslo do klienta, przekoduj jego dane z nowym haslem.
 *
 * @author  m@sote.pl
 * @version $Id: remind2.php,v 2.4 2005/01/20 15:00:24 maroslaw Exp $
* @package    users
 */

$global_database=true;
$global_secure_test=true; 
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

// naglowek
$theme->head();
$theme->page_open_head("page_open_1_head");

// odczytaj email
if (! empty($_REQUEST['email'])) {
    $email=$_REQUEST['email'];
    require_once ("include/my_crypt.inc");
    $crypt_email=$my_crypt->endecrypt("",$email,"");

    // wyszukaj uzytkownika w bazie wg emaila
    $query="SELECT * FROM users WHERE order_data=0 AND crypt_email=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetText($prepared_query,1,$crypt_email);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                // jest taki adres w bazie wyslij nowe haslo i przekoduj dane
                $theme->bar($lang->users_remind_title);
                
                $__id=$db->FetchResult($result,0,"id");
                $crypt_login=$db->FetchResult($result,0,"crypt_login");               
                $__login=$my_crypt->endecrypt("",$crypt_login,"de");
                $__email=$email;
                $__result=&$result;
                
                
                require_once ("./include/endecrypt_users.inc.php");
                $theme->theme_file("_users/remind2.html.php");
                $theme->theme_file("users.html.php");
            } else {
                // nie ma takiego adresu w bazie
                $__email_not_exists=true;
                include ("remind.php");
                exit;
            }
        } else die ($db->Error());
    } else die ("Forbidden");
    
} else {
    // nie wprowadzono adresu email
    include ("remind.php");
    exit;
}

$theme->page_open_foot("page_open_1_foot");
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
