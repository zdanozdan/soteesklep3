<?php
/**
* Aktualizuj dane transakcji
*
* @author  m@sote.pl
* @version $Id: order_update.inc.php,v 2.42 2006/05/15 11:56:06 lukasz Exp $
* @package    order
*/

/**
* \@global int   $id id transakcji
* \@global float $__total_amount kwota zamówienia wg. tabeli order_products
*/

if (@$global_secure_test!=true) {
    die ("Forbidden");
}

/**
* Dodaj klasê zawieraj±ca funkcje obliczania sumy kontrolnej.
*/
require_once ("include/order/checksum.inc");

// pobieram aktualna date
$date=date("Y-m-d");

if (! empty($_POST['order'])) {
    $order=$_POST['order'];
} else die ("Forbidden: Order ID");


if (@$order['confirm']=='confirm') {
    $confirm=1;
}
else
$confirm=0;

if (@$order['confirm']=='cancel') {
    $cancel = 1;
}
else
$cancel = 0;


if (@$order['confirm_user']==1) $confirm_user=1;
else $confirm_user=0;

if (! empty($order['description'])) {
    $description=$order['description'];
}
if (! empty($order['send_date'])) {
    if (ereg ("^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$",$order['send_date'])) {
        $send_date=$order['send_date'];
    } else {
        $send_date=$date;
    }
} else {
    $send_date=$date;
}

if (! empty($order['send_number'])) {
    $send_number=$order['send_number'];
}

if (@$order['send_confirm']==1) $send_confirm=1;
else $send_confirm=0;

if (empty($order['onet'])) {
    $onet=0;
} else {
    $onet=$order['onet'];
}

@$info_for_client=(@$_POST['info_for_client']);

// odczytaj status nadawany transakcji partnera
if (! empty($order['confirm_partner'])) {
    $confirm_partner=$order['confirm_partner'];
} else $confirm_partner=0;

// start set pay_status:
$pay_status='';
if (! empty($order['pay_status'])) {
    if (ereg("^[0-9]+$",$order['pay_status'])) {
        $pay_status=$order['pay_status'];
    }
}
// end set pay_status:

// start amount_confirm: - kwota rozliczenia modyfikowana przez sprzedawce
$amount_confirm=0;
if (! empty($order['amount_confirm'])) {
    if ($order['amount_confirm']>0) {
        $amount_confirm=$order['amount_confirm'];
        $amount_confirm=ereg_replace(",",".",$amount_confirm);
        $amount_confirm=$theme->price($amount_confirm);
    }
}
// end amount_confirm:
// odczytaj jaki jest teraz status transakcji, czy jest zaplacona
// musimy wieziec, ajki status byl wczesniej, gdyz w ten sposob mozemy
// dowiedziec sie czy uzytwkonik zmienil status platnosci;
// na podstawie tej informacji bedziemy pozniej dodawac lub odejmowac pubkty dla uzytkownika
$query="SELECT confirm,cancel,confirm_user,amount,delivery_cost,pay_status FROM order_register WHERE id=?";
$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query,1,$id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        $num_rows=$db->NumberOfRows($result);
        if ($num_rows>0) {
            $before_confirm=$db->FetchResult($result,0,"confirm");
            $before_cancel=$db->FetchResult($result,0,"cancel");
            $before_amount=$db->FetchResult($result,0,"amount");
            $before_delivery_cost=$db->FetchResult($result,0,"delivery_cost");
            $pay_status=$db->FetchResult($result,0,"pay_status");
            $confirm_user_prev = $db->FetchResult($result,0,"confirm_user");
            $pay_status_prev = $pay_status;
            if (! empty($pay_status_new)) {
                $pay_status=$pay_status_new;
            }
        } else exit;
    } else die ($db->Error());
} else die ($db->Error());

if ((($confirm == 0) && ($cancel == 0) && ($before_cancel + $before_confirm > 0)) || (($confirm == 1) && ($cancel == 1))) {
    $confirm = $before_confirm;
    $cancel = $before_cancel;
}

$dat=$mdbd->select("amount,order_id","order_register","id=?",array($id=>"int"),"LIMIT 1");
$order_id_users = $dat['order_id'];

if(($confirm == 1) && ($before_confirm != $confirm)) {
    include_once("./include/order_confirm.inc.php");
}
if(($cancel == 1) && ($before_cancel != $cancel)) {
    include_once("./include/order_cancel.inc.php");
}
// sprawdz czy kwota rozliczenia nie jest wyzsza od kwoty transakcji, oraz sprawdz zakres kwoty rozliczenia
if ($amount_confirm>($before_amount+$before_delivery_cost)) {
    $amount_confirm=$before_amount+$before_delivery_cost;
} elseif ($amount_confirm<0) $amount_confirm=0;

// start checksum:
$checksum=OrderChecksum::checksum($dat['order_id'],$confirm,$dat['amount']);
// end checksum:

$query="UPDATE order_register SET id_status=?, confirm_partner=?, confirm_user=?,
            description=?, send_date=?, send_number=?, send_confirm=?, pay_status=?, 
            amount_confirm=?, checksum=?, 
            total_amount=?,  confirm_partner=?, info_for_client=?
        WHERE id=?";

$prepared_query=$db->PrepareQuery($query);
if ($prepared_query) {
    $db->QuerySetInteger($prepared_query, 1, $order['status']);
    $db->QuerySetInteger($prepared_query, 2, $confirm_partner);
    $db->QuerySetInteger($prepared_query, 3, $confirm_user);
    $db->QuerySetText(   $prepared_query, 4, @$description);
    $db->QuerySetText(   $prepared_query, 5, @$send_date);
    $db->QuerySetText(   $prepared_query, 6, @$send_number);
    $db->QuerySetInteger($prepared_query, 7, $send_confirm);
    $db->QuerySetText(   $prepared_query, 8, $pay_status);
    $db->QuerySetFloat(  $prepared_query, 9, $amount_confirm);
    $db->QuerySetText(   $prepared_query,10, $checksum);
    $db->QuerySetText(   $prepared_query,11, $__total_amount);
    $db->QuerySetText(   $prepared_query,12, @$order['confirm_partner']);
    $db->QuerySetText(   $prepared_query,13, @$info_for_client);
    $db->QuerySetInteger($prepared_query,14, $id);
    $result=$db->ExecuteQuery($prepared_query);
    if ($result!=0) {
        // dane zostaly poprawnie zaktualizowane
        // wyslij info do klienta, je¶li dany status transakcji ma zaznaczon± odpowiedni± opcjê
        // i je¶li sprzedawca nie wy³±czy³ dla tej transakcji (status_unlock) wysy³ania potwierdzenia
        /* Obs³uga statusów */
        if (@$order['status_unlock']==1) {
            require_once ("./include/status.inc.php");
            $o_status =& new OrderStatus;
            if ($o_status->send($dat['order_id'],$order)) {
                print $lang->order_status_sent;
            }
        } else {
            print $lang->order_status_lock_info;
        }
    } else die ($db->Error());
} else die ($db->Error());
// odczytaj kwote zakupow i id uzytwkonika, ktory dokonal zakupow i uzytkownika, ktory polecil produkt
$amount=0;$id_user='';
if ((! empty($config_points->for_product))  && ($config_points->for_product>0)) {
    // odczytaj kwote zakupow
    if (empty($id)) $id='0';
    $query="SELECT amount,id_users,recom_id_user FROM order_register WHERE id=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$id);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                $amount=$db->FetchResult($result,0,"amount");
                $id_user=$db->FetchResult($result,0,"id_users");
                $recom_id_user=$db->FetchResult($result,0,"recom_id_user");
            } else {
            	$amount=0;
            	$id_user=0;
            	$recom_id_user=0;
            }
        } else die ($db->Error());
    } else die ($db->Error());

    // odczytaj obecna liczbe punktow
    $query="SELECT points FROM users_points WHERE id_user=?";
    $prepared_query=$db->PrepareQuery($query);
    if ($prepared_query) {
        $db->QuerySetInteger($prepared_query,1,$id_user);
        $result=$db->ExecuteQuery($prepared_query);
        if ($result!=0) {
            $num_rows=$db->NumberOfRows($result);
            if ($num_rows>0) {
                $current_points=$db->FetchResult($result,0,"points");
            }
        } else die ($db->Error());
    } else die ($db->Error());
    // odczytaj liczbe punktow klienta polecaj±cego
    if ($recom_id_user!=0) {
        // odczytaj obecna liczbe punktow
        $query="SELECT points FROM users_points WHERE id_user=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetInteger($prepared_query,1,$recom_id_user);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $recom_id_points=$db->FetchResult($result,0,"points");
                }
    
            } else die ($db->Error());
        } else die ($db->Error());
    }
}
// sprawdz czy uzytkownik zmienil status platnosci
if (empty($current_points)) {
    $current_points=0;
}

// modyfikacje r@sote.pl
global $var_points;
// oblicznie warto¶ci zamówienia na punkty
if($config_points->for_type == 2) {
    // punkty naliczne na podstawie wartosci punktowych produktow
    // funkcja sum_points jest w pliku order_func.inc.php
    $var_points=sum_points();
    // modyfikacje tomasz@mikran.pl 05/09/2006
    // od naliczonych punktów chcemy odj±æ rabat dla danego klienta, ¿eby nie dosta³ ich za du¿o
    // w mikran.pl ilosc punktów towaru = jego cena
    // zahardcodowane w oddzielnej funckji
    $var_points=check_apply_points_discount($var_points);
} else {
    // punkty naliczne na sume zamówienia
    if ((! empty($amount)) && ($amount>0)){
        $var_points=intval(($amount/100)*$config_points->for_product);
    }
}

// punkty dla zarejestrowanego uzywkownika kupujacego
if ($id_user>0 && $config_points->for_product>0 && $before_confirm!=$confirm){
    require_once ("include/points.inc");
    $add=new Points();
    // zmien punkty, sprawdz czy uzytkwonik anulowal czy potwierdzil platnosc
    if ($confirm==1) {
        // oblicznie punktow (dodawanie)
        $new_points=$current_points+$var_points;
        if ($var_points!=0) {
            // dodanie historii punktow
            $add->add_history($id_user,$var_points,"add","product",$order_id);
            // weryfikacja punktow (dodawanie)
            $add->add_points($id_user,$new_points);
        }
    }else{
        //obliczanie punktow (odejmowanie)
        $new_points=$current_points-$var_points;
        if ($new_points<0) $new_points=0;
        // dodanie historii
        if ($var_points!=0) {
            $add->add_history($id_user,$var_points,"decrease","product",$order_id);
            // weryfikacja punktow (odejmowanie)
            $add->add_points($id_user,$new_points);
        }
    }
    // modyfikacje tomasz@mikran.pl 05/09/2006
    // dodanie naliczania punktów za sposób zap³aty (hardcoded ale w oddzielnym pliku)
    require_once ("./include/points_for_payment_method.inc.php");
}
// punkty dla uzytkownika polecajego
if ((!empty($recom_id_user)) && $config_points->for_recommend>0 && $before_confirm!=$confirm && empty($order['points']) && ($recom_id_user!=$id_user)){
    require_once ("include/points.inc");
    $add=new Points();
    // zmien punkty, sprawdz czy uzytkwonik anulowal czy potwierdzil platnosc
    if ($confirm==1) {
        // oblicznie punktow (dodanie)
        $new_points_recom=$recom_id_points+$config_points->for_recommend;
        // dodanie historii punktow
        $add->add_history($recom_id_user,$config_points->for_recommend,"add","recommend");
        // werfikacja punktow (dodanie)
        $add->add_points($recom_id_user,$new_points_recom);
    }else{
        // oblicznie punktow (odejmowanie)
        $new_points_recom=$recom_id_points-$config_points->for_recommend;
        if ($new_points_recom<0) $new_points_recom=0;
        // dodanie historii punktow
        $add->add_history($recom_id_user,$config_points->for_recommend,"decrease","recommend");
        // weryfikacja punktow (odejmowanie)
        $add->add_points($recom_id_user,$new_points_recom);
    }

}

// aktualizacja magazynu
if (
(@$config->depository['update_num_on_action'] == 'on_confirm') &&
($confirm_user_prev != $confirm_user) &&
($confirm_user == 1)
) { // zdejmij produkty z magazynu

$res_available = $mdbd->select("user_id,num_from,num_to", "available", "1=1", array(), '', 'array');

$res2 = $mdbd->select("user_id_main,num", "order_products", "order_id=" . $dat['order_id'], array(), '', 'array');
if(is_array($res2) && (count($res2 > 0))) {
    reset($res2);
    for ($i = 0; $i < count($res2); $i++) {
        $user_id_main = $res2[$i]['user_id_main'];
        $num = $res2[$i]['num'];
        /**/
        $res = $mdbd->select("num,min_num,id", "depository", "user_id_main=?", array($user_id_main => 'text'), '', 'array');

        if(is_array($res) && (count($res) == 1)) {
            $base_num = $res[0]['num'];
            $res_num = $base_num - $num;
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
        /**/
    }
}
}

//>>>>>>> 2.29
/*
//  odejmujemy punkty (zmiana transakcji potwierdzonej na niepotwierdzona)
if ($new_points<0) $new_points=0;
if ($new_points_recom<0) $new_points_recom=0;

*/
// aktualizacja transakcji w zaleznosci od systemu platynosci
$id_pay_method=@$_REQUEST['order']['id_pay_method'];
$file=$DOCUMENT_ROOT."/go/_order/include/pay_method_class/pm_".$id_pay_method.".inc.php";
if (file_exists($file)) {
    require_once ("./include/pay_method_class/pm_".$id_pay_method.".inc.php");
    $pay_method->update($id);
}
?>
