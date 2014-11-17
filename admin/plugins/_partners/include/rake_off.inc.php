<?php
/**
 * Obliczamy prowizje dla danego partnera z danego okresu 
 *
 * $author: piotrek@sote.pl
 * $Id: rake_off.inc.php,v 1.3 2005/01/19 13:04:52 scalak Exp $
* @version    $Id: rake_off.inc.php,v 1.3 2005/01/19 13:04:52 scalak Exp $
* @package    partners
 */

class RakeOff {
  
    /**
     * Oblicz prowizje dla danego partnera z danego okresu
     *
     * @param $partner - nazwa partnera
     * @param $from_date - data od
     * @param $to_date - data do
     */
    function compute_rake_off($partner,$from_date,$to_date){
        require_once("include/metabase.inc");
        global $db;
        global $lang;
        global $config;
        
        $total_rake_off_amount=0;
        
        $database = new my_Database;

        // wyciagnij partner_id 
        $partner_id=$database->sql_select("partner_id","partners","name=$partner");

        // zapytanie o transakcje dla danego partnera i zadanego okresu czasu
        $query="SELECT rake_off_amount FROM order_register WHERE partner_id='$partner_id' AND confirm=1 AND(date_add >= '$from_date' AND date_add <= '$to_date')";                    
                
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $rake_off_amount=$db->FetchResult($result,$i,"rake_off_amount");   // pobranie prowizji dla danej transakcji
                        $total_rake_off_amount=$total_rake_off_amount+$rake_off_amount;    // calkowita wartosc prowizji
                    }
                }
            } else die ($db->Error());
        } else die ($db->Error());

        if ($num_rows>0) {
             print "<table border=0 align=center cellspacing=6>";
             print "<tr><td>$lang->partners_total_trans_found: <b>$i</b></td></tr>";
             print "<tr><td>$lang->partners_total_rake_off <b>$partner</b> $lang->partners_period <b>$from_date</b> $lang->partners_to <b>$to_date</b></td></tr>";
             print "<tr><td align=center><b>$total_rake_off_amount $config->currency</b></td></tr>";
             print "</table>";
        } else print $lang->partners_no_transactions;
        
    } // end compute_rake_off()
    
} // end class RakeOff

?>
