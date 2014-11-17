<?php
/**
 * Dodaj nowego dostawce
 * @return int $id
 */

global $_REQUEST;
if ($global_secure_test!=true) die ("Bledne wywolanie");

$price=array();
if(!empty($_REQUEST["delivery_price"]) && !empty($_REQUEST["delivery_set"])) {
	foreach($_REQUEST["delivery_price"] as $key=>$value) {
		if(array_key_exists($key,$_REQUEST["delivery_set"])) {
			$price=$price+array($key=>$value);
		}
	}
} else {
	$price="";
}	
$rec->data['delivery_zone']=serialize($price);

$pay=array();
if(!empty($_REQUEST["delivery_pay"])) {
	foreach($_REQUEST["delivery_pay"] as $key=>$value) {
		if($value) {
			$pay=$pay+array($key=>$value);
		}	
	}
} else {
	$pay="";
}	
$rec->data['delivery_pay']=serialize($pay);

if(empty($delivery['order_by']))
    $delivery['order_by'] = 0;
// dodaj dostawce
// odczytaj numer id dodanego dostawcy
$query="INSERT INTO delivery (name,order_by,price_brutto,vat,free_from,delivery_info,delivery_zone,delivery_pay) VALUES (?,?,?,?,?,?,?,?)";
//print $query;
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$delivery['name']);
    $db->QuerySetInteger($prepared_query,2,$delivery['order_by']);
    $db->QuerySetText($prepared_query,3,$delivery['price_brutto']);
    $db->QuerySetInteger($prepared_query,4,$delivery['vat']);
    $db->QuerySetFloat($prepared_query,5,$delivery['free_from']);
    $db->QuerySetText($prepared_query,6,$delivery['delivery_info']);
    $db->QuerySetText($prepared_query,7,$rec->data['delivery_zone']);
    $db->QuerySetText($prepared_query,8,$rec->data['delivery_pay']);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {        
        // odczytaj numer id dodanego rekordu
        $query="SELECT max(id) FROM delivery";
        $result_id=$db->Query($query);
        if ($result_id!=0) {
            $insert_info=$lang->record_add;
            $num_rows=$db->NumberOfRows($result_id);
            if ($num_rows>0) {
                $var=$config->dbtype."_maxid";
                $id=$db->FetchResult($result_id,0,$config->$var);
            } else die ("Bledne dodanie rekordu");
        } else die ($db->Error());        
    } else die ($db->Error());
} else die ($db->Error());
?>