<?php
/**
 * Sprawdz poprawnosc formularza, dodatkowe funkcje
 *
 * @author  m@sote.pl
 * \@template_version Id: form_check_functions.inc.php,v 2.3 2003/06/14 21:59:37 maroslaw Exp
 * @version $Id: form_check_functions.inc.php,v 1.3 2004/12/20 17:58:12 maroslaw Exp $
 * @return  int $this->id
* @package    edit_producer
 */
class FormCheckFunctions extends FormCheck {

    /**
     * Sprawdzanie pola producent
     *
     * @param  string $producer nazwa producenta
     * \@global int    $this->nr numer bladu
     * @return bool   true - pole poprawnie wypelnione, false w p.w.
     *
     * @public
     */
    function producer(&$producer) {
        global $db;
        $producer=trim($producer);

        $query="SELECT producer FROM producer WHERE lower(producer) like lower(?)";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$producer);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $this->error_nr=11;
                    return false;
                }
            } else die ($db->Error());
        } else die ($db->Error());

        return $this->string($producer);        
    } // end producer()
} // end class FormCheckFunctions
?>
