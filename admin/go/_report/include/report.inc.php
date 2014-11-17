<?php
/**
* Plik z definicj� klasy Report
*
* Domy�lny skrypt obs�uguj�cy generowanie raport�w sprzeda�y.
* @author  lech@sote.pl
* @version $Id: report.inc.php,v 1.4 2004/12/20 17:59:04 maroslaw Exp $
* @package    report
*/

/**
* Plik klasy SimpleBarChart - rysowanie wykres�w s�upkowych
*/
require_once ("SimpleBarChart/include/simplebarchart.inc.php");

/**
* G��wna klasa obs�uguj�ca generowanie raportu sprzeda�y produkt�w
*
* Klasa generuje 4 rodzaje raport�w:
* <ul>
*   <li>zestawienie najlepiej sprzedawanych produkt�w</li>
*   <li>zestawienie kategorii najlepiej sprzedawanych produkt�w</li>
*   <li>zestawienie producent�w najlepiej sprzedawanych produkt�w</li>
*   <li>zestawienie liczby transakcji lub warto�ci transakcji</li>
* </ul>
* Ka�de zestawienie mo�e zosta� ograniczone zadanym przedzia�em czasowym.
* 
* @package report
*/
class Report {
    
    /**
    * Pole okre�laj�ce rodzaj raportu do wygenerowania.
    * Mo�e przyj�� jedn� z czterech nast�puj�cych warto�ci:
    * <ul>
    *   <li>"q_products" - zestawienie najlepiej sprzedawanych produkt�w</li>
    *   <li>"q_categories" - zestawienie kategorii najlepiej sprzedawanych produkt�w</li>
    *   <li>"q_producers" - zestawienie producent�w najlepiej sprzedawanych produkt�w</li>
    *   <li>"q_transactions" - zestawienie liczny lub warto�ci transakcji</li>
    * </ul>
    * Pole inicjowane konstruktorem
    * @var string
    */
    var $report_type;
    
    /**
    * Tablica warto�ci przekazanych do kostruktora klasy SimpleBarChart.
    * Posiada dwa pola:
    * <ul>
    * <li>title - tytu� wykresu w postaci HTML</li>
    * <li>data - tablica danych do s�upk�w wykresu. Kluczami s� nazwy s�upk�w,
    * warto�ciami - warto�ci s�upk�w</li>
    * </ul>
    * @var array
    */
    var $data = array();
    
    /**
    * Tablica danych pobranych z formularza
    * 
    * Tablica inicjowana jest jest w konstruktorze poprzez dok�adn� kopi�
    * tablicy $_REQUEST. Dla u�ytku klasy wykorzystywane s� nast�puj�ce pola:
    * <ul>
    * <li>date_data - tablica, kt�rej kluczami s� kolejne indeksy typu int (od zera),
    * a warto�ciami - tablice reprezentuj�ce daty o nast�puj�cej strukturze:
    *   <ul>
    *       <li>y - rok w postaci 4-cyfrowej</li>
    *       <li>m - dzie� w postaci 2-cyfrowej</li>
    *       <li>d - miesi�c w postaci 2-cyfrowej</li>
    *   </ul>
    * Poszczeg�lne elementy tablicy oznaczaj� r�ne terminy, np. dolne ograniczenie
    * czasowe zestawienia, g�rne ograniczenie czasowe zestawienia, itp. Ich kolejno��
    * i interpretacja zale�y od rodzaju raportu.
    * </li>
    * <li>producer_data - tablica, kt�ra w polu "id" zawiera 0 lub identyfikator producenta
    * o formacie "IdProducenta|NazwaProducenta" - dotyczy tylko raportu produkt�w
    * </li>
    * <li>category_data - tablica, kt�ra w polu "id" zawiera 0 lub identyfikatory
    * kategorii 1 i kategorii 2 (kategorii g��wnej produktu i podkategorii)
    * o formacie "IdKategorii1_IdKategorii2|NazwaKategorii1_NazwaKategorii2"
    *  - dotyczy tylko raportu produkt�w
    * </li>
    * <li>amount_data - tablica, kt�ra w polu "amount" wskazuje, ile pierwszych
    * pozycji ma zosta� uj�tych w zestawieniu
    *  - nie dotyczy tylko raportu transakcji</li>
    * <li>transaction_form - tablica, kt�ra w polu "division" okre�la
    * rodzaj zestawienia raportu transakcji:
    *   <ul>
    *     <li>d_1 - podzia� na miesi�ce</li>
    *     <li>d_2 - podzia� na dni</li>
    *     <li>d_3 - podzia� na godziny</li>
    *   </ul>
    *   natomiast w polu "values" okre�la, jakie warto�ci b�d� prezentowane na wykresie
    *   transakcji:
    *   <ul>
    *     <li>1 - liczby transakcji</li>
    *     <li>2 - sumy warto�ci transakcji</li>
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
    * @param string $report_type Warto�� inicjuj�ca pole report_type
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
    * Metoda poprawiaj�ca b��dnie wpisan� dat�
    * 
    * Metoda zamienia dat� np. 31 czerwca 2004 na 1 lipca 2004
    *
    * @param array $ar_date Data do poprawienia. Tablica ma 3 pola:
    * <ul>
    *   <li>y - rok w formacie 4-cyfrowym</li>
    *   <li>m - rok w formacie 2-cyfrowym</li>
    *   <li>d - rok w formacie 2-cyfrowym</li>
    * </ul>
    *
    * @return array Tablica z poprawion� dat� w tym samym formacie, co parametr wej�ciowy
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
    * Metoda pobiera dane z bazy i przekszta�ca je do formatu przystosowanego
    * dla klasy wy�wietlaj�cej wykres SimpleBarChart (dane zostaj� zapisane do
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
    * Funkcja tworzy formularz, do kt�rego mo�na wprowadzi� warto�ci precyzuj�ce
    * dane, kt�re chcemy pokaza� w raporcie, np. przedzia� czasowy
    *
    * @return none
    */
    function _drawForm() {
        global $db;

        include('./html/' . $this->report_type . '_form.html.php');
        return ;
    }
    
    /**
    * Generowanie ca�ego raportu
    * 
    * Funkcja realizuje pe�ne wygenerowanie raportu: formularza, pobranie danych
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
