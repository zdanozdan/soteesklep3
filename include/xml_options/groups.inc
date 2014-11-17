<?php
/**
* Wybieranie atrybutow sposrod grup opcji, z mozliwoscia wybrania atrybutu zmieniajacego cene produktu
*
* @author m@sote.pl
* @version $Id: groups.inc,v 2.5 2004/12/20 18:03:02 maroslaw Exp $
*
* @public show()
* @public parse($display)
* @public price($price,$data)
* @package    include
*/

class XMLGroups {
    var $data;             // zawartosc pola xml_options
    var $price=0;          // cena przetwarzanego atrybutu
    var $element;          // nazwa jw.
    var $elements=array(); // elementy pola select
    var $tab_data=array(); // nazwy pol i wartosci tablica postaci array("nazwa"=>array("wartosc1","wartosc2"))
    
    /**
    * Wywolanie prezentacji opcji
    *
    * @param &$result wynik zapytania z bazy danych
    * 
    * @access public
    * @return none
    */
    function show(&$result) {
        $this->result=&$result;
        $this->parse(true);
        return (0);
    } // end show()
    
    /**
    * Parsuj XML, zapisz strukture XML do tablicy $this->elements
    *
    * @param bool $display czy wyswietlac elementy formularza HTML
    * @public
    */
    function parse($display=false) {
        $xml=ereg_replace('&','&#38;',$this->data);
        
        $parser = xml_parser_create();
        xml_parse_into_struct($parser,$xml,$values,$tags);
        xml_parser_free($parser);
        
        $group_open=false;
        foreach ($values as $index) {
            $tag=$index['tag'];
            $type=$index['type'];
            $level=$index['level'];
            
            if (! empty($index['value'])) {
                $value=$index['value'];
            } else $value='';
            
            // otworzenei grupy elementow
            if (($tag=="GROUP") && ($level==2) && ($type=="open")){
                $group_open=true;
                $this->elements=array();
            }
            
            // elementy wewnatrz grupy
            if ($group_open==true) {
                if (($tag=="TITLE") && ($level==3) && ($type=="complete")) {
                    $this->title=$value;
                }
                if (($tag=="NAME") && ($level==3) && ($type=="complete")) {
                    $this->name=$value;
                }
                if (($tag=="VALUE") && ($level==3) && ($type=="complete")) {
                    array_push($this->elements,$value);
                }
            }
            
            // zamkniecie grupy elementow
            if (($tag=="GROUP") && ($level==2) && ($type=="close")) {
                if ($display==true) {
                    $this->show_group();
                } else {
                    // zapamietaj nazwe pola i wartosci
                    $tab_data=array($this->name,$this->elements);
                    array_push($this->tab_data,$tab_data);
                } // end if
                $group_open=false;
            } // end if
            
        } // end foreach
        
        return;
    } // end parse()
    
    /**
    * Odczytaj cene jesli jest podana przy opcji np. zielony[100]
    *
    * @param string $element wartosc wybranego elementu (atrybutu)
    * \@global floas $this->price cena
    * \@global string $this->element nazwa elementu bez ceny
    * \@global object $this->result wskaznik obiektu zawierajacego wynik zapytania SQL o atrybuty produktu
    * @return float cena odczytana z opcji
    */
    function get_price($element) {
        $this->element=$element;
        if (! ereg("\[[0-9.]+\]",$element)) {
            return(0);
        }
        
        $my_price = new MyPrice;
        
        preg_match("/^(.+)\[([0-9.]+)\]/",$element,$matches);
        $this->element=$matches[1];
        $this->price=my(@$matches[2]);
        $this->price=$my_price->price($this->result,0,$this->price,$this->price); // $this->price cena brutto, $this->price cena w walucie
        
        return $this->price;
    } // end get_price()
    
    /**
    * Przedstaw w postaci elementu formularz grupe opcji
    *
    * \@global array $this->elements
    * \@global string $this->name
    * \@global string $this->title
    * @public
    */
    function show_group() {
        global $config;
        global $discounts_config;
        
        // jezeli jest zalaczony modul rabatow dla kategorii i producentow, a nie ma zdefiniowanego
        // domyslnego rabatu uzytkownika, to nie wyswietlaj opcji, gdyz jesli w opcji beda ceny
        // to zostana one zle wyliczone
        if ((! empty($discounts_config)) && (empty($discounts_config->default_discount))) {
            return(0);
        }
        
        print "<B>$this->title</B>: \n";
        print "<select name=options[$this->name]>\n";
        print "<option value=''>   ---   \n";
        reset($this->elements);
        foreach ($this->elements as $element) {
            $this->get_price($element);                   // odczytaj cene jesli jest podana w opcji "opcja[cena]"
            if ($this->price>0) {
                print "<option value='".$this->element."'>".$this->element." ".$this->price." ".$config->currency."\n";
            } else {
                print "<option value='$element'>$element\n";
            }
            $this->price=0;$this->element='';
        } // end foreach
        print "</select><br>\n";
    } // end show_group()
    
    
    /**
    * Odczytaj cene produktu w. wybranych opcji
    *
    * @param float  $price_brutto cena produktu
    * @param string $xml_options  wartosc pola xml_options produktu
    * @return float cena brutto produktu wg. wybranej opcji
    * @public
    */
    function price($price_brutto,$xml_options='') {
        global $_REQUEST;
        
        if (! empty($xml_options)) $options=&$xml_options;
        else return $price_brutto;
        
        $this->data=&$options;
        
        // parsuj XML
        $this->parse();
        
        reset($this->tab_data);
        foreach ($this->tab_data as $tab) {
            $name=$tab[0];
            $values=$tab[1];
            foreach ($values as $value) {
                if (ereg("^(\s)*".$_REQUEST["options"][$name]."(\s)*\[[0-9]+\]$",$value)) {
                    $price_brutto=$this->get_price($value);
                }
            } // end foreach
        } // end foreach
        
        return $price_brutto;
    } // end price()
    
    /**
    * Sprawdz czy dany typ danych mozna edytowac w formie uproszczonej (wprowadzajac dane do polaa <input ...>
    *
    * @access public
    * @return boll   true - uproszczona edycja jest dostepna, false w p.w.
    */
    function checkSimpleEdit() {
        return false;
    } // end checkSimpleEdit()
    
} // end class group

class MyXMLOptions extends XMLGroups {};
$my_xml_options = new MyXMLOptions;

?>
