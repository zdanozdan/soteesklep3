<?php
/**
 * Dosteponosc produktu
 *
 * @author  m@sote.pl
 * @version $Id: available.inc,v 2.12 2006/01/25 09:43:26 lechu Exp $
* @package    include
 */ 

class Available { 

    /**
     * Odczytaj dostepnosc produktu
     * 
     * @param  $id    id dostepnosci produktu
     * @param  object $rec dane z bazy dot. produktu $rec->data
     * @param  string [string|NULL] jesli wartosc == string to dostepnosc jest zwracana
     * @return string dostepnosc lub ciag pusty (np. dla list produktow, dla sprzedazy produktow on-line) 
     * 
     * @public
     */
    function get1($id,$rec='',$type='') {
        global $config;
        global $lang;
        if($config->depository['display_availability'] != 1)
            return;
        $available_prefix="<b>".$lang->available." </b>";     

        if (! empty($config->available[$id])) {
            $available_prefix="<b>".$lang->available." </b>";       
            $available=$config->available[$id]."<br>\n";
        } elseif ($rec->data['main_keys_online']!=1) return '';


        if (empty($rec)) {
            if (! empty($config->available[$id])) {
                return $available;
            }
        } else {
            if ($rec->data['main_keys_online']=="1") {
                if ($type=="string") {
                    // sprawdz czy sa kody dla danego produktu
                    if ($this->check_main_keys($rec->data['user_id'])) {
                        return $lang->available_online["1"];
                    } else {
                        return $lang->available_online["0"];
                    }
                } else return '';
            } elseif (! empty($config->available[$id])) {
                return $available;
            }
        }         
        return false;
    } // end get()

    function get($id,$rec='',$type='') {
        global $config;
        if($config->depository['display_availability'] != 1)
            return;
        include_once("include/lang_functions.inc");
        global $lang, $mdbd;
        if($id == 0)
            return ;
        $available_prefix="<b>".$lang->available." </b>";
        $available_value = $mdbd->select("name", "available", "user_id=?",array($id=>'int'));
        $available_value = LangF::translate($available_value);
        $available = $available_value . "<br>\n";
        if (! empty($available)) 
        return $available;
        else return;
    }
    
    /**
     * Sprawdz czy sa kody dla danego produktu
     *
     * @param string $user_id
     * @return bool 
     */
    function check_main_keys($user_id) {
        global $db;

        $query="SELECT id FROM main_keys WHERE user_id_main=? AND order_id!=0 LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$user_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) return true;
                else return false;
            } else die ($db->Error());
        } else die ($db->Error());

    } // end check_main_keys()

} // end class Available

$available = new Available;

?>
