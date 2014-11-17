<?php
/**
 * Klasa do potwierdzen platnosci w tle z serwisu allpay
 *
 */


define ("ALLPAY_SERVER","217.17.41.5");

class AllpayOnline {

    /**
	 * Konstruktor klasy
	 *
	 * @return AllpayOnline
	 */
    function AllpayOnline() {
        global $database, $db;
        ob_start();
        if($this->checkParam()) {
            if($this->prepareData2()) {
                $database->sql_insert("allpay_trans",array("status"=>"OK","order_id"=>$_REQUEST['description']));
                print "OK";
            } else {
                $database->sql_insert("allpay_trans",array("status"=>"ERROR","order_id"=>$_REQUEST['description']));
                print "ERROR";
            }
        }
//        $query="INSERT INTO log (order_id, message) VALUES ('".$_REQUEST['description']."','".ob_get_contents()."')";
//        $db->Query($query);
        ob_flush();

    } // end func AllpayOnline

    /**
	 * Zapisz parametry do bazy danych
	 *
	 */
    function checkParam()
    {
        global $_REQUEST;
        global $database;
        global $mdbd;
        foreach($_REQUEST as $key=>$value) {
            $_REQUEST[$key]= addslashes($_REQUEST[$key]);
        }
        $database->sql_insert("allpay_trans",$_REQUEST);
        $session=$mdbd->select('data','order_session',"order_id='".$_REQUEST['description']."'");
        if (!empty($session)) {
            $_SESSION=unserialize($session);
            // zapalamy flage
            global $session_restored;
            $session_restored=true;
        }
        return true;
    } // end func checkParam

    function server() {
        if ($_SERVER['REMOTE_ADDR']==ALLPAY_SERVER) {
            return true;
        }
        return false;
    }
    function prepareData2() {
        global $db, $allpay_config, $config, $database, $mdbd, $DOCUMENT_ROOT;
        $data=$database->sql_select_multi_array4("*","order_register","order_id=".$_REQUEST['description']);
        if (!is_array($data)) return true;
        $amount=$data[0]['amount']+$data[0]['delivery_cost'];
        if(!preg_match("/\./",$amount)) {
            $amount=$amount.".00";
        }
        if(preg_match("/\.[0-9]$/",$amount)) {
            $amount=$amount."0";
        }
        $md5=md5(
            @$allpay_config->allpay_pin.":".
            $allpay_config->allpay_id.":".
            $_REQUEST['control'].":".
            $_REQUEST['t_id'].":".
            $amount.":".
            $_REQUEST['email'].":".
            @$_REQUEST['service'].":".
            @$_REQUEST['code'].":".
            @$_REQUEST['username'].":".
            @$_REQUEST['password'].":".
            $_REQUEST['t_status']
        );
        $database->sql_insert("allpay_trans",array(
            "control"=>@$_REQUEST['control'],
            "t_id"=>@$_REQUEST['t_id'],
            "order_id"=>@$_REQUEST['description'],
            "amount"=>$amount,
            "email"=>@$_REQUEST['email'],
            "service"=>@$_REQUEST['service'],
            "code"=>@$_REQUEST['code'],
            "username"=>@$_REQUEST['username'],
            "password"=>@$_REQUEST['password'],
            "t_status"=>$_REQUEST['t_status'],
            "md5"=>$md5,
            "md5_req"=>$_REQUEST['md5'],
            "orginal_amount"=>$_REQUEST['amount'],
            "remote_addres"=>$_SERVER["REMOTE_ADDR"]
            )
        );
        // wylaczyc do testow - nie beda sprawdzane parametry posta i bedzie mozna wchodzic przez przegladarke zeby akceptowac transakcje
        if ($md5!=@$_REQUEST['md5'] || !$this->server()) {
            return false;
        }
        switch ($_REQUEST['t_status']) {
            case 0:
            // koniec powiadomien
            return true;
            break;
            case 1:
            // nowa
            return true;
            break;
            case 2:
            // ok
            // wlaczanie mozliwosci wielokrotnego akceptowania transakcji
//            if (true) {
            if ($data[0]['confirm_online']!=1) {
                global $auto_transaction;
                $auto_transaction=true;
                global $__secure_test;
                $__secure_test=1;
               
                require_once ("include/order_register.inc");
                $amount_all=number_format(($data[0]['amount']+$data[0]['delivery_cost']),2,".","");
                $order_id=$_REQUEST['description'];
                $my_checksum=OrderRegisterChecksum::checksum($_REQUEST['description'],1,$amount_all);
                $database->sql_update("order_register","order_id=".$_REQUEST['description'],array(
                "confirm_online"=>"1",
                "confirm"=>"1",
                "pay_status"=>"001",
                "checksum_online"=>$my_checksum,
                )
                );
                 include_once("$DOCUMENT_ROOT/go/_register/include/send_order.inc.php");
                if (in_array("main_keys",$config->plugins)) {
                    require_once ("go/_register/include/main_keys.inc.php");
                    $main_keys = new MainKeys;
                    $main_keys->show();
                }
            }
            return true;
            break;
            case 3:
            // odmowa
            require_once ("include/order_register.inc");
            $my_checksum=OrderRegisterChecksum::checksum($_REQUEST['description'],0,$data[0]['amount']);
            $database->sql_update("order_register","order_id=".$_REQUEST['description'],array(
            "confirm_online"=>"0",
            "confirm"=>"0",
            "pay_status"=>"003",
            "checksum_online"=>$my_checksum,
            )
            );
            return true;
            break;
            case 4:
            // anulowana/zwrot
            require_once ("include/order_register.inc");
            $my_checksum=OrderRegisterChecksum::checksum($_REQUEST['description'],0,$data[0]['amount']);
            $database->sql_update("order_register","order_id=".$_REQUEST['description'],array(
            "confirm_online"=>"0",
            "confirm"=>"0",
            "pay_status"=>"004",
            "checksum_online"=>$my_checksum,
            )
            );
            return true;
            break;
            case 5:
            // reklamacja
            require_once ("include/order_register.inc");
            $my_checksum=OrderRegisterChecksum::checksum($_REQUEST['description'],0,$data[0]['amount']);
            $database->sql_update("order_register","order_id=".$_REQUEST['description'],array(
            "confirm_online"=>"0",
            "confirm"=>"0",
            "pay_status"=>"005",
            "checksum_online"=>$my_checksum,
            )
            );
            return true;
            break;
            default:
            return false;
            break;
        }
        return;
    }
    /**
     * Sprawdz trenaskacje
     *
     */
    function prepareData()
    {
        ob_start();
        global $database;
        global $allpay_config;
        global $DOCUMENT_ROOT;
        global $config;
        global $mdbd;
        $data=$database->sql_select_multi_array4("*","order_register","order_id=".$_REQUEST['description']);

        $amount=$data[0]['amount']+$data[0]['delivery_cost'];
        if(!preg_match("/\./")) {
            $amount=$amount.".00";
        }

        //$md5=md5(":10045:b03337e6e90a9dc291d528d113cdf3c3:10045-P12:70:fsd@fsdfsd.pl:::::1");
        $md5=md5(
        @$allpay_config->allpay_pin.":".
        $allpay_config->allpay_id.":".
        $_REQUEST['control'].":".
        $_REQUEST['t_id'].":".
        $amount.":".
        $_REQUEST['email'].":".
        @$_REQUEST['service'].":".
        @$_REQUEST['code'].":".
        @$_REQUEST['username'].":".
        @$_REQUEST['password'].":".
        $_REQUEST['t_status']
        );

        $database->sql_insert("allpay_trans",array(
        "control"=>@$_REQUEST['control'],
        "t_id"=>@$_REQUEST['t_id'],
        "order_id"=>@$_REQUEST['description'],
        "amount"=>$amount,
        "email"=>@$_REQUEST['email'],
        "service"=>@$_REQUEST['service'],
        "code"=>@$_REQUEST['code'],
        "username"=>@$_REQUEST['username'],
        "password"=>@$_REQUEST['password'],
        "t_status"=>$_REQUEST['t_status'],
        "md5"=>$md5,
        "md5_req"=>$_REQUEST['md5'],
        "orginal_amount"=>$_REQUEST['amount'],
        "remote_addres"=>$_SERVER["REMOTE_ADDR"]
        )
        );
        if ($data[0]['confirm_online']==1) return;
        // transakcja nowa lub odmowna
        $mdbd->insert("log","order_id,message",array(
        @$_REQUEST['description']=>"text",
        print_r($_REQUEST,1)=>"text",
        )
        );
        if($md5 == $_REQUEST['md5'] && ($_REQUEST['t_status'] == 1 || $_REQUEST['t_status'] == 3) && $_SERVER["REMOTE_ADDR"] == ALLPAY_SERVER) {
            return true;
        }
        // potwierdzenie trasakcji
        if($md5 == $_REQUEST['md5'] && $_REQUEST['t_status'] == 2 && $_SERVER["REMOTE_ADDR"] == ALLPAY_SERVER && $data['confirm_online']==0) {
            // jesli skroty sa dobre tzn ze transakcja jest prawidlowa

            global $auto_transaction;
            $auto_transaction=true;
            if (in_array("main_keys",$config->plugins)) {
                require_once ("go/_register/include/main_keys.inc.php");
                $main_keys = new MainKeys;
                $main_keys->show();
            }
            require_once ("include/order_register.inc");
            $my_checksum=OrderRegisterChecksum::checksum($_REQUEST['description'],1,$data[0]['amount']);
            $database->sql_update("order_register","order_id=".$_REQUEST['description'],array(
            "confirm_online"=>"1",
            "confirm"=>"1",
            "pay_status"=>"001",
            "checksum_online"=>$my_checksum,
            )
            );

            include_once("$DOCUMENT_ROOT/go/_register/include/send_order.inc.php");




            $result_online=$database->sql_select("confirm_online","order_register","order_id=".$_REQUEST['description']);
            if($result_online == 1) {
                return true;
            } else {
                return false;
            }

        }

        $mdbd->insert("log","order_id,message",array(
        @$_REQUEST['description']=>"text",
        ob_get_contents()=>"text",
        )
        );
        ob_flush();
    } // end func prepareData
} // end class AllpayOnline
?>
