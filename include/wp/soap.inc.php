<?php
/**
* Obsluga SOAP
*
*
* @author  rdiak@sote.pl
* @version $Id: soap.inc.php,v 1.4 2005/09/02 08:24:38 lukasz Exp $
* @package    pasaz.wp.pl
*/

require_once("HTTP/http.php");

class SOAP {

    var $address='';
    var $port='';
    var $rpc='';
    var $message='';
    var $transaction='';
    var $login='';
    var $password='';
    var $target='';
    var $ftp_dir='';


    /**
    * Konstruktor obiektu wpGetCat
    *
    * @return boolean true/false
    */
    function SOAP() {
        global $wp_config;
        global $config;

        if($wp_config->wp_load == 'product') {
            $this->address=$wp_config->wp_server;
        } else {
            $this->address=$wp_config->wp_test_server;
        }
        $this->port=$wp_config->wp_port;
        $this->rpc=$wp_config->wp_rpc;
        $this->message=$wp_config->wp_message;
        $this->login=$wp_config->wp_login;
        $this->password=$wp_config->wp_password;
        $this->transaction=$wp_config->wp_message;
        $this->ftp_dir=$config->ftp_dir;
        $this->target=$this->ftp_dir."/admin/plugins/_pasaz.wp.pl/file";
        return true;
    } // end SOAP()

    /**
    * Funkcja konwersji metaznakow z xml
    *
    * @param  string $xml      string xml
    *
    * @return string           skonwetowany xml
    */
    function & xml_to_chars(&$xml) {
        $xml = eregi_replace('&lt;', '<', $xml);
        $xml = eregi_replace('&gt;', '>', $xml);
        $xml = eregi_replace('&amp;', '&', $xml);
        $xml = eregi_replace('&quot;', '"', $xml);
        $xml = eregi_replace('&apos;', '\'', $xml);
        return $xml;
    } // end xml_to_chars()

    /**
    * Funkcja konwersji metaznakow do xml
    *
    * @param  string $str      string xml
    *
    * @return string          skonwetowany xml
    */
    function & chars_to_xml(&$xml) {
        $xml = eregi_replace('<', '&lt;', $xml);
        $xml = eregi_replace('>', '&gt;', $xml);
        $xml = eregi_replace('&', '&amp;', $xml);
        $xml = eregi_replace('"', '&quot;', $xml);
        $xml = eregi_replace('\'', '&apos;', $xml);
        return $xml;
    } // end chars_to_xml()

    /**
    * Glowna funkcja  pobierania  kategorii z wp_pasaz.
    *
    * @param  string $mesg      depesza SOAP ktora ma zostac wyslana do serwera
    *
    * @return boolean true/false
    */
    function & send_soap_category($mesg) {
        global $lang;
        $category='';

        // inicjalizacja klasy ktora zostanie wykorzystana do komunikacji
        $http = new http_class;
        //print "<br>Adres".$this->address;
        // otwieramy polaczenie z serwerem SOAP
        $error=$http->Open(array(
        "HostName"=>$this->address,
        "HostPort"=>$this->port,
        )
        );
        // jesli polaczenie zostalo otwarte pomyslnie
        if($error == "" ) {
            $str=$this->address.$this->rpc;
            //print $str;
            $error1=$http->SendRequest(array(
            "RequestMethod"=>"POST",
            "RequestURI"=>$this->rpc,
            "Headers"=>array(
            "Host"=>$this->address,
            "User-Agent"=>"Manuel Lemos HTTP class SOAP test script",
            "Pragma"=>"no-cache",
            "SoapAction"=>"",
            "EndPointURL"=>"$str",
            "Content-Type"=>"text/xml; charset=ISO-8859-2"
            ),
            "Body"=>$mesg
            )
            );

            if($error1 == ""){
                $headers=array();
                $error2=$http->ReadReplyHeaders($headers);
                if($error2 == "") {
                    $i=0;
                    for(;;)
                    {
                        $error3=$http->ReadReplyBody($body,50);
                        if($error3!="" || strlen($body)==0){
                            //print "<Br><br>Error".$error3."<br><br>";
                            break;
                        } else {
                            $category.=HtmlSpecialChars($body);
                        }
                        $i++;
                    }
                } else {
                    print $lang->wp_soap['no_header']."<br>";
                    print $error2;
                } //end error2
            } else {
                print $lang->wp_soap['bad_reply']."<br>";
                print $error1;
            } // end error1
        } else {
            print $lang->wp_soap['not_connect']."<br>";
            print $error;
        } //end error
        $cat=&$category;
        return $cat;
    } // end send_soap_offer()

    /**
    * Funkcja inlementuje komunikacje i ladowanie oferty do wp_pasaz.
    *
    * @param  string $mesg      depesza SOAP ktora ma zostac wyslana do serwera
    *
    * @return boolean true/false
    */
    function & send_soap_offer(&$mesg) {
        global $lang;
        $category='';

        // inicjalizacja klasy ktora zostanie wykorzystana do komunikacji
        $http = new http_class;

        //$address=$this->login.":".$this->password."@".$this->address;
        $address=$this->address;

        //print "<br>adress".$address."<br>";
        // otwieramy polaczenie z serwerem SOAP
        $error=$http->Open(array(
        "HostName"=>$this->address,
        "HostPort"=>$this->port,
        )
        );
        // jesli polaczenie zostalo otwarte pomyslnie
        if($error == "" ) {
            $str="http://".$address.$this->message;
            //print "<br>str".$str."<br>";
            $auth='Basic ' . base64_encode($this->login . ':' . $this->password);
            $error1=$http->SendRequest(array(
            "RequestMethod"=>"POST",
            "RequestURI"=>$this->message,
            "Headers"=>array(
            "Host"=>$address,
            "User-Agent"=>"Manuel Lemos HTTP class SOAP test script",
            "Pragma"=>"no-cache",
            "SoapAction"=>"",
            "EndPointURL"=>"$str",
            "Content-Type"=>"text/xml; charset=ISO-8859-2",
            "Authorization" => $auth
            ),
            "Body"=>$mesg
            )
            );

            if($error1 == ""){
                $headers=array();
                $error2=$http->ReadReplyHeaders($headers);
                if($error2 == "") {
                    $i=0;
                    for(;;)
                    {
                        $error3=$http->ReadReplyBody($body,1000);
                        if($error3!="" || strlen($body)==0){
                            break;
                        } else {
                            $category.=HtmlSpecialChars($body);
                        }
                        $i++;
                    }
                } else {
                    print $lang->wp_soap['no_header']."<br>";
                    print $error2;
                } //end error2
            } else {
                print $lang->wp_soap['bad_reply']."<br>";
                print $error1;
            } // end error1
        } else {
            print $lang->wp_soap['not_connect']."<br>";
            print $error;
        } //end error
        $cat=&$category;
        return $cat;
    } // end send_soap_offer()

    /**
    * Funkcja implementuje komunikacje i obsluge transakcji.
    *
    * @param  string $mesg      depesza SOAP ktora ma zostac wyslana do serwera
    *
    * @return boolean true/false
    */
    function & send_transaction(&$mesg) {
        global $lang;

        $category='';

        // inicjalizacja klasy ktora zostanie wykorzystana do komunikacji
        $http = new http_class;

        // otwieramy polaczenie z serwerem SOAP
        $error=$http->Open(array(
        "HostName"=>$this->address,
        "HostPort"=>$this->port,
        )
        );
        // jesli polaczenie zostalo otwarte pomyslnie
        if($error == "" ) {
            $str="http://".$this->address.$this->transaction;
            print "adress".$str;
            $error1=$http->SendRequest(array(
            "RequestMethod"=>"POST",
            "RequestURI"=>$this->transaction,
            "PostValues"=>$mesg,
            )
            );

            if($error1 == ""){
                $headers=array();
                $error2=$http->ReadReplyHeaders($headers);
                if($error2 == "") {
                    $i=0;
                    for(;;)
                    {
                        $error3=$http->ReadReplyBody($body,1000);
                        if($error3!="" || strlen($body)==0){
                            break;
                        } else {
                            $category.=HtmlSpecialChars($body);
                        }
                        $i++;
                    }
                } else {
                    print $lang->wp_soap['no_header']."<br>";
                    print $error2;
                } //end error2
            } else {
                print $lang->wp_soap['bad_reply']."<br>";
                print $error1;
            } // end error1
        } else {
            print $lang->wp_soap['not_connect']."<br>";
            print $error;
        } //end error
        $cat=&$category;
        return $cat;
    } // end send_transaction()
} // end class SOAP
?>
