<?php
/**
* Obliczenie kosztow dostawy. Wy¶wietlanie informacji o dostawie.
* Klasa zawiera funkcje obliczaj±ce warto¶æ dostawy na podstawia warto¶ci zmówienia, oraz prezentacjê
* listy dostawców wraz z kosztami dostawy.
*
* @author  m@sote.pl
* @version $Id: delivery.inc.php,v 1.2 2006/11/23 17:57:58 tomasz Exp $
* @package    basket
*/

/**
* Obliczanie kosztów dostawy.
*/
include_once("include/delivery_cost.inc");

/**
* Dostawa towaru.
* @package basket
* @subpackage delivery
*/
class Delivery {
    var $checked=false;
    var $data=array();      // dane dostawcy, informacja o wybranym dostawcy
    var $delivery_id=-1;    // id wybranego dostawcy
    var $delivery_name="";  // nazwa jw.
    var $delivery_cost=0;   // koszt dostawy
    var $delivery_pay;   	// sposoby platnosci
    var $id_zone='';		// strefa dostawy
    var $weight='';         // objetosc towaru
    var $deliverycost='';
    /**
    * Oblicz koszty dostawy, odczytaj dane z bazy i zpamiêtaj w tabclicy.
    *
    * @return none
    */
    function calc() {
        global $theme,$lang;
        global $db;
        global $_SESSION;
        global $shop;
        global $basket;

        // print "calc<br>";
        // odczytaj warto¶c zamówienia
        $basket->calc();
        $global_basket_amount=$basket->amount;

        //print "weight".$this->weight."<br>";

        // zanim odczytasz nazwe dostawcy, domyslnie jest on nieokreslony
        // wymagadne w przypadku, kiedy nie ma zadnego dostawcy w bazie
        $this->delivery_name=$lang->basket_delivery_name_unknown;

        // wywo³ujemy klase obliczajaca koszty przesy³ki
        $this->deliverycost=new Delivery_Cost($this->weight);
        // pobieramy strefe dostawy
        $this->id_zone=$this->deliverycost->_get_zone();
        //print "id_zone".$this->id_zone;
        if($this->id_zone==-1) {
            $i=0;
        } else {
            $i=1;
        }

        //print "zone".$this->id_zone."<br>";

        $query="SELECT * FROM delivery ORDER BY order_by";
        $result=$db->Query($query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows==0) {
                return;
            } else {
                for ($i;$i<$num_rows;$i++) {
                    $this->id=$db->FetchResult($result,$i,"id");
                    $this->name=$db->FetchResult($result,$i,"name");
                    $this->price_brutto=$db->FetchResult($result,$i,"price_brutto");
                    $this->vat=$db->FetchResult($result,$i,"vat");
                    $this->free_from=$db->FetchResult($result,$i,"free_from");
                    $this->delivery_info=$db->FetchResult($result,$i,"delivery_info");
                    $this->delivery_zone=$db->FetchResult($result,$i,"delivery_zone");
                    $this->price_zone=$this->deliverycost->_get_delivery($this->delivery_zone);
                    $this->price_volume=$this->deliverycost->_compute_cost_delivery($this->id);
                    $this->pay=$db->FetchResult($result,$i,"delivery_pay");

                    if ($global_basket_amount>=$this->free_from) {
                        $this->cost=0;
                    } else {
                        $this->cost=$theme->price($this->price_brutto);
                    	//print $this->cost;
                    }
                    if($this->deliverycost->check_deliver($this->id_zone,$this->id)) {
                    	$this->_calc_row();
        			}	
                    if($this->id_zone==-1) {
                        $i=$num_rows;
                    }
                }
            }
        }
        //print "<pre>";
        //print_r($this->data);
        //print "</pre>";

        return;
    } // end show()

    /**
    * Zapamietaj dane dostawcy. Zaznacz wybranego dostawcê.
    *
    * \@global int $_REQUEST['delivery'] ID dostawcy (pole id z tabeli delivery)
    * @access private
    * @return none
    */
    function _calc_row() {
        global $lang;
        global $config;
        global $_REQUEST;

        $this->_changeCost();      // zprawd¼ czy zmieniæ koszty dostawy, je¶li tak to podmieñ warto¶c $this->cost

        $checked=false;;
        if (empty($_REQUEST['delivery'])) {
            // ustaw domyslnego dostawce - pierwszego z listy dostawcow
            if ($this->checked==false) {
                $checked=true;
            }
        } else {
            // jest juz w sesji wybrany dostawca - zmiana dostawcy
            if ($_REQUEST['delivery']['id']==$this->id) {
                $checked=true;
            }
        }

        // je¶li wybrano nowy kraj, zaznacz 1 dostawcê z listy
        if  (((! empty($_REQUEST['item']['country']))) && (! $this->checked)) {
            $checked=true;

        }

        // zapamiêtaj, ¿e wybrano ju¿ dostawcê do zaznaczenia; nie zaznaczaj kolejnych
        if (! empty($checked)) {
            $this->checked=true;
            $this->save_delivery();
        }

        // zapamietaj dane dostawcy (kolejnych dostawców)
        $tab=array();
        $tab['id']=$this->id;
        $tab['name']=$this->name;
        $tab['cost_standard']=@$this->cost_standard;
        $tab['cost']=$this->cost;
        $tab['checked']=$checked;
        $tab['delivery_info']=$this->delivery_info;
        $tab['delivery_zone']=$this->delivery_zone;
        $tab['pay']=$this->delivery_pay;
        $tab['price_zone']=$this->price_zone;
        $tab['price_volume']=$this->price_volume;
        $tab['weight']=$this->weight;

        // start dodaj tlumaczenie:
        if ($config->base_lang!=$config->lang) {
            $tab['name']=LangFunctions::f_translate($this->name);
            $tab['delivery_info']=LangFunctions::f_translate($this->delivery_info);
        }
        // end dodaj tlumaczenie:

        array_push($this->data,$tab);

        return;
    } // end _calc_row()

    /**
    * Ustal koszty dostawy na podstawie objêto¶ci.
    * Sprawd¼ czy jest zdefiniowana kwota dostawy liczona na podstawie objêcto¶ci.
    * Je¶li tak, to podmieñ warto¶c $this->cost na warto¶c obliczon± zwi±zan± z obj. itp.
    *
    * @access private
    * @return none
    */
    function _changeCost() {
        global $basket;
    	// je¶li s± koszty dostawy wyliczona na podstwei obêto¶ci itp., to zmieñ
        // cenê dostawy
        
        if ($this->price_volume != '' || $this->price_zone != '') {
            $this->cost_standard=$this->cost;   // zapamiêtaj cenê standardow±
            // jesli klinet zamowil o wartosci wiekszej niz dostawa bez oplaty to zeruj wartosci. 
            if($basket->amount >=$this->free_from) {
            	$this->cost=0;
            } else {	
            	$this->cost=$this->price_zone+$this->price_volume;
            }	
        }
        return;
    } // end _changeCost()

    /**
    * Zapamietaj dane wybranego dostawcy
    */
    function save_delivery() {
        $this->delivery_id=$this->id;
        $this->delivery_name=$this->name;
        $this->delivery_cost=$this->cost;
        $this->delivery_pay=$this->pay;
        return;
    } // end save_delivery()

    /**
    * Prezentacja kosztow dostawy
    */
    function show() {
        global $lang;
        print "<p>\n";
        print "<b>$lang->basket_delivery_header:</b>";
        print "<table class=\"payment\" border=\"0\">\n";
        print "  <tr>";
        print "    <td class=\"payment_head\" valign=\"top\" align=\"center\" colspan=\"2\">\n<b>$lang->basket_delivery_method</b></td>";
        print "    <td class=\"payment_head\" valign=\"top\" align=\"center\">\n<b>$lang->basket_delivery_cost</b></td>";
        print "  </tr>";

        // sprawd¼ czy jaki¶ dostawca jest zaznaczony, je¶li nie, to zaznacz pierwszego na li¶cie
        $_ck=false;
        foreach ($this->data as $data) {
            if (! empty($data['checked'])) $_ck=true;
        }
        // end

        // print "<pre>";print_r($this->data);print "</pre>";

        reset($this->data);
        foreach ($this->data as $data) {
            $this->id=$data['id'];
            $this->name=$data['name'];
            $this->cost=$data['cost'];
            $this->delivery_info=$data['delivery_info'];
            $this->pay=$data['pay'];
            

            if (($data['checked']==true) || (! $_ck)) $this->checked=" checked";
            else $this->checked="";

            $this->_row();
        }
        print "</table>\n";
        return;
    } // end show()

    /**
    * Prezentacja 1 dostawcy
    *
    * @access private
    * @return none
    */
    function _row() {
        global $config,$lang;
        global $shop;
        
        // Je¶li koszyk jest w formie do wydruku, to nie wyswietlaj listy dostawców
        global $config;
        if ($config->theme!='print'){
        	
        if (! empty ($this->delivery_info)) $dinfo_sep=",";
        else $dinfo_sep="";


        $price=$shop->currency->price($this->cost);
        $price.=" ".$shop->currency->currency."</nobr>";
        print "  <tr>";
        print "    <td class=\"payment_itext\" valign=\"top\" align=\"left\">\n";
        //TZ UWAGA
        //submit - dzia³a inaczej w FF a inaczej w IE.
        //print "      <input type=\"radio\" name=\"delivery[id]\" $this->checked value=\"$this->id\" style='border-width: 0px;'>";
        print "      <input type=\"radio\" name=\"delivery[id]\" $this->checked value=\"$this->id\" onclick=\"this.form.submit();\" style='border-width: 0px;'>";
        print "      <input type=\"hidden\" name=\"delivery[name]\" value=\"$this->name\"</td>\n";
        print "    <td class=\"payment_itext\" valign=\"top\" align=\"left\" nowrap>$this->name,</td>";
        //        print "    <td class=\"payment_itext\" valign=top>$lang->basket_delivery_cost</td>\n";
        print "    <td class=\"payment_itext\" valign=\"top\" align=\"left\" nowrap>".$price."$dinfo_sep</td>\n";
        print "    <td class=\"payment_itext\" valign=\"top\" align=\"left\">$this->delivery_info</td>\n";
        print "  </tr>\n";
        }
     } // end _row()


    /**
    * Wy¶wietl listê krajów - zmiana kraju dostawy
    * Zapamiêtaj wybrany kraj dostawy w sesji
    *
    * @author rdiak@sote.pl m@sote.pl
    * @return none
    */
    
    function show_country() {
        global $config;
        global $_SESSION;
        global $lang;
        global $sess;
        global $global_country_delivery;

        
        // Je¶li koszyk jest w formie do wydruku, to nie wyswietlaj wyboru kraju
        global $config;
        if ($config->theme!='print'){
        
        
        if (! empty($_REQUEST['item']['country'])) {
            $global_country_delivery=$_REQUEST['item']['country'];
            $sess->register("global_country_delivery",$global_country_delivery);
        } elseif (! empty($_SESSION['global_country_delivery'])) {
            $global_country_delivery=$_SESSION['global_country_delivery'];
            $sess->register("global_country_delivery",$global_country_delivery);
        } else {
            $global_country_delivery=$config->default_country;
            $sess->register("global_country_delivery",$global_country_delivery);
        }

        if(!empty($config->country_select)) {
        	$country=$config->country_select;
        } else {
        	$country=$lang->country;
        }
        
        $keys=$global_country_delivery;
        $str="<table align=left border=\"0\">\n";
        $str.=$lang->delivery_country."&nbsp;<select name=item[country] onChange=\"this.form.submit();\">\n";
        $str.="<option value=''>".$lang->select_country."</option>";
        foreach($country as $key=>$value) {
            if($keys == $key) {
                $str.="<option value=".$key." selected>".$lang->country[$key]."</option>\n";
            } else {
                $str.="<option value=".$key.">".$lang->country[$key]."</option>\n";
            }
        }
        $str.="</select>\n";
        $str.="</table><br><br>\n";
        print $str;
    } // end show_country()
    }// end koszyk w formie do wydruku
} // end class Delivery

$delivery_obj =& new Delivery;

?>
