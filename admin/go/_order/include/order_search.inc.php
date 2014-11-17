<?php
/**
* Generuj SQL, zapytanie wyszukiwania transakcji
*
* @author  m@sote.pl
* @version $Id: order_search.inc.php,v 2.13 2005/04/01 07:04:17 maroslaw Exp $
* @package    order
*/

/**
* \@global string $sql
*/

/**
* Funkcja konwertuj±ca tekst male/wielkie litery. 
*/
require_once("include/upper_lower_name.inc");
/**
* Dodanie obs³ugi kodowania danych.
*/
require_once ("include/my_crypt.inc");
$my_crypt = new MyCrypt;

if (@$global_secure_test!=true) {
    die ("Forbidden");
}

if (ereg("^[0-9]+$",@$_REQUEST['pay_method'])) {
    $_REQUEST['form']['pay_method']=$_REQUEST['pay_method'];
    $_REQUEST['form']['and']=1;
}

// odczytaj parametry
if (! empty($_REQUEST['form'])) {
    $form=$_REQUEST['form'];
} else die ("Bledne wywolanie");

if (! empty($_REQUEST['from'])) $from=$_REQUEST['from'];
else $from=array("day"=>"00",
"month"=>"00",
"year"=>"0000");

if (! empty($_REQUEST['to'])) $to=$_REQUEST['to'];
else $to=array("day"=>date("d"),
"month"=>date("m"),
"year"=>(date("Y")+1)
);

if (strlen($from['month'])==1) $from['month']="0".$from['month'];
if (strlen($from['day'])==1) $from['day']="0".$from['day'];
if (strlen($to['month'])==1) $to['month']="0".$to['month'];
if (strlen($to['day'])==1) $to['day']="0".$to['day'];

$date_from=$from['year']."-".$from['month']."-".$from['day'];
$date_to=$to['year']."-".$to['month']."-".$to['day'];

// sprawdz spojnik [i|lub]
if (@$form['and']!=1) {
    $conjuction="OR";
} else {
    $conjuction="AND";
}

// czy sprawdzac date?
if (@$form['search_date']==1) {
    $search_date=1;
} else $search_date=0;

if (! empty($_REQUEST['form'])) {
    $form=$_REQUEST['form'];
}

$sql="SELECT * FROM order_register WHERE 1=1 AND record_version='30' ";

//$if=false;
if ($search_date==1) {
    $sql.=" $conjuction ((date_add>'$date_from' and date_add<'$date_to') or (date_add='$date_from') or (date_add='$date_to'))";
    $if=true;
}

// kwota od-do
if (! empty($form['amount_from'])) {
    $amount_from=$form['amount_from'];
    $amount_from=number_format($amount_from,2,".","");
}
if (! empty($form['amount_to'])) {
    $amount_to=$form['amount_to'];
    $amount_to=number_format($amount_to,2,".","");
}
if ((! empty($amount_from)) && (empty($amount_to))) {
    $sql.=" $conjuction total_amount>'$amount_from'";
    //    $if=true;
}
if ((empty($amount_from)) && (! empty($amount_to))) {
    $sql.=" $conjuction total_amount<'$amount_to'";
    //    $if=true;
}
if ((! empty($amount_from)) && (! empty($amount_to))) {
    $sql.=" $conjuction (total_amount>'$amount_from' and total_amount<$amount_to)";
    //    $if=true;
}

// rodzaj platnosci
if (! empty($form['pay_method'])) {
    $pay_method=$form['pay_method'];
    $sql.=" $conjuction id_pay_method='$pay_method'";
    //    $if=true;
}

// status
if (! empty($form['status'])) {
    $status=$form['status'];
    $sql.=" $conjuction id_status='$status'";
    //    $if=true;
}

// partner
if (! empty($form['partner'])) {
    $partner=$form['partner'];     
    $sql.=" $conjuction partner_name='$partner'";
//    $if=true;
}

// potwierdzenie zaplaty
if ((! empty($form['confirm'])) || (@$form['confirm']=="0")) {
    $confirm=$form['confirm'];
    $sql.=" $conjuction confirm=$confirm";
    //    $if=true;
}

// numer transakcji
$form['order_id'] = (int)trim(@$form['order_id']);
if (! empty($form['order_id']))  {
    $order_id=$form['order_id'];
    $sql.=" $conjuction order_id=$order_id";
}

if (! empty($form['fraud_attention'])) {
    $sql.=" $conjuction (";
    reset($config->pay_fraud);
    while (list($key,$val) = each($config->pay_fraud)) {
        if (! $val) {
            $sql.=" fraud = $key OR";
        }
    } // end while
    $sql=substr($sql,0,strlen($sql)-3);
    $sql.=")";
} // end if

?>
