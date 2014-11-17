<?php
/**
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author  m@sote.pl
 * \@template_version Id: form_check_functions.inc.php,v 2.3 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: form_check_functions.inc.php,v 1.4 2004/12/20 17:58:09 maroslaw Exp $
 * @return  int $this->id
* @package    edit_category
 */
class FormCheckFunctions extends FormCheck {

    /**
     * Sprawdzanie pola kategorii
     *
     * @param  string $producer nazwa kategorii
     * \@global int    $__deep   numer kategorii
     * \@global int    $this->nr numer bladu
     * @return bool   true - pole poprawnie wypelnione, false w p.w.
     *
     * @public
     */
    function category(&$category) {
        global $db;
        global $__deep;
        $category=trim($category);

        $query="SELECT category$__deep FROM category$__deep WHERE lower(category$__deep) like lower(?) and id <> ?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$category);
            $db->QuerySetInteger($prepared_query,2,$_REQUEST['id']);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $this->error_nr=11;
                    return false;
                }
            } else die ($db->Error());
        } else die ($db->Error());

        return $this->string($category);        
    } // end category()

} // end class FormCheckFunctions
?>
