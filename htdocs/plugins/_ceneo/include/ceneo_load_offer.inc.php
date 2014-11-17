<?php
/**
 * Obsluga ladowania oferty do onet_pasaz
 *
 *
 * @author  rdiak@sote.pl
 * @version $Id: ceneo_load_offer.inc.php,v 1.7 2006/04/20 09:09:51 scalak Exp $
* @package    pasaz.onet.pl
 */


/**
 * Includowanie potrzebnych klas 
 */
require_once("include/metabase.inc");
require_once("include/ceneo/soap.inc.php");
require_once("include/ftp.inc.php");
include_once ("config/auto_config/ceneo_config.inc.php");

/**
 * Klasa OnetLoadOffer
 *
 * @package onet
 * @subpackage admin
 */
class CeneoLoadOffer extends SOAP {

    var $ceneo_mode='';                  // tryb ladowania produktow do ceneo_pasaz full - pelny update - przyrostowy
    var $ceneo_shop_id='';               // id sklepu przyznawany przez administratora z ceneo_pasaz
    var $www='';                        // adres internetowy sklepu
    var $count=0;
    var $partner_name='';               // nazwa partnera
    var $target='';
    var $ftp_dir;
    /**
	* Konstruktor obiektu ceneoLoadOffer
	*
	* @access public
	*
	* @author rdiak@sote.pl
	*
	* @return boolean true/false
	*/
    function ceneoLoadOffer() {
        global $ceneo_config;
        global $config;

        $this->ceneo_shop_id=$ceneo_config->ceneo_shop_id;
        $this->ceneo_mode=@$ceneo_config->ceneo_mode;
        $this->partner_name=$ceneo_config->ceneo_partner_name;
        $this->ftp_dir=$config->ftp_dir;
        $this->target=$this->ftp_dir."/htdocs/plugins/_ceneo";
        $this->www=$config->www;
        $this->SOAP();
        return true;
    } // end ceneoLoadOffer()

    /**
	* Funkcja zwaracajaca nalowek pliku xml
	*
	* @access public
	*
	* @author rdiak@sote.pl
	*
	* @return string naglowek pliku xml
	*
	*/
    function ceneo_get_head() {
        $str="<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"  xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"  xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\"><soap:Body>";
        return $str;
    } //end ceneo_get_head()

    /**
	* Funkcja zwraca stopke pliku xml .
	*
	* @access public
	*
	* @author rdiak@sote.pl
	*
	* @return string stopka pliku xml
	*
	*/
    function ceneo_get_foot() {
        $str="</soap:Body></soap:Envelope>";
        return $str;
    } //end ceneo_get_foot()

    /**
	 * Funkcja zwraca url produktu .
	 *
	 * @access public
	 *
	 * @return string url
	 */
    function ceneo_prepare_url() {
        global $mdbd;
        global $config;

        $data=$mdbd->select("partner_id,name","partners","name=?",array($this->partner_name=>"string"));
        $partner_id=$data['partner_id'];
        $code=md5("partner_id.$partner_id.$config->salt");                 // wygenerowanie kodu kontrolnego
        $link="&partner_id=".$partner_id."&code=".$code;    // budowanie linku
        return $link;
    }


    /**
	 * Funkcja formuje komunikat xml z oferta sklepu  .
	 *
	 * @access public
	 *
	 * @author rdiak@sote.pl
	 *
	 * @return string stopka pliku xml
	 *
	 */
    function & prepare_offer() {
        global $database;
        global $lang;
        $str='';
        //$str.=$this->ceneo_get_head();
        // jest to tablica tablic zawierajaca dane z oferty
        $dane=$this->get_database();
        if(empty($dane)) return false;

        // kawalek url odpwiedzialny za prawid³ow± identyfikacjê partnera
        $code=$this->ceneo_prepare_url();
        foreach($dane as $data){
            if($data['onet_category']=='opt') continue;
            $price=$this->ceneo_currency($data);
            $url="http://".$this->www."/?id=".$data['user_id'].$code;
            #$url=$this->chars_to_xml($url);
            if($data['onet_status'] == 1) {
                $str.="<offer>\n";
            } elseif($data['onet_status'] == 0) {
                $str.="<offer toDelete=\"true\">\n";
            }
            $str.="\t<id>".$data['user_id']."</id>\n";
            $str.="\t<name>".$this->chars_to_xml($this->encoding_iso8859_2_to_utf8($data['name']))."</name>\n";
            $str.="\t<price>".$price."</price>\n";
            $str.="\t<url>".$url."</url>\n";
            $str.="\t<categoryId>".substr($data['onet_category'],0,32)."</categoryId>\n";
            $xml_description=$this->_cut_html($data['xml_description']);
            $str.="\t<description>".$this->chars_to_xml($this->encoding_iso8859_2_to_utf8($xml_description))."</description>\n";
            $str.="\t<maxPrice>".$price."</maxPrice>\n";
            $str.="\t<producer>".$this->chars_to_xml($data['producer'])."</producer>\n";
            if(!empty($data['onet_author'])) $str.="\t<author>".$data['onet_author']."</author>\n";
            if(!empty($data['onet_edition'])) $str.="\t<edition>".$data['onet_edition']."</edition>\n";
            if($data['onet_image_export'] == 1) {
                $str.="\t".$this->ceneo_image($data)."\n";
            }
            //			$str.="\t<op>".$data['onet_op']."</op>\n";
            if(!empty($data['ceneo_attrib'])) {
                $str.="\t<attributes>\n";
                foreach($data as $key=>$value) {
                    if(preg_match("/ceneo/",$key) && ($key!='ceneo_export' && $key!='ceneo_attrib')) {
                        if(!empty($data[$key])) {
                            $str.="<attribute>\n";
                            $str.="<name>".$lang->ceneo_attrib[$key]."</name>\n";
                            $str.="<value>".$this->encoding_iso8859_2_to_utf8($data[$key])."</value>\n";
                            $str.="</attribute>\n";
                        }   
                    }
                }
                $str.="\t</attributes>\n";
            }
            $str.="</offer>\n\n";
            $this->count++;
        }
        //$str.=$this->onet_get_foot();
        $offer=&$str;
        return $offer;
    } //end prepare_offer()

    /**
	* Funkcja zapisuje oferte do pliku  .
	*
	* @access public
	*
	* @author rdiak@sote.pl
	*
	* @return string stopka pliku xml
	*
	*/
    function load_offer() {
        global $DOCUMENT_ROOT;
        global $lang;
        global $ceneo_config;
        global $config;


        $offer1="<offers>".$this->prepare_offer()."</offers>";
        
        $file_name="xml_offer_ceneo.xml";
        $offer=$this->ceneo_get_head();
        $offer.='<ExportCennik xmlns="http://';
        $offer.=$ceneo_config->ceneo_server;
        $offer.='/">';
        $offer.='<idSklep>'.$ceneo_config->ceneo_shop_id.'</idSklep>';
        $offer.='<Login>'.$ceneo_config->ceneo_login.'</Login>';
        $offer.='<Password>'.$ceneo_config->ceneo_password.'</Password>';
        $offer.='<xmlofe>';
        $offer.=$this->chars_to_xml($offer1);
        $offer.='</xmlofe>
        </ExportCennik>';


        $offer.=$this->ceneo_get_foot();

        if($offer) {
            $file=$DOCUMENT_ROOT."/tmp/ceneo.xml";
            if  ($fd=fopen($file,"w+")) {
                fwrite($fd,$offer,strlen($offer));
                fclose($fd);
            }
            print $offer;
            exit;
            //if($this->load_ftp("ceneo.xml")) {
            //	print "<center>Plik wygenerowany poprawnie<br> Plik mo¿na sciagnaæ z adresu http://".$config->www."/htdocs/ceneo/ceneo.xml";
            //}
            //$content=$this->send_soap_offer($offer);
            //print $this->encoding_utf8_to_8859_2($this->xml_to_chars($content));
        } else {
            print "<br><center>".$lang->onet_load_offer['noprod']."<center>";
        }
    } // end load_offer

    /**
	* Funkcja onet_currency przelicza cene jesli waluta jest inna niz PLN
	*
	* @access public
	*
	* @author rdiak@sote.pl
	*
	* @param  string $price_brutto nazwa zdjecia,
	*
	* @return string $price przelicznona cena
	*
	*/
    function ceneo_currency($data) {
        global $database;
        $currency=$database->sql_select_data_array("id","currency_val","currency");
        $id_currency=$data['id_currency'];

        if ( $id_currency > 1 ) {
            $price_brutto=($data['price_currency']*$currency[$id_currency])*(1+($data['vat']/100));
            if ($data['discount'] >0 && $data['discount'] <100) {
                $price_brutto=$price_brutto-(($price_brutto*$data['discount'])/100);
            }
        } else {
            $price_brutto=$data['price_brutto']*1;
            if ($data['discount'] >0 && $data['discount'] <100) {
                $price_brutto=$price_brutto-(($price_brutto*$data['discount'])/100);
            }
        }

        if(eregi("(^[0-9]{1,}$)",$price_brutto)) {
            $price_brutto=$price_brutto.".00";
        }elseif(eregi("(^[0-9]{1,}\.[0-9]{1}$)",$price_brutto)) {
            $price_brutto=$price_brutto."0";
        }elseif(eregi("(^[0-9]{1,}\.[0-9]{2}$)",$price_brutto)) {
            $price_brutto=$price_brutto;
        }elseif(eregi("^[0-9]{1,}\.[0-9]{0,17}$",$price_brutto)) {
            preg_match("/^(\d{1,})\.(\d{2})/",$price_brutto,$data_match);
            $price_brutto=$data_match[1].".".$data_match[2];
        }
        return $price_brutto;
    } // end ceneo_currency

    /**
	* Funkcja formuje komunikat xml z oferta sklepu  .
	*
	* @access public
	*
	* @author rdiak@sote.pl
	*
	* @return string stopka pliku xml
	*
	*/
    function & get_database() {
        global $db;

        global $database;
        
        $main_param=$database->sql_select_multi_array7("*","main_param","ceneo_export=1","","","user_id");
        //print "<pre>";
        //print_r($main_param);
        //print "</pre>";
        $product=array();
        $query="SELECT ";
        $query.="onet_category, onet_status, onet_image_export, onet_image_desc,onet_image_title,onet_attrib,";
        $query.="user_id,photo,name_L0,price_brutto,price_currency,xml_description_L0,producer,vat,id_currency,discount,hidden_price ";
        $query.=" FROM main WHERE onet_export=1";

        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $data=array();
                        $data['onet_category']=$db->FetchResult($result,$i,"onet_category");
                        $data['onet_status']=$db->FetchResult($result,$i,"onet_status");
                        $data['onet_image_export']=$db->FetchResult($result,$i,"onet_image_export");
                        $data['onet_image_desc']=$db->FetchResult($result,$i,"onet_image_desc");
                        $data['onet_image_title']=$db->FetchResult($result,$i,"onet_image_title");
                        $data['onet_attrib']=$db->FetchResult($result,$i,"onet_attrib");

                        $data['user_id']=$db->FetchResult($result,$i,"user_id");
                        $data['photo']=$db->FetchResult($result,$i,"photo");
                        $data['name']=$db->FetchResult($result,$i,"name_L0");
                        $data['price_brutto']=$db->FetchResult($result,$i,"price_brutto");
                        $data['price_currency']=$db->FetchResult($result,$i,"price_currency");
                        $data['xml_description']=$db->FetchResult($result,$i,"xml_description_L0");
                        $data['producer']=$db->FetchResult($result,$i,"producer");
                        $data['vat']=$db->FetchResult($result,$i,"vat");
                        $data['id_currency']=$db->FetchResult($result,$i,"id_currency");
                        $data['discount']=$db->FetchResult($result,$i,"discount");
                        $data['hidden_price']=$db->FetchResult($result,$i,"hidden_price");
                        
                        foreach($main_param[$data['user_id']] as $key=>$value) {
                            if(preg_match("/ceneo/",$key)) {
                                $data[$key]=$main_param[$data['user_id']][$key];
                            }
                        }
                        array_push ($product, $data);
                    } // end for
                }
            } else die ($db->Error());
        } else die ($db->Error());
        $data=&$product;
        return $data;
    } // end get_database

    /**
	* Funkcja onet_check_image zwraca gotowy tag xml z parametrami zdj-Bêcia -A
	*
	* @access public
	*
	* @author rdiak@sote.pl
	*
	* @param  string $photo  nazwa zdjecia,
	* @param  string $url    adres url do zdjecia
	*
	* @return string tag xml zawierajacy parametry zdjecia
	*
	*/
    function ceneo_image($data) {
        $url="http://".$this->www."/photo/".$data['photo'];
        $size = @getimagesize ($url);
        $str="<image height=\"".@$size[1]."\" width=\"".@$size[0]."\" title=\"".$data['onet_image_title']. "\" 		description=\"".$data['onet_image_desc']."\">".$url."</image>";
        return $str;
    } // end ceneo_image

    /**
	 * Funkcja ftpuje plik do okrelsonej lokalizacji.
	 *
	 * @param  string $file nazwa pliku
	 *
	 * @return boolean true/false
	 */
    function load_ftp($file) {
        global $ftp;
        global $DOCUMENT_ROOT;
        $ftp->connect();
        $ftp->put("$DOCUMENT_ROOT/tmp/$file","$this->target","$file");
        $ftp->close();
        return true;
    } // end load_ftp()

    /**
	 * Wytnij znaczniki html ze stringu
 	 *
     * @return string ciag znakow bez znacznikow html
     */
    function _cut_html($str) {
        $str=preg_replace("'<[\/\!]*?[^<>]*?>'si","",$str);
        return $str;
    } // end _cut_html
    
    function chars_to_xml($xml) {
        $xml = eregi_replace('<', '&lt;', $xml);
        $xml = eregi_replace('>', '&gt;', $xml);
        $xml = eregi_replace('&', '&amp;', $xml);
        $xml = eregi_replace('"', '&quot;', $xml);
        $xml = eregi_replace('\'', '&apos;', $xml);
        return $xml;
    } // end chars_to_xml()
} // end class ceneoLoadOffer
?>
