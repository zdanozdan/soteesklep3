<?php
/**
 * Sprawdzenie polaczenia z baza danych. Jesli nie mozna sie polaczyc z baza danych
 * przekieruj uzytkownika na strone gdzie mozne wprowadzic nowe dane.
 *
 * @author  m@sote.pl
 * @version $Id: check_db.inc.php,v 2.4 2004/12/20 17:59:19 maroslaw Exp $
* @package    admin_include
 */

global $__scure_test,$db;
if (@$__secure_test!=true) die ("Forbidden");

$query="SELECT id FROM main LIMIT 1";
$result=$db->Query($query);
if ($result==0) {
    // nie mozna polaczyc sie z baza
    die ($db->Error());
    exit;
}
?>
