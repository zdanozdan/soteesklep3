<?php
/**
 * Usuwanie producentow. Sprawdz czy mozna usunac danego producenta, tj. czy sa produkty w danej kategorii. Jesli sa
 * to nie zezwalaj na usuwanie. Usun produkt z listy.
 *
 * @global array $_REQUEST['del'] id usuwanych rekordow
 *
 * @author  m@sote.pl
 * @version $Id: check_delete.inc.php,v 1.1 2003/07/29 08:37:05 maroslaw Exp $
 * @package soteesklep
 */

if (@$__secure_test!=true) die ("Forbidden");

class CheckDelete {
    var $allow_del=array();              // lista ID rekordow, ktore mozna skasowac
    var $deny_del=array();               // lista ID rekordow, ktorych nie mozna skasowac
    var $producer_names=array();         // nazwy kategorii

    /**
     * Sprawdz czy jakies produkty maja przypisanego producenta z argumentow
     *
     * @param  int    $id   id producenta
     * @return bool   true - jest taki producent, false w p.w.
     */
    function is_producer($id) {
        global $db;

        $query="SELECT id_producer,producer FROM main WHERE id_producer=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $this->producer_names[$id]=$db->FetchResult($result,0,"producer");
                    return true;
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());

        return false;
    } // end is_producer

    /**
     * Sprawdz ktore kategorie mozna usunac
     * 
     * @global array $this->allow_del
     * @global array $this->deny_del
     * @return array nowa tablica z id kategorii, ktore mozna usunac
     */
    function check_all() {
        global $_REQUEST;

        if (! empty($_REQUEST['del'])) {
            $del=$_REQUEST['del'];
            reset($del);

            while (list($id,) = each ($del)) {
                if (! $this->is_producer($id)) {
                    $this->allow_del[$id]="on";
                } else {
                    $this->deny_del[$id]=$this->producer_names[$id];
                }
            } // end foreach
        }
                
        return $this->allow_del;
    } // end check_all()

    /**
     * Pokaz komunikaty, ktorych rekordow nie mozna usunac
     */
    function report() {
        global $lang;
        
        if (! empty($this->deny_del)) {
            print "$lang->edit_producer_not_deleted\n";
        } else return(0);

        reset($this->deny_del);
        while (list($id,$producer) = each ($this->deny_del)) {
            print "<li>$id - $producer\n";
        } // end while()
        return(0);
    } // end report()

} // end class CheckDelete

$check_delete = new CheckDelete;
$_REQUEST['del']=$check_delete->check_all();
$check_delete->report();
?>