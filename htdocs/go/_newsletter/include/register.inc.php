<?php
/**
 * Obsluga newslettera, potwierdzenie rejestracji lub wyrejestrowania
 * 
 * @author  rdiak@sote.pl
 *
 * @version $Id: register.inc.php,v 1.2 2004/12/20 18:01:42 maroslaw Exp $
 *
* @package    newsletter
 */

require_once ("lib/Mail/MyMail.php");
require_once ("include/metabase.inc");

class NewsLetterRegister {

    var $salt='';            // salt z pliku config
    var $from='';            // pole maila from
    var $reply='';           // pole maila reply
    var $email='';           // adres zapisujacego/wypisujacego sie z Newsletter
    var $action='';          // czy zapisuje sie czy wypisuje
    var $confirm='';         // czy wysylamy potwierdzenie do uzytkownika ( dokladny opis w config.inc.php)
    var $email_md5='';       // md5 od adresu email

    /**
     * Konstruktor obiektu NewsLetter 
     *
     * @access public
     *
     * @return string the current date in specified format
     */

    function NewsletterRegister($email,$action) {

        global $config;

        $this->email=$email;
        $this->salt=$config->salt;
        $this->from=$config->from_email;
        $this->reply=$config->newsletter_email;
        $this->confirm=$config->newsletter_confirm;
        $this->make_md5();
        return true;
    }



} //end class NewsletterRegister
?>
