<?php
/**
 * Obluga wejsc z portalu Onet.pl
 *
 * @author  m@sote.pl
 * @version $Id: onet.pl.inc.php,v 1.3 2004/12/20 18:03:01 maroslaw Exp $
* @package    include
 */
 
class SearchFrom {
    var $max_words=10;       // maksymalna liczba slow rozpatrywanych z zapytania wyszukiwania

    /**
     * Odczytaj wyrazy wyszukiwane przez klienta
     * format danych z onet.pl: http://szukaj.onet.pl/query.html?qt=sote+software&col=all&fff=1
     * interesuje naz zmienna qt
     *
     * @return string lista wyszukiwanych w wyszukiwarce slow np. sklepy+internetowe
     */
    function get_query_words() {
        global $_SERVER;

        $http_refer=$_SERVER['HTTP_REFER'];
        preg_match("/qt=([a-z0-9_\.+|-|%|0-9]+)/i",$http_refer,$matches);        
        if (! @empty($matches[1])) {
            return urldecode($matches[1]);
        } else return array();                    
    } // end get_query_words()   
    
} // end class SearchFrom

$search_from = new SearchFrom;
?>
