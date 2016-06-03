<?php
/**
 * Obsluga wysylania poczty.
 *
 * @author  m@sote.pl
 * @version $Id: MyMail.php,v 2.8 2006/08/16 14:31:12 lukasz Exp $
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
        global $lang;
        if ($type=="html") {
            $type="text/html";
        } else $type="text/plain";

        if (isset($lang->encoding))
        {
        	if (strpos($type, 'charset') === false)
        	$type .= '; charset='.$lang->encoding;
        	$subject = "=?".$lang->encoding."?B?".base64_encode($subject) ."?=";
        }
        else 
        {
        	$type .= '; charset=iso-8859-2';
        	$subject = "=?iso-8859-2?B?".base64_encode($subject) ."?=";
        }
        
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
