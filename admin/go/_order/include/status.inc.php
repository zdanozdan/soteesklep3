<?php
/**
* Klasa obs³ugujaca statusy transakcji.
*
* @author  m@sote.pl
* @version $Id: status.inc.php,v 2.2 2004/12/20 17:58:58 maroslaw Exp $
*
* @todo przenie¶æ do tej klasy wszystkie odpwo³ania do statusów transakcji
* @package    order
*/

/* Obs³uga wysy³ania maili */
require_once ("Mail/MyMail.php");

class OrderStatus {
    
    /**
    * Wy¶lij informacjê o zmianie statusu transakcji do kleinta
    *
    * @param int $order_id   id transakcji
    * @param int $order      tablica z danymi transakcji przekazanymi przez $_REQUEST przy aktualizacji
    *
    * @return bool true - mail zosta³ wys³any, false w p.w.
    */
    function send($order_id,$order) {
        global $mdbd,$config,$lang;
        
        if (empty($order['email'])) return;
        
        // odczytaj szablony tematu i wiadomosci oraz sprawdz czy dla danego statusu wysy³ane sa maile
        $status=$mdbd->select("user_id,name,send_mail,mail_content,mail_title","order_status","user_id=?",
        array($order['status']=>"int"));
        
        if ($status['send_mail']==1) {
            // sprawdz, czy dla tego statusu nie byl juz wyslany mail
            $last_status_sent=$mdbd->select("last_status_sent","order_register","order_id=?",
            array($order_id=>"int"));
            if ($last_status_sent!=$order['status']) {
                $message=$status['mail_content'];
                $subject=$status['mail_title'];
                $to=$order['email'];
                $status_name=$status['name'];
                
                // szablon - podmiana danych
                $message=ereg_replace("{WWW}",$config->www,$message);
                $message=ereg_replace("{ORDER_ID}",$order_id,$message);
                
                $subject=ereg_replace("{WWW}",$config->www,$subject);
                $subject=ereg_replace("{ORDER_ID}",$order_id,$subject);
                
                $mail =& new MyMail();
                if ($mail->send($config->from_email,$to,$subject,$message,$config->from_email)) {
                    $mdbd->update("order_register","last_status_sent=?","order_id=?",
                    array(
                    "1,".$order['status']=>"int",
                    "2,".$order_id=>"int")
                    );
                    return true;
                }
            }
        }
        return false;
    } // end send()
    
} // end classOrderStatus()
?>
