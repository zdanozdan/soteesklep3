<?php
/**
* Zapisz transakcje w bazie danych
*
* \@session int $order_id
* \@session string $order_id_date
* \@session int $global_id_pay_method numer id rodzaju platbosci 1- zalicznie, 2 - eCard, 3 - PolCard
* \@session string $global_pay_name nzwa metody platnosci
*
* @author  m@sote.pl
* @version $Id: order_register.inc.php,v 2.18 2006/06/29 14:23:07 lukasz Exp $
* @package    register
*/

if (@$global_secure_test!=true) {
    die ("Forbidden");
}

/**
* Dodaj dodatkow± obs³ugê Metabase.
*/
global $database;
require_once ("include/metabase.inc");

/**
* Dodaj klasê obs³ugi transakcji.
*/
require_once ("include/order/order.inc");
$ord_reg =& new OrderRegister;

// dodaj transakcje do bazy, generuj numer transakcji
if (! $ord_reg->getOrderID()) {
    $ord_reg->insert();
    
} else {    
    // aktualizuj id_pay_method, na wypadek, gdyby uzytlownik np. wybral platnsoc karta
    // nie dokonczyl platnosci i pozniej wybral inna forme zaplaty
    
    // sprawdz czy uzytkownik nie wybral wczesniej platnosci karta kredytowa
    $my_order_id=$ord_reg->getOrderID();
    
    // odczytaj, czy wczesniej nie bylo zdefinowanej metody platnosci
    // (np. kleint nie dokonczyl autoryzacji karte itp.)
    $prev_id_pay_method=$database->sql_select("id_pay_method","order_register","order_id=$my_order_id");
    
    // przekaz zmienna do pliku _post/index.php
    // sprawdz czy klient zmienil metode platnosci
    if (($prev_id_pay_method!=$global_id_pay_method) && ($prev_id_pay_method>1)) {
        $__check=1;
    } else $__check=0;
	if (empty($_SESSION['order_session'])) {
		$_SESSION['order_session']=$sess->id;
	} else {
		$_SESSION['order_session']=md5(time());
	}    
    $ord_reg->update($ord_reg->getOrderID());  
} 

// zapisz wybrana forme platnosci
$sess->register("global_id_pay_method",$global_id_pay_method);
$global_pay_name=$config->pay_method[$global_id_pay_method];
$sess->register("global_pay_name",$global_pay_name);

// wstaw numer order_id do zalaczonych zdjec, o ile opcja taka jest dostepna w sklepie
if ($config->basket_photo==true) {
    require_once("./include/basket_photo_update.inc.php");
}
?>
