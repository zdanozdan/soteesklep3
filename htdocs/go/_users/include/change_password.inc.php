<?php
/**
 * Zmien haslo i przekoduj dane klienta
 *
 * @author  m@sote.pl
 * @version $Id: change_password.inc.php,v 2.2 2004/12/20 18:01:53 maroslaw Exp $
* @package    users
 */

if ($__secure_test!=true) die ("Forbidden");

$__new_password=$_REQUEST['item']['password'];
$__id=$_SESSION['global_id_user'];

// wyszukaj uzytkownika w bazie wg id
$query="SELECT * FROM users WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$__id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
	$num_rows=$db->NumberOfRows($result);
	if ($num_rows>0) {
	    $__result=&$result;
	    // przekoduj dane i zaloz nowe haslo klientowi
            require_once ("./include/endecrypt_users.inc.php");
	} else {
	    $theme->theme_file("users.html.php");
	}
    } else die ($db->Error());
} else die ("Forbidden");

?>
