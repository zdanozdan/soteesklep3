<?php
/**
 * Obsluga sciagania kategorii z onet_pasaz
 *
 *
 * @author  rdiak@sote.pl
 * @version $Id: onet_get_cat.inc.php,v 1.32 2005/04/28 11:14:22 scalak Exp $
* @package    pasaz.onet.pl
 */

/**
 * Includowanie potrzebnych klas 
 */
require_once("include/onet/soap.inc.php");
require_once("include/metabase.inc");
require_once ("include/ftp.inc.php");
require_once ("lib/XMLParser/XMLParser.php");
include_once ("config/auto_config/onet_config.inc.php");

/**
 * Klasa OnetGetCat
 *
 * @package onet
 * @subpackage admin
 */
class OnetGetCat extends SOAP{
	
	var $body='';                // depesza z kategoriami odebrana z onetu
	var $values='';
	var $tags='';
	var $target='';
	var $ftp_dir='';
	var $tree='';				// drzewko sparsowanych kategorii
	var $from='onet';				// skad sa pobierane kategorie ( z pliku czy z onetu )
	
	/**
	 * Konstruktor obiektu OnetGetCat
	 *
	 * @return boolean true/false
	 */
	function OnetGetCat($from='') {
		global $database;
		global $config;

		$this->ftp_dir=$config->ftp_dir;
		$this->target=$this->ftp_dir."/admin/plugins/_pasaz.onet.pl/file";
		$this->SOAP();
		return true;
	} // end OnetGetCat
	
	/**
	 * Funkcja zwraca komunikat SOAP ktory pobiera kategorie z onet_pasaz.
	 *
	 * @return string komunikat SOAP
	 */
	function onet_get_cat_mesg(){
		$msg="<?xml version='1.0' encoding='ISO-8859-2'?>
                           <SOAP-ENV:Envelope xmlns:SOAP-ENV='http://schemas.xmlsoap.org/soap/envelope/'
                                              xmlns:xsd='http://www.w3.org/2001/XMLSchema'
                                              xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'>
                                <SOAP-ENV:Body>
                                    <ns1:getCategoryTree xmlns:ns1='urn:ImportB2B'
                                          SOAP-ENV:encodingStyle='http://xml.apache.org/xml-soap/literalxml'>
                                    </ns1:getCategoryTree>
                                </SOAP-ENV:Body>
                           </SOAP-ENV:Envelope>
                         ";
		return $msg;
	} // end onet_get_cat_mesg
	
	/**
	 * Glowna funkcja  pobierania  kategorii z onet_pasaz.
	 *
	 * @return boolean true/false
	 */
	function onet_get_tree() {
		global $onet_config;
		global $lang;
		// pobranie komunikatu soap
		$mesg=$this->onet_get_cat_mesg();
		//pobranie z configa nazwy serwera
		if($this->onet_parse_cat($mesg)) {
			print $lang->onet_get_cat['parse']."<br>";
			if($this->load_to_db()) {
				print $lang->onet_get_cat['loaddb']."<br>";
				if($this->onet_select()) {
					print $lang->onet_get_cat['file']."<br>";
				} else {
					print $lang->onet_get_cat['error_file']."<br>";
				}
			} else {
				print $lang->onet_get_cat['error_loaddb']."<br>";
			}
		} else {
			print $lang->onet_get_cat['error_parse']."<br>";
		}
		return true;
	} // end onet_get_tree
	
	/**
	 * Funkcja  tworzy liste rozwijana z kategorii onetowych.
	 *
	 * @return boolean true/false
	 */
	function onet_select() {
		global $database;
		global $DOCUMENT_ROOT;
		global $onet_config;
		$file_name="onet_category.php";
		$file_name_cut="onet_category_cut.php";
		$str=$database->sql_select_select("onet_category","item[onet_category]","id_user","name","","","opt=Wybierz kategorie dla produktu w Onet Pasa¿");
		
		if  ($fd=fopen("$DOCUMENT_ROOT/tmp/$file_name","w+")) {
			fwrite($fd,$str,strlen($str));
			fclose($fd);
			$this->load_ftp($file_name);
			unlink("$DOCUMENT_ROOT/tmp/$file_name");
			$data=file("$DOCUMENT_ROOT/plugins/_pasaz.onet.pl/file/$file_name",1);
			$str='';
			while(list($line_num,$line)=each($data)){
				if( strstr($line,'select') ||  strstr($line,'Wybierz')) {
					$str.=$line;
				}
				foreach (@$onet_config->onet_category as $onet_cat) {
					if (strstr($line,@$onet_cat)) {
						$str.= $line;
					}
				}
			}
			$fd=@fopen("$DOCUMENT_ROOT/tmp/$file_name_cut","w+");
			fwrite($fd,$str,strlen($str));
			fclose($fd);
			$this->load_ftp($file_name_cut);
			unlink("$DOCUMENT_ROOT/tmp/$file_name_cut");
		} else {
			return false;
		}
		return true;
	} // end onet_select
	
	/**
	 * Funkcja  parsowania xml z kategoriami  z onet_pasaz.
	 *
	 * @return array sprasowane kategorie w postaci tablicy
	 */
	function onet_parse_cat(&$mesg){
		global $DOCUMENT_ROOT;
		if($this->from == 'onet') {
			$fd=fopen("$DOCUMENT_ROOT/tmp/tmp_xml.xml","w");
			$xml=$this->send_soap_category($mesg);
			fwrite($fd,$xml,strlen($xml));
			fclose($fd);
		} else {
			$fd=fopen("$DOCUMENT_ROOT/tmp/tmp_xml.xml","r");
			$xml=fread($fd, filesize($fd));
			fclose($fd);
		}	
		$xml=$this->xml_to_chars($xml);
		$parser = new XMLParser($xml, 'raw');
		$this->tree = $parser->getTree();
		//print "<pre>";
		//print_r($tree);
		//print "</pre>";
		return true;		
	} // end onet_parse_cat

	/**
	 * Funkcja laduje do bazy kategorie onetowe oraz glowne kategorie onetowe
	 *
	 * @return boolean true/false
	 */
	function load_to_db() {
		global $database;

		$database->sql_delete("onet_category");
		$database->sql_delete("onet_main_category");
		
		$tree=@$this->tree['SOAP-ENV:ENVELOPE'][0]['SOAP-ENV:BODY'][0]['NS1:GETCATEGORYTREERESPONSE'][0]['RETURN'][0]['ALLCATEGORIES'][0]['CATEGORY'][0]['SUB-CATEGORIES'][0]['CATEGORY'];
		//print "<pre>";		
		//print_r($tree);
		//print "</pre>";
		if(isset($tree)) {
			foreach($tree as $key=>$value) {
				$main_category=$value['NAME'][0]['VALUE']; 
				$main_category=$this->encoding_utf8_to_8859_2($main_category);
				$database->sql_insert("onet_main_category",array("name"=>$main_category));	
				if(!empty($value['SUB-CATEGORIES'])) {
					$this->dir_path='';
					$this->get_path_cat($main_category,$value['SUB-CATEGORIES'][0]['CATEGORY']); 
				}
			}
		} else {
			return false;
		}		
		return true;
	} // end load_to_db

	/**
	 * Funkcja przeglada tablice kategorii i tworzy drzewko
	 *
	 * @return boolean true/false
	 */
	function get_path_cat($main_category,&$table) {
		global $database;
		$main=$main_category;
		foreach($table as $key1=>$value1) {
			$name1=$value1['DISPLAY-NAME'][0]['VALUE'];
			$id1=$value1['ATTRIBUTES']['ID'];
			if(!empty($value1['SUB-CATEGORIES'][0]['CATEGORY'])) {
				foreach($value1['SUB-CATEGORIES'][0]['CATEGORY'] as $key2=>$value2) {
					$name2=$value2['DISPLAY-NAME'][0]['VALUE'];
					$id2=$value2['ATTRIBUTES']['ID'];
					if(!empty($value2['SUB-CATEGORIES'][0]['CATEGORY'])) {
						foreach($value2['SUB-CATEGORIES'][0]['CATEGORY'] as $key3=>$value3) {
							$name3=$value3['DISPLAY-NAME'][0]['VALUE'];
							$id3=$value3['ATTRIBUTES']['ID'];
							if(!empty($value3['SUB-CATEGORIES'][0]['CATEGORY'])) {
								foreach($value3['SUB-CATEGORIES'][0]['CATEGORY'] as $key4=>$value4) {
									$name4=$value4['DISPLAY-NAME'][0]['VALUE'];
									$id4=$value4['ATTRIBUTES']['ID'];
									if(!empty($value4['SUB-CATEGORIES'][0]['CATEGORY'])) {
										foreach($value4['SUB-CATEGORIES'][0]['CATEGORY'] as $key5=>$value5) {
											$name5=$value5['DISPLAY-NAME'][0]['VALUE'];
											$id5=$value5['ATTRIBUTES']['ID'];
											if(!empty($value5['SUB-CATEGORIES'][0]['CATEGORY'])) {
												foreach($value5['SUB-CATEGORIES'][0]['CATEGORY'] as $key6=>$value6) {
													$name6=$value6['DISPLAY-NAME'][0]['VALUE'];
													$id6=$value6['ATTRIBUTES']['ID'];
													if(!empty($value6['SUB-CATEGORIES'][0]['CATEGORY'])) {
													} else {
														$str=$main_category."/".$name1."/".$name2."/".$name3."/".$name4."/".$name5."/".$name6;
														$this->insert_into_db($id6,$str);
													}	
												}
											} else {
												$str=$main_category."/".$name1."/".$name2."/".$name3."/".$name4."/".$name5;
												$this->insert_into_db($id5,$str);
											}
										}	
									} else {
										$str=$main_category."/".$name1."/".$name2."/".$name3."/".$name4;
										$this->insert_into_db($id4,$str);
									}	
								}
							} else {
								$str=$main_category."/".$name1."/".$name2."/".$name3;
								$this->insert_into_db($id3,$str);
							}	
						}	
					} else {
						$str=$main_category."/".$name1."/".$name2;
						$this->insert_into_db($id2,$str);
					}
				}
			} else {
				$str=$main_category."/".$name1;
				$this->insert_into_db($id1,$str);
			}
		}
		return true;
	} // get_path_cat
	
	/**
	 * Funkcja konwertuje string z utf8 na iso8859-2 oraz wrzuca do bazy danych
	 *
	 * @param string $id id kateogrii onetowej
	 * @param string $str ci±g znaków do konwersji
	 *
	 * @return boolean true/false
	 */
	function insert_into_db($id,$str) {
		global $database;
		$str=$this->encoding_utf8_to_8859_2($str);
		$database->sql_insert("onet_category",array("id_user"=>$id,"name"=>$str));
		return true;
	} // end insert_into_db
	
	/**
	 * Funkcja ftpuje plik do okrelsonej lokalizacji.
	 *
	 * @param  string $file nazwa pliku
	 *
	 * @return boolean true/false
	 */
	function load_ftp($file) {
		global $ftp;
		global $DOCUMENT_ROOT;
		$ftp->connect();
		$ftp->put("$DOCUMENT_ROOT/tmp/$file","$this->target","$file");
		$ftp->close();
		return true;
	} // end load_ftp()
} // end class OnetGetCat
?>
