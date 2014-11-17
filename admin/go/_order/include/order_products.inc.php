<?php
/**
* Odczytaj dane produktów w danym zamówieniu.
*
* @author  m@sote.pl
* @version $Id: order_products.inc.php,v 2.13 2006/08/16 14:30:47 lukasz Exp $
* @package    order
*/

/**
* Odczytaj dane produktów w danym zamówieniu
* @package order
* @subpackage order
*/
class OrderProducts {
    
    /**
    * @var array dane produktów.
    * Tablica zwiera wyni zapytania $mdbd->select() w postaci tablicy, array(0=>array(), 1=>array(), ...).
    */
    var $data=array();
    
    /**
    * @var float $total_amount_brutto warto¶æ zamówienia przypisanego dla danej transakcji.
    * Warto¶æ mo¿e byæ ró¿na od kwoty zamówienia z³o¿onego przez klienta, gdy¿ sprzedawca mo¿e
    * modyfikowaæ za³o¿one zamówienie.
    */
    var $total_amount_brutto=0;
    
    /**
    * @var float $total_amount_netto warto¶æ zamówienia netto
    */
    var $total_amount_netto=0;
    
    /**
    * @var int order_id zamówienia
    */
    var $order_id;
    
    /**
    * Konstruktor
    */
    function OrderProducts($order_id) {
        global $mdbd;
        if (! empty($order_id)) {
            $dat=$mdbd->select("id_promotions,promotions_name,promotions_discount","order_register","order_id=?",array($order_id=>"int"),"LIMIT 1");
            $this->discount=$dat['promotions_discount'];
            $this->order_id=$order_id;
        }
        return;
    } // end OrderProducts()
    
    /**
    * Odczytaj dane produktów dla danej trsnsakcji.
    *
    * @param int $order_id id transakcji
    * @return none
    
    Array
    (
    [0] => Array
    (
    [id] => 1
    [order_id] => 443
    [user_id_main] => 12
    [price_brutto] => 3900
    [vat] => 0
    [name] => Future 1724 Future Design
    [num] => 1
    [currency] => PLN
    [measure] =>
    [producer] =>
    )
    )
    */
    function getData() {
        global $mdbd;
        $order_id=$this->order_id;
        $this->data=$mdbd->select("id,order_id,user_id_main,price_brutto,vat,name,num,currency,measure,producer,options",
        "order_products","order_id=?",array($order_id=>"int"),'ORDER BY id',"ARRAY");
        return;
    } // end getData()
    
    /**
    * Wy¶wietl produkty z danej transakcji.
    *
    * @param int $order_id order_id zamówienia
    * @return string HTML
    * @link tutorials/extended/order.pkg
    */
    function getProductsInfo() {
        global $theme;
        
        $order_id=$this->order_id;
        
        if (empty($this->data)) $this->getData();
        if (empty($this->data)) return;
        
        reset($this->data);
        $o=$this->_showHead();
        foreach ($this->data as $pos=>$product) {
            $this->_calcProduct($product);
            $o.=$this->_showRecord($product);
        } // end foreach
        $this->total_amount_netto=$theme->price($this->total_amount_netto);
        $this->total_amount_brutto=$theme->price($this->total_amount_brutto);
        $o.=$this->_showFoot();
        return $o;
    } // end getProductsInfo()
    
    /**
    * Wy¶wietl formularz dodania produktu do zamówienia + przycisk aktualizacji ca³ego zamówienia.
    * @return none
    */
    function addForm() {
        global $lang;
        include_once ("./html/product_add_form.html.php");
        return;
    } // end addForm()
    
    /**
    * Dodaj dodatkowe pola do danych produktu (netto,sume)
    *
    * @param array &$product dane produktu
    * @access private
    * @return none
    */
    function _calcProduct(&$product) {
        global $theme;
        
        $product['price_netto']=$theme->price($product['price_brutto']/( (100+$product['vat'])/100 ));
        $product['sum_brutto']=$product['price_brutto']*$product['num'];
        $product['sum_netto']=$theme->price($product['price_netto']*$product['num']);
        $product['vat_value']=$theme->price($product['price_netto']*($product['vat']/100));
        $this->total_amount_brutto=$this->total_amount_brutto+$product['sum_brutto'];
        $this->total_amount_netto=$this->total_amount_netto+$product['sum_netto'];
        return;
    } // end _calcProduct()
    
    /**
    * Nag³ówek listy produktów.
    * Funkcja zwraca HTML <table><tr><th>...</th></tr>
    *
    * @return string HTML
    * @access private
    */
    function _showHead() {
        global $lang, $order_print;
        if($order_print != true) { // zwyk³a prezentacja listy
	        $o="<table border=\"1\" width=\"100%\">\n<tr>\n";
        }
	    else { // prezentacja listy do druku
        	$o="<table border=\"1\" width=\"100%\" cellspacing=0 cellpadding=2>\n<tr>\n";
	    }
        $o.="<th>".$lang->order_products['user_id']."</th>";
        $o.="<th>".$lang->order_products['name']."</th>";
        // $o.="<th>".$lang->order_products['producer']."</th>";
        $o.="<th>".$lang->order_products['options']."</th>";
        $o.="<th>".$lang->order_products['price_netto']."</th>";
        $o.="<th>".$lang->order_products['price_brutto']."</th>";
        $o.="<th>".$lang->order_products['vat']."%</th>";
        $o.="<th>".$lang->order_products['vat_value']."</th>";
        $o.="<th>".$lang->order_products['num']."</th>";
        $o.="<th>".$lang->order_products['sum_brutto']."</th>";
        if($order_print != true) {
        	$o.="<th><input type=\"submit\" value=\"$lang->delete\"></th>";
        }
        $o.="</tr>\n";
        
        return $o;
    } // _showHead()
    
    
    /**
    * Rekord z informacjami o produkcie.
    * Funkcja zwraca kod HTML <tr>...</tr>.
    *
    * @param array $product dane produktu
    *
    * @access private
    * @return string HTML
    */
    function _showRecord($product) {
    	global $order_print;
        $o="<tr>\n";
        $o.="  <td align=\"right\">".$product['user_id_main']."</td>\n";
        $o.="  <td align=\"center\">".$product['name']."</td>\n";
        // $o.="  <td align=\"right\">".$product['producer']."</td>\n";
        $o.="  <td align=\"right\">".$product['options']."</td>\n";
        $o.="  <td align=\"right\">".$product['price_netto']."</td>\n";
        $o.="  <td align=\"right\">".$product['price_brutto']."</td>\n";
        $o.="  <td align=\"center\">".$product['vat']."</td>\n";
        $o.="  <td align=\"right\">".$product['vat_value']."</td>\n";
        $o.="  <td align=\"center\">".$product['num']."</td>\n";
        $o.="  <td align=\"right\">".$product['sum_brutto']."</td>\n";
        if($order_print != true) {
	        $o.="  <td align=\"center\"><input type=\"checkbox\" name=products_del[".$product['id']."] value=1></td>\n";
        }
        $o."</tr>\n";
        
        return $o;
    } // end _showRecord()
    
    /**
    * Stopka listy produktów.
    * Funkcja zamyka tabele HTML listy produktów oraz zawiera podsumowanie kwoty netto i brutto zamówienia.
    *
    * @access private
    * @return string HTML
    */
    function _showFoot() {
        global $lang,$config;
        
        $o="</table>\n";
        $o.="<div align=\"right\">";
        $o.="$lang->order_total_amount_netto ".$this->total_amount_netto." $config->currency<BR>";
        $o.="$lang->order_total_amount_brutto <b>".$this->total_amount_brutto."</b> $config->currency<BR>";
        $this->totalAmount();
        $o.="</div>\n";
        return $o;
    } // _showFoot()
    
    /**
    * Dodaj produkt do zamówienia
    *
    * @param array $product  dane dodawanego produktu
    * @return none
    */
    function add($product) {
        global $mdbd;
        
        $order_id=$this->order_id;
        
        // jesli wybrano produkt z listy rozwijanej, to przekaz user_id przypisane do wybranego produktu
        if (! empty($product['user_id_auto'])) {
            $product['user_id']=$product['user_id_auto'];
        }
        
        // jesli nie podano nazwy, odczytaj dane produktu z bazy danych
        if ((empty($product['name'])) && (! empty($product['user_id']))) {
             
            $db_product=$mdbd->select("user_id,name_L0,price_brutto,vat,xml_options","main","user_id=?",
            array($product['user_id']=>"text"),"LIMIT 1");
            
            if (empty($db_product)) return;
            // elementy, ktore sa przekazywane z formularza nie z bazy
            if (! empty($product['num'])) $db_product['num']=$product['num'];
            if (! empty($product['options'])) $db_product['options']=$product['options'];
            
            // oblicz cene produktu wg rodzaju
            $db_product['price_brutto']=$db_product['price_brutto'];
            $product=$db_product;

        }
        else 
        {
        	$product['name_L0'] = $product['name'];
        }
        
        if (empty($product['num'])) $product['num']=1;
        if (empty($product['options'])) $product['options']='';

        $mdbd->insert("order_products","user_id_main,name,price_brutto,vat,options,num,order_id","?,?,?,?,?,?,?",
        array(
        "1,".$product['user_id']=>"text",
        "2,".$product['name_L0']=>"text",
        "3,".$product['price_brutto']=>"text",
        "4,".$product['vat']=>"text",
        "5,".$product['options']=>"text",
        "6,".$product['num']=>"text",
        "7,".$order_id=>"int",
        ));
        
        return;
    } // end add()
    
    /**
    * Usuñ zaznaczone produkty z zamówienia (o podnym id).
    * Zaznaczone produkty s± usuwane z tabeli order_products.
    *
    * @param array $del tablica z id rekordów do usuniêcia
    * @return none
    */
    function delete($del) {
        global $mdbd;
        
        if (empty($del)) return;
        reset($del);
        foreach ($del as $id=>$val) {
            if ($val==1) {
                $mdbd->delete("order_products","id=?",array($id=>"int"));
            }
        } // end foreach
        $this->totalAmount();
        return;
    } // end delete()
    
    /**
    * Odczytaj warto¶æ zamówienia dla danej transakcji i zapisz warto¶æ w order_register.
    * Zwracana warto¶c zmówienia uwzglêdnia zmiany wprowadzone do zamówienia. Np. dodanie pozycji do koszyka itp.
    *
    * @return float warto¶c zamówienia brutto
    */
    function totalAmount() {
        global $db,$mdbd,$rec;
        
        $order_id=$this->order_id;
        
        $query="SELECT SUM(price_brutto*num) AS total_amount FROM order_products WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $total_amount=$db->FetchResult($result,0,"total_amount");
                $total_amount=$total_amount*((100-$this->discount)/100);
                $rec->data['total_amount']=$total_amount;
                $mdbd->update("order_register","total_amount=?","order_id=?",
                array("1,".$total_amount=>"text",
                "2,".$order_id=>"int"));
                return $total_amount;
            }
        } else die ($db->Error());
        
        return 0;
    } // end totalAmount()
    
} // end class OrderProducts
?>
