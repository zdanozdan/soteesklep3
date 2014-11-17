<?php
/**
 * Usuwanie kategorii. Sprawdz czy mozna usunac dana kategorie, tj. czy sa prodyukty w danej kategorii. Jesli sa
 * to nie zezwalaj na usuwanie. Usun produkt z listy.
 *
 * @global int   $__deep          numer kategorii
 * @global array $_REQUEST['del'] id usuwanych rekordow
 *
 * @author  m@sote.pl
 * @version $Id: check_delete.inc.php,v 1.1 2003/07/29 08:35:55 maroslaw Exp $
 * @package soteesklep
 */

if (@$__secure_test!=true) die ("Forbidden");

class CheckDelete {
    var $allow_del=array();              // lista ID rekordow, ktore mozna skasowac
    var $deny_del=array();               // lista ID rekordow, ktorych nie mozna skasowac
    var $category_names=array();         // nazwy kategorii

    /**
     * Sprawdz czy jakies produkty maja przypisana kategorie z argumentow
     *
     * @param  string $deep nr kategorii 1-5
     * @param  int    $idc  id kategorii np. id_categiry1, id_category2 itd.
     * @return bool   true - jest taka kategori, false w p.w.
     */
    function is_category($deep,$id) {
        global $db;

        $query="SELECT id_category$deep,category$deep FROM main WHERE id_category$deep=? LIMIT 1";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $this->category_names[$deep][$id]=$db->FetchResult($result,0,"category$deep");
                    return true;
                } else return false;
            } else die ($db->Error());
        } else die ($db->Error());

        return false;
    } // end is_category

    /**
     * Sprawdz ktore kategorie mozna usunac
     * 
     * @param  int   $deep nr kategorii
     * @global array $this->allow_del
     * @global array $this->deny_del
     * @return array nowa tablica z id kategorii, ktore mozna usunac
     */
    function check_all($deep) {
        global $_REQUEST;

        if (! empty($_REQUEST['del'])) {
            $del=$_REQUEST['del'];
            reset($del);

            while (list($id,) = each ($del)) {
                if (! $this->is_category($deep,$id)) {
                    $this->allow_del[$id]="on";
                } else {
                    $this->deny_del[$id]=$this->category_names[$deep][$id];
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
            print "$lang->edit_category_not_deleted\n";
        } else return(0);

        reset($this->deny_del);
        while (list($id,$category) = each ($this->deny_del)) {
            print "<li>$id - $category\n";
        } // end while()
        return(0);
    } // end report()

} // end class CheckDelete

$check_delete = new CheckDelete;
$_REQUEST['del']=$check_delete->check_all($__deep);
$check_delete->report();
?>