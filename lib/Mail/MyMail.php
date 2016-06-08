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
require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

class MyMail {

  function send_slack($message)
  {
    $message = iconv("ISO-8859-2","UTF-8",$message);

    $post = "payload=" . json_encode(array(
					   "channel"       => "#orders",
					   //"text"          => 'This is posted and comes from *mikran-bot*.',
					   "text"          => $message,
					   "username"      => "mikran bot na sklep@mikran.pl",
					   "icon_emoji"    => ":monkey_face:"
					   ));

    $ch = curl_init('https://hooks.slack.com/services/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');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // execute!
    $response = curl_exec($ch);

    // close the connection, release resources used
    curl_close($ch);
  }
    
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
     * @return bool tru
e  mail wyslany, false - problem z wyslaniem maila
     */

    function send($from,$to,$subject,$body,$reply="",$type="") {
      $mail = new PHPMailer;

      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'mikran.pl';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'sklep@mikran.pl';                 // SMTP username
      $mail->Password = 'MIkran123';                           // SMTP password

      $mail->setFrom($from, $from);
      $mail->addAddress($to, $to);     // Add a recipient

      if($type=='text/html')
	$mail->isHTML(true);                                 // Set email format to HTML

      $mail->Subject = $subject;
      $mail->Body    = $body;
      //$mail->AltBody = strip_tags($body);

      $mail->CharSet = 'iso-8859-2';

      if(!$mail->send()) 
	{
	  //echo 'Message could not be sent.';
	  //echo 'Mailer Error: ' . $mail->ErrorInfo;
	  return false;
	} 

      return true;
    }

    function send_old($from,$to,$subject,$body,$reply="",$type="") {
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
