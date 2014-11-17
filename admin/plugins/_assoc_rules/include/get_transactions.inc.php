<?php
/**
* Pobierz transakcje z bazy i zapisz je do pliku
*
* @author  lech@sote.pl
* @version $Id: get_transactions.inc.php,v 1.5 2005/12/08 17:15:21 lechu Exp $
*
* @package    _assoc_rules
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ($global_secure_test!=true) {
    die ("Forbidden");
}

$query = "
SELECT p.user_id_main AS p_prod_id, p.order_id AS p_order_id
FROM order_products p, order_register o, main m
WHERE
o.order_id = p.order_id AND o.confirm = 1 AND p.user_id_main = m.user_id AND m.active=1";
/*
$query = "
SELECT user_id_main AS prod_id, order_id
FROM order_products2";
*/
global $stream, $theme, $_REQUEST;

$transactions = array();
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
        	for ($i = 0; $i < $num_rows; $i++) {
            
            	// Odczytaj w³a¶ciwo¶ci transakcji i zapamiêtaj je w tablicy $transactions
            	$prod_id = $db->FetchResult($result,$i,"p_prod_id");
            	$order_id = $db->FetchResult($result,$i,"p_order_id");
            	$transactions[$order_id][] = $prod_id;
            	if(empty($_REQUEST['cron_mode']))
            	   $stream->line_blue();
        	}
        }
    } else die ($db->Error());
} else die ($db->Error());

// przepisz tablicê $transactions do pliku
$fp = fopen($transactions_path, "w");
reset($transactions);
while (list($key, $val) = each($transactions)) {
	$transaction = implode(";", $val) . "\n";
	fwrite($fp, $transaction);
}
fclose($fp);
?>