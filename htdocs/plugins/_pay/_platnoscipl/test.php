<?php
$global_database=true;
$global_secure_test=true;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
include_once ("$DOCUMENT_ROOT/../include/head.inc");
include_once ("$DOCUMENT_ROOT/../include/metabase.inc");
require_once ("HTTP/Client.php");
include_once ("config/auto_config/platnoscipl_config.inc.php");
include_once ("include/metabase.inc");

        // pobierz status transakcji
        $http =& new HTTP_Client;
        $http->post("https://www.platnosci.pl/paygw/ISO/Payment/get/txt",array(
                                                                    "pos_id"=>'392',
                                                                    "session_id"=>'beae7a9bbf02576a7627757fd2dd282f',
                                                                    "ts"=>'1128955592264',
                                                                    "sig"=>'3a9167121069f1aa457d9aa30fdeb756',
                                                                    )
                   );

        //$result=$http->_responses[0]['body'];
        $result=$http->_responses;
        print "cos";
        print_r($result);



?>