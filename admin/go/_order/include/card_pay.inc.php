<?php
if ($rec->data['id_pay_method']==110) {
	require_once("include/rsa_crypt.inc");
	$keyhandler=& new KeyHandler();
	global $mdbd;
	if (@$confirm=="tak") {
		$card_id=$mdbd->select('id_card_pay','order_register','id=?',array(@$id=>'int'));
		if ($card_id!='0') {
			$deleted=$keyhandler->encrypt("-");
			$empty1=$keyhandler->encrypt("----");
			$empty2=$keyhandler->encrypt("---");
			$temp=array("$deleted"=>'text', "$empty1"=>'text', "$empty2"=>'text', "$card_id" => 'int');
			$data=$mdbd->update('card_pay','card=?, valid_to=?, cvv=?','id=?', $temp);
		}
	}
	if ($rec->data['id_pay_method']==110) {
		$data=$mdbd->select('card,valid_to,cvv','card_pay','id=?',array($rec->data['id_card_pay'] => "int"));
		$rec->data['card']['card']=$keyhandler->decrypt($data['card']);
		if ($rec->data['card']['card']=='-') {
			$rec->data['card']['card']=$lang->card['record_deleted'];
		}
		$rec->data['card']['valid_to']=$keyhandler->decrypt($data['valid_to']);
		$rec->data['card']['cvv']=$keyhandler->decrypt($data['cvv']);
	}
}
?>