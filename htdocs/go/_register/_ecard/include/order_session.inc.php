<?php
/**
 * Utworz plik sesji wedlug wartosci $order_id. W pliku tym zapisz numer sesji.
 */

class OrderSession {
    function write($order_id) {
        global $db;
        global $sess;

        // sprawdz, czy w bazie nie jest juz zapiany numer sesji
        $query="SELECT session_id FROM order_session WHERE order_id=?";
        $prepared_query=$db->PrepareQuery($query);        
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$order_id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) return;
                else {
                    $query="INSERT INTO order_session (order_id,session_id) VALUES (?,?)";
                    $prepared_query=$db->PrepareQuery($query);
                    if ($prepared_query) {
                        $db->QuerySetInteger($prepared_query,1,$order_id);
                        $db->QuerySetText($prepared_query,2,$sess->id);
                        $result=$db->ExecuteQuery($prepared_query);
                        if ($result!=0) {
                            // sesja zostala dodana do bazy 
                            return;
                        } else die ($db->Error());
                    } else die ($db->Error());
                }
            } else die ($db->Error());
        } else die ($db->Error());
        return;
    } // end write()

} // end class OrderSession

$order_sess = new OrderSession;

?>