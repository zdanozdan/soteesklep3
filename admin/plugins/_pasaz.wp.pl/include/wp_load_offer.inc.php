<?php
/**
 * £adowanie oferty do WP Pasa¿
 *
 * @author  rdiak@sote.pl
 * @version $Id: wp_load_offer.inc.php,v 1.10 2006/01/30 07:38:40 scalak Exp $
* @package    pasaz.wp.pl
 */

/**
 * Includowanie potrzebnych klas 
 */
require_once("include/wp/wp.inc.php");
include_once("include/metabase.inc");

/**
 * Klasa WpLoadOffer 
 *
 * @package wp
 * @subpackage admin
 */
class WpLoadOffer extends WP {

	var $data=array();			// produkty do eksportu
	var $data_add=array();
	var $data_update=array();
	var $data_delete=array();

    /**
     * Konstruktor obiektu WpLoadOffer  
     *
     * @return boolean true/false
     */
	function WpLoadOffer() {
		// wywolaj konstruktor obiektu rodzica.
		$this->WP();
		return true;
	} // end WpLoadOffer

    /**
     * Funkcja glowna funkcja ³adujaca ofertê do WP Pasa¿. 
     *
     * @return boolean true/false
     */
	function LoadOffer() {
		// pobierz dane z tablicy main_param
		$this->_wp_get_main_param();
		// pobierz dane z tablicy main
		$this->_wp_get_main();
		foreach($this->data as $key=>$value) {
			if($value['wp_status'] == 1) {
				// dodaj produkt to tablicy produktów dodawanych
				array_push($this->data_add,$this->data[$key]);
			} elseif($value['wp_status'] == 2) {
				// dodaj produkt to tablicy produktów aktualizowanych
				array_push($this->data_update,$this->data[$key]);
			} elseif($value['wp_status'] == 3) {
				// dodaj produkt to tablicy produktów kasowanych				
				array_push($this->data_delete,$this->data[$key]);
			} else {
				print "error";
			}
		}
		if(!empty($this->data_add)) $this->_prepare_add_xml();
		if(!empty($this->data_delete)) $this->_prepare_del_xml();
		if(!empty($this->data_update)) $this->_prepare_upd_xml();
		return true;
	} // end LoadOffer

    /**
     * Funkcja pobiera dane z bazy danych i tworzy z nich gotow± tablicê
     * z produktami z której mo¿na utworzyæ komunikat SOAP. 
     *
     * @return boolean true/false
     */
	function _wp_get_main() {
		global $database;
		global $config;
		
		$records=array(
						"id",
						"name_L0",
						"xml_description_L0",
						"price_brutto",
						"photo",
		);
		// pobieramy dane w talicy main i laczymy tablice tak aby otrzymac w jednym rekordzie
		// pelne informacje o produkcie
		foreach($this->data as $key=>$value) {
			$data=$database->sql_select_multi_array4($records,"main","user_id=".$value['user_id'],$option='');
			// zmodyfikuj dostep do fotografi
			$data[0]['photo']="http://".$config->www."/photo/".$data[0]['photo'];
			// stworz url z ktorym bedzie sie wchodzilo do sklepu z wp
			$data[0]['url']="http://".$config->www."/?id=".$value['user_id'].$this->_wp_prepare_url();
			// pobierz pola Field1 i Field2 z bazy danych
			$field=$this->_get_field12($value['wp_fields']);
			// i przypisz je do odpowiednich pol w tablicy
			$data[0]['wp_field1']=$field['field1'];
			$data[0]['wp_field2']=$field['field2'];
			$this->data[$key]['wp_valid']=preg_replace("/:0{2}$/i","",$this->data[$key]['wp_valid']);
			$this->data[$key]=$this->data[$key]+$data[0];
		}
		return true;
	} // end _wp_get_main

    /**
     * Funkcja pobiera z tablicy wp_fields dwa pola
     * odpowiednie do przekazanego argumentu cid
     *
     * @param int cid identyfikator dodatkowych kategorii
     *
     * @return array dwa pola field1 i field2
     */
	function _get_field12($cid) {
		global $mdbd;
		$data=$mdbd->select("field1,field2","wp_fields","cid=?",array($cid=>"int"));	
		return $data;
	} // end _get_field12
	
	/**
     * Funkcja wyciaga produkty do eksportu z tablicy main_param
     * 
     * @return bool   true     dane pobrane, false w p.w.
     */
	function _wp_get_main_param() {
		global $database;
		$records=array(
						"user_id",
						"wp_category",
						"wp_status",
						"wp_dictid",
						"wp_valid",
						"wp_producer",
						"wp_dest",
						"wp_advantages",
						"wp_fields",
						"wp_filters",
						"wp_ptg",
						"wp_ptg_desc",
						"wp_ptg_days",
						"wp_ptg_picurl"
						);
		$this->data=$database->sql_select_multi_array4($records,"main_param","wp_export=1",$option='');
		return true;
	} // end _wp_get_main_param
	
	
	/**
	 * Funkcja wysyla wczesniej stworzony komunikat SOAP
	 * na serwer WP Pasa¿
	 *
	 * @return string url
	 */
	function _send_offer(& $offer,$action) {
		global $DOCUMENT_ROOT;
		global $lang;
		
		if($action == 'add') {
			$file_name="wp_offer_add.xml";
			$info="AddProducts";
		} elseif($action == 'upd') {
			$file_name="wp_offer_upd.xml";
			$info="UpdateProducts";
		} elseif($action == 'del') {	
			$file_name="wp_offer_del.xml";
			$info="DeleteProducts";
		}
		if($offer) {
			$file=$DOCUMENT_ROOT."/tmp/".$file_name;
			if  ($fd=@fopen($file,"w+")) {
				fwrite($fd,$offer,strlen($offer));
				fclose($fd);
			}
			//wyslij oferte na serwer
			//print $offer;
			$content=$this->soap->send_soap_offer($offer);
			// sparsuj odpowiedz serwera wp
			$this->_wp_send_request($content,'trans');
			// zapisz zwrotina informacje do bazy danych
			$this->_insert_info_db($info,'SRCID'); 
			
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
				$data=$database->sql_select_multi_array3(array("msg","order_id","res"),"wp_logs","order_id=".$value['user_id'],"AND show_info=1");
				$str="Produkt <b>".$data['order_id']."</b>";
				if($data['res'] == 0) {
					$str.=" za³adowany poprawnie<br>"; 
				} else {
					$str.=" za³adowany niepoprawnie <font color=red>B³±d!!! ". $data['msg']."</font><br>";	
				}
				print $str;
			}
		} elseif ($info == "UpdateProducts") {
			foreach($this->data_update as $key=>$value) {
				$data=$database->sql_select_multi_array3(array("msg","order_id","res"),"wp_logs","order_id=".$value['user_id'],"AND show_info=1");
				$str="Produkt <b>".$data['order_id']."</b>";
				if($data['res'] == 0) {
					$str.=" zaktualizowany poprawnie<br>"; 
				} else {
					$str.=" zaktualizowany niepoprawnie <font color=red>B³±d!!! ". $data['msg']."</font><br>";	
				}
				print $str;
			}
		} elseif ($info == "DeleteProducts") {
			foreach($this->data_delete as $key=>$value) {
				//print_r($this->data_delete);
				$data=$database->sql_select_multi_array3(array("msg","order_id","res"),"wp_logs","order_id=".$value['user_id'],"AND show_info=1");
				$str="Produkt <b>".$data['order_id']."</b>";
				if($data['res'] == 0) {
					$str.=" skasowany poprawnie<br>"; 
				} else {
					$str.=" skasowany niepoprawnie <font color=red>B³±d!!! ". $data['msg']."</font><br>";	
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
		$str=$this->_wp_get_head();
		//tworzymy pelny komunikat soap zawierajacy dodawane produkty
		$str.=$this->_wp_record_add($this->data_add);
		// stopka komunikatu soap
		$str.=$this->_wp_get_foot();
		// wysylamy oferte na serwer;
		$this->_send_offer($str,"add");
		return true;
	} // end _prepare_add_xml
	
	/**
	 * Funkcja na podstawie tablicy $this->data_delete tworzy komunikat
	 * SOAP dotyczacy usuwanych produktow i wysyla go do pasazu
	 *
	 * @return string url
	 */
	function _prepare_del_xml() {
		// naglowek komunikatu soap
		$str=$this->_wp_get_head();
		//tworzymy pelny komunikat soap zawierajacy dodawane produkty
		$str.=$this->_wp_record_delete($this->data_delete);
		// stopka komunikatu soap
		$str.=$this->_wp_get_foot();
		// wysylamy oferte na serwer;
		$this->_send_offer($str,"del");
		return true;
	} // end _prepare_del_xml
	
	/**
	 * Funkcja na podstawie tablicy $this->data_delete tworzy komunikat
	 * SOAP dotyczacy usuwanych produktow i wysyla go do pasazu
	 *
	 * @return string url
	 */
	function _prepare_upd_xml() {
		// naglowek komunikatu soap
		$str=$this->_wp_get_head();
		//tworzymy pelny komunikat soap zawierajacy dodawane produkty
		$str.=$this->_wp_record_update($this->data_update);
		// stopka komunikatu soap
		$str.=$this->_wp_get_foot();
		// wysylamy oferte na serwer;
		$this->_send_offer($str,"upd");
		return true;
	} // end _prepare_upd_xml
	
	/**
	 * Funkcja zwraca url produktu .
	 *
	 * @access public
	 *
	 * @return string url
	 */
	function _wp_prepare_url() {
		global $mdbd;
		global $config;
		
		$data=$mdbd->select("partner_id,name","partners","name=?",array($this->_partner_name=>"string"));	
        $partner_id=$data['partner_id'];
		$code=md5("partner_id.$partner_id.$config->salt");                 // wygenerowanie kodu kontrolnego
        $link="&partner_id=".$partner_id."&code=".$code;    // budowanie linku
		$this->soap->chars_to_xml($link); 
        return $link;
	}
	
	
} // end class WpLoadOffer
