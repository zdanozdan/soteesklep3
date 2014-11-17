<?php
/**
 * Obsluga wysylania poczty.
 *
 * @author  m@sote.pl
 * @version $Id: MyMail.php,v 2.6 2004/09/02 11:40:28 lechu Exp $
 * @package soteesklep
 */ 

// PEAR Mail
require_once ("Mail.php");

class MyMail {
    
    /**
     * Wysli wiadomosc e-mail
     *
     * @param string $to      adresat
     * @param string $from    nadawca
     * @param string $subject temat
     * @param string $body    tresc maila
     * @param string $reply   odpowiedz na adres
     * @param string $type    typ wiadomosci np. [html]
     * @access public
     * @return bool true  mail wyslany, false - problem z wyslaniem maila
     */
    function send($from,$to,$subject,$body,$reply="",$type="") {
        
        if ($type=="html") {
            $type="text/html";
        } else $type="text/plain";        

        
        if (empty($reply)) $reply=$from;
        
        $mail =& new Mail;
        
        if (
        $mail->send(array($to),array("From"=>$from,
                                    "Subject"=>$subject,
                                    "Reply-to"=>$reply,
                                    "Content-type"=>$type
                                   ),
                               $body
                  )
           ) return true;
        else return false;        
    } // end send()
} // end class MyMail

?>
