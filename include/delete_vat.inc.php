<?php
require_once ("include/metabase.inc");

class DeleteVat {

	
	var $status_ue;		// jesli kraj lezy w UE to zmienna ta zawiera numer strefy UE
 	var $disable;		// zmienna ktora blokuje pola w przypadku kiedy zostal podany nip UE
	var $status_vat;
	
 	/**
	 * Konstruktor obiektu
     * @return vat
     */
	function DeleteVat() {
		$this->check_vat();
	} // end DeleteVat
	
	/**
	 * Pobiez status UE
     */
	function get_status_ue() {
		return $this->status_ue;
	} // end get_status_ue
	
    function status_check($status_vat) {
        global $global_nip_eu;
        global $global_check_vat;
        global $_SESSION;
        global $sess;
    	$this->status_vat=$status_vat;
        /*print $this->disable."::"."<br>";
        print "status_ue".$this->status_ue."<br>";
        print "check".$this->check_ue_format()."<br>";
        print "status_vat".$status_vat."<br>";*/
        if(($this->check_ue_format() && $this->status_ue) && $status_vat) {
			//print "1"."<br>";
        	if(empty($_SESSION['global_nip_eu'])) {
            	//print "2"."<br>";
        		$global_nip_eu=$_REQUEST['item']['nip_eu'];
          		$sess->register("global_nip_eu",$global_nip_eu);
			}	
			if(empty($_SESSION['global_check_vat'])) {
				//print "3"."<br>";
				$global_check_vat=$_REQUEST['item']['check_vat'];
          		$sess->register("global_check_vat",$global_check_vat);
			}	
			$this->disable="disabled";
        	return true;
        } else {
			//print "4"."<br>";
        	return false;
        }
	} // status_check
	
	function set_nip_eu() {
		global $_SESSION;
		global $_REQUEST;
		if(empty($_REQUEST['item']['nip_eu'])) {
			return $_SESSION['global_nip_eu'];
		} else return $_REQUEST['item']['nip_eu'];
	}
	
	/**
	 * Pokaz pola do wpisania vatu i potwierdzenia
     * @return vat
     */
	function show_field_ue_vat() {
    	global $_REQUEST;
    	global $_SESSION;
    	global $lang;
    	global $sess;
 		
		//print "<pre>";
		//print_r($_SESSION);
		//print "</pre>";
		if(empty($_REQUEST['item']['check_vat'])) {
			$_REQUEST['item']['check_vat']=$_SESSION['global_check_vat'];
		}
    	// wywo³aj funkcje ktora sprawdzi czy mozna wyswietlic pola ktore odpowiadaja za vat UE
    	if($this->status_ue) {
   			if($_REQUEST['item']['check_vat'] == 1) {
   				$checked="checked";
   			} 
   			print "<input type=checkbox name=item[check_vat] ".$checked." value=1 onChange=\"this.form.submit();\"".$this->disable.">".$lang->vat_ue_check."<br>";
   			
   	        if(!$this->check_field_confirm()) {
   				// nie zaznaczono ze ma sie numer UE
   				print "<span style=\"color:red;\">".$lang->vat_ue_error_check."</span><br><br>";
   			} else {
   				print "<br>";
   			}
   			print "<input type=text name=item[nip_eu] size=20 value=\"".$this->set_nip_eu()."\" onChange=\"this.form.submit();\"".$this->disable.">";
   			print $lang->vat_ue."<br>";
   			if(!$this->check_ue_format()) {
   				// nieprawidlowy numer vat
   				print "<span style=\"color:red;\">".$lang->vat_ue_error."</span>";
   			}
   		} 
		return true;
 	} // end show_field_ue_vat

	function check_field_confirm() {
 		global $_REQUEST;

 		if(empty($_REQUEST['item']['check_vat'])) {
 			$_REQUEST['item']['check_vat']=$_SESSION['global_check_vat'];
 		}

 		if (empty($_REQUEST['item']['check_vat'])) {
			//zmienna nie jest ustawiaona wiec
			return false;
		} else {
			return true;
		}
	} // end check_field_confirm
 	
 	/**
	 * Funckcja sprawdza czy kraj do ktorego kupujemy nie jest krajem z UE
     * @return vat
     */
 	function check_ue_format() {
 		global $_REQUEST;
 		global $_SESSION;
 		
 		if(empty($_REQUEST['item']['nip_eu'])) {
 			$_REQUEST['item']['nip_eu']=$_SESSION['global_nip_eu'];
 		}
 		$country_delivery=$_SESSION['global_country_delivery'];
		if (preg_match("/$country_delivery\d{10}/i", $_REQUEST['item']['nip_eu'])) {
			return true;
		} else {
			return false;
		}
 	} // end row_xml()  

    /**
    * Funkcja pobiera kraj wysylki ze strony i sprawdza czy ten kraj nalezy do UE
    *
    *
    * @access public
    * @return float  wartosc zamowienia
    */
 	function check_vat() {
    	global $_REQUEST;
		global $_SESSION;
		global $database;
		global $config;
    	
    	// sprawdz czy w requescie jest okreslony kraj
		if (! empty($_REQUEST['item']['country'])) {
        	$this->country=$_REQUEST['item']['country'];
        // jesli nie to sprawdz czy jest w sesji
		} elseif (! empty($_SESSION['global_country_delivery'])) {
            $this->country=$_SESSION['global_country_delivery'];
        // jesli nie to wez z konfiga kraj domyslny
		} else {
            $this->country=$config->default_country;
        }
	   	if(!empty($this->country)) {
			//sprawdz czy kraj nalezy do ue i przypisz go zmiennej
	   		$this->status_ue=$database->sql_select("id","delivery_zone",""," WHERE country LIKE '%".$this->country."%' AND id=12");
	   	}	
	   	return true;
    }
} // end class MyBasket
?>
