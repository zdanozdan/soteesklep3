<?php
/**
* Plik z definicj± klasy Report
*
* Domy¶lny skrypt obs³uguj±cy generowanie raportów sprzeda¿y.
* @author  lech@sote.pl
* @version $Id: report.inc.php,v 1.4 2004/12/20 17:59:04 maroslaw Exp $
* @package    report
*/

/**
* Plik klasy SimpleBarChart - rysowanie wykresów s³upkowych
*/
require_once ("SimpleBarChart/include/simplebarchart.inc.php");

/**
* G³ówna klasa obs³uguj±ca generowanie raportu sprzeda¿y produktów
*
* Klasa generuje 4 rodzaje raportów:
* <ul>
*   <li>zestawienie najlepiej sprzedawanych produktów</li>
*   <li>zestawienie kategorii najlepiej sprzedawanych produktów</li>
*   <li>zestawienie producentów najlepiej sprzedawanych produktów</li>
*   <li>zestawienie liczby transakcji lub warto¶ci transakcji</li>
* </ul>
* Ka¿de zestawienie mo¿e zostaæ ograniczone zadanym przedzia³em czasowym.
* 
* @package report
*/
class Report {
    
    /**
    * Pole okre¶laj±ce rodzaj raportu do wygenerowania.
    * Mo¿e przyj±æ jedn± z czterech nastêpuj±cych warto¶ci:
    * <ul>
    *   <li>"q_products" - zestawienie najlepiej sprzedawanych produktów</li>
    *   <li>"q_categories" - zestawienie kategorii najlepiej sprzedawanych produktów</li>
    *   <li>"q_producers" - zestawienie producentów najlepiej sprzedawanych produktów</li>
    *   <li>"q_transactions" - zestawienie liczny lub warto¶ci transakcji</li>
    * </ul>
    * Pole inicjowane konstruktorem
    * @var string
    */
    var $report_type;
    
    /**
    * Tablica warto¶ci przekazanych do kostruktora klasy SimpleBarChart.
    * Posiada dwa pola:
    * <ul>
    * <li>title - tytu³ wykresu w postaci HTML</li>
    * <li>data - tablica danych do s³upków wykresu. Kluczami s± nazwy s³upków,
    * warto¶ciami - warto¶ci s³upków</li>
    * </ul>
    * @var array
    */
    var $data = array();
    
    /**
    * Tablica danych pobranych z formularza
    * 
    * Tablica inicjowana jest jest w konstruktorze poprzez dok³adn± kopiê
    * tablicy $_REQUEST. Dla u¿ytku klasy wykorzystywane s± nastêpuj±ce pola:
    * <ul>
    * <li>date_data - tablica, której kluczami s± kolejne indeksy typu int (od zera),
    * a warto¶ciami - tablice reprezentuj±ce daty o nastêpuj±cej strukturze:
    *   <ul>
    *       <li>y - rok w postaci 4-cyfrowej</li>
    *       <li>m - dzieñ w postaci 2-cyfrowej</li>
    *       <li>d - miesi±c w postaci 2-cyfrowej</li>
    *   </ul>
    * Poszczególne elementy tablicy oznaczaj± ró¿ne terminy, np. dolne ograniczenie
    * czasowe zestawienia, górne ograniczenie czasowe zestawienia, itp. Ich kolejno¶æ
    * i interpretacja zale¿y od rodzaju raportu.
    * </li>
    * <li>producer_data - tablica, która w polu "id" zawiera 0 lub identyfikator producenta
    * o formacie "IdProducenta|NazwaProducenta" - dotyczy tylko raportu produktów
    * </li>
    * <li>category_data - tablica, która w polu "id" zawiera 0 lub identyfikatory
    * kategorii 1 i kategorii 2 (kategorii g³ównej produktu i podkategorii)
    * o formacie "IdKategorii1_IdKategorii2|NazwaKategorii1_NazwaKategorii2"
    *  - dotyczy tylko raportu produktów
    * </li>
    * <li>amount_data - tablica, która w polu "amount" wskazuje, ile pierwszych
    * pozycji ma zostaæ ujêtych w zestawieniu
    *  - nie dotyczy tylko raportu transakcji</li>
    * <li>transaction_form - tablica, która w polu "division" okre¶la
    * rodzaj zestawienia raportu transakcji:
    *   <ul>
    *     <li>d_1 - podzia³ na miesi±ce</li>
    *     <li>d_2 - podzia³ na dni</li>
    *     <li>d_3 - podzia³ na godziny</li>
    *   </ul>
    *   natomiast w polu "values" okre¶la, jakie warto¶ci bêd± prezentowane na wykresie
    *   transakcji:
    *   <ul>
    *     <li>1 - liczby transakcji</li>
    *     <li>2 - sumy warto¶ci transakcji</li>
    *   </ul>
    *    - dotyczy tylko raportu transakcji</li>
    * </ul>
    * @var array
    */
    var $form_data;

    /**
    * Konstruktor klasy
    *
    * Inicjuje pola report_type i form_data
    * 
    * @param string $report_type Warto¶æ inicjuj±ca pole report_type
    * @return none
    */
    function Report($report_type = '') {
        $this->report_type = $report_type;
        if($this->report_type == '')
            $this->report_type = 'q_products';
        
        $this->form_data = @$_REQUEST;
        return ;
    }
    
    /**
    * Metoda poprawiaj±ca b³êdnie wpisan± datê
    * 
    * Metoda zamienia datê np. 31 czerwca 2004 na 1 lipca 2004
    *
    * @param array $ar_date Data do poprawienia. Tablica ma 3 pola:
    * <ul>
    *   <li>y - rok w formacie 4-cyfrowym</li>
    *   <li>m - rok w formacie 2-cyfrowym</li>
    *   <li>d - rok w formacie 2-cyfrowym</li>
    * </ul>
    *
    * @return array Tablica z poprawion± dat± w tym samym formacie, co parametr wej¶ciowy
    */
    function _correctDate($ar_date) {
        if(count($ar_date) < 3)
            return $ar_date;
        $time = mktime(0, 0, 0, (int)$ar_date['m'], (int)$ar_date['d'], (int)$ar_date['y']);
        $ar_result['m'] = date('m', $time);
        $ar_result['d'] = date('d', $time);
        $ar_result['y'] = date('Y', $time);
        return $ar_result;
    }
    
    /**
    * Pobranie danych z bazy
    *
    * Metoda pobiera dane z bazy i przekszta³ca je do formatu przystosowanego
    * dla klasy wy¶wietlaj±cej wykres SimpleBarChart (dane zostaj± zapisane do
    * pola "data" - patrz opis pola)
    * @return none
    */
    function _prepareData() {
        $data = array();
        global $db;
        include_once("./include/" . $this->report_type . ".php");
        $this->data = $data;
        return ;
    }
    
    /**
    * Generowanie formularza do raportu
    * 
    * Funkcja tworzy formularz, do którego mo¿na wprowadziæ warto¶ci precyzuj±ce
    * dane, które chcemy pokazaæ w raporcie, np. przedzia³ czasowy
    *
    * @return none
    */
    function _drawForm() {
        global $db;

        include('./html/' . $this->report_type . '_form.html.php');
        return ;
    }
    
    /**
    * Generowanie ca³ego raportu
    * 
    * Funkcja realizuje pe³ne wygenerowanie raportu: formularza, pobranie danych
    * do wykresu i narysowanie wykresu
    *
    * @return none
    */
    function draw() {
        $this->_drawForm();
        $this->_prepareData();
        echo '<br>';
        $chart =& new SimpleBarChart($this->data, 400);
        $chart->bar_unit_image = 'unit_violet_3d.jpg';
        $chart->border = 1;
        $chart->draw();
        return ;
    }
}

?>
