<?php
/**
* Funckje sprawdzajace poprawnosc danych z formularzy
*
* @author  m@sote.pl
* @version $Id: form_check.inc,v 2.24 2005/12/08 14:13:51 lukasz Exp $
* @package    include
*/

require_once ("Validate/Validate.php");

/**
 * Klasa FormCheck
 *
 * @package soteesklep2
 */
class FormCheck extends Validate {
    
    var $errors=array();         // komunikaty o bledach
    var $error_nr=-1;            // numer bledu
    var $check="false";          // domylsnie nie wywolano sprawdzania formularza
    var $max_string=255;         // maksymalna dlugosc pola tekstowego
    var $fun=array();            // lista funkcji klasy FormCheck ktore sprawdzaja poprawnosc pol np. array("pole"=>"funkcja",...)
    var $form=array();           // dane z formularza
    var $errors_found=array();   // tablica asocjacyjna zawierajaca informacje o znalezionych bledach
    
    // -- start lista funkcji:
    /**
    * Nie sprawdzaj pola
    *
    * @return bool true
    */
    function null() {
        return true;
    }
    
    /**
    * Sprawdz czy pole zawiera kwote pieniezna
    *
    * @param string $val wartosc pola
    * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
    */
    function price($val) {
        
        $val=ereg_replace(",",".",$val);
        
        if (ereg("^[0-9.]+$",$val)){
            return true;
        } else return false;
    }
    
    /**
    * Sprawdz czy pole jest typu procentowego 0-100%
    *
    * @param string $val wartosc pola
    * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
    */
    function vat($val) {
        if (ereg("^[0-9]+$",$val))
        if (($val>=0) && ($val<=100))
        return true;
        return false;
    }
    
    /**
    * Sprawdzenie czy wartosci pola jest liczba calkowita>0
    *
    * @param string $val wartosc pola
    * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
    */
    function int($val) {
        if (ereg("^[0-9]+$",$val))
        return true;
        $this->error_nr=1;
        return false;
    }
    
    /**
    * Dowolny ciag znakow
    *
    * @param string $val wartosc pola
    * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
    */
    function string($val) {
        if (! empty($val)) {
            if (strlen($val)>$this->max_string) {
                $this->error_nr=1;
                return false;
            } else return true;
        }
        $this->error_nr=0;
        return false;
    } // end string()

    /**
    * Dowolny ciag znakow - w tym 0
    *
    * @param string $val wartosc pola
    * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
    */
    function string0($val) {
        if (isset($val) && ($val != '')) {
            if (strlen($val)>$this->max_string) {
                $this->error_nr=1;
                return false;
            } else return true;
        }
        $this->error_nr=0;
        return false;
    } // end string()

    
    /**
    * Kraj
    *
    * @param string $val wartosc pola
    * @return bool true - poprawnie wypelnione pole, false - bledna wartosc
    */
    function country($val) {
        global $_SESSION, $_REQUEST;
        if(($val != @$_SESSION['global_country_delivery']) && ($_REQUEST['form']['cor_addr'] == 'yes')) {
            $this->error_nr=1;
            return false;
        }
        else {
            return true;
        }
    } // end country()

    // -- end lista funkcji:
    
    /**
    * Sprawdzenie czy formularz jest poprawnie wypelniony.
    * Jesli jakis blad zostal znaleziony, to informacja o bledzie
    * znajdowac sie bedzie w tablicy $this->error_found['nazwa_pola']
    *
    * \@global array $this->form tablica z danymi z pol formularza
    * \@global array $this->errors tablica z komuniakatami bledow;
    *                             wymagane elementy formularza
    * \@global string $this->fun nazwa funkcji testujace poprawnosc pola
    * @return [false|true] informacja czy formularz jest poprawnie wyswietlony
    */
    function form_test() {
        // if ($this->check!="true") return;
        
        $form_error=0;
        reset ($this->errors);
        while (list($name,$error) = each ($this->errors)) {
            
            $value=@$this->form[$name];
            $fun=$this->fun[$name];
            
            if (method_exists($this,$fun))  {
                if (! $this->$fun($value)) {
                    if (! empty($error)) {
                        if (is_array($error)) {
                            if (! empty($error[$this->error_nr])) {
                                $this->errors_found[$name]=$error[$this->error_nr];
                            } else {
                                $this->errors_found[$name]="Error";
                            }
                        } else {
                            $this->errors_found["$name"]=$error;
                        }
                        $form_error=1;
                    }
                }
            }
        } // end while
        
        if ($form_error==1) return false;
        return true;
    } // end form_test()
    
} // end class FormCheck
?>
