<?php
/**
* Generowanie maila i wys³anie zamówienia do sprzedawcy i kleinta.
*
* @author  m@sote.pl
* @version $Id: send.inc,v 1.20 2006/04/14 13:50:52 lukasz Exp $
* @package    include
*/

/**
* Klasa obs³uguj±ca wys³anie zamówienia.
* @package order
* @subpackage htdocs
*/
class OrderSend {
    
    /**
    * Wy¶lij zamówienie do sprzedawcy i potwierdzenie do klienta.
    *
    * @return bool true - zamówienie zosta³o poprawnie wys³ane, false w p.w.
    */
    function send() {
        global $_SESSION,$sess;
        global $DOCUMENT_ROOT;
        global $lang,$config;
        global $__check,$theme;
//        global $my_basket, $basket;
        
        require_once ("include/order/order.inc");
        $ord_reg =& new OrderRegister;
        
        if (my(@$_SESSION['global_lock_register'])!=true) {
            // wyswietl strone z linkiem do glownej strony
            $theme->go2main();
            exit;
        }
        
        if (! empty($_SESSION['global_basket_data'])) {
            require_once ("go/_basket/include/my_ext_basket.inc.php");
            $basket=& new My_Ext_Basket;
            $basket->init();
            $my_basket=&$basket;
            $my_basket->display="text";
        } else {
            $theme->go2main();
            exit;
        }
                
        
        // includujemy plik obliczajacy punkty uzytkownika
        require_once("$DOCUMENT_ROOT/go/_register/include/points.inc.php");
        $points =& new UserPoints;
        
        // generowanie tresci zamowienia do maila
        require_once("go/_register/include/message.inc.php");
        $message =& new Message; // odczytaj dane z sesji z wczesniej wypelnionych formularzy
        
        if (! empty($_SESSION['form'])) {
            $form=$_SESSION['form'];
        }
        if (! empty($_SESSION['form_cor'])) {
            $form_cor=$_SESSION['form_cor'];
        }
        
        $body=$message->order2txt($ord_reg->getOrderID());
        
        $basket_txt=$my_basket->basket_txt(); 
        // dodaj obsluge wysylania wiadomosci e-mail
        require_once ("lib/Mail/MyMail.php");
        $mail =& new MyMail;
                
        // wyslij maila z zamowieniem
        $from=$config->from_email;
        $to=$config->order_email;
        $merchant_email=$to;
        $subject=$lang->order_subject;
        
        if (! empty($form['email'])) {
            $reply=$form['email']; $user_email=$reply;
        } else $reply="";
        
        $confirm=false;
              
        // wyslij maila z zamowieniem o ile mail nie zostal juz wyslany
        if (my(@$_SESSION['global_lock_send'])!=true) {                    
            
            // odczytaj rodzaj platnosci
            if (! empty($_SESSION['global_pay_name'])) {
                $pay_name=$_SESSION['global_pay_name'];
            }
            if ((empty($pay_name)) && (! empty($global_pay_name))) {
                $pay_name=$global_pay_name;
            }
            
            // odczytaj numer transakcji
            $order_id=$ord_reg->getOrderID();
            $order_id_date=$ord_reg->getOrderIDDate();
            
            // odczytaj identyfikator uzytkownika
            // jesli jest to obluicz dla niego liczbe punktow
            $user_id=0;
            if (! empty($_SESSION['global_id_user'])) {
                $global_id_user=$_SESSION['global_id_user'];
                $MyPoints=$points->show_user_points($global_id_user);
                $user_id=1;
            }
            
            // pelna tresc zamowienia
            $order_body=$message->order_body($basket_txt,$body,$order_id,$pay_name);
            
            // sprawdz czy uzytkownik nie wybral wczesniej platnosci karta
            if ($__check==1) {
                $order_body.=$lang->send_add_info;
            }
            
            // generuj tytu³
            $subject="ORDER-ID: $order_id, $pay_name, $subject";
                        
            // wyslij maila z zamowieniem do sprzedawcy
            if ($mail->send($from,$to,$subject,$order_body,$reply)) {                
                // wyslij maila z potwierdzeniem zamowienia do klienta
                $confirm_subject=$lang->order_confirm_subject." ".$_SERVER['HTTP_HOST'];
                $host=$_SERVER['HTTP_HOST'];
                $from=$merchant_email;
                $to=$user_email;
                $order_body='';

                $user_text_file = $DOCUMENT_ROOT . "/themes/_" . $config->langs_symbols[$config->lang_id] . "/_html_files/order_mail_hello.html";
                $pfile = fopen($user_text_file, "r");
                $user_text = fread($pfile, filesize($user_text_file));
                fclose($pfile);
                $user_text = strip_tags($user_text);
                $order_body .= $user_text;
                
                // definicja linku, ktory bedzie potwierdzeniem zamowienia
                $order_body.="\n";
                $order_body.=$lang->send_link;  // w celu potwierdzenia zamówienia kliknij ponizszy link
                $order_body.="\n";
                // stworzenie specjalnego kodu, by klient mogl zatwierdzic tylko swoja transakcje
                $sign=md5($order_id.$config->salt);
                $order_body.="http://$host".$config->url_prefix."/go/_register/confirm.php?trans=$order_id&code=$sign";
                
                // dodanie linku za pomoca , ktorego klient bedzie mogl zobaczc informacje o swojej transakcji
                $order_body.="\n\n";
                $order_body.=$lang->trans_link; // by sprawdzic stan swojej transakcji kliknij ponizszy link
                $order_body.="\n";
                $order_body.="http://$host".$config->url_prefix."/go/_users/order_info.php?id=$order_id&code=$sign";
                $order_body.="\n\n";
                
                $order_body.=$message->order_body($basket_txt,$body,$order_id,$pay_name);
                // nazwa hosta
                

                $user_text_file = $DOCUMENT_ROOT . "/themes/_" . $config->langs_symbols[$config->lang_id] . "/_html_files/order_mail.html";
                $pfile = fopen($user_text_file, "r");
                $user_text = fread($pfile, filesize($user_text_file));
                fclose($pfile);
                $user_text = strip_tags($user_text);
                $user_text = str_replace("{bank}", $config->merchant['bank'], $user_text);
                $order_body .= $user_text;
                
                // jezeli uzytkownik byl zalogowany podczas skladania zamowienia to dodaj do maila aktualna liczbe punktow
                if (($user_id==1) && (my($MyPoints>0))) {
                    $order_body.="\n\n";
                    $order_body.="$lang->users_your_points:".$MyPoints;   //aktualna liczba punktow klienta do langow
                }
                
                $reply=$config->from_email;
                $mail->send($from,$to,$confirm_subject,$order_body,$reply);
                $confirm=true;
                
                // jesli jest wlaczona opcja sprzedazy on-line, to zapamietaj stan koszyka przed jeggo skasowaniem
                if (in_array("main_keys",$config->plugins)) {
                    $prev_session['my_basket']=$my_basket;
                    $prev_session['global_order_id']=$order_id;
                    $prev_session['global_basket_amount']=$_SESSION['global_basket_amount'];
                    $sess->register("prev_session",$prev_session);
                }
                // end
                
                // skasuj zawartosc koszyka
                $basket->emptyBasket();
                global $global_basket_amount,$global_basket_count,$global_order_amount;
                $global_order_amount=0;
                $global_basket_count=0;
                $global_order_amount=0;
                global $mdbd;
                $sess->unregister('global_lock_register');
                $saved_session=serialize($_SESSION);
                $mdbd->update('order_session','data=?','order_id=?',array("$saved_session"=>"text","$order_id"=>"int"));
                $sess->unregister("global_basket_amount");
                $sess->unregister("global_order_amount");
                $sess->unregister("global_basket_count");
                $sess->unregister("global_order_id");
                $sess->unregister("global_order_id_date");
                $sess->unregister("global_basket_data");
            } 
        } else {
            $confirm=true;
        }
        
        return $confirm;
    } // end send()
    
} // end class OrderSend

?>
