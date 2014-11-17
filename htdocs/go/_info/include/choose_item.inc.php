<?php
/**
* Wykonaj odpowiednie dzialanie w zaleznosci od parametru item
* Gdy $__item:
*    =1 -> Wyswiel inne produkty z tej samej kategorii
*    =2 -> Wyswietl akcesoria do danego produktu
*    =3 -> Wyswietl pelny opis produktu (zalaczony jako plik html)
*    =4 -> Wyswietl recenzje do danego produktu
*
* @author piotrek@sote.pl
* @version $Id: choose_item.inc.php,v 2.3 2004/12/20 18:01:40 maroslaw Exp $
* \@global $__id - identyfikator produktu, $__item - parametr. ktory pokazuje co ma zostac wyswietlone
* @package    info
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ((empty($secure_test)) || (! empty($_REQUEST['secure_test']))) {
    die ("Forbidden");
}

if ($__item==0) $__item=1;

switch ($__item) {
    case 1:
    include("./include/in_category.inc.php");           // inne produkty z tej samej kategorii
    break;
    case 2:
    include("./include/accessories.inc.php");           // akcesoria do danego produktu
    break;
    case 3:
    include("./include/html_desc.inc.php");           // pelny opis zalaczany z pliku html
    break;
    case 4:
    include("./include/reviews.inc.php");               // recenzje
    break;
    default:
    include("./include/in_category.inc.php");           // inne produkty z tej samej kategorii
    break;
    break;
    
}


?>
