<?php

global $mdbd;
if ($rec->data['points']) {
	$points_value=$mdbd->select('points','users_points_history','order_id=?',array($rec->data['order_id']=>"int"),"LIMIT 1");
	$rec->data['points_value']=$points_value;
}
/*
if ($_POST['order']['confirm'] && $_POST['order']['points']) {
	require_once("include/points.inc");
	$points=&new Points();
	$points_state=$mdbd->select('points,points_reserved','users_points','id_user=?',array($rec->data['id_users']=>"int"));
	$points_reserved_current=$points_state['points_reserved']-$rec->data['points_value'];
	$points->add_points($rec->data['id_users'],$points_state['points'],"$points_reserved_current");
	$mdbd->update('order_register','points=?','order_id=?',array("0"=>"int",$rec->data['order_id']=>"int"));
	$rec->data['points']=0;
}*/
?>