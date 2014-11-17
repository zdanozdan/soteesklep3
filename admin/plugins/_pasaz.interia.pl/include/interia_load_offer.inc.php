<?php
/**
 * £adowanie oferty do interia Pasa¿
 *
 * @author  rdiak@sote.pl
 * @version $Id: interia_load_offer.inc.php,v 1.2 2005/04/04 09:55:46 scalak Exp $
* @package    pasaz.interia.pl
 */

/**
 * Includowanie potrzebnych klas 
 */
require_once("include/interia/interia.inc.php");
include_once("include/metabase.inc");

/**
 * Klasa interiaLoadOffer 
 *
 * @package interia
 * @subpackage admin
 */
class interiaLoadOffer extends interia {

	var $data=array();			// produkty do eksportu
	var $data_add=array();
	var $data_update=array();
	var $data_delete=array();

    /**
     * Konstruktor obiektu interiaLoadOffer  
     *
     * @return boolean true/false
     */
	function interiaLoadOffer() {
		// wywolaj konstruktor obiektu rodzica.
		$this->interia();
		return true;
	} // end interiaLoadOffer

    /**
     * Funkcja glowna funkcja ³adujaca ofertê do interia Pasa¿. 
     *
     * @return boolean true/false
     */
	function LoadOffer() {
		// pobierz dane z tablicy main_param
		$this->_interia_get_main_param();
		// pobierz dane z tablicy main
		$this->_interia_get_main();
		foreach($this->data as $key=>$value) {
			if($value['interia_status'] == 1) {
				// dodaj produkt to tablicy produktów dodawanych
				array_push($this->data_add,$this->data[$key]);
			}
		}
		//print "<pre>";
		//print_r($this->data_add);
		//print "</pre>";
		if(!empty($this->data_add)) $this->_prepare_add_xml();
		return true;
	} // end LoadOffer

    /**
     * Funkcja pobiera dane z bazy danych i tworzy z nich gotow± tablicê
     * z produktami z której mo¿na utworzyæ komunikat SOAP. 
     *
     * @return boolean true/false
     */
	function _interia_get_main() {
		global $database;
		global $config;
		
		$records=array(
						"id",
						"name_L0",
						"xml_description_L0",
						"price_brutto",
						"photo",
						"producer",
		);
		// pobieramy dane w talicy main i laczymy tablice tak aby otrzymac w jednym rekordzie
		// pelne informacje o produkcie
		foreach($this->data as $key=>$value) {
			$data=$database->sql_select_multi_array4($records,"main","user_id=".$value['user_id'],$option='');
			// zmodyfikuj dostep do fotografi
			$data[0]['photo']="http://".$config->www."/photo/".$data[0]['photo'];
			// stworz url z ktorym bedzie sie wchodzilo do sklepu z interia
			$data[0]['url']="http://".$config->www."/?id=".$value['user_id'].$this->_interia_prepare_url();
			// pobierz pola Field1 i Field2 z bazy danych
			// i przypisz je do odpowiednich pol w tablicy
			$this->data[$key]=$this->data[$key]+$data[0];
		}
		return true;
	} // end _interia_get_main

    /**
     * Funkcja pobiera z tablicy interia_fields dwa pola
     * odpowiednie do przekazanego argumentu cid
     *
     * @param int cid identyfikator dodatkowych kategorii
     *
     * @return array dwa pola field1 i field2
     */
	function _get_field12($cid) {
		global $mdbd;
		$data=$mdbd->select("field1,field2","interia_fields","cid=?",array($cid=>"int"));	
		return $data;
	} // end _get_field12
	
	/**
     * Funkcja wyciaga produkty do eksportu z tablicy main_param
     * 
     * @return bool   true     dane pobrane, false w p.w.
     */
	function _interia_get_main_param() {
		global $database;
		$records=array(
						"user_id",
						"interia_category",
						"interia_status",
						);
		$this->data=$database->sql_select_multi_array4($records,"main_param","interia_export=1",$option='');
		return true;
	} // end _interia_get_main_param
	
	
	/**
	 * Funkcja wysyla wczesniej stworzony komunikat SOAP
	 * na serwer interia Pasa¿
	 *
	 * @return string url
	 */
	function _send_offer(& $offer,$action) {
		global $DOCUMENT_ROOT;
		global $lang;
		
		if($action == 'add') {
			$file_name="interia_offer_add.xml";
			$info="AddProducts";
		}
		if($offer) {
			$file=$DOCUMENT_ROOT."/tmp/".$file_name;
			if  ($fd=@fopen($file,"w+")) {
				fwrite($fd,$offer,strlen($offer));
				fclose($fd);
			}
			//wyslij oferte na serwer
			//print $offer;
			$this->_content=$this->soap->send_soap_offer($offer);
			// sparsuj odpowiedz serwera interia
			$this->_interia_send_request($content,'trans');
			// zapisz zwrotina informacje do bazy danych
			//$this->_insert_info_db($info,'SRCID'); 
			
			// pokaz informacje o ladowaniu produktów
			$this->_show_info($info);
			return true;
		} else {
			print "<br><center>".$lang->onet_load_offer['noprod']."<center>";
		}
		return true;
	} // end _send_add 
	
	/**
	 * Funkcja pokazuje informacje o statusie ladowania produktow.
	 *
	 * @return string url
	 */
	function _show_info($info) {
		global $database;
		//print_r($this->data_add);
		if($info == "AddProducts") {
			foreach($this->data_add as $key=>$value) {
				$this->_interia_send_request($this->_content,$type='');
				if(!array_key_exists("SOAP-ENV:FAULT", $this->_tags)) {
					$str="Produkty za³adowane poprawnie<br>"; 
				} else {
					$str="Produkty za³adowane niepoprawnie <font color=red>B³±d!!! ".$this->_values[$this->_tags['FAULTSTRING'][0]]['value']."</font><br>";	
				}
				print $str;
			}
		}
		return true;
	} // end _show_info
	
	/**
	 * Funkcja na podstawie tablicy $this->data_add tworzy komunikat
	 * SOAP dotyczacy dodawanych produktow i wysyla go do pasazu
	 *
	 * @return string url
	 */
	function _prepare_add_xml() {
		// naglowek komunikatu soap
		$str=$this->_interia_get_head();
		//tworzymy pelny komunikat soap zawierajacy dodawane produkty
		$str.=$this->_interia_record_add($this->data_add);
		// stopka komunikatu soap
		$str.=$this->_interia_get_foot();
		//print $str;
		// wysylamy oferte na serwer;
		$this->_send_offer($str,"add");
		return true;
	} // end _prepare_add_xml
	
	/**
	 * Funkcja zwraca url produktu .
	 *
	 * @access public
	 *
	 * @return string url
	 */
	function _interia_prepare_url() {
		global $mdbd;
		global $config;
		
		$data=$mdbd->select("partner_id,name","partners","name=?",array($this->_partner_name=>"string"));	
        $partner_id=$data['partner_id'];
		$code=md5("partner_id.$partner_id.$config->salt");                 // wygenerowanie kodu kontrolnego
        $link="&partner_id=".$partner_id."&code=".$code;    // budowanie linku
		$this->soap->chars_to_xml($link); 
        return $link;
	}
} // end class interiaLoadOffer
