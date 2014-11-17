<?php
/**
* Wybieranie atrybutow sposrod grup opcji, z mozliwoscia wybrania atrybutu zmieniajacego cene produktu
*
* @author m@sote.pl
* @version $Id: groups_txt.inc,v 2.3 2004/12/20 18:03:02 maroslaw Exp $
*
* show()
* @package    include
*/



class XMLGroups {
    var $data;
    var $gi=1;
    var $price=0;          // cena przetwarzanego atrybutu
    var $element;          // nazwa jw.
    var $elements=array(); // elementy pola select
    var $tab_data=array(); // nazwy pol i wartosci tablica postaci array("nazwa"=>array("wartosc1","wartosc2"))
    
    /**
    * Wywolanie prezentacji opcji
    *
    * @public
    */
    function show() {
        $this->parse(true);
        return;
    } // end show()
    
    /**
    * Parsuj XML, zapisz strukture XML do tablicy $this->elements
    *
    * @param bool $display czy wyswietlac elementy formularza HTML
    * @pubic
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
    * @return float cena odczytana z opcji
    */
    function get_price($element) {
        if (! ereg("\[[0-9.]+\]",$element)) {
            $this->element=$element;
            return;
        }
        
        preg_match("/^(.+)\[([0-9.]+)\]/",$element,$matches);
        $this->element=$matches[1];
        $this->price=my(@$matches[2]);
        
        return $this->price;
    } // end get_price()
    
    /**
    * Wyswietl tylko jeden element kazdego atrybutu
    * Wyswietlamy tylko jeden element kazdej z opcji bez listy rozwijanej
    *
    * \@global array $this->elements
    * \@global string $this->name
    * \@global string $this->title
    * @public
    */
    function show_group() {
        global $config;
        
        //wyswietlaj tylko atrybuty gdzie wystepuje element !
        if(! empty($this->elements['0'])) {
            print "<B>$this->title</B>: \n";
            reset($this->elements);
            
            foreach ($this->elements as $element) {
                $this->get_price($element);                   // odczytaj cene jesli jest podana w opcji "opcja[cena]"
                if ($this->price>0) {
                    print "<option value='".$this->element."'>".$this->element." ".$this->price." ".$config->currency."\n";
                    
                    $this->price=0;$element='';
                } else {
                    print "$element\n";
                }
            } // end foreach
            print "<br>";
        }
    } // end show_group()
    
    
    /**
    * Odczytaj cene produktu w. wybranych opcji
    *
    * @param float $price_brutto cena produktu
    */
    function price($price_brutto) {
        global $_REQUEST;
        
        if (empty($_REQUEST['options'])) return $price_brutto;
        $options=$_REQUEST['options'];
        
        // parsuj XML
        $this->parse();
        
        reset($this->tab_data);
        foreach ($this->tab_data as $tab) {
            $name=$tab[0];
            
            $values=$tab[1];
            foreach ($values as $value) {
                if (ereg("^(\s)*".$options[$name]."(\s)*\[[0-9]+\]$",$value)) {
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
