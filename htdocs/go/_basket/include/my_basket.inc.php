<?php
/**
* Obsluga koszyka, obliczanie sumy zakupow, prezentacja koszyka itp.
*
* @author  m@sote.pl
* @version $Id: my_basket.inc.php,v 1.3 2006/11/29 22:43:57 tomasz Exp $
*
* @package    basket
* \@lang
*/

/**
* Podstawowa klasa obs³ugi koszyka.
*/
require_once ("lib/Basket/basket.php");

/**
* Klasa obs³ugi t³umaczeñ
*/
require_once ("include/lang_functions.inc");

/**
* G³ówna klasa zwi±zana obs³ug± koszyka. Do tej klasy odwo³uj± siê funkcje, korzystaj±ce z danych zawarto¶ci
* koszyka. W odró¿nieniu od klasy Basket, klasa ta spe³nia g³ównie funkcje zwi±zane z prezentacj± i
* dostêpem do informacjio zawarto¶ci koszyka.
*
* @package basket
* @subpackage basket
*/
class MyBasket extends Basket {
    
    /**
    * Wartosc calego zamowienia
    * @var float
    */
    var $amount=0;
    
    /**
    * Zawartosc calego koszyka, w stosunku do zmiennej z klasy Basket, tablica
    * ta zaweira dodatkowe informacje o produkcie m.in. cenê netto, sumê - warto¶æ danego produktu * ilo¶æ
    * @var array
    */
    var $items=array();
    
    /**
    * Zawartosc koszyka w formacie TXT
    * @var string
    */
    var $basket_data_txt="";
    
    /**
    * Rodzaj prezentacji koszyka;
    * @var string "form"  - wstaw pola formularza, "text"  - tylko informacja
    */
    var $display="form";
    
    /**
    * Konstruktor
    */
    function MyBasket() {
        global $_SESSION;
        
        if (! empty($_SESSION['global_basket_data'])) {
            $basket_data=$_SESSION['global_basket_data'];
            $this->items=$basket_data['items'];
            $this->_count=$basket_data['count'];
        }
        
        return;
    } // end MyBasket()

    // {{{ empty_basket()
    
    /**
    * Oproznij koszyk
    *
    * @access public
    * @return none
    */
    function empty_basket() {
        $this->amount=0;
        $this->_item=array();
        $this->items=array();
        $this->basket_data_txt="";
        return(0);
    } // end empty_basket()
    
    
    // }}}
    
    // {{{ amount()
    
    /**
    * Wartosc calego zamowienia, bez kosztow dostawy
    *
    * @access public
    * @return float  wartosc zamowienia
    */
    function amount() {
        global $_SESSION;
        if (@$_SESSION['global_basket_amount']>0) {
            return $_SESSION['global_basket_amount'];
        } else return 0;
    } // end amount()
    
    // }}}
    
    // {{{ totalAmount()
    
    /**
    * Warto¶æ zamówienia wraz z kosztami dostawy
    */
    function totalAmount() {
        global $_SESSION;
        if ($_SESSION['global_delivery']['cost']>0) {
            return $this->amount()+$_SESSION['global_delivery']['cost'];
        } else return $this->amount();
    } // end totalAmount()
    
    // }}}
    
    /**
    * Uaktualnij dane w koszyku, uporzadkuj kolejnosc elementow
    * oblicz wartosc zakupow, uaktuanij ilosc elementow w koszyku.
    *
    * @access public
    * @return float warto¶æ zakupów
    */
    function calc() {
        global $theme;
        global $delivery_obj;
        
        $this->amount=0;
	$this->num=0;
	$this->weight=0;
	$this->euro_2012_promo = false;
	$this->euro_2012_modify_row = false;	 

        if ($this->count()==0) return;
        
        foreach ($this->items as $id=>$item) {
            //TZ
	    //EURO 2012 promocje
	    if($item['ID'] == '9574')
            {
		$this->euro_2012_promo = true;
		$this->euro_2012_amount = $item['price'];
	    }
            $this->amount+=($item['price']*$item['num']);
            $this->num+=intval($item['num']);
            $this->items[$id]['price_netto']=$theme->price($item['price']/((100+$item['data']['vat'])/100));
            $this->items[$id]['sum_brutto']=$theme->price($item['price']*$item['num']);
            $this->items[$id]['price']=$theme->price($this->items[$id]['price']);
            
            // opcje dot. zgodno¶ci z poprzedni± werj± koszyka
            $this->items[$id]['user_id']=$this->items[$id]['data']['user_id'];
            $this->items[$id]['vat']=$this->items[$id]['data']['vat'];
            $this->items[$id]['price_brutto']=$this->items[$id]['price'];
            $this->items[$id]['options']=@$this->items[$id]['data']['options'];
            $this->weight+=(@$this->items[$id]['data']['weight']*$item['num']);
            // end
        }
        //print "weight".$this->weight;
        $delivery_obj->weight=$this->weight;

	if($this->euro_2012_promo == true and $this->amount >= 300)
	{
	  $this->amount -= $this->euro_2012_amount;
	  $this->euro_2012_modify_row = true;	  
	}	


        return $this->amount;

    } // end calc()
    
    /**
    * Pokaz linki do kategorii w ktorej dodano produkt
    *
    * \@global array  $__add_basket_category tablica z danymi kategorii i producenta dodawanego
    *                                       do koszyka produktu
    */
    function add_category_links() {
        global $__add_basket_category;
        global $lang;
        global $category_lang;
        
        $idc1="id_";$idc="";$url="";
        
        if (! empty($__add_basket_category['category1'])) {
            $url="idc=id_".$__add_basket_category['id_category1'];
            $category_lang=$__add_basket_category['category1'];
            LangF::translate($category_lang);
            print "<b>$lang->basket_continue_in_category:</b> <a href=/go/_category/?$url>".$category_lang."</a>";
        }
        
        if (! empty($__add_basket_category['category2'])) {
            for ($i=1;$i<=5;$i++) {
                if ($i>1) {
                    $url.=$__add_basket_category["id_category$i"]."_";
                    $url2=substr($url,0,strlen($url)-1);
                    if (! empty($__add_basket_category["category$i"])) {
                        $category_lang=$__add_basket_category['category'.$i];
                        LangF::f_translate($category_lang);
                        print "> <a href=/go/_category/?$url2>".$category_lang."</a> ";
                    }
                } else {
                    $url="idc=".$__add_basket_category["id_category$i"]."_";
                }
            } // end for
        } // end if
        
        
        return(0);
    } // end add_category_links()
    
    /**
    * Sprawd¼ czy koszyk jest pusty.
    *
    * @return bool   true - koszyk jest pusty, false w p.w.
    */
    function isEmpty() {        
        if (empty($this->items)) {
            if ($this->amount()>0) {
                return false;
            }
            return true;
        }
        return false;
    } // end isEmpty()
    
    /**
    * Formularz z zawartoscia koszyka.
    * Wyswo³anie funckji powoduje wy¶wietlenie na stronie koszyka + elementów formularza (zmiana ilo¶ci).
    * Funkcja wywo³uje tabelke z opisem oraz pe³ny formularz <form> ... </form>. WY¶wietlane te¿ s±
    * informacje o dostawie i promocjach, które mo¿na wybraæ w koszyku.
    *
    * @return wartosc zamowienia, bez kosztow dostawy
    * \@global object $basket        obiekt klasy Basket
    * \@global object $delivery_obj  obiekt z klasy Delivery
    */
    function showBasketForm() {
        global $theme;
        global $lang;
        global $delivery_obj;
        global $global_basket_calc_button;

        // je¶li koszyk jest pusty to poka¿ odpowiedni komunikat
        if (empty($this->items)) {
            $theme->basket_empty();
            return;
        }
        // Je¶li koszyk jest w formie do wydruku, to nie wyswietlaj paska i przycisku
        global $config;
        if ($config->theme!='print'){
        // pasek "bar" koszyka
        //$theme->bar($lang->basket_bar_title);
        
        print "<p>\n";
        print "<div class=\"block_1\">\n";
        print "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
        print "  <tr>\n";
        print "    <td valign=\"top\" align=\"left\">";
        // button kontynuuj zakupy
        $theme->button($lang->basket_order_continue,"/",220);
        print "</td>\n";
        print "  </tr>\n";
        print "</table>\n";
        print "<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
        print "  <tr>\n";
        print "    <td>\n";
        // pokaz kategorie dodawanego produktu - linki do ketegorii
        $this->add_category_links();
        print "<td>\n";
        print "  </tr>\n";
        print "</table>\n";
        print "</div>\n";
        }
        
        $theme->theme_file("basket_up.html.php");
        if ($this->display=="form") {
            print "<form action=\"index.php\" method=\"post\" name=\"basketForm\">\n";
        } // end niewydruk
        
        // start koszyk lista produktów
        // Jesli 
        // jesli koszyk jest do wydruku to nie rób odstêpów pomiêdzy wierszami
        if ($config->theme!='print'){
        print  "<table border=\"0\" cellspacing=\"2\" cellpadding=\"2\" align=\"center\" width=\"100%\">\n";
        }else{
        print  "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" width=\"100%\">\n";	
        }
        print "<pre>";
        print_r (debug_backtrace());
        print "</pre>";
        $theme->basket_th($this->display);
        
        /* uaktualnij warto¶c zakupów i dodatkowe dane prodyuktów */
        $this->calc();
        
        // wy¶wietl pozycje z koszyka w wierszach
        reset($this->items);
        foreach ($this->items as $id=>$item) {
            // print "<pre>";print_r($item);print "</pre><hr>\n";
            $this->_row($id,$item);
        }
        
        print "</table>\n";
        // end koszyk lista produktów
        
        if (! empty($global_basket_calc_button)) {
            // przycisk podsumuj
            print "<div align=\"right\">";
            $theme->calc_button();
            print "</div>";
            
        }
        
        if ($this->display=="form") {
            // pokaz: suma zamowienia, podsumuj wprowadzone zmiany, zaplac, powrot
	        $delivery_obj->show_country();
           	$delivery_obj->show();
           	$this->order_amount=$this->amount+$delivery_obj->delivery_cost;
           	$theme->basket_submit($theme->price($this->amount),$theme->price($this->order_amount),
           	$delivery_obj->delivery_name,$delivery_obj->delivery_cost);
            print "</form>\n";
            
            // pokaz dostepne promocje
            global $config;
            if (in_array("promotion",$config->plugins)) {
                $theme->showPromotions();
            }
        } else {
            print "<p>";
        }
        
        return $this->amount;
    } // end showBasketForm()
    
    /* @see showBasketForm()  */
    function show_form() {
        return $this->showBasketForm();
    } // end show_form()

    function show_form_mikran_add() {
       return $this->showBasketFormLimited();
    } // end show_form()
    
    
    /**
    * Przedstaw pozycje/wiersz z koszyka w formacie html
    *
    * @param int   $id   id systemowe koszyka, pozycja w koszyku
    * @param array $item dane dot. produktu
    *
    * @access private
    * @return none
    */
    function _row($id,$item) {
        global $theme, $config;
        
        // przet³umacz nazwê
        $name=$item['data']['lang_names'][$config->lang_id];
        
        // jesli koszyk jest do wydruku to nie wyswietlaj kolorów i usuñ
        if ($config->theme!='print'){
        
        print "<tr bgcolor=" . @$config->theme_config['colors']['basket_td'] . ">\n";
        print "<td>".$name;
        $id_pos='';
        if (! empty($item['data']['options'])) {
            $options=$item['data']['options'];
            $this->_showOptions($options,"html");
        }
        print "</td>\n";
        
        // start waluty:
        global $shop;
        $shop->currency();
        $item2=$item;
        if ($shop->currency->changed()) {            
            $item2['price']=$shop->currency->price($item2['price']);
            $item2['price_netto']=$shop->currency->price($item2['price_netto']);
            $item2['sum_brutto']=$shop->currency->price($item2['sum_brutto']);
        
        }        
        // end waluty:
        
        print "<td align=\"center\">".$item2['price_netto']."</td>\n";
        print "<td align=\"center\">".$item['data']['vat']."%</td>\n";
        print "<td align=\"center\">".$item2['price']."</td>\n";
        if ($this->display=="form") {
            print "<td align=\"center\">
            <input type=\"text\" size=\"2\" maxsize=\"6\" name=\"num[$id]\" value=\"".$item['num']."\"></td>\n";
        } else {
            print "<td align=\"center\">".$item['num']."</td>\n";
        }
        print "<td align=\"center\">".$item2['sum_brutto']."</td>\n";
        if ($this->display=="form") {
            print "<td align=\"center\">
            <input class=\"border0\" type=\"checkbox\" name=\"del[$id]\" onClick=\"this.form.submit();\"></td>\n";
        }
        print "</tr>\n";
        }else{
        	// jesli koszyk do wydruku to wy¶wietlaj 
        print "<tr><td><hr width=100%</td><td><hr width=100%</td><td><hr width=100%</td>
        <td><hr width=100%</td><td><hr width=100%</td><td><hr width=100%</td></tr>";	
        print "<tr bgcolor=>";
        print "<td>".$name;
        $id_pos='';
        if (! empty($item['data']['options'])) {
            $options=$item['data']['options'];
            $this->_showOptions($options,"html");
        }
        print "</td>\n";
        
        // start waluty:
        global $shop;
        $shop->currency();
        $item2=$item;
        if ($shop->currency->changed()) {            
            $item2['price']=$shop->currency->price($item2['price']);
            $item2['price_netto']=$shop->currency->price($item2['price_netto']);
            $item2['sum_brutto']=$shop->currency->price($item2['sum_brutto']);
        
        }        
        // end waluty:
        
        print "<td align=\"center\">".$item2['price_netto']."</td>\n";
        print "<td align=\"center\">".$item['data']['vat']."%</td>\n";
        print "<td align=\"center\">".$item2['price']."</td>\n";
        print "<td align=\"center\">".$item['num']."</td>\n";
        print "<td align=\"center\">".$item2['sum_brutto']."</td>\n";
       
        print "</tr>\n";
        	
        }
        return;
    } // end _row()
    
    /**
    * Przedstaw wybrane opcje produktu.
    *
    * @param array $data opcje produktu
    * @param array $type tryb prezentacji opcji produktu (txt,html)
    *
    * @access private
    * @return string|none
    */
    function _showOptions($data,$type) {
        $o="";
        if (is_array($data)) {
            reset($data);
            foreach ($data as $option) {
                $o.="$option ";
            }
        } else {
            $o.="$data";
        }
        
        if ($type=="txt") {
            return $o;
        } else {
            print "<br>".$o;
        }
        return(0);
    } // end _showOptions()
    
    /**
    * Przedstaw zawartosc koszyka w postaci TXT. Informacja ta zostanie dodana do
    * maila z zamowieniem
    *
    * @access public
    * @return string zwraca zawartosc calego goszyka w formacie TXT
    */
    function basket_txt() {
        global $lang;
        global $_SESSION;
        global $config;
        
        $this->calc();
        
        $global_delivery=$_SESSION['global_delivery'];
        $global_order_amount=$_SESSION['global_order_amount'];
        
        $this->basket_data_txt.=$lang->basket_txt_title.":\n";
        reset($this->items);$this->_pos=1;
        foreach ($this->items as $id=>$item) {
            $this->basket_data_txt.=$this->_rowTXT($item);
            $this->_pos++;
        }
        
        
        // start waluty:
        global $shop;
        $shop->currency();
        
        $curr_delivery_cost=$shop->currency->price($global_delivery['cost']);
        $curr_amount=$shop->currency->price($this->amount);
        $curr_order_amount=$shop->currency->price($global_order_amount);
        
        // end waluty:
        
        $o=$this->basket_data_txt;
        $o.="\n".$lang->basket_delivery_name.": ".$global_delivery['name'].", ";
        $o.=$lang->basket_delivery_cost.": ".$curr_delivery_cost." ".$shop->currency->currency."\n";
        $o.=$lang->basket_amount_name.": ".$curr_amount." ".$shop->currency->currency."\n";
        $o.=$lang->basket_order_amount_name.": ".$curr_order_amount." ".$shop->currency->currency."\n";
        
        global $shop;
        $shop->promotions();
        $o.=$shop->promotions->txtInfo();
        
        return $o;
    } // end basket_txt()

    function _headHTML()
    {
      global $lang;
      $o="<thead>";
      $o.="<tr class'basket_head_row'>";
      $o.="<th>".$lang->basket_elements['name']."</th>";
      $o.="<th>".$lang->basket_elements['mik_code']."</th>";
      $o.="<th>".$lang->basket_elements['price_netto']."</th>";
      $o.="<th>".$lang->basket_elements['vat']."</th>";
      $o.="<th>".$lang->basket_elements['num']."</th>";
      $o.="<th>".$lang->basket_elements['price_brutto']."</th>";
      $o.="<th>".$lang->basket_elements['sum_brutto']."</th>";
      $o.="</tr>";
      $o.="</thead>";

      return $o;
    }

    function _rowHTML($item) {
      global $lang;
        
      // przet³umacz nazwê produktu
      $name=LangF::name($item['name']);
      global $config;
      $href='/'.$config->lang.'/id'.$item['ID'].'/'.$name;
      $urlcheck = new EncodeUrl;
      $encoded = $urlcheck->encode_url_category($name);

      $host = "http://www.sklep.mikran.pl";
      $href = $host."/$config->lang/id".$item['ID']."/".$encoded;

      $o.="<tr class='basket_row'>";
      $o.="<td><a href='".$href."'>".$name."</a>";

      if (! empty($item['data']['options'])) {
	$data=$item['data']['options'];
	$o.="<br>".$this->show_options($data,"txt");
      }

      $o.="</td>";

      // start waluty:
      global $shop;
      $shop->currency();
      if ($shop->currency->changed()) {
	$item['price']=$shop->currency->price($item['price']);
	$item['price_brutto']=$shop->currency->price($item['price_brutto']);
	$item['price_netto']=$shop->currency->price($item['price_netto']);
	$item['sum_brutto']=$shop->currency->price($item['sum_brutto']);
      }
      // end waluty:

      $o.="<td><a href='".$href."'>".$lang->basket_elements['mik_id'].$item['ID']."</a></td>";
      $o.="<td style='text-align:center'>". $item['price_netto']." ".$shop->currency->currency."</td>";
      $o.="<td style='text-align:center'>". $item['data']['vat']." %</td>";
      $o.="<td style='text-align:center'>". $item['num']."</td>";
      $o.="<td style='text-align:center'>". $item['price_brutto']." ".$shop->currency->currency."</td>";
      $o.="<td style='text-align:center'>". $item['sum_brutto']." ".$shop->currency->currency."</td>";

      $o.="</tr>";

      return $o;
    }
    
    /**
    * Dane rekordu z koszyka w postaci TXT
    *
    * @param array $item dane produktu
    *
    * @access private
    * @return string dane produktu w TXT
    */
    function _rowTXT($item) {
        global $lang;
        
        // przet³umacz nazwê produktu
        $name=LangF::name($item['name']);
        
        $o="";
        $nr=$this->_pos;
        $o.="$nr ".$lang->basket_elements['name'].": ".$name;
        if (! empty($item['data']['options'])) {
            $data=$item['data']['options'];
            $o.=$this->show_options($data,"txt");
        }
        
        // start waluty:
        global $shop;
        $shop->currency();
        if ($shop->currency->changed()) {
            $item['price']=$shop->currency->price($item['price']);
            $item['price_brutto']=$shop->currency->price($item['price_brutto']);
            $item['price_netto']=$shop->currency->price($item['price_netto']);
            $item['sum_brutto']=$shop->currency->price($item['sum_brutto']);
        }
        // end waluty:
        
        $o.="\n";
        $o.="\t".$lang->basket_elements['user_id'].": ".$lang->basket_elements['mik_id'].$item['ID']."\n";
        $o.="\t".$lang->basket_elements['price_netto'].": ".$item['price_netto']." ".$shop->currency->currency."\n";
        $o.="\t".$lang->basket_elements['vat'].": ".$item['data']['vat']."\n";
        $o.="\t".$lang->basket_elements['num'].": ".$item['num']."\n";
        $o.="\t".$lang->basket_elements['price_brutto'].": ".$item['price_brutto']." ".$shop->currency->currency."\n";
        $o.="\t".$lang->basket_elements['sum_brutto'].": ".$item['sum_brutto']." ".$shop->currency->currency."\n\n";
        
        return $o;
    } // end _row_txt()
    
    /**
    * Generuj opis skrócony zamówienia.
    *
    * @return string opis skrocony zmowienia
    */
    function orderDescription() {        
        $o="ID: ".$_SESSION['global_order_id'].", ";
        foreach ($this->items as $item) {
            $o.=$item['name']."; ";
        }
        $o=substr($o,0,strlen($o)-2);
        
        return $o;
    } // end orderDescription()
    
    /**
    * @ignore
    */
    function order_description() {
        return $this->orderDescription();
    } // end order_description()
    
    
    /**
    * Zarejestruj dane zwi±zane z koszykiem w sesji
    *
    * \@global float $global_basket_amount warto¶c produktów w koszyku
    * \@global float $global_order_amount  warto¶æ zamówienia z koszyami dostawy
    * \@global int   $global_basket_count  ilo¶c produktów w koszyku
    * \@global array $global_basket_data   pe³na zawarto¶æ koszyka, która jest zapamiêtywana w sesji
    *
    * @return none
    */
    function register() {
        global $sess,$_SESSION;
        global $global_basket_amount,$global_basket_count,$global_order_amount,$global_basket_data;
        
        // mozliwe, ze wprowadzono zmiany, uaktualnij wartosc zakupow i ilo¶æ wszystkich produktów
        $this->calc();
        
        // zapisz wartosc zakupow i ilo¶c produktów
        $global_basket_amount=$this->amount;
        $global_basket_count=$this->num;
        
        $sess->register("global_basket_amount",$global_basket_amount);
        $sess->register("global_basket_count",$global_basket_count);
        
        // zapamiêtaj stan koszyka w sesji
        $global_basket_data=array("items"=>$this->items,"count"=>$this->getCount());
        $sess->register("global_basket_data",$global_basket_data);
        
        if (! empty($_SESSION['global_delivery'])) {
            $global_delivery=$_SESSION['global_delivery'];
        }
        
        // kwota do zaplazy z kosztami dostawy
        $global_order_amount=$global_delivery['cost']+$global_basket_amount;
        $sess->register("global_order_amount",$global_order_amount);
        
        return;
    } // end register()
    
    
    /**
    * Przedstaw wybrane opcje produktu
    *
    * @param array $data opcje produktu
    * @param array tryb prezentacji opcji produktu (txt,html)
    *
    * @access public
    * @return string|none
    */
    function show_options($data,$type) {
        $o="";
        if (is_array($data)) {
            reset($data);
            foreach ($data as $option) {
                $o.=", $option ";
            }
        } else {
            $o.="$data";
        }
        
        if ($type=="txt") {
            return $o;
        } else {
            print "<br>".$o;
        }
        return(0);
    } // end show_options()
    
} // end class MyBasket
?>
