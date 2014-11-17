<?php
/**
* Obsluga glowna klasa do kominkacji z wp
*
* @author  rdiak@sote.pl
* @version $Id: wp.inc.php,v 1.12 2006/04/03 10:18:33 scalak Exp $
* @package    pasaz.wp.pl
*/

require_once('include/wp/soap.inc.php');
require_once('include/metabase.inc');
require_once ("config/auto_config/wp_config.inc.php");

class WP extends SOAP{

    // @var string
    var $_login='';				// login logowania do pasazu wp
    // @var string
    var $_password='';			// haslo logowania do pasazu wp
    // @var string
    var $_sid='';			    // string identyfikujacy jednoznacznie sklep

    /**
    * warto¶ci tagow sprasowanego xml
    * @var string
    */
    var $_tags='';
    /**
    * warto¶ci sprasowanego xml
    * @var string
    */
    var $_values='';
    /**
    * parametr pobierania danych
    * @var string
    */

    var $_partner_name='';               // nazwa partnera
    var $_soap;
    var $_action='';

    var $_wp_store_trans=array(
    "-1"=>"Serwer SOAP niedostêpny",
    "0"=>"Wszystko ok",
    "1"=>"B³±d autoryzacji",
    "2"=>"Operacja powiod³a siê czê¶ciowo",
    "3"=>"Operacja nie powiod³a siê ca³kowicie",
    );


    /**
    * Konstruktor obiektu WP
    *
    * @access public
    * @return none
    */
    function WP() {
        global $wp_config;
        global $_REQUEST;
        global $database;

        $this->soap=new SOAP;
        $this->_login=$wp_config->wp_login;
        $this->_password=$wp_config->wp_password;
        $this->_sid=$wp_config->wp_shop_id;
        $this->_partner_name=$wp_config->wp_partner_name;
        $this->_action=@$_REQUEST['get_param'];
        // aktualizuj logi tak zeby wiadomo bylo co bylo ostatnie
        $count=$database->sql_select("count(*)","wp_logs");
        if($count > 0) {
            $database->sql_update("wp_logs","",array("show_info"=>0));
        }
        return true;
    } // end WP


    /**
    * Funkcja zwraca naglowek SOAP.
    *
    * @access public
    * @return string naglowek komunikatu SOAP
    */
    function _wp_get_head(){
        $msg="<?xml version='1.0' encoding='ISO-8859-2'?>
					<SOAP-ENV:Envelope xmlns:SOAP-ENV='http://schemas.xmlsoap.org/soap/envelope/'
									   xmlns:xsd='http://www.w3.org/2001/XMLSchema'
									   xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'
									   xmlns:SOAP-ENC='http://schemas.xmlsoap.org/soap/encoding/'
        							   xmlns:ns4='http://codewebservice.namespace'
						SOAP-ENV:encodingStyle='http://schemas.xmlsoap.org/soap/encoding/'>
					<SOAP-ENV:Body>
        	";
        return $msg;
    } // end _wp_get_head

    /**
    * Funkcja zwraca stopke SOAP.
    *
    * @access public
    * @return string stopka komunikat SOAP
    */
    function _wp_get_foot(){
        $msg="</SOAP-ENV:Body>
				</SOAP-ENV:Envelope>	
        	";
        return $msg;
    } // end _wp_get_foot

    /**
    * Funkcja wysyla informacje o zakupach do pasazu onet.
    *
    * @param array $record informacje dotycznace transakcji
    * @param array $id lista id produktów w koszyku
    *
    * @access private
    * @return string komunkat dodania produktów
    */
    function _wp_store_transaction( & $record, & $id) {
        $str="<ns4:StoreTransactions>\n";
        $str.="<Value>\n";
        $str.="<AuthLogin>".$this->_login."</AuthLogin>\n";
        $str.="<AuthPassword>".$this->_password."</AuthPassword>\n";
        $str.="<AuthSid>".$this->_sid."</AuthSid>\n";
        $str.="<Rows>\n";
        $str.="<Row>\n";
        $str.="<Trans_id>".$record['order_id']."</Trans_id>\n";
        $str.="<Trans_value>".$record['price']."</Trans_value>\n";
        $str.="<Trans_date>".@$record['date_add']."</Trans_date>\n";
        $str.="<Src_id>\n";
        foreach($id as $key=>$value) {
            $str.="<id>".$value."</id>\n";
        }
        $str.="</Src_id>\n";
        $str.="<Commit>".$record['commit']."</Commit>\n";
        $str.="</Row>\n";
        $str.="</Rows>\n";
        $str.="</Value>\n";
        $str.="</ns4:StoreTransactions>\n";
        return $str;
    } // _wp_store_transaction

    /**
    * Funkcja wysyla potwierdzenie lub anulowanie transakcji w pasazu wp
    .
    *
    * @param string $message nazwa komunikatu
    * @param array $record informacje dotycznace transakcji
    * @param array $id lista id produktów w koszyku
    *
    * @access private
    * @return string komunkat dodania produktów
    */
    function _wp_commit_roll_trans($message, & $record) {
        $str="<ns4:".$message.">\n";
        $str.="<Value>\n";
        $str.="<AuthLogin>".$this->_login."</AuthLogin>\n";
        $str.="<AuthPassword>".$this->_password."</AuthPassword>\n";
        $str.="<AuthSid>".$this->_sid."</AuthSid>\n";
        $str.="<Rows>\n";
        foreach($record as $key=>$value) {
            $str.="<Row>\n";
            $str.="<Trans_id>".$value['order_id']."</Trans_id>\n";
            $str.="</Row>\n";
        }
        $str.="</Rows>\n";
        $str.="</Value>\n";
        $str.="</ns4:".$message.">\n";
        return $str;
    } // end wp_commit_roll_trans

    /**
    * Funkcja pakuje rekord do dodania  w komunikat SOAP.
    *
    * @param string $record jeden rekord w postaci tablicy asocjacyjnej
    *
    * @access private
    * @return string komunkat dodania produktów
    */
    function _wp_record_add( & $record) {
        $str="<ns4:AddProducts>\n";
        $str.="<Value>\n";
        $str.="<AuthLogin>".$this->_login."</AuthLogin>\n";
        $str.="<AuthPassword>".$this->_password."</AuthPassword>\n";
        $str.="<AuthSid>".$this->_sid."</AuthSid>\n";
        $str.="<Rows>";
        foreach($record as $key=>$value) {
            $str.="<Row>\n";
            $str.="<Name>".$this->soap->chars_to_xml($value['name_L0'])."</Name>\n";
            $value['xml_description_L0']=$this->_cut_html($value['xml_description_L0']);
            $str.="<Desc>".$this->soap->chars_to_xml($value['xml_description_L0'])."</Desc>\n";
            $str.="<Cid>".$value['wp_category']."</Cid>\n";
            $str.="<SrcId>".$value['user_id']."</SrcId>\n";
            $str.="<DictId>".$value['wp_dictid']."</DictId>\n";
            if($value['wp_valid'] != '0000-00-00 00:00') {
                $str.="<Valid>".$value['wp_valid']."</Valid>\n";
            }
            $str.="<Price>".$value['price_brutto']."</Price>\n";
            $str.="<Url>".$value['url']."</Url>\n";
            if($value['wp_advantages'] != 0 ) {
                $str.="<Adv>".$value['wp_advantages']."</Adv>\n";
            }
            if($value['wp_producer'] != 'default' ) {
                $str.="<Prid>".$value['wp_producer']."</Prid>\n";
            }
            if($value['wp_dest'] != 0 ) {
                $str.="<Dest>".$value['wp_dest']."</Dest>\n";
            }
            if(!empty($value['wp_field1'])) {
                $str.="<Field1>".$value['wp_field1']."</Field1>\n";
            }
            if(!empty($value['wp_field2'])) {
                $str.="<Field2>".$value['wp_field2']."</Field2>\n";
            }
            $str.="<PicUrl>".$this->soap->chars_to_xml($value['photo'])."</PicUrl>\n";
            if($value['wp_filters'] != 'opt') {
                $str.="<LocalFilters>".$value['wp_filters']."</LocalFilters>\n";
            }
            if($value['wp_ptg'] == 1) {
                $str.="<PTG>\n";
                $str.="\t\t<Desc>".$value['wp_ptg_desc']."</Desc>\n";
                $str.="\t\t<PicUrl>".$value['wp_ptg_picurl']."</PicUrl>\n";
                $str.="\t\t<Days>".$value['wp_ptg_days']."</Days>\n";
                $str.="</PTG>\n";
            }
            $str.="</Row>\n";
        }
        $str.="</Rows>\n";
        $str.="</Value>\n";
        $str.="</ns4:AddProducts>\n";
        return $str;
    } // end _wp_record_add

    /**
    * Funkcja pakuje rekord do update  w komunikat SOAP.
    *
    * @param string $record jeden rekord w postaci tablicy asocjacyjnej
    *
    * @access private
    * @return string komunkat dodania produktów
    */
    function _wp_record_update( & $record) {
        $str="<ns4:UpdateProducts>";
        $str.="<Value>";
        $str.="<AuthLogin>".$this->_login."</AuthLogin>";
        $str.="<AuthPassword>".$this->_password."</AuthPassword>";
        $str.="<AuthSid>".$this->_sid."</AuthSid>";
        $str.="<Rows>";
        foreach($record as $key=>$value) {
            $str.="<Row>";
            $str.="<SrcId>".$value['user_id']."</SrcId>";
            $str.="<Name>".$this->soap->chars_to_xml($value['name_L0'])."</Name>";
            $str.="<Cid>".$value['wp_category']."</Cid>\n";
            $value['xml_description']=$this->_cut_html($value['xml_description_L0']);
            $str.="<Desc>".$this->soap->chars_to_xml($value['xml_description_L0'])."</Desc>\n";
            $str.="<DictId>".$value['wp_dictid']."</DictId>";
            if($value['wp_valid'] != '0000-00-00 00:00') {
                $str.="<Valid>".$value['wp_valid']."</Valid>";
            }
            $str.="<Price>".$value['price_brutto']."</Price>";
            $str.="<Url>".$value['url']."</Url>";
            if($value['wp_advantages'] != 0 ) {
                $str.="<Adv>".$value['wp_advantages']."</Adv>";
            }
            $str.="<Prid>".$value['wp_producer']."</Prid>";
            if($value['wp_dest'] != 0 ) {
                $str.="<Dest>".$value['wp_dest']."</Dest>";
            }
            if(!empty($value['wp_field1'])) {
                $str.="<Field1>".$value['wp_field1']."</Field1>";
            }
            if(!empty($value['wp_field2'])) {
                $str.="<Field2>".$value['wp_field2']."</Field2>";
            }
            $str.="<PicUrl>".$this->soap->chars_to_xml($value['photo'])."</PicUrl>";
            if($value['wp_filters'] != 'opt') {
                $str.="<LocalFilters>".$value['wp_filters']."</LocalFilters>";
            }
            if($value['wp_ptg'] == 1) {
                $str.="<PTG>";
                $str.="\t\t<Desc>".$value['wp_ptg_desc']."</Desc>";
                $str.="\t\t<PicUrl>".$value['wp_ptg_picurl']."</PicUrl>";
                $str.="\t\t<Days>".$value['wp_ptg_days']."</Days>";
                $str.="</PTG>";
            }
            $str.="</Row>";
        }
        $str.="</Rows>";
        $str.="</Value>";
        $str.="</ns4:UpdateProducts>";
        return $str;
    } // end _wp_record_update

    /**
    * Funkcja tworzy kominkat SOAP usuniecia produktów.
    *
    * @param array $records tablica id produktów do usuniêcia
    *
    * @access private
    * @return string komunkat SOAP usuniêcia produktów
    */
    function _wp_record_delete ( & $record) {
        $str="<ns4:DeleteProducts>\n";
        $str.="<Value>\n";
        $str.="<AuthLogin>".$this->_login."</AuthLogin>\n";
        $str.="<AuthPassword>".$this->_password."</AuthPassword>\n";
        $str.="<AuthSid>".$this->_sid."</AuthSid>\n";
        $str.="<Rows>\n";
        foreach($record as $key=>$value) {
            $str.="<Row>\n";
            $str.="<SrcId>".$value['user_id']."</SrcId>\n";
            $str.="</Row>\n";
        }
        $str.="</Rows>\n";
        $str.="</Value>\n";
        $str.="</ns4:DeleteProducts>\n";
        return $str;
    } // end _wp_record_del()

    /**
    * Funkcja tworzy kompletny komunikat SOAP gotowy do wys³ania do pasa¿u
    *
    * @param string $what jaki komunkat zostaje wys³any
    * @param array  $record dane w postaci tablicy potrzbne do stworzenia komunkatu
    * @param string $id w zale¿no¶ci od komunikatu jest to albo id produktu albo identyfikator
    * 					 u¿ywanego drzewa
    *
    * @access private
    * @return string komunkat dodania produktów
    */
    function  & wp_from_complete_soap($what, $record='', $id='') {
        $msg=$this->_wp_get_head();
        if ($what == 'AddProducts') {
            $msg.=$this->_wp_record_add($record);
        } elseif ($what == 'UpdateProducts') {
            $msg.=$this->_wp_record_update($record);
        } elseif ($what == 'DeleteProducts') {
            $msg.=$this->_wp_record_delete($record);
        } elseif ($what == 'GetTree') {
            $msg.=$this->_wp_get_data($what);
        } elseif ($what == 'GetProducers') {
            $msg.=$this->_wp_get_data($what);
        } elseif ($what == 'GetAdvantages') {
            $msg.=$this->_wp_get_data($what);
        } elseif ($what == 'GetFieldsMeaning') {
            $msg.=$this->_wp_get_data($what);
        } elseif ($what == 'GetLocalFilters') {
            $msg.=$this->_wp_get_data($what);
        } elseif ($what == 'GetAllProducts') {
            $msg.=$this->_wp_get_data($what);
        } elseif ($what == 'GetOneProduct') {
            $msg.=$this->_wp_get_one_prod($id);
        } elseif ($what == 'IsValidTree') {
            $msg.=$this->_wp_get_valid_tree($id);
        }
        $msg.=$this->_wp_get_foot();
        $data= & $msg;
        return $data;
    } // end wp_from_complete_soap

    function _wp_send_request(& $xml,$type='') {
        global $DOCUMENT_ROOT;

        //$soap=new SOAP;
        //wyslij komunikat soap
        //$xml=$soap->send_soap_category($soap_request);
        $xml=$this->soap->xml_to_chars($xml);
        //print "xml".$xml;
        $parser = xml_parser_create();
        if($type == 'trans') {
            $match[0]=$xml;
        } else {
            ereg("\<Rows(.+)\<\/Rows\>", $xml, $match);
        }
        $parser = xml_parser_create();
        if(xml_parse_into_struct($parser,$match[0],$values,$tags)) {
            //print "<br><br>jestem<br><br><br>";
            if(xml_parser_free($parser)) {
                $this->_values= & $values;
                $this->_tags=& $tags;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } // end _wp_send_request

    /**
    * Funkcja konwertujaca string z standardu utf-8 na iso-8859-2
    *
    * @param  string $string  ciag znakow,
    *
    * @return string $string  ciag znakow po konwersji
    */
    function & _wp_utf8_to_8859_2(&$string) {
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
    } // end func encoding_unicode_to_8859-2

    /**
    * Funkcja konwertujaca string z standardu iso-8859-2 na utf-8
    *
    * @param  string $string  ciag znakow,
    *
    * @return string $string  ciag znakow po konwersji
    */
    function & _wp_iso8859_2_to_utf8(&$string) {
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
    * Zapisz do bazy danych informacje zwrotna otrzymana z pasazu wp
    *
    * @return boolean true/false
    */
    function _insert_info_db($info,$id) {
        global $database;

        $result=$this->_values[$this->_tags['RESULT'][0]]['value'];

        if(! $this->_values[$this->_tags['ERRMSG'][0]]['value']) {
            foreach($this->_tags[$id] as $key=>$value) {
                $order_id=$this->_values[$this->_tags[$id][$key]]['value'];
                $database->sql_insert("wp_logs",array(
                "name_action"=>$info,
                "order_id"=>$order_id,
                "show_info"=>1,
                "date_add"=>date("Y-m-d H:i:s"),
                "result"=>$result,
                "result_info"=>$this->_wp_store_trans[$result],
                "errmsg"=>$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['ERRMSG'][$key]]['value']),
                "res"=>$this->_values[$this->_tags['RES'][$key]]['value'],
                "msg"=>$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['MSG'][$key]]['value'])
                )
                );
            }
        } else {
            $database->sql_insert("wp_logs",array(
            "name_action"=>$info,
            "order_id"=>@$order_id,
            "show_info"=>1,
            "date_add"=>date("Y-m-d H:i:s"),
            "result"=>1,
            "result_info"=>@$this->_wp_store_trans[$result],
            "errmsg"=>@$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['ERRMSG'][$key]]['value']),
            "res"=>1,
            "msg"=>@$this->_wp_utf8_to_8859_2($this->_values[$this->_tags['MSG'][$key]]['value'])
            )
            );
        }




        return true;
    } // end _insert_info_db

    /**
    * Wytnij znaczniki html ze stringu
    *
    * @return string ciag znakow bez znacznikow html
    */
    function _cut_html($str) {
        $str=preg_replace("'<[\/\!]*?[^<>]*?>'si","",$str);
        return $str;
    } // end _cut_html
} // end class WP
