<?php
/**
* Funckje sprawdzaj±ce poprawno¶æ pól formularza edycji/dodania produktu
*
* @author m@sote.pl
* @version $Id: my_form_check.inc.php,v 2.5 2004/12/20 17:58:05 maroslaw Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

require_once("include/form_check.inc");

class MyFormCheck extends FormCheck {
    var $category=array();               // wprowadzone kategorie
    
    /**
    * Sprawdz czy istnieje produkt o podanym identyfikatorze user_id
    *
    * @param string $user_id identyfikator produktu podany przez uzytkownika
    * @return bool true - produkt o danym user_id jest juz w bazie, false - nie ma
    */
    function user_id($user_id) {
        global $db;
        
        if (empty($user_id)) {
            $this->error_nr=10;
            return false;
        }
        
        $query="SELECT user_id FROM main where user_id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$user_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $this->error_nr=11;
                    return false;
                } else  {
                    return true;
                }
            } else die ($db->Error());
        } else die ($db->Error());
        
    } // end user_id()
    
    /**
    * Sprawdz, czy sa wypelnione odpowiednie kategorie. Dla nr=2 musi byc wypelniona
    * kategoria 1i2, dla 3- 1,2 i 3 itd. Wartosci kategorii pobierane sa z tablicy $this->category
    * oraz z parametru $category
    *
    * @param string $caregory
    * @param int $nr - numer kategorii
    * @return bool [true|false] true - sa wymagane kategorie, false w pw.
    */
    function check_category($category,$nr) {
        // odczytaj jaka jest maksymalna wprowadzona kategoria
        $max_cat=0;
        for ($i=1;$i<=5;$i++) {
            // sprawdz czy wspiano kategorie lub czy wybrano kategorie z list select
            // dla poprzednich kategorii
            if ((! empty($this->category[$i])) || (! empty($this->item2["category$i"]))) $max_cat=$i;
        }
        
        // jesli kategoria jest pusta, a sa wyzsze kategorie, to zwroc falsz
        if ((empty($category)) && (empty($this->item2["category$nr"])) && ($max_cat>$nr)) return false;
        
        return true;
    } // end check_category()
    
    /**
    * Sprawdz poprawnosc wypelnienia pola category1
    *
    * @param string $category1 kategoria 1 produktu
    *
    * @access public
    * @return bool
    */
    function category1($category1) {
        global $_POST;
        
        if (! empty($_POST['item2'])) {
            // odczytaj kategorie z elementow SELECT przy kategoriach
            $this->item2=$_POST['item2'];
        } else $this->item2='';
        
        if (! empty($category1)) return true;
        if (! empty($this->item2["category1"])) return true;
        return false;
    } // end category1()
    
    function category2($category2) {
        return $this->check_category($category2,2);
    } // end category2()
    
    function category3($category3) {
        return $this->check_category($category3,3);
    } // end category3()
    
    function category4($category4) {
        return $this->check_category($category4,4);
    } // end category4()
    
    function category5($category5) {
        return $this->check_category($category5,5);
    } // end category5()
    
} // end class MyFormCheck

?>
