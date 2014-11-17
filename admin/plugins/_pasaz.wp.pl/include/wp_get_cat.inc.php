<?php
/**
 * Obsluga pobierania kategorii i innych informacji z pasazu wp
 *
 * @author  rdiak@sote.pl
 * @version $Id: wp_get_cat.inc.php,v 1.16 2006/01/12 11:47:05 scalak Exp $
* @package    pasaz.wp.pl
 */

 
/**
 * Includowanie potrzebnych klas 
 */
require_once("include/wp/wp.inc.php");
require_once ("config/auto_config/wp_config.inc.php");
require_once ("include/ftp.inc.php");


/**
 * Klasa WpGetCat
 *
 * @package wp
 * @subpackage admin
 */
class WpGetCat extends WP {
	
	var $target='';			// gdzie ftpujemy plik

	/**
	 * Konstruktor obiektu WpGetCat
	 *
	 * @return boolean true/false
	 */
	function WpGetCat($from='') {
		global $config;
		$this->target=$config->ftp_dir."/admin/plugins/_pasaz.wp.pl/file";
		$this->WP();
		return true;
	} // end WpGetCat
	
	/**
     * Funkcja tworzy komunikat SOAP pobrania danych ze pasa¿u WP 
	 * dopuszczalne warto¶æ to: GetTree, GetProducers, GetAdvantages,
	 * GetFieldsMeaning, GetLocalFilters, GetAllProducts
	 *
     * @return string komunkat SOAP pobrania kategorii
     */
    function _wp_get_data($request) {
 		$str="<ns4:".$request.">\n";
		$str.="<Value>\n";
		$str.="<AuthLogin>".$this->_login."</AuthLogin>\n";
		$str.="<AuthPassword>".$this->_password."</AuthPassword>\n";
		$str.="<AuthSid>".$this->_sid."</AuthSid>\n";
		$str.="<Rows>\n";
		$str.="</Rows>\n";
   		$str.="</Value>\n";
   		$str.="</ns4:".$request.">\n";
   		return $str;
    } // end _wp_get_data
    
	/**
     * Funkcja tworzy komunikat SOAP pobrania danyych o wybranym produkcie z pasazu
	 *
     * @return string komunkat SOAP pobrania kategorii
     */
    function _wp_get_one_prod($id) {
 		$str="<ns4:GetOneProduct>\n";
		$str.="<Value>\n";
		$str.="<AuthLogin>".$this->_login."</AuthLogin>\n";
		$str.="<AuthPassword>".$this->_password."</AuthPassword>\n";
		$str.="<AuthSid>".$this->_sid."</AuthSid>\n";
		$str.="<Rows>\n";
		$str.="<Row>\n";
		$str.="<SrcId>".$id."</SrcId>";
		$str.="</Row>\n";
		$str.="</Rows>\n";
   		$str.="</Value>\n";
   		$str.="</ns4:GetOneProduct>\n";
   		return $str;
    } // end _wp_get_one_prod

    /**
     * Funkcja tworzy komunikat SOAP pobrania informacji o wa¿no¶ci drzewa kategorii
	 *	
     * @return string komunkat SOAP pobrania informacji o wa¿no¶ci drzewa kategorii
     */
    function _wp_get_valid_tree($treekey) {
 		$str="<ns4:IsValidTree>\n";
		$str.="<Value>\n";
		$str.="<AuthLogin>".$this->_login."</AuthLogin>\n";
		$str.="<AuthPassword>".$this->_password."</AuthPassword>\n";
		$str.="<AuthSid>".$this->_sid."</AuthSid>\n";
		$str.="<Rows>\n";
		$str.="<TreeKey>".$treekey."</TreeKey>";
		$str.="</Rows>\n";
   		$str.="</Value>\n";
   		$str.="</ns4:IsValidTree>\n";
   		return $str;
    } // end _wp_get_valid_tree
    
    /**
     * Funkcja g³ówna wywo³uj±ca odpowiednie funkcje w zale¿no¶ci od tego co chcemy pobrac
	 *
     * @return bool 
     */
    function wp_get_data() {
    	if($this->_action =='GetAdvantages') {
	    	$soap_request=$this->wp_from_complete_soap("GetAdvantages");
			$this->_wp_get_advantages($soap_request);
   		} elseif($this->_action =='GetProducers') {
	    	$soap_request=$this->wp_from_complete_soap("GetProducers");
			$this->_wp_get_producers($soap_request);
			// generuj plik z producentami 
			$this->_wp_select_producer(); 
   		} elseif($this->_action =='GetFieldsMeaning') {
   			$soap_request=$this->wp_from_complete_soap("GetFieldsMeaning");
   			$this->_wp_get_fieldsmeaning($soap_request);
   		} elseif($this->_action =='GetLocalFilters') {
	    	$soap_request=$this->wp_from_complete_soap("GetLocalFilters");
			$this->_wp_get_localfilters($soap_request);
   		} elseif($this->_action =='GetTree') {
   			$soap_request=$this->wp_from_complete_soap("GetTree");
			$this->_wp_get_tree($soap_request);
   			// generuj plik z kategoriami
			$this->_wp_select_category();
   		} elseif($this->_action =='IsValidTree') {
			$this->_wp_get_validtree();
   		}
    	return true;		
    } // end wp_get_data	

    /**
     * Funkcja czy¶ci tablice
	 *
     * @param  string $table nazwa tabeli ktor± trzeba wyczy¶ciæ
	 *
     * @return bool 
     */
    function _wp_clear_table_db($table) {
		global $mdbd;
		if($mdbd->delete($table)) {
			return true;
		} else return false;
    } // end _wp_clear_table_db
    
    /**
     * Funkcja pobiera korzysci z pasazu wp i zapisuje je w tablicy wp_adv
     * 
     * @param  string $soap_request   komunikat SOAP pobrania korzysci z pasazu WP
	 *
     * @return bool   true     dane pobrane, false w p.w.
     */
    function _wp_get_advantages($soap_request) {
		global $mdbd;
		global $lang;
    	
		if(!empty($soap_request)) {
			$content=$this->soap->send_soap_category($soap_request);
			if($this->_wp_send_request($content,'trans')) {
				$result=$this->_values[$this->_tags['RESULT'][0]]['value'];
				// jesli result jest rowne 0
				if($result == 0) {
					if($this->_wp_clear_table_db('wp_advant')) {
						foreach($this->_tags['AID'] as $key=>$value) {
							$aid=$this->_values[$value]['value'];
							$name=$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['NAME'][$key]]['value']);
							$img=$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['IMG'][$key]]['value']);
							$result=$mdbd->insert("wp_advant","aid,name,img","?,?,?",array($aid=>"int",$name=>"text",$img=>"text"));				
						}
						if($result == 'true') {
							print "<center>".$lang->wp_get_cat['advant_load_ok']."<center>";
						} else {
							print "<center>".$lang->wp_get_cat['advant_load_error']."<center>";
						}
					}	
					return false;
				} else {
					print "<br><center><font color=red>".$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['ERRMSG'][0]]['value']);
					print "<br>".$lang->wp_get_cat['check_config']."</font></center>";
				}	
			}		
			return false;
		}
		return false;
    } // end _wp_get_advantages()

    /**
     * Funkcja pobiera producentów z pasazu wp i zapisuje je w tablicy wp_prod
     * 
     * @param  string $soap_request   komunikat SOAP pobrania korzysci z pasazu WP
	 *
     * @return bool   true     dane pobrane, false w p.w.
     */
    function _wp_get_producers($soap_request) {
		global $mdbd;
		global $lang;
		
		if(!empty($soap_request)) {
			$content=$this->soap->send_soap_category($soap_request);
			if($this->_wp_send_request($content,'trans')) {
				$result=$this->_values[$this->_tags['RESULT'][0]]['value'];
				// jesli result jest rowne 0
				if($result == 0) {
					if($this->_wp_clear_table_db('wp_prod')) {
						foreach($this->_tags['PRID'] as $key=>$value) {
							$prid=$this->_values[$value]['value'];
							$name=$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['NAME'][$key]]['value']);
							$result=$mdbd->insert("wp_prod","prid, name","?,?",array($prid=>"int",$name=>"text"));				
						}
						if($result == 'true') {
							print "<center>".$lang->wp_get_cat['producer_load_ok']."<center>";
						} else {
							print "<center>".$lang->wp_get_cat['producer_load_error']."<center>";
						}
					}	
					return false;
				} else {
					print "<br><center><font color=red>".$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['ERRMSG'][0]]['value']);
					print "<br>".$lang->wp_get_cat['check_config']."</font></center>";
				}	
			}		
			return false;
		}
		return false;
    } // end _wp_get_producers()

    /**
     * Funkcja pobiera dodatkowe atrybuty do produktów
     * 
     * @param  string $soap_request   komunikat SOAP pobrania korzysci z pasazu WP
	 *	
     * @return bool   true     dane pobrane, false w p.w.
     */
    function _wp_get_fieldsmeaning($soap_request) {
		global $mdbd;
		global $lang;
		
		if(!empty($soap_request)) {
			$content=$this->soap->send_soap_category($soap_request);
			if($this->_wp_send_request($content,'trans')) {
				$result=$this->_values[$this->_tags['RESULT'][0]]['value'];
				// jesli result jest rowne 0
				if($result == 0) {
					if($this->_wp_clear_table_db('wp_fields')) {
						foreach($this->_tags['CID'] as $key=>$value) {
							$cid=$this->_values[$value]['value'];
							$field1=$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['FIELD1'][$key]]['value']);
							$field2=$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['FIELD2'][$key]]['value']);
							$result=$mdbd->insert("wp_fields","cid,field1,field2","?,?,?",array($cid=>"int",$field1=>"text",$field2=>"text"));				
						}
						if($result == 'true') {
							print "<center>".$lang->wp_get_cat['fields_load_ok']."<center>";
						} else {
							print "<center>".$lang->wp_get_cat['fields_load_error']."<center>";
						}
					}	
					return false;
				} else {
					print "<br><center><font color=red>".$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['ERRMSG'][0]]['value']);
					print "<br>".$lang->wp_get_cat['check_config']."</font></center>";
				}	
			}		
			return false;
		}
		return true;
    } // end _wp_get_fieldsmeaning()

    /**
     * Funkcja pobiera filtry z pasazu wp i zapisuje je w tablicy wp_filters
     * 
     * @param  string $soap_request   komunikat SOAP pobrania korzysci z pasazu WP
	 *
     * @return bool   true     dane pobrane, false w p.w.
     */
    function _wp_get_localfilters($soap_request) {
		global $mdbd;
		global $lang;

		if(!empty($soap_request)) {
			$content=$this->soap->send_soap_category($soap_request);
			if($this->_wp_send_request($content,'trans')) {
				$result=$this->_values[$this->_tags['RESULT'][0]]['value'];
				// jesli result jest rowne 0
				if($result == 0) {
					if($this->_wp_clear_table_db('wp_filters')) {
						foreach($this->_tags['CID'] as $key=>$value) {
							$cid=$this->_values[$value]['value'];
							$lfid=$this->_values[$this->_tags['LFID'][$key]]['value'];
							$lfname=$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['LFNAME'][$key]]['value']);
							$lfvalue=$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['LFVALUE'][$key]]['value']);
							$result=$mdbd->insert("wp_filters","cid,lfid,lfname,lfvalue","?,?,?,?",array($cid=>"text",$lfid=>"int",$lfname=>"text",$lfvalue=>"text"));				
						}
						if($result == 'true') {
							print "<center>".$lang->wp_get_cat['filters_load_ok']."<center>";
						} else {
							print "<center>".$lang->wp_get_cat['filters_load_error']."<center>";
						}
					}	
					return false;
				} else {
					print "<br><center><font color=red>".$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['ERRMSG'][0]]['value']);
					print "<br>".$lang->wp_get_cat['check_config']."</font></center>";
				}
			}		
			return false;
		}
		return false;
    } // end _wp_get_localfilters()

    /**
     * Funkcja pobiera drzewo kategorii z pasazu wp i zapisuje je w tablicy wp_prod
     * 
     * @param  string $soap_request   komunikat SOAP pobrania korzysci z pasazu WP
     *
     * @return bool   true     dane pobrane, false w p.w.
     */
    function _wp_get_tree($soap_request) {
		global $mdbd;
		global $lang;
		
		if(!empty($soap_request)) {
			$content=$this->soap->send_soap_category($soap_request);
			if($this->_wp_send_request($content,'trans')) {
				$result=$this->_values[$this->_tags['RESULT'][0]]['value'];
				// jesli result jest rowne 0
				if($result == 0) {
					if($this->_wp_clear_table_db('wp_tree') && $this->_wp_clear_table_db('wp_treekey') && $this->_wp_clear_table_db('wp_main_tree')) {
						// pobierz numer drzewa katalogu
						$treekey=$this->_values[$this->_tags['TREEKEY'][0]]['value'];
						// i zapisz numer drzewa do bazy danych
						$result=$mdbd->insert("wp_treekey","treekey","?",array($treekey=>"text"));
						if($result == 'true') {
							print "<center>".$lang->wp_get_cat['validtree_save_ok']."<center>";
						} else {
							print "<center>".$lang->wp_get_cat['validtree_save_error']."<center>";
							exit;	
						}
						$result='true';
						$main_cat=array();
						foreach($this->_tags['CID'] as $key=>$value) {
							$cid=$this->_values[$value]['value'];
							$path=$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['PATH'][$key]]['value']);
							$data = split('[/]', $path);
							$result=$mdbd->insert("wp_tree","cid,path","?,?",array($cid=>"int",$path=>"text"));				
							array_push($main_cat,$data[2]);
						}
						$main_cat=array_unique($main_cat);
						foreach($main_cat as $value1) {
							$result=$mdbd->insert("wp_main_tree","name","?",array($value1=>"text"));				
						}	
						if($result == 'true') {
							print "<center>".$lang->wp_get_cat['tree_load_ok']."<center>";
						} else {
							print "<center>".$lang->wp_get_cat['tree_load_error']."<center>";
						}
					}	
					return false;
				} else {
					print "<br><center><font color=red>".$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['ERRMSG'][0]]['value']);
					print "<br>".$lang->wp_get_cat['check_config']."</font></center>";
				}	
			}		
			return false;
		}
		return false;
    } // end _wp_get_tree()

    /**
     * Funkcja sprawdza czy drzewko kategorii jest aktualne
     * 
     * @return bool   true     dane pobrane, false w p.w.
     */
    function _wp_get_validtree() {
		global $mdbd;
		global $lang;
		
		//pobieramy z bazy danych aktualny klucz wa¿no¶ci kategorii
		$data=$mdbd->select("treekey","wp_treekey","1=?",array(1=>"int"));
		// wysy³amy do pasazu zapytanie z naszym kluczem o jego aktualno¶æ
		$soap_request=$this->wp_from_complete_soap("IsValidTree","",$data);
		if(!empty($data)) {
			if(!empty($soap_request)) {
				$content=$this->soap->send_soap_category($soap_request);
				if($this->_wp_send_request($content,'trans')) {
					$result=$this->_values[$this->_tags['RESULT'][0]]['value'];
					// jesli result jest rowne 0
					if($result == 0) {
						$treekeyvalid=$this->_values[$this->_tags['TREEKEYVALID'][0]]['value'];
						if($treekeyvalid == 0) {
							print "<center>".$lang->wp_get_cat['validtree_ok']."<center>";
						} else {
							print "<center>".$lang->wp_get_cat['validtree_error']."<center>";
						}
						return true;
					} else {
						print "<br><center><font color=red>".$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['ERRMSG'][0]]['value']);
						print "<br>".$lang->wp_get_cat['check_config']."</font></center>";
						
					}	
				}		
				return false;
			}		
		} else {
			// tabela jest pusta wiec trzeba probrac kategorie.
			print "<center>".$lang->wp_get_cat['validtree_error']."<center>";
		}
		return false;
    } // end _wp_get_validtree()

    /**
	 * Funkcja  tworzy liste rozwijana z kategorii pasa¿u WP.
	 *
	 * @return boolean true/false
	 */
	function _wp_select_category() {
		global $database;
		global $DOCUMENT_ROOT;
		global $wp_config;
		$file_name="wp_category.php";
		$file_name_cut="wp_category_cut.php";
		$str=$database->sql_select_select("wp_tree","item[wp_category]","cid","path","","","default=----wybierz----");
		
		if  ($fd=fopen("$DOCUMENT_ROOT/tmp/$file_name","w+")) {
			fwrite($fd,$str,strlen($str));
			fclose($fd);
			$this->load_ftp($file_name);
			//unlink("$DOCUMENT_ROOT/tmp/$file_name");
			$data=file("$DOCUMENT_ROOT/plugins/_pasaz.wp.pl/file/$file_name",1);
			$str='';
			while(list($line_num,$line)=each($data)){
				if( strstr($line,'select') ||  strstr($line,'Wybierz')) {
					$str.=$line;
				}
				foreach (@$wp_config->wp_category as $wp_cat) {
					if (strstr($line,@$wp_cat)) {
						$str.= $line;
					}
				}
			}
			$fd=@fopen("$DOCUMENT_ROOT/tmp/$file_name_cut","w+");
			fwrite($fd,$str,strlen($str));
			fclose($fd);
			$this->load_ftp($file_name_cut);
			//unlink("$DOCUMENT_ROOT/tmp/$file_name_cut");
		} else {
			return false;
		}
		return true;
	} // end _wp_select_category

    /**
	 * Funkcja  tworzy liste rozwijana z producentow pasa¿u WP.
	 *
	 * @return boolean true/false
	 */
	function _wp_select_producer() {
		global $database;
		global $DOCUMENT_ROOT;
		global $wp_config;

		$file_name="wp_producer.php";
		$str=$database->sql_select_select("wp_prod","item[wp_producer]","prid","name",""," ORDER BY name ","default=----wybierz----");
		if  ($fd=fopen("$DOCUMENT_ROOT/tmp/$file_name","w+")) {
			fwrite($fd,$str,strlen($str));
			fclose($fd);
			$this->load_ftp($file_name);
			unlink("$DOCUMENT_ROOT/tmp/$file_name");
		} else {
			return false;
		}
		return true;
	} // end _wp_select_producer

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
} // end class WpGetCat
