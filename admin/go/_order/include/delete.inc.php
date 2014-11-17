<?php
/**
* Klasa obs³uguj±ca usuwanie transakcji.
*
* @ignore
* @version    $Id: delete.inc.php,v 2.5 2005/12/06 13:15:45 lechu Exp $
* @package    order
*/

/**
* @package order
* @subpackage order
* @ignore
*/
class DeleteOrder {

    /**
    * Usuñ rekord
    *
    * @param int $id ID transakcji.
    * @return none
    */
    function delete($id="") {
        global $lang,$db,$mdbd;
        
        if (empty($id)) return;
        
        $query="SELECT order_id, id_users, id_users_data FROM order_register WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $order_id=$db->FetchResult($result,0,"order_id");
                    $id_users_data=$db->FetchResult($result,0,"id_users_data");
                    $id_users=$db->FetchResult($result,0,"id_users");
                    
                    // usun produkty
                    $query="DELETE FROM order_register WHERE id=?";
                    $prepared_query=$db->PrepareQuery($query);
                    if ($prepared_query) {
                        $db->QuerySetText($prepared_query,1,$id);
                        $result=$db->ExecuteQuery($prepared_query);
                        if ($result!=0) {
                            print "&nbsp; &nbsp; $order_id -".$lang->deleted."<br>";
                            // skaduj produkty zwi±zane z tym zamówieniem ( z tabeli order_products)
                            $mdbd->delete("order_products","order_id=?",array($order_id=>"int"));
                        } else die ($db->Error());
                    } else die ($db->Error());
                    
                    // usun wpis o tymczasowym uzytkowniku (users)
                    if ($id_users == -1) { // zamawiaj±cy u¿ytkownik nie by³ zalogowany
                        $query="DELETE FROM users WHERE id=?";
                        $prepared_query=$db->PrepareQuery($query);
                        if ($prepared_query) {
                            $db->QuerySetInteger($prepared_query,1,$id_users_data);
                            $result=$db->ExecuteQuery($prepared_query);
                        } else die ($db->Error());
                    }
                    
                } else {
                    print $lang->delete_not_found." id=$id<BR>";
                }
            } else die ($db->Error());
        } else die ($db->Error());
        
        return;
    } // end delete()
    
} // end class DeleteOrder

$delete =& new DeleteOrder;

?>
