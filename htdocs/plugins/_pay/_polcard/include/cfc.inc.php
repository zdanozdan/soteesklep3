<?php
/**
* Obsluga plikow rozliczeniowych PolCardu CFC
*
* @author  m@sote.pl
* @version $Id: cfc.inc.php,v 1.4 2004/12/20 18:02:09 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

if (@$__secure_test!=true) die ("Forbidden");

/**
* Dodaj obs³ugê kodowania danych.
*/
require_once ("include/my_crypt.inc");

/**
* Klasa zarz±dzaj±ca danymi transakcji w formacie CFC.
*
* @package polcard
* @subpackage htdocs_adv
*/
class CFC {
    
    var $separator=",";           // separator danych w pliku CFC
    var $endline="\n";            // znak konca lini w pliku CFC
    var $currency="PLN";          // waluta rozliczenia
    
    /**
    * Odczytaj dni, ktorych sa transakcje do rozliczenia.
    *
    * Wystarczy ze jest 1 transakcja w 1 dniu, to wtedy dodajemy date do listy.
    *
    * @return array daty w ktorych sa transakcje do rozliczenia np. array('2003-09-10','2003-09-11',...)
    */
    function get_days() {
        global $db;
        
        $date_tab=array();
        $query="SELECT date_add FROM order_register WHERE id_pay_method=3 AND
                                                         (pay_status='001' OR pay_status='010'
                                                       OR pay_status='051' 
                                                       OR pay_status='052')
                                                    GROUP BY date_add";
        $result=$db->Query($query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                $i=0;
                while ($i<$num_rows) {
                    $date_add=$db->FetchResult($result,$i,"date_add");
                    array_push($date_tab,$date_add);
                    $i++;
                } // end while
            } else {
                // nie ma zadnych plikow do wysatwienia, nic nie pokazuj
                return array();
            }
        } else die ($db->Error());
        
        return $date_tab;
    } // end get_days()
    
    /**
    * Zamien liczbe 1,2,3 na 001,002,003 itd.
    *
    * @param  $nr    int     liczba cakowita
    * @return string liczba w postaci strongu o dlugosci 3
    */
    function int2str3($nr) {
        $o="";
        if ($nr<10) {
            $o.='0';
        }
        if ($nr<100) {
            $o.='0';
        }
        
        return $o.$nr;
    } // end int2str()
    
    
    /**
    * Generuj kolejny numer batch 000-999, aktualizuj tabele polacard_batch
    *
    * @return string [3] np. 000,001,...,999
    */
    function batch() {
        global $db;
        
        $is=false;
        $query="SELECT batch_cfc FROM polcard_batch LIMIT 1";
        $result=$db->Query($query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                $batch_cfc=$db->FetchResult($result,0,"batch_cfc");
                $is=true;
            }
        } else die ($db->Error());
        
        if (! $is) {
            // wstaw wartosc do tablicy polcard_batch
            $query="INSERT INTO polcard_batch (batch_cfc) VALUES ('000')";
            $result=$db->Query($query);
            if ($result!=0) {
                // wartosc do polcard_batch zostala poprawnie wstawiona
                $batch_cfc='000';
            } else die ($db->Error());
        }
        
        // zwieksz batch_cfc o 1
        $batch_new=number_format($batch_cfc,0)+1;
        $batch_new_str=$this->int2str3($batch_new);
        
        $query="UPDATE polcard_batch SET batch_cfc=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$batch_new_str);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // kolejny numer zostal poprawnie wygenerowany
            } else die ($db->Error());
        } else die ($db->Error());
        
        // zapamietaj globalnie numer batch, ten numer posluzy do zapisania zmeinnej w bazie
        // pod tym numerem bedzie odpowiedni wpis w tabeli z plikami cfc
        $this->batch=$batch_new_str;
        
        return $batch_new_str;
    } // end batch()
    
    /**
    * Naglowek pliku CFC
    *
    * @return string naglowek pliku CFC
    */
    function head() {
        global $polcard_config;
        
        // generuj kolejny numer pliku rozliczenia 000-999
        $batch=$this->batch();
        
        $cfc='';
        $cfc.="TID: $polcard_config->posid".$this->endline;
        $cfc.="Nazwa: $polcard_config->client".$this->endline;
        $cfc.="Waluta: $this->currency".$this->endline;
        $cfc.="Separator: $this->separator".$this->endline;
        $cfc.="Format: C".$this->endline;
        $cfc.="Batch: ".$batch.$this->endline;
        $cfc.=$this->endline;
        
        return $cfc;
        
    } // end head()
    
    /**
    * Aktualizuj status transakcji; ustaw status na 301 tj. transakcja wystawiona do pliku CFC
    *
    * @param int $order_id order_id zamowienia
    */
    function order_pay_status_update($order_id) {
        global $db;
        
        $query="UPDATE order_register SET pay_status=? WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,'301');
            $db->QuerySetInteger($prepared_query,2,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // status transakcji zostal poprawnie zaktualizowany
            } else die ($db->Error());
        } else die ($db->Error());
        
        return(0);
    } // end order_pay_status_update()
    
    /**
    * Zmien format dany na format do CFC np. 2003-09-25 zmein na 032509 itp.
    *
    * @param string $date np. 2003-09-25
    * @param string data w formacie CFC np. 030925
    */
    function date_cfc($date) {
        $date_cfc=ereg_replace("-","",$date);
        $date_cfc=substr($date_cfc,2,strlen($date_cfc)-2);
        return $date_cfc;
    } // end date_cfc()
    
    /**
    * Generuj plik CFC
    *  
    * @param $date data zawarcia transakcji
    * @return string|false zawartosc pliku CFC, false - nie ma transakcji lub nie udalo sie zapisac danych do bazy
    */
    function gen_cfc($date) {
        global $db;
        global $polcard_config;
        
        
        $cfc='';
        
        $my_crypt = new MyCrypt;
        
        // wyszukaj wszystkie transakcje dla danej daty
        $orders=array();
        $amount_confirm_tab=array();                    // kwoty rozliczenia dla poszczegolnych transakcji
        // jesli kwota ! >0 to, biezemy kwote z tabeli polcard_auth z pola amount
        $date_add_tab=array();                          // daty zawarcia transakcji wg order_id
        $query="SELECT order_id,amount_confirm,date_add FROM order_register WHERE id_pay_method=3 AND date_add=? AND (
                            pay_status='001' OR pay_status='010'  OR pay_status='051' OR 
			    pay_status='052')";
        
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$date);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                //print "date=$date num_rows=$num_rows \n";
                if ($num_rows>0) {
                    $i=0;
                    while ($i<$num_rows) {
                        $order_id=$db->FetchResult($result,$i,"order_id");
                        //print "order_id=$order_id\n";
                        $amount_confirm=$db->FetchResult($result,$i,"amount_confirm");
                        array_push($orders,$order_id);
                        $amount_confirm_tab[$order_id]=$amount_confirm;
                        $date_add_tab[$order_id]=$db->FetchResult($result,$i,"date_add");
                        $i++;
                    } // end while
                } else {
                    // nie ma zadnych transakcji dla date $date, zwroc pusty CFC
                    return '';
                }
            } else die ($db->Error());
        } else die ($db->Error());
        
        // zmianna $orders zawiera liste $order_id transakcji do 
        // rozliczenia z danego dnia np. array('1','23','45',...)
        // odczytaj dane odebrane podczas autoryzacji z polcard_auth dot. tych transakcji
        $orders_data=array();
        $polcard_auth=array();
        
        reset($orders);
        // sprawdzenie czy jest choc 1 transakcja do rozliczenia i czy wszystkei dane dla
        $is=false;     
        // tej transakcji sie zgadzaja
        foreach ($orders as $order_id) {
            //print "orderID=$order_id\n";
            $query="SELECT * FROM polcard_auth WHERE order_id=?";
            $prepared_query=$db->PrepareQuery($query);
            if ($prepared_query) {
                $db->QuerySetInteger($prepared_query,1,$order_id);
                $result=$db->ExecuteQuery($prepared_query);
                if ($result!=0) {
                    $num_rows=$db->NumberOfRows($result);
                    //print "num_rows order_id z polcard_auth=$num_rows\n";
                    if ($num_rows>0) {
                        $is=true;
                        $polcard_auth['order_id']=$order_id;
                        $polcard_auth['session_id']=$db->FetchResult($result,0,"session_id");
                        
                        // jesli klient zmienil kwote rozliczenia, to rozlicz kwote 
                        // podana przez klienta (kwota tylko nizsza)
                        if (! $amount_confirm_tab[$order_id]>0) {
                            $polcard_auth['amount']=$db->FetchResult($result,0,"amount");
                        } else {
                            $polcard_auth['amount']=$amount_confirm_tab[$order_id]*100;
                        }
                        
                        $polcard_auth['response_code']=$db->FetchResult($result,0,"response_code");
                        $polcard_auth['cc_number_hash']=$db->FetchResult($result,0,"cc_number_hash");
                        $polcard_auth['date_add']=$this->date_cfc($date_add_tab[$order_id]);
                        $polcard_auth['card_type']=$db->FetchResult($result,0,"card_type");
                        $polcard_auth['test']=$db->FetchResult($result,0,"test");
                        $polcard_auth['auth_code']=$db->FetchResult($result,0,"auth_code");
                        $polcard_auth['bin']=$my_crypt->endecrypt("",$db->FetchResult($result,0,"crypt_bin"),"de");
                        $polcard_auth['checksum']=$db->FetchResult($result,0,"checksum");
                        
                        // sprawdz sume kontrolna
                        if ($polcard_auth['response_code']=="000") $auth=1; else $auth=0;
                        $amount=number_format($polcard_auth['amount'],2,"",".");
                        $my_checksum=OrderRegisterChecksum::checksum($order_id,$auth,$amount);
                        //if ($my_checksum==$polcard_auth['checksum']) {
                        // transakcja OK, suma kontrolna sie zgadza, generujemy wpis do CFC dla tej transakcji
                        $cfc.=$this->order2cfc($polcard_auth);
                        $this->order_pay_status_update($order_id);               // ustaw status transakcji na 301
                        //} else {
                        // nie zgadza sie suma kontrolna transakcji
                        // pomijamy transakcje
                        //}
                    } else {
                        // nie ma transakcji dla danego order_id w polcard_auth
                        // proba rozliczenia transkacji nierozliczonej
                        // pomijamy transakcje
                    }
                } else die ($db->Error());
            } else die ($db->Error());
            
        } // end foreach
        
        if (! $is) return false;
        
        // wstaw naglowek pliku CFC i generuj kolejny numer batch (numer przesylki)
        $cfc_head=$this->head();
        $cfc=$cfc_head.$cfc;
        
        // zapisz plik CFC do bazy danych, zebysmy mieli kopie tego co jest wysylane do PolCardu
        if ($this->cfc2db($this->batch,$cfc)) return $cfc;
        else return false;
        
    } // end gen_cfc()
    
    /**
    * Zapisz plik CFC do bazy danych
    *
    * @param string[3] $batch numer przesylki 000-999 (rotacyjnie?)
    * @param string    $cfc   zawartosc pliku CFC
    * @return bool true udalo sie zapisac CFC do bazy, false w p.w.
    */
    function cfc2db($batch,$cfc) {
        global $db;
        global $mdbd;
        
        $my_crypt = new MyCrypt;
        $crypt_data=$my_crypt->endecrypt("",$cfc);
        
        // sprawdz czy CFC o danych batch istnieje, jesli tak to usun ten wpis (nastapila rotacja)
        // start 2004-03-11:
        $mdbd->delete("polcard_cfcd","batch=? AND format='C'",array($batch=>"text"),"LIMIT 1");
        // end 2004-03-11:
        
        $query="INSERT INTO polcard_cfcd (batch,format,crypt_data,date_send) VALUES (?,?,?,?)";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$batch);
            $db->QuerySetText($prepared_query,2,"C");    // C -> CFC
            $db->QuerySetText($prepared_query,3,$crypt_data);
            $db->QuerySetText($prepared_query,4,date("Y-m-d h:M:s"));
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // udalo sie poprawnie zapisac CFC do bazy
                return true;
            } else die ($db->Error());
        } else die ($db->Error());
        
        return false;
    } // end cfc2db()
    
    /**
    * Generuj wiersz wpisu CFC dla transakcji
    *
    * @param array $polcard_auth date transakcji z tabeli polcard_auth
    * @return string wiersz reprezentujacy transakcje w CFC
    */
    function order2cfc($polcard_auth) {
        global $db;
        
        $cfc='';
        
        // odczytaj dodatkowe dane o transakcji z order_register
        $query="SELECT pay_status FROM order_register WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$polcard_auth['order_id']);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $pay_status=$db->FetchResult($result,0,"pay_status");
                } else return '';
            } else die ($db->Error());
        } else die ($db->Error());
        
        // $pay_status zawiera status transakcji $order_id
        
        $cfc.="H".$polcard_auth['cc_number_hash'].$this->separator;
        $cfc.=$polcard_auth['session_id'].$this->separator;
        $cfc.=$polcard_auth['date_add'].$this->separator;
        $cfc.=$polcard_auth['amount'].$this->separator;
        
        // start XY:
        // X [T|P] T- test, P- product
        // Y [D|C|V] D - pobranie kwoty, C -zwrot, V - anulowanie
        if ($polcard_auth['test']=="Y") {
            $X="T";
        } else $X="P";
        
        switch ($pay_status) {
            case "001": $Y="D"; break;
            case "051": $Y="D"; break;
            case "052": $Y="C"; break;
            case "010": $Y="V"; break;
        }
        
        $cfc.=$X.$Y.$this->separator;
        // end XY:
        
        $cfc.=$polcard_auth['auth_code'].$this->separator;
        $cfc.="I".$this->separator;
        $cfc.=$polcard_auth['order_id'].$this->endline;
        
        return $cfc;
    } // end order2cfc()
    
} // end class CFC
?>
