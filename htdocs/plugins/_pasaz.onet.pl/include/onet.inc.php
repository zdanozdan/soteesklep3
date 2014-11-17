<?php
/**
 * Obsluga Pasaz.onet.pl. Rozpoznanie czy uzytkownik wszedl z pasazu Onet
 *
 * \@session string $global_onet informacja, ze uzytkownik wszedl z onetu
 * @author m@sote.pl
 * @version $Id: onet.inc.php,v 2.3 2004/12/20 18:02:02 maroslaw Exp $
* @package    pasaz.onet.pl
 */

if (@$global_secure_test!=true) die ("Bledne wywolanie");
include_once("include/metabase.inc");

class Onet {
    /**
     * Sprawdz czy uzytkwonik wszedl z pasaz.onet.pl
     */
    function check_from_register() {
        global $_REQUEST;
        global $sess;
	global $database;

    
        if ((! empty($_REQUEST['load'])) && ($_REQUEST['load']=="onet")) {
	    $name=$_REQUEST['load'];
	    $partner_id=$database->sql_select("partner_id","partners","name=$name");
            return $partner_id;
        }        
        return false; 
    } // end check_from()
} // end class  Onet

$onet = new Onet;

if ($onet->check_from_register()!=false) {
    $global_partner_id=$onet->check_from_register();    
    $sess->register("global_partner_id",$global_partner_id);
}

?>
