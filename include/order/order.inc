<?php
/**
* Obs³uga transakcji.
*
* @author  m@sote.pl
* @version $Id: order.inc,v 1.37 2006/06/29 14:23:15 lukasz Exp $
* @package    include
*/
/**
* Dodanie klasy generuj±cej sumê kontroln± transakcji.
*/
require_once ("include/order/checksum.inc");

/**
* Dodanie klasy obs³ugi cen
*/
require_once ("include/price.inc");

/**
* Dodaj klasê obs³ugi kodowania danych.
*/
require_once ("include/my_crypt.inc");

/**
* Dodaj obs³ugê newslettera
*/
require_once ("include/newsletter_add.inc");

/**
* Klasa obs³ugi transakcji.
* @package order
* @subpackage htdocs
*/
class OrderRegister {
    
    /**
    * Konstruktor
    *
    * @return none
    */
    function OrderRegister() {
        $this->order_id=$this->getOrderID();
        return;
    } // end OrderRegister()
    
    /**
    * Zapisz numer transakcji w sesji
    *
    * @param int $order_id numer transakcji
    *
    * @access private
    * @return none
    */
    function _register($order_id) {
        global $global_order_id,$sess;
                
        $global_order_id=$order_id;
        $this->order_id=$order_id;
        $sess->register("global_order_id",$global_order_id);
        return;
    } // end register()
    
    /**
    * Odczytaj numer zamówienia
    *
    * @return int numer zamówienia, 0 - jesli nie ma nadanego numeru order_id
    */
    function getOrderID() {
        global $_SESSION;
        
        $order_id=0;
        if (! empty($this->order_id)) {            
            $order_id=$this->order_id;
        } elseif (! empty($_SESSION['global_order_id'])) {
            $order_id=$_SESSION['global_order_id'];
        }
//        die($order_id);
        return $order_id;
    } // end getOrderID()
    
    /**
    * Odczytaj numer ID transakcji + date (dzien/miesiac/rok)
    *
    * @return string format 1001/2004/03/12, gdzie 1001 to order_id
    */
    function getOrderIDDate() {
        return $this->getOrderID()."/".date("Y/m/d");
    } // end getOrderIDDate();
    
    /**
    * @deprecated since 3.0
    */
    function xml_user() {}
    
    /**
    * Opis transakcji w XML
    * @deprecated ver. 3.0
    */
    function xml_description() {
        return;
    } // end xml_description()
    
    /**
    * Dodaj transakcje do bazy.
    * UWAGA! Uzytkownik zapisujacy do bazy transakcje, nie ma praw SELECT do tabeli.
    *
    * \@global int $this->order_id
    * \@global string $this->order_id_date
    * \@global int $global_id_pay_method id metody p³tno¶ci
    */
    function insert() {
        global $_SESSION;
        global $sess;
        global $_SERVER;
        global $global_id_pay_method;
        global $db;
        global $config;
        global $theme;
        global $mdbd;
        
        // odczytaj dane bilingowe
        if (! empty ($_SESSION['form'])) {
            $form=$_SESSION['form'];
        } else $form=array();
        
        // odczytaj dane dotsawy
        if (! empty ($_SESSION['form_cor'])) {
            $form_cor=$_SESSION['form_cor'];
        } else $form_cor=array();
        
        $global_delivery=$_SESSION['global_delivery']; // ['id'] ['name'] ['cost']
        $delivery_cost=$global_delivery['cost'];
        $id_delivery=$global_delivery['id'];
        
        // dodaj klase OrderRegister + utowrzenie obiektu tej klasy: $order
        require_once ("include/order.inc.php");
        // generuj numer zamowienia
        $order->get_id();
        // zapamietaj numer order_id i order_id_date, dane do przekazania poza klasa
        $this->order_id=$order->id;
        $this->order_id_date=$order->id_date;
        
        $order_id=$this->order_id;
        $order_session=$mdbd->select('id','order_register',"session_id='".$sess->id."'");
        if (empty($_SESSION['order_session']) && empty($order_session)) {
        	$_SESSION['order_session']=$sess->id;
        } else {
        	$_SESSION['order_session']=md5(time());
        }
        $session_id=$_SESSION['order_session'];
        $amount=$_SESSION['global_basket_amount'];
        if (in_array("discounts",$config->plugins)) {
            $my_price = new MyPrice;
            $amount=$my_price->promotionsAmount($amount);
        }
        $date_add=date("Y-m-d");
        $time_add=date("H:i:s");
        $id_pay_method=$global_id_pay_method;
        $remote_ip=$_SERVER['REMOTE_ADDR'];
        
       // dodaj ades e-mail klienta do bazy newslettera
       if ($form['news']=='yes'){
       	add_2_newsletter($form['email'],$date_add,1,1,@$email_md5,":1:",$config->lang);     
       }

        require_once("include/my_crypt.inc");
        global $my_crypt;
        $crypt_email=$my_crypt->endecrypt("",$form['email']);
        
        // @deprecated ver. 3.0 $crypt_xml_description=$my_crypt->endecrypt("",$this->xml_description());
        $crypt_xml_description='';
        
        // odczytaj id uzytkownika, jesli jest zalogowany
        if (! empty($_SESSION['global_id_user'])) {
            $id_users=$_SESSION['global_id_user'];
        } else $id_users=-1;
        
        // identyfikacja partnera - modul partners
        if (! empty($_SESSION['global_partner_id'])) {
            $partner_id=$_SESSION['global_partner_id'];
            
            // oblicz prowizje dla partnera
            $rake_off=$mdbd->select("rake_off","partners","partner_id=?",array($partner_id=>"int"));  // prowizja procentowa dla danego partnera
            $rake_off_amount=$amount*($rake_off/100);                                         // prowizja dla partnera od produktu
            // end oblicz prowizje dla partnera
            
            // pobierz nazwe partnera z bazy
            $partner_name=$mdbd->select("name","partners","partner_id=?",array($partner_id=>"int"));
        } else {
            $partner_id=0;
            $rake_off_amount=0;
            $partner_name='';
        };
        // end partners module
        
        // koduj dane klienta
        $crypt_xml_user=$my_crypt->endecrypt("",$this->xml_user());
        $crypt_name=$my_crypt->endecrypt("",$form['name']." ".$form['surname']);
        
        // statusy domyslne
        $id_status=0;
        $confirm=0;
        
        // sprawdz czy produkt byl polecany wczesniej przez innego uzytkownika sklepu
	    $items=@$_SESSION['global_basket_data']['items'];
        foreach ($items as $key=>$value) {
        	if ($value['user_id']==@$_SESSION['recom']['recom_product']) {
        		$recom_id_user=@$_SESSION['recom']['recom_user'];
				$recom_code=@$_SESSION['recom']['recom_code'];
				$sess->unregister('recom');
        	} else {
        		$recom_id_user="0";
				$recom_code="0";
        	}
        }
        // suma kontrolna potwierdzenia transakcji
        $amount_all=$theme->price($amount+$delivery_cost);
        $checksum = OrderChecksum::checksum($order_id,0,$amount);
        $checksum_online = OrderChecksum::checksum($order_id,0,$amount_all);
        // end

        
        // start oblicz date: do kiedy nalezy potwierdzic transakcje
        $date_confirm='0000-00-00';
        if (! empty($config->order_timeout[$id_pay_method])) {
            require_once ("Date/Calc.php");
            $day=date("d")+$config->order_timeout[$id_pay_method]-1;  // -1 bo obliczmy date wg funkcji nextDay
            $month=date("m");
            $year=date("Y");
            $date_confirm=Date_Calc::nextDay($day,$month,$year,$format="%Y-%m-%d");
        }
        // end oblicz date:
        
        // dodaj dane klienta do bazy, niezaleznie od tego czy user jest zalogowany
        // dane klient sa zapisywane jako nowy rekord
        $id_users_data=$this->_addUser($_SESSION['form'],@$_SESSION['form_cor']);
        
        // je¿eli transakcja szla przez karte - konieczne sa dodatkowe wpisy do bazy
        if ($id_pay_method==110) {
        	require_once('include/order/card.inc');
        	$card=& New Card_Pay;
        	$id_card_pay=$card->save_to_db();
        } else $id_card_pay=0;
        
        // obs³uga zamówieñ produktów punktowych
        global $shop;
        if ($shop->basket->mode=="points") {
        	require_once("include/order/points.inc");
        	$points=&new Points_pay();
        	$points->pay_with_points($this->getOrderID());
        	$is_points="1";
        } else $id_points="0";

        $query="INSERT INTO order_register (order_id,session_id,amount,delivery_cost,id_delivery,
                                            id_pay_method,date_add,time_add,remote_ip,
                                            id_users,
                                            id_status,confirm,
                                            partner_id,rake_off_amount,partner_name,
                                            checksum,checksum_online,date_confirm,
                                            id_promotions,promotions_name,promotions_discount,
                                            total_amount,id_users_data,user_description,record_version,
                                            id_card_pay,recom_id_user,recom_code,lang_id,
                                            points,info_for_client
                                            )
                       VALUES (?,?,?,?,?,
                               ?,?,?,?,
                               ?,
                               ?,?,
                               ?,?,?,
                               ?,?,?,
                               ?,?,?,
                               ?,?,?,'30',?,?,?,?,?,'info_for_client')";
        
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1, $order_id);
            $db->QuerySetText(   $prepared_query,2, $session_id);
            $db->QuerySetText(   $prepared_query,3, $amount);
            $db->QuerySetText(   $prepared_query,4, $delivery_cost);            
            $db->QuerySetText(   $prepared_query,5, $id_delivery);
            
            $db->QuerySetInteger($prepared_query,6, $id_pay_method);
            $db->QuerySetText(   $prepared_query,7, $date_add);
            $db->QuerySetText(   $prepared_query,8, $time_add);
            $db->QuerySetText(   $prepared_query,9, $remote_ip);
                        
            $db->QuerySetInteger($prepared_query,10,$id_users);            
                                   
            $db->QuerySetInteger($prepared_query,11,$id_status);
            $db->QuerySetText(   $prepared_query,12,$confirm);
            
            $db->QuerySetInteger($prepared_query,13,$partner_id);
            $db->QuerySetInteger($prepared_query,14,$rake_off_amount);
            $db->QuerySetText(   $prepared_query,15,$partner_name);
            
            $db->QuerySetText(   $prepared_query,16,$checksum);
            $db->QuerySetText(   $prepared_query,17,$checksum_online);
            $db->QuerySetText(   $prepared_query,18,$date_confirm);
            
            $db->QuerySetText(   $prepared_query,19,@$_SESSION['__promotions']['id']);
            $db->QuerySetText(   $prepared_query,20,@$_SESSION['__promotions']['name']);
            $db->QuerySetText(   $prepared_query,21,@$_SESSION['__promotions']['discount']);
                        
            $total_amount=$amount;
            $db->QuerySetText(   $prepared_query,22, $total_amount);
            $db->QuerySetText(   $prepared_query,23,$id_users_data);
            $db->QuerySetText(   $prepared_query,24,@$form['description']);
            $db->QuerySetInteger($prepared_query,25,@$id_card_pay);
            $db->QuerySetText(	 $prepared_query,26,$recom_id_user);
		    $db->QuerySetText(	 $prepared_query,27,$recom_code);
		    $db->QuerySetText(	 $prepared_query,29,@$is_points);
		    $db->QuerySetText(	 $prepared_query,28,$config->lang_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // Transakcja zostala dodana.
                // user obecny nie ma praw do selectu, wiec update jest dokonywany w pozniejszym czasie
                // na podsatwie order_id, ktory jest takze unikalnym numerem transakcji
                
                // zapisz numer order_id w sesji
                $this->_register($order_id);
                $saved_session=serialize($_SESSION);
                $mdbd->insert('order_session','order_id,data','?,?',array("$order_id"=>"int","$saved_session"=>"text"));
                // zapisz produkty z zamówienia
                $this->_registerProducts($order_id);
            } else die ("I".$db->Error());
        } else die ("J".$db->Error());

		print "xxxx";
		exit();

       
        if (! empty($_SESSION['global_partner_id'])) {
			// jesli jest to partner "Onet" to wyslij info o transakcji
            $partner_name=$mdbd->select("name","partners","partner_id=?",array($partner_id=>"int"));
            if ($partner_name == 'onet') {
		        global $onet_config;
            	@include_once ("include/onet/onet_transaction.inc.php");
            	$onet_trans=new OnetTrans;
            	$onet_trans->send_trans(1,$order_id);
            	//print_r($onet_trans);
            } elseif ($partner_name == 'wp') {
            	global $wp_config;
            	include_once ("include/wp/wp_transaction.inc.php");
            	$wp_trans=new WpTransaction();
            	// wysylamy order_id oraz potwierdzenie transakcji w tej sytuacji zawsze jest
            	// to transakcje niepotwierdzona
            	$wp_trans->SendTrans($order_id,-1);
            } elseif ($partner_name == 'interia') {
            	global $interia_config;
            	include_once ("include/interia/interia_transaction.inc.php");
            	$interia_trans=new InteriaTransaction();
            	// wysylamy order_id oraz potwierdzenie transakcji w tej sytuacji zawsze jest
            	// to transakcje niepotwierdzona
            	$interia_trans->SendTrans($order_id,1);
            } 
            
        }        
        return;
    } // end insert()
    
    /**
    * Dodaj dane zamawiaj±cego oraz dane odbiorcy do bazy klientów.
    * Dane klienta z zamówienia s± dodawane jako nowy rekord do tabeli "users", niezale¿nie od tego
    * czy klient by³ zalogowany czy nie. Rozwi±zanie takie umo¿liwia na zapamiêtanie
    * modyfikacji adresu i danych osoby zalogowanej i nie powoduje zmiany danych w zamówieniu
    * przy zmianie danych klienta.
    *
    * @param array $form
    * @param array $form_cor
    *
    * @access private
    * @return int  ID dodanego klienta, lub 0 jesli nie uda³o siê dodaæ klienta    
    */
    function _addUser($form,$form_cor=array()) {
        global $db,$_SERVER;
        
        $crypt =& new MyCrypt;
        
        // podstaw dodatkowe dane, które bêd± zapisywane w tabeli users
        $form['last_ip']=$_SERVER['REMOTE_ADDR'];
        $form['date_add']=date("Y-m-d");
        $form['login']=$this->_maxIDUsers()+1;          
        $form['password']=md5(rand(1,100000).$form['login'].time());      // losowe haslo
        
                
        $query1="INSERT INTO users (
                                   crypt_firm,crypt_name,crypt_surname,
                                   crypt_street,crypt_street_n1,crypt_street_n2,
                                   crypt_country,crypt_postcode,crypt_city,
                                   crypt_phone,crypt_email,crypt_nip,
                                   crypt_cor_firm,crypt_cor_name,crypt_cor_surname,
                                   crypt_cor_street,crypt_cor_street_n1,crypt_cor_street_n2,
                                   crypt_cor_country,crypt_cor_postcode,crypt_cor_city,
                                   crypt_cor_phone,crypt_cor_email,
                                   date_add,last_ip,order_data,
                                   crypt_login,crypt_password,record_version,remark_admin)
                            VALUES (
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?,?,
                                    ?,?,
                                    ?,?,1,
                                    ?,?,30,'rm')";
        $prepared_query1=$db->PrepareQuery($query1);
        if ($prepared_query1) {            
            $db->QuerySetText($prepared_query1,1,$crypt->endecrypt('',@$form['firm']));
            $db->QuerySetText($prepared_query1,2,$crypt->endecrypt('',@$form['name']));
            $db->QuerySetText($prepared_query1,3,$crypt->endecrypt('',@$form['surname']));
            $db->QuerySetText($prepared_query1,4,$crypt->endecrypt('',@$form['street']));
            $db->QuerySetText($prepared_query1,5,$crypt->endecrypt('',@$form['street_n1']));
            $db->QuerySetText($prepared_query1,6,$crypt->endecrypt('',@$form['street_n2']));
            $db->QuerySetText($prepared_query1,7,$crypt->endecrypt('',@$form['country']));
            $db->QuerySetText($prepared_query1,8,$crypt->endecrypt('',@$form['postcode']));
            $db->QuerySetText($prepared_query1,9,$crypt->endecrypt('',@$form['city']));
            $db->QuerySetText($prepared_query1,10,$crypt->endecrypt('',@$form['phone']));
            $db->QuerySetText($prepared_query1,11,$crypt->endecrypt('',@$form['email']));
            $db->QuerySetText($prepared_query1,12,$crypt->endecrypt('',@$form['nip']));
            $db->QuerySetText($prepared_query1,13,$crypt->endecrypt('',@$form_cor['firm']));
            $db->QuerySetText($prepared_query1,14,$crypt->endecrypt('',@$form_cor['name']));
            $db->QuerySetText($prepared_query1,15,$crypt->endecrypt('',@$form_cor['surname']));
            $db->QuerySetText($prepared_query1,16,$crypt->endecrypt('',@$form_cor['street']));
            $db->QuerySetText($prepared_query1,17,$crypt->endecrypt('',@$form_cor['street_n1']));
            $db->QuerySetText($prepared_query1,18,$crypt->endecrypt('',@$form_cor['street_n2']));
            $db->QuerySetText($prepared_query1,19,$crypt->endecrypt('',@$form_cor['country']));
            $db->QuerySetText($prepared_query1,20,$crypt->endecrypt('',@$form_cor['postcode']));
            $db->QuerySetText($prepared_query1,21,$crypt->endecrypt('',@$form_cor['city']));
            $db->QuerySetText($prepared_query1,22,$crypt->endecrypt('',@$form_cor['phone']));
            $db->QuerySetText($prepared_query1,23,$crypt->endecrypt('',@$form_cor['email']));
            $db->QuerySetText($prepared_query1,24,$form['date_add']);
            $db->QuerySetText($prepared_query1,25,$form['last_ip']);
            $db->QuerySetText($prepared_query1,26,$crypt->endecrypt('',@$form['login']));
            $db->QuerySetText($prepared_query1,27,$form['password']);

            $result1=$db->ExecuteQuery($prepared_query1);
            if ($result1!=0) 
	      {
                // dane klienta zosta³y poprawnie dodane do bazy
                // odczytaj ID kleinta                                
                return $this->_maxIDUsers();
	      } 
	    else 
	      die ("F".$db->Error());
        } 
	else die ("G".$db->Error());           
        
        return 0;
    } // end _addUser()
    
       /**
    * Dodaj dane zamawiaj±cego oraz dane odbiorcy do bazy klientów.
    * Dane klienta z zamówienia s± dodawane jako nowy rekord do tabeli "users", niezale¿nie od tego
    * czy klient by³ zalogowany czy nie. Rozwi±zanie takie umo¿liwia na zapamiêtanie
    * modyfikacji adresu i danych osoby zalogowanej i nie powoduje zmiany danych w zamówieniu
    * przy zmianie danych klienta.
    *
    * @param array $form
    * @param array $form_cor
    *
    * @access private
    * @return int  ID dodanego klienta, lub 0 jesli nie uda³o siê dodaæ klienta    
    */
    function _updateUser($id,$form,$form_cor=array()) {
        global $db,$_SERVER;
        
        $crypt =& new MyCrypt;
        
        // podstaw dodatkowe dane, które bêd± zapisywane w tabeli users
        $form['last_ip']=$_SERVER['REMOTE_ADDR'];
        $form['date_add']=date("Y-m-d");
        
                
        $query1="UPDATE users SET  crypt_firm=?,crypt_name=?,crypt_surname=?,
                                   crypt_street=?,crypt_street_n1=?,crypt_street_n2=?,
                                   crypt_country=?,crypt_postcode=?,crypt_city=?,
                                   crypt_phone=?,crypt_email=?,crypt_nip=?,
                                   crypt_cor_firm=?,crypt_cor_name=?,crypt_cor_surname=?,
                                   crypt_cor_street=?,crypt_cor_street_n1=?,crypt_cor_street_n2=?,
                                   crypt_cor_country=?,crypt_cor_postcode=?,crypt_cor_city=?,
                                   crypt_cor_phone=?,crypt_cor_email=?,last_ip=? WHERE id=?";

        $prepared_query1=$db->PrepareQuery($query1);
        if ($prepared_query1) {            
            $db->QuerySetText($prepared_query1,1,$crypt->endecrypt('',@$form['firm']));
            $db->QuerySetText($prepared_query1,2,$crypt->endecrypt('',@$form['name']));
            $db->QuerySetText($prepared_query1,3,$crypt->endecrypt('',@$form['surname']));
            $db->QuerySetText($prepared_query1,4,$crypt->endecrypt('',@$form['street']));
            $db->QuerySetText($prepared_query1,5,$crypt->endecrypt('',@$form['street_n1']));
            $db->QuerySetText($prepared_query1,6,$crypt->endecrypt('',@$form['street_n2']));
            $db->QuerySetText($prepared_query1,7,$crypt->endecrypt('',@$form['country']));
            $db->QuerySetText($prepared_query1,8,$crypt->endecrypt('',@$form['postcode']));
            $db->QuerySetText($prepared_query1,9,$crypt->endecrypt('',@$form['city']));
            $db->QuerySetText($prepared_query1,10,$crypt->endecrypt('',@$form['phone']));
            $db->QuerySetText($prepared_query1,11,$crypt->endecrypt('',@$form['email']));
            $db->QuerySetText($prepared_query1,12,$crypt->endecrypt('',@$form['nip']));
            $db->QuerySetText($prepared_query1,13,$crypt->endecrypt('',@$form_cor['firm']));
            $db->QuerySetText($prepared_query1,14,$crypt->endecrypt('',@$form_cor['name']));
            $db->QuerySetText($prepared_query1,15,$crypt->endecrypt('',@$form_cor['surname']));
            $db->QuerySetText($prepared_query1,16,$crypt->endecrypt('',@$form_cor['street']));
            $db->QuerySetText($prepared_query1,17,$crypt->endecrypt('',@$form_cor['street_n1']));
            $db->QuerySetText($prepared_query1,18,$crypt->endecrypt('',@$form_cor['street_n2']));
            $db->QuerySetText($prepared_query1,19,$crypt->endecrypt('',@$form_cor['country']));
            $db->QuerySetText($prepared_query1,20,$crypt->endecrypt('',@$form_cor['postcode']));
            $db->QuerySetText($prepared_query1,21,$crypt->endecrypt('',@$form_cor['city']));
            $db->QuerySetText($prepared_query1,22,$crypt->endecrypt('',@$form_cor['phone']));
            $db->QuerySetText($prepared_query1,23,$crypt->endecrypt('',@$form_cor['email']));
            $db->QuerySetText($prepared_query1,24,$form['last_ip']);
            $db->QuerySetInteger($prepared_query1,25,$id);
            
            $result1=$db->ExecuteQuery($prepared_query1);
            if ($result1!=0) {
                // dane klienta zosta³y poprawnie dodane do bazy
                // odczytaj ID kleinta                                
                return $this->_maxIDUsers();
            } else die ("F".$db->Error());
        } else die ("G".$db->Error());
        
        return 0;
    } // end _addUser()
    
    /**
    * Odczytaj maksymalne ID kleinta w bazie
    * @access private
    * @return int max ID
    */
     function _maxIDUsers() {
        global $db;
        $query2="SELECT max(id) AS maxid FROM users LIMIT 1";
        $db->soteSetModSQLOff();
        $result2=$db->Query($query2);
        if ($result2!=0) {
            $num_rows2=$db->NumberOfRows($result2);
            if ($num_rows2>0) {
            	$db->soteSetModSQLOn();
                return $db->FetchResult($result2,0,"maxid");
            } else return 0;
        } else die ("E".$db->Error());
    } // end _maxIDUsers()
    
     /**
    * Odczytaj id_users kleinta w bazie
    * @access private
    * @return int max ID
    */
    function _getIDUsers($order_id) {
        global $db;
        $query2="SELECT id_users_data FROM order_register WHERE order_id=$order_id";
        $result2=$db->Query($query2);
        if ($result2!=0) {
            //$db->QuerySetInteger($result2,0,$order_id);
            $num_rows2=$db->NumberOfRows($result2);
            if ($num_rows2>0) {
                return $db->FetchResult($result2,0,"id_users_data");
            } else return 0;
        } else die ("E".$db->Error());
    } // end _maxIDUsers()
    
    /**
    * Generuj opis opcji produktu
    *
    * @param array $options dane opcji
    *
    * @access private
    * @return string opis opcji, który zostanie zapisany pó¼niej w bazie danych
    */
    function _getOptions($options) {
        if (is_array($options)) {
            reset($options);$o='';
            foreach ($options as $key=>$val) {
                $o.=$val.";";
            }
            $o=substr($o,0,strlen($o)-1);
            return $o;
        } else return '';
    } // end _getOptions()
    
    /**
    * Zapisz produkty do danej transakcji w bazie.
    *
    * @param int $order_id order_id transakcji
    *
    * @access private
    * @return none
    */
    function _registerProducts($order_id) {
        global $db;
        global $my_basket;
        global $config, $mdbd;
        
        
        $items=&$my_basket->items;
        if (@$config->depository['update_num_on_action'] == 'on_take_order') {
            $res_available = $mdbd->select("user_id,num_from,num_to", "available", "1=1", array(), '', 'array');
        }
        reset($items);$pos=0;
        foreach ($items as $item) {
            $pos++;
            $options=$this->_getOptions(@$item['data']['options']);            
            $query="INSERT INTO order_products (order_id,user_id_main,price_brutto,vat,name,num,currency,measure,
                                                id_category1,id_category2,id_category3,id_category4,id_category5,
                                                category1,category2,category3,category4,category5,
                                                id_producer,producer,
                                                promotion,new,bestseller,discount,
                                                date_add,basket_pos,time_from,
                                                options,points_value)
                           VALUES (?,?,?,?,?,?,?,?,
                                   ?,?,?,?,?,
                                   ?,?,?,?,?,
                                   ?,?,
                                   ?,?,?,?,
                                   ?,?,?,
                                   ?,?)";
            $prepared_query=$db->PrepareQuery($query);
            if ($prepared_query) {
                $db->QuerySetInteger($prepared_query,1,$order_id);
                $db->QuerySetText(   $prepared_query,2,$item['data']['user_id']);
                $db->QuerySetText(   $prepared_query,3,$item['price']);
                $db->QuerySetText(   $prepared_query,4,$item['data']['vat']);
                $db->QuerySetText(   $prepared_query,5,$item['name']);
                
                
                $db->QuerySetText(   $prepared_query,6,$item['num']);
                $db->QuerySetText(   $prepared_query,7,$item['data']['currency']);
                $db->QuerySetText(   $prepared_query,8,'');
                
                $db->QuerySetText(   $prepared_query,9,@$item['data']['category']['id_category1']);
                $db->QuerySetText(   $prepared_query,10,@$item['data']['category']['id_category2']);
                $db->QuerySetText(   $prepared_query,11,@$item['data']['category']['id_category3']);
                $db->QuerySetText(   $prepared_query,12,@$item['data']['category']['id_category4']);
                $db->QuerySetText(   $prepared_query,13,@$item['data']['category']['id_category1']);
                
                $db->QuerySetText(   $prepared_query,14,@$item['data']['category']['category1']);
                $db->QuerySetText(   $prepared_query,15,@$item['data']['category']['category2']);
                $db->QuerySetText(   $prepared_query,16,@$item['data']['category']['category3']);
                $db->QuerySetText(   $prepared_query,17,@$item['data']['category']['category4']);
                $db->QuerySetText(   $prepared_query,18,@$item['data']['category']['category5']);
                
                $db->QuerySetText(   $prepared_query,19,@$item['data']['category']['id_producer']);
                $db->QuerySetText(   $prepared_query,20,@$item['data']['category']['producer']);
                
                $db->QuerySetText(   $prepared_query,21,0);
                $db->QuerySetText(   $prepared_query,22,0);
                $db->QuerySetText(   $prepared_query,23,0);
                $db->QuerySetText(   $prepared_query,24,0);
                
                
                $db->QuerySetText(   $prepared_query,25,date("Y-m-d"));
                $db->QuerySetInteger($prepared_query,26,$pos);
                $db->QuerySetText(   $prepared_query,27,0);
                $db->QuerySetText(   $prepared_query,28,@$options);
                $db->QuerySetText(   $prepared_query,29,@$item['points_value']);
                
                $result=$db->ExecuteQuery($prepared_query);
                if ($result!=0) {
                    // rekord zosta³ poprawnie dodany do bazy
                    // debug: print "<pre>";print_r($item);print "</pre>";
                    if (@$config->depository['update_num_on_action'] == 'on_take_order') { // zdejmij produkty z magazynu
                    
                        $user_id_main = $item['data']['user_id'];
                        $num = $item['num'];
                        
                        $res = $mdbd->select("num,min_num,id", "depository", "user_id_main=?", array($user_id_main => 'text'), '', 'array');
                        if(is_array($res) && (count($res) == 1)) {
                            $base_num = $res[0]['num'];
                            $res_num = $base_num - $num;
                            $res_num_positive = $res_num;
                            if($res_num_positive < 0)
                                $res_num_positive = 0;
                                
                            $mdbd->update("depository", "num=$res_num", "user_id_main=?", array($user_id_main => 'text')); // update depository

                            
                            if(!empty($res_available)) {
                                $av_id = 0;
                                reset($res_available);
                                while (($av_id == 0) && (list($key, $val) = each($res_available))) {
                                    $a = $val['user_id'];
                                    $from = $val['num_from'];
                                    $to = $val['num_to'];
                                    if($to != '*') {
                                        if (($from <= $res_num_positive) && ($res_num_positive <= $to)) {
                                            $av_id = $a;
                                        }
                                    }
                                    else {
                                        $last_id = $a;
                                    }
                                }
                                if($av_id == 0) {
                                    $av_id = $last_id;
                                }
                                if(($av_id == '') || (!is_numeric($av_id)))
                                    $av_id = 0;
                                $mdbd->update("main","id_available=$av_id", "user_id=?", array($user_id_main => "text"));
                            }

                        }
                    }
                } else die ($db->Error());
                
            } else die ($db->Error());
            
        } // end foreach
        
        return;
    } // end _registerProducts()
    
    /**
    * Aktualizuj dane transakcji
    *
    * \@global int $id_pay_method id methody p³atno¶ci
    * @return none
    */
    function update($order_id) {
        global $db;
        global $global_id_pay_method;
        global $mdbd;
        if (empty($order_id)) return;
        
        $query="UPDATE order_register SET id_pay_method=? WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$global_id_pay_method);
            $db->QuerySetInteger($prepared_query,2,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
            	$id_users_data=$this->_getIDUsers($order_id);
                $this->_updateUser($id_users_data,$_SESSION['form'],@$_SESSION['form_cor']);
                $saved_session=serialize($_SESSION);
                $order_id=$this->getOrderID();
                
                $new_sess_id=md5(time());
                $mdbd->update('order_register',"session_id='$new_sess_id'","order_id=$order_id");
                $_SESSION['order_session']=$new_sess_id;
                $mdbd->update('order_session','data=?','order_id=?',array("$saved_session"=>"text","$order_id"=>"int"));
                // dane transakcji zostaly poprawnie zaktualizowane
            } else die ("C".$db->Error());
        } else die ("D".$db->Error());
        
        return;
    } // end update()
    
} // end class OrderRegister
?>
