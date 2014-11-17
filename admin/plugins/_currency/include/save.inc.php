<?php
/**
* Zapisz kursy walut do pliku konfiguracyjnego na podstawie danych z bazy
*
* @author  m@sote.pl
* @version $Id: save.inc.php,v 2.2 2004/12/20 17:59:32 maroslaw Exp $
* @package    currency
*/

/** Dodanie odwo³ania do ftp */
require_once ("include/ftp.inc.php");
/** obsluga generowania pliku konfiguracyjnego uzytkwonika */
require_once("include/gen_user_config.inc.php");


// generuj plik konfiguracyjny
if (@$_REQUEST['update']==true) {
    $query="SELECT * FROM currency";
    $result=$db->query($query);
    if ($result!=0) {
        $num_rows=$db->numberOfRows($result);
        if ($num_rows>0) {
            
            $__currency=array();$__currency_name=array();
            for ($i=0;$i<$num_rows;$i++) {
                $__currency[$db->fetchResult($result,$i,"id")]=$db->fetchResult($result,$i,"currency_val");
                $__currency_name[$db->fetchResult($result,$i,"id")]=$db->fetchResult($result,$i,"currency_name");
            }
            
            if ($_REQUEST['id']==1) {
                $currency_default=$_REQUEST['item']['currency_name'];
            } else $currency_default=$config->currency;
            $gen_config->gen(array("currency_data"=>$__currency,"currency_name"=>$__currency_name,"currency"=>$currency_default));
        }
    } else die ($db->error());    
}
// end
?>
