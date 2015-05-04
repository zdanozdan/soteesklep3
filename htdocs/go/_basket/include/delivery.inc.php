<?php
/**
* Obliczenie kosztow dostawy. Wy�wietlanie informacji o dostawie.
* Klasa zawiera funkcje obliczaj�ce warto�� dostawy na podstawia warto�ci zm�wienia, oraz prezentacj�
* listy dostawc�w wraz z kosztami dostawy.
*
* @author  m@sote.pl
* @version $Id: delivery.inc.php,v 1.2 2006/11/23 17:57:58 tomasz Exp $
* @package    basket
*/

/**
* Obliczanie koszt�w dostawy.
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
    var $spring_promo_code = 0;

    function set_spring_promo($promo)
    {
	$this->spring_promo_code = $promo;
    }

    function get_delivery_data_by_id($delivery_id)
    {
        global $theme,$lang;
        global $db;
        global $_SESSION;
        global $shop;
        global $basket;

        // odczytaj warto�c zam�wienia
        $basket->calc();
        $global_basket_amount=$basket->amount;

        // zanim odczytasz nazwe dostawcy, domyslnie jest on nieokreslony
        // wymagadne w przypadku, kiedy nie ma zadnego dostawcy w bazie
        $this->delivery_name=$lang->basket_delivery_name_unknown;

        // wywo�ujemy klase obliczajaca koszty przesy�ki
        $this->deliverycost=new Delivery_Cost($this->weight);
        // pobieramy strefe dostawy
        $this->id_zone=$this->deliverycost->_get_zone();

        $tab=array();

        $query="SELECT * FROM delivery where id=$delivery_id ORDER BY order_by";
        $result=$db->Query($query);
        if ($result!=0) 
        {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows==1) 
            {
               $this->id=$db->FetchResult($result,0,"id");
               $this->name=$db->FetchResult($result,0,"name");
               $this->price_brutto=$db->FetchResult($result,0,"price_brutto");
               $this->vat=$db->FetchResult($result,0,"vat");
               $this->free_from=$db->FetchResult($result,0,"free_from");
               $this->delivery_info=$db->FetchResult($result,0,"delivery_info");
               $this->delivery_zone=$db->FetchResult($result,0,"delivery_zone");
               $this->price_zone=$this->deliverycost->_get_delivery($this->delivery_zone);
               $this->price_volume=$this->deliverycost->_compute_cost_delivery($this->id);
               $this->pay=$db->FetchResult($result,0,"delivery_pay");
               
               if ($global_basket_amount>=$this->free_from) 
               {
                  $this->cost=0;
               } else {
                  $this->cost=$theme->price($this->price_brutto);
               }
               
               if($this->deliverycost->check_deliver($this->id_zone,$this->id)) 
               {
                  $this->save_delivery();
                  $this->_changeCost();      // zprawd� czy zmieni� koszty dostawy, je�li tak to podmie� warto�c $this->cost
                  
                  // zapamietaj dane dostawcy (kolejnych dostawc�w)
                  $tab['id']=$this->id;
                     $tab['name']=$this->name;
                     $tab['cost']=$this->cost;
                     $tab['pay']=$this->delivery_pay;
                     
                     // start dodaj tlumaczenie:
                     if ($config->base_lang!=$config->lang) 
                     {
                        $tab['name']=LangFunctions::f_translate($this->name);
                     }
               }
            }
        }
        return $tab;
    }
    /**
    * Oblicz koszty dostawy, odczytaj dane z bazy i zpami�taj w tabclicy.
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
        // odczytaj warto�c zam�wienia
        $basket->calc();
        $global_basket_amount=$basket->amount;

        //print "weight".$this->weight."<br>";

        // zanim odczytasz nazwe dostawcy, domyslnie jest on nieokreslony
        // wymagadne w przypadku, kiedy nie ma zadnego dostawcy w bazie
        $this->delivery_name=$lang->basket_delivery_name_unknown;

        // wywo�ujemy klase obliczajaca koszty przesy�ki
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
	//print $this->id_zone;
	//exit();

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
                    if($this->deliverycost->check_deliver($this->id_zone,$this->id)) 
                    {
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
    * Zapamietaj dane dostawcy. Zaznacz wybranego dostawc�.
    *
    * \@global int $_REQUEST['global_delivery'] ID dostawcy (pole id z tabeli delivery)
    * @access private
    * @return none
    */
    function _calc_row() {
        global $lang;
        global $config;
        global $_REQUEST;
        global $_SESSION;

        $this->_changeCost();      // zprawd� czy zmieni� koszty dostawy, je�li tak to podmie� warto�c $this->cost

        $checked=false;;
        if (empty($_REQUEST['delivery']) && empty($_SESSION['global_delivery'])) 
        {
           // ustaw domyslnego dostawce - pierwszego z listy dostawcow
           if ($this->checked==false) {
              $checked=true;
           }
        }
        else 
        {
           // jest juz w sesji wybrany dostawca - zmiana dostawcy
            if (!empty($_REQUEST['delivery']))
            {
               if ($_REQUEST['delivery']['id']==$this->id) 
               {
                  $checked=true;
               }
            }
            else
            {
               if (!empty($_SESSION['global_delivery']))
               {
                  if ($_SESSION['global_delivery']['id']==$this->id) 
                  {
                     //print($_SESSION['global_delivery']['name']);
                     $checked=true;
                  }
               }
            }
        }

        // je�li wybrano nowy kraj, zaznacz 1 dostawc� z listy
        if  (((! empty($_REQUEST['item']['country']))) && (! $this->checked)) {
            $checked=true;

        }

        // zapami�taj, �e wybrano ju� dostawc� do zaznaczenia; nie zaznaczaj kolejnych
        if (! empty($checked)) {
            $this->checked=true;
            $this->save_delivery();
        }

        // zapamietaj dane dostawcy (kolejnych dostawc�w)

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
    * Ustal koszty dostawy na podstawie obj�to�ci.
    * Sprawd� czy jest zdefiniowana kwota dostawy liczona na podstawie obj�cto�ci.
    * Je�li tak, to podmie� warto�c $this->cost na warto�c obliczon� zwi�zan� z obj. itp.
    *
    * @access private
    * @return none
    */
    function _changeCost() {
        global $basket;
    	// je�li s� koszty dostawy wyliczona na podstwei ob�to�ci itp., to zmie�
        // cen� dostawy
        
        if ($this->price_volume != '' || $this->price_zone != '') {
            $this->cost_standard=$this->cost;   // zapami�taj cen� standardow�
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

    function show()
    {
      print "<span id=\"delivery_show\">";
      $this->show_ajax();
      print "</span>";
    }

    function get_checked() {
      foreach ($this->data as $data) 
	{
          if (! empty($data['checked'])) 
	    return $data['id'];
	}
    }

    /**
    * Prezentacja kosztow dostawy
    */
      function show_ajax() {
        global $lang;
        print "<p>";
        print "<div class='alert alert-info text-left'>$lang->basket_delivery_header:</div>";
        print "<table class=\"table table-bordered table-hover table-mikran table-delivery payment_old\">";
        print "  <tr>";
        print "    <th class=\"payment_head_old\" colspan=\"2\">$lang->basket_delivery_method</td>";
        print "    <th class=\"payment_head_old\">$lang->basket_delivery_cost</td>";
        print "  </tr>";

        // sprawd� czy jaki� dostawca jest zaznaczony, je�li nie, to zaznacz pierwszego na li�cie
        $_ck=false;
        foreach ($this->data as $data) {
            if (! empty($data['checked'])) $_ck=true;
	    
            //TZ wiosenne promocje 
            if (! empty($data['checked']))
            {
               if($data['id'] == 16)
	         if($this->spring_promo_code == 0)
                   $_ck=false;
	     }
        }
        // end

        //print "<div>";print_r($this->data);print "</div>";

        reset($this->data);
        foreach ($this->data as $data) {
            $this->id=$data['id'];
            $this->name=$data['name'];
            $this->cost=$data['cost'];
            $this->delivery_info=$data['delivery_info'];
            $this->pay=$data['pay'];
            

            if (($data['checked']==true) || (! $_ck)) 
               $this->checked=" checked";
            else 
               $this->checked="";
       
        //je�li darmowa dostawa
	//TZ wiosenna promocja
	if($this->id == 16)
        {
	  if($this->spring_promo_code > 0)
          {
            $this->_row();
          }
        }
	else
	{
	  $this->_row();
        }

        }
        print "</table>";
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
        
        // Je�li koszyk jest w formie do wydruku, to nie wyswietlaj listy dostawc�w
        global $config;
        if ($config->theme!='print')
        {
           if (! empty ($this->delivery_info)) $dinfo_sep=",";
           else $dinfo_sep="";
           
           $price=$shop->currency->price($this->cost);
           $price.=" ".$shop->currency->currency."</nobr>";
           
           print "  <tr>";
           print "    <td class=\"payment_itext_old\">";
           print "      <input type=\"radio\" name=\"delivery[id]\" $this->checked value=\"$this->id\" onclick='clearSelections(); deliverySelection(\"del_$this->id\");document.getElementById(\"order_step_one\").innerHTML=\"Prosz� czeka�, pobieranie danych ...\";xmlhttpGet(\"/go/_basket/sess_delivery.php?delivery_id=$this->id\",\"order_step_one\")'\"'>";
           print "    <td id=\"del_$this->id\" class=\"payment_itext_old\">$this->name,</td>";
           print "    <td id=\"del_$this->id"."1"."\" class=\"payment_itext_old\" nowrap>".$price."$dinfo_sep</td>\n";
           print "    <td id=\"del_$this->id"."2"."\"class=\"payment_itext_old\">$this->delivery_info</td>\n";
           print "  </tr>\n";
           
           if ($this->checked==" checked")
              print "<script>deliverySelection(\"del_$this->id\")</script>";
        }
     } // end _row()


    /**
    * Wy�wietl list� kraj�w - zmiana kraju dostawy
    * Zapami�taj wybrany kraj dostawy w sesji
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


        
        // Je�li koszyk jest w formie do wydruku, to nie wyswietlaj wyboru kraju
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
	echo "<div class='alert alert-info text-left'>";
	echo $lang->delivery_country;
	echo ": </div>";
        $str="<div class='text-left'>";
        $str.="<select name=item[country] onChange=\"this.form.submit();\">";
        $str.="<option value=''>".$lang->select_country."</option>";
        foreach($country as $key=>$value) {
            if($keys == $key) {
                $str.="<option value=".$key." selected>".$lang->country[$key]."</option>";
            } else {
                $str.="<option value=".$key.">".$lang->country[$key]."</option>";
            }
        }
        $str.="</select>";
        $str.="</div><br>";
        print $str;
    } // end show_country()
    }// end koszyk w formie do wydruku
} // end class Delivery

$delivery_obj =& new Delivery;
?>
