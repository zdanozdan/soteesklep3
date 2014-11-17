<?php
/**
* Interfejs aktualizacji danych tranksacji z wersji 2.5 do formatu danych w 3.0
*
* @author m@sote.pl
* @version $Id: upgrade_order.inc.php,v 1.3 2004/12/20 17:59:27 maroslaw Exp $
* @package    admin_include
*/

/* Obs³uga danych klientów */
require_once ("include/ver2.5/upgrade_users.inc.php");

/**
* @package upgrade
* @subpackage 2.5->3.0
*/
class UpgradeOrder {
    
    /* @var int limi ilo¶ci rekordów aktualizaowanych przy jednym wywo³aniu upgradeAll() */
    var $_max_results=10000;
    
    /* @var array dane transakcji odczytane z xml_description */
    var $_order_tab=array();
    
    /**
    * Konstruktor.
    * @return none
    */
    function upgradeOrder() {
        require_once ("include/my_crypt.inc");
        $this->crypt =& new MyCrypt;
        return;
    } // end upgradeOrder()
    
    /**
    * Sprawd¼ czy aktualna baza pochodzi z wersji 2.5
    * @return bool
    */
    function checkDB25() {
        global $db;
        // sprawdzamy istnienie pola crypt_xml_description, które bylo w wersji 2.5, ale nie ma go w 3.0
        $query="SELECT crypt_xml_description FROM order_register LIMIT 1";
        $result=$db->Query($query);
        if ($result!=0) return true;
        return false;
    } // end checkDB25()
    
    /**
    * Aktualizuj wszystkie dane transakcji (maksymalnie $this->_max_result rekordów)
    *
    * @return bool
    */
    function upgradeAll() {
        global $db,$mbdb,$lang;
        if (! $this->checkDB25()) return false;
        $query="SELECT * FROM order_register WHERE record_version!='30' ORDER BY id DESC LIMIT $this->_max_results";
        $result=$db->query($query);
        if ($result!=0) {
            $num_rows=$db->numberOfRows($result);
            if ($num_rows>0) {
                print $lang->upgrade_update_start."<p />\n";
                for ($i=0;$i<$num_rows;$i++) {
                    if (! $this->_upgradeRecord($result,$i)) return false;                 
                }
            }
        } else die ($db->Error());
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
    function _upgradeRecord(&$result,$i) {
        global $db,$time,$db2,$mdbd;
        
        $order_id=$db->fetchResult($result,$i,"order_id");
        $this->_order_id=$order_id;
        
        $crypt_xml_description=$db->fetchResult($result,$i,'crypt_xml_description');
        $xml_description=$this->crypt->endecrypt('',$crypt_xml_description,'de');
        
        $xml=ereg_replace("&","",$xml_description);
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
                $order_tab[strtolower($tag)]=$value;
                
            }
            
            if (($level==2) && ($type=="close")) {
                array_push($this->_order_tab,$order_tab);
            }
            
        } // end foreach
        
        $time->stop("order id=".$order_id);
        
        // zapisz dane z $this->_order_tab do bazy tj. jako rekordy do order_products
        reset($this->_order_tab);$db2=$db;
        foreach ($this->_order_tab as $order_tab) {
            $db=$db2;
            if (! $this->_insertOrderProducts($order_tab,$order_id)) return false;
        } // end foreach()
        
        // dodaj dane klienta
        $upgrade_users =& new Upgradeusers();
        $id_users=$upgrade_users->addOrderUser($order_id);
        
        // zmien status rekordu transakcji
        $mdbd->update("order_register","record_version='30',id_users_data=?","order_id=?",
        array(        
        "1,".$id_users=>'int',
        "2,".$order_id=>'int',
        )
        );
        
        return true;
    } // end _upgradeRecord()
    
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
    
    
} // end class UpgradeOrder
?>
