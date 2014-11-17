<?php
/**
 * Sprawdz czy dane logowania Apache sa poprawne
 * 
 * @author  m@sote.pl
 * @version $Id: test_auth.inc.php,v 2.4 2004/12/20 17:59:25 maroslaw Exp $
* @package    admin_include
 */ 

if (empty($__pin)) {
    header ("Location: http://".$_SERVER['HTTP_HOST'].@$config->admin_dir."/go/_auth/index.php");
    exit;
}	    

$login=false;
while (list($md5_user,$user_type)  = each ($config->auth_sign)) {
    if (md5(@$_SERVER['REMOTE_USER'])==$md5_user) {
        $login=true;
    }
} // end foreach

if ($login==false) {
    header ("Location: http://".$_SERVER['HTTP_HOST'].@$config->admin_dir."/go/_auth/index.php");
    exit;
}

?>
