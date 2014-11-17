<?php
/**
* @version    $Id: send.php,v 1.3 2006/03/29 12:10:49 lukasz Exp $
* @package    ask4price
* \@ask4price
*/

$global_database=true;
$global_secure_test=true;
global $_POST;
$DOCUMENT_ROOT=$HTTP_SERVER_VARS['DOCUMENT_ROOT'];
require_once ("../../../include/head.inc");
require_once ("lib/Mail/MyMail.php");

global $mdbd;

$ask4price_list = @$_SESSION['ask4price_list'];

$mail = new MyMail;

$name_company = @$_REQUEST['ask4price_name_company'];  // od kogo
$comment = addslashes(@$_REQUEST['ask4price_comment']);  // uwagi


// parametry maila
$from = @$_REQUEST['ask4price_email'];  // od kogo
$to = $config->order_email;  // do kogo  
$reply = $from;

if(!empty($_SESSION['global_id_user'])) {
    $user_text = " (" . $lang->ask4price_user_logged . " " . $_SESSION['global_id_user'] . ") ";
}
else {
    $user_text = " (" . $lang->ask4price_user_not_logged . ") ";
}

$subject = $lang->ask4price_subject;
$content = "$name_company $user_text" . $lang->ask4price_intro . "\n\n";

reset($ask4price_list);
while (list($key, $val) = each($ask4price_list)) {
    $content .= $val['id'] . ': ' . $val['name'] . " (" . $val['producer'] . ")\n\n";
}

    if(!empty($_REQUEST['ask4price_comment'])) {
        $content .= $lang->ask4price_comment . ":\n";
        $content .= $comment;
    }

// wysylam maila
if(empty($_REQUEST['ask4price_email'])) {
    $theme->theme_file("plugins/_ask4price/ask4price_send_error1.html.php");     // nie podales swojego maila! 
}
else {
    if (!empty($_SESSION['ask4price_list'])) {
        if($mail->send($from,$to,$subject,$content,$reply)){
            reset($ask4price_list);
            $guid = @$_SESSION['global_id_user'];
            if(empty($guid))
                $guid = 0;
            $res = $mdbd->select("MAX(request_id)", "ask4price", "1=1", array($guid => "int", $from => "string"), "", "array");
            $request_id = $res[0]["MAX(request_id)"];
            $request_id = $request_id + 1;
    
            while (list($key, $val) = each($ask4price_list)) {
                $vid = $val['id'];
                $vname = $val['name'];
                $vproducer = $val['producer'];
                $request_id = addslashes($request_id);
                $guid = addslashes($guid);
                $name_company = addslashes($name_company);
                $from = addslashes($from);
                $vid = addslashes($vid);
                $vname = addslashes($vname);
                $vproducer = addslashes($vproducer);
                $comment = addslashes($comment);
                $mdbd->insert("ask4price",
                "request_id,id_users,name_company,email,prod_user_id,name,producer,date_add,date_update,comments",
                "$request_id, $guid, '$name_company', '$from', '$vid', '$vname', '$vproducer', NOW(), NOW(), '$comment'"
                );
            }
            
            $theme->theme_file("plugins/_ask4price/ask4price_send_ok.html.php");  // udalo sie wyslac maila
        }
        else {
            $theme->theme_file("plugins/_ask4price/ask4price_send_error.html.php");      // nie udalo sie wyslac
        }
    }
    else {
        $theme->theme_file("plugins/_ask4price/ask4price_send_error.html.php");      // nie udalo sie wyslac
    }
}


?>
