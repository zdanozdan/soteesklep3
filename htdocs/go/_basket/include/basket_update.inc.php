<?php
/**
* Aktualizuj stan koszyka
*
* @param array $num - parametr przekazany z formularza koszyka
* @param array $del - jw.
* @version    $Id: basket_update.inc.php,v 2.4 2004/12/20 18:01:34 maroslaw Exp $
* @package    basket
*/

// nie zezwalaj na bezposrednie wywolanie tego pliku
if ((empty($global_secure_test)) || (! empty($_REQUEST['global_secure_test']))) {
    die ("Niedozwolone wywolanie");
}

// podlicz
if (! empty($_POST['num'])) {
    $num=$_POST['num'];
    
    while (list($id,$quantity) = each ($num)) {        
        $quantity=intval($quantity);
        if ($quantity>0) {           
            $basket->setNum($id,$quantity);
        } else {
            $basket->del($id);
        }
    }        
    $basket->register();
}

// usun wybrany produkt
if (! empty($_POST['del'])) {
    $del=$_POST['del'];
    $id=key($del);
    $basket->del($id);
    $basket->register();
}
?>
