<?php
/**
* Klasa obliczaj±ca koszty dostawy
*
* wywo³anie
* $delivery= new Delivery_Cost($sum_volume);
* $deliver=$delivery->get_delivery();
*
* $deliver jest tablica która zawiera pe³ne informacje o dostawcach i cenach
*
* @author  r@sote.pl
* @version $Id: delivery_cost.inc,v 2.13 2005/12/02 08:43:16 scalak Exp $
* @package soteesklep
* $Log: delivery_cost.inc,v $
* Revision 2.13  2005/12/02 08:43:16  scalak
* no message
*
* Revision 2.12  2005/10/12 09:20:18  scalak
* no message
*
* Revision 2.11  2005/07/19 09:28:10  scalak
* no message
*
* Revision 2.10  2005/05/17 12:26:37  scalak
* no message
*
* Revision 2.9  2005/04/22 11:04:11  scalak
* no message
*
* Revision 2.8  2005/02/10 10:52:30  scalak
* no message
*
* Revision 2.7  2005/02/09 15:25:12  scalak
* no message
*
* Revision 2.6  2005/02/09 13:55:36  scalak
* no message
*
* Revision 2.5  2005/02/08 12:55:13  scalak
* no message
*
* Revision 2.4  2005/02/03 13:39:52  scalak
* no message
*
* Revision 2.1  2004/11/29 13:02:36  scalak
* no message
*
*
*/

/**
* Klasa obs³ugi wyliczenie kosztów dostawy.
* @package delivery
* @subpackage htdocs
*/
include_once("include/metabase.inc");
class Delivery_Cost {

	var $_global_country_delivery;	// odczytana z sesji informacja o kraju dostawy
	var $_id_zone;                  // id strefy dostawy 
	var $_delivery_array=array();   // tablica dostawców
	var $_sum_volume;				// sumaryczna objetosc zakupów	
	
	/**
    * Konstruktor
    *
    * @return none
    */
    function Delivery_Cost($sum_volume) {
    	global $_SESSION;
    	global $config;
    	global $mdbd;
		// przypisz zmiennej wartosc odczytana w sesji
		if(!empty($_REQUEST['item']['country'])) {
			$this->_global_country_delivery=$_REQUEST['item']['country'];
		} elseif(!empty($_SESSION['global_country_delivery'])) {
			$this->_global_country_delivery=@$_SESSION['global_country_delivery'];
		} else {
			$this->_global_country_delivery=$config->default_country;
		}
    	//print "country".$this->_global_country_delivery;
		$this->_sum_volume=$sum_volume;
		$this->_delivery_array=$mdbd->select("id,name,delivery_zone,price_brutto","delivery","id!=1","","ORDER BY id","array");
		return true;
    } // end Delivery_Cost()

    /**
    *
	* Funkcja sprawdza w jakiej strefie dostawy znajduje sie kraj do ktorego 
	* wysy³amy przesy³ke 
    *
    * @return bool true - znaleziono dostawce dla danego kraju, false nie znaleziono
    */
    function _get_zone($country='') {
		global $mdbd;
		global $config;
		
		if(!empty($country)) {
			$this->_global_country_delivery=$country;
		} 
		//if($config->default_country == $this->_global_country_delivery) {
		//	$this->_id_zone=$mdbd->select("id","delivery_zone","id!=1 AND id!=12","","LIMIT 1","auto");
		//	return $this->_id_zone;
		//}
		// odczytaj wszystkie strefy z bazy danych
		$data=$mdbd->select("id,country","delivery_zone","id!=1","","","array");
		foreach($data as $key=>$value) {
    		// zmien serializowna zmienna na tablice
			$data_country=unserialize($value['country']);
			if(!empty($data_country)) {
				if(in_array($this->_global_country_delivery,$data_country)) {
         			// jesli kraj znajduje sie w kilku strefach bierzemy pierwsza napotkana
   					$this->_id_zone=$value['id'];
				}
			}	
		}
		// jesli kraj jest przypisany do jakies strefy ale strefa nie jest przypisana do zadnego
		// z dostawcow to sprawdzamy to w tym miejscu
		$status=0;
		foreach($this->_delivery_array as $key=>$value) {
			$data_temp=unserialize($value['delivery_zone']);
			if(!empty($data_temp)) {
				if(array_key_exists($this->_id_zone,$data_temp)) {
					$status=1;
				}	
			}					
		}
		// i jesli warunek powyzje jest spelniony to ustawiamy dostawe standardowa
		if(empty($this->_id_zone) || $status == 0) {
			// kraj nie zosta³ przypisany do ¿adnej strefy dostawy
			$this->_id_zone=-1;
			//$this->_id_zone=12;
		}
		return $this->_id_zone;
    } // end _get_zone
	
    /**
    *
	* Funkcja znajduje dostawców którzy mog± dostarczyæ przesy³ke do danego kraju 
    *
    */
    function _get_delivery($value) {
    		//print "id_zone".$this->_id_zone;
    		// zmien serializowna zmienna na tablice
			$data_zone=unserialize($value);
			// jesli dostawca spelnia kryteria to zapisz go do tablicy
			if(!empty($data_zone)) {
				if(array_key_exists($this->_id_zone, $data_zone)) {
					return $data_zone[$this->_id_zone];
				} else {
					return @$data_zone[1];
					//return false;
				}
			}		
    } // end _get_delivery
    
   /**
    *
	* Funkcja znajduje dostawców którzy mog± dostarczyæ przesy³ke do danego kraju 
    *
    */
    function _compute_cost_delivery($id) {
    	global $mdbd;
    	global $database;
    	//sumarczyna objêto¶æ wszystkich towarów w koszyku
		//odczytujemy wszystkie objetosci
        // otrzymujemy id_volume w której znajduje siê produkt
		//print "sum_volume=".$this->_sum_volume."<br>";
        if(!empty($this->_sum_volume)) {
  				
        		//$id_volume=$mdbd->select("id","delivery_volume",
             	//	"range_max <= $this->_sum_volume","","","array");
       		$id_volume=$database->sql_select("id","delivery_volume",""," WHERE range_max >=$this->_sum_volume ORDER BY range_max LIMIT 1");
				
             	
             	//print "id_volume".$id_volume."<br>";
             	// dla ka¿dego dostawcy odczytaj ile doplacamy do przesy³ki ze wzglêdu na objêto¶æ
           		$data=$mdbd->select("price","delivery_price","id_zone=$this->_id_zone AND id_delivery=".$id);
				if(!empty($data)) {
           			$data_un=unserialize($data);
           			// jesli ilosc plyt jest zbyt duza i jest poza zdefiniowanym zakresem to wez maksymalna
           			// kosztow dostawy
           			if(empty($id_volume)) {
           				$max = array_pop($data_un);
           				$price_volume=$max;
           			} else {	
           				// odczytaj wartosc doplacana do przesylki
	        			$price_volume=$data_un[$id_volume];
           				// na koncu kazdej tablicy z dostawca dodajemy
           				// pole które informuje o tym jaka jest doplata
           			}
          			return $price_volume;
           		} else {
           			return 0;
           		}	
       		}
    } // end _compute_cost_delivery
    
   /**
    *
	* Pobierz dostawców z bazy danych
    *
    */
    function get_deliver($zone) {
		global $mdbd;	
		$this->_id_zone=$zone;
		// jesli kraj nie nalezy do zadnej strefy to
		if($zone == -1) {
			$data=$mdbd->select("id,name,delivery_zone","delivery","id=1","","","array");
		} else {
			// jesli kraj nalezy do jakiejs strefy
			$data=$mdbd->select("id,name,delivery_zone","delivery","delivery_zone LIKE '%".$zone."%' AND id!=1","","","array");
		}
		//print "<pre>";
		//print_r($data);
		//print "</pre>";
		return $data;
	} // end get_deliver
	

	/**
    *
	* Sprawdz ktory dostawca ubsluguje ten kraj
    *
    * @param zone - strefa dostawy
    * @param id - id dostawcy
    */
    function check_deliver($zone,$id) {
		global $mdbd;	
		global $config;
		
		//print $config->default_country."::".$this->_global_country_delivery;
		//if($config->default_country == $this->_global_country_delivery) {
		//	return true;
		//}
		if($zone == -1) {
			return true;
		} else {
			// przegladamy tallice wszystkich dostawcow
			foreach($this->_delivery_array as $key=>$value) {
				// jesli to jest ten dostawca o ktorego nam chodzi 
				if($value['id'] == $id) {
					// odkodowujemy strefy dostawy 
					$temp=unserialize($value['delivery_zone']);
					// i opuszczamy pêtlê
					break;
				}	
			}
			// sprawdzamy czy dany dostawca obsluje te strefe dostawy
			if(!empty($temp)) {
				if(array_key_exists($zone, $temp)) {
					//print "ok";
					return true;
				} else {
					//print "nie ok";
					return false;
				}
			}			
		}
	} // end check_deliver
	
	/**
    *
	* Funkcja pokazuje dostawców i ceny dostawy którzy obsluguja danych kraj
    * dla kalkulatora cen
    */
	function show_cost(& $data) {
		// przechodzimy wszystkich dostawców
		foreach($data as $key=>$value) {
			// obliczamy cene dostawy ze wzgledu na objeto¶æ
			$price_volume=$this->_compute_cost_delivery($value['id']);
			$data_un=unserialize($value['delivery_zone']);
			//jesli kraj nie jest w zadnej strefie to
			if($this->_id_zone == -1) {
				//bierzemy pierwsza wartosc bo wszystkie i tak sa takie same
				$price_zone=array_shift($data_un);
			} else {	
				// bierzemy odpowiednia warto¶æ ze wzgledu na objetosc i strefe dostawy
				$price_zone=$data_un[$this->_id_zone];
			}	
			// do tablicy dok³adamy dwa pola
			$data[$key]=$data[$key]+array("price_zone"=>$price_zone);
			$data[$key]=$data[$key]+array("price_volume"=>$price_volume);
		} 
		return;	
	} // end show_cost

   /**
    *
	* Wyswietlajaca dostawcow i koszty dostawy w Polsce 
    * dla kalkulatora cen
    */
	function show_poland(& $data) {
		global $mdbd;	
		$this->_id_zone=$zone;
		$data=$mdbd->select("id,name,delivery_zone,price_brutto","delivery","id!=1","","","array");
		foreach($data as $key=>$value) {
			$data[$key]=$data[$key]+array("price_zone"=>$value['price_brutto']);
		} 
		return;	
	} // end show_poland
} // end class Delivery_Cost
?>
