<?php
/**
* Klasa zawierajaca funkcje prezenctaji wiersza rekordu z bazy danych
* Ponizsze: nazwa klasy i nazwa funkcji sa domyslnymi nazwami w klasie DBEdit
*
* \@global  string $__record_row rodzaj prezentacji rekordu [short|long]
* \@session string $__record_row_type jw.
* \@global  object $xml_description obiekt klasy include/xml_description.inc
* @version    $Id: record_row.inc,v 2.16 2005/09/02 08:24:36 lukasz Exp $
* @package    include
*/

/**
* Odczytaywanie danych o produkcie.
*/
require_once ("include/product.inc");

/**
* @ignore
*/
class RecTmp{};

class RecordRow {
    var $type="long";                          // rodzaj prezentacji rekordu -  pelny lub skocony
    
    /**
    * Prezentacja rekodu z produktem (krotkiego lub pelnego ze zdjeciem)
    *
    * @param int $result wskaznik na strukture wyniku danych z bazy w obiekcie $db
    * @param int $i      numer wiersza wyniku zapytania SQL
    */
    function record(&$result,$i) {
        global $db;
        global $theme;
        global $rec;
        global $__record_row_type;
        global $config;
        global $DOCUMENT_ROOT;
        global $time;
        global $shop;
        
        $time->start("<font color=green>record_row.inc $i</font>");
        
        $rec =& new RecTmp;
        $product =& new Product($result,$i,$rec);
        $product->getRec(PRODUCT_ROW_SCORE);
        
        
        // zmien walute, jesli jest jakas waluta zadeklarowana globalnie
        $shop->currency->price($rec->data['price_brutto']);
        
        // odczytaj wyglad rekodu i wyswietl go
        if ($__record_row_type=="short") {
            // skrocona prezentacja rekordu
            $theme->record_row_short($rec);
        } else {
            // pelna prezentacja reordu
            $theme->record_row($rec);
        }
        
        $time->stop("<font color=green>record_row.inc $i</font>");
        
        return;
    } // end record_row()
    
    /**
    * Element wyswietlany przed gorna lista linkow do podstron
    */
    function open_page_links_top() {
        global $theme;
        $theme->theme_file("list/open_page_links_top.html.php");
    } // end  open_page_links_top()
    
    /**
    * Element wyswietlany po gornej lista liscie do podstron
    */
    function close_page_links_top() {
        global $theme;
        $theme->theme_file("list/close_page_links_top.html.php");
    } // end  close_page_links_top()
    
    /**
    * Element wyswietlany przed dolna lista linkow do podstron
    */
    function open_page_links_bottom() {
        global $theme;
        $theme->theme_file("list/open_page_links_bottom.html.php");
    } // end  open_page_links_bottom()
    
    /**
    * Element wyswietlany po dolnej lista liscie do podstron
    */
    function close_page_links_bottom() {
        global $theme;
        $theme->theme_file("list/close_page_links_bottom.html.php");
    } // end  close_page_links_bottom()
}

// sprawdz czy wywolano zmiane prezentacji rekordu i ustaw odpowiednie zmienne
// zapamietujace to wywolanie
$__record_row_type=$config->record_row_type_default;
if (@$_REQUEST['record_row']=="short") {
    $__record_row_type="short";
    $sess->register("__record_row_type",$__record_row_type);
    $rec->type="short";
} elseif (@$_REQUEST['record_row']=="long") {
    $__record_row_type="long";
    $sess->register("__record_row_type",$__record_row_type);
    $rec->type="long";
} elseif (! empty($_SESSION['__record_row_type'])) {
    $__record_row_type=$_SESSION['__record_row_type'];
    $rec->type=$__record_row_type;
} else {
    $rec->type=$config->record_row_type_default;
}

$config->record_row_type=&$rec->type;
?>
