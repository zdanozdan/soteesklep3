<?php


global $_REQUEST;
if ($global_secure_test!=true) die ("Bledne wywolanie");

$price=array();

if(!empty($_REQUEST["delivery_set"])) {
	foreach($_REQUEST["delivery_price"] as $key=>$value) {
		if(array_key_exists($key,$_REQUEST["delivery_set"])) {
			$price=$price+array($key=>$value);
		}
	}
}	
		
$delivery_zone=serialize($price);
$rec->data['delivery_zone']=$delivery_zone;

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
$delivery_pay=serialize($pay);
$rec->data['delivery_pay']=serialize($pay);


$query="UPDATE delivery SET name=?, order_by=?, price_brutto=?, vat=?, free_from=?, delivery_info=? , delivery_zone=? , delivery_pay=? WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetText($prepared_query,1,$delivery['name']);
    $db->QuerySetText($prepared_query,2,$delivery['order_by']);
    $db->QuerySetText($prepared_query,3,$delivery['price_brutto']);
    $db->QuerySetText($prepared_query,4,$delivery['vat']);
    $db->QuerySetText($prepared_query,5,$delivery['free_from']);
    $db->QuerySetText($prepared_query,6,$delivery['delivery_info']);
    $db->QuerySetText($prepared_query,7,$delivery_zone);
    $db->QuerySetText($prepared_query,8,$delivery_pay);
    
    $db->QuerySetText($prepared_query,9,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $update_info=$lang->edit_update_ok;
    } else die ($db->Error());
} else die ($db->Error());

?>