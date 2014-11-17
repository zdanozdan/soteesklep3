<?php
/**
* Klasa obs³uguj±ca import danych do sklepu z wersji 3.0
*
* @author  m@sote.pl
* @version $Id: soteesklep25.inc.php,v 1.1 2006/01/25 09:53:31 lukasz Exp $
* @package importshop
*/

/**
* Klasa z funkcjami globalnymi dot. importu danych. Funkcje niezale¿ne od rodzaju programu, z którego s±importowane dane.
*/
require_once ("./include/importshop_main.inc.php");
require_once ("include/my_crypt.inc");

$__import_class="SOTEeSKLEP25";

/**
* Import danych z SOTEeSKLEP 3.0
* @package importshop
*/
class SOTEeSKLEP25 extends ImportShopMain {

    var $name="soteesklep25";

    /**
    * Konstruktor    
    */
    function SOTEeSKLEP25() {
        require_once ("./config/$this->name"."-config.inc.php");
        require_once ("include/my_crypt.inc");
        $this->crypt =& new MyCrypt;
        $this->crypt->gen_keys();
        return true;
    } // end SOTEeSKLEP30()

    /**
    * Je¶li id_curreny jest>1 to wstaw warto¶æ 0, je¶li id_currency=1 to skopiuj warto¶æ
    *
    * @param mixed $value
    * @return float
    */
    function changeOrZero($value) {
        if ($this->values['id_currency']==1) {
            return $value;
        } else return 0;
    } // end changeOrZero()

    /**
    * Oblicz sume kontrol± dla s³owa bazowego. 
    *    
    * @return string 
    */
    function dictionaryKeyMd5() {
        if (! empty($this->values['wordbase'])) {
            return md5($this->values['wordbase']);
        }
    } // end dictionary_key_md5()

    /**
    * Generuj sumê kontroln± potrzebn± w celu uniemo¿liwienia dodania dwóch identycznych rekordow, tj. rabatów 
    *
    * @param string $value warto¶c aktualna checksum
    * @return string
    */
    function discountChecksum($value) {
        // suma kontrolna potrzebna w celu uniemozliwienia dodania dwoch identycznych rekordow
        if (empty($value)) {
            return md5($this->values['idc_name'].$this->values['producer_name']);
        } else return $value;
    } // end discountChecksum()

    /**
     *  Crypt login - jesli login jest pusty nadaj login jako ID
     * 
     *  @param string $value warto¶æ aktualna checksum
     *  @return string
     */
     function crypt_login($value) {
	global $my_crypt;
	if (empty($value)) {
        return $my_crypt->endecrypt("",$this->values['id']);	
	} else return $value;
     } // end crypt_login()
    
     /**
      * Zwraca id dodanej dla u¿ytkownika przechowalni
      *
      * @return int
      */
     function id_wishlist() {
     	global $db;
     	$empty_basket='a:1:{i:0;s:5:"Blank";}';
     	$sql="INSERT INTO basket (data) VALUES ('$empty_basket')";
     	$result=$db->Query($sql);
     	if ($result!=0) {
     		$sql="SELECT max(id) FROM basket";
			$res=$db->Query($sql);
			$id_wishlist=$db->FetchResult($res,0,'max(id)');
			return $id_wishlist;
     	}
     	return (0);
     }
     
     function null($var) {
     	return $var;
     }
     
     
     function recordVersion() {
     	return '30';
     }
     /*
     * Przeniesione z modu³u upgradu
     *
     */
     
     var $_max_results=1000000;
    
    /* @var array dane transakcji odczytane z xml_description */
    var $_order_tab=array();
    
    
    /**
    * Sprawd¼ czy aktualna baza pochodzi z wersji 2.5
    * @return bool
    */
    function checkDB25() {
        global $db;
        // sprawdzamy istnienie pola crypt_xml_description, które bylo w wersji 2.5, ale nie ma go w 3.0
        $query="SELECT crypt_xml_description FROM order_register LIMIT 1";
        $result=$this->db2->Query($query);
        if ($result!=0) return true;
        return false;
    } // end checkDB25()
    
    /**
    * Aktualizuj wszystkie dane transakcji (maksymalnie $this->_max_result rekordów)
    *
    * @return bool
    */
    function upgradeAll($data='') {
        global $db,$mbdb,$lang;
//        if (! $this->checkDB25()) return false;
        /*$query="SELECT * FROM order_register WHERE record_version!='30' ORDER BY id DESC LIMIT $this->_max_results";
        $result=$db->query($query);
        if ($result!=0) {
            $num_rows=$db->numberOfRows($result);
            if ($num_rows>0) {
                print $lang->upgrade_update_start."<p />\n";
                for ($i=0;$i<$num_rows;$i++) {*/
                    if (! $this->_upgradeRecord($data)) return false;                 
/*                }
            }
        } else die ($db->Error());*/
        return true;
    } // end upgradeAll()
    
    /**
    * Aktualizuj 1 rekord
    *
    * @param mixed &$result wynik zapytania z bazy danych
    * @param int   $i       numer wiersza wyniku zapytania z bazy danych
    *
    * @access private
    * @return bool
    */
    function _upgradeRecord($data) {
        global $db,$time,$db2,$mdbd;
        
//        $order_id=$db->fetchResult($result,$i,"order_id");
        $order_id=$this->values["order_id"];
        $this->_order_id=$order_id;
        
        $crypt_xml_description=$data;
        $xml_description=$this->crypt->endecrypt('',$crypt_xml_description,'de');
        $xml=ereg_replace("&","",$xml_description);
        
        $xml=utf8_encode($xml);
        $parser = xml_parser_create();
        xml_parse_into_struct($parser,$xml,$values,$tags);
        xml_parser_free($parser);
        
        $time->start("order id=".$order_id);
        
        reset($values);$this->_order_tab=array();
        foreach ($values as $index) {
            $tag=$index['tag'];
            $type=$index['type'];
            $level=$index['level'];
            if (! empty($index['value'])) $value=$index['value'];
            else $value='';
            
            if (($level==2) && ($type=="open")) {
                $order_tab=array();
            }
            
            $level=$index['level'];
            if (($level==3) && ($type=="complete")) {
                $order_tab[strtolower($tag)]=utf8_decode($value);
                
            }
            
            if (($level==2) && ($type=="close")) {
                array_push($this->_order_tab,$order_tab);
            }
            
        } // end foreach
        
        $time->stop("order id=".$order_id);
        
            
        // zapisz dane z $this->_order_tab do bazy tj. jako rekordy do order_products
        reset($this->_order_tab);$db2=$db;
        $this->order_amount=0;
        foreach ($this->_order_tab as $order_tab) {
            $db=$db2;
            $this->order_amount=$this->order_amount+$order_tab['sum_brutto'];
            if (! $this->_insertOrderProducts($order_tab,$order_id)) return false;
        } // end foreach()
        
        // dodaj dane klienta
//        $upgrade_users =& new Upgradeusers();
        $id_users=$this->addOrderUser($order_id);
//        $id_users="0";
        // zmien status rekordu transakcji
     /*   $mdbd->update("order_register","record_version='30',id_users_data=?","order_id=?",
        array(        
        "1,".$id_users=>'int',
        "2,".$order_id=>'int',
        )
        );*/
//		$this->values['id_users']=$id_users;
		$this->values1['id_users_data']=$id_users;
        return true;
    } // end _upgradeRecord()
    
    function get_order_id_users_data() {
    	return $this->values1['id_users_data'];
    }
    
    function get_order_id_users() {
    	return $this->id_users;
    }
    
    function get_order_amount() {
    	return $this->order_amount;
    }
    
    /**
    * Dodaj rekord do order_products (pozycja z koszyka)
    *
    * @param  array $order_tab 1 pozy cja z koszyka
    * @param  int   $order_id   order_id zamówienia
    * @access private
    * @return bool
    */
    function _insertOrderProducts($order_tab,$order_id) {
        global $db;
        $query="INSERT INTO order_products (order_id,user_id_main,name,price_brutto,vat,num,currency) VALUES (?,?,?,?,?,?,?)";
        $prepared_query=$db->prepareQuery($query);
        if ($prepared_query) {
            $db->querySetInteger($prepared_query,1,$order_id);
            $db->querySetText($prepared_query,2,$order_tab['user_id']);
            $db->querySetText($prepared_query,3,$order_tab['name']);
            $db->querySetText($prepared_query,4,$order_tab['price_brutto']);
            $db->querySetText($prepared_query,5,$order_tab['vat']);
            $db->querySetText($prepared_query,6,$order_tab['num']);
            $db->querySetText($prepared_query,7,1);
            $result=$db->executeQuery($prepared_query);
            if ($result==0) die ($db->Error());
        } else die ($db->Error());
        return true;
    } // end _insertOrderProducts()
    
     
    /**
    * Aktualizuj dane klienta dla transakcji
    *
    * @param int $order_id order_id transakcji
    * @return int|false id dodanego klienta
    */
    function addOrderUser($order_id) {
        $id=$this->values['id'];
                    if (! $this->_upgradeRecordOrder($id)) return false;
        
        return $this->id_users;
    } // end addOrderUser()
    
    /**
    * Aktualizuj dane 1 rokordu klienta z danych transakcji
    *
    * @param mixed $rsult wynik zapytania z bzay danych
    * @param int numer wiersza wyniku zapytania z bzay danych
    * @return bool
    */
    function _upgradeRecordOrder($id) {
        global $db,$time,$mdbd;
        
//        $id=$db->fetchResult($id);
        $this->_id=$id;
        
        $crypt_xml_user=$this->values['crypt_xml_user'];
        $xml_user=$this->crypt->endecrypt('',$crypt_xml_user,'de');
        
        $xml=ereg_replace("&","",$xml_user);
        $xml=utf8_encode($xml);
        $parser = xml_parser_create();
        xml_parse_into_struct($parser,$xml,$values,$tags);
        xml_parser_free($parser);
        
        $time->start("user id=".$id);
        
        reset($values);$this->_user_tab=array();
        foreach ($values as $index) {
            $tag=$index['tag'];
            $type=$index['type'];
            $level=$index['level'];
            if (! empty($index['value'])) $value=$index['value'];
            else $value='';
            
            if (($level==2) && ($type=="open")) {
                $user_tab=array();
            }
            
            $level=$index['level'];
            if (($level==3) && ($type=="complete")) {
                $user_tab[strtolower($tag)]=utf8_decode($value);
            }
            
            if (($level==2) && ($type=="close")) {
                array_push($this->_user_tab,$user_tab);
            }
            
        } // end foreach
        $time->stop("user id=".$id);
        
        // dodaj klienta do bazy
        $this->id_users=$this->insertUser($this->_user_tab);
                
        return true;
    } // end _upgradeRecordOrder()
    
    /**
    * Dodaj dane klienta do bazy
    *
    * @param array $user_tab dane klienta
    * @return int id kleinta
    */
    function insertUser($user_tab) {
        global $mdbd;
        
        reset($user_tab);
        foreach ($user_tab as $key1=>$user_tab_data) {
            reset($user_tab_data);
            foreach ($user_tab_data as $key2=>$val2) {
                $user_tab[$key1][$key2]=$this->crypt->endecrypt('',$val2);
            }
        }
        
        if (! empty($user_tab[0])) $bill=$user_tab[0]; else $bill=array();
        if (! empty($user_tab[1])) $cor=$user_tab[1];  else $cor=array();
                
        $mdbd->insert("users","crypt_firm,crypt_name,crypt_surname,
                               crypt_street,crypt_street_n1,crypt_street_n2,crypt_country,
                               crypt_postcode,crypt_nip,crypt_city,crypt_phone,crypt_email,
                               crypt_cor_firm,crypt_cor_name,crypt_cor_surname,
                               crypt_cor_street,crypt_cor_street_n1,crypt_cor_street_n2,crypt_cor_country,
                               crypt_cor_postcode,crypt_cor_city,crypt_cor_phone,crypt_cor_email,
                               order_data",
        "?,?,?,
                                ?,?,?,?,
                                ?,?,?,?,?,
                                ?,?,?,
                                ?,?,?,?,
                                ?,?,?,?,1",
        array
        (
        "1,". @$bill['firm']=>"text",
        "2,". @$bill['name']=>"text",
        "3,". @$bill['surname']=>"text",
        "4,". @$bill['street']=>"text",
        "5,". @$bill['street_n1']=>"text",
        "6,". @$bill['street_n2']=>"text",
        "7,". @$bill['country']=>"text",
        "8,". @$bill['postcode']=>"text",
        "9,". @$bill['nip']=>"text",
        "10,".@$bill['city']=>"text",
        "11,".@$bill['phone']=>"text",
        "12,".@$bill['email']=>"text",
        "13,".@$cor['firm']=>"text",
        "14,".@$cor['name']=>"text",
        "15,".@$cor['surname']=>"text",
        "16,".@$cor['street']=>"text",
        "17,".@$cor['street_n1']=>"text",
        "18,".@$cor['street_n2']=>"text",
        "19,".@$cor['country']=>"text",
        "20,".@$cor['postcode']=>"text",
        "21,".@$cor['city']=>"text",
        "22,".@$cor['phone']=>"text",
        "23,".@$cor['email']=>"text",
        )
        );
                      
        
        // odczytaj id dodanego usera
        $id_users=$mdbd->select("id","users",1,array(),"ORDER BY id DESC LIMIT 1");
        $this->values['id_users_data']=$id_users;
        return $id_users;
    } // end insertUser()
    
    function get_users_id($id) {
    	$this->users_prv_key=$this->_getUserPrvKey($id);
    	return $id;
    }
    
    function users_data_recode($val) {
    	$decrypt_field=$this->crypt->endecrypt($this->users_prv_key,$val,"de"); // odkoduj
           $encrypt_field=$this->crypt->endecrypt('',$decrypt_field);   
           return $encrypt_field;
    }
    
    /**
    * Aktualizu dane 1 klienta - przekoduj dane nowym kluczem
    *
    * @param mixed $result wynik zapytania za bazy danych
    * @param int   $i      numer wiersza wybniku zapytania z bzay danych
    * @result bool
    */
    function _upgradeUser() {
        global $mdbd,$db;
        
        $id=$this->values['id'];
        $prv_key=$this->_getUserPrvKey($id);
        if (empty($prv_key)) $prv_key='';
        $data=array();$db_list='';$db_data=array();
        $tab=array(
        		"crypt_firm"=>$this->values['crypt_firm'],
        		"crypt_street"=>$this->values['crypt_street'],
        		"crypt_street_n1"=>$this->values['crypt_street_n1'],
        		"crypt_street_n2"=>$this->values['crypt_street_n2'],
        		"crypt_country"=>$this->values['crypt_country'],
        		"crypt_postcode"=>$this->values['crypt_postcode'],
        		"crypt_nip"=>$this->values['crypt_nip'],
        		"crypt_city"=>$this->values['crypt_city'],
        		"crypt_city"=>$this->values['crypt_city'],
        		"crypt_cor_firm"=>$this->values['crypt_cor_firm'],
        		"crypt_cor_name"=>$this->values['crypt_cor_name'],
        		"crypt_cor_surname"=>$this->values['crypt_cor_surname'],
        		"crypt_cor_street"=>$this->values['crypt_cor_street'],
        		"crypt_cor_street_n1"=>$this->values['crypt_cor_street_n1'],
        		"crypt_cor_street_n2"=>$this->values['crypt_cor_street_n2'],
        		"crypt_cor_country"=>$this->values['crypt_cor_country'],
        		"crypt_cor_postcode"=>$this->values['crypt_cor_postcode'],
        		"crypt_cor_city"=>$this->values['crypt_cor_city'],
        		"crypt_cor_phone"=>$this->values['crypt_cor_phone'],
        		"crypt_cor_email"=>$this->values['crypt_cor_email']);
        $k=1;
        foreach ($tab as $field=>$value) {
            $decrypt_field=$this->crypt->endecrypt($prv_key,$value,"de"); // odkoduj
            $this->values[$field]=$this->crypt->endecrypt('',$decrypt_field);                                  // zakoduj na nowo
            $data1[$field."unclean"]=$this->crypt->endecrypt('',$decrypt_field);                                  // zakoduj na nowo
            $data1[$field."clean"]=$this->crypt->endecrypt('',$data1[$field."unclean"],'de');                                  // zakoduj na nowo
            
        } // end foreach           
        $db_data[$k.",".$id]="int";        
        
        return true;
    } // end upgradeUser()
    
    function get_users_date_add(){
    	return $this->values['date_add'];
    }
    
    /**
    * Odczytaj klucz prywatny klienta
    *
    * @param int $id id klienta
    * @return string klucz prywatny klienta
    */
    function _getUserPrvKey($id) {
        // odczytaj ostatni wpis dla danego klienta z tabeli users_keys
        $sql="SELECT user_key FROM users_keys WHERE id_users='$id' ORDER BY id DESC LIMIT 1";
        $result=$this->db2->Query($sql);
        if ($result!=0) {
        	$num_rows=$this->db2->NumberOfRows($result);
        	if ($num_rows==1) {
        		return $this->db2->FetchResult($result,0,'user_key');
        	}
        }
    } // end _getUserPrvKey()
    
    function id_newsedit_groups() {
    	return "1";
    }
    
} // end class SOTEeSKLEP25
?>
