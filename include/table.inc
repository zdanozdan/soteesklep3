<?php
/**
* Klasa obslugi tabel HTML. Glowna funkcja klasy, jest generowanie okreslonej
* ilosci pol w wierszu tabeli.
*
* @author  m@sote.pl
* @version $Id: table.inc,v 2.7 2004/12/20 18:02:57 maroslaw Exp $
* @package    include
*/

class HTMLTable {
    
    /**
    * @var int $_cols liczba kolumn w wierszu tabeli
    */
    var $_cols=1;
    
    /**
    * @var int $_nr Numer aktualnej kolumny w wierszu
    */
    var $_nr=1;
    
    /**
    * @var bool $_new Oznaczenie czy w kolejnym polu wstawiamy nowy wiersz
    */
    var $_new=true;
    
    /**
    * Konstruktor
    *
    * @param string $width  szerowkosc tablicy
    * @param string $attrib atrybuty
    *
    * @access public
    * @return void
    */
    function HTMLTable($width="100%",$attrib='') {
        $this->open($width,$attrib);
        return;
    } // end HTMLTable()
    
    /*
    * Otworz/inicjuj tablice
    *
    * @param string $width  szerowkosc tablicy
    * @param string $attrib atrybuty
    *
    * @access public
    * @return void
    */
    function open($width,$attrib='') {
        print "<table width='$width' $attrib>\n";
        return;
    } // end open()
    
    /**
    * Zamknij tablice
    *
    * @access public
    * @return void
    */
    function close() {
        print "</table>\n";
        return;
    } // end close()
    
    /**
    * Ustaw liczbe kolumn w wierszu 
    * 
    * @param int $cols liczba kolumn
    *
    * @access public
    * @return void
    */
    function setCols($cols) {
        $this->_cols=$cols;
        return;
    } // end setCols()
    
    /**
    * Rozpocznij nowy wiersz
    * 
    * @param string $attrib atrybuty <TR>
    * 
    * @access public
    * @return void
    */
    function openRow($attrib='') {
        print "<tr $attrib>\n";
        return;
    } // openRow()
    
    /**
    * Zakoncz wiersz
    * 
    * @access piblic
    * @return void
    */
    function closeRow() {
        print "</tr>\n";
        return;
    } // end closeRow()
    
    /**
    * Otworz komorke (<TD>)
    * 
    * @param string $attrib atrybuty <TD>
    *
    * @access public
    * @return void
    */
    function openCol($attrib) {
        print "<td $attrib>\n";
        return;
    } // openCol()
    
    /**
    * Zamknij komorke
    *
    * @access public
    * @return void
    */
    function closeCol() {
        print "</td>\n";
        return;
    } // end closeCol()
    
    /**
    * Otworz wiersz/komorke tabeli uwzgledniajac ilosc kolumn w wierszu
    * 
    * @param string $attrib atrybuty <TR> i <TD> - takie same sa wstawiade do obu tagow
    *
    * @access public
    * @return void
    */
    function openField($attrib='') {
        if ($this->_new) {
            $this->openRow($attrib);
            if (! eregi("width",$attrib)) {
                $width=" width='".intval(100/$this->_cols)."%' ";
            } else $width='';
            $this->openCol($attrib.$width);
            $this->_new=false;
        } else {
            $this->openCol($attrib);
        }
        return;
    } // end openField()
    
    /**
    * Zamknij wiersz/komorke
    *
    * @access public
    * @return void
    */
    function closeField() {
        if ($this->_nr<$this->_cols) {
            $this->closeCol();
            $this->_nr++;
        } else {
            $this->closeCol();
            $this->closeRow();
            $this->_new=true;
            $this->_nr=1;
        }
        return;
    } // end closeField()
    
} // end class HTMLTable()

/* Example:
require_once ("include/table.inc");
$data=array("1","2","3","4","5");
reset($data);
$table = new HTMLTable("100%","border=1");
$table->setCols(3);
foreach ($data as $dat) {
    $table->openField();
    print "dat=$dat";
    $table->closeField();
}
$table->close();
*/

?>
