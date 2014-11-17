<?php
/**
 * Rozpoznanie czy uzytkownik wszedl ze strony partnera
 *
 * \@session string $global_partner_id informacja, ze uzytkownik wszedl ze strony partnera
 * @author p@sote.pl
 * @version $Id: partners.inc.php,v 1.3 2004/12/20 18:02:01 maroslaw Exp $
* @package    partners
 */

if (@$global_secure_test!=true) die ("Bledne wywolanie");

class Partner {
    
    /**
     * Sprawdz czy uzytkownik wszedl ze strony partnera i zweryfikuj dane 
     */
    function check_partner() {
        global $_REQUEST;
        global $sess;
        global $config;
        if (! eregi("^[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$",$_REQUEST['partner_id'])) {  // czy format partner_id OK
            return false;
        } else $partner_id=$_REQUEST['partner_id'];
        
        if (! eregi("^[0-9A-Za-z]+$",$_REQUEST['code'])) {                                    // czy format code OK
            return false;
        } else $code=$_REQUEST['code'];
        
        // sprawdz czy mamy takiego partnera w bazie
        include_once("include/metabase.inc");
        $database = new my_Database;
        $check_id=$database->sql_select("id","partners","partner_id=$partner_id");
        if (empty($check_id)) {
            return false;
        }
        // sprawdz czy zgadza sie suma kontrolna code
        $my_code=md5("partner_id.$partner_id.$config->salt");  // prawidlowy kod kontrolny
       if ($code!=$my_code) {
            return false;
        }
        
        return $partner_id;
        
    } // end check_partner()
} // end class Partner

$partner = new Partner;

if ($partner->check_partner()!=false) {
	//print "partner";
	$global_partner_id=$partner->check_partner();    
    $sess->register("global_partner_id",$global_partner_id);
}

?>
