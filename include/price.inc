<?php
/**
 * Klasa odpowiadajace za dopasowanie odpowiedniej ceny do produktu w
 * zaleznosci np. od czy uzytkwonik jest odbiorca hurtowym, stalym klientem
 * itp.
 * Jest tu takze obliczana cena produktu na podstwie kursu waluty oraz rabat.
 *
 * @author m@sote.pl
 * @version $Id: price.inc,v 1.1 2007/04/13 14:13:35 tomasz Exp $
* @package    include
 */

class MyPrice {
    var $discount=0;          // rabat nadany przy obliczniu ceny z rabatem

    /**
     * Odczytaj cene produktu.
     *
     * @param addr $result wskaznik wyniku zapytania z bazy danych
     * @param int $row wiersz odpowiedzi z bazy danych
     * @param float $price_brutto cena zakupu
     * @param float $price_currency cena w walucie (opcjonalnie np. przy atrybutach)
     * @param bool $withdiscount czy obliczac cene z rabatem
     * @return real cena zakupu produktu w sklepie
     */ 
    function price(&$result,$row=0,$price_brutto='',$price_currency='',$withdiscount=true) {
        global $db;
        global $_SESSION;
        global $theme;
        global $config;
        global $shop;

        // wyzeruj rabat, tak ¿eby nie by³ powielany dla innych produktów
        $this->discount=0;

        if (empty($price_brutto)) {
            // cena brutto zakupu towaru
            $price_brutto=$db->FetchResult($result,$row,"price_brutto");
        }

        // cena hurtowa
        $shop->currency();
        $price_brutto_2=$db->FetchResult($result,$row,"price_brutto_2");
        $id_currency=$db->FetchResult($result,$row,"id_currency");
        $price_brutto_2=$shop->currency->change($price_brutto_2,$id_currency,1);
        
        if ((! empty($_SESSION['global_firm_login'])) || (($config->cd==1) && ($config->cd_setup['hurt']==1))) {
            // zalogowany jest odbiorca hurtowy
            if ($price_brutto_2>0) {
                return $price_brutto_2;
            } elseif ($price_brutto>0) {
                return $price_brutto;
            } else return 0;
        }

        // sprawdz walute
        if (in_array("currency",$config->plugins)) {
            // odczytaj cene walucie i id waluty
            if (empty($price_currency)) {
                $price_currency=$db->FetchResult($result,$row,"price_currency");
            }
            $id_currency=$db->FetchResult($result,$row,"id_currency");
            
            if (empty($config->currency_data[$id_currency])) {
                if ($shop->admin) {
                    print ("Error: Unknown value: \$config->currency_data[$id_currency] <br />\n");
                }
                return;
            }


            $vat=$db->FetchResult($result,$row,"vat");
            if ($vat>0) {
                if ($id_currency>1) {
                    $price_netto=$price_currency*$config->currency_data[$id_currency];
                    $price_brutto=$price_netto*(1+($vat/100));
                }
            } elseif ($vat==0) {
                if ($id_currency>1) {
                    $price_netto=$price_currency*$config->currency_data[$id_currency];
                    $price_brutto=$price_netto;
                }
            } else {
                // brak danych w polu vat
                $price_brutto=0;
            }
        } // end if
        
        // funkcja obliczajaca rabaty dla danego produktu
        // wylaczona z ciala $this->price do wykorzystywania przez inne klasy
        if ($withdiscount) {
        	$this->get_discount($result,$row);
        } else $this->discount=0;
        // oblicz nowa cene brutto umniejszona o rabat
        $new_price=$price_brutto*(1-($this->discount/100));

        //return $theme->price($new_price);
        return $new_price;
    } // end price()

    /**
     * Oblicz rabat do tego produktu
     * Funkcja wylaczona z $this->price
     *
     * @param resource $result wskaznik do wyniku zapytania bazy danych
     * @param int $row rzad ktory nas interesuje
     */
    function get_discount(&$result,$row=0) {
    	global $config;
    	global $db;
        // start RABATY:
        if ((in_array("discounts",$config->plugins)) && (! empty($_SESSION['__id_discounts_groups']))) {
            // sprawdz rabat dla klienta, kategorii, producenta
            global $discounts;
            require_once ("include/discounts.inc");
            if (! is_object($discounts)) $discounts = new Discounts;

            // start generuj IDC:
            $idc="";
            for ($i=1;$i<=5;$i++) {
                if ($db->FetchResult($result,$row,"id_category$i")>0) {
                    $idc.=$db->FetchResult($result,$row,"id_category$i")."_";
                }

            } // end for
            $idc=substr($idc,0,strlen($idc)-1);
            // end generuj IDC:

            // id producenta
            $id_producer=$db->FetchResult($result,$row,"id_producer");

            // przypisz rabat (jesli rabat dla danej kategorii czy uzytkwonika nie jest przypisany)
            $this->discount=$discounts->gen($idc,$id_producer);
        }

        // jesli nie ma zadnego rabtu dla kleinta, to sprawdz czy jest jakis rabat dla produktu
        //
        // sprawdz rabat dla produktu, kupowanego przez internet
        // rabat ten jest wykorzystywany w sytuacji, kiedy produkty kupowane przez internet maja nizsza cene
        // w info jest prezentacja ceny tradycyjnej i przez internet
        $discount=$db->FetchResult($result,$row,"discount");

        // jesli rabat dla danego produktu jest wiekszy niz rabat dla danego klienta/grupy to
        // produkt otrzyma rabat wyzszy. Chodzi o unikniecie sytuacji, kiedy bez zalogowania sie
        // jest wiekszy rabat na produkt niz dla osoby zarejetrowanej w jakiejs grupie rabatowej
        if ($discount>$this->discount) $this->discount=$discount;

        // sprawdz rabat progowy dla danego produktu; calkowity rabat dla produktu nie moze byc wiekszy niz rabat progowy
        $max_discount=$db->FetchResult($result,$row,"max_discount");

        if (empty($max_discount))
        {
           $this->discount = 0;
        }
        else
        {
           if ($this->discount > $max_discount)
           {
              $this->discount=$max_discount;
           }
        }
        // end RABATY:
    }
    /**
      * Zamien cene netto na brutto
      * 
      * @param  float $price_netto cena netto
      * @param  int   $vat         VAT
      * @param  bool  $change_number_format formatuj wynik w postaci xxx.yy wg $theme->price()
      * @return float cena brutto
      */
    function netto2brutto($price_netto=0,$vat=0,$change_number_format=true) {
        global $theme;
        if ($change_number_format==true) {
            return $theme->price(($price_netto*(100+$vat))/100);
        } else return (($price_netto*(100+$vat))/100);
    } // end netto2brutto()


    /**
      * Zamien cene brutto na netto
      * 
      * @param  float $price_netto          cena brutto
      * @param  int   $vat                  VAT
      * @param  bool  $change_number_format formatuj wynik w postaci xxx.yy wg $theme->price()
      * @return float cena netto
      */
    function brutto2netto($price_brutto=0,$vat=0,$change_number_format=true) {
        global $theme;
        if ($change_number_format==true) {
            return $theme->price(($price_brutto/(100+$vat))*100);
        } else return (($price_brutto/(100+$vat))*100);
    } // end netto2brutto()

    /**
     * Oblicz cene w promocji (promotions)
     *
     * @param float $amount kwota do zaplaty
     *
     * @access public
     * @return float cena po rabacie| void
     */
    function promotionsAmount($price=0) {
        global $_SESSION;
        global $theme;

        if ($price==0) return (0);
        if (! empty($_SESSION['__promotions'])) {
            $__promotions=$_SESSION['__promotions'];

            $new_price=$theme->price($price*((100-$__promotions['discount'])/100));
            if ($new_price>0) return $new_price;
        }

        return $price;
    } // end promotionsAmount

} // end class MyPrice
// na koncu nie mo¿e byæ ¿adnych znaków
?>
