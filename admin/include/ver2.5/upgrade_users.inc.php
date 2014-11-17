<?php
/**
* Interfejs aktualizacji danych klientów z wersji 2.5 do formatu danych w 3.0
*
* @author m@sote.pl
* @version $Id: upgrade_users.inc.php,v 1.6 2005/09/02 09:05:30 maroslaw Exp $
* @package    admin_include
*/

/**
* @package upgrade
* @subpackage 2.5->3.0
*/
class UpgradeUsers {
    
    /* @var int limi ilo¶ci rekordów aktualizaowanych przy jednym wywo³aniu upgradeAll() */
    var $_max_results=10000;
    
    /**
    * Konstruktor
    */
    function UpgradeUsers() {
        require_once ("include/my_crypt.inc");
        $this->crypt =& new MyCrypt;
        return;
    } // end UpgradeUsers()
    
    function upgradeAll() {
        $this->_upgradeAllUsers();
        return;
    } // end upgradeAll()
    
    
    /**
    * Aktualizuj dane klienta dla transakcji
    *
    * @param int $order_id order_id transakcji
    * @return int|false id dodanego klienta
    */
    function addOrderUser($order_id) {
        global $db,$db2,$lang;
        
        $query="SELECT * FROM order_register WHERE order_id=? LIMIT $this->_max_results";
        $prepared_query=$db->prepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order_id);
            $result=$db->executeQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->numberOfRows($result);
                if ($num_rows>0) {
                    $db2=$db;
                    if (! $this->_upgradeRecordOrder($result,0)) return false;
                    $db=$db2;
                }
            } else die ($db->Error());
        } else die ($db->Error());
        
        return $this->id_users;
    } // end addOrderUser()
    
    /**
    * Aktualizuj dane 1 rokordu klienta z danych transakcji
    *
    * @param mixed $rsult wynik zapytania z bzay danych
    * @param int numer wiersza wyniku zapytania z bzay danych
    * @return bool
    */
    function _upgradeRecordOrder($result,$i) {
        global $db,$time,$mdbd;
        
        $id=$db->fetchResult($result,$i,"id");
        $this->_id=$id;
        
        $crypt_xml_user=$db->fetchResult($result,$i,'crypt_xml_user');
        $xml_user=$this->crypt->endecrypt('',$crypt_xml_user,'de');
        
        $xml=ereg_replace("&","",$xml_user);
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
                $user_tab[strtolower($tag)]=$value;
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
        
        return $id_users;
    } // end insertUser()
    
    /**
    * Aktualizuj wszystkie dane klientów
    * @return bool
    */
    function _upgradeAllUsers() {
        global $db,$db2,$lang;
        
        $query="SELECT * FROM users ORDER BY id DESC LIMIT $this->_max_results AND record_version!='30'";
        $prepared_query=$db->prepareQuery($query);
        if ($prepared_query) {            
            $result=$db->executeQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->numberOfRows($result);
                if ($num_rows>0) {
                    $db2=$db;
                    for ($i=0;$i<$num_rows;$i++) {
                        if (! $this->_upgradeUser($result,$i)) return false;
                    }
                    $db=$db2;
                }
            } else die ($db->Error());
        } else die ($db->Error());
        
        return true;
    } // end _upgradeAllUsers()
    
    /**
    * Aktualizu dane 1 klienta - przekoduj dane nowym kluczem
    *
    * @param mixed $result wynik zapytania za bazy danych
    * @param int   $i      numer wiersza wybniku zapytania z bzay danych
    * @result bool
    */
    function _upgradeUser($result,$i) {
        global $mdbd,$db;
        
        $id=$db->fetchResult($result,$i,"id");
        $prv_key=$this->_getUserPrvKey($id);
        if (empty($prv_key)) $prv_key='';
        
        $data=array();$db_list='';$db_data=array();
        $tab=array("crypt_firm","crypt_street","crypt_street_n1","crypt_street_n2","crypt_country",
                   "crypt_postcode","crypt_nip","crypt_city","crypt_phone",
                   "crypt_cor_firm","crypt_cor_name","crypt_cor_surname",
                   "crypt_cor_street","crypt_cor_street_n1","crypt_cor_street_n2","crypt_cor_country",
                   "crypt_cor_postcode","crypt_cor_city","crypt_cor_phone","crypt_cor_email");
        $k=1;
        foreach ($tab as $field) {
            $decrypt_field=$this->crypt->endecrypt($prv_key,$db->fetchResult($result,$i,$field),"de"); // odkoduj
            $data[$field]=$this->crypt->endecrypt('',$decrypt_field);                                  // zakoduj na nowo
            
            // utworz elementy do zapyatania SQL
            $db_list.=$field."=?,";
            $db_data[$k.",".$data[$field]]="text";
            $k++;
        } // end foreach           
        $db_data[$k.",".$id]="int";        
                
        $mdbd->update("users",$db_list."record_version='30'","id=?",$db_data,"LIMIT 1");

        return true;
    } // end upgradeUser()
    
    /**
    * Odczytaj klucz prywatny klienta
    *
    * @param int $id id klienta
    * @return string klucz prywatny klienta
    */
    function _getUserPrvKey($id) {
        global $mdbd;        
        // odczytaj ostatni wpis dla danego klienta z tabeli users_keys
        return $mdbd->select("user_key","users_keys","id_users=?",array($id=>"int"),"ORDER BY id DESC LIMIT 1");        
    } // end _getUserPrvKey()
    
} // end UpgradeUsers
?>
