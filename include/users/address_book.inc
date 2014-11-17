<?php
/**
* Zarzadzanie sql ksiazki adresowej
*
* @author  rp@sote.pl
* @version $Id: address_book.inc,v 1.3 2005/12/09 12:42:11 lukasz Exp $
* @package    include
*/

/**
* Dodaj obs³ugê kodowania.
*/
require_once ("include/my_crypt.inc");

/**
* Ksi±¿ka adresowa
*
* @package users
* @subpackaeg addres_book
*/
class AddressBook {
    
    /**
    * @var int maksymalna liczba rekorów na stronie.
    */
    var $maxRecords=12;
    
    /**
    * @var int maksymalna liczba rekorów w wierszu.
    */
    var $records_in_row=3;
    
    var $debug=false;
    
    /**
    * Dodawanie wartosci rekordow w sesji po dodaniu wpisu w celu szybszego odswiezenie danych
    *
    * @praram int $i maksymalna dopuszczalna liczba rekordow
    *
    * @return none
    */
    function sessionAdd(){
        global $sess, $_SESSION, $address_book_rec;
        if(empty($_SESSION['address_book_rec']['records_no'])){
            $_SESSION['address_book_rec']['records_no']=0;
        }
        $count=$_SESSION['address_book_rec']['records_no']+1;
        $address_book_rec=array("records_no"=>$count);
        $sess->register("address_book_rec",$address_book_rec);
    } // end sessionAdd()
    
    /**
    * Usuwanie wartosci rekordow z sesji po usunieciu wpisu w celu szybszego odswiezenia danych
    *
    * @praram int $i maksymalna dopuszczalna liczba rekordow
    *
    * @access public
    * @return none
    */
    function sessionDelete(){
        global $sess, $_SESSION, $address_book_rec;
        if(empty($_SESSION['address_book_rec']['records_no'])){
            $_SESSION['address_book_rec']['records_no']=1;
        }
        $count=$_SESSION['address_book_rec']['records_no']-1;
        $address_book_rec=array("records_no"=>$count);
        $sess->register("address_book_rec",$address_book_rec);
    } // end sessionDelete()
    
    /**
    * Wyswietlanie linku >>dodaj adres<< w ksiazce
    *
    * @praram int $i maksymalna dopuszczalna liczba rekordow
    *
    * @access public
    * @return none
    */
    function maxRecord(){
        global $_SESSION, $theme, $lang, $sess;
        // jesli jest to pierwsze wywolanie ksiazki odczytaj ilosc rekordow z bazy
        if(empty($_SESSION['address_book_rec']['records_no'])){
            $data=$this->_selectData();
            $count=count($data);
            $address_book_rec=array("records_no"=>$count);
            $sess->register("address_book_rec",$address_book_rec);
        }
        $i=$this->maxRecords;
        if (@$_SESSION['address_book_rec']['records_no']<=1) {
            $theme->add_rec_top="&raquo;&nbsp;<a href=\"/go/_users/address_book1.php\">".$lang->address_book_add."</a>&nbsp;&laquo;";
            $theme->add_rec_bottom="&nbsp;";
            return(0);
        }
        else if ($_SESSION['address_book_rec']['records_no']<$i) {
            $theme->add_rec_top="&raquo;&nbsp;<a href=\"/go/_users/address_book1.php\">".$lang->address_book_add."</a>&nbsp;&laquo;";
            $theme->add_rec_bottom="&raquo;&nbsp;<a href=\"/go/_users/address_book1.php\">".$lang->address_book_add."</a>&nbsp;&laquo;";
            return(0);
        }
        else if ($_SESSION['address_book_rec']['records_no']>=$i) {
            $theme->add_rec_top="&nbsp;";
            $theme->add_rec_bottom="&nbsp;";
            return(0);
        } else {
            $theme->add_rec_top="&nbsp;";
            $theme->add_rec_bottom="&nbsp;";
            
            return(0);
        }
    } // end maxRecord()
    
    /**
    * Wstawianie rekordu do formularza
    *
    * @praram int $ins id rekordu do wstawienia
    *
    * @access public
    * @return none
    */
    Function pasteRecord(){
        global $mdbd,$_SESSION,$sess,$theme,$form_cor,$_REQUEST;
        
        if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;
        
        if(!empty($_REQUEST['id'])){
            $id=$_REQUEST['id'];
        } else {
            return(0);
        }
        $data=$this->_selectData();
        if(empty($data)) return;
        
        $data=$this->_convertData($data);
        if(@$_SESSION['global_id_user']!=$data['id_users']) return;
        $form_cor=$data;
        if (!$sess->reload()){
            $sess->register("form_cor",$form_cor);
            $theme->theme_file("_users/address_book/address_book_paste.html.php");
        }
        // lub wyswietl ksiazke adresowa
        unset($_REQUEST['id']); // zwolnij id aby wynikiem nastepnego zapytania by³a tablica
        $this->maxRecord();
        $theme->theme_file("_users/address_book/address_book.html.php");
        return(0);
    } // end pasteRecord()
    
    /**
    * Kasowanie rekordu
    *
    * @praram int $del id rekordu do usuniecia
    *
    * @access public
    * @return none
    */
    function deleteRecord(){
        global $mdbd,$_SESSION,$sess,$theme;
        
        if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;
        
        if(!empty($_REQUEST['del'])){
            $id=$_REQUEST['del'];
        } else {
            return(0);
        }
        if (!$sess->reload()){
            $mdbd->delete("users_address_book",
            "id=? and id_users=?",
            array(
            "1,".$id=>"int",
            "2,".$_SESSION['global_id_user']=>"int"                                                                )
            );
            // pokaz plik html
            $theme->theme_file("_users/address_book/address_book_del.html.php");
        }
        // lub wyswietl ksiazke adresowa
        $this->sessionDelete(); // zmiejsz wartosc w sesji o 1
        $this->maxRecord(); // wygeneruj link "dadaj adres"
        $theme->theme_file("_users/address_book/address_book.html.php");
        return(0);
    } // end deleteRecord()
    
    /**
    * Konwersja tablicy sql na dane do formularza
    *
    * @pararm array $data dane do przekonwertowania
    *
    * @access private
    * @return array
    */
    function _convertData($data){
        if(!is_array($data)) return;
        foreach($data as $key=>$val){
            $key=ereg_replace("crypt_cor_","",$key);
            $record[$key]=$val;
        }
        return $record;
    } // end convertData()
    
    /**
    * Edycja rekordow
    *
    * @access public
    * @return array
    */
    function editData(){
        if(empty($_REQUEST['id'])) return;
        $data=$this->_selectData();
        $data=$this->_convertData($data);
        return $data;
    } // end editData()
    
    /**
    * Wyswietlanie rekordow
    *
    * @access private
    * @return array
    */
    function _selectData(){
        global $mdbd,$_SESSION;
        
        if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;
        
        if (!empty($_REQUEST['id'])) {
            $_sql="AND id=?";
            $id=$_REQUEST['id'];
            $type="auto";
        } else {
            $_sql='';
            $id=0;
            $type="array";
        }
        
        $data_db=$mdbd->select("id,id_users,crypt_cor_firm,crypt_cor_name,crypt_cor_surname,crypt_cor_street,crypt_cor_street_n1,crypt_cor_street_n2,crypt_cor_postcode,crypt_cor_city,crypt_cor_email,crypt_cor_phone,crypt_cor_country","users_address_book","id_users=? $_sql",array($_SESSION['global_id_user']=>"int",$id=>"int"),"ORDER BY id DESC LIMIT 0,12",$type);
        
        if (! empty($data_db)) {
            reset($data_db);$data=array();
            
            if ($type=="array") {
                foreach ($data_db as $item) {
                    $this->_endecryptData($item,"de");
                    $data[]=$item;
                }
            } else {
                $this->_endecryptData($data_db,"de");
                $data=$data_db;
            }
        } else $data=array();
        
        return $data;
    } // end _selectData()
    
    /**
    * Wyswietlenie ksiazki adresowej
    *
    * \@session int $address_book_rec ilosc rekordow w ksiazce adresowej
    *
    * @access public
    * @return none;
    */
    function showAddressBook(){
        global $sess, $address_book_rec, $theme;
        $data=$this->_selectData();
        if(empty($data)) return;
        
        $count=count($data);
        $address_book_rec=array("records_no"=>$count);
        $sess->register("address_book_rec",$address_book_rec);
        
        $i=$this->records_in_row; //ilosc rekordow w wierszu
        $j=ceil(count($data)/$i);
        $n=count($data);
        if($n<$i){
            //$i=$i-($i-$n);
            $i=$n;
        }
        
        $m=1;
        for($k=0;$k<$j;$k++){
            print "<tr>\n";
            print "<td>&nbsp;&nbsp;&nbsp;</td>\n";
            for($l=0;$l<$i;$l++){
                list(,$value)=each($data);
                print "  <td valign=\"top\">";
                if(is_array($value)){
                    $this->_showRecord($value,$m);
                }
                $m++;
                print "</td>\n";
                print "<td>&nbsp;&nbsp;&nbsp;</td>\n";
                
            }
            print "</tr>\n";
        }
        return(0);
    } // end showAddressBook()
    
    /**
    * Pobranie rekordow i wpisanie w szablon wyswietlajacy
    *
    * @access private
    * @return array
    */
    function _showRecord(&$data,$i){
        global $theme;
        $record=$this->_convertData($data);
        $record['separator']="<br />";
        while(list($key,$value)=each($record)){
            if(empty($value) and $key!="street_n2"){
                $record[$key]="";
                $record['separator'].="<br />\n";
            }
        }
        $record['no']=$i;
        $theme->record=&$record;
        $theme->theme_file("_users/address_book/address_record.html.php");
    } // end _showRecord()
    
    /**
    * Dodanie nowego rekordu do bazy
    *
    * @author rp@sote.pl
    *
    * @param array $data dane z formularza
    *
    * @return none;
    */
    function insertData(&$data){
        global $mdbd, $_SESSION, $theme;
        global $sess;
        
        // koduj dane
        $this->_endecryptData($data,"de");
        
        if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;
        
        // sprawdz czy nie zostala osiagnieta maksymalna liczba produktow
        if (@$_SESSION['address_book_rec']['records_no']>$this->maxRecords) return;
        
        if (! $sess->reload()) {
            $mdbd->insert("users_address_book","id_users,
		                                        crypt_cor_firm,
		                                        crypt_cor_name,
		                                        crypt_cor_surname,
                                    		    crypt_cor_street,
                                    		    crypt_cor_street_n1,
                                    		    crypt_cor_street_n2,
                                    		    crypt_cor_postcode,
                                    		    crypt_cor_city,
                                    		    crypt_cor_email,
                                    		    crypt_cor_phone,
                                    		    crypt_cor_country",
            "?,?,?,?,?,?,?,?,?,?,?,?",
            array(
            "1,".$_SESSION['global_id_user']=>"int",
            "2,".$data['firm']=>"text",
            "3,".$data['name']=>"text",
            "4,".$data['surname']=>"text",
            "5,".$data['street']=>"text",
            "6,".$data['street_n1']=>"text",
            "7,".$data['street_n2']=>"text",
            "8,".$data['postcode']=>"text",
            "9,".$data['city']=>"text",
            "10,".$data['email']=>"text",
            "11,".$data['phone']=>"text",
            "12,".$data['country']=>"text"
            )
            );
            // pokaz plik html z podziekowaniem
            $theme->theme_file("_users/address_book/address_book_thx.html.php");
        }
        // wyswietl ksiazke adresowa
        $this->sessionAdd();
        $this->maxRecord();
        $theme->theme_file("_users/address_book/address_book.html.php");
        return(0);
    } // end insertData()
    
    /**
    * Update rekordu
    *
    * @author rp@sote.pl
    *
    * @param array $data dane z formularza
    *
    * @return none;
    */
    function updateData(&$data){
        global $mdbd, $_SESSION, $theme;
        global $sess;
        
        // koduj dane
        $this->_endecryptData($data,"de");
        
        if(!ereg("^[0-9]+$",@$_SESSION['global_id_user'])) return;        
        if(@$_SESSION['global_id_user']!=$data['id_users']) return;        
        
        if (! $sess->reload()) {
            $mdbd->update("users_address_book","crypt_cor_firm=?,
		                                        crypt_cor_name=?,
		                                        crypt_cor_surname=?,
		                                        crypt_cor_street=?,
		                                        crypt_cor_street_n1=?,
		                                        crypt_cor_street_n2=?,
		                                        crypt_cor_postcode=?,
		                                        crypt_cor_city=?,
		                                        crypt_cor_email=?,
		                                        crypt_cor_phone=?,
		                                        crypt_cor_country=?",
            "id_users=? AND id=?",
            array(
            "1,".$data['firm']=>"text",
            "2,".$data['name']=>"text",
            "3,".$data['surname']=>"text",
            "4,".$data['street']=>"text",
            "5,".$data['street_n1']=>"text",
            "6,".$data['street_n2']=>"text",
            "7,".$data['postcode']=>"text",
            "8,".$data['city']=>"text",
            "9,".$data['email']=>"text",
            "10,".$data['phone']=>"text",
            "11,".$data['country']=>"text",
            "12,".$_SESSION['global_id_user']=>"int",
            "13,".$data['id']=>"int"
            )
            );
            // pokaz plik html z podziekowaniem
            $theme->theme_file("_users/address_book/address_book_upt.html.php");
        }
        //wyswietl ksiazke adresowa
        $this->maxRecord();
        $theme->theme_file("_users/address_book/address_book.html.php");
        return(0);
    } // end updateData()
    
    /**
    * Koduj i dekoduj dane
    *
    * @param array  $data   tablica za danymi klienta zakodowanymi/lub jawnymi
    * @param string $method informacja o tym, czy kodujemy, czy dekodujemy dane; 'de'=>dekodujemy
    *
    * @access private
    * @return none
    */
    function _endecryptData(&$data,$method='') {
        if ($this->debug==true) {print "<pre>BEFORE ENDECRYPT:<BR>";print_r($data);print "</pre>";}
        $crypt =& new MyCrypt;
        reset($data);$data2=array();
        foreach ($data as $key=>$val) {
            if (($key!="id") && ($key!="id_users")) $data2[$key]=$crypt->endecrypt('',$val,$method);
            else $data2[$key]=$val;
        }
        
        $data=$data2;        
        if ($this->debug==true) {print "<pre>AFTER ENDECRYPT:<BR>";print_r($data);print "</pre>";}
        
        return;
    } // end _endecryptData()
    
} // end class AddressBook
?>
