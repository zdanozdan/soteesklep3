<?php
/**
* Obsluga newslettera, dodaj usun email uzytkwonika do bazy
*
* Algorytm dzia³ania :
* 1. gosc sie zapisuje na newsletter przez storne $active=0 $status=0
* 3. gosc potwierdza rejestracje                  $active=1 $status=1
* 4. gosc postanawia sie wypisac przez strone     $active=0 $status=1
* 5. gosc potwierdza przez link ze sie wypisal    $active=0 $status=0
*
* @author  rdiak@sote.pl
* @version $Id: newsletter.inc.php,v 1.19 2005/12/06 10:53:09 krzys Exp $
* @package    newsletter
*/
global $config;
require_once ("lib/Mail/MyMail.php");
require_once ("include/metabase.inc");

$language_array=array_flip($config->langs_symbols);

if ($language_array[$config->lang]=='0'){
require_once ("config/auto_config/newsletter/newsletter_config_L0.inc.php");
}elseif ($language_array[$config->lang]=='1') {
require_once ("config/auto_config/newsletter/newsletter_config_L1.inc.php");
}elseif ($language_array[$config->lang]=='2') {
require_once ("config/auto_config/newsletter/newsletter_config_L2.inc.php");
}elseif ($language_array[$config->lang]=='3') {
require_once ("config/auto_config/newsletter/newsletter_config_L3.inc.php");
} if ($language_array[$config->lang]=='4') {
require_once ("config/auto_config/newsletter/newsletter_config_L4.inc.php");
}
/**
 * Klasa obs³uguj±ca Newsletter.
 * 
 * @package newsletter
 * @subpackage htdocs
 */
class NewsLetter {
    
    var $salt='';            // salt z pliku config
    var $from='';            // pole maila from
    var $reply='';           // pole maila reply
    var $email='';           // adres zapisujacego/wypisujacego sie z Newsletter
    var $action='';          // czy zapisuje sie czy wypisuje
    var $confirm='';         // czy wysylamy potwierdzenie do uzytkownika ( dokladny opis w config.inc.php)
    var $email_md5='';       // md5 od adresu email
    var $action='';          // co robimy z uzytkownikiem: zapisujemy czy wypisujemy
    var $group='';            // domyslna grupa do ktorej maja byc dopisywani nowi uczestnicy newslettera
        
    /**
    * Konstruktor obiektu NewsLetter
    *
    * @access public
    *
    * @author rdiak@sote.pl
    *
    * @return string the current date in specified format
    */
    
    function newsletter($email,$action) {
        
        global $config;
        global $config_newsletter;
        
        $this->email=$email;
        if($action == ' Usuñ ') {
            $this->action='del';
        } else {
            $this->action='add';
        }
        $this->salt=$config->salt;
        $this->from=$config_newsletter->newsletter_sender;
        $this->reply=$config_newsletter->newsletter_sender;
        //$this->confirm=$config_newsletter->newsletter_confirm;
        $this->group=$config_newsletter->newsletter_group;
        $this->make_md5();
        return true;
    }
    
    /**
    * Glowna funkcja zarzadzajaca newsletterem
    *
    * @access public
    *
    * @author rdiak@sote.pl
    *
    * @return boolean true/false
    */
    
    function action() {
        global $lang;
        if($this->check_email()) {
            if(($this->action == 'add') || ($this->action == '')) {
                $res_add = $this->add();
                if($res_add != false) {
                    if($this->send()) {
                        if($res_add == 'added')
                            print "<br><center>".$lang->newsletter_added."</center><br>";
                    } else {
                        print "<br><center>".$lang->newsletter_error_send."</center><br>";
                    }
                } else {
                    // print "<br><center>".$lang->newsletter_error_add."</center><br>";
                }
            } elseif($this->action == 'del') {
                if($this->del()) {
                    if($this->send()) {
                        print "<br><center>".$lang->newsletter_deleted."</center><br>";
                    } else {
                        print "<br><center>".$lang->newsletter_error_send."</center><br>";
                    }
                } else {
                    print "<br><center>".$lang->newsletter_error_add."</center><br>";
                }
            }
        } else {
            print "<br><center>".$lang->newsletter_error_address."<br>";
            print "<u><a href=javascript:history.back();>".$lang->back."</a></u></center><br>";
            
        }
        return true;
    }
    
    /**
    * Sprawdz poprawnosc adresu e-mail
    *
    * @param string $email adres email, ktory sprawdzamy
    * @return bool true - adres poprawnym, false - nie poprawny
    *
    * @author m@sote.pl
    *
    * TODO
    */
    
    function check_email() {
        if (ereg("@",$this->email)) {
            return true;
        }
        return false;
    } // end check_email()
    
    /**
    * Dodaj adres do bazy newsletter
    *
    * @param string $email adres email dodawany do bazy
    *
    * @author  m@sote.pl
    */    
    function add() {
        global $database;
        global $lang;
        global $config;
        
        // sprawdzenie czy jakies grupy istnieja w systemie
        // jesli nie to zalozenie pierwszej poczatkowej grupy.
        // i dopisanie tego czlonka do tej grupy
        $count=$database->sql_select("count(*)","newsletter_groups");
        if($count > 0 ) {
            $group=$database->sql_select("user_id","newsletter_groups","name=$this->group");
            if(empty($group)) {
                $max=$database->sql_select("max(user_id)","newsletter_groups");
                $database->sql_insert("newsletter_groups",array(
                "user_id"=>$max++,
                "name"=>$this->group,
                "count"=>1
                )
                );
            } else {
                $max=$group;
            }
            $groups=":".$max.":";
        } else {
            $database->sql_insert("newsletter_groups",array(
            "user_id"=>1,
            "name"=>"public",
            "count"=>1,
            )
            );
            $groups=":1:";
        }
        
        $num_rows=$database->sql_select_data("email","status","newsletter","email=$this->email");
        
        if(!empty($num_rows[0])) {
            if($num_rows[1] == 0) {
                $result=$database->sql_update("newsletter","email=$this->email",array("status"=>"1"));
                print "<br><center>".$lang->newsletter_error_activate."</center><br>";
                return "activated";
            } else {
                print "<br><center>".$lang->newsletter_error_repeat."</center><br>";
                return false;
            }
        } else {
            $result=$database->sql_insert("newsletter",array(
            "email"=>$this->email,
            "date_add"=>date("Y-m-d"),
            "active"=>0,
            "status"=>0,
            "md5"=>$this->email_md5,
            "groups"=>$groups,
            "lang"=>$config->lang,
            )
            );
            
            $count_1=$database->sql_select("count","newsletter_groups","name=$groups");
            $count_1++;
            $database->sql_update("newsletter_groups","name=$groups",array("count"=>"$count_1"));
            if ($result==0) {
                return false;
            }
        }
        return "added";
    } // end add()
    
    /**
    * Usun adres z bazy newsletter
    *
    * @param string $email adres email dodawany do bazy
    *
    * @author rdiak@sote.pl
    *
    * @return boolean true/false
    */
    
    function del() {
        global $database;
        
        $num_rows=$database->sql_select("count(*)","newsletter","email=$this->email");
        
        if($num_rows < 0) {
            return false;
        } else {
            $result=$database->sql_update("newsletter","email=$this->email",array(
            "date_remove"=>date("Y-m-d"),
            "active"=>0,
            "status"=>1,
            )
            );
            if ($result==0) {
                return false;
            }
        }
        return true;
    } // end del()
    
    /**
    * Funkcja tworzy tre¶æ maila wysylanego do zapisujacego sie  uzytkownika
    *
    * @author rdiak@sote.pl
    *
    * @return string $str tresc maila
    */
    
    function prepare_email_add() {
        global $config_newsletter;
        global $config;
        
        // naglowek wiadomosci
        $str=$config_newsletter->newsletter_head." ". $this->email."\n\n";
        $str.=$config_newsletter->newsletter_info_add."\n\n";
        $str.=$config_newsletter->newsletter_foot_add."\n";
        $str.="http://".$_SERVER['SERVER_NAME'].$config->url_prefix."/go/_newsletter/register.php?act=add&email=".$this->email_md5."\n\n";
        return $str;
    } //end prepare_email
    
    /**
    * Funkcja tworzy tre¶æ maila wysylanego do wypisujacego sie uzytkownika
    *
    * @author rdiak@sote.pl
    *
    * @return string $str tresc maila
    */    
    function prepare_email_del() {
        global $config_newsletter;
        global $lang;
        global $config;
        
        // naglowek wiadomosci
        $str=$config_newsletter->newsletter_head." ". $this->email."\n\n";
        $str.=$config_newsletter->newsletter_info_del."\n\n";
        $str.=$config_newsletter->newsletter_foot_del."\n";       
        $str.="http://".$_SERVER['SERVER_NAME'].$config->url_prefix."/go/_newsletter/register.php?act=del&email=".$this->email_md5."\n\n";       
        return $str;
    } //end prepare_email
    
    /**
    * Funkcja generuje md5 od adresu email
    *
    * @author rdiak@sote.pl
    *
    * @return boolean true/false
    */    
    function make_md5() {
        $this->email_md5=md5($this->email.$this->salt);
        return true;
    } // end make_md5
    
    /**
    * Funkcja wysy³a maila do zapisuj±cego
    *
    * @author rdiak@sote.pl
    *
    * @return boolean true/false
    */    
    function send() {
        global $lang;
        
        if($this->action == 'add') {
            $body=$this->prepare_email_add();
            $subject=$lang->newsletter_sub_add;
        } elseif($this->action == 'del') {
            $body=$this->prepare_email_del();
            $subject=$lang->newsletter_sub_del;
        }
        $mail = new MyMail;
        if($mail->send($this->from,$this->email,$subject,$body,$this->reply)) {
            return true;
        } else {
            return false;
        }
    } //end send()
    
} //end class Newsletter

?>
