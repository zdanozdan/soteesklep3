<?php
/**
 * Klasa do komunkacji z Allegro.
 * Podstawowe funkcje
 *
 */
include_once("config/auto_config/allegro_config.inc.php");
include_once("NuSOAP/nusoap.php");
include_once("include/metabase.inc");
include_once('lib/ConvertCharset/ConvertCharset.class.php');

class Allegro {

    var $_debug=0;              // czy tryb debugowania

    /**
	 * Enter description here...
	 *
	 * @return Allegro
	 */
    function Allegro() {

    } // end func Allegro

    /**
	 * Pobranie drzewa kategorii z Allegro.pl
	 *
	 */
    function getCategory()
    {
        global $_SESSION;
        global $allegro_config;
        global $lang;
        global $database;
        // ustawienie parametów wywo³ania SOAP

        // jesli allegro jest w trybie produkcyjnym to
        if($allegro_config->allegro_mode == 'true') {
            $parameters = array(
            $allegro_config->allegro_country_code,          // kod kraju
            $allegro_config->allegro_version,               // numer wersji WEBAPI
            $allegro_config->allegro_web_api_key,           // klucz WEBAPI allegro
            );
        } else {
            $parameters = array(
            $allegro_config->allegro_country_code_test,     // kod kraju
            $allegro_config->allegro_version_test,          // numer wersji WEBAPI
            $allegro_config->allegro_web_api_key,           // klucz WEBAPI allegro
            );
        }
        // stworzenie obiektu SOAP
        $client = new soapclient($allegro_config->allegro_server,true);
        $client->decode_utf8=false;
        // pobranie b³êdów je¶li trakie by³y
        $errors = $client->getError();
        if ($errors) {
            // Wyswietlenie bledow wywoalania - niepowodzenie
            echo '<h2>Blad </h2><pre>' . $errors . '</pre>';
        }
        // wywo³anie metody
        $response = $client->call('doGetCatsData',$parameters);
        if(!empty($response['faultcode'])) {
            $convertChar = new ConvertCharset();
            $afterChange = $convertChar->Convert($response['faultstring'],'utf-8','iso-8859-2');
         	print $afterChange;
        } else {
            if($this->_debug) {
                print "<pre>";
                print_r($response);
                print "</pre>";
            }
            $this->saveCategory($response);
            // sprawdzamy czy do bazy zostaly zapisane kategorie
            $count=$database->sql_select("count(*)","allegro_cat");
            if($count) {
                if($allegro_config->allegro_mode == 'true') {
                    if($response['ver-key']=$allegro_config->allegro_version) {
                        print "<center>".$lang->get_category_ok."<center>";
                    }
                } else {
                    if($response['ver-key']=$allegro_config->allegro_version_test) {
                        print "<center>".$lang->get_category_ok."<center>";
                    }
                }
            } else {
                print $lang->allegro_error_auction['category'];
            }
        }
    } // end func getCategory

    /**
     * Enter description here...
     *
     */
    function getOther()
    {
        global $_SESSION;
        global $allegro_config;
        global $lang;
        // ustawienie parametów wywo³ania SOAP

        // jesli allegro jest w trybie produkcyjnym to
        if($allegro_config->allegro_mode == 'true') {
            $parameters = array(
            $allegro_config->allegro_country_code,      // kod kraju
            $allegro_config->allegro_version,            // numer wersji WEBAPI
            $allegro_config->allegro_web_api_key,       // klucz WEBAPI allegro
            );
        } else {
            $parameters = array(
            $allegro_config->allegro_country_code_test,      // kod kraju
            $allegro_config->allegro_version_test,            // numer wersji WEBAPI
            $allegro_config->allegro_web_api_key,       // klucz WEBAPI allegro
            );
        }
        // stworzenie obiektu SOAP
        $client = new soapclient($allegro_config->allegro_server, true);
        $client->decode_utf8=false;
        // pobranie b³êdów je¶li trakie by³y
        $errors = $client->getError();
        if ($errors) {
            // Wyswietlenie bledow wywoalania - niepowodzenie
            echo '<h2>Blad </h2><pre>' . $errors . '</pre>';
        }
        // wywo³anie metody
        $response = $client->call('doGetSellFormFields',$parameters);
        if(!empty($response['faultcode'])) {
            // jest jakis b³±d
            $convertChar = new ConvertCharset();
            print $convertChar->Convert($response['faultstring'],'utf-8','iso-8859-2');
        } else {
            if($this->_debug) {
                print "<pre>";
                print_r($response);
                print "</pre>";
            }
            $this->prepareOther($response['sell-form-fields']);
            if($allegro_config->allegro_mode == 'true') {
                if($response['ver-key']=$allegro_config->allegro_version) {
                    print "<center>".$lang->get_other_ok."<center>";
                }
            } else {
                if($response['ver-key']=$allegro_config->allegro_version_test) {
                    print "<center>".$lang->get_other_ok."<center>";
                }
            }
        }
    } // end func getOther

    /**
     * Funkcja parsuje dane z prametrow allegro i zwraca tablice asocjacyjna
     *
     * @param array  data  dane z allegro
     * @param string index index tablicy 
     *
     * @return array $tab
     */
    function prepareArray(& $data, $index)
    {
        $tab=array();
        $sell_form_desc=preg_split("/\|/",$data[$index]['sell-form-desc'],-1,PREG_SPLIT_NO_EMPTY);
        $sell_form_opts_values=preg_split("/\|/",$data[$index]['sell-form-opts-values'],-1,PREG_SPLIT_NO_EMPTY);
        foreach($sell_form_desc as $key=>$value) {
            $tab= $tab+array($sell_form_opts_values[$key]=>$this->utf8_to_8859($value));
        }
        return $tab;
    } // end func prepareArray

    /**
     * Pobranie innych danych z allegro
     *
     * @param array  data  dane z allegro
     *
     * @return boolean true/false
     */
    function prepareOther(& $data)
    {
        //pobierz czas trwania aukcji
        $this->allegro_time=array();
        if($data[3]['sell-form-id'] == 4) {
            $this->allegro_time = $this->prepareArray(& $data, 3);
        }
        // pobierz województwa
        if($data[9]['sell-form-id'] == 10) {
            $this->allegro_states = $this->prepareArray(& $data, 9);
        }
        // transport
        if($data[11]['sell-form-id'] == 12) {
            $this->allegro_trans = $this->prepareArray(& $data, 11);
        }
        return true;
    } // end func prepareOther

    /**
	 * Zapisanie katergorii do bazy danych
	 *
     * @param array category
     *
     * @return boolean true/false
	 */
    function saveCategory(& $category)
    {
        global $database;
        // skasuj zawartosc tablicy
        $database->sql_delete("allegro_cat");
        // przejdz po tablicy i zapisz kategrii do bazy danych
        foreach($category['cats-list'] as $key=>$value) {
            $database->sql_insert("allegro_cat",array(
            "id"=>"",
            "cat_id"=>$value['cat-id'],
            "cat_name"=>$this->utf8_to_8859($value['cat-name']),
            "cat_parent"=>$value['cat-parent'],
            "cat_position"=>$value['cat-position'],
            ));
        }
        return true;
    } // end func saveCategory

    /**
     * Logowanie do systemu allegro.pl. Po zalogowaniu otrzymujemy numer sesji
     *
     * @return boolean true/false
     */
    function Login()
    {
        global $allegro_config;
        global $allegro;
        global $sess;
        // ustawienie parametów wywo³ania SOAP

        // jesli allegro jest w trybie produkcyjnym to
        if($allegro_config->allegro_mode == 'true') {
            $parameters = array(
            $allegro_config->allegro_login,             // login w allegro
            $allegro_config->allegro_password,          // has³o w allegro
            $allegro_config->allegro_country_code,      // kod kraju
            $allegro_config->allegro_web_api_key,       // klucz WEBAPI allegro
            $allegro_config->allegro_version            // numer wersji WEBAPI
            );
        } else {
            // tryb testowy
            $parameters = array(
            $allegro_config->allegro_login_test,             // login w allegro
            $allegro_config->allegro_password_test,          // has³o w allegro
            $allegro_config->allegro_country_code_test,      // kod kraju
            $allegro_config->allegro_web_api_key,       // klucz WEBAPI allegro
            $allegro_config->allegro_version_test            // numer wersji WEBAPI
            );
        }
        // stworzenie obiektu SOPA
        $client = new soapclient($allegro_config->allegro_server, true);
        // pobranie b³êdów je¶li trakie by³y
        $errors = $client->getError();
        if ($errors) {
            // Wyswietlenie bledow wywoalania - niepowodzenie
            echo '<h2>Blad </h2><pre>' . $errors . '</pre>';
        }
        // wywo³anie metody
        $response = $client->call('doLogin',$parameters);

        // sprawdz
        if(!empty($response['session-handle-part'])) {
            $allegro=$response;
            $sess->register("allegro",$allegro);
            return true;
        } else {
            print "<font color=red>";
           	print "<b>Problem z zalogowaniem siê do systemu Allegro. Upewnij siê, ¿e masz za³o¿one konto w systmie Allegro.</b>";
            print "</font>";
        	return false;
        }
    } // end func Login

    /**
     * Wylogowanie z allegro ( skasowanie z sesji sklepu danych zwiazanych z allegro )
     *
     * @return boolean true/false
     */
    function Logout()
    {
        global $sess;
        $sess->unregister("allegro");
        return true;
    } // end func Logout

    /**
     * Funkcja konwertujaca string z standardu utf-8 na iso-8859-2
     *
     * @param  string $string  ciag znakow,
     *
     * @return string $string  ciag znakow po konwersji
     */
    function & utf8_to_8859(&$string) {
        $decode=array(
        "\xC4\x84"=>"\xA1",
        "\xC4\x85"=>"\xB1",
        "\xC4\x86"=>"\xC6",
        "\xC4\x87"=>"\xE6",
        "\xC4\x98"=>"\xCA",
        "\xC4\x99"=>"\xEA",
        "\xC5\x81"=>"\xA3",
        "\xC5\x82"=>"\xB3",
        "\xC5\x83"=>"\xD1",
        "\xC5\x84"=>"\xF1",
        "\xC3\x93"=>"\xD3",
        "\xC3\xB3"=>"\xF3",
        "\xC5\x9A"=>"\xA6",
        "\xC5\x9B"=>"\xB6",
        "\xC5\xB9"=>"\xAC",
        "\xC5\xBA"=>"\xBC",
        "\xC5\xBB"=>"\xAF",
        "\xC5\xBC"=>"\xBF"
        );

        $string = strtr("$string",$decode);
        return $string;
    } // end func utf8_to_8859

    /**
     * Funkcja konwertujaca string z standardu iso-8859-2 na utf-8
     *
     * @param  string $string  ciag znakow,
     *
     * @return string $string  ciag znakow po konwersji
     */
    function & iso8859_to_utf8(&$string) {
        $decode=array(
        "\xA1" => "\xC4\x84",
        "\xB1" => "\xC4\x85",
        "\xC6" => "\xC4\x86",
        "\xE6" => "\xC4\x87",
        "\xCA" => "\xC4\x98",
        "\xEA" => "\xC4\x99",
        "\xA3" => "\xC5\x81",
        "\xB3" => "\xC5\x82",
        "\xD1" => "\xC5\x83",
        "\xF1" => "\xC5\x84",
        "\xD3" => "\xC3\x93",
        "\xF3" => "\xC3\xB3",
        "\xA6" => "\xC5\x9A",
        "\xB6" => "\xC5\x9B",
        "\xAC" => "\xC5\xB9",
        "\xBC" => "\xC5\xBA",
        "\xAF" => "\xC5\xBB",
        "\xBF" => "\xC5\xBC",
        );
        $string = strtr("$string",$decode);
        return $string;
    } // end func encoding_iso8859_2_to_utf8

    /**
     * Funkcja preparuje liste podkategorii dla kategorii g³ównej
     *
     * @param unknown $cat
     */
    function & prepareSubCat($cat,$default='')
    {
        global $database;
        $str='';
        $data1=$database->sql_select_data_array("cat_id","cat_name","allegro_cat","cat_parent=$cat");
        foreach($data1 as $key1=>$value1) {
            $count1=$database->sql_select("count(*)","allegro_cat","cat_parent=".$key1);
            if($count1) {
                $data2=$database->sql_select_data_array("cat_id","cat_name","allegro_cat","cat_parent=$key1");
                foreach($data2 as $key2=>$value2) {
                    $count2=$database->sql_select("count(*)","allegro_cat","cat_parent=".$key2);
                    if($count2) {
                        $data3=$database->sql_select_data_array("cat_id","cat_name","allegro_cat","cat_parent=$key2");
                        foreach($data3 as $key3=>$value3) {
                            $count3=$database->sql_select("count(*)","allegro_cat","cat_parent=".$key3);
                            if($count3) {
                                $data4=$database->sql_select_data_array("cat_id","cat_name","allegro_cat","cat_parent=$key3");
                                foreach($data4 as $key4=>$value4) {
                                    $count4=$database->sql_select("count(*)","allegro_cat","cat_parent=".$key4);
                                    if($count4) {
                                        $data5=$database->sql_select_data_array("cat_id","cat_name","allegro_cat","cat_parent=$key4");
                                        foreach($data5 as $key5=>$value5) {
                                            $count5=$database->sql_select("count(*)","allegro_cat","cat_parent=".$key5);
                                            if($count5) {
                                            } else {
                                                if($default == $key5) $checked=" selected"; else $checked="";
                                                $str.="<option  value=\"".$key5."\"".@$checked.">".$value1." >> ".$value2." >> ".$value3." >> ".$value4." >> ".$value5."</option>\n";
                                            }
                                        }
                                    } else {
                                        if($default == $key4) $checked=" selected"; else $checked="";
                                        $str.="<option  value=\"".$key4."\"".@$checked.">".$value1." >> ".$value2." >> ".$value3." >> ".$value4."</option>\n";
                                    }
                                }
                            } else {
                                if($default == $key3) $checked=" selected"; else $checked="";
                                $str.="<option  value=\"".@$key3."\"".@$checked.">".@$value1." >> ".@$value2." >> ".@$value3."</option>\n";
                            }
                        }
                    } else {
                        if($default == $key2) $checked=" selected"; else $checked="";
                        $str.="<option  value=\"".@$key2."\"".@$checked.">".@$value1." >> ".@$value2."</option>\n";
                    }
                }
            } else {
                if($default == $key1) $checked=" selected"; else $checked="";
                $str.="<option  value=\"".$key1."\"".@$checked.">".$value1."</option>\n";
            }
        }
        return $str;
    } // end func prepareSubCat

    /**
     * Funkcja buduje liste kategorii 
     *
     * @return string $str lista rozwiajana z aktywnymi kategoriami
     */
    function buildTree($default='')
    {
        global $allegro_config;
        $str='<select class=form name="item[allegro_category]" size="1"><option value="default">----wybierz----</option>'."\n";
        foreach($allegro_config->allegro_category as $key=>$value) {
            $str.=$this->prepareSubCat($value,$default);
        }
        $str.="</select>\n";
        return $str;
    } // end func buildTree

    /**
     * Preparujemy aukcje dla okreslonego user_id
     *
     * @param string user_id
     *
     * @return array $param  tablica zawierajace wszytkie potrzebne paramtry do wystawienia aukcji
     */
    function & prepareAuction($user_id)
    {
        global $database;
        global $allegro_config;
        $data=$database->sql_select_multi_array4("*","allegro_auctions","user_id=".$user_id);

        $param=array();
        // tytul aukcji
        $param[0]=array('fid'=>1,
        'fvalue-string'=>$this->iso8859_to_utf8($data[0]['allegro_product_name']),
        'fvalue-int'=>'','fvalue-float'=>'','fvalue-image'=>'','fvalue-text'=>'','fvalue-datetime'=>'','fvalue-boolean'=>'');

        $param[1]=array('fid'=>2,'fvalue-string'=>'',
        'fvalue-int'=>$data[0]['allegro_category'],
        'fvalue-float'=>'','fvalue-image'=>'','fvalue-text'=>'','fvalue-datetime'=>'','fvalue-boolean'=>'');

        $param[2]=array('fid'=>3,'fvalue-string'=>'','fvalue-int'=>'','fvalue-float'=>'','fvalue-image'=>'','fvalue-text'=>'',
        'fvalue-datetime'=>time(),
        'fvalue-boolean'=>'');

        $param[3]=array('fid'=>4,'fvalue-string'=>'',
        'fvalue-int'=>$data[0]['allegro_how_long'],
        'fvalue-float'=>'','fvalue-image'=>'','fvalue-text'=>'','fvalue-datetime'=>'','fvalue-boolean'=>'');

        $param[4]=array('fid'=>5,'fvalue-string'=>'',
        'fvalue-int'=>$data[0]['allegro_stock'],
        'fvalue-float'=>'','fvalue-image'=>'','fvalue-text'=>'','fvalue-datetime'=>'','fvalue-boolean'=>'');

        $param[5]=array('fid'=>6,'fvalue-string'=>'','fvalue-int'=>'',
        'fvalue-float'=>$data[0]['allegro_price_start'],
        'fvalue-image'=>'','fvalue-text'=>'','fvalue-datetime'=>'','fvalue-boolean'=>'');

        $param[6]=array('fid'=>7,'fvalue-string'=>'','fvalue-int'=>'',
        'fvalue-float'=>$data[0]['allegro_price_min'],
        'fvalue-image'=>'','fvalue-text'=>'','fvalue-datetime'=>'','fvalue-boolean'=>'');

        $param[7]=array('fid'=>8,'fvalue-string'=>'','fvalue-int'=>'',
        'fvalue-float'=>$data[0]['allegro_price_buy_now'],
        'fvalue-image'=>'','fvalue-text'=>'','fvalue-datetime'=>'','fvalue-boolean'=>'');

        if($allegro_config->allegro_mode == 'true') {
            $param[8]=array('fid'=>9, 'fvalue-string'=>'',
            'fvalue-int'=>$allegro_config->allegro_country_code,
            'fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        } else {
            $param[8]=array('fid'=>9, 'fvalue-string'=>'',
            'fvalue-int'=>$allegro_config->allegro_country_code_test,
            'fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        }

        $param[9]=array('fid'=>10, 'fvalue-string'=>'',
        'fvalue-int'=>$allegro_config->allegro_state_select,
        'fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');

        $param[10]=array('fid'=>11,
        'fvalue-string'=>$this->iso8859_to_utf8($allegro_config->allegro_city),
        'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');

        $param[11]=array('fid'=>12, 'fvalue-string'=>'',
        'fvalue-int'=>$data[0]['allegro_delivery_who_pay'],
        'fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');

        $param[12]=array('fid'=>13, 'fvalue-string'=>'',
        'fvalue-int'=>1,
        'fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');

        $param[13]=array('fid'=>14, 'fvalue-string'=>'',
        'fvalue-int'=>1,
        'fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');

        $param[14]=array('fid'=>15, 'fvalue-string'=>'',
        'fvalue-int'=>1,
        'fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');

        $param[15]=array('fid'=>16, 'fvalue-string'=>'', 'fvalue-int'=>'','fvalue-float'=>'',
        'fvalue-image'=>$this->preparePhoto($data[0]['allegro_photo']),
        'fvalue-text'=>'', 'fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        $param[16]=array('fid'=>17, 'fvalue-string'=>'', 'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        $param[17]=array('fid'=>18, 'fvalue-string'=>'', 'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        $param[18]=array('fid'=>19, 'fvalue-string'=>'', 'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        $param[19]=array('fid'=>20, 'fvalue-string'=>'', 'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        $param[20]=array('fid'=>21, 'fvalue-string'=>'', 'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        $param[21]=array('fid'=>22, 'fvalue-string'=>'', 'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        $param[22]=array('fid'=>23, 'fvalue-string'=>'', 'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');

        $param[23]=array('fid'=>24,
        'fvalue-string'=>$this->iso8859_to_utf8($data[0]['allegro_product_description']),
        'fvalue-int'=>'','fvalue-float'=>'', 'fvalue-image'=>'', 'fvalue-text'=>'','fvalue-datetime'=>'', 'fvalue-boolean'=>'');
        if($this->debug) {
            print "<pre>";
            print_r($param);
            print "</pre>";
        }    
        return $param;
    } // end func prepareAuction

    /**
     * Wyslij aukcje na allegro
     *
     * @return array $tab
     */
    function sendAuctions($id)
    {
        global $database;
        global $allegro_config;
        global $_SESSION;
        global $lang;
        $user_id=$database->sql_select_array("user_id","allegro_auctions","user_id=".$id);

        $client = new soapclient($allegro_config->allegro_server, true);
        $client->decode_utf8=false;

        foreach($user_id as $key=>$value) {
            $data=$this->prepareAuction($value);
            $parameters = array(
            $_SESSION['allegro']['session-handle-part'],    // sesja z allegro
            $data,                                          // dane w postaci tablicy
            0,
            0
            );
            // wywo³anie metody
            $response = $client->call('doNewAuction',$parameters);
            //echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
            if(!empty($response['faultcode'])) {
                print "<font color=red>";
                print $lang->allegro_error_auction['problem'].$value."<br>";
                print $lang->allegro_error_auction['type_error'].$this->utf8_to_8859($response['faultstring'])."<br><br>";
                print "</font>";
            } else {
                if(!empty($response['item-id'])) {
                    print $lang->set_auction['ok'].$value."<br>";
                    print $lang->set_auction['number'].$response['item-id']."<br>";
                    if($allegro_config->allegro_mode == 'true') {
                        print $lang->set_auction['url']."<a href=\"http://www.allegro.pl/show_item.php?item=".$response['item-id']."\" target=\"window\"><u>http://www.allegro.pl/show_item.php?item=".$response['item-id']."</u></a><br><br>";
                    } else {
                        print $lang->set_auction['url']."<a href=\"http://www.testwebapi.pl/show_item.php?item=".$response['item-id']."\" target=\"window\"><u>http://www.testwebapi.pl/show_item.php?item=".$response['item-id']."</u></a><br><br>";
                    }
                    $database->sql_update("allegro_auctions","user_id=".$value,array(
                    "allegro_number"=>$response['item-id'],
                    ));
                }
            }
        }
        return true;
    } // end func sendAuctions

    /**
     * Zakodowanie pliku fotografii
     *
     * @param string $name nazwa fotografii
     *
     * @return string $encoded zakodowany obrazek
     */
    function & preparePhoto($name)
    {
        global $DOCUMENT_ROOT;
        global $config;

        $path="http://".$config->www."/photo/".$name;
        if(preg_match("/soteesklep3/",$path)) {
        	print "<font color=red>Ustaw prawid³owy adres sklepu w zak³adce \"Dane sprzedawcy. Adres sklepu\"</font><br>";
        }
        $file='';
        if($fd = fopen($path, "rb")) {
            while (!feof($fd)) {
                $file .= fread($fd, 8192);
            }
            $encoded = base64_encode($file);
            fclose($fd);
            return $encoded;
        } else {
            print "<font color=red>Problem z do³±czeniem zdjeciem</font><br>";
            return false;
        }
    } // end func preparePhoto
} // end class Allegro
?>
