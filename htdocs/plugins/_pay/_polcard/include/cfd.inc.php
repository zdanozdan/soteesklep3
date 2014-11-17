<?php
/**
* Klasa analizujaca plik CFD, plik z rozliczeniem odebranym z PolCard'u
*
* @author  m@sote.pl
* @version $Id: cfd.inc.php,v 1.4 2004/12/20 18:02:10 maroslaw Exp $
* @package    pay
* @subpackage polcard
*/

if (@$__secure_test!=true) die ("Forbidden");

/**
* Dodaj obs³ugê kodowania danych.
*/
require_once ("include/my_crypt.inc");

/**
* Klasa zarz±dzaj±ca danymi w formacie CFD.
*
* @package polcard
* @subpackage htdocs_adv
*/
class CFD {
    
    var $separator=",";          // separator danych w wierszu dot. transakcji
    var $endline="\n";           // znak konca linii
    var $cfd=array();            // dane z pliku CFD podzilelona na tablice
    var $cfd_file;               // zawartosc pliku CFD w postaci zalaczonej z formularza (text)
    
    // mapa kodow rozliczen -> pay_status
    var $code_map=array("00"=>"002",
    "01"=>"321",
    "02"=>"050",
    "03"=>"054",
    "04"=>"324",
    "05"=>"325",
    "06"=>"326",
    "07"=>"327",
    "08"=>"328",
    "09"=>"329",
    "10"=>"330",
    "97"=>"397",
    "98"=>"398",
    "99"=>"399"
    );
    
    /**
    * Zmien format dany na format do CFD np. 2003-09-25 zmein na 032509 itp.
    *
    * @param string $date np. 2003-09-25
    * @param string data w formacie CFD np. 030925
    */
    function date_cfd($date) {
        $date_cfc=ereg_replace("-","",$date);
        $date_cfc=substr($date_cfc,2,strlen($date_cfc)-2);
        return $date_cfc;
    } // end date_cfc()
    
    
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
    * Odczytaj zawartosc pliku CFD
    *
    * @param  string $file plik tymczasowy, w kotrym przetrzymywana jest zawartosc zalaczonego pliku CFD
    * @return string zawartosc pliku CFD
    * \@global string $this->cfd_file jw.
    */
    function get_cfd($file) {
        $fd=fopen($file,"r");
        $cfd=fread($fd,filesize($file));
        fclose($fd);
        
        $this->cfd_file=$cfd;
        
        return $cfd;
    } // end get_cfd()
    
    /**
    * Parsuj wiersz z danymi transakcji
    *
    * @param  string $line wiersz z danymi transakcji np. "T,00,H987406,0826acdab1cff45a79380819174e9365,030909,2800,TD,987406,I,116"
    * @return array  dane transakcji w postaci tablicy np. array("answer"=>"T","auth_code"=>"00","session_id"=>...)"
    *         bool   false jesli format danych jest zly
    */
    function parse_order($line) {
        $order=array();
        
        $tab=split($this->separator,$line,10);
        if (sizeof($tab)!=10) return false;
        
        for ($i=0;$i<10;$i++) {
            $order['answer']=$tab[0];
            $order['code']=$tab[1];
            $Hcc_number_hash=$tab[2];
            if (ereg("^H",$Hcc_number_hash)) {
                $order['cc_number_hash']=substr($Hcc_number_hash,1,strlen($Hcc_number_hash)-1);
            } else return false;
            $order['session_id']=$tab[3];
            $order['date']=$tab[4];
            $order['amount']=$tab[5];
            $order['auth_type']=$tab[6];
            $order['auth_code']=$tab[7];
            $order['type']=$tab[8];
            $order['order_id']=$tab[9];
        } // end for
        
        return $order;
    } // end parse_order()
    
    /**
    * Analizuj plik CFD, rozdziel go na logiczne elementy
    *
    * \@global array  $this->cfd   dane z pliku CFD podzielone na tablice
    * \@global string $this->batch numer przesylki CFD zakres: 000-999
    * @return array jw.
    */
    function parse() {
        if (empty($this->cfd_file)) die ("Error: Empty $this->cfd_file");
        
        $cfd=$this->cfd_file;
        $this->cfd['order']=array();
        
        $lines=split("\n",$cfd);
        foreach ($lines as $line) {
            if (ereg("^TID:",$line)) {
                $tab=split(":",$line);
                $this->cfd['posid']=trim($tab[1]);
            }
            if (ereg("^Nazwa:",$line)) {
                $tab=split(":",$line);
                $this->cfd['name']=trim($tab[1]);
            }
            if (ereg("^Waluta:",$line)) {
                $tab=split(":",$line);
                $this->cfd['currency']=trim($tab[1]);
            }
            if (ereg("^Separator:",$line)) {
                $tab=split(":",$line);
                $this->cfd['separator']=trim($tab[1]);
            }
            if (ereg("^Format:",$line)) {
                $tab=split(":",$line);
                $this->cfd['format']=trim($tab[1]);
            }
            if (ereg("^Batch:",$line)) {
                $tab=split(":",$line);
                $this->cfd['batch']=trim($tab[1]);
                $this->batch=$this->cfd['batch'];
            }
            
            // sprawdz czy wiersz reprezentuje transakcje wiersz bedzie sie rozpoczynal od np. T,00 lub F,01 lub E,01 itp.
            if (ereg("^T".$this->separator."[0-9]{2}",$line) ||
            ereg("^F".$this->separator."[0-9]{2}",$line) ||
            ereg("^E".$this->separator."[0-9]{2}",$line)) {
                $parse_order=$this->parse_order($line);
                if (! empty($parse_order)){
                    array_push($this->cfd['order'],$parse_order);
                }
            }
            
        } // end foreach
        
        return $this->cfd;
    } // end parse()
    
    /**
    * Zweryfikuj dane z CFD, usaktualnij status transakcji na podstawie weryfikowanych danych
    *
    * \@global array $this->cfd dane CFD w postaci tablicy np.
    * Array
    * (
    *    [order] => Array
    *        (
    *            [0] => Array
    *                (
    *                    [answer] => T
    *                    [code] => 00
    *                    [cc_number_hash] => 987406
    *                    [session_id] => 0826acdab1cff45a79380819174e9365
    *                    [date] => 030909
    *                    [amount] => 2800
    *                    [auth_type] => TD
    *                    [auth_code] => 987406
    *                    [type] => I
    *                    [order_id] => 116
    *                )
    *    [name] => SOTE
    *    [currency] => PLN
    *    [separator] => ,
    *    [format] => D
    *    [batch] => 074
    * )
    *
    * @return bool true - dane naglowka CFD OK, false - dane w naglowku CFD nie zgadzaja sie (nie dotyczy danych transakcji)
    */
    function verify() {
        global $db;
        
        // weryfikacja naglowka
        if (! $this->verify_batch()) return false;                   // sprawdz czy zostal wyslany plik CFC o danym numerze batch
        if ($this->cfd['format']!="D") return false;
        if ($this->cfd['separator']!=$this->separator) return false;
        // end
        
        // weryfikuj dane transakcji
        reset($this->cfd['order']);
        foreach ($this->cfd['order'] as $order) {
            if (! $this->verify_order($order)) {
                $this->set_error_order_verify($order['order_id']);
                // debug: print "order_id=".$order['order_id']." ... False\n";
            } else {
                // debug: print "order_id=".$order['order_id']." ... True\n";
            }
        } // end foreach
        
        return true;
    } // end verify()
    
    /**
    * Nie udalo sie zweryfikowac poprawnie transakcji z CFD, uaktualnij pay_status
    *
    * @param int $order_id
    */
    function set_error_order_verify($order_id) {
        global $db;
        
        if (empty($order_id)) return false;
        
        // aktualizuj status transakcji
        $query="UPDATE order_register SET pay_status=? WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,'350');
            $db->QuerySetInteger($prepared_query,2,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // status transakcji zostal poprawnie zaktualizowany
            } else die ($db->Error());
        } else die ($db->Error());
        // end
        
        return(0);
    } // end set_error_order_verify()
    
    /**
    * Weryfikuj dane transakcji wyslane w rekordzie CFD
    *
    * @param array $order dane transakcji np.
    *              Array
    *                (
    *                    [answer] => T
    *                    [code] => 00
    *                    [cc_number_hash] => 987406
    *                    [session_id] => 0826acdab1cff45a79380819174e9365
    *                    [date] => 030909
    *                    [amount] => 2800
    *                    [auth_type] => TD
    *                    [auth_code] => 987406
    *                    [type] => I
    *                    [order_id] => 116
    *                )
    * @return bool true - dane sie zgadzaja, false w p.w.
    */
    function verify_order($order) {
        global $db;
        
        if (empty($order['order_id'])) return false;
        
        // odczytujemy z polcard_auth dane dla danego order_id i session_id
        $query="SELECT order_id,session_id,cc_number_hash,auth_code FROM polcard_auth
                       WHERE order_id=? AND session_id=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order['order_id']);
            $db->QuerySetText($prepared_query,2,$order['session_id']);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    // order_id i session_id zgadzaja sie, w/w transakcja zostala zawarta w sklepie
                    // odczytaj dane
                    $cc_number_hash=$db->FetchResult($result,0,"cc_number_hash");
                    $auth_code=$db->FetchResult($result,0,"auth_code");
                    $session_id=$db->FetchResult($result,0,"session_id");
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());
        // end
        
        // odczytaj date transakcji i zweryfikuj ja
        $query="SELECT date_add,delivery_cost,amount,amount_confirm FROM order_register WHERE order_id=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order['order_id']);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $date_add=$this->date_cfd($db->FetchResult($result,0,"date_add"));
                    $amount=$db->FetchResult($result,0,"amount");
                    $delivery_cost=$db->FetchResult($result,0,"delivery_cost");
                    $amount_confirm=$db->FetchResult($result,0,"amount_confirm");
                    
                    // oblicz jaka kwota powinna byc w rozliczeniu -> $amount_c
                    if ($amount_confirm>0) $amount_c=$amount_confirm;
                    else $amount_c=$amount+$delivery_cost;
                    $amount_c=number_format(($amount_c),2,".","")*100;
                    
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());
        if ($date_add!=$order['date']) return false;
        // end
        
        // weryfikuj cc_number_hash i auth_code
        if ($cc_number_hash!=$order['cc_number_hash']) return false;
        if ($auth_code!=$order['auth_code']) return false;
        
        // weryfikuj "code" - kod rozliczenia
        if (! ereg("^[0-9]{2}$",$order['code']))  return false;
        if (! empty($this->code_map[$order['code']])) {
            $pay_status=$this->code_map[$order['code']];
        } else $pay_status='399';
        
        if ($order['answer']=="E") $pay_status='396';
        elseif (($order['answer']!="T") &&  ($order['answer']!="F")) return false;
        
        if (($pay_status=="002") and ($order['answer']!="T")) return false;
        
        // zweryfikuj kwote
        // oblicz na podstawie kwoty sume kontrolna i porownaj ja z suma zapisana w order_register
        if ($order['amount']!=$amount_c) {
            // sprawdz czy jest to zwrot, czy rozliczenie
            if (($order['auth_type']=="TD") || ($order['auth_type']=="PD")) {
                // proba rozliczenia - przy niezgodnej kwocie
                $pay_status='395';             // format dla [99 zl 50 gr]=>9950
            } elseif (($order['auth_type']=="TC") || ($order['auth_type']=="PC")) {
                // zwrot - przy niezgodnej kwocie
                $pay_status='394';
            } else {
                // transakcja anulowana - przy niezgodnej kwocie
                $pay_status='054';
            }
        } else {
            // kwota rozliczenia sie zgadza
            if (($order['auth_type']=="TC") || ($order['auth_type']=="PC")) {
                $pay_status='053';
            } elseif (($order['auth_type']=="TV") || ($order['auth_type']=="PV")) {
                // transakcja anulowana
                $pay_status='054';
            }
            // jesli auth_type = TD lub PD, to wczesniej ustawiona wartosc pay_status nie zmienia sie
        }
        
        // sprawdz auth_type
        if (($order['auth_type']!="TD") && ($order['auth_type']!="TC") && ($order['auth_type']!="TV") &&
        ($order['auth_type']!="PD") && ($order['auth_type']!="PC") && ($order['auth_type']!="PV")) return false;
        
        // zweryfikuj typ transakcji
        if ($order['type']!="I") return false;
        
        // zweryfikuj numer sesji
        if ($order['session_id']!=$session_id) return false;
        
        // aktualizuj status transakcji
        $query="UPDATE order_register SET pay_status=? WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$pay_status);
            $db->QuerySetInteger($prepared_query,2,$order['order_id']);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                // status transakcji zostal poprawnie zaktualizowany
            } else die ($db->Error());
        } else die ($db->Error());
        // end
        
        return true;
    } // end verify_order()
    
    /**
    * Weryfikuj batch, sprawdz czy istnieje CFC z przedstawionym w CFD numerem
    *
    * @return bool true - CFC o podanym batch zostal wystawiony, false - w p.w.
    */
    function verify_batch() {
        global $db;
        
        $batch=$this->cfd['batch'];
        $query="SELECT batch FROM polcard_cfcd WHERE format=? AND batch=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,"C");
            $db->QuerySetText($prepared_query,2,$batch);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    print "Received: [".$this->cfd['posid'].",".$this->cfd['batch']."]\n";
                    return true;
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());
        
        return false;
    } // end verify_batch()
    
    // start 2004-03-10:
    /**
    * Zapisz CFD w bazie
    *
    * \@global string $this->cfd_file     zawarto¶æ CFD odebranego z polocardu
    * \@global string $this->cfd['batch'] numer przesy³ki
    *
    * @return void
    */
    function cfd2db() {
        global $mdbd;
        
        // jesli j est CFD o podanych numerze batchm to usuñ go, nast±pi³a rotacja
        $is=$mdbd->select("id","polcard_cfcd","batch=? AND format='D'",
        array($this->cfd['batch']=>"text"),"LIMIT 1");
        if ($is>0) {
            $mdbd->delete("polcard_cfcd","batch=? AND format='D'",
            array($this->cfd['batch']=>"text"),"LIMIT 1");            
        }
        
        // dodaj CFD do bazy        
        $my_crypt =& new MyCrypt;
        $crypt_cfd=$my_crypt->endecrypt("",$this->cfd_file);
        $date_send=date("Y-m-d h:M:s");
        $mdbd->insert("polcard_cfcd","batch,format,crypt_data,date_send","?,'D',?,?",
        array(
        $crypt_cfd=>"text",
        $batch=>"text",
        $date_send=>"text"                
        ));
        
        return;
    } // end cfd2db()
    // end 2004-03-10:
    
} // end class CFD

$cfd = new CFD;
$cfd->get_cfd($_FILES['clearing_report_file']['tmp_name']);
$cfd->parse();         // parsuj plik CFD
$cfd->verify();        // weryfiuj dane z pliku/struktury ($this->cfd) CFD

// start 2004-03-10:
$cfd->cfd2db();        // zapisz plik CFD do bazy
// end 2004-03-10:
?>
