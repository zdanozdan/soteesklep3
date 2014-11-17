<?php
/**
* Klasa zwiazana z obsluga walut w sklepie
*
* @author  m@sote.pl
* @version $Id: currency.inc,v 2.19 2005/04/01 12:55:16 maroslaw Exp $
* $Log: currency.inc,v $
* Revision 2.19  2005/04/01 12:55:16  maroslaw
* ""
*
* Revision 2.18  2005/01/07 09:43:42  maroslaw
* ""
*
* Revision 2.16  2004/12/29 14:05:55  krzys
* no message
*
* Revision 2.15  2004/12/20 18:02:50  maroslaw
* no message
*
* Revision 2.14  2004/10/27 07:53:44  maroslaw
* ""
*
* @package    include
*/

/**
* Zmieñ dzia³anie funkcji Currency2:price(), pomnó¿ cenê razy kurs, domy¶lnie cena jest dzielona przez kurs.
*/
define ("CURRENCY_REVERSE",1);

class Currency2 {
    // @dep $config->currency_name id->nazwa
    // @dep $config->currency_data id->kurs

    /**
    * @var int $price_raw je¶li warto¶æ 1, to warto¶æ nie zaokr±glaj wyniku  obliczania ceny w funkcji Currency2::price()
    */
    var $price_raw=0;    

    /**
    * @var int id aktualnie wy¶wietlanej w skelpie waluty
    */
    var $id_currency=1;
    
    /**
    * Konstruktor
    */
    function Currency2() {
        global $config,$_SESSION;

        $this->currency=$config->currency;

        if (@$_SESSION['__currency']>1) {
            $__currency=$_SESSION['__currency'];
            $this->id_currency=$__currency;
        } else return(0);

        if (! empty($config->currency_name[$__currency])) {
            $this->currency=$config->currency_name[$__currency];
        }

        return(0);
    }  // end Currency()

    /**
    * Funkcja sprawdzaj±ca, czy jest wybrana jaka¶ waluta inna od domyslnej
    * @return bool true - zmieniono walutê, false -  nie zmieniono waluty
    */
    function changed() {
        global $_SESSION;
        if (@$_SESSION['__currency']>1) {
            return true;
        } else return false;
    } // end changed()

    /**
    * Lista dostêpnych w sklepie walut do wyboru
    * @return none
    */
    function currencyList() {
        global $config,$lang;
        global $_SESSION;

        if ($config->cd==1) return;


        if (((@$config->catalog_mode==0) && (@$config->currency_show_form==1))||((@$config->catalog_mode==1)&&(@$config->catalog_mode_options['currency']==1))) {
            if (! empty($_SESSION['__currency'])) {
                $default=$_SESSION['__currency'];
            } else $default='';

            require_once ("HTML/Form.php");
            $form = new HTML_Form($config->url_prefix."/plugins/_currency/index.php");
            $attrib="onChange=\"this.form.submit();\"";
            $form->addSelect("currency",$lang->currency_select,$config->currency_name,$default,1,'',false,$attrib);
            $form->display();
            return;
        }
    } // end currencyList()

    // {{{ price()

    /**
    * Pokaz cene wybranej walucie, o ile jest ona inna od domyslnej
    *
    * @param float $price cena
    * @param int   $id_currency id waluty (opcjonalnie)
    * @param int   CURRENCY_REVERSE odwróæ liczenie waluty (/->*) (opcjonalnie)
    *
    * @access public
    * @return float  cena w walucie, false jesli jest error
    */
    function price($price) {
        global $_SESSION,$theme,$config;

        if (empty($price)) return 0;
        
        $args=func_get_args();
        if ((! empty($args[1])) && ($args[1]>0)) $__currency=$args[1];
        elseif (! empty($_SESSION['__currency'])) {
            $__currency=$_SESSION['__currency'];
        } else return $price;

        if ((! empty($args[2])) && ($args[2]==CURRENCY_REVERSE)) $type=CURRENCY_REVERSE;
        else $type=0;

        if (@$config->currency_data[$__currency]>0) {
            if ($type==CURRENCY_REVERSE) {
                $price_currency=$price*$config->currency_data[$__currency];
            } else {
                $price_currency=$price/$config->currency_data[$__currency];
            }

            if ($this->price_raw!=1) {
                $price_currency=$theme->price($price_currency);
            }
                        
            return $price_currency;
        }

        return $price;
    } // end price()

    // }}}

    // {{{ change()

    /**
    * Zmieñ warto¶æ ceny z waluty X na walutê Y
    *
    * @param float $price warto¶æ w walucie X
    * @param int   $id_currency1 waluita X
    * @param int   $id_currency waluta Y
    *
    * @return float warto¶æ w walucie Y (wiele miejsc po przecinku)
    */
    function change($price,$id_currency1,$id_currency2) {
        global $config;

        if ($id_currency1==$id_currency2) return $price;

        $this->price_raw=1;
        
        // sprawd¼ czy obie waluty s± zdefiniowane
        if ((! empty($config->currency_data[$id_currency1])) && (! empty($config->currency_data[$id_currency2]))) {
            if (($id_currency1==1) && ($id_currency2>1)) {
                $new_price=$this->price($price,$id_currency2);
            } elseif (($id_currency1>1) && ($id_currency2==1)) {
                $new_price=$this->price($price,$id_currency1,CURRENCY_REVERSE);                
            } elseif (($id_currency1>1) && ($id_currency2>1)) {
                $new_price_1=$this->price($price,$id_currency1,CURRENCY_REVERSE);                
                $new_price=$this->price($new_price_1,$id_currency2);
            } else $new_price=$price;

            $price=$new_price;
            
        }

        $this->price_raw=0;
        
        return $price;
    } // end change()

    // }}}


} // end class Currency2
?>
