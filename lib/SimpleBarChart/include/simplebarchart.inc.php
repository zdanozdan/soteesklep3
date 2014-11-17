<?php
/**
* Generowanie prostych graf�w s�upkowych
*
* Modu� generuje prosty wykres s�upkowy. S�upki s� poziome.
* Barwa definiowana jest plikiem graficznym. Niedozwolone s� warto�ci ujemne.
* D�ugo�ci s�upk�w s� proporcjonalnie skalowane do narzuconej szeroko�ci wykresu.
*
* @author  lech@sote.pl
* @version $Id: simplebarchart.inc.php,v 1.2 2004/12/17 09:24:29 krzys Exp $
* @package simplebarchart
*/

$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];


/**
* Sciezka do katalogu g��wnego sklepu
*/
define("SBC_DOCUMENT_ROOT", $DOCUMENT_ROOT."/../");

/**
* Sciezka do katalogu z modu�em
*/
define("SBC_PATH", '/lib/SimpleBarChart/');

/**
* Sciezka do katalogu z grafikami do modu�u
*/
define("SBC_PATH_IMAGES", SBC_PATH . 'html_img/');


/**
* G��wna klasa modu�u generuj�cego proste grafy s�upkowe
*
* @author  lech@sote.pl
* @version $Id: simplebarchart.inc.php,v 1.2 2004/12/17 09:24:29 krzys Exp $
* @package simplebarchart
*/
class SimpleBarChart{


    /**
    * Tablica z danymi o wykresie
    *
    * Tablica zawiera nast�puj�ce elementy:
    * <ul>
    *   <li>title - tytu� wykresu,
    *   <li>series - tablica z warto�ciami prezentowanymi na wykresie, jej kluczami s� nazwy s�upk�w,
    * a warto�ciami - warto�ci (d�ugo�ci) s�upk�w
    * </ul>
    * Tablica inicjowana jest przez konstruktor.
    */
    var $data;
    
    /**
    * Szeroko�� obszaru wykresu
    *
    * Pole definiuj�ce szeroko�� obszaru, na kt�rym generowane b�d� s�upki wykresu.
    * Nie jest to szeroko�� ca�kowita, gdy� nie obejmuje opis�w s�upk�w i innych
    * tekstowych element�w wykresu. Pole inicjowane konstruktorem.
    */
    var $width; // szeroko�� wykresu

    /**
    * Wysoko�� obszaru wykresu - obecnie bez zastosowania
    */
    var $height;

    /**
    * Zeskalowane warto�ci s�upk�w wykresu
    *
    * Tablica zawiera te same klucze i warto�ci co tablica $data['series'],
    * lecz jej warto�ci s� odpowiednio zeskalowane do narzuconej szeroko�ci wykresu
    */
    var $scaled_values;
    
    /**
    * Nazwa pliku graficznego, kt�ry s�u�y do obrazowania s�upka wykresu
    */
    var $bar_unit_image = "unit_sea_3d.jpg"; // obrazek paska wykresu
    
    /**
    * Grubo�� zewn�trznej ramki wykresu
    */
    var $border = 2;
    
    /**
    * Rozstrzelenie kom�rek w tabeli wykresu (odst�py mi�dzy kom�rkami)
    */
    var $cellpadding = 3;
    
    /**
    * Kostruktor klasy SimpleBarChart
    *
    * Kostruktor inicjuje niekt�re parametrami wej�ciowymi.
    * @param array $data Tablica zawiera nast�puj�ce pola charakteryzuj�ce wykres:
    * <ul>
    *   <li>title - tytu� wykresu,</li>
    *   <li>series - tablica z warto�ciami prezentowanymi na wykresie, jej kluczami
    *   s� nazwy s�upk�w, a warto�ciami - warto�ci (d�ugo�ci) s�upk�w</li>
    * </ul>
    * @param int $width Pole definiuj�ce szeroko�� obszaru, na kt�rym generowane b�d�
    * s�upki wykresu (zobacz opis pola $width)
    */
    function SimpleBarChart($data, $width){
        global $lang;
        if(count($data['series']) == 0)
            $data['series'][$lang->no_item] = 0;
        while(list($key, $val) = each($data['series'])){
            if($val < 0)
                $val = 0;
            $this->data['series'][$key] = $val;
        }
        $this->data['title'] = $data['title'];
        $this->width = $width;
    }
    
    /**
    * Metoda przygotowuj�ca dane i generuj�ca wykres
    */
    function draw(){
        $this->_scaleValues();
        $this->_htmlDraw();
    }
    
    /**
    * Metoda generuj�ca wykres HTML
    */
    function _htmlDraw(){
        $this->_htmlChartHead();
        reset($this->data['series']);
        while (list($key, $val) = each($this->data['series'])){
            $this->_htmlBar($key);
        }
        $this->_htmlChartFoot();
    }

    /**
    * Metoda skaluj�ca dane proporcjonalnie do narzuconej szeroko�ci wykresu
    */
    function _scaleValues(){
        $val_max = 0;
        $scaled = array();
        $working = $this->data['series'];
//        print_r($working);
        reset($working);
        while (list($key, $val) = each($working)){
            if($val > $val_max)
                $val_max = $val;
        }
        if($val_max == 0){
            while (list($key, $val) = each($this->data['series'])){
                $this->scaled_values[0][$key] = 0;
                $this->scaled_values[1][$key] = 0;
            }
        }
        else{
            $val_min = $val_max;
            reset($working);
            while (list($key, $val) = each($working)){
                if($val < $val_min)
                    $val_min = $val;
            }
            $val_max2 = $val_max - $val_min;
            $mul = 1;
            if($val_max < 10)
                $m = 10;
            else
                $m = 0.1;
            $tmp = $val_max;
            $safety_iterator = 1000;
            while(($tmp < 10) || ($tmp >= 100)){
                $tmp = $tmp * $m;
                $mul = $mul / $m;
                $safety_iterator--;
                if($safety_iterator <= 0)
                    exit("P�tla wykona�a zbyt wiele iteracji. Nast�pi�o wy��czenie skrypt�w.");
            }
            $tmp = floor($tmp) + 1;
            $val_max = $tmp * $mul;
            if($val_max == 0)
                $k = 0;
            else
                $k = $this->width / $val_max;
            if($val_max2 == 0)
                $k2 = 0;
            else
                $k2 = $this->width / $val_max2;
            reset($this->data['series']);
            while (list($key, $val) = each($this->data['series'])){
                $this->scaled_values[0][$key] = floor($k * $val);
                $this->scaled_values[1][$key] = floor($k2 * ($val - $val_min));
            }
        }
    }
    
    /**
    * Metoda wy�wietlaj�ca pojedynczy s�upek w wykresie
    * 
    * @param string $data_row Nazwa s�upka (klucz z tablicy $data['series']).
    */
    function _htmlBar($data_row){
        $images_path = SBC_PATH_IMAGES;
        $bar_unit_image = SBC_PATH_IMAGES . $this->bar_unit_image;
        $value = $this->scaled_values[0][$data_row];
        $value2 = $this->scaled_values[1][$data_row];
        $value_str = $this->data['series'][$data_row];
        $scale = floor(($this->cellpadding + 15) / 2);
        while($scale > 15)
            $scale = floor($scale / 2);
        include(SBC_DOCUMENT_ROOT . SBC_PATH . "html/chart_bar.html.php");
    }
    
    /**
    * Metoda wy�wietlaj�ca nag��wek wykresu
    */
    function _htmlChartHead(){
        $images_path = SBC_PATH_IMAGES;
        $rowspan = count($this->data['series']) * 2 + 11;
        include(SBC_DOCUMENT_ROOT . SBC_PATH . "html/chart_head.html.php");
    }
    
    /**
    * Metoda wy�wietlaj�ca stopk� wykresu
    */
    function _htmlChartFoot(){
        $images_path = SBC_PATH_IMAGES;
        include(SBC_DOCUMENT_ROOT . SBC_PATH . "html/chart_foot.html.php");
    }
}
?>