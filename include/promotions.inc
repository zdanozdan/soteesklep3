<?php
/**
* Prezentacjia zdefiniowanych przez sprzedawce promocji
*
* @author  m@sote.pl
* @version $Id: promotions.inc,v 2.10 2004/12/20 18:02:56 maroslaw Exp $
*
* @todo dodac obliczanie kwot zamowienia itp. w jednej funkcji zmiast w 2
*       teraz oddzielnie jest to liczone w elementach wyswietlajacych dane w txt i html
* @package    include
*/

require_once ("include/table.inc");
require_once ("HTML/Form.php");
require_once ("MetabaseData/DataForm.php");
require_once ("include/my_crypt.inc");

define ("PROMOTIONS_COLS",2); // liczba promocji w wierszu

class Promotions {
    
    /**
    * Wyswietl liste promocji
    *
    * @param array $data dane z zapyatnia SQL o liste promocji
    *
    * @access public
    * @return none
    */
    function showList(&$data) {
        global $lang;
        
        global $theme;
        if (empty($data)) {
            print "<center><b>$lang->promotions_not_found</b></center>\n";
            $theme->go2main(4);
            $theme->page_open_foot("page_open_1_foot");
            $theme->foot();
            exit;
        } else {
            print $lang->promotions_info."<p>";
        }
        reset(@$data);
        $table = new HTMLTable("100%","border=0");
        $table->setCols(PROMOTIONS_COLS);
        foreach (@$data as $dat) {
            $table->openField("valign=top");
            $this->_row($dat);
            $table->closeField();
        }
        $table->close();
        return(0);
    } // end showList()
    
    /**
    * Pokaz liste promocji + formularz do wpisania kodu promocji
    *
    * @access public
    * @return none
    */
    function basketForm() {
        global $config,$mdbd,$lang,$theme,$_SESSION,$config;
        
        if ($this->_promotionsExists()) {            
            $theme->frame_open($lang->promotions_title,"");
            // wy¶wietl link do dostêpnych promocji
            print "<center><a href=\"/plugins/_promotions/index.php\"><u>$lang->promotions_all</a></u></center><br />";
            $form =& new DataForm($mdbd,$config->url_prefix."/plugins/_promotions/active.php");
            $data=$mdbd->select("id,name","promotions","lang=?",array($config->lang=>"text"),"ORDER BY name LIMIT 100","ARRAY");
            $form->dbAddSelect($data,"id",$lang->promotions_select);
            $form->addText("code",$lang->promotions_code,'',16);
            $form->addSubmit("submit",$lang->promotions_submit);
            $form->display();
            $theme->frame_close();
        }
        return(0);
    } // end basketForm()
    
    /**
    * Pokaz info o rabatach w promocji w koszyku
    *
    * @access public
    * @return none
    */
    function basketInfo() {
        global $config,$theme,$DOCUMENT_ROOT;
        
        global $shop;
        $shop->basket();
        $shop->currency();
        
        if (in_array("discounts",$config->plugins)) {
            require_once ("include/price.inc");
            $my_price =& new MyPrice;
            if (! empty($_SESSION['__promotions'])) {
                if (@$_SESSION['global_delivery']['cost']>0) {
                    $this->delivery_cost=$_SESSION['global_delivery']['cost'];
                } else $this->delivery_cost=0;       
                $price=$my_price->promotionsAmount($shop->basket->amount());          // kwota zamoweinia w 1 (np. PLN)
                $this->amount=$shop->currency->price($price);                         // kwota zamowienia w walucie
                $this->total_amount=$price+$this->delivery_cost;                      // wartosc zamowienia w 1 
                $this->curr_total_amount=$shop->currency->price($this->total_amount); // wartosc zamowienia w walucie
                $this->promotions=$_SESSION['__promotions'];
                $file="_promotions/promotions_basket_amount.html.php";
                include ("$DOCUMENT_ROOT/themes/include/theme_file.inc.php");
            }
        }
        
        return(0);
    } // end basketInfo()
    
    
    /**
    * Pokaz info o rabatach promocji w trybie TXT (dla zamowienia)
    *
    * @access public
    * @return string info o promocji
    */
    function txtInfo() {
        global $config,$theme,$DOCUMENT_ROOT,$_SESSION,$shop,$lang;
        
        $o='';
        if (in_array("discounts",$config->plugins)) {
            $o.="\n";
            require_once ("include/price.inc");
            $my_price =& new MyPrice;
            if (! empty($_SESSION['__promotions'])) {
                $this->promotions=$_SESSION['__promotions'];
                $shop->basket();
                                
                $o.="\n".$lang->promotions_basket_name.": ".
                @$_SESSION['__promotions']['name']."\n";
                $o.=$lang->promotions_basket_amount.": ";

                $price=$my_price->promotionsAmount($shop->basket->amount());                
                $o.=$shop->currency->price($price)." ".$shop->currency->currency;                

                $o.=" (".$lang->promotions_basket_discount.":".
                @$_SESSION['__promotions']['discount']."%)\n";                
                                
                if (@$_SESSION['global_delivery']['cost']>0) {
                    $delivery_cost=$_SESSION['global_delivery']['cost'];
                } else $delivery_cost=0;                
                $total_amount=$price+$delivery_cost;
                $curr_total_amount=$shop->currency->price($total_amount);
                
                $o.=$lang->promotions_order_amount.": ";
                $o.=$curr_total_amount." ".$shop->currency->currency;
                if ($shop->currency->changed()) {
                    $o.=" ($total_amount $config->currency)";                
                }
                $o.="\n\n";
            }
        }
        
        return $o;
    } // end txtInfo()
    
    /**
    * Sprawdz czy jest zdefiniowana jakas aktywna promocja.
    * Je¶li s± dostêpne promocje, a zalogowany klient jest przypisany
    * do grupy rabatowej, to promocje nie bêd± aktywne
    * 
    * @access private
    * @return bool    true-jest zdefiniowana conajmniej 1 aktywna promocja, user nie jest w grupie rabatowej, false w p.w
    *
    * @todo dodac definiowanie roznych promocji do roznych krajów
    */
    function _promotionsExists() {
        global $mdbd,$config;
        
        global $_SESSION;
        if (! empty($_SESSION['__id_discounts_groups'])) return false;
                
        if ($mdbd->select("id","promotions","active=1 AND lang=?",array($config->lang=>"text"),"LIMIT 1")>0) return true;
        return false;
    } // end _promotionsExists()
    
    /**
    * Wyswietl "wiersz" prezentacji promocji
    *
    * @param array $dat dane promocji
    *
    * @access private
    * @return none
    */
    function _row($dat) {
        global $theme;
        $theme->data=&$dat;
        $theme->theme_file("_promotions/promotions_row.html.php");
        return(0);
    } // end _row()
    
    /**
    * Informacja szczegolowa o promocji
    *
    * @param array $data dane promocji
    *
    * @access public
    * @return none
    */
    function info(&$data) {
        global $theme;
        $theme->data=&$data;
        $theme->theme_file("_promotions/promotions_info.html.php");
        $this->_form($data);
        return(0);
    } // end info()
    
    /**
    * Formularz do wprowadzenia kodu promocji
    *
    * @param array $data dane promocji
    *
    * @acces private
    * @return none
    */
    function _form(&$data) {
        global $lang;
        $form = new HTML_Form("active.php","POST");
        $form->addText("code",$lang->promotions_code_info,"",16);
        $form->addHidden("id",$data['id']);
        $form->addSubmit("submit",$lang->next);
        $form->display();
        return(0);
    } // end _form()
    
    /**
    * Sprawdz, czy kod [promocji podany przez uzytkownika jest prawidlowy
    *
    * @param array $data dane promocji
    *
    * @access public
    * @return bool true - kod poprawny, false w p.w.
    */
    function checkCode(&$data,$code) {
        if (empty($code)) return false;
        $my_crypt = new MyCrypt;
        for ($i=1;$i<=10;$i++) {
            $db_code=$data["code$i"];
            $crypt_code=$my_crypt->endecrypt("",$db_code,"de");
            if ($crypt_code==$code) return true;
        }
        return false;
    } // end checkCode()
    
    /**
    * Poprawna autoryzacja, aktywuj promocje
    *
    * \@session array $__promotions dane promocji wybranej przez klienta
    *
    * @acces public
    * @return none
    */
    function authTrue(&$data) {
        global $__promotions;
        global $sess,$theme;
        global $_SESSION;
        
        if ($data['discount']>0) {
            $__promotions['discount']=$data['discount'];
            $__promotions['id']=$data['id'];
            $__promotions['name']=$data['name'];
            $sess->register("__promotions",$__promotions);
            if ((! empty($_SESSION['__id_discounts_groups']))  || (! empty($_SESSION['global_firm_login']))) {
                // oproznij koszyk, bo w koszyku moga byc produkty zakupione po nizszych cenach
                // wynikajacych z grupy rabatowej
                $sess->unregister("basket");$sess->unregister("my_basket");
                $sess->unregister("global_basket_amount");
                $sess->unregister("global_basket_count");
                $sess->unregister("__id_discounts_groups");
            }
        }
        
        $theme->theme_file("_promotions/promotions_auth_true.html.php");
        
        return(0);
    } // end authTrue()
    
    /**
    * Niepoprawna autoryazacja
    *
    * @acces public
    * @return none
    */
    function authFalse() {
        global $theme;
        $theme->theme_file("_promotions/promotions_auth_false.html.php");
        return false;
    } // end authFalse()
    
} // end class Promotions()
?>
