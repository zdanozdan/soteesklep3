<?php
/**
 * Dodaj informacjê o punktach do sesji, je¶li podany kod jest prawid³owy.
 *
 * @author krzys@sote.pl
 *
 * @package    info
 */
global $sess;

/**
* Odczytaj login klienta polecajacego produkt 
*
* @return array user_id= login klienta 
*/

function read_recom_code() {
	global $db;
	global $_REQUEST;
	require_once ("include/my_crypt.inc");

	$query="SELECT recom_code FROM order_register WHERE recom_code=?";
	$prepared_query=$db->PrepareQuery($query);
	$db->QuerySetText($prepared_query,1,$_REQUEST['recom_code']);
	if ($prepared_query) {
		$result=$db->ExecuteQuery($prepared_query);
		if ($result!=0) {
			$num_rows=$db->NumberOfRows($result);
			if ($num_rows>0) {
				return 0;
			}else{
				return 1;	
			}
		} else die ($db->Error());
	} else die ($db->Error());
    return;
    
} // end read_recom_code()

if (! empty($_REQUEST['recom_code']) && ! empty($_REQUEST['recom_product']) && ! empty($_REQUEST['recom_user']) && ! empty($_REQUEST['recom_t']) ){
@$recom=array('recom_code'=>$_REQUEST['recom_code'],
			  'recom_product'=>$_REQUEST['recom_product'],
			  'recom_user'=>$_REQUEST['recom_user'],
			  'recom_t'=>$_REQUEST['recom_t'],
			  );
			  
$key="soteszyfr";

$recomm_string=$recom['recom_user'].$recom['recom_product'].$recom['recom_t'].$key;
$recomm_string_crypt=md5($recomm_string);

if (($recomm_string_crypt==$recom['recom_code'])&&(read_recom_code()==1)){		  

	$sess->register('recom',$recom);  
 }
}

?>