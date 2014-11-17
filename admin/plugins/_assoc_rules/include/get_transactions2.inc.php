<?php
/**
* Pobierz transakcje z bazy i zapisz je do pliku
*
* @author  lech@sote.pl
* @version $Id: get_transactions2.inc.php,v 1.11 2005/12/27 12:12:04 lechu Exp $
*
* @package    _assoc_rules
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ($global_secure_test!=true) {
    die ("Forbidden");
}

global $query, $mdbd, $current_user_id, $assoc_rules, $DOCUMENT_ROOT, $_REQUEST;


$res = $mdbd->select("id_users,order_id", "order_register", "id_users > 0 AND confirm = 1 ", array(), "", "array");

$users_transactions = array();

if (is_array($res)) {
    for($i = 0; $i < count($res); $i++) {
    	$users_transactions[$res[$i]["id_users"]][$res[$i]["order_id"]] = 1;
    }
}


reset($users_transactions);
$count = 0;
while (list($current_user_id, $current_user_transactions) = each($users_transactions)) {
	$transactions = array();
	$product_ranking = array();
	$count++;
	
	// collect products bought by $current_user_id
	$where = '1=0';
	$conditions = array();
	while (list($current_user_transaction_id, $one) = each($current_user_transactions)) {
	    if (!isset($conditions[$current_user_transaction_id])) {
    		$conditions[$current_user_transaction_id] = "text";
    		$where .= " OR order_id=? ";
	    }
	}
	$res_current_user_products = $mdbd->select("user_id_main", "order_products", $where, $conditions, "", "array");

	// collect other users' orders that bought same products what $current_user_id
	$where = '1=0';
	$conditions = array();
	if (is_array($res_current_user_products)){
    	for ($i = 0; $i < count($res_current_user_products); $i++) {
    		if (!isset($conditions[$res_current_user_products[$i]["user_id_main"]])) {
    			$where .= " OR user_id_main=? ";
    			$conditions[$res_current_user_products[$i]["user_id_main"]] = "text";
    		}
    	}
	}

	
	$res_other_users_transactions = $mdbd->select("order_id", "order_products", $where, $conditions, "", "array");

	
    // collect other users that bought same products what $current_user_id
	$where = ' id_users > 0  AND confirm = 1 AND (1=0 ';
	$conditions = array();
	if (is_array($res_other_users_transactions)){
    	for ($i = 0; $i < count($res_other_users_transactions); $i++) {
    		if (!isset($conditions[$res_other_users_transactions[$i]["order_id"]])) {
    			$conditions[$res_other_users_transactions[$i]["order_id"]] = "int";
    			$where .= " OR order_id=? ";
    		}
    	}
	}
	$where .= ' ) ';
	$res_other_users_ids = $mdbd->select("id_users", "order_register", $where, $conditions, "", "array");
/*
SELECT DISTINCT or1.id_users
FROM order_register or1, order_products op1, order_register or2, order_products op2
WHERE or2.id_users =482 AND or2.order_id = op2.order_id AND op2.user_id_main = op1.user_id_main AND op1.order_id = or1.order_id
*/

	// for every other user
	$other_users_ids = array();
	if (is_array($res_other_users_ids)){
    	for ($i = 0; $i < count($res_other_users_ids); $i++) {
    		if(($res_other_users_ids[$i]["id_users"] > 0) && ($res_other_users_ids[$i]["id_users"] != $current_user_id) && (!isset($other_users_ids[$res_other_users_ids[$i]["id_users"]]))) {
    			$other_users_ids[$res_other_users_ids[$i]["id_users"]] = 1;
    			$other_user_id = $res_other_users_ids[$i]["id_users"];
    
    			// collect other user's all transactions
    			
    			// ********** DODAÆ OGRANICZENIE CZASOWE!!!
    			$date_limit['dd'] = date('d');
    			$date_limit['mm'] = date('m');
    			$date_limit['yyyy'] = date('Y') - 1;
    			$date_limit = $date_limit['yyyy'] . '-' . $date_limit['mm'] . '-' . $date_limit['dd'];
    			$res_other_users_all_transactions = $mdbd->select("order_id", "order_register", "id_users > 0 AND confirm = 1 AND 'date_add' > '$date_limit' AND id_users=?", array($other_user_id => "int"), "", "array");
    			
    			
    			// collect all products bought by $other_user_id
    			$where = '(1=0';
    			$conditions = array();
    			$j = 1;
    			if (is_array($res_other_users_all_transactions)){
        			for ($k = 0; $k < count($res_other_users_all_transactions); $k++) {
        				$conditions[$j . "," . $res_other_users_all_transactions[$k]["order_id"]] = "int";
        				$j++;
        				$where .= " OR order_id=? ";
        			}
    			}
    			$where .= " ) ";
    			
    			if (is_array($res_current_user_products)){
        			for ($k = 0; $k < count($res_current_user_products); $k++) {
        				$conditions[$j . "," . $res_current_user_products[$k]["user_id_main"]] = "text";
        				$j++;
        				$where .= " AND user_id_main <> ? ";
        			}
    			}
    		
    			$res_other_users_products = $mdbd->select("user_id_main", "order_products", $where, $conditions, "", "array");
    			if (is_array($res_other_users_products)){
        			for($k = 0; $k < count($res_other_users_products); $k++) {
        			    /*
        				if (!isset($transactions[$other_user_id][$res_other_users_products[$k]["user_id_main"]])) {
        					$transactions[$other_user_id][$res_other_users_products[$k]["user_id_main"]] = $res_other_users_products[$k]["user_id_main"];
        				}
        				*/
        				if(!isset($product_ranking[$res_other_users_products[$k]["user_id_main"]])) {
        				    $product_ranking[$res_other_users_products[$k]["user_id_main"]] = 1;
        				}
        				else {
        				    $product_ranking[$res_other_users_products[$k]["user_id_main"]] ++;
        				}
        			}
    			}
    		}
    	}
	}
    /*
	$transactions_path = $DOCUMENT_ROOT . "/tmp/transactions_for_userranking.txt";
	if (is_file($transactions_path)) {
		unlink($transactions_path);
	}
	$fp = fopen($transactions_path, "w");
	reset($transactions);
	while (list($key, $val) = each($transactions)) {
		$transaction = implode(";", $val) . "\n";
		fwrite($fp, $transaction);
//		echo "[$transaction]<br>";
	}
	fclose($fp);
	$assoc_rules = new AssocRules($transactions_path);
	$assoc_rules->generateRules();
	*/
    
//	if (count($assoc_rules->Rules) > 0) {
	include("./include/userranking2db.inc.php");
	if(empty($_REQUEST['cron_mode']))
	   $stream->line_blue();
//	}
}

/*
if (empty($query)) {
	$query = "
	SELECT p.user_id_main AS prod_id, p.order_id AS order_id
	FROM order_products p, order_register o WHERE
	o.id = order_id AND (o.confirm_user = 1 OR o.confirm_online = 1)";

	$query = "
	SELECT user_id_main AS prod_id, order_id
	FROM order_products";
}

$transactions = array();
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
        	for ($i = 0; $i < $num_rows; $i++) {
            
            	// Odczytaj w³a¶ciwo¶ci transakcji i zapamiêtaj je w tablicy $transactions
            	$prod_id = $db->FetchResult($result,$i,"prod_id");
            	$order_id = $db->FetchResult($result,$i,"order_id");
            	$transactions[$order_id][] = $prod_id;
        	}
        }
    } else die ($db->Error());
} else die ($db->Error());
*/
// przepisz tablicê $transactions do pliku
?>