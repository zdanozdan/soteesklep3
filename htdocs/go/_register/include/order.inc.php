<?php
/**
 * Rejstracja zamowienia, generownie numeru zamowienia order_id
 *
 * @author m@sote.pl
 * @version $Id: order.inc.php,v 2.2 2004/12/20 18:01:45 maroslaw Exp $
* @package    register
 */
 
class Order {
    var $id;         // nr order_id
    var $id_date;    // order_id+data np. 2002/03/101

    /**
     * Generuj order_id z data
     */
    function gen_id_date($order_id) {
        return (date("Y"))."/".(date("m"))."/".$order_id;
    } // end gen_id_date()


    /**
     * Generuj kolejny numer order_id.
     *
     * @return string numer order_id z data w postaci np. 2002/03/101, lub false
     * \@global int $this->id numer order_id
     * \@global string $this->id_date jw. + data
     */
    function get_id() {
        global $db;
        
        $query="SELECT order_id FROM order_id";
        $result=$db->Query($query);
        if ($result!=0) {           
            $num_rows=$db->NumberOfRows($result);           
            if ($num_rows>0) {
                $order_id=$db->FetchResult($result,0,"order_id");
                if ($order_id>0) $order_id++;
                else $order_id=1;
                                
                $query="UPDATE order_id SET order_id=?";
                $prepared_query=$db->PrepareQuery($query);
                if ($prepared_query) {
                    $db->QuerySetText($prepared_query,1,$order_id);
                    $result=$db->ExecuteQuery($prepared_query);
                    if ($result!=0) {
                        $this->id=$order_id;
                        $this->id_date=$this->gen_id_date($order_id);
                        return $this->id_date;                    
                    } else {
                        die ($db->Error());
                    }                
                }
            } else {
                $order_id=1;
                $query="INSERT INTO order_id (order_id) VALUES (?)";
                $prepared_query=$db->PrepareQuery($query);
                if ($prepared_query) {
                    $db->QuerySetText($prepared_query,1,$order_id);
                    $result=$db->ExecuteQuery($prepared_query);
                    if ($result!=0) {
                        $this->id=$order_id;
                        $this->id_date=$this->gen_id_date($order_id);
                        return $this->id_date;
                    } else {
			die ($db->Error());
                    }
                }
            }             
        } else {
            $db->Error();
        }

        return false;
    } // end get_id()
}

$order = new Order;
?>
