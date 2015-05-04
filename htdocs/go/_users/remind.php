<?php
/**
 * "Przypomnienie" hasla klienta, obsluga wyslania nowego hasla na konto email klienta
 * System ze wzgledow bezp. nie przechwuje hasel w postaci jawnej i nie moze ich odtworzyc
 * dlatego zakladane jest nowe haslo i wysylane do klienta. Po zmianie hasla przekodowywane
 * sa dane klienta nowym kluczem.
 *
 * \@global bool $__email_not_exists true nie ma takiego adresu email w bazie (parametr przekazywany z remind2.php)
 *
 * @author  m@sote.pl
 * @version $Id: remind.php,v 1.1 2006/11/30 10:01:56 tomasz Exp $
* @package    users
 */

$global_database=false;
$global_secure_test=true; 
$DOCUMENT_ROOT=$_SERVER['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");

$val = true;
$sess->register("head_display",$val);

// naglowek
//$theme->head();
$theme->page_open_head("page_open_1_head");

$theme->bar($lang->users_remind_title);

if (@$__email_not_exists==true) {
    print "<br><center><b>".@$_REQUEST['email']."</b> - <font color=red>$lang->users_email_not_exists</font></center><p>";
}
$theme->theme_file("_users/remind.html.php");

$theme->page_open_foot("page_open_1_foot");
// stopka
$theme->foot();
include_once ("include/foot.inc");
?>
