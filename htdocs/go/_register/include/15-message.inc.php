<?php
/**
* Generowanie tresci zamowienia.
*
* @author m@sote.pl
* @version $Id: message.inc.php,v 2.13 2005/11/30 08:54:17 lukasz Exp $
* @package    register
*/

class Message {
    
    function order2txt($order_id) {
        global $form,$form_cor;
        global $lang;
        global $config;
        global $_SESSION;
        
        if ((empty($form)) && (! empty($_SESSION['form']))) {
            $form=$_SESSION['form'];
        }
        if ((empty($form_cor)) && (! empty($_SESSION['form_cor']))) {
            $form_cor=$_SESSION['form_cor'];
        }
        
        $this->order_id=$order_id;
        
        $o="";
        
        $o.=$lang->form_title_addr.":\n";
        // dane bilingowe
        $b="";
        if (! empty($form['firm']))
        $b.=$lang->form_name['firm'].": ".$form['firm']."\n";
        $b.=$lang->form_name['name'].": ".$form['name']."\n";
        $b.=$lang->form_name['surname'].": ".$form['surname']."\n";
        $b.=$lang->form_name['street'].": ".$form['street']." ";
        $b.=$form['street_n1'];
        if (! empty($form['street_n2'])) {
            $b.=" / ".$form['street_n2']."\n";
        } else {
            $b.="\n";
        }
        $b.=$lang->form_name['postcode'].": ".$form['postcode']."\n";
        $b.=$lang->form_name['city'].": ".$form['city']."\n";
        $b.=$lang->form_name['country'].": ".$lang->country[$form['country']]."\n";
        $b.=$lang->form_name['phone'].": ".$form['phone']."\n";
        if (! empty($form['nip']))
        $b.=$lang->form_name['nip'].": ".$form['nip']."\n";
        $b.=$lang->form_name['email'].": ".$form['email']."\n";
        
        // adres billingowy txt
        $this->addr=$b;
        
        $o.=$b;
        
        // czy podano odzielny adres korespondencyjny?
        if ((@$form['cor_addr']=="no") && (! empty($form_cor['name']))) {
            $o.="\n".$lang->form_title_addr_cor.":\n";
            $c="";
            if (! empty($form_cor['firm']))
            $c.=$lang->form_name['firm'].": ".$form_cor['firm']."\n";
            $c.=$lang->form_name['name'].": ".$form_cor['name']."\n";
            $c.=$lang->form_name['surname'].": ".$form_cor['surname']."\n";
            $c.=$lang->form_name['street'].": ".$form_cor['street']." ";
            $c.=$form_cor['street_n1'];
            if (! empty($form_cor['street_n2'])) {
                $c.=" / ".$form_cor['street_n2']."\n";
            } else {
                $c.="\n";
            }
            $c.=$lang->form_name['postcode'].": ".$form_cor['postcode']."\n";
            $c.=$lang->form_name['city'].": ".$form_cor['city']."\n";
            $c.=$lang->form_name['country'].": ".$lang->country[$form_cor['country']]."\n";
            if (! empty($form_cor['phone']))
            $c.=$lang->form_name['phone'].": ".$form_cor['phone']."\n";
            if (! empty($form_cor['email']))
            $c.=$lang->form_name['email'].": ".$form_cor['email']."\n";
            
            // adres korespondencyjny txt
            $this->addr_cor=$c;
            
            $o.=$c;
            
        } else {
            $o.="\n".$lang->form_title_one_addr."\n\n";
        }
        
        $o.=$lang->form_name['description'].": ".@$form['description']."\n";
        
        // dodatkowe informacje o zmowieniu wprowadzane w dodatkwoym oknie z koszyka
        if (! empty($_SESSION['global_order_ext_description'])) {
            $o.="\n ".$_SESSION['global_order_ext_description']."\n";
        }
        
        if ($config->basket_photo==true) {
            $o.="\n";
            $o.=$this->basket_photo();
        }
        
        return $o;
    } // end order2txt()
    
    
    /**
    * Dodaj linki do zalaczonych do zamowienia zdjec
    *
    * @param int $order_id
    * @return string (txt) linki do zdjec produktow
    */
    function basket_photo() {
        global $db,$sess;
        global $lang;
        global $_SERVER;
        global $_SESSION;
        global $config;
        
        // nazwa hosta
        $host=$_SERVER['HTTP_HOST'];
        
        if (empty($this->order_id)) die ("Error: Zamówienie nie zosta³o wys³ane/Error: Order wasn't sent.");
        $order_id=$this->order_id;
        
        $o=$lang->message_basket_photo_title;
        $query="SELECT user_id,name FROM basket_photo WHERE session_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$sess->id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                for ($i=0;$i<$num_rows;$i++) {
                    $user_id=$db->FetchResult($result,$i,"user_id");
                    $name=$db->FetchResult($result,$i,"name");
                    $o.=$user_id." http://$host".$config->url_prefix."/go/_basket/_photo/tmp_photos/$name\n";
                } // end for
            } else die ($db->Error());
        } else die ($db->Error());
        
        return $o;
    } // end basket_photo
    
    
    /**
    * Zloz tresc calego zamowienia
    *
    * @param string $basket_add zawartosc koszyka w formacie txt
    * @param string $body dane zamaiwajacego, adres korepsondencyjny
    * @param int    $order_id numer zamowienia
    * @return string tresc zamowienia
    */
    function order_body(&$basket_txt,&$body,$order_id,&$pay_name) {
        global $lang,$config;
        global $_SESSION;
        global $global_id_pay_method;
        
        $this->order_id=$order_id;
        
        $o="";
        $o.="ORDER-ID: $order_id\n";
        $o.=$lang->pay_method_title.": ".
        $lang->pay_method[$global_id_pay_method]."\n\n";
        $o.=$basket_txt;
        $o.="\n";
        $o.=$body;
        
        return $o;
    } // end order_body()
    
} // end class Message
?>
