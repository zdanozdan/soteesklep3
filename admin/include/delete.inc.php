<?php
/**
 * Usuwanie rekordow ze wskazanej tabeli
 *
 * @author m@sote.pl
 * @version $Id: delete.inc.php,v 2.7 2005/04/12 12:50:54 maroslaw Exp $
* @package    admin_include
 */

class Delete {
    var $del="del";            // nazwa tablicy z wartosciami id przekazywanej z formularza HTML
    var $show_empty_info=true; // pokaz komunikat o pustym koszu

    /**
     * Usun rekord
     * @param int    $id     id usuwanego rekordu
     * @param string $table  nazwa tabeli, z ktorej usuwamy rekordy
     * @param string $column nazwa pola, ktorego wartosc bedzie wyswietlana jako 
     *                       dodatkowe info o usunietym rekordzie
     */
    function delete_one_record($id="",$table,$column="id") {
        global $lang,$db;

        if (empty($id)) return;

        $query="SELECT $column FROM $table WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $column=$db->FetchResult($result,0,"$column");

                    // usun produkt
                    $query="DELETE FROM $table WHERE id=?";
                    $prepared_query=$db->PrepareQuery($query);
                    if ($prepared_query) {
                        $db->QuerySetText($prepared_query,1,$id);
                        $result=$db->ExecuteQuery($prepared_query);
                        if ($result!=0) {
                            print "&nbsp; &nbsp; $column -".$lang->deleted."<br>";
                        } else die ($db->Error());
                    } else die ($db->Error());
                } else {
                    print $lang->delete_not_found." id=$id<BR>";
                }
            } else die ($db->Error());
        } else die ($db->Error());

        return;
    } // end delete_one_record()

    /**
     * Usun wszystkie zaznaczone w formularzu rekordy. Pola w formularzu musz miec typ checkbox
     * o wartosci del[id]=1 dla $this->del="del"
     *
     * @param string $table nazwa tabeli, zktorej usuwamy rekordy
     * @param string $column nazwa pola, ktorego wartosc bedzie wyswietlana jako dodatkowe info o usunietym rekordzie
     */
    function delete_all($table,$column="id") {
        global $_REQUEST;
        global $lang;

        // usun wszsytkei zaznaczone rekordy
        if (! empty($_REQUEST[$this->del])) {
            $del=$_REQUEST[$this->del];

            if (is_object(@$this->delete_obj)) {
                $data=$this->deleteCheck($table,$column,$del,$this->delete_obj);
                $del=$data['deleted'];
            }

            // lista rekordow do usuniecia
            while (list($id,) = each($del)) {
                if (! empty($id)) {
                    $this->delete_one_record($id,$table,$column);
                }
            }
        } else {
            if  ($this->show_empty_info==true) {
                print "<center>".$lang->delete_empty."</center>";
            }
        }
        return;
    } // end delete_all()

    /**
     * Usun wszystkie zaznaczone w formularzu rekordy. Pola w formularzu musz miec typ checkbox
     * o wartosci del[id]=1 dla $this->del="del"
     *
     * @param string $table nazwa tabeli, zktorej usuwamy rekordy
     * @param string $column nazwa pola, ktorego wartosc bedzie wyswietlana jako dodatkowe info o usunietym rekordzie
     * @param object $delete_obj wska¼nik obiektu zawieraj±cego funkcje deleteCheck(), sprawdzaj±c± czy mo¿na usun±æ rekord
     */
    function deleteAllCheck($table,$column="id",&$delete_obj) {
        $this->delete_obj=&$delete_obj;
        return $this->delete_all($table,$column);
    } // end deleteAllCheck()

    // {{{ deleteCheck()

    /**
    * Warunkowe usuniêcie produktów, sprawdzenie czy mo¿na usun±æ dane rekordy.
    *
    * @param string $table  tabela, z której usuwamy rekordy
    * @param string $column kolumna wed³ug warto¶ci której usuwane s± rekordy
    * @param string $data   tablica z danymi dla $column, dla tych wartosci $column rekordy zostan± usuniête
    * @param object $delete_obj wska¼nik obiektu zawieraj±cego funkcje deleteCheck(), sprawdzaj±c± czy mo¿na usun±æ rekord
    * 
    * @return array $data[deleted] - $data z pominiêciem rekordów, których nie mo¿na usun±æ + $this->warnings z raportem,  $data[not_deleted] - rekordy nie usuniête
    */
    function deleteCheck($table,$column,$data,&$delete_obj) {
        $o='';

        reset($data);$data2=array();$datan=array();
        foreach ($data as $key=>$on) {
            if (method_exists($delete_obj,"deleteCheck")) {
                $ret=$delete_obj->deleteCheck($key,$table);
                if ($ret) {
                    $data2[$key]=$on;
                } else {
                    $datan[$key]=$on;
                }
            } else {
                die ("Unknown method: \$delete_obj->deleteCheck");
            }
        }
        $this->warnings=$o;
        return array("deleted"=>$data2,"not_deleted"=>$datan);
    } // end deleteCheck()

    // }}}

} // end class Delete


/*
// Przyklad wywolania usuniecia rekordow z tabeli order_register

// 1. przyklad
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("order_register","order_id");

// 2. przyklad
require_once("include/delete.inc.php");
$delete = new Delete;
$delete->delete_all("order_register");

*/
?>
