<?php

global $mdbd, $config;
// aktualizacja punktów
$data=$mdbd->select("points,id_users,confirm,cancel","order_register","order_id=".$dat['order_id']);

if ($data['points']=="1") {
	$points_value=$mdbd->select('points','users_points_history','order_id=?',array($dat['order_id']=>"int"),"LIMIT 1");
	// pobieramy aktualny stan punktów klienta
	$points_state=$mdbd->select('points,points_reserved','users_points','id_user=?',array($data['id_users']=>"int"));
	if ($data['confirm']!=1 && $data['cancel']!=1) {
		// pomniejszamy liczbe punktów zarezerwowanych o warto¶æ tego zamówienia
		$points_reserved_current=$points_state['points_reserved']-$points_value;
	} else $points_reserved_current="-";
	// zwiêkszamy liczbe punktów w³a¶ciwych o warto¶æ tego zamówienia
	$points_current=$points_state['points']+$points_value;
	require_once("include/points.inc");
	$points=&new Points();
	// zapisujemy dane
	$points->add_points($data['id_users'],$points_current,"$points_reserved_current");
	$points->add_history($data['id_users'],$points_value,"add",$lang->points['cancel'],$dat['order_id']);
}
// aktualizacja punktów - koniec

$mdbd->update("order_register", "confirm=0, cancel=1", "id=?", array($id => "int"));

// aktualizacja magazynu
if(
    (@$config->depository['return_on_cancel'] == 1) &&
    (
        (($before_confirm == 1) && (@$config->depository['update_num_on_action'] == 'on_paid')) ||
        (@$config->depository['update_num_on_action'] == 'on_take_order')
    )
    
  ) { // przywróæ produkty do magazynu
    $res_available = $mdbd->select("user_id,num_from,num_to", "available", "1=1", array(), '', 'array');

    $res2 = $mdbd->select("user_id_main,num", "order_products", "order_id=" . $order_id_users, array(), '', 'array');
    if(is_array($res2) && (count($res2 > 0))) {
        reset($res2);
        for ($i = 0; $i < count($res2); $i++) {
            $user_id_main = $res2[$i]['user_id_main'];
            $num = $res2[$i]['num'];
            /**/
            $res = $mdbd->select("num,min_num,id", "depository", "user_id_main=?", array($user_id_main => 'text'), '', 'array');
            
            if(is_array($res) && (count($res) == 1)) {
                $base_num = $res[0]['num'];
                $res_num = $base_num + $num;
                $res_num_positive = $res_num;
                if($res_num_positive < 0)
                    $res_num_positive = 0;
                    
                $mdbd->update("depository", "num=$res_num", "user_id_main=?", array($user_id_main => 'text')); // update depository

                
                if(!empty($res_available)) {
                    $av_id = 0;
                    reset($res_available);
                    while (($av_id == 0) && (list($key, $val) = each($res_available))) {
                        $a = $val['user_id'];
                        $from = $val['num_from'];
                        $to = $val['num_to'];
                        if($to != '*') {
                            if (($from <= $res_num_positive) && ($res_num_positive <= $to)) {
                                $av_id = $a;
                            }
                        }
                        else {
                            $last_id = $a;
                        }
                    }
                    if($av_id == 0) {
                        $av_id = $last_id;
                    }
                    $mdbd->update("main","id_available=$av_id", "user_id=?", array($user_id_main => "text"));
                }
            }
        }
    }
}
// aktualizacja magazynu - koniec
?>