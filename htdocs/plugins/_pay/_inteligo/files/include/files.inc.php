<?php
/**
* @package    pay
* @subpackage inteligo
*/
define('INTELIGO_IP_NUMBER', "193.109.225.252");
//define('PARTNER_IP_NUMBER', "80.50.34.196");
define('PARTNER_IP_NUMBER', "80.54.16.232");
/**
 * Klasa do obslugi plikow wymiany Inteligo
 *
 * @version $Id: files.inc.php,v 1.3 2004/12/20 18:02:05 maroslaw Exp $
 * @package soteesklep inteligo
 */

include("include/metabase.inc");
include("lib/LibPHP/Date/Calc.php");

class InteligoFile {

    var $location='';               // miejsce zapisania pliku z transakacjami *.trn
    var $filename='';               // nazwa aktualnie zaladowanego pliku
    var $sep="\|";                  // separator rekordów w inteligo dymy¶lnie belka
    var $ext='';                    // rozszerzenie zaladowanego na serwer pliku
    var $number_files='';           // numer plików rozliczeniowych

    /**
     * Konstruktor obiektu InteligoFile
     *
     * @access public
     *
     * @return boolean true/false
     */
    function InteligoFile() {
        global $DOCUMENT_ROOT;
        global $inteligo_config;
        $this->location="$DOCUMENT_ROOT/plugins/_pay/_inteligo/files/files/";
        $this->number_files=$inteligo_config->inteligo_number;
        return true;
    }

    /**
     * Glowna funkcja uploadowania plików
     *
     * @access public
     *
     * @return boolean true/false
     */
    function InteligoAction() {
        global $lang;
        // za³aduj plik na serwer
        if($this->_InteligoCheckHttps() == 'true') {
            if($this->_InteligoCheckIpAddress() == 'true') {
                if($this->_InteligoUpload() == 'true') {
                    // sprawdzamy jakie rozszerzenie ma plik
                    if($this->_InteligoCheckFile() == "true") {
                        if($this->ext == "trn") {
                            // na serwer zostal wyslany plik z transakcjami
                            $this->_InteligoParseTRN();
                        } else {
                            // na serwer zostal wys³any plik z b³êdami
                            $this->_InteligoParseERR();
                        }
                    } else {
                        // plik jest nieprawid³owy ma zle rozszerzenie
                        print "<br><center>".$lang->inteligo_files_bad_ext."</center><br><br>";
                    }
                } else {
                    // plik nie zostal prawidlowo uploadowny na serwer
                    print "<br><center>".$lang->inteligo_files_bad_upload."</center><br><br>";
                }
            } else {
                // polaczenie z nieautoryzowanego adresu id
                print "<br><center>".$lang->inteligo_ip_bad."</center><br><br>";
            }
        } else {
            // polaczenie nie nastapilo protokolem https
            print "<br><center>".$lang->inteligo_https_bad."</center><br><br>";
        }
        return true;
    } // end func InteligoAction

    /**
     * Glowna funkcja do sprawdzania polaczenia z serwerem inteligo
     *
     * @access public
     *
     * @return boolean true/false
     */
    function InteligoUploadAction() {
        global $lang;
        if($this->_InteligoCheckIpAddress() == 'true') {
            if($this->_InteligoCheckHttps() == 'true') {
                $this->_InteligoPrintList();
            } else {
                // polaczenie nie nastapilo protokolem https
                print "<br><center>".$lang->inteligo_https_bad."</center><br><br>";
            }
        } else {
            // polaczenie z nieautoryzowanego adresu id
            print "<br><center>".$lang->inteligo_ip_bad."</center><br><br>";
        }
        return true;
    } // end func InteligoUploadAction

    /**
     * Glowna funkcja do dynmicznego tworzenia zawartosci plików
     *
     * @access public
     *
     * @return boolean true/false
     */
    function InteligoFileDownload() {
        global $lang;
        if($this->_InteligoCheckIpAddress() == 'true') {
            if($this->_InteligoCheckHttps() == 'true') {
                $date_trans=$this->_InteligoGetName();
                $this->_InteligoPrintTrans($date_trans);
             } else {
                // polaczenie nie nastapilo protokolem https
                print "<br><center>".$lang->inteligo_https_bad."</center><br><br>";
            }
        } else {
            // polaczenie z nieautoryzowanego adresu id
            print "<br><center>".$lang->inteligo_ip_bad."</center><br><br>";
        }
        return true;
    } // end func InteligoFileDownload

	/**
     * Listuj transakcje do pliku
     *
     * @param int $order_id id transakcji z tabeli order_register
     */
    function _InteligoPrintTrans($date_trans) {
        global $database;
        //print $date_trans;
        // wyciagamy z bazy wszystkie transakcje ktore byly potwierdzone tego dnia
        $data=$database->sql_select_data_array("order_id","pay_status","order_register","send_date=$date_trans","AND id_pay_method=4 AND confirm_online=1");
	$count=count($data);
        $i=0;
        $str='';
        $status='';
        foreach($data as $key=>$value) {
            list($txid,$amount_org)=$database->sql_select_data("txid","amount_org","inteligo","order_id=$key");
	        $amount_org=number_format($amount_org, 2, '.', '');
		    if($i == $count-1) {
		        if($value == '001' || $value == '002') {
                    $str.=$txid."|".@$amount_org."|P";
                    $status='002';
                    $database->sql_update("order_register","order_id=$key",array("pay_status"=>$status));
                } elseif($value == '010' || $value == '054') {
					$str.=$txid."|".@$amount_org."|R";
                    $status='054';
                    $database->sql_update("order_register","order_id=$key",array("pay_status"=>$status));
                }
            } else {
		        if($value == '001' || $value == '002') {
					$str.=$txid."|".@$amount_org."|P\r\n";
                    $status='002';
                    $database->sql_update("order_register","order_id=$key",array("pay_status"=>$status));
                } elseif($value == '010' || $value == '054') {
					$str.=$txid."|".@$amount_org."|R\r\n";
                    $status='054';
                    $database->sql_update("order_register","order_id=$key",array("pay_status"=>$status));
                }
			}
          $i++;
        }
		header ("Content-type: text/plain");
		print $str;
        return true;
    } // end func _InteligoPrintTrans

    /**
     * Zamiana wartosci zamowiebnia na grosze
	 *
     * @return int wartosc zamowienia w groszach
     */
	function compute_amount($amount) {
        $price=$amount;
		$price=number_format($price,2,".","");
        return intval($price*100);
	} // end func compute_amount


    /**
     * Funkcja pobiera informacje o pliku do sciagniecia
     *
     * @access public
     *
     * @return boolean true/false
     */
    function _InteligoGetName() {
        if(! empty($_REQUEST['file'])) {
            $file=$_REQUEST['file'];
        } else  $file='';
        // czyty zmienna $file nie jest pusta ?
        if(!empty($file)) {
            // wyciagnij numer dnia z nazwy pliku
            preg_match("/[0-9]{3}([0-9]{3})[0-9]{2}$/",$file,$tab);
            $calc=new Date_Calc();
            // oblicz numer dnia dla 01-01- year
            $days_year = $calc->dateToDays("01","01",date("Y"));
            // dodaj ilosc dni roku minus jeden
            $days_year+=$tab[1]-1;
            // pokaz date obliczona na podstawie dni
            $date_next=$calc->daysToDate($days_year,"%Y-%m-%d");
        } else {
            print $lang->inteligo_file_bad_down;
        }
        return $date_next;
    } // end func _InteligoGetName

    /**
     * Funckcja sprawdza czy zaladowany zostal plik z bledami czy z transakcjami
     *
     * @access private
     *
     * @return boolean true/false
     */
     function _InteligoCheckFile() {
        list($name,$ext)=split("\.",$this->filename);
        $ext=strtolower($ext);
        if(($ext == "err") || ($ext == "trn") ) {
            $this->ext=$ext;
            return true;
        } else {
            return false;
        }
      } // end func _InteligoCheckFile

    /**
     * Funkcja tworzy formatke dla ulpoadu plikow oraz tworzy listê plików do sci±gniêcia
     * z ostatniego miesi±ca
     *
     * @access public
     *
     * @return boolean true/false
     */
    function _InteligoPrintList() {
        global $inteligo_config;

        include_once("./html/upload.html.php");
        // transakcje zatwierdzone dzis wystawiamy dopiero jutro
        // czyli prezentujemy plik od wczoraj wstecz
        $day_of_year=date("z");
        for($i=0;$i<30;$i++) {
            $days=$day_of_year-$i;
            $str=$inteligo_config->inteligo_merchant_id.$days.$this->number_files.".txt";
            print "<a href=file/$str>$str</a><br>";
        }
        return true;
    } // end func _InteligoPrintList


    /**
     * Funkcja sprawdza czy nastapialo polaczenie przez https
     *
     * @access private
     *
     * @return boolean true/false
     */
    function _InteligoCheckHttps() {
        if(!empty($_SERVER["HTTPS"])) {
            if($_SERVER["HTTPS"] == 'on') {
                return true;
            } else return false;
        } else return false;
    } // end func _InteligoCheckHttps

    /**
     * Funkcja sprawdza z jakich adresow nastapilo polaczenie
     *
     * @access private
     *
     * @return boolean true/false
     */
    function _InteligoCheckIpAddress() {
        //print $_SERVER["REMOTE_ADDR"];
        if(($_SERVER["REMOTE_ADDR"] == INTELIGO_IP_NUMBER) || ($_SERVER["REMOTE_ADDR"] == PARTNER_IP_NUMBER)) {
            return true;
        } else return false;
    } // end func _InteligoCheckIpAddress

    /**
     * Funkcja zapisuje uploadowany plik na dysk
     *
     * @access public
     *
     * @return boolean true/false
     */
    function _InteligoUpload() {
        global $lang;
		if (! empty($_FILES['datafile']['name'])) {
            $file=$_FILES['datafile'];
            $datafile=$file['name'];
            $this->filename=$datafile;
            $datafile_tmp=$file['tmp_name'];
            if(file_exists("$this->location/$datafile")) {
                print "<br><center>".$lang->inteligo_file_exists."</center><br><br>";
				return false;
			} else {
				copy($datafile_tmp,"$this->location/$datafile");
            }
			return true;
       } else {
            require_once ("./html/upload.html.php");
            return false;
       }
    } // end func _InteligoUpload

     /**
     * Funkcja zapisuje parsuje plik z transakcjami wszystkimi
     *
     * @access public
     *
     * @return boolean true/false
     */
    function _InteligoParseTRN() {
        global $lang;

        $file=$this->location.$this->filename;
        if(file_exists($file)) {
        // plik istnieje na serwerze
            $fd=fopen($file,"r");
            if($fd) {
                $i=0;
                while (!feof ($fd)) {
                    $buffer = fgets($fd,4096);
                    if($buffer != '') {
                        if($i > 6) {
                            $table=split($this->sep,$buffer);
                            $this->_InteligoSetParamTRN($table);
                        }
                    }
                $i++;
                }
            } else {
                print "<br><center>".$lang->inteligo_no_files_open."</center><br><br>";
            }
        } else {
            print "<br><center>".$lang->inteligo_no_files_trn."</center><br><br>";
        }
        print "<br><center>".$lang->inteligo_files_upload_ok."</center><br><br>";
        return true;
    } //end  func _InteligoParseTRN

     /**
     * Funkcja zapisuje aktualizuje baze danych
     *
     * @access private
     *
     * @return boolean true/false
     */
    function _InteligoSetParamTRN(&$table) {
        global $database;
        global $lang;
        // sprawdzamy czy transakcja o danym identyfikatorze istnieje w tablicy inteligo
        // identyfikator transakcji
        $txid=$table[1];
		$table[3]=trim($table[3]);
		$tmp=split("\/",$table[3]);
		$partner_confirm_date="20".$tmp[2]."-".$tmp[1]."-".$tmp[0];
		list($order_id,$outtrn)=$database->sql_select_data("order_id","outtrn","inteligo","txid=$txid");
        // je¶li tranasakcja jest w bazie danych ( u¿ytkownik wrocil po p³atnosci do sklepu
        // i dane transakcji zostaly zapisane w tablicy inteligo
        if(!empty($order_id)) {
            $count=$database->sql_select("count(*)","order_register","order_id=$order_id");
            if($count == 1) {
                // potwierdzamy transakcje w bazie danych
                $database->sql_update("order_register","order_id=$order_id",array(
										"pay_status"=>"000",
										"confirm_online"=>"1",
										"partner_confirm_date"=>$partner_confirm_date,
										));
            } else {
                // transakcji nie ma w order_register
                $database->sql_update("order_register","order_id=$order_id",array("pay_status"=>"452"));
            }
        // transakcji nie ma w bazie a to moze oznaczac, ze gosc nie wrocil po
        // transakcji do sklepu ale zaplacil
        } else {
            // odczytujemy pole Title1 z pliku *.trn
            $order_id=$table[6];
            $order_id=trim($order_id);
			$amount=trim($table[5]);
            // sprawdzamy czy transakcja o takim id istnieje w bazie danych
            $count=$database->sql_select("count(*)","order_register","order_id=$order_id");
            if($count == 1) {
                // jesli transkcja istnieje to zostaje ustawiony status na zaplacona
                $database->sql_update("order_register","order_id=$order_id",array(
										"pay_status"=>"000",
										"confirm_online"=>"1",
										"partner_confirm_date"=>$partner_confirm_date,
										));

				$database->sql_insert("inteligo",array(
														"txid"=>$txid,
														"order_id"=>$order_id,
														"date_add"=>date("YmdHis"),
														"amount"=>$this->compute_amount($amount),
														"amount_org"=>$amount,
														)
									  );
			} else {
                // jesli nie ma jej w bazie danych to blad
                $database->sql_update("order_register","order_id=$order_id",array("pay_status"=>"453"));
            }
        }
        return true;
    } // end func _InteligoSetParamTRN

     /**
     * Funkcja zapisuje parsuje plik z transakcjami blednymi
     *
     * @access private
     *
     * @return boolean true/false
     */
    function _InteligoParseERR() {
        global $lang;
        $file=$this->location.$this->filename;
        $records=array();
        if(file_exists($file)) {
        // plik istnieje na serwerze
            $fd=fopen($file,"r");
            if($fd) {
                $i=0;
                while (!feof ($fd)) {
                    $buffer = fgets($fd,4096);
                    $buffer=trim($buffer);
                    if($buffer != '') {
                        if($i > 10) {
                            array_push($records,$buffer);
                        }
                    }
                $i++;
                }
            } else {
                print "<br><center>".$lang->inteligo_no_files_open."</center><br><br>";
            }
            $this->_InteligoSetParamERR($records);
        } else {
            print "<br><center>".$lang->inteligo_no_files_trn."</center><br><br>";
        }
        print "<br><center>".$lang->inteligo_files_upload_ok."</center><br><br>";
        return true;
    } //end  func _InteligoParseERR

     /**
     * Funkcja zapisuje aktualizuje baze danych zwiazane z plikiem bledow
     *
     * @access private
     *
     * @return boolean true/false
     */
    function _InteligoSetParamERR(&$table) {
        global $database;
        global $lang;

        //print_r($table);
        $count=count($table);
        print $count;
        $param=array();
        for ($i=0;$i < $count; $i+=2 ) {
            $param=split("[ ]+",$table[$i]);
            $param=array_merge ($param,$table[$i+1]);
            $txid=trim($param[0]);
            //print "<pre>";
            //print_r($param);
            //print "</pre>";
            // sprawdzamy czy transakcja jest w talicy inteligo jako poprawnie zautoryzowana
            list($order_id,$outerr)=$database->sql_select_data("order_id","outerr","inteligo","txid=$txid");
            if(!empty($order_id)) {
                // sprawdzamy czy w order_register jest ta transakcja
                $count_id=$database->sql_select("count(*)","order_register","order_id=$order_id");
                if($count_id == 1) {
                    // zaznaczamy ze transakacja byla niepoprawa
                    $database->sql_update("order_register","order_id=$order_id",array("pay_status"=>"050"));
                }
            }
        }
        return true;
    } // end func _InteligoSetParamERR

} //end class InteligoFile
?>
