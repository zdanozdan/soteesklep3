<?php
/**
* Menu z dodatkowymi opcjami dot. aktualziacji wersji
*
* @author  m@sote.pl
* @version $id$
* @package    upgrade
*/

require_once ("include/ver2.5/upgrade_order.inc.php");
$upgrade_order =& new UpgradeOrder();

$_upgrade25=$mdbd->select("id","`upgrade`","name='2530'",array(),"LIMIT 1");

if (($upgrade_order->checkDB25()) && (! $_upgrade25)) {
    $buttons =& new Buttons;
    $_order=0;$_user=0;
    if ($mdbd->select("id","order_register","record_version!='30'",array(),"LIMIT 1")>0) {
        $buttons->button($lang->upgrade_25_menu['order'],"upgrade_25_order.php");   
        $_order=1;
    }
    if ($mdbd->select("id","users","record_version!='30'",array(),"LIMIT 1")>0) {
        $buttons->button($lang->upgrade_25_menu['users'],"upgrade_25_user.php");   
        $_user=1;
    }
    if (($_user==0) && ($_order==0)) {
        $mdbd->insert("`upgrade`","name,date_add,description","?,?,?",
        array(
        "1,".'2530'=>"text",
        "2,".date("Y-m-d")=>"text",
        "3,".$lang->upgrade_25_description=>"text"       
        )
        );
    }
 
} 

print "<br />\n";
?>
