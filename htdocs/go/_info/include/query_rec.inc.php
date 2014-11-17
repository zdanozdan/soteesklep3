<?php
/**
 * Odczytaj dane z zapyatnia SQL i udostepnij je w obiekcie $rec
 *
 * \@global object $result - wynik zapytania SQL o wlasciwosci produktu
 *
 * @author  m@sote.pl
 * @version $Id: query_rec.inc.php,v 2.19 2004/12/20 18:01:40 maroslaw Exp $
* @package    info
 */

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ((empty($secure_test)) || (! empty($_REQUEST['secure_test']))) {
    die ("Forbidden");
}
   
/**
* @package info
* @ignore
*/
class RecordData {
    var $data=array();
}

global $rec;
$rec =& new RecordData;

$my_price =& new MyPrice;

require_once ("include/product.inc");
$product =& new Product($result,0,$rec);
$product->getRec(PRODUCT_INFO);
?>
