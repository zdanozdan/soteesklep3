<?php
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("../../../../include/head.inc");
include_once ("include/metabase.inc");
require_once ("include/order_register.inc");
require_once ("config/auto_config/ecard_config.inc.php");

function check_param()
{
    global $_REQUEST;
    $status=0;
    if(!preg_match("/^\d+$/",$_REQUEST['ORDERNUMBER'])) $status=1;
    if(!preg_match("/^[A-Z]+$/",$_REQUEST['COMMTYPE'])) $status=1;
    if(!preg_match("/^[a-z_]+$/",$_REQUEST['PREVIOUSSTATE'])) $status=1;
    if(!preg_match("/^[a-z_]+$/",$_REQUEST['CURRENTSTATE'])) $status=1;
    
    if(!(empty($_REQUEST['APPROVALCODE']) || preg_match("/^[0-9A-F]+$/",$_REQUEST['APPROVALCODE']))) $status=1;
    if(!(empty($_REQUEST['VALIDATIONCODE']) || preg_match("/^[0-9]+$/",$_REQUEST['VALIDATIONCODE']))) $status=1;

    if(!($_REQUEST['WITHCVC'] == 'YES' || $_REQUEST['WITHCVC'] == 'NO')) $status=1;
    return $status;
}


if(preg_match("/^\d+$/",$_REQUEST['MERCHANTNUMBER']) && $_REQUEST['MERCHANTNUMBER'] == $ecard_config->ecardAccount) {
    if(!check_param()) {
        $database->sql_insert("ecard_status",array(
                                                    'MERCHANTNUMBER'=>$_REQUEST['MERCHANTNUMBER'],
                                                    'ORDERNUMBER'=>$_REQUEST['ORDERNUMBER'],
                                                    'COMMTYPE'=>$_REQUEST['COMMTYPE'],
                                                    'PREVIOUSSTATE'=>$_REQUEST['PREVIOUSSTATE'],
                                                    'CURRENTSTATE'=>$_REQUEST['CURRENTSTATE'],
                                                    'PAYMENTTYPE'=>$_REQUEST['PAYMENTTYPE'],
                                                    'EVENTTYPE'=>$_REQUEST['EVENTTYPE'],
                                                    'PAYMENTNUMBER'=>$_REQUEST['PAYMENTNUMBER'],
                                                    'APPROVALCODE'=>$_REQUEST['APPROVALCODE'],
                                                    'VALIDATIONCODE'=>$_REQUEST['VALIDATIONCODE'],
                                                    'BIN'=>$_REQUEST['BIN'],
                                                    'AUTHTIME'=>$_REQUEST['AUTHTIME'],
                                                    'TYPE'=>$_REQUEST['TYPE'],
                                                    'WITHCVC'=>$_REQUEST['WITHCVC'],
                                                    'sess_id'=>$_REQUEST['sess_id'],
        ));
        if(($_REQUEST['CURRENTSTATE'] == 'payment_approved' || $_REQUEST['CURRENTSTATE'] == 'transfer_accepted') && $_REQUEST['PREVIOUSSTATE'] == 'payment_pending') {
            $database->sql_update("order_register","order_id=".$_REQUEST['ORDERNUMBER'],array(
            "confirm_online"=>"1",
            "pay_status"=>"001",
            )
            );
        }
        print "OK";
    } else {
        print "ERROR";
    }
} else {
    print "ERROR";
}
?>