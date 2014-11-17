<?php
/**
* Elementy select z danymi kategorii,producenta itp
*
* @author  m@sote.pl
* @version $Id: select_category.inc.php,v 2.7 2005/01/20 10:46:17 lechu Exp $
* @todo Ten plik koniecznie musi mieæ zmienion± nazwê (by lech@sote.pl)
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

/**
* Elementy zwi±zane z edycj± produktu
* @package admin
* @subpackage edit
*/
class FormElements {
    var $selected=false;          // jesli selected=true to pokazuj aktualne elementy jako domyslnie zaznaczone
    var $type="add";              // [add|edit] - jesli type=edit to nie zznaczaj domyslnego elementu
    
    /**
    * Wyswietl element SELECT formualrza. Zaznacz bie¿±c± warto¶æ
    *
    * @param string $column nazwa kolumny kategorii/producenta z tabeli main
    * @param string $current, aktualna warto¶æ
    *
    * @return none
    */
    function select($column,$current) {
        global $db;
        global $_REQUEST;
        
        if (! empty($_REQUEST['item2'][$column])) {
            $current=$_REQUEST['item2'][$column];
            $this->selected=true;
        }
        
        $query="SELECT * FROM $column";
        $result=$db->Query($query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows==0) {
                return;
            } else {
                print "<select name=item2[$column]>\n";
                print "<option value='' selected>--->\n";
                for ($i=0;$i<$num_rows;$i++) {
                    $id=$db->Fetchresult($result,$i,"id");
                    
                    $selected="";
                    $value=$db->Fetchresult($result,$i,$column);
                    if (($this->selected==true) && ($this->type=="add")) {
                        if (($value==$current) || ($current==$id)) $selected=" selected";
                    }
                    print "<option value=\"$value\" $selected>$value\n";
                    
                } // end for
                print "</select>\n";
            } // end if
        } else die ($db->Error());
        return;
    } // end select()
    
    /**
    * Wy¶wietl w postaci elementu SELECT formularza dostepnosc "available"
    *
    * @param int $id id dostepnosci danego produktu
    *
    * @return none
    */
    function select_available($id=0) {
        global $config, $mdbd;
        $options = $mdbd->select("user_id,name", "available",1,array(),'','ARRAY');
         
        if ((is_array($options)) && (! empty($options))) {
            
            print "<select name=item[id_available]>\n";
            print "<option value=0>---\n";
            if ((is_array($options)) && (! empty($options))) {
                reset($options);
                for ($i = 0; $i < count($options); $i++) {
                    if (! empty($options[$i]['user_id'])) {
                        $user_id = $options[$i]['user_id'];
                        $name = $options[$i]['name'];
                        if ($user_id==$id) {
                            print "<option value=$user_id selected>$name\n";
                        } else {
                            print "<option value=$user_id>$name\n";
                        }
                    }
                } // end while
                print "</select>\n";
            }
        }
        return;
    } // end select_available()
    
} // end class GroupColumn

$form_elements =& new FormElements;

?>
