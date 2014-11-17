<?php
/**
 * Dodawanie adresu e-mail klienta do bazy newslettera, po zlozeniu zamowienia, badz zarejestrowaniu.
 * 
 * @author krzys@sote.pl
 * @package include
 */


function add_2_newsletter($email,$date_add,$status,$active,$email_md5,$groups,$lang){
global $db,$config;
	
	$email_md5=md5($email.$config->salt);

	$query="SELECT id FROM newsletter WHERE md5=?";
	$prepared_query=$db->PrepareQuery($query);
	if ($prepared_query){
		$db->QuerySetText($prepared_query,1,$email_md5);
		$result=$db->ExecuteQuery($prepared_query);
		$num_rows=$db->NumberOfRows($result);
		if ($num_rows==0) {
		$query="INSERT INTO newsletter (email,date_add,status,active,md5,groups,lang)
				VALUES (?,?,?,?,?,?,?)";
		$prepared_query=$db->PrepareQuery($query);
			if ($prepared_query) {
				$db->QuerySetText($prepared_query,1,$email);
				$db->QuerySetText($prepared_query,2,$date_add);
				$db->QuerySetText($prepared_query,3,$status);
				$db->QuerySetText($prepared_query,4,$active);
				$db->QuerySetText($prepared_query,5,$email_md5);
				$db->QuerySetText($prepared_query,6,$groups);
				$db->QuerySetText($prepared_query,7,$lang);
				$result=$db->ExecuteQuery($prepared_query);
				if ($result==0) {
					die ($db->Error());
				}
			} else {
				die ($db->Error());

			}
		}
	}
}

?>
