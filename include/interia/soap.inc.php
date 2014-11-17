<?php
/**
* Obsluga SOAP
*
*
* @author  rdiak@sote.pl
* @version $Id: soap.inc.php,v 1.3 2005/09/02 08:24:37 lukasz Exp $
* @package    pasaz.interia.pl
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
    * Konstruktor obiektu interiaGetCat
    *
    * @return boolean true/false
    */
    function SOAP() {
        global $interia_config;
        global $config;

        if($interia_config->interia_load == 'product') {
            $this->address=$interia_config->interia_server;
        } else {
            $this->address=$interia_config->interia_test_server;
        }
        $this->port=$interia_config->interia_port;
        $this->rpc=$interia_config->interia_rpc;
        $this->message=$interia_config->interia_message;
        //$this->login=$interia_config->interia_login;
        $this->password=$interia_config->interia_password;
        $this->transaction=$interia_config->interia_transaction;
        $this->ftp_dir=$config->ftp_dir;
        $this->target=$this->ftp_dir."/admin/plugins/_pasaz.interia.pl/file";
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
    * Glowna funkcja  pobierania  kategorii z interia_pasaz.
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
        //$this->address=$this->address."/".$this->rpc;
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
                        $error3=$http->ReadReplyBody($body,1000);
                        if($error3!="" || strlen($body)==0){
                            //print "<Br><br>Error".$error3."<br><br>";
                            break;
                        } else {
                            $category.=HtmlSpecialChars($body);
                            $body='';
                        }
                        $i++;
                    }
                } else {
                    print $lang->interia_soap['no_header']."<br>";
                    print $error2;
                } //end error2
            } else {
                print $lang->interia_soap['bad_reply']."<br>";
                print $error1;
            } // end error1
        } else {
            print $lang->interia_soap['not_connect']."<br>";
            print $error;
        } //end error
        $cat=&$category;
        return $cat;
    } // end send_soap_offer()

    /**
    * Funkcja inlementuje komunikacje i ladowanie oferty do interia_pasaz.
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
                    print $lang->interia_soap['no_header']."<br>";
                    print $error2;
                } //end error2
            } else {
                print $lang->interia_soap['bad_reply']."<br>";
                print $error1;
            } // end error1
        } else {
            print $lang->interia_soap['not_connect']."<br>";
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
		print "to";
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
            $error1=$http->SendRequest(array(
            "RequestMethod"=>"GET",
            "RequestURI"=>$this->transaction,
            "GetValues"=>$mesg,
            "EndPointURL"=>"$str",
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
                    print $lang->interia_soap['no_header']."<br>";
                    print $error2;
                } //end error2
            } else {
                print $lang->interia_soap['bad_reply']."<br>";
                print $error1;
            } // end error1
        } else {
            print $lang->interia_soap['not_connect']."<br>";
            print $error;
        } //end error
        $cat=&$category;
        return $cat;
    } // end send_transaction()
} // end class SOAP
?>
