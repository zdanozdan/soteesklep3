<?php
/**
 * Obsluga tworzenia pliku dla ceneo.pl
 *
 *
 * @author krzys@sote.pl
 * @version $Id: ceneo_load_offer.inc.php,v 1.10 2006/08/30 09:47:51 lukasz Exp $
* @package    pasaz.ceneo.pl
 */


/**
 * Includowanie potrzebnych klas 
 */
require_once("include/metabase.inc");
require_once("include/ftp.inc.php");



/**
 * Klasa OnetLoadOffer
 *
 * @package onet
 * @subpackage admin
 */
class CeneoLoadOffer{

    var $ceneo_mode='';                  // tryb ladowania produktow do ceneo_pasaz full - pelny update - przyrostowy
    var $ceneo_shop_id='';               // id sklepu przyznawany przez administratora z ceneo_pasaz
    var $www='';                        // adres internetowy sklepu
    var $count=0;
    var $partner_name='ceneo';               // nazwa partnera
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
        $this->ftp_dir=$config->ftp_dir;
        $this->target=$this->ftp_dir."/htdocs/";
        $this->www=$config->www;
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
        $str="<?xml version=\"1.0\" encoding=\"ISO-8859-2\"?>\n<!DOCTYPE pasaz:Envelope SYSTEM \"loadOffers.dtd\">\n<pasaz:Envelope xmlns:pasaz=\"http://schemas.xmlsoap.org/soap/envelope/\">\n<pasaz:Body>\n<loadOffers xmlns=\"urn:ExportB2B\">\n";
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
        $str="</loadOffers>\n</pasaz:Body>\n</pasaz:Envelope>";
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
            $price=$this->ceneo_currency($data);
            $url="http://".$this->www."/go/_info/?id=".$data['id'].$code;
            $str.="<offer>\n";
            $str.="\t<id>".$data['user_id']."</id>\n";
            $str.="\t<name>".$data['name']."</name>\n";
            $str.="\t<price>".$price."</price>\n";
            $str.="\t<url>".$url."</url>\n";
            $str.="\t<categoryId>".$data['category'];
            if (!empty($data['category2'])){
            $str.="/".$data['category2'];
            }
            if (!empty($data['category3'])){
            $str.="/".$data['category3'];
            }
            if (!empty($data['category4'])){
            $str.="/".$data['category4'];
            }
            if (!empty($data['category5'])){
            $str.="/".$data['category5'];
            }
            $str.="</categoryId>\n";
            $xml_description=$this->_cut_html($data['xml_description']);
            $str.="\t<description>".($xml_description)."</description>\n";
          	if(isset($data['photo']) && !empty($data['photo']) && strlen($data['photo'])>0)
            	$str.="\t".$this->ceneo_image($data)."\n";

                $str.="\t<attributes>\n";
                $str.="<attribute>\n";
                $str.="<name>Producent</name>\n";
                $str.="<value>".$data['producer']."</value>\n";
                $str.="</attribute>\n";
                $str.="\t</attributes>\n";
            
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


        $offer1="<offers>\n".$this->prepare_offer()."</offers>\n";
        $file_name="xml_offer_ceneo.xml";
        $offer=$this->ceneo_get_head();
        $offer.=$offer1;
        $offer.=$this->ceneo_get_foot();
        
        if($offer) {
            $file=$DOCUMENT_ROOT."/tmp/ceneo.xml";
            if  ($fd=fopen($file,"w+")) {
                fwrite($fd,$offer,strlen($offer));
                fclose($fd);
            }
        }
        $this->load_ftp($file);

    } // end load_offer

    /**
	* Funkcja ceneo_currency przelicza cene jesli waluta jest inna niz PLN
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
        
        //print "<pre>";
        //print_r($main_param);
        //print "</pre>";
        $product=array();
        $query="SELECT ";
        $query.="ceneo_export,";
        $query.="user_id,photo,name_L0,price_brutto,producer,price_currency,xml_description_L0,vat,id_currency,discount,hidden_price,category1,category2,category3,category4,category5,id";
        $query.=" FROM main WHERE ceneo_export=1";

        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $data=array();                       
                     
                        $data['user_id']=$db->FetchResult($result,$i,"user_id");
                        $data['photo']=$db->FetchResult($result,$i,"photo");
                        $data['name']=$db->FetchResult($result,$i,"name_L0");
                        $data['price_brutto']=$db->FetchResult($result,$i,"price_brutto");
                        $data['producer']=$db->FetchResult($result,$i,"producer");
                        $data['price_currency']=$db->FetchResult($result,$i,"price_currency");
                        $data['xml_description']=$db->FetchResult($result,$i,"xml_description_L0");
                        $data['vat']=$db->FetchResult($result,$i,"vat");
                        $data['id_currency']=$db->FetchResult($result,$i,"id_currency");
                        $data['discount']=$db->FetchResult($result,$i,"discount");
                        $data['hidden_price']=$db->FetchResult($result,$i,"hidden_price");
                        $data['category']=$db->FetchResult($result,$i,"category1");
                        $data['category2']=$db->FetchResult($result,$i,"category2");
                        $data['category3']=$db->FetchResult($result,$i,"category3");
                        $data['category4']=$db->FetchResult($result,$i,"category4");
                        $data['category5']=$db->FetchResult($result,$i,"category5");
                        $data['id']=$db->FetchResult($result,$i,"id");
                        
                        
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
        $path = './../../photo/'.$data['photo'];
    	$size = @getimagesize ($path);
        $str="<image height=\"".@$size[1]."\" width=\"".@$size[0]."\" title=\"".$data['name']."\">".$url."</image>";
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
        $ftp->put("$file","$this->target","ceneo.xml");
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
    
} // end class ceneoLoadOffer
?>
