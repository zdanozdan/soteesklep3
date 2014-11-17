<?php
/**
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author  m@sote.pl
 * \@template_version Id: form_check_functions.inc.php,v 2.3 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: form_check_functions.inc.php,v 1.4 2004/12/20 18:00:01 maroslaw Exp $
 * @return  int $this->id
* @package    main_keys
 */

require_once ("include/metabase.inc");

class FormCheckFunctions extends FormCheck {
    /* 
     * \@global int $this->error_nr numer bledu: 0 - brak wartosci, 1 - za dluga zmienna tekstowa
     */

    /**
     * Sprawdz ID produktu, sprawdz czy produkt o podanym ID istnieje
     *
     * @param  string $user_id user_id produktu z tabeli main
     * @param  table  main
     *
     * @return
     * \@global int    $this->error_nr 
     *                10 - produkt o podanym user_id nie istnieje
     * @return bool   true produkt istnieje i $user_id propawne, false w p.w.
     */
    function user_id_main($user_id) {
        $user_id=trim($user_id);
        if (! $this->string($user_id)) return false;
        global $database;

        $db_user_id=$database->sql_select("user_id","main","user_id=$user_id");
        if (! empty($db_user_id)) return true;
        else {
            $this->error_nr=10;
            return false;
        }            
    } // end user_id_main()
    
    function userIdMain(&$user_id) {
        return $this->user_id_main($user_id);
    } // end userIdMain()
        
    /**
     * Sprawdz numer order_id. Jesli pole nie jest puste, to sprawdz czy istnieje pole o podenym order_id w order_register.
     * jesli pole jest puste, to pomin sprawdzanie pola. 
     *
     * @param int $order_id id zamowienia
     * @table order_register
     *
     * @return
     * \@global int    $this->error_nr 
     *                10 - nie poprawna wartosc order_id (wymaga wartosc int)
     *                11 - nie ma zamowienia o podanym order_id
     * @return bool   true order_id istnieje i jest propawne, false w p.w.
     */
    function order_id(&$order_id) {
        global $database;

        $order_id=trim($order_id);

        if (empty($order_id)) return true;

        if (! ereg("^[0-9]+$",$order_id)) {
            $this->error_nr=10;
            return false;
        }

        $db_order_id=$database->sql_select("order_id","order_register","order_id=$order_id");
        if (empty($db_order_id)) {
            $this->error_nr=11;
            return false;
        } else  return true;
    } // end order_id()

    function orderID(&$order_id) {
        return $this->order_id($order_id);
    } // end orderID()
    
    // funckje do main_keys_ftp
    
    /**
    * Sprawdz czy istnieje produkt o podanym user_id i czy w main_keys_ftp 
    * nie ma czasem kodu do takiegop produktu
    *
    * @param string $user_id user_id produktu
    * 
    * @access public
    * @return bool true 
    */
    function userIDMainUnique($user_id) {
        global $mdbd;
        $ret=$this->userIdMain($user_id);
        if ($ret) {
            $id=$mdbd->select("id","main_keys_ftp","user_id_main=?",array($user_id=>"text"),"LIMIT 1");           
            $this->id_main_keys_ftp=$id;
            if ($id>0) {
                 $this->error_nr=11;
                 return false;
            } else return true;
        } else return $ret;
    } // end userIDMainUnique()
        
} // end class FormCheckFunctions
?>
