<?php
/**
* Obsluga przekazania kodow klientowi, przy sprzedazy on-line
*
* @author  m@sote.pl
* @version $Id: main_keys.inc,v 1.6 2005/08/30 12:02:17 maroslaw Exp $
* @todo Dodaæ sprawdzanie, czy klient wybra³ produkt do sprzeda¿y on-line. Je¶li tak, 
*       to powinny pojawiæ siê tylko p³atno¶ci z wiarygodnym potwierdzeniem danych
*       o autoryzacji on-line. Modyfikacja dot. m.in. register_pay_method.html.php
* @package    include
*/

global $__secure_test;
if  (@$__secure_test!=true) die ("Forbidden secure test main_keys");

require_once ("include/my_crypt.inc");

class MainKeys {
    var $status=false;         // znacznik nadania statusu transakcji

    /**
    * @var array $_mainKeysFTP informacja o tym ktore produkty zawieraja pliki - md5 kodu w main_keys
    *                          zawartosc pola md5_main_keys przypisanego do produktu kodu
    */
    var $_mainKeysFTP=array();

    /**
    * Pokaz(lub nie) kody do transakcji
    *
    * \@global array $_SESSION['prev_session'] wybrane dane z sesji przed skasowaniem koszyka
    *
    * @access public
    * @return none
    */
    function show() {
        global $_SESSION;
        global $lang;

        $prev_sess=@$_SESSION['prev_session'];
        if (empty($prev_sess)) return false;
        $order_id=$prev_sess['global_order_id'];

        // sprawdz czy kwota ujeta w sesji zgadza sie z kwota w bazie
        // jest to zabezpieczenie przed sfalszowaniem danych w seji, tak zeby nie bylo mozliwe
        // poprzez zmiane sesji (np. robienie zakupow z 2 okna przegladarki z ta sama sesja) zwiekszyc
        // ilosci produktow w koszyku, przez co pozniej otrzymac wiekszej ilosci kodow do zamowienia
        if ($this->check_amount($order_id,$prev_sess['global_basket_amount'])) {
            // sprawdz czy transakcja zostala zaplacona online
            if ($this->check_confirm_online($order_id)) {
                // transkacja zaplacona on-line, pokaz kody dla wybranych produktow,
                // ktore maja main_keys_online=1 w tabeli main
                $main_keys=$this->get_main_keys($order_id);
                $this->show_main_keys($main_keys);
                if (! empty($main_keys)) {
                    $this->send_main_keys($main_keys,$order_id);
                }
                $this->show_errors();
            } else {
                // transakcja nie zostala zaplacona on-line
                // nic nie wyswietlamy dodatkowo
            }

            // pokaz linki do plikow demo, jesli takowe sa zdefiniowane dla prouktow w koszyku
            $this->_showDemoFiles($prev_sess,$order_id);

        } else {
            // bledna weryfikacja kwoty zamowienia
        }

        return(0);
    } // end show()

    /**
    * Sprawdz czy kwota zakupow w sesji zgadza sie z kwota w bazie (bez kosztow dostawy)
    *
    * @param  int   $order_id id zamowienia
    * @param  float $amount
    *
    * @access public
    * @return bool  true - kwota ok, false w p.w.
    */
    function check_amount($order_id,$amount) {
        global $db;

        if (! ereg("^[0-9]+$",$order_id)) die ("Forbidden order_id");

        $query="SELECT amount FROM order_register WHERE order_id=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $db_amount=$db->FetchResult($result,0,"amount");
                    if ($amount==$db_amount) return true;
                    else return false;
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());

        return false;
    } // end check_amount()

    function checkAmount($order_id,$amount) {
        return $this->check_amount($order_id,$amount);
    } // end checkAmount()


    /**
    * Pokaz kody do produktow zamowionych online
    *
    * @param array $main_keys kody
    *
    * @access public
    * @return none
    */
    function show_main_keys($main_keys) {
        global $lang;
        global $config;
        global $mdbd;
        
        if ((! empty($main_keys)) || (! empty($this->_mainKeysFTP))) {

            print "<p /><table align=center width=50% border=0>\n";
            reset($main_keys);$title=false;
            while (list($user_id,$keys) = each ($main_keys)) {
                if ($title==false) {
                    print "<tr><td width=50%>".$lang->main_keys_title."</td></tr>\n";
                    $title=true;
                }
                if (! empty($this->_mainKeysFTP[$user_id])) {
                    // plik FTP
                    $code=$this->_mainKeysFTP[$user_id];
                    $o=$this->_showCode($code,$user_id);
                    if (! empty($o)) {
                        print "<tr>\n";
                        print "<td valign=top>";
                        print "<b>".$this->main_keys_name[$user_id]."</b></td>";
                        // pokaz link do pliku z kodem
                        print "<td valign=top>\n";
                        print $o;
                        print "</td>";
                        print "</tr>";
                    }
                } else {
                    // kod on-line
                    print "<tr>\n";

                    if (is_array($keys)) {
                        print "<td><b>".$this->main_keys_name[$user_id]."</b></td>";
                        print "<td valign=top>\n";
                        foreach ($keys as $key) {
                            print "<li>$key</li>\n";
                        }
                        print "</td>\n";
                    } else {
                        print "<td><b>".$this->main_keys_name[$user_id]."</b></td>";
                        print "<td valign=top>".$keys."</td>\n";
                    }
                    print "</tr>\n";
                }
                print "</tr>\n";
            } // end foreach

            print "</table>\n";
            print "<p />";
        }

        // sprawdz czy do produktu jest przypisany plik
        if (! empty($this->_mainKeysFTP[@$user_id])) {
            $this->_showMainKeysFTP($user_id);
        }

        return(0);
    } // end show_main_keys()

    /**
    * Wstaw link do danego programu/pliku wg podanego kode $code
    *
    * @param string $code     kod do pliku
    * @param string $user_id  user_id produktu
    * @param string $type     HOST|NONE HOST oznacza wsatwienie pelnego linku http://
    * @param string $file_ftp nazwa pliku do pobrania
    *
    * @access private
    * @return string kod HTML z linkiem do pliku
    */
    function _showCode($code,$user_id,$type="NONE",$file_ftp='') {
        global $mdbd,$config,$lang;

        if (empty($file_ftp)) {
            $file_ftp=$mdbd->select("ftp","main_keys_ftp","user_id_main=? AND demo=0",array($user_id=>"text"),"LIMIT 1");
            if (empty($file_ftp)) return '';
        }
        if ($type=="HOST") {
            $prefix="http://".$_SERVER['HTTP_HOST'];
            $o="$prefix".$config->url_prefix."/plugins/_main_keys/$file_ftp?code=$code";
        } else {
            $o="<a href=".$config->url_prefix."/plugins/_main_keys/$file_ftp?code=$code>";
            $o.="<u>".$file_ftp." ".$lang->main_keys_download."</u></a>";
        }

        return $o;
    }  // end _showCode()

    function showMainKeys($main_keys) {
        return $this->show_main_keys($main_keys);
    } // end showMainKeys()

    /**
    * Sprawdz czy produkt ma przypisany plik, jesli tak to zapisz dane w $this->_mainKeysFTP[$user_id]
    * oraz generuj wpis do main_keys z losowym kodem, ktory zostanie przypisany do zamowienia
    *
    * @param string $user_id            user_id produktu
    * \@global array $this->_maimKeysFTP informacje o plikach przypisanych do produktu
    *
    * @access private
    * @return none
    */
    function _setMainKeysFTP($user_id) {
        global $mdbd;
        $my_crypt = new MyCrypt;
        $file=$mdbd->select("ftp","main_keys_ftp","user_id_main=? AND active=1",array($user_id=>"int"),"LIMIT 1");
        $rnd_key=$my_crypt->endecrypt("",$this->_randomKey()); $md5_rnd_key=md5($rnd_key);
        if (! empty($file)) {
            $mdbd->insert
            ("main_keys","user_id_main,main_key,main_key_md5","?,?,?",
            array("1,".$user_id=>"text",
            "2,".$rnd_key=>"text",
            "3,".$md5_rnd_key=>"text"
            )
            );
            $this->_mainKeysFTP[$user_id]=$md5_rnd_key;
        }
        return(0);
    } // end _setMainKeysFTP()

    /**
    * Generuj lossowy kod
    *
    * @access private
    * @reutrn string losowy kod 32 znaki
    */
    function _randomKey() {
        return md5(microtime().date("YmdHis").rand(1,1000000));
    } // end randomKey()

    /**
    * Send main_keys, wyslij kody do klienta
    *
    * @param  array $main_keys kody dla uzytkwonika wg. kluczy reprezentujacyhc dany produkt
    * @param  int   $order_id  id zamowienia
    * @return bool true - kody wyslane do klienta, false - nie udalo sie wyslac kodow mailem
    */
    function send_main_keys($main_keys,$order_id) {
        global $shop;
        global $config;
        global $_SESSION;
        global $lang;

        // start #240
        // if (! empty($_SESSION['form']['email'])) {
        //     $email=$_SESSION['form']['email'];
        // } else return false;
        global $mdbd;
        $id_users_data=$mdbd->select("id_users_data","order_register","order_id=?",array($order_id=>"int"),"LIMIT 1");
        $crypt_email=$mdbd->select("crypt_email","users","id=?",
        array($id_users_data=>"int"),"LIMIT 1");
        $my_crypt = new MyCrypt;
        $email=$my_crypt->endecrypt("",$crypt_email,"de");
        if (empty($email)) return false;
        // end #240

        if (! ereg("^[0-9]+$",$order_id)) return false;

        $from=$config->from_email;
        $to=$email;
        $subject=$config->www.": ".$lang->main_keys_mail['subject']." ORDER-ID: ".$order_id;

        // start tresc maila:
        $body='';
        $body.=$lang->main_keys_mail['title']." $config->www:\n\n";
        while (list($user_id,$keys) = each ($main_keys)) {
            $name=$this->main_keys_name[$user_id];
            $body.=$lang->main_keys_mail['user_id'].": ".$user_id." ".$lang->main_keys_mail['name'].": $name\n";
            if (! empty($this->_mainKeysFTP[$user_id])) {
                $code=$this->_mainKeysFTP[$user_id];
                $body.="\t".$this->_showCode($code,$user_id,"HOST")."\n";
            } else {
                if (is_array($keys)) {
                    foreach ($keys as $key) {
                        $body.="\t $key\n";
                    } // end foreach
                } else {
                    $body.="\t $keys\n";

                }
            }

        } // end foreach
        $body.="\n";
        // end tresc maila:

        $reply=$config->from_email;

        $shop->mail();
        $shop->mail->send($from,$to,$subject,$body,$reply);

        return (0);
    } // end send_main_keys()

    function sendMainKeys($main_keys,$order_id) {
        return $this->send_main_keys($main_keys,$order_id);
    } // end sendmainKeys()

    /**
    * Pokaz dodatkowe komuniakty o "bledach" do zamowienia
    *
    * @access public
    * @return none
    */
    function show_errors() {
        global $lang;

        if (! empty($this->errors)) {
            reset($this->errors);
            print "<p></p>\n";
            print "<table><tr><td valign=top align=left>\n";
            print "&nbsp;".$lang->main_keys_errors_title."<br />\n";
            print "<table>\n";
            print "<tr><th align=left>".$lang->main_keys_cols['name']."</th><th align=left>".$lang->main_keys_cols['info']."</tr>\n";
            print "<tr>";
            while (list($name,$error) = each ($this->errors)) {
                print "<td valign=top><b>$name</b></td valign=top><td>$error</td>\n";
            }
            print "</tr>\n";
            print "</table>\n";
            print "</td></tr></table>";
            print "<p></p>";
        }

        return(0);
    } // end show_errors()

    function showErrors() {
        return $this->show_errors();
    } // end showErrors()

    /**
    * Odczytaj liste produktow i ilosc z zamowienia z order_register
    *
    * @param int $order_id id zamowienia
    *
    * @access private
    * @return array lista produktow + ilosc array(0=>array("user_id"=>"A001","num"=>2),
    *                                                array("user_id"=>"B002","num"=>1)), ...
    */
    function _order2Items($order_id) {
        global $mdbd;

        $order=$mdbd->select("user_id_main,name,num","order_products","order_id=?",array($order_id=>"int"),'',"ARRAY");
        return $order;
    } // end _order2Items()

    /**
    * Sprawdz, czy ktorys z produktow z koszyka jest do sprzedazy
    * on-line i jesli tak to pobierz odpowiednie kody
    *
    * @param int    $order_id id zamowienia
    * \@global array $_SESSION['prev_session'] wybrane dane z sesji przed skasowaniem koszyka
    * \@global array $this->main_keys_name nazwy produktow user_id->nazwa
    *
    * @access public
    * @return array $this->main_keys kody do zamowienia
    */
    function get_main_keys($order_id) {
        global $lang;

        if (! ereg("^[0-9]+$",$order_id)) return false;

        $this->main_keys=array();

        // #234
        // global $_SESSION;
        // $items=$_SESSION['prev_session']['my_basket']->items;
        // odczytaj liste produktow + ilosc z zamowienia
        // end #234
        $items=$this->_order2Items($order_id);
        if (! empty($items)) {

            foreach ($items as $item) {
                $item['user_id']=$item['user_id_main'];
                // sprawdz czy produkt ma przypisany jakis plik
                // jesli tak, to generuj wpis kodu do main_keys
                $this->_setMainKeysFTP($item['user_id']);

                $keys=$this->get_key($item['user_id'],$item['num'],$order_id);
                if (($keys) && ($keys!=-1)) {
                    $this->main_keys[$item['user_id']]=$keys;
                    $this->main_keys_name[$item['user_id']]=$item['name'];
                    if (! $this->status) {
                        // przydzielono kody do zamowienia
                        $this->set_status($order_id,'001');
                    }
                } elseif ($keys==-1) {
                    // produkt nie ma przypisanych kodow, produkt nie sprzedawany on-line
                } else {
                    // dla danego $item zabraklo kodow
                    $this->set_status($order_id,'050');
                    $this->errors[$item['name']]=$lang->main_keys_empty;
                }

            } // end foreach
        } else {
            return false;
        }

        return $this->main_keys;
    } // end get_main_keys()

    function getMainKeys($order_id) {
        return $this->get_main_keys($order_id);
    } // end getMainKeys()

    /**
    * Ustaw status dot. main_keys
    *
    * @param  int    $order_id id zamowienia
    * @param  string $status   status  dot. main_keys np.
    *                          '050' - zabraklo kodow do realizacji calego zlecenia
    *
    * @access public
    * @return bool   true - status zaktualizowany, false - w p.w.
    */
    function set_status($order_id,$status) {
        global $db;

        $query="UPDATE order_register SET main_keys_status=? WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$status);
            $db->QuerySetInteger($prepared_query,2,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $this->status=true;
                return true;
            } else die ($db->Error());
        } else die ($db->Error());

        return false;
    } // end set_status()

    function setStatus($order_id,$status) {
        return $this->setStatus();
    } // end setStatus()

    /**
    * Odczytaj kody dla danego produktu
    *
    * @param string $user_id  user_id produktu
    * @param int    $num      ilosc zakupionego produktu
    * @param int    $order_id id zamowienia
    *
    * @access public
    * @return string|array|int 1 kod lub tablica kodow, -1 - produkt nie jest sprzedawany on-line
    */
    function get_key($user_id,$num=1,$order_id) {
        global $db;

        $my_crypt = new MyCrypt;

        // sprawdz czy produkt jest ma kody
        $query="SELECT main_keys_online FROM main WHERE user_id=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$user_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $main_keys=$db->FetchResult($result,0,"main_keys_online");
                    if ($main_keys!=1) return -1;
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());
        // end

        // odczytaj kody dla produktu
        $query="SELECT id,main_key FROM main_keys WHERE user_id_main=? AND order_id=0 ORDER BY id LIMIT ?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$user_id);
            $db->QuerySetInteger($prepared_query,2,$num);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows==1) {
                    $crypt_main_key=$db->FetchResult($result,0,"main_key");
                    $id=$db->FetchResult($result,0,"id");
                    if (! $this->set_key_used($id,$order_id)) return false;
                    $main_key=$my_crypt->endecrypt("",$crypt_main_key,"de");

                    return $main_key;

                } elseif ($num_rows==$num) {
                    // zmiana na warunek >1, spowoduje wyswietlenie dostepnej ilosci kodow nie koniecznie=$num
                    $tab_main_keys=array();
                    for ($i=0;$i<$num_rows;$i++) {
                        $crypt_main_key=$db->FetchResult($result,$i,"main_key");
                        $main_key=$my_crypt->endecrypt("",$crypt_main_key,"de");
                        $tab_main_keys[$i]=$main_key;
                        $id=$db->FetchResult($result,$i,"id");
                        if (! $this->set_key_used($id,$order_id)) return false;

                    } // end for
                    return $tab_main_keys;
                } else {
                    return false;
                }
            } else die ($db->Error());
        } else die ($db->Error());
        // end

        return false;
    } // end get_key();

    function getKey($user_id,$num=1,$order_id) {
        return $this->get_key($user_id,$num,$order_id);
    } // end getKey()

    /**
    * Zaznacz kod jako wykorzystany przez nadanie mu numeru order_id
    *
    * @param int $id       id kodu z tabeli main_keys
    * @param int $order_id id zamowienia
    *
    * @access public
    * @return none
    */
    function set_key_used($id,$order_id) {
        global $db;

        if (! ereg("^[0-9]+$",$id)) return false;
        if (! ereg("^[0-9]+$",$order_id)) return false;

        $query="UPDATE main_keys SET order_id=? WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order_id);
            $db->QuerySetInteger($prepared_query,2,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                return true;
            } else die ($db->Error());
        } else die ($db->Error());

        return false;
    } // end set_key_used()

    function setKeyUsed($id,$order_id) {
        return $this->set_key_used($id,$order_id);
    } // end setKeyUsed

    /**
    * Sprawdz czy transakcja zostala zaplacona on-line
    *
    * @param  int $order_id order_id zamowienia
    *
    * @access public
    * @return bool true transakcja zaplacona online, false w p.w.
    */
    function check_confirm_online($order_id) {
        global $db;
        if (! ereg("^[0-9]+$",$order_id)) return false;

        $query="SELECT confirm,checksum,confirm_online,checksum_online,amount,delivery_cost FROM order_register WHERE order_id=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {

                    $confirm=$db->FetchResult($result,0,"confirm");
                    $checksum=$db->FetchResult($result,0,"checksum");

                    $confirm_online=$db->FetchResult($result,0,"confirm_online");
                    $checksum_online=$db->FetchResult($result,0,"checksum_online");
                    if (empty($checksum_online)) return false;

                    $amount=$db->FetchResult($result,0,"amount");
                    $delivery_cost=$db->FetchResult($result,0,"delivery_cost");
                    $amount_all=number_format(($amount+$delivery_cost),2,".","");

                    // sprawdz sume kontrolna
                    // sprawdzamy dla confirm=0 bo transakcja nie ma jeszzce zmienionego statusu w bazie
                    require_once ("include/order_register.inc");
                    $my_checksum_online=OrderRegisterChecksum::checksum($order_id,1,$amount_all);
                    $my_checksum=OrderRegisterChecksum::checksum($order_id,1,$amount_all);

                    // TMP wylaczenie sprawdzenia sumy kontrolnej i platnosci online
                    // return true;
                    // end                    
                    
                    if (($my_checksum_online!=$checksum_online) && ($my_checksum!=$checksum)) return false;
                    else {
                        // sprawdz czy status platnosci online = 1
                        if (($confirm_online==1) | ($confirm==1)) {
                            return true;
                        } else return false;
                    }

                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());

        return false;
    } // end check_confirm_online()

    function checkConfirmOnline($order_id) {
        return $this->check_confirm_online($order_id);
    } // end checkConfirmOnline()

    /**
    * Sprawdz czy dany produkt ma przypisany plik DEMO, jesli tak to odczytaj nazwe pliku
    *
    * @param string $user_id user_id produktu
    *
    * @access private
    * @return string  nazwa pliku demo lub none
    */
    function _getDemoFile($user_id) {
        global $mdbd;
        $demo_file=$mdbd->select("ftp","main_keys_ftp","user_id_main=? AND demo=1",array($user_id=>"text"),"LIMIT 1");
        return $demo_file;
    } // end _getDemoFile()

    /**
    * Pokaz linki do plikow demo
    *
    * @param array $prev_sess dane dot. kszyka z sesji z zankupow
    * @param int   $oreder_id ID zamowienia
    *
    * @access private
    * @return none
    */
    function _showDemoFiles($prev_sess,$order_id) {
        global $lang;
        global $mdbd;

        $my_basket=$prev_sess['my_basket'];
        $items=@$my_basket->items;
        if (! empty($items)) {
            reset($items);$title=false;
            foreach ($items as $item) {
                $demo_file=$this->_getDemoFile($item['user_id']);                                
                if (! empty($demo_file)) {
                    $this->_setMainKeysFTP($item['user_id']);
                    if ($title==false) {
                        print "<p /><table width=50%>";
                        print "<tr><td width=50%>".$lang->main_keys_demo_title."</td></tr>";
                        $title=true;
                    } else print "<tr>";
                    $dat=$mdbd->select("id","main_keys_ftp","user_id_main=? AND demo=1",
                    array($item['user_id']=>"text","LIMIT 1"));
                    $name=$mdbd->select("name_L0","main","user_id=?",array($item['user_id']=>"text"),"LIMIT 1");
                    $id=$dat['id'];
                    print "<td><b>".$name."</b></td>";
                    print "<td>";
                    print $this->_showCode($this->_mainKeysFTP[$item['user_id']],$item['user_id'],"NONE",$demo_file);
                    print "</td>";
                    print "</tr>";
                } // end if
            } // end foreach
            print "</table>\n";
        } // end if

        return(0);
    } // end _showDemoFiles()

} // end class MainKeys
?>
